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

                    {{ __('View product here!') }}
                </div>
            </div>

            <div class="float-start">
                <h4 class="pb-3">{{ __('View product - ') }}{{ $product->name }}</h4>
            </div>
            <div class="float-end">
                <a href="{{ route('products.index') }}" class="btn btn-info float-right"><i class="fa fa-arrow-left" aria-hidden="true"></i>{{ __(' All Products') }}</a> 
            </div>
            <div class="clearfix"></div>

            <div class="card card-body bg-light p-4">
                <div class="mb-3">
                    <label for="name" class="form-label">{{ __('Name') }}</label>
                    <input type="text" class="form-control mb-2" id="name" name="name" value="{{ $product->name }}" disabled>
                </div>

                <div class="mb-3">
                    <label for="price" class="form-label">{{ __('Price') }}</label>
                    <input type="number" class="form-control mb-2" id="price" name="price" value="{{ $product->price }}">
                </div>

                <div class="mb-3">
                    <label for="description" class="form-label">{{ __('Description') }}</label>
                    <textarea class="form-control mb-2" id="description" name="description">{{ $product->description }}</textarea>
                </div>

                <div class="mb-3">
                    <label for="tags" class="form-label">{{ __('Tags') }}</label>
                    <input type="text" class="form-control mb-2" id="tags" name="tags" value="{{ $product->tags }}">
                </div>

                <div class="mb-3">
                    <label for="status" class="form-label">{{ __('Status') }}</label>
                    <input type="text" class="form-control mb-2" id="status" name="status" value="{{ $product->status }}">
                </div>

                <br>
                <div class="col-3">
                    <a href="{{ route('products.index') }}" class="btn btn-default float-left">{{ __('Back') }}</a>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
