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

                    {{ __('Update user here!') }}
                </div>
            </div>

            <div class="float-start">
                <h4 class="pb-3">{{ __('Update users - ') }}{{ $user->name }}</h4>
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

                    <input type="hidden" name="user_id" id="user_id" value={{ $user->id }}>

                   <div class="mb-3">
                       <label for="name" class="form-la__bel">{{ ('Name') }}</label>
                       <input type="text" class="form-control mb-2" id="name" name="name" value="{{ $user->name }}">
                       @error('name')
                           <span class="text-danger">{{ $message }}</span>
                       @enderror
                   </div>

                   <div class="mb-3">
                       <label for="email" class="form-label">{{ __('Email Adress') }}</label>
                       <input type="email" class="form-control mb-2" id="email" name="email" value="{{ $user->email }}">
                       @error('email')
                           <span class="text-danger">{{ $message }}</span>
                       @enderror
                   </div>

                   <div class="mb-3">
                       <label for="phone" class="form-label">{{ __('Phone Number') }}</label>
                       <input type="text" class="form-control mb-2" id="phone" name="phone" value="{{ $user->phone }}">
                       @error('phone')
                           <span class="text-danger">{{ $message }}</span>
                       @enderror
                   </div>
                   
                    @role('Admin')
                        <div class="form-group">
                            <label for="role" class="form-la__bel">{{ __('Role') }}</label>
                            <select class="form-select mb-2" id="roles" name="roles">
                                @foreach ($roles as $role)
                                    <option value="{{ $userRole }}" selected hidden>{{ __($userRole) }}</option>
                                    <option value="{{ $role }}">{{ __($role) }}</option>
                                @endforeach
                            </select>
                        </div>
                    @endrole

                    <br>
                    <button type="submit" id="updateButton" class="btn btn-primary"><i class="fa fa-check" aria-hidden="true"></i> {{ __('Submit') }}</button>
                    <a href="{{ route('users.index') }}" class="btn btn-defau__lt"> {{ __('Back') }}</a>
                </form>
            </div>
        </div>
    </div>
</div>
<script>
    $(function () {

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
        Update User Code
        --------------------------------------------
        --------------------------------------------*/
        $('#updateButton').click(function (e) {
            e.preventDefault();
        
            var user_id = $('#user_id').val();

            $.ajax({
            data: $('#userForm').serialize(),
            url: "{{ route('users.store') }}"+'/'+user_id,
            type: "PUT",
            dataType: 'json',
                success: function (data) {
                    if($.isEmptyObject(data.error)){
                        console.log(data.success);
                        $('#updateButton').html('Submit');
                        window.location.href = '/users';
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
