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

                    {{ __('Manage roles here!') }}
                </div>
            </div>

            <div class="float-start">
                <h4 class="pb-3">{{ __('Roles Management') }}</h4>
            </div>
            <div class="float-end">
              @can('user-create')
                <a href="{{ route('roles.create') }}" class="btn btn-info float-right"><i class="fa fa-plus" aria-hidden="true"></i>{{ __(' Create Role') }}</a> 
              @endcan
            </div>
            <div class="clearfix"></div>

            <div class="card">
                <div class="card-body p-5">
                    <table class="table table-bordered align-middle table-responsive data-table"  style="width:100%">
                        <thead>
                            <tr>
                                <th class="text-center">#</th>
                                <th class="text-center">{{ __('Name') }}</th>
                                <th class="text-center">{{ __('Action') }}</th>
                            </tr>
                        </thead>
                        <tbody>
                        </tbody>
                    </table>
                </div>
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
        Render DataTable
        --------------------------------------------
        --------------------------------------------*/
        var table = $('.data-table').DataTable({
            language: {
                            "emptyTable": "No role Found. Please create a Role"
                        },
            processing: true,
            serverSide: true,
            ajax: "{{ route('roles.index') }}",
            columns: [
                {data: 'DT_RowIndex', name: 'DT_RowIndex', class: 'text-center'},
                {data: 'name', name: 'name', class: 'text-center'},
                {data: 'action', name: 'action', orderable: true, searchable: true, class: 'text-center'},
            ]
        });
            
        /*------------------------------------------
        --------------------------------------------
        Delete Role Code
        --------------------------------------------
        --------------------------------------------*/
        $('body').on('click', '.deleteRole', function () {
       
        var role_id = $(this).data("id");

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
                    url: "{{ route('roles.store') }}"+'/'+role_id,
                    success: function (data) {
                        table.draw();
                    },
                    error: function (data) {
                        console.log('Error:', data);
                    }
                });
                Swal.fire(
                'Deleted!',
                'Role has been deleted.',
                'success'
                )
            }
        });
    });
         
    });
  </script>
@endsection

