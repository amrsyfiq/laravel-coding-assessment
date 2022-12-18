<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use Illuminate\Support\Facades\Validator;
use Yajra\DataTables\DataTables;

class RoleController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    function __construct()
    {
        $this->middleware('permission:role-list|role-create|role-edit|role-delete', ['only' => ['index', 'store']]);
        $this->middleware('permission:role-create', ['only' => ['create', 'store']]);
        $this->middleware('permission:role-edit', ['only' => ['edit', 'update']]);
        $this->middleware('permission:role-delete', ['only' => ['destroy']]);
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        if ($request->ajax()) {

            $data = Role::latest()->get();

            return DataTables::of($data)
                ->addIndexColumn()
                ->addColumn('action', function ($row) {
                    $btn = ' <a href="/roles/' . $row->id . '" class="btn btn-info"><i class="fa fa-user-circle" aria-hidden="true"></i></a>';
                    $btn = $btn . ' <a href="/roles/' . $row->id . '/edit" class="btn btn-warning"><i class="fa fa-edit" aria-hidden="true"></i></a>';

                    $btn = $btn . ' <a href="javascript:void(0)" data-toggle="tooltip"  data-id="' . $row->id . '" data-original-title="Delete" class="btn btn-danger deleteRole"><i class="fa fa-trash" style="color: #000;"aria-hidden="true"></i></a>';
                    return $btn;
                })
                ->rawColumns(['action'])
                ->make(true);
        }

        return view('roles.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $permissions = Permission::get();
        return view('roles.create', compact('permissions'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|unique:roles,name',
            'permissions' => 'required',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'error' => $validator->errors()->all()
            ]);
        }


        $permissions = $request->permissions;
        $permissions = implode(', ', $permissions);

        //Assign the "mutated" permissions value to $input
        $input['permissions'] = $permissions;
        $input = $request->all();

        $role = Role::create($input);
        $role->syncPermissions($request->permissions);

        return response()->json(['success' => 'Role saved successfully.']);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $role = Role::find($id);
        $rolePermissions = $role->permissions()->get();

        return view('roles.show', compact('role', 'rolePermissions'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $role = Role::find($id);
        $selectedRolePermissions = $role->permissions()->get()->toArray();

        $selectedArray = [[
            'selected' => '',
            'name' => '',
        ]];

        $rolePermissionId = [];
        foreach ($selectedRolePermissions as $key => $rolePermission) {
            $selectedArray[$key]['selected'] = 1;
            $selectedArray[$key]['name'] = $rolePermission['name'];
            array_push($rolePermissionId, $rolePermission['id']);
        }

        $unselectedRolePermissions = Permission::whereNotIn('id', $rolePermissionId)->get();

        $unselectedArray = [[
            'selected' => '',
            'name' => '',
        ]];

        foreach ($unselectedRolePermissions as $key => $rolePermission) {
            $unselectedArray[$key]['selected'] = 0;
            $unselectedArray[$key]['name'] = $rolePermission->name;
        }

        //joined array
        $joinRolePermisison = [[]];

        $joinRolePermisison = (array_merge($selectedArray, $unselectedArray));

        return view('roles.edit', compact('role', 'joinRolePermisison'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|unique:roles,name,' . $id,
            'permissions' => 'required',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'error' => $validator->errors()->all()
            ]);
        }


        $permissions = $request->permissions;
        $permissions = implode(', ', $permissions);

        //Assign the "mutated" permissions value to $input
        $input['permissions'] = $permissions;
        $input = $request->all();

        $role = Role::find($id);
        $role->update($input);
        $role->syncPermissions($request->permissions);

        return response()->json(['success' => 'Role updated successfully.']);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        Role::find($id)->delete();

        return response()->json(['success' => 'Role deleted successfully.']);
    }
}
