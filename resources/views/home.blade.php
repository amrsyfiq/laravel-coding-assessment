<!-- Author : Muhammad Amir Syafiq -->

@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center mb-3">
        <div class="col-md-9">
            <div class="card">
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
        </div>
    </div>
    <div class="row justify-content-center">
        <div class="col-md-3">
            <a href="{{ route('users.index') }}" class="card bg-info" style="color: black; text-decoration: none;">
                <div class="card-header">{{ __('Users') }}</div>

                <div class="card-body">
                    @if (session('status'))
                        <div class="alert alert-success" role="alert">
                            {{ session('status') }}
                        </div>
                    @endif

                    {{ __('Manage Users') }}
                </div>
            </a>
        </div>
        <div class="col-md-3">
            <a href="{{ route('roles.index') }}" class="card bg-warning" style="color: black; text-decoration: none;">
                <div class="card-header">{{ __('Roles') }}</div>

                <div class="card-body">
                    @if (session('status'))
                        <div class="alert alert-success" role="alert">
                            {{ session('status') }}
                        </div>
                    @endif

                    {{ __('Manage Roles') }}
                </div>
            </a>
        </div>
        <div class="col-md-3">
            <a href="{{ route('products.index') }}" class="card bg-danger" style="color: black; text-decoration: none;">
                <div class="card-header">{{ __('Products') }}</div>

                <div class="card-body">
                    @if (session('status'))
                        <div class="alert alert-success" role="alert">
                            {{ session('status') }}
                        </div>
                    @endif

                    {{ __('Manage Products') }}
                </div>
            </a>
        </div>
    </div>
    </div>
</div>
@endsection
