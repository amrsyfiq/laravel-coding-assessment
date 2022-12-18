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

                    {{ __('Create role here!') }}
                </div>
            </div>

            <div class="float-start">
                <h4 class="pb-3">{{ __('Create Role') }}</h4>
            </div>
            <div class="float-end">
                <a href="{{ route('roles.index') }}" class="btn btn-info float-right"><i class="fa fa-arrow-left" aria-hidden="true"></i>{{ __(' All roles') }}</a> 
            </div>
            <div class="clearfix"></div>

            <div class="card card-body bg-light p-4">
                <form id="roleForm" name="roleForm">
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
                        <label for="permission" class="form-label">{{ __('Permissions') }}</label>
                        <select class="form-select mb-2" id="permissions" name="permissions[]" style="width:100%" multiple>
                            @foreach($permissions as $permission)
                                <option value="{{ $permission->name }}">{{ __($permission->name) }}</option>
                            @endforeach
                        </select>
                        @error('permissions')
                            <span class="text-danger">{{ $message }}</span>
                        @enderror
                    </div>

                    <br>
                    <button type="submit" id="createButton" class="btn btn-primary"><i class="fa fa-check" aria-hidden="true"></i> {{ __('Submit') }}</button>
                    <a href="{{ route('roles.index') }}" class="btn btn-default"> {{ __('Back') }}</a>
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
            $('#permissions').select2({
                theme: "bootstrap-5",
                placeholder: "Select permissions",
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
        Create Role Code
        --------------------------------------------
        --------------------------------------------*/
        $('#createButton').click(function (e) {
            e.preventDefault();

            $.ajax({
            data: $('#roleForm').serialize(),
            url: "{{ route('roles.store') }}",
            type: "POST",
            dataType: 'json',
                success: function (data) {
                    if($.isEmptyObject(data.error)){
                        console.log(data.success);
                        $('#createButton').html('Submit');
                        window.location.href = '/roles';
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
