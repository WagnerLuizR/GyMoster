<?php

namespace App\Repositories;

use Illuminate\Support\Facades\DB;

class TrainingRepository
{
    public function create($data)
    {
        return DB::table('tra_training')->insertGetId($data);
    }

    public function update($id, $data)
    {
        DB::table('tra_training')->where('id', $id)->update($data);
    }

    public function delete($id)
    {
        DB::table('tra_training')->where('id', $id)->delete();
    }

    public function findById($id)
    {
        return DB::table('tra_training')->where('id', $id)->first();
    }

    public function findAll()
    {
        return DB::table('tra_training')->get();
    }
}
