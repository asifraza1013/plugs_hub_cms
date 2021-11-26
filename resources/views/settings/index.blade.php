@extends('layouts.app', ['title' => __('Settings')])

@section('content')
<div class="header bg-gradient-primary pb-8 pt-5 pt-md-8">
</div>
<div class="container-fluid mt--7">
    <div class="row">
        <div class="col-xl-12 order-xl-1">
            <div class="card bg-secondary shadow">
                <div class="card-header bg-white border-0">
                    <div class="row align-items-center">
                        <div class="col-8">
                            <h3 class="mb-0">{{ __('Settings Management') }}</h3>
                        </div>
                        <div class="col-4 text-right">

                        </div>
                    </div>
                </div>
                <div class="card-body">
                    <!--<h6 class="heading-small text-muted mb-4">{{ __('Settings information') }}</h6>-->
                    @if (session('status'))
                    <div class="alert alert-success alert-dismissible fade show" role="alert">
                        {{ session('status') }}
                        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    @endif
                    <form method="post" action="{{ route('settings.update', $settings->id) }}" autocomplete="off"
                        enctype="multipart/form-data">
                        @csrf
                        @method('put')
                        <br />
                        <div class="tab-content" id="myTabContent">
                            <div class="tab-pane fade" id="tabs-icons-text-2" role="tabpanel"
                                aria-labelledby="tabs-icons-text-2-tab">
                            </div>
                            <div class="tab-pane fade active show" id="tabs-icons-text-1" role="tabpanel"
                                aria-labelledby="tabs-icons-text-1-tab">
                                @include('partials.input',['id'=>'admin_commission','name'=>'Admin
                                Commission','placeholder'=>'Admin Commission ...','value'=>$settings->admin_commission,
                                'required'=>true])
                                @include('partials.input',['id'=>'google_map_key','name'=>'Google Map API
                                Key','placeholder'=>'Google MAP API key ...','value'=>$settings->google_map_key,
                                'required'=>true])
                                <br />
                            </div>
                        </div>
                        <div class="text-center">
                            <button type="submit" class="btn btn-success mt-4">{{ __('Save') }}</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
<br /><br />
</div>
@endsection
