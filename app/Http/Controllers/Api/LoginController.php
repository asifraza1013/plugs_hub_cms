<?php

namespace App\Http\Controllers\Api;

use App\DeviceToken;
use App\Http\Controllers\Controller;
use App\Notifications\SendOtpNotification;
use App\ServiceProvider;
use App\UserApp;
use Carbon\Carbon;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Validator;

class LoginController extends Controller
{
    /**
     * signup for customer
     */
    public function userSignUp(Request $request)
    {
        $rules = [
            'first_name' => 'required|string',
            'last_name' => 'required|string',
            'email' => 'required|email',
            'phone' => 'required|string',
            'password' => 'nullable|string',
            'role' => 'required|in:1,2',
        ];

        $validator = Validator::make($request->all(), $rules);
        $errors = error_msg_serialize($validator->errors());
        if (count($errors) > 0)
        {
            return response()->json(['status' => false, 'status_code' => 1013, 'data' => $errors]);
        }

        $exist = UserApp::where('email', $request->email)->orWhere('phone', $request->phone)->first();
        if($exist){
            return response()->json([
                'status' => false,
                'code' => config('response.5000.code'),
                'message' => config('response.5000.message'),
            ]);
        }
        // $data = [
        //     'first_name' => $request->first_name,
        //     'last_name' => $request->last_name,
        //     'email' => $request->email,
        //     'phone' => $request->phone,
        //     'password' => Hash::make($request->password),
        //     'admin_approved' => ($request->role == 1) ? true : false,
        //     'app_role' => $request->role,
        //     'status' => 3, // unverified by default
        // ];

        // $createUser = UserApp::updateOrCreate([
        //     'email' => $request->email,
        //     'phone' => $request->phone,
        // ],
        // [
        //     'first_name' => $request->first_name,
        //     'last_name' => $request->last_name,
        //     'email' => $request->email,
        //     'phone' => $request->phone,
        //     'password' => Hash::make($request->password),
        //     'admin_approved' => ($request->role == 1) ? true : false,
        //     'app_role' => $request->role,
        //     'status' => 3, // unverified by default
        // ]);

        $createUser= new UserApp;
        $createUser->first_name = $request->first_name;
        $createUser->last_name = $request->last_name;
        $createUser->email = $request->email;
        $createUser->phone = $request->phone;
        $createUser->password = Hash::make($request->password);
        $createUser->admin_approved = ($request->role == 1) ? true : false;
        $createUser->app_role = $request->role;
        $createUser->status = 3; // unverified by default
        $createUser->save();

        if($createUser){
           /**
            * TODO send OTP to user for verification
            */
            return response()->json([
                'status' => true,
                'user' => $createUser,
                'code' => config('response.1004.code'),
                'message' => config('response.1004.message'),
            ]);
        }

        return response()->json([
            'status' => false,
            'code' => config('response.1003.code'),
            'message' => config('response.1003.message'),
        ]);
    }

    /**
     * customer login
     */
    public function customerEmailLogin(Request $request)
    {
        $rules = [
            'email' => 'required|email',
            'password' => 'required|string',
            'device_token' => 'required|string',
        ];

        $validator = Validator::make($request->all(), $rules);
        $errors = error_msg_serialize($validator->errors());
        if (count($errors) > 0)
        {
            return response()->json(['status' => false, 'status_code' => 1013, 'data' => $errors]);
        }

        $customer = UserApp::where('email', $request->email)
        ->first();

        if(is_null($customer)){
            return response()->json([
                'status' => false,
                'code' => config('response.1005.code'),
                'message' => config('response.1005.message'),
            ]);
        }

        if($customer->status == 3){
            return response()->json([
                'status' => false,
                'user' => (object)['id'=> $customer->id, 'first_name' => $customer->first_name, 'last_name' => $customer->last_name],
                'code' => config('response.1006.code'),
                'message' => config('response.1006.message'),
            ]);
        }

        if($customer->status == 2){
            return response()->json([
                'status' => false,
                'code' => config('response.1006.code'),
                'message' => config('response.1006.message'),
            ]);
        }
        if (!Hash::check($request->password, $customer->password)) {
            return response()->json([
                'status' => false,
                'code' => config('response.401.code'),
                'message' => config('response.401.message'),
                'error' => 'Unauthenticated.'
            ], 401);
        }
        $tokenResult = $customer->createToken('Personal Access Token');
        $token = $tokenResult->token;
        if ($request->remember_me)
            $token->expires_at = Carbon::now()->addWeeks(1);
        $token->save();

        // store deive token
        $device_token = DeviceToken::updateOrCreate(
            [
                'user_apps_id' => $customer->id,
                'device_token' => $request->device_token,
            ],
            [
                'user_apps_id' => $customer->id,
                'device_token' => $request->device_token
            ]
        );

        $exist = ServiceProvider::where('user_apps_id', $customer->id)->first();

        $data = [
            'id' => $customer->id,
            'name' => $customer->first_name.' '.$customer->last_name,
            'email' => $customer->email,
            'image' => (is_null($customer->image)) ? null : asset('images/user/'.$customer->image),
            'enable_notifications' => $customer->enable_notifications,
            'role' => config('constants.appRole.'.$customer->app_rol),
            'access_token' => $tokenResult->accessToken,
            'token_type' => 'Bearer',
            'add_detail' => ($exist) ? false : true,
            'expires_at' => Carbon::parse(
                $tokenResult->token->expires_at
            )->toDateTimeString()
        ];
        return response()->json([
            'status' => true,
            'user' => $data,
            'code' => config('response.1002.code'),
            'message' => config('response.1002.message'),
        ]);
    }

    /**
     * update car detail
     */
    public function updateCarDetail(Request $request)
    {
        $rules = [
            'car_brand' => 'required|string',
            'car_modal' => 'required|string',
        ];

        $validator = Validator::make($request->all(), $rules);
        $errors = error_msg_serialize($validator->errors());
        if (count($errors) > 0)
        {
            return response()->json(['status' => false, 'status_code' => 1013, 'data' => $errors]);
        }

        $user = $request->user();
        $user->car_brand = $request->car_brand;
        $user->car_modal = $request->car_modal;
        $user->save();
        return response()->json([
            'status' => true,
            'code' => config('response.1007.code'),
            'message' => config('response.1007.message'),
        ]);
    }

    /**
     * update profile image
     */
    public function updateProfileImage(Request $request)
    {
        $rules = [
            'image' => 'required|string',
        ];

        $validator = Validator::make($request->all(), $rules);
        $errors = error_msg_serialize($validator->errors());
        if (count($errors) > 0)
        {
            return response()->json(['status' => false, 'status_code' => 1013, 'data' => $errors]);
        }

        $user = $request->user();

        $image = $request->image;  // your base64 encoded
        // $image = str_replace('data:image/png;base64,', '', $image);
        $image = str_replace(' ', '+', $image);
        $imageName = str_random(10).'.'.'png';
        if($user->image){
            File::delete(public_path('users/'.$user->image));
        }
        File::put(public_path('users/'.$imageName), base64_decode($image));
        $user->image = $imageName;
        $user->save();
        return response()->json([
            'status' => true,
            'code' => config('response.1008.code'),
            'message' => config('response.1008.message'),
        ]);
    }

    /**
     * send OTP
     */
    public function sendOtp(Request $request)
    {
        $rules = [
            'user_id' => 'required|numeric',
        ];

        $validator = Validator::make($request->all(), $rules);
        $errors = error_msg_serialize($validator->errors());
        if (count($errors) > 0)
        {
            return response()->json(['status' => false, 'status_code' => 1013, 'data' => $errors]);
        }

       $otp = rand(0000, 9999);
       Log::info("OTP user ".$request->user_id. ' OTP '.$otp);

       $userapp = UserApp::where('id', $request->user_id)->first();

       $userapp->otp = $otp;
       $userapp->update();

       Log::info("user detial ".json_encode($userapp));
       // send email notification
       $userapp->notify(new SendOtpNotification($userapp, $otp));

        return response()->json([
            'status' => true,
            'code' => config('response.1018.code'),
            'message' => config('response.1018.message'),
        ]);
    }

    /**
     * verify OTP
     */
    public function verifyOtp(Request $request)
    {
        Log::info("verifyOtp req".json_encode($request->all()));
        $rules = [
            'user_id' => 'required|numeric',
            'otp' => 'required|numeric',
        ];

        $validator = Validator::make($request->all(), $rules);
        $errors = error_msg_serialize($validator->errors());
        if (count($errors) > 0)
        {
            return response()->json(['status' => false, 'status_code' => 1013, 'data' => $errors]);
        }

        $userapp = UserApp::where('id', $request->user_id)->first();
        Log::info("userapp OTP ".json_encode($userapp));
        if($userapp->otp == null || $request->otp != $userapp->otp){
            return response()->json([
                'status' => false,
                'code' => config('response.1019.code'),
                'message' => config('response.1019.message'),
            ]);
        }

        $userapp->otp = null;
        $userapp->status = 1;
        $userapp->update();

        return response()->json([
            'status' => true,
            'code' => config('response.1020.code'),
            'message' => config('response.1020.message'),
        ]);
    }

    /**
     * get user profile
     */
    public function userProfile(Request $request)
    {
        $user = $request->user();
        if($user->image){
            $user->image = asset('uploads/'.$user->image);
        }

        return response()->json([
            'status' => true,
            'profile' => $user,
            'code' => config('response.1029.code'),
            'message' => config('response.1029.message'),
        ]);
    }
}
