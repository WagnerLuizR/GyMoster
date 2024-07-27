<?php

namespace App\Repositories;

use Illuminate\Support\Facades\DB;

class UsersRepository
{
    public function create($data)
    {
        return DB::table('users')->insertGetId($data);
    }

    public function update($id, $data)
    {
        DB::table('users')->where('id', $id)->update($data);
    }

    public function delete($id)
    {
        DB::table('users')->where('id', $id)->delete();
    }

    public function findById($id)
    {
        return DB::table('users')->where('id', $id)->first();
    }

    public function findAll()
    {
        return DB::table('users')->get();
    }
}
