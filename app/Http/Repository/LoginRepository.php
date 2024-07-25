<?php

namespace App\Repositories;

use Illuminate\Support\Facades\DB;

class LoginRepository
{
    public function create($data)
    {
        return DB::table('lgn_login')->insertGetId($data);
    }

    public function update($id, $data)
    {
        DB::table('lgn_login')->where('id', $id)->update($data);
    }

    public function delete($id)
    {
        DB::table('lgn_login')->where('id', $id)->delete();
    }

    public function findById($id)
    {
        return DB::table('lgn_login')->where('id', $id)->first();
    }

    public function findAll()
    {
        return DB::table('lgn_login')->get();
    }
}
