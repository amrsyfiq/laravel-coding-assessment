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
                <a href="{{ route('users.index') }}" class="btn btn-info float-right"><i class="fa fa-arrow-left" aria-hidden="true"></i> {{ __('All user') }}</a> 
            </div>
            <div class="clearfix"></div>

            <div class="card card-body bg-light p-4">
                <form id="userForm" name="userForm">
                    <div class="alert alert-danger print-error-msg" style="display:none">
                        <ul></ul>
                    </div>

                    <div class="mb-3">
                        <label for="name" class="form-label">{{ __('Name') }}</label>
                        <input type="text" class="form-control mb-2" id="name" name="name">
                        @error('name')
                            <span class="text-danger">{{ $message }}</span>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label for="email" class="form-label">{{ __('Email Adress') }}</label>
                        <input type="email" class="form-control mb-2" id="email" name="email">
                        @error('email')
                            <span class="text-danger">{{ $message }}</span>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label for="phone" class="form-label">{{ __('Phone Number') }}</label>
                        <input type="text" class="form-control mb-2" id="phone" name="phone">
                        @error('phone')
                            <span class="text-danger">{{ $message }}</span>
                        @enderror
                    </div>
                   
                   @role('Admin')
                        <div class="mb-3">
                            <label for="password" class="form-label">{{ __('Password') }}</label>
                            <input type="password" class="form-control mb-2" id="password" name="password">
                            @error('password')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="confirm-password" class="form-label">{{ __('Confirm Password') }}</label>
                            <input type="password" class="form-control mb-2" id="confirm-password" name="confirm-password">
                            @error('confirm-password')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>

                        <div class="form-group">
                            <label for="role" class="form-label">{{ __('Role') }}</label>
                            <select class="form-select mb-2" id="roles" name="roles">
                                @foreach ($roles as $role)
                                    <option value="" selected disabled hidden>{{ __('Select a role') }}</option>
                                    <option value="{{ $role }}">{{ __($role) }}</option>
                                @endforeach
                            </select>
                        </div>
                    @endrole

                    <br>
                    <button type="submit" id="createButton" class="btn btn-primary"><i class="fa fa-check" aria-hidden="true"></i> {{ __('Submit') }}</button>
                    <a href="{{ route('users.index') }}" class="btn btn-default"> {{ __('Back') }}</a>
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
        Create User Code
        --------------------------------------------
        --------------------------------------------*/
        $('#createButton').click(function (e) {
            e.preventDefault();

            $.ajax({
            data: $('#userForm').serialize(),
            url: "{{ route('users.store') }}",
            type: "POST",
            dataType: 'json',
                success: function (data) {
                    if($.isEmptyObject(data.error)){
                        console.log(data.success);
                        $('#createButton').html('Submit');
                        window.location.href = '/users';
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
