@extends('layouts.app', ['title' => __('Charger Info Management')])

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
                                <h3 class="mb-0">{{ __('Charger Info') }}</h3>
                            </div>
                            <div class="col-4 text-right">
                                <a href="{{ route('chargerbox.create') }}" class="btn btn-sm btn-primary">{{ __('Add Info') }}</a>
                            </div>
                        </div>
                    </div>

                    <div class="col-12">
                        @if (session('status'))
                            <div class="alert alert-success alert-dismissible fade show" role="alert">
                                {{ session('status') }}
                                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                        @endif
                    </div>

                    <div class="table-responsive">
                        <table class="table align-items-center table-flush">
                            <thead class="thead-light">
                                <tr>
                                    <th scope="col">{{ __('Image') }}</th>
                                    <th scope="col">{{ __('Name') }}</th>
                                    <th scope="col">{{ __('Type') }}</th>
                                    <th scope="col">{{ __('Status') }}</th>
                                    <th scope="col">{{ __('Creation Date') }}</th>
                                    <th scope="col"></th>
                                </tr>
                            </thead>
                            <tbody>
                                @if(count($chargers))
                                @foreach ($chargers as $user)
                                    <tr>
                                        <td><img src="{{ asset('uploads/'.$user->image.'_thumbnail'.'.jpg') }}" alt="" class="w-25" style="border-radius: 50%"></td>
                                        <td>{{ $user->name }}</td>
                                        <td>{{ config('constants.charger_type.'.$user->type) }}</td>
                                        <td>
                                            @if ($user->status == 'Active')
                                            <span class="badge badge-success badge-pill">{{ $user->status }}</span>
                                            @else
                                            <span class="badge badge-danger badge-pill">{{ $user->status }}</span>
                                            @endif
                                        </td>
                                        <td>{{ $user->created_at->format('d/m/Y H:i') }}</td>
                                        <td class="text-right">
                                            <div class="dropdown">
                                                <a class="btn btn-sm btn-icon-only text-light" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                                    <i class="fas fa-ellipsis-v"></i>
                                                </a>
                                                <div class="dropdown-menu dropdown-menu-right dropdown-menu-arrow">
                                                    <a class="dropdown-item" href="{{ route('chargerbox.edit', $user->id) }}">{{ __('Edit') }}</a>
                                                </div>
                                            </div>
                                        </td>
                                    </tr>
                                @endforeach
                                @else
                                <tr class="text-center">
                                    <td colspan="4">No Data Found!</td>
                                </tr>
                                @endif
                            </tbody>
                        </table>
                    </div>
                    <div class="card-footer py-4">
                        <nav class="d-flex justify-content-end" aria-label="...">
                            {{ $chargers->links() }}
                        </nav>
                    </div>
                </div>
            </div>
        </div>

        @include('layouts.footers.auth')
    </div>
@endsection
