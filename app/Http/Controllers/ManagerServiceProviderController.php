<?php

namespace App\Http\Controllers;

use App\Http\Resources\VendorCollection;
use App\ServiceProvider;
use App\UserApp;
use Illuminate\Http\Request;

class ManagerServiceProviderController extends Controller
{
    // function __construct()
    // {
    //      $this->middleware('permission:vendor-list|vendor-create|vendor-edit|vendor-delete', ['only' => ['vendorList','store']]);
    //      $this->middleware('permission:vendor-create', ['only' => ['create','store']]);
    //      $this->middleware('permission:vendor-detail', ['only' => ['vendorDetail']]);
    //      $this->middleware('permission:vendor-edit', ['only' => ['edit','update']]);
    //      $this->middleware('permission:vendor-delete', ['only' => ['destroy']]);
    // }

    /**
     * List of service providors
     */
    public function vendorList(Request $request)
    {
        $title = 'Service Provider List';
        $vendors = ServiceProvider::with(['user'])->orderBy('id','ASC')->paginate(5);
        return view('vendors.index', compact([
            'title',
            'vendors'
        ]))->with('i', ($request->input('page', 1) - 1) * 5);
    }

    /**
     * show vendor detail
     */
    public function vendorDetail($id)
    {
        $title = 'Vendor Detail';
        $vendor = ServiceProvider::with(['user', 'chargerInfo'])->first();
        return view('vendors.show', compact(['title', 'vendor']));
    }

    public function approve($id)
    {
        $customer = UserApp::where('id', $id)->first();
        if(is_null($customer)){
            return redirect()->back()->with('error', 'User Not found. Please try with correct data');
        }

        if($customer->admin_approved){
            $customer->admin_approved = false;
        }else{
            $customer->admin_approved = true;
        }
        $customer->save();
        return redirect()->back()->with('success','Vendor account approved successfully.');
    }
}
