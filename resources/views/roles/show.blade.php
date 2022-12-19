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

                    {{ __('View role here!') }}
                </div>
            </div>

            <div class="float-start">
                <h4 class="pb-3">{{ __('View role - ') }}{{ $role->name }}</h4>
            </div>
            <div class="float-end">
                <a href="{{ route('roles.index') }}" class="btn btn-info float-right"><i class="fa fa-arrow-left" aria-hidden="true"></i>{{ __(' All Roles') }}</a> 
            </div>
            <div class="clearfix"></div>

            <div class="card card-body bg-light p-4">
                <div class="mb-3">
                    <label for="name" class="form-label">{{ __('Name') }}</label>
                    <input type="text" class="form-control mb-2" id="name" name="name" value="{{ $role->name }}" disabled>
                </div>

                <div class="mb-3">
                    <label for="permission" class="form-label">{{ __('Permissions') }}</label>
                    @if(!empty($rolePermissions))
                        <select class="form-select mb-2" id="roles" name="roles"  style="width:100%" multiple disabled>
                            @foreach($rolePermissions as $permission)
                                <option value="{{ $permission->name }}" selected>{{ __($permission->name) }}</option>
                            @endforeach
                        </select>
                    @endif
                </div>

                <br>
                <div class="col-3">
                    <a href="{{ route('roles.index') }}" class="btn btn-default float-left">{{ __('Back') }}</a>
                </div>
            </div>
        </div>
    </div>
</div>
<script>
    /*------------------------------------------
    --------------------------------------------
    Select2
    --------------------------------------------
    --------------------------------------------*/ 
   $(document).ready(function() {
       $('#roles').select2({
           theme: "bootstrap-5",
       });
   });
</script>
@endsection
