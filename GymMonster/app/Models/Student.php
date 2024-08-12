<?php

namespace App\Models;

use Backpack\CRUD\app\Models\Traits\CrudTrait;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Student extends Model
{
    use CrudTrait;
    use HasFactory;

    protected $table = 'std_student';
    protected $primaryKey = 'id';
    protected $guarded = ['id'];
    protected $fillable = [
        'nickname',
        'age',
        'gender',
        'height',
        'weight',
        'bmi',
        "created_at",
        'updated_at',
    ];

    protected $casts = [
        'id' => 'integer',
    ];

    public function trainings(): BelongsToMany
    {
        return $this->belongsToMany(Training::class);
    }


}
