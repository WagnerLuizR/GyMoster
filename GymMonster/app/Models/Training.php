<?php

namespace App\Models;

use Backpack\CRUD\app\Models\Traits\CrudTrait;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Training extends Model
{
    use CrudTrait;
    use HasFactory;

    protected $table = 'tra_training';
    protected $guarded = ['id'];

    protected $fillable = [
        'name',
        'description',
        'difficult_level',
        'duration',
        'type'
    ];

    protected $casts = [
        'id' => 'integer',
    ];

    public function students(): BelongsToMany
    {
        return $this->belongsToMany(Student::class, 'student_training',
            'training_id', 'student_id');
    }

}
