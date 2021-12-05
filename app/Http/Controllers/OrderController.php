<?php

namespace App\Http\Controllers;

use App\Order;
use Carbon\Carbon;
use Illuminate\Http\Request;

class OrderController extends Controller
{

    /**
    * get order list
    */
    public function index()
    {
        $title = 'Order List';
        $orders = Order::with(['customer', 'vendor', 'plugType'])->get();
        return view('');
    }

    public function liveapi()
    {
        //Today only
        $orders = Order::where('created_at', '>=', Carbon::today())->orderBy('created_at', 'desc');
        $orders = $orders->with(['status', 'customer'])->get()->toArray();

        $newOrders = array();
        $acceptedOrders = array();
        $onwayOrders = array();
        $pickedOrders = array();
        $doneOrders = array();

        $items = [];
        foreach ($orders as $key => $order) {
            array_push($items, array(
                'id' => $order['id'],
                'last_status' => $order['status'][count($order['status']) - 1]['name'],
                'last_status_id' => $order['status'][count($order['status']) - 1]['pivot']['status_id'],
                'last_status_alias' => $order['status'][count($order['status']) - 1]['alias'],
                'time' => $order['created_at'],
                'client' => $order['customer']['first_name'],
                'client_email' => $order['customer']['email'],
                'link' => "/orders/" . $order['id'],
                'price' => $order['amount']
            ));
        }

        //----- ADMIN ------
        if (auth()->user()->hasRole('Admin')) {
            foreach ($items as $key => $item) {
                if ($item['last_status_alias'] == 'just_created') {
                    $item['pulse'] = 'blob green';
                    array_push($newOrders, $item);
                } else if ($item['last_status_alias'] == 'accepted_by_vendor') {
                    $item['pulse'] = 'blob green';
                    array_push($acceptedOrders, $item);
                } else if ($item['last_status_alias'] == 'arrive_confirm' || $item['last_status_alias'] == 'start_charging') {
                    $item['pulse'] = 'blob orangestatic';
                    if ($item['last_status_alias'] == 3) {
                        $item['pulse'] = 'blob orange';
                    }
                    array_push($onwayOrders, $item);
                } else if ($item['last_status_alias'] == 5) {
                    $item['pulse'] = 'blob orangestatic';
                    if ($item['last_status_alias'] == 3) {
                        $item['pulse'] = 'blob orange';
                    }
                    array_push($pickedOrders, $item);
                } else if ($item['last_status_alias']  == 'cancelled_by_vendor' ||  $item['last_status_alias']  == 'cancelled_by_customer' || $item['last_status_alias']  == 'charging_complete') {
                    $item['pulse'] = 'blob greenstatic';
                    if ($item['last_status_alias']  == 'cancelled_by_vendor' ||  $item['last_status_alias']  == 'cancelled_by_customer') {
                        $item['pulse'] = 'blob redstatic';
                    }
                    array_push($doneOrders, $item);
                }
            }
        }
        $toRespond = array(
            'neworders' => $newOrders,
            // 'accepted'=>$acceptedOrders,
            'onway' => $acceptedOrders,
            'picked' => $onwayOrders,
            'done' => $doneOrders
        );

        return response()->json($toRespond);
    }

    public function live()
    {
        return view('orders.live');
    }
}
