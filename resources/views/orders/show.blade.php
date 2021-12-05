@extends('layouts.app', ['title' => __('Orders')])

@section('content')
    <div class="header bg-gradient-primary pb-8 pt-5 pt-md-8">
    </div>
    <div class="container-fluid mt--7">
        <div class="row">
            <div class="col-xl-7 ">
                <br/>
                <div class="card bg-secondary shadow">
                    <div class="card-header bg-white border-0">
                        <div class="row align-items-center">
                            <div class="col-8">
                                <h3 class="mb-0">{{ "#".$order->id." - ".$order->created_at->format('d M Y H:i') }}</h3>
                            </div>
                            <div class="col-4 text-right">
                                <a href="{{ url()->previous() }}" class="btn btn-sm btn-primary">{{ __('Back') }}</a>
                            </div>
                        </div>
                    </div>
                    <div class="card-body">
                       {{-- <h6 class="heading-small text-muted mb-4">{{ __('Restaurant information') }}</h6> --}}
                        @if (session('status'))
                            <div class="alert alert-success alert-dismissible fade show" role="alert">
                                {{ session('status') }}
                                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                        @endif
                        <hr class="my-4" />
                        <div class="row">
                            <div class="col-lg-4">
                                <h4 class="mb-2 text-red">Distance: {{ $order->distance }} Miles</h4>
                            </div>
                            <div class="col-lg-8 text-right">
                                <h4 class="mb-2 text-red">Delivery Time: {{ $order->estimated_time }}(approximately)</h4>
                            </div>
                        </div>
                        <hr class="my-4" />
                        @if(is_null($order->restorant_id))
                        <h6 class="heading-small text-muted mb-4">{{ __('Client Information') }}</h6>
                        <div class="pl-lg-4">
                            <div class="row">
                                <div class="col-lg-6">
                                    <h3>{{ $order->client->name }}</h3>
                                </div>
                                <div class="col-lg-6 text-right">
                                    <h4 class="text-red">Client Contact No: {{ $order->cdetail->business_mobile }}</h4>
                                </div>
                            </div>
                            <h4>{{ $order->client->email }}</h4>
                            <h4>{{ $order->address?$order->address->address:"" }}</h4>

                            @if(!empty($order->address->apartment))
                                <h4>{{ __("Apartment number") }}: {{ $order->address->apartment }}</h4>
                            @endif
                            @if(!empty($order->address->entry))
                                <h4>{{ __("Entry number") }}: {{ $order->address->entry }}</h4>
                            @endif
                            @if(!empty($order->address->floor))
                                <h4>{{ __("Floor") }}: {{ $order->address->floor }}</h4>
                            @endif
                            @if(!empty($order->address->intercom))
                                <h4>{{ __("Intercom") }}: {{ $order->address->intercom }}</h4>
                            @endif
                            @if(!empty($order->client->phone))
                            <br/>
                            <h4>{{ __('Contact')}}: {{ $order->client->phone }}</h4>
                            @endif
                        </div>
                        <hr class="my-4" />
                        <div class="row text-center">
                            <div class="col-lg-12">
                                <h4 class="mb-2 text-red text-center">Service Type: {{ $order->cdetail->service_type }}</h4>
                            </div>
                        </div>
                        @else
                        <h6 class="heading-small text-muted mb-4">{{ __('Restaurant Information') }}</h6>
                        <div class="pl-lg-4">
                            <div class="row">
                                <div class="col-lg-6">
                                    <h3>{{ $order->restorant->name }}</h3>
                                </div>
                                <div class="col-lg-6 text-right">
                                    <h4 class="text-red">Restaurant Contact No: {{ $order->restorant->phone }}</h4>
                                </div>
                            </div>
                            <h4>{{ $order->restorant->user->email }}</h4>
                            <h4>{{ $order->address?$order->address->address:"" }}</h4>

                            @if(!empty($order->address->apartment))
                                <h4>{{ __("Apartment number") }}: {{ $order->address->apartment }}</h4>
                            @endif
                            @if(!empty($order->address->entry))
                                <h4>{{ __("Entry number") }}: {{ $order->address->entry }}</h4>
                            @endif
                            @if(!empty($order->address->floor))
                                <h4>{{ __("Floor") }}: {{ $order->address->floor }}</h4>
                            @endif
                            @if(!empty($order->address->intercom))
                                <h4>{{ __("Intercom") }}: {{ $order->address->intercom }}</h4>
                            @endif
                        </div>
                        <hr class="my-4" />
                        <div class="row text-center">
                            <div class="col-lg-12">
                                <h4 class="mb-2 text-red text-center">Category: {{ $order->restorant->categories[0]->name }}</h4>
                            </div>
                        </div>
                        @endif
                        <h6 class="heading-small text-muted mb-4">{{ __('Order') }}</h6>
                        @if(is_null($order->restorant_id))
                              <div class="row">
                                  <div class="col-lg-7">
                                      <label for="">From:</label>
                                      <h4 class="pl-lg-4">{{ $order->address->address }}</h4>
                                  </div>
                                  <div class="col-lg-5">
                                      <label for="">POSTCODE:</label>
                                      <h4 class="pl-lg-4"><span class="text-red text-right"></span>{{ $order->address->postcode }}</h4>
                                  </div>
                              </div>
                              <div class="row mt-lg-3">
                                  <div class="col-lg-7">
                                      <label for="">Delivery To: </label>
                                      {{-- <h4><span class="text-red"></span>{{ $order->address->address }}</h4> --}}
                                      <ul id="order-items">
                                        @foreach($order->items as $item)
                                            <li><h4>{{ $item->address }}</h4></li>
                                        @endforeach
                                    </ul>
                                  </div>
                                  <div class="col-lg-5">
                                      <label for="">POSTCODE: </label>
                                      <ul id="order-items">
                                        @foreach($order->items as $item)
                                            <li><h4>{{ $item->postcode }}</h4></li>
                                        @endforeach
                                    </ul>
                                  </div>
                              </div>
                              @else
                              <div class="row">
                                <div class="col-lg-7">
                                    <label for="">Picked From:</label>
                                    <h4 class="pl-lg-4">{{ $order->restorant->address }}</h4>
                                </div>
                                {{-- <div class="col-lg-5">
                                    <label for="">Pickedup POSTCODE:</label>
                                    <h4 class="pl-lg-4"><span class="text-red text-right"></span>{{ $order->address->postcode }}</h4>
                                </div> --}}
                            </div>
                            <div class="row mt-lg-3">
                                <div class="col-lg-7">
                                    <label for="">Delivery To: </label>
                                    <h4><span class="text-red"></span>{{ $order->address->address }}</h4>
                                </div>
                                <div class="col-lg-5">
                                    <label for="">Delivery POSTCODE: </label>
                                    <h4><span class="text-red"></span>{{ $order->address->postcode }}</h4>
                                </div>
                            </div>
                              @endif
                        @if(!empty($order->items[0]->description))
                        <br/>
                        <label for="">Comment:</label>
                        <h4>{{ $order->items[0]->description }}</h4>
                        @endif
                        <br/>
                        {{-- <h4 class="ml-4">{{ __("DELIVERY FEE") }}: @money( $order->delivery_price, env('CASHIER_CURRENCY','usd'),true)</h4> --}}
                        <div class="accordion" id="accordionExample">
                            <div class="">
                              <div class="" id="headingTwo">
                                <h2 class="mb-0">
                                    <button class="btn btn-link collapsed" type="button" data-toggle="collapse" data-target="#collapesOne" aria-expanded="false" aria-controls="collapesOne">
                                    <h4 class="ml-1">{{ __("DELIVERY FEE") }}: @money( $order->delivery_price, env('CASHIER_CURRENCY','usd'),true) <span class="text-red"><strong class="collaps-sign-two">+</strong></span></h4>
                                  </button>
                                </h2>
                              </div>
                          
                              <div id="collapesOne" class="collapse" aria-labelledby="headingTwo" data-parent="#accordionExample">
                                <div class="card-body pt-0">
                                    <h5>{{ __("MSD Fee") }}:  @money( $order->msd_fee, env('CASHIER_CURRENCY','usd'),true)</h5>
                                    <h5>{{ __("Clean Zone Fee") }}:  @money( $order->other_fee, env('CASHIER_CURRENCY','usd'),true)</h5>
                                    <h5>{{ __("Delivery Fee") }}:  @money( $order->delivery_price -($order->msd_fee + $order->other_fee) , env('CASHIER_CURRENCY','usd'),true)</h5>
                                </div>
                              </div>
                            </div>
                          </div>
                        <div class="accordion" id="accordionExample">
                            <div class="">
                              <div class="" id="headingOne">
                                <h2 class="mb-0">
                                    <button class="btn btn-link collapsed" type="button" data-toggle="collapse" data-target="#collapseTwo" aria-expanded="false" aria-controls="collapseTwo">
                                    <h4 class="ml-1">{{ __("TOTAL") }}: @money( $order->total_price, env('CASHIER_CURRENCY','usd'),true) <span class="text-red"><strong class="collaps-sign">+</strong></span></h4>
                                  </button>
                                </h2>
                              </div>
                          
                              <div id="collapseTwo" class="collapse" aria-labelledby="headingTwo" data-parent="#accordionExample">
                                <div class="card-body pt-0">
                                    <h5>{{ __("Admin Fee") }}:  @money( $order->admin_fee, env('CASHIER_CURRENCY','usd'),true)</h5>
                                    <h5>{{ __("MSD Fee") }}:  @money( $order->msd_fee, env('CASHIER_CURRENCY','usd'),true)</h5>
                                    <h5>{{ __("Clean Zone Fee") }}:  @money( $order->other_fee, env('CASHIER_CURRENCY','usd'),true)</h5>
                                    <h5>{{ __("Delivery Fee") }}:  @money( $order->delivery_price -($order->msd_fee + $order->other_fee) , env('CASHIER_CURRENCY','usd'),true)</h5>
                                </div>
                              </div>
                            </div>
                          </div>
                        <hr />
                        <h4>{{ __("Payment method") }}: {{ __(strtoupper($order->payment_method)) }}</h4>
                        <h4>{{ __("Payment status") }}: {{ __(ucfirst(($order->payment_status == 'unpaid') ? "Postpaid Payable" : $order->payment_status)) }}</h4>
                        <hr />
                        <h4>{{ __("Delivery method") }}: {{ true ?__('Delivery'):__('Pickup') }}</h4>
                        <h3>{{ __("Time slot") }}: @include('orders.partials.time', ['time'=> (!$order->is_urgent) ? $order->dlvry_time : $order->created_at])</h3>



                    </div>
                   @include('orders.partials.actions.buttons',['order'=>$order])
                </div>
            </div>
            <div class="col-xl-5  mb-5 mb-xl-0">
                <br/>
                <div class="card card-profile shadow">
                    <div class="card-header">
                        <h5 class="h3 mb-0">{{ __("Order tracking")}}</h5>
                    </div>
                    <div class="card-body">
                        @include('orders.partials.map',['order'=>$order])
                    </div>
                </div>
                <br/>
                <div class="card card-profile shadow">
                    <div class="card-header">
                        <h5 class="h3 mb-0">{{ __("Status History")}}</h5>
                    </div>
                    <div class="card-body">
                        <div class="timeline timeline-one-side" id="status-history" data-timeline-content="axis" data-timeline-axis-style="dashed">
                        @foreach($order->status as $key=>$value)
                            <div class="timeline-block">
                                <span class="timeline-step badge-success">
                                    <i class="ni ni-bell-55"></i>
                                </span>
                                <div class="timeline-content">
                                    <div class="d-flex justify-content-between pt-1">
                                        <div>
                                            <span class="text-muted text-sm font-weight-bold">{{ __($value->name) }}</span>
                                        </div>
                                        <div class="text-right">
                                            <small class="text-muted"><i class="fas fa-clock mr-1"></i>{{ $value->pivot->created_at->format('d M Y h:i') }}</small>
                                        </div>
                                    </div>
                                    <h6 class="text-sm mt-1 mb-0">{{ __('Status from') }}: {{$userNames[$key] }}</h6>
                                </div>
                            </div>
                        @endforeach
                        </div>
                    </div>
                </div>


            </div>
        </div>
        @include('layouts.footers.auth')
        @include('orders.partials.modals')
    </div>
@endsection
@section('js')
<script>
    $(document).ready(function () {
        $('#headingOne button').on('click', function () { 
            if($(this).hasClass('collapsed')){
                $('.collaps-sign').text('--');
            }
            else{
                $('.collaps-sign').text('+');
            }
         })
        $('#headingTwo button').on('click', function () { 
            if($(this).hasClass('collapsed')){
                $('.collaps-sign-two').text('--');
            }
            else{
                $('.collaps-sign-two').text('+');
            }
         })
    });
</script>
@endsection

