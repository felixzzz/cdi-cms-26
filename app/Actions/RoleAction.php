<?php

namespace App\Actions;

use App\Models\Role;
use Illuminate\Http\Request;

class RoleAction
{
    /**
     * Create a new class instance.
     */
    public function __construct()
    {
        //
    }

    public function store(Request $request){
        $data = [
            ...$request->only(['name', 'is_superadmin']),
            ...$this->getRequestPermission()
        ];
        return Role::create($data);
    }

    public function update(Request $request, $ulid){
        $data = [
            ...$request->only(['name', 'is_superadmin']),
            ...$this->getRequestPermission()
        ];
        return Role::whereUlid($ulid)->update($data);
    }


    private function getRequestPermission(){
        $permissions = ["view admin.dashboard"];
        foreach(request('permissions',[]) as $permission){
            array_push($permissions, $permission);
        }
        return  [
            'permissions' => $permissions
        ];
    }

    public function delete($ulid){
        return Role::where('ulid', $ulid)->delete();
    }
}
