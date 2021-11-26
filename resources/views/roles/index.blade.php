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
                                <a href="{{ route('roles.create') }}" class="btn btn-sm btn-primary">{{ __('Add Role') }}</a>
                            </div>
                        </div>
                        @include('msg.flash_message')
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
                                   <th>No</th>
                                   <th>Name</th>
                                   <th width="280px">Action</th>
                                </tr>
                            </thead>
                            <tbody>
                              @foreach ($roles as $key => $role)
                              <tr>
                                  <td>{{ ++$i }}</td>
                                  <td>{{ $role->name }}</td>
                                  <td>
                                      <a class="btn btn-info" href="{{ route('roles.show',$role->id) }}">Show</a>
                                      @can('role-edit')
                                          <a class="btn btn-primary" href="{{ route('roles.edit',$role->id) }}">Edit</a>
                                      @endcan
                                      @can('role-delete')
                                          {!! Form::open(['method' => 'DELETE','route' => ['roles.destroy', $role->id],'style'=>'display:inline']) !!}
                                              {!! Form::submit('Delete', ['class' => 'btn btn-danger']) !!}
                                          {!! Form::close() !!}
                                      @endcan
                                  </td>
                              </tr>
                              @endforeach
                            </tbody>
                          </table>
                    </div>
                    <div class="card-footer py-4">
                        <nav class="d-flex justify-content-end" aria-label="...">
                            {{ $roles->links() }}
                        </nav>
                    </div>
                </div>
            </div>
        </div>

        @include('layouts.footers.auth')
    </div>
@endsection
