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

                    {{ __('Update product here!') }}
                </div>
            </div>

            <div class="float-start">
                <h4 class="pb-3">{{ __('Update product - ') }}{{ $product->name }}</h4>
            </div>
            <div class="float-end">
                <a href="{{ route('products.index') }}" class="btn btn-info float-right"><i class="fa fa-arrow-left" aria-hidden="true"></i>{{ __(' All products') }}</a> 
            </div>
            <div class="clearfix"></div>

            <div class="card card-body bg-light p-4">
                <form id="productForm" name="productForm">
                    <div class="alert alert-danger print-error-msg" style="display:none">
                        <ul></ul>
                    </div>

                    <input type="hidden" name="product_id" id="product_id" value={{ $product->id }}>

                    <div class="mb-3">
                        <label for="name" class="form-label">{{ __('Name') }}</label>
                        <input type="text" class="form-control mb-2" id="name" name="name" value="{{ $product->name }}">
                        @error('name')
                            <span class="text-danger">{{ $message }}</span>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label for="price" class="form-label">{{ __('Price') }}</label>
                        <input type="number" class="form-control mb-2" id="price" name="price" value="{{ $product->price }}">
                        @error('price')
                            <span class="text-danger">{{ $message }}</span>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label for="description" class="form-label">{{ __('Description') }}</label>
                        <textarea class="form-control mb-2" id="description" name="description">{{ $product->description }}</textarea>
                        @error('description')
                            <span class="text-danger">{{ $message }}</span>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label for="tags" class="form-label">{{ __('Tags') }}</label>
                        {{ Form::select('tags[]', array("New"=>"New", "Top Seller"=>"Top Seller", "On Sales"=>"On Sales", "Discount"=>"Discount",), explode(', ', $product->tags), array('class' => 'form-select', 'id'=> 'tags', 'multiple')) }}
                        @error('tags')
                            <span class="text-danger">{{ $message }}</span>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label for="status" class="form-label">{{ __('Status') }}</label>
                        <select class="form-select mb-2" id="status" name="status">
                            <option value="{{ $product->status }}" selected hidden>{{ $product->status }}</option>
                            <option value="In Stock">{{ __('In Stock') }}</option>
                            <option value="Out of Stock">{{ __('Out of Stock') }}</option>
                            <option value="Shipping">{{ __('Shipping') }}</option>
                            <option value="Delivered">{{ __('Delivered') }}</option>
                        </select>
                        @error('status')
                            <span class="text-danger">{{ $message }}</span>
                        @enderror
                    </div>

                    <br>
                    <button type="submit" id="updateButton" class="btn btn-primary"><i class="fa fa-check" aria-hidden="true"></i> {{ __('Submit') }}</button>
                    <a href="{{ route('products.index') }}" class="btn btn-default"> {{ __('Back') }}</a>
                </form>
            </div>
        </div>
    </div>
</div>
<script>
    $(function () {
        
        /*------------------------------------------
         --------------------------------------------
         Select2
         --------------------------------------------
         --------------------------------------------*/ 
         $(document).ready(function() {
            $('#tags').select2({
                theme: "bootstrap-5",
                placeholder: "Select tags",
            });
        });

        /*------------------------------------------
         --------------------------------------------
         Pass Header Token
         --------------------------------------------
         --------------------------------------------*/ 
        $.ajaxSetup({
              headers: {
                  'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
              }
        });

        /*------------------------------------------
        --------------------------------------------
        Update Product Code
        --------------------------------------------
        --------------------------------------------*/
        $('#updateButton').click(function (e) {
            e.preventDefault();
        
            $.ajax({
            data: $('#productForm').serialize(),
            url: "{{ route('products.store') }}",
            type: "POST",
            dataType: 'json',
                success: function (data) {
                    if($.isEmptyObject(data.error)){
                        console.log(data.success);
                        $('#updateButton').html('Submit');
                        window.location.href = '/products';
                    }else{
                        printErrorMsg(data.error);
                    }
                },
                error: function (data) {
                    console.log('Error:', data);
                     $('#updateButton').html('Submit Error');
                }
            });
        });

        function printErrorMsg (msg) {
            $(".print-error-msg").find("ul").html('');
            $(".print-error-msg").css('display','block');
            $.each( msg, function( key, value ) {
                $(".print-error-msg").find("ul").append('<li>'+value+'</li>');
            });
        }
    });
</script>
@endsection
