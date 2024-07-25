<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Coach extends Model
{
    use HasFactory;

    protected $fillable = [
        'nickname',
         'profile',
    ];

    // Método para criar um novo coach
    public static function createCoach($data)
    {
        return self::create($data);
    }

    // Método para atualizar os dados de um coach
    public function updateCoach($data)
    {
        $this->update($data);
    }

    // Método para excluir um coach
    public function deleteCoach()
    {
        $this->delete();
    }

    // Método para buscar um coach por ID
    public static function findCoachById($id)
    {
        return self::find($id);
    }

    // Na classe Coach
    public function students()
    {
        return $this->hasMany(Student::class, 'coa_id');
    }

}
