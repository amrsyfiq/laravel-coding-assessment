<!-- Author : Muhammad Amir Syafiq -->

@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card mb-5">
                <div class="card-header">{{ __('Dashboard') }}</div>

                <div class="card-body">
                    @if (session('status'))
                        <div class="alert alert-success" role="alert">
                            {{ session('status') }}
                        </div>
                    @endif

                    {{ __('View user here!') }}
                </div>
            </div>

            <div class="float-start">
                <h4 class="pb-3">{{ __('View user - ') }}{{ $user->name }}</h4>
            </div>
            <div class="float-end">
                <a href="{{ route('users.index') }}" class="btn btn-info float-right"><i class="fa fa-arrow-left" aria-hidden="true"></i> All user</a> 
            </div>
            <div class="clearfix"></div>

            <div class="card card-body bg-light p-4">
                <div class="mb-3">
                    <label for="name" class="form-label">Name</label>
                    <input type="text" class="form-control mb-2" id="name" name="name" value="{{ $user->name }}" disabled>
                </div>

                <div class="mb-3">
                    <label for="email" class="form-label">Email Adress</label>
                    <input type="email" class="form-control mb-2" id="email" name="email" value="{{ $user->email }}" disabled>
                </div>

                <div class="mb-3">
                    <label for="phone" class="form-label">Phone Number</label>
                    <input type="text" class="form-control mb-2" id="phone" name="phone" value="{{ $user->phone }}" disabled>
                </div>
                
                <div class="form-group">
                    <label for="role" class="form-label">Role</label>
                    @if(!empty($user->getRoleNames()))
                        @foreach($user->getRoleNames() as $role)
                        <input type="text" class="form-control mb-2" id="role" name="role" value="{{ $role }}" disabled>
                        @endforeach
                    @endif
                </div>

                <br>
                <div class="col-3">
                    <a href="{{ route('users.index') }}" class="btn btn-default float-left">Back</a>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
