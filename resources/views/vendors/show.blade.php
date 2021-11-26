@extends('layouts.app', ['title' => __('Vendor Management')])

@section('content')
    <div class="header bg-gradient-primary pb-8 pt-5 pt-md-8">
    </div>

<div class="container-fluid mt--7">
    <div class="row">
        <div class="col">
            <div class="card shadow">
                <div class="card-header border-0">
                    <div class="row align-items-center">
                        <div class="col-12 text-center">
                            <h2 class="mb-0">{{ __('Vendor Detail') }}</h2>
                            <hr>
                        </div>
                        @include('msg.flash_message')
                        <div class="h-25"></div>
                        <div class="col-6">
                            <h4 class="mb-0">{{ __('Vendor Detail') }}
                            </h4>
                        </div>
                        <div class="col-6 text-right">
                            @if($vendor->user->image)
                                <span>
                                    <img src="{{ asset('uploads/'.$vendor->user->image) }}" alt="" class="" style="border-radius: 50%; width: 15%">
                                </span>
                            @endif
                        </div>
                        <div class="col-12"><hr></div>
                        <div class="h-25"></div>
                        <div class="col-6 col-lg-4">
                            <div class="form-group">
                                <label for="">Vendor Name</label>
                                <p>{{ $vendor->user->first_name }}  {{ $vendor->user->last_name }}</p>
                            </div>
                        </div>
                        <div class="col-6 col-lg-4">
                            <div class="form-group">
                                <label for="">Vendor Id</label>
                                <p>{{ $vendor->vendor_id }}</p>
                            </div>
                        </div>
                        <div class="col-6 col-lg-4">
                            <div class="form-group">
                                <label for="">Email</label>
                                <p>{{ $vendor->user->email }}</p>
                            </div>
                        </div>
                        <div class="col-12"><hr></div>
                        <div class="h-25"></div>
                        <div class="col-6">
                            <h4 class="mb-0">{{ __('Vendor Address Info') }} ({{ $vendor->country }})
                            </h4>
                        </div>
                        <div class="col-6 text-right">
                            <span>
                                <img src="{{ asset('uploads/'.$vendor->parking_img) }}" alt="" class="" style="border-radius: 50%; width: 15%">
                            </span>
                        </div>
                        <div class="col-12"><hr></div>
                        <div class="col-lg-5 col-6">
                            <div class="form-group">
                                <label for="">Address</label>
                                <p>{{ $vendor->address }}</p>
                            </div>
                        </div>
                        <div class="col-lg-4 col-6">
                            <div class="form-group">
                                <label for="">Street</label>
                                <p>{{ $vendor->street }}</p>
                            </div>
                        </div>
                        <div class="col-lg-3 col-6">
                            <div class="form-group">
                                <label for="">Postcode</label>
                                <p>{{ $vendor->post_code }}</p>
                            </div>
                        </div>
                        <div class="col-12"><hr></div>
                        <div class="h-25"></div>
                        <div class="col-6">
                            <h4 class="mb-0">{{ __('Charger Detail') }} (Total :{{ count($vendor->chargerInfo) }})
                            </h4>
                        </div>
                        <div class="col-12"><hr></div>
                        <table class="table table-responsive table-strapped">
                            <thead>
                                <th>{{ __('No.') }}</th>
                                <th>{{ __('Charger Box') }}</th>
                                <th>{{ __('Charger Plug Type') }}</th>
                                <th>{{ __('Charger Level') }}</th>
                                <th>{{ __('Charger Capacity') }}</th>
                                <th>{{ __('Charger Voltage') }}</th>
                                <th>{{ __('Charger Image') }}</th>
                            </thead>
                            <tbody>
                                @foreach ($vendor->chargerInfo as $key=>$item)
                                    <tr>
                                        <td>{{ $key +1 }}</td>
                                        <td>{{ $item->charger_box }}</td>
                                        <td>{{ $item->charger_plug_type }}</td>
                                        <td>{{ $item->charger_level }}</td>
                                        <td>{{ config('constants.charger_capacity.'.$item->charger_capacity) }}</td>
                                        <td>{{ config('constants.charger_voltage.'.$item->charger_voltage) }}</td>
                                        <td><img src="{{ asset('uploads/'.$item->charger_img) }}" class="w-25" alt=""></td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>

                        <div class="col-12"><hr></div>
                        <h4 class="mb-0">{{ __('Images') }}</h4>
                        <div class="col-12"><hr></div>
                        <div class="h-25"></div>
                        <div class="col-6">
                            <div class="form-group">
                                <label for="">Elecricity Bill</label>
                                <img src="{{ asset('uploads/'.$vendor->bill_img) }}" alt="">
                            </div>
                        </div>
                        <div class="col-6">
                            <div class="form-group">
                                <label for="">Parking Area</label>
                                <img src="{{ asset('uploads/'.$vendor->parking_img) }}" alt="">
                            </div>
                        </div>
                        @if($vendor->id_type == 'NID')
                        <div class="col-6">
                            <div class="form-group">
                                <label for="">Front Image</label>
                                <img src="{{ asset('uploads/'.$vendor->id_img_1) }}" alt="">
                            </div>
                        </div>
                        <div class="col-6">
                            <div class="form-group">
                                <label for="">Front Image</label>
                                <img src="{{ asset('uploads/'.$vendor->id_img_2) }}" alt="">
                            </div>
                        </div>
                        @else
                        <div class="col-6">
                            <div class="form-group">
                                <label for="">Passport Image</label>
                                <img src="{{ asset('uploads/'.$vendor->id_img_1) }}" alt="">
                            </div>
                        </div>
                        @endif
                        <div class="col-3 offset-4">
                            <a href="{{ route('admin.vendor.approve', $vendor->user_apps_id) }}" class="btn {{ ($vendor->user->admin_approved) ? "btn-danger" : "btn-primary" }} btn-block btn-lg">{{ ($vendor->user->admin_approved) ? "Barred" : "Approve" }}</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
