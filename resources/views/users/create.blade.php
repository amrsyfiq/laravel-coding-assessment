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

                    {{ __('Create user here!') }}
                </div>
            </div>

            <div class="float-start">
                <h4 class="pb-3">{{ __('Create User') }}</h4>
            </div>
            <div class="float-end">
                <a href="{{ route('users.index') }}" class="btn btn-info float-right"><i class="fa fa-arrow-left" aria-hidden="true"></i> All user</a> 
            </div>
            <div class="clearfix"></div>

            <div class="card card-body bg-light p-4">
                <form action="{{ route('users.store') }}" method="POST">
                    @csrf

                   <div class="mb-3">
                       <label for="name" class="form-label">Name</label>
                       <input type="text" class="form-control mb-2" id="name" name="name">
                       @error('name')
                           <span class="text-danger">{{ $message }}</span>
                       @enderror
                   </div>

                   <div class="mb-3">
                       <label for="email" class="form-label">Email Adress</label>
                       <input type="email" class="form-control mb-2" id="email" name="email">
                       @error('email')
                           <span class="text-danger">{{ $message }}</span>
                       @enderror
                   </div>

                   <div class="mb-3">
                       <label for="phone" class="form-label">Phone Number</label>
                       <input type="text" class="form-control mb-2" id="phone" name="phone">
                       @error('phone')
                           <span class="text-danger">{{ $message }}</span>
                       @enderror
                   </div>
                   
                   @role('Admin')
                        <div class="mb-3">
                            <label for="password" class="form-label">Password</label>
                            <input type="password" class="form-control mb-2" id="password" name="password">
                            @error('password')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="confirm-password" class="form-label">Confirm Password</label>
                            <input type="password" class="form-control mb-2" id="confirm-password" name="confirm-password">
                            @error('confirm-password')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>

                        <div class="form-group">
                            <label for="role" class="form-label">Role</label>
                            {{ Form::select('roles[]', $roles, [], array('class' => 'form-control', 'multiple')) }}
                        </div>
                    @endrole

                    <br>
                    <button type="submit" class="btn btn-primary"><i class="fa fa-check" aria-hidden="true"></i> Submit</button>
                    <a href="{{ route('users.index') }}" class="btn btn-default"> Back</a>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
