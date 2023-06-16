<?php

namespace App\Http\Controllers\Api\Master;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Role;
use Illuminate\Support\Collection;

use App\Models\User;

class UserController extends Controller
{
    public $searchable = ["name", "email"];

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $data = User::query();

        return $this->sendResponse($this->getListData($data, $request), 'Memuat data berhasil');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $user
     * @return \Illuminate\Http\Response
     */
    public function show(User $user)
    {
        $user->role = $user->roles[0]->name;
        unset($user->roles);

        return $this->sendResponse($user, 'Memuat data berhasil');
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
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }

    public function roleList()
    {
        $roles = \Spatie\Permission\Models\Role::all();
        $data = [];

        foreach ($roles as $key => $value) {
            $data[$key] = collect([
                "role" => $value->name,
                "permissions" => $value->permissions
            ]);
        }

        return $this->sendResponse($data, 'Memuat data berhasil');
    }
}
