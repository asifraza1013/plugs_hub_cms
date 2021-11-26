@extends('layouts.app', ['title' => __('Charger Info Management')])

@section('content')
    @include('users.partials.header', ['title' => __('Add Charger')])

    <div class="container-fluid mt--7">
        <div class="row">
            <div class="col-xl-12 order-xl-1">
                <div class="card bg-secondary shadow">
                    <div class="card-header bg-white border-0">
                        <div class="row align-items-center">
                            <div class="col-8">
                                <h3 class="mb-0">{{ __('Charger Info Management') }}</h3>
                            </div>
                            <div class="col-4 text-right">
                                <a href="{{ route('chargerbox.index') }}" class="btn btn-sm btn-primary">{{ __('Back to list') }}</a>
                            </div>
                        </div>
                    </div>
                    <div class="card-body">
                        <form method="post" action="{{ route('chargerbox.store') }}" autocomplete="off" enctype="multipart/form-data">
                            @csrf

                            <h6 class="heading-small text-muted mb-4">{{ __('User information') }}</h6>
                            <div class="pl-lg-4">
                                <div class="form-group{{ $errors->has('name') ? ' has-danger' : '' }}">
                                    <label class="form-control-label" for="input-name">{{ __('Name') }}</label>
                                    <input type="text" name="name" id="input-name" class="form-control form-control-alternative{{ $errors->has('name') ? ' is-invalid' : '' }}" placeholder="{{ __('Name') }}" value="{{ old('name') }}" required autofocus>

                                    @if ($errors->has('name'))
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $errors->first('name') }}</strong>
                                        </span>
                                    @endif
                                </div>
                                <div class="form-group{{ $errors->has('type') ? ' has-danger' : '' }}">
                                    <label class="form-control-label" for="">{{ __('Type') }}</label>
                                    <select class="form-control form-control-alternative{{ $errors->has('type') ? ' is-invalid' : '' }}" name="type">
                                        <option disabled selected value> -- {{ __('Select an option') }} -- </option>
                                        @foreach (config('constants.charger_info') as $key=>$item)
                                            <option value="{{ $key }}"
                                            >{{ $item }}</option>
                                        @endforeach
                                    </select>

                                    @if ($errors->has('type'))
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $errors->first('type') }}</strong>
                                    </span>
                                    @endif
                                </div>
                                <div class="form-group{{ $errors->has('status') ? ' has-danger' : '' }}">
                                    <label class="form-control-label" for="">{{ __('Status') }}</label>
                                    <select class="form-control form-control-alternative{{ $errors->has('status') ? ' is-invalid' : '' }}" name="status">
                                        <option disabled selected value> -- {{ __('Select an option') }} -- </option>
                                        <option value="Active">{{ __('Active') }}</option>
                                        <option value="Inactive">{{ __('Inactive') }}</option>
                                    </select>

                                    @if ($errors->has('status'))
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $errors->first('status') }}</strong>
                                    </span>
                                    @endif
                                </div>
                                <div class="form-group {{ $errors->has('image') ? ' has-danger' : '' }}">
                                    <label class="form-control-label" for="image">{{ __('Image') }}</label>
                                    <div class="text-center">
                                        <div class="fileinput fileinput-new" data-provides="fileinput">
                                            <div class="fileinput-preview img-thumbnail" data-trigger="fileinput" style="width: 200px; height: 150px;">
                                                <img src="https://www.fastcat.com.ph/wp-content/uploads/2016/04/dummy-post-square-1-768x768.jpg" width="200px" height="150px" alt="..."/>
                                            </div>
                                        <div>
                                        <span class="btn btn-outline-secondary btn-file">
                                        <span class="fileinput-new">{{ __('Select image') }}</span>
                                        <span class="fileinput-exists">{{ __('Change') }}</span>
                                            <input type="file" name="image" accept="image/x-png,image/gif,image/jpeg"  required>
                                        </span>
                                        <a href="#" class="btn btn-outline-secondary fileinput-exists" data-dismiss="fileinput">{{ __('Remove') }}</a>
                                    </div>
                                    </div>
                                    </div>
                                </div>
                                <div class="text-center">
                                    <button type="submit" class="btn btn-success mt-4">{{ __('Save') }}</button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>

        @include('layouts.footers.auth')
    </div>
@endsection
