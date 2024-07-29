<?php

namespace App\Repositories;

use Illuminate\Support\Facades\DB;

class CoachRepository
{
    public function create($data)
    {
        return DB::table('coa_coach')->insertGetId($data);
    }

    public function update($id, $data)
    {
        DB::table('coa_coach')->where('id', $id)->update($data);
    }

    public function delete($id)
    {
        DB::table('coa_coach')->where('id', $id)->delete();
    }

    public function findById($id)
    {
        return DB::table('coa_coach')->where('id', $id)->first();
    }

    public function findAll()
    {
        return DB::table('coa_coach')->get();
    }
}
