@extends('layouts.app', ['title' => __('Customer Management')])

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
                                <h3 class="mb-0">{{ __('Customers') }}</h3>
                            </div>
                            <!-- <div class="col-4 text-right">
                                <a href="{{ route('users.create') }}" class="btn btn-sm btn-primary">{{ __('Add user') }}</a>
                            </div> -->
                        </div>
                    </div>
                    @include('msg.flash_message')

                    <div class="table-responsive">
                        <table class="table align-items-center table-flush">
                            <thead class="thead-light">
                                <tr>
                                    <th scope="col">{{ __('Name') }}</th>
                                    <th scope="col">{{ __('Email') }}</th>
                                    <th scope="col">{{ __('Phone') }}</th>
                                    <th scope="col">{{ __('Car Brand') }}</th>
                                    <th scope="col">{{ __('Car Modal') }}</th>
                                    <th scope="col">{{ __('Status') }}</th>
                                    <th scope="col">{{ __('Creation Date') }}</th>
                                    <th scope="col"></th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($cutomerList as $user)
                                    <tr>
                                        <td>{{ $user->first_name }} {{ $user->last_name }}</td>
                                        <td>
                                            <a href="mailto:{{ $user->email }}">{{ $user->email }}</a>
                                        </td>
                                        <td>{{ $user->phone }}</td>
                                        <td>{{ ($user->car_brand) ? $user->car_brand : '--' }}</td>
                                        <td>{{ ($user->car_modal) ? $user->car_modal : '--' }}</td>
                                        <td>
                                        @if ($user->status == 1)
                                        <span class="badge badge-success badge-pill">
                                            {{ config('constants.status.'.$user->status) }}
                                        </span>
                                        @elseif ($user->status == 2)
                                        <span class="badge badge-danger badge-pill">
                                            {{ config('constants.status.'.$user->status) }}
                                        </span>
                                        @else
                                        <span class="badge badge-warning badge-pill">
                                            {{ config('constants.status.'.$user->status) }}
                                        </span>
                                        @endif
                                        </td>
                                        <td>{{ $user->created_at->format('d/m/Y H:i') }}</td>
                                        <td class="text-right">
                                            <div class="dropdown">
                                                <a class="btn btn-sm btn-icon-only text-light" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                                    <i class="fas fa-ellipsis-v"></i>
                                                </a>
                                                @if($user->status != 3)
                                                <div class="dropdown-menu dropdown-menu-right dropdown-menu-arrow">
                                                    <form action="{{ route('admin.customer.change.status', $user) }}" method="post">
                                                        @csrf
                                                        @method('delete')
                                                        <button type="button" class="dropdown-item" onclick="confirm('{{ __("Are you sure you want to change Status?") }}') ? this.parentElement.submit() : ''">
                                                            {{ __('Change Status') }}
                                                        </button>
                                                    </form>
                                                </div>
                                                @endif
                                            </div>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                    <div class="card-footer py-4">
                        <nav class="d-flex justify-content-end" aria-label="...">
                            {{ $cutomerList->links() }}
                        </nav>
                    </div>
                </div>
            </div>
        </div>

        @include('layouts.footers.auth')
    </div>
@endsection
