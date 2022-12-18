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

                    {{ __('Create product here!') }}
                </div>
            </div>

            <div class="float-start">
                <h4 class="pb-3">{{ __('Create Product') }}</h4>
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
                    
                    <div class="mb-3">
                        <label for="name" class="form-label">{{ __('Name') }}</label>
                        <input type="text" class="form-control mb-2" id="name" name="name" placeholder="Enter Name">
                        @error('name')
                            <span class="text-danger">{{ $message }}</span>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label for="price" class="form-label">{{ __('Price') }}</label>
                        <input type="number" class="form-control mb-2" id="price" name="price" placeholder=" RM 0.00">
                        @error('price')
                            <span class="text-danger">{{ $message }}</span>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label for="description" class="form-label">{{ __('Description') }}</label>
                        <textarea class="form-control mb-2" id="description" name="description" placeholder="Enter Description"></textarea>
                        @error('description')
                            <span class="text-danger">{{ $message }}</span>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label for="tags" class="form-label">{{ __('Tags') }}</label>
                        {{ Form::select('tags[]', array("New"=>"New", "Top Seller"=>"Top Seller", "On Sales"=>"On Sales", "Discount"=>"Discount",), [], array('class' => 'form-select', 'id'=> 'tags', 'multiple')) }}
                        @error('tags')
                            <span class="text-danger">{{ $message }}</span>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label for="status" class="form-label">{{ __('Status') }}</label>
                        <select class="form-select mb-2" id="status" name="status">
                            <option value="" selected disabled hidden >{{ __('Select a status') }}</option>
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
                    <button type="submit" id="createButton" class="btn btn-primary"><i class="fa fa-check" aria-hidden="true"></i> {{ __('Submit') }}</button>
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
        Create Product Code
        --------------------------------------------
        --------------------------------------------*/
        $('#createButton').click(function (e) {
            e.preventDefault();

            $.ajax({
            data: $('#productForm').serialize(),
            url: "{{ route('products.store') }}",
            type: "POST",
            dataType: 'json',
                success: function (data) {
                    if($.isEmptyObject(data.error)){
                        console.log(data.success);
                        $('#createButton').html('Submit');
                        window.location.href = '/products';
                    }else{
                        printErrorMsg(data.error);
                    }
                },
                error: function (data) {
                    console.log('Error:', data);
                     $('#createButton').html('Submit Error');
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
