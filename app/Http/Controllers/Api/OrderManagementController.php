<?php

namespace App\Http\Controllers\Api;

use App\ChargerInfo;
use Illuminate\Support\Facades\Validator;
use App\Http\Controllers\Controller;
use App\Order;
use App\OrderHasStatus;
use App\Setting;
use App\Status;
use SimpleSoftwareIO\QrCode\Facades\QrCode;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class OrderManagementController extends Controller
{
    /**
     * Send request to book charger.
     */
    public function requestChargerBooking(Request $request)
    {
        $rules = [
            'plug_type' => 'required|string',
            'vendor_id' => 'required|string',
            'charging_duration' => 'required|string',
        ];

        $validator = Validator::make($request->all(), $rules);
        $errors = error_msg_serialize($validator->errors());
        if (count($errors) > 0)
        {
            return response()->json(['status' => false, 'status_code' => 1013, 'data' => $errors]);
        }

        $customer = $request->user();
        $adminCommission = Setting::first();
        // add data to create order

        // get charger power
        $power = ChargerInfo::where('user_apps_id', $request->vendor_id)->where('charger_plug_type', $request->plug_type)->first();

        $total = (int)config('constants.per_mint_cost') *  (int)$request->charging_duration;

        $order = new Order;
        $order->customer_id = (int)$customer->id;
        $order->provider_id = (int)$request->vendor_id;
        $order->charging_time = (int)$request->charging_duration;
        $order->power = (is_null($power)) ? config('constants.charger_capacity.1') :config('constants.charger_capacity.'.$power->charger_capacity);
        $order->plug_type = (int)$request->plug_type;
        $order->per_min_cost = (int)config('constants.per_mint_cost');
        $order->amount = $total;
        $order->commission = calculateAdminCommission($total, $adminCommission->admin_commission);
        $order->payment_method = config('constants.payment_method');
        $order->created_at = date('Y-m-d H:s:i');
        $order->updated_at = date('Y-m-d H:s:i');
        $order->save();

        Log::info("New Order Created by ".$customer->name. ' orderDetail '.json_encode($order));

        $alias = 'just_created';
        // create status for this order
        $status = createOrderHaseStatus($alias, $order);

        // send notification to vendor
        sendNotification($alias, $order, true);

        return response()->json([
            'status' => true,
            'code' => config('response.1022.code'),
            'message' => config('response.1022.message'),
        ]);
    }

    /**
     * order list
     */
    public function orderList(Request $request)
    {
        $user = $request->user();

        $orders = Order::with([
            'vendorAddress',
            'customer:id,first_name,last_name,email,phone',
            'vendor:id,first_name,last_name,email,phone',
            'plugType:id,name',
        ]);
        if($request->has('pending') && $request->pending){
            $orders = $orders->where('request_status', 1);
        }
        if($request->has('approved') && $request->approved){
            $orders = $orders->where('request_status', 2);
        }
        if($request->has('cancelled') && $request->cancelled){
            $orders = $orders->where('request_status', 3);
        }
        if($request->has('completed') && $request->completed){
            $orders = $orders->where('request_status', 4);
        }
        if($user->app_role == 1){
            $orders = $orders->where('customer_id', $user->id);
        }else{
            $orders = $orders->where('provider_id', $user->id);
        }
        $orders = $orders->get();
        if(count($orders)){
            return response()->json([
                'status' => true,
                'list' => $orders,
                'code' => config('response.1023.code'),
                'message' => config('response.1023.message'),
            ]);
        }
        return response()->json([
            'status' => false,
            'code' => config('response.1024.code'),
            'message' => config('response.1024.message'),
        ]);
    }

    /**
     * approve charger request
     */
    public function approveChargerReq(Request $request)
    {
        $rules = [
            'order_id' => 'required|string',
        ];

        $validator = Validator::make($request->all(), $rules);
        $errors = error_msg_serialize($validator->errors());
        if (count($errors) > 0)
        {
            return response()->json(['status' => false, 'status_code' => 1013, 'data' => $errors]);
        }

        $order = Order::where('id', $request->order_id)->where('request_status', 1)->first();
        if(is_null($order)){
            return response()->json([
                'status' => false,
                'code' => config('response.1025.code'),
                'message' => config('response.1025.message'),
            ]);
        }

        $alias = 'accepted_by_vendor';
        $order->request_status = 2;
        $order->update();

        // add status for this order
       $status = createOrderHaseStatus('accepted_by_vendor', $order);
        Log::info("status ". json_encode($status));
        // send approvel notification to customer
        sendNotification($alias, $order);

        return response()->json([
            'status' => true,
            'order' => $order,
            'code' => config('response.1026.code'),
            'message' => config('response.1026.message'),
        ]);
    }

    /**
     * cancel charger request
     */
    public function cancelChargerReq(Request $request)
    {
        $rules = [
            'order_id' => 'required|string',
        ];

        $validator = Validator::make($request->all(), $rules);
        $errors = error_msg_serialize($validator->errors());
        if (count($errors) > 0)
        {
            return response()->json(['status' => false, 'status_code' => 1013, 'data' => $errors]);
        }

        $order = Order::where('id', $request->order_id)->where('request_status', 1)->first();
        if(is_null($order)){
            return response()->json([
                'status' => false,
                'code' => config('response.1025.code'),
                'message' => config('response.1025.message'),
            ]);
        }

        $order->request_status = 3;
        $order->update();

        $user = $request->user();

        if($user->app_role == 2){
            $alias = 'cancelled_by_vendor';
            // add status for this order
           $status = createOrderHaseStatus('cancelled_by_vendor', $order);
            // send cancel order notification to customer
            sendNotification($alias, $order);
        }else{
            $alias = 'cancelled_by_customer';
            // add status for this order
            $status = createOrderHaseStatus('cancelled_by_customer', $order);
            // send cancel order notification to customer
            sendNotification($alias, $order, true);
        }

        return response()->json([
            'status' => true,
            'order' => $order,
            'code' => config('response.1027.code'),
            'message' => config('response.1027.message'),
        ]);
    }

    /**
     * get order detail
     */
    public function orderDetail(Request $request)
    {
        $rules = [
            'order_id' => 'required|string',
        ];

        $validator = Validator::make($request->all(), $rules);
        $errors = error_msg_serialize($validator->errors());
        if (count($errors) > 0)
        {
            return response()->json(['status' => false, 'status_code' => 1013, 'data' => $errors]);
        }

        $order = Order::with([
            'vendorAddress',
            'customer:id,first_name,last_name,email,phone',
            'vendor:id,first_name,last_name,email,phone',
            'plugType:id,name',
        ])->where('id', $request->order_id)->first();

        if(is_null($order)){
            return response()->json([
                'status' => false,
                'code' => config('response.1027.code'),
                'message' => config('response.1027.message'),
            ]);
        }
        if(!is_null($order->vendorAddress)){
            $order->vendorAddress->parking_img = asset('uploads/'.$order->vendorAddress->parking_img);
        }
        return response()->json([
            'status' => true,
            'detail' => $order,
            'code' => config('response.1028.code'),
            'message' => config('response.1028.message'),
        ]);
    }

    /**
     * update arrive confirm
     */
    public function arrivedConfirmed(Request $request)
    {
        $rules = [
            'order_id' => 'required|numeric',
        ];

        $validator = Validator::make($request->all(), $rules);
        $errors = error_msg_serialize($validator->errors());
        if (count($errors) > 0)
        {
            return response()->json(['status' => false, 'status_code' => 1013, 'data' => $errors]);
        }

        $order = Order::where('id', $request->order_id)->first();
        createOrderHaseStatus('arrive_confirm', $order);
        return response([
            'status' => true,
            'code' => config('response.1031.code'),
            'message' => config('response.1031.message'),
        ]);
    }

    /**
     * update order status. charging started
     */
    public function startCharging(Request $request)
    {
        $rules = [
            'order_id' => 'required|numeric',
        ];

        $validator = Validator::make($request->all(), $rules);
        $errors = error_msg_serialize($validator->errors());
        if (count($errors) > 0)
        {
            return response()->json(['status' => false, 'status_code' => 1013, 'data' => $errors]);
        }

        $order = Order::where('id', $request->order_id)->first();
        createOrderHaseStatus('start_charging', $order);
        return response([
            'status' => true,
            'code' => config('response.1031.code'),
            'message' => config('response.1031.message'),
        ]);
    }

    /**
     * create QR code for order verification
     */
    public function generateQrCode(Request $request)
    {
        $rules = [
            'order_id' => 'required|string',
        ];

        $validator = Validator::make($request->all(), $rules);
        $errors = error_msg_serialize($validator->errors());
        if (count($errors) > 0)
        {
            return response()->json(['status' => false, 'status_code' => 1013, 'data' => $errors]);
        }
        \QrCode::size(500)
            ->format('png')
            ->generate($request->order_id, public_path('uploads/qr_code_'.$request->order_id.'.png'));
        return response()->json([
            'status' => true,
            'qr_code' => asset('uploads/qrcode.png'),
            'message' => config('response.1030.message'),
        ]);
    }

    /**
     * initiate payment
     */
    public function initiateCustomerPayment(Request $request)
    {
        $rules = [
            'order_id' => 'required|string',
        ];

        $validator = Validator::make($request->all(), $rules);
        $errors = error_msg_serialize($validator->errors());
        if (count($errors) > 0)
        {
            return response()->json(['status' => false, 'status_code' => 1013, 'data' => $errors]);
        }

        // find order
        $order = Order::where('id', $request->order_id)
        ->where('request_status', 2)
        ->first();
        if(is_null($order)){
            return response()->json([
                'status' => false,
                'code' => config('response.1033.code'),
                'message' => config('response.1033.message'),
            ]);
        }

        Log::info('CreateIntentFor '.json_encode($order));

        try {
            \Stripe\Stripe::setApiKey(env('STRIPE_SECRET'));
            $stripeIntent =  \Stripe\PaymentIntent::create([
                'amount' => (integer) $order->amount,
                'currency' => config('constants.currency'),
                'payment_method_types' => ['card'],
                ]);

                Log::info('STRIPERESPONSE - '.json_encode($stripeIntent));

                $order->payment_status = config('constants.payment_status.Pending');
                $order->stripe_token = $stripeIntent->id;
                $order->update();

                return response()->json([
                    'status' => true,
                    'data' => $stripeIntent,
                    'code' => config('response.1032.code'),
                    'message' => config('response.1032.message'),
                ]);
        } catch (\Exception $e) {
            return response()->json([
                'status' => false,
                'code' => 500,
                'message' => $e->getMessage(),
            ]);
        }
    }

    /**
     * update payment status
     */
    public function updateCustomerPayment(Request $request)
    {
        $rules = [
            'order_id' => 'required|string',
            'status' => 'required|in:0,1',
        ];

        $validator = Validator::make($request->all(), $rules);
        $errors = error_msg_serialize($validator->errors());
        if (count($errors) > 0)
        {
            return response()->json(['status' => false, 'status_code' => 1013, 'data' => $errors]);
        }

        $order = Order::where('id', $request->order_id)
        ->where('request_status', 2)
        ->where('stripe_token', '!=', null)
        ->where('payment_status', config('constants.payment_status.Pending'))
        ->first();

        if(is_null($order)){
            return response()->json([
                'status' => false,
                'code' => config('response.1033.code'),
                'message' => config('response.1033.message'),
            ]);
        }

        // update payment status
        if($request->status == 1){
            // verify user payment status
            try {
                $stripe = new \Stripe\StripeClient(
                    env('STRIPE_SECRET')
                  );
                  $stripe->paymentIntents->capture(
                    (string)$order->stripe_token,
                    []
                  );
            } catch (\Exception $e) {
                return response()->json([
                    'status' => false,
                    'code' => 500,
                    'message' => $e->getMessage(),
                ]);
            }

            if(is_null($stripe)){
                return response()->json([
                    'status' => false,
                    'code' => config('response.1033.code'),
                    'message' => config('response.1033.message'),
                ]);
            }
            if($order->amount != $stripe->amount_received){
                return response()->json([
                    'status' => false,
                    'code' => config('response.1035.code'),
                    'message' => config('response.1035.message'),
                ]);
            }else{
                $order->payment_status = config('constants.payment_status.Paid');
            }
        }else{
            $order->payment_status = config('constants.payment_status.Cancelled');
        }
        $order->update();
        return response()->json([
            'status' => true,
            'code' => config('response.1034.code'),
            'message' => config('response.1034.message'),
        ]);
    }
}
