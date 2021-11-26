@extends('layouts.app', ['title' => __('Role Management')])

@section('content')

<div class="header bg-gradient-primary pb-8 pt-5 pt-md-8">
</div>

<div class="container-fluid mt--7">
    <div class="row">
        <div class="col">
            <div class="card shadow">
                <div class="card-header border-0">
                    <div class="row align-items-center">
                        <div class="col-8">
                            <h3 class="mb-0">{{ __('Role') }}</h3>
                        </div>
                        <div class="col-4 text-right">
                            <a href="{{ route('roles.index') }}" class="btn btn-sm btn-primary">{{ __('Back') }}</a>
                        </div>
                    </div>
                    @include('msg.flash_message')
                </div>


                <div class="container">
                    <div class="row">
                        <div class="col-xs-12 col-sm-12 col-md-12 text-center">
                            <div class="form-group">
                                <strong>Name:</strong>
                                {{ $role->name }}
                            </div>
                        </div>
                        <div class="col-xs-12 col-sm-12 col-md-12">
                            <div class="form-group">
                                <strong>Permissions:</strong>
                                @if(!empty($rolePermissions))
                                <ul>
                                    <div class="row">
                                        @foreach($rolePermissions as $v)
                                        <div class="col-lg-4 col-6">
                                            <li>{{ $v->name }}</li>
                                        </div>
                                        @endforeach
                                    </div>
                                </ul>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    @include('layouts.footers.auth')
</div>
@endsection
