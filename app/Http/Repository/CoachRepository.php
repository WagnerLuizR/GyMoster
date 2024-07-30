<?php

namespace App\Repositories;

use Illuminate\Support\Facades\DB;

class CoachRepository
{
    protected $table = 'coa_coach'; // Especifica a tabela correta

    public function create($data)
    {
        return DB::table($this->table)->insertGetId($data);
    }

    public function update($id, $data)
    {
        DB::table($this->table)->where('id', $id)->update($data);
    }

    public function delete($id)
    {
        DB::table($this->table)->where('id', $id)->delete();
    }

    public function findById($id)
    {
        return DB::table($this->table)->where('id', $id)->first();
    }

    public function findAll()
    {
        return DB::table($this->table)->get();
    }
}
