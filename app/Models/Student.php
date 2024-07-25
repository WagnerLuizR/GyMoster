<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Student extends Model
{
    use HasFactory;

    protected $fillable = [
        'coa_id',
        'tra_id',
        'nickname',
        'age',
        'height',
        'weight',
        'profile',
    ];

    // Método para criar um novo estudante
    public static function createStudent($data)
    {
        return self::create($data);
    }

    // Método para atualizar os dados de um estudante
    public function updateStudent($data)
    {
        $this->update($data);
    }

    // Método para excluir um estudante
    public function deleteStudent()
    {
        $this->delete();
    }

    // Método para buscar um estudante por ID
    public static function findStudentById($id)
    {
        return self::find($id);
    }
    public function course()
    {
        return $this->belongsTo(Coach::class, 'coa_id');
    }
}
