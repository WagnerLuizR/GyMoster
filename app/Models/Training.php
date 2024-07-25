<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Training extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'description',
    ];

    // Método para criar um novo treino
    public static function createTraining($data)
    {
        return self::create($data);
    }

    // Método para atualizar os dados de um treino
    public function updateTraining($data)
    {
        $this->update($data);
    }

    // Método para excluir um treino
    public function deleteTraining()
    {
        $this->delete();
    }

    // Método para buscar um treino por ID
    public static function findTrainingById($id)
    {
        return self::find($id);
    }
}
