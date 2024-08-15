<?php

namespace App\Models;

use Backpack\CRUD\app\Models\Traits\CrudTrait;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Attendance extends Model
{
    use CrudTrait;
    use HasFactory;

    protected $table = 'atd_attendance';
    protected $primaryKey = 'id';
    protected $guarded = ['id'];
    protected $fillable = [
        'attendance_date',
        'status',
        'student_id'
    ];

    // protected $hidden = [];
    public function trainings(): BelongsToMany
    {
        return $this->belongsToMany(Training::class);
    }

    public function student(): BelongsTo
    {
        return $this->belongsTo(Student::class, 'student_id');
    }
}
