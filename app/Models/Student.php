<?php

namespace App\Models;

use Backpack\CRUD\app\Models\Traits\CrudTrait;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasOne;

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

    public function attendance(): HasOne
    {
        return $this->hasOne(Attendance::class);
    }
}
