<!-- Author : Muhammad Amir Syafiq -->

@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card mb-5">
                <div class="card-header">{{ __('Dashboard') }}</div>

                <div class="card-body">
                    @if (session('status'))
                        <div class="alert alert-success" role="alert">
                            {{ session('status') }}
                        </div>
                    @endif

                    {{ __('Manage users here!') }}
                </div>
            </div>

            <div class="float-start">
                <h4 class="pb-3">{{ __('Users Management') }}</h4>
            </div>
            <div class="float-end">
              @can('user-create')
                <a href="{{ route('users.create') }}" class="btn btn-info float-right"><i class="fa fa-plus" aria-hidden="true"></i> Create user</a> 
              @endcan
            </div>
            <div class="clearfix"></div>

            <div id="reload">
                @foreach ($users as $user)
                    <div class="card mb-3">
                        <h5 class="card-header">
                            {{ __($user->name) }}
                            <span class="badge rounded-pill bg-light text-dark">{{ __('Created') }} - {{ __( $user->created_at->diffForHumans() ) }}</span>
                        </h5>

                        <div class="card-body">
                            <div class="card-text">
                                <div class="float-start">
                                    {{ __('Role') }} : {{ $user->roles->pluck('name')[0] ?? '' }}
                                <br>
                                    {{ __('Email') }} : {{ __($user->email) }}
                                <br>
                                    {{ __('Phone Number') }} : {{ __($user->phone) }}
                                <br>
                                @if ($user->created_at > now()->subMinutes(5))
                                <span class="badge rounded-pill bg-success text-white mt-3">{{ __('New') }}</span>
                                @endif
                                <small>{{ __('Last Updated') }} - {{ __( $user->updated_at->diffForHumans() ) }}</small>
                                </div>
                                <div class="float-end">
                                <a href="{{ route('users.show', $user->id) }}" class="btn btn-info"><i class="fa fa-user-circle" aria-hidden="true"></i></a>
                                @can('user-edit')
                                    <a href="{{ route('users.edit', $user->id) }}" class="btn btn-warning"><i class="fa fa-edit" aria-hidden="true"></i></a>
                                @endcan
                                @can('user-delete')
                                    <button type="submit" class="btn btn-danger" onclick="deleteUser('{{ $user->id }}')"><i class="fa fa-trash" style="color: #000;"aria-hidden="true"></i></button>
                                @endcan
                                </div>
                                <div class="clearfix"></div>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
            <div class="float-end pt-3">
                {{  $users->links()  }}
            </div>

            @if (count($users) === 0)
                <div class="alert alert-danger p-2">
                    {{ __('No user Found. Please create a user') }}
                    <a href="{{ route('users.create') }}"> here</a> !
                </div>
            @endif
        </div>
    </div>
</div>
<script>

    /*------------------------------------------
    --------------------------------------------
    Render pageRefresh
    --------------------------------------------
    --------------------------------------------*/

    $(document).ready(function() {
    var pageRefresh = 1000; //5 s
        setInterval(function() {
            $('#reload').load(location.href + " #reload");
        }, pageRefresh);
    });
    
    function deleteUser(user_id) {
        
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
        Delete User Code
        --------------------------------------------
        --------------------------------------------*/

        Swal.fire({
            title: 'Are you sure?',
            text: "You won't be able to revert this!",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Yes, delete it!'
            }).then((result) => {
            if (result.isConfirmed) {
                $.ajax({
                    type: "DELETE",
                    url: "{{ route('users.store') }}"+'/'+user_id,
                    success: function (data) {
                        table.draw();
                    },
                    error: function (data) {
                        console.log('Error:', data);
                    }
                });
                Swal.fire(
                'Deleted!',
                'User has been deleted.',
                'success'
                )
            }
        });
    }   
</script>
@endsection
