<!-- Author : Muhammad Amir Syafiq -->

@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card mb-5">
                <div class="card-header">{{ __('Dashboard') }}</div>

                <div class="card-body">
                    @if (session('status'))
                        <div class="alert alert-success" role="alert">
                            {{ session('status') }}
                        </div>
                    @endif

                    {{ __('You are logged in!') }}
                </div>
            </div>

            <div class="float-start">
                <h4 class="pb-3">{{ __('Users Management') }}</h4>
            </div>
            <div class="float-end">
              @can('user-create')
                <a href="{{ route('users.create') }}" class="btn btn-info float-right"><i class="fa fa-plus" aria-hidden="true"></i> Create user</a> 
              @endcan
            </div>
            <div class="clearfix"></div>

            @foreach ($users as $user)
                <div class="card mb-3">
                    <h5 class="card-header">
                        {{ __($user->name) }}
                        <span class="badge rounded-pill bg-light text-dark">Created - {{ __( $user->created_at->diffForHumans() ) }}</span>
                    </h5>

                    <div class="card-body">
                        <div class="card-text">
                            <div class="float-start">
                                Role: {{ $user->roles->pluck('name')[0] ?? '' }}
                              <br>
                                Phone Number: {{ __($user->phone) }}
                              <br>
                              <span class="badge rounded-pill bg-success text-white">New</span>
                              <small>Last Updated - {{ __( $user->updated_at->diffForHumans() ) }}</small>
                            </div>
                            <div class="float-end">
                              <a href="{{ route('users.show', $user->id) }}" class="btn btn-info"><i class="fa fa-user-circle" aria-hidden="true"></i></a>
                              @can('user-edit')
                                <a href="{{ route('users.edit', $user->id) }}" class="btn btn-warning"><i class="fa fa-edit" aria-hidden="true"></i></a>
                              @endcan
                              @can('user-delete')
                                <form action="{{ route('users.destroy', $user->id) }}" style="display: inline" method="POST">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-danger" onclick="return confirm('Are you sure?')"><i class="fa fa-trash" style="color: #000;"aria-hidden="true"></i></button>
                                </form>
                              @endcan
                            </div>
                            <div class="clearfix"></div>
                        </div>
                    </div>
                </div>
            @endforeach

            @if (count($users) === 0)
                <div class="alert alert-danger p-2">
                    {{ __('No user Found. Please create a user') }}
                    <a href="{{ route('users.create') }}"> here</a> !
                </div>
            @endif
        </div>
    </div>
</div>
@endsection
