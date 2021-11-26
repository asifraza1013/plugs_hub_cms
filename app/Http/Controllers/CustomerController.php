<?php

namespace App\Http\Controllers;

use App\UserApp;
use Illuminate\Http\Request;

class CustomerController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

    // function __construct()
    // {
    //      $this->middleware('permission:cusotmer-list|cusotmer-create|cusotmer-edit|cusotmer-delete', ['only' => ['index','store']]);
    //      $this->middleware('permission:cusotmer-create', ['only' => ['create','store']]);
    //      $this->middleware('permission:cusotmer-edit', ['only' => ['edit','update']]);
    //      $this->middleware('permission:cusotmer-delete', ['only' => ['destroy']]);
    // }

    public function index(Request $request)
    {
        $cutomerList = UserApp::orderBy('id','ASC')->paginate(5);
        return view('customers.index', compact([
            'cutomerList'
        ]))->with('i', ($request->input('page', 1) - 1) * 5);
    }

    public function destroy($id)
    {
        $customer = UserApp::where('id', $id)->first();
        if(is_null($customer)){
            return redirect()->back()->with('error', 'User Not found. Please try with correct data');
        }

        if($customer->status == 3){
            return redirect()->back()->with('error', 'Unverified user can\'t be change');
        }
        if($customer->status == 1){
            $customer->status = 2;
        }else{
            $customer->status = 1;
        }
        $customer->save();
        return redirect()->back()->with('success','User update successfully');
    }
}
