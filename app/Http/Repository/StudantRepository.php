<?php

namespace App\Repositories;

use Illuminate\Support\Facades\DB;

class StudentRepository
{
    public function create($data)
    {
        return DB::table('std_studant')->insertGetId($data);
    }

    public function update($id, $data)
    {
        DB::table('std_studant')->where('id', $id)->update($data);
    }

    public function delete($id)
    {
        DB::table('std_studant')->where('id', $id)->delete();
    }

    public function findById($id)
    {
        return DB::table('std_studant')->where('id', $id)->first();
    }

    public function findAll()
    {
        return DB::table('std_studant')->get();
    }
}
