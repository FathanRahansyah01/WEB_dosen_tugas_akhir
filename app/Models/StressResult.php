<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class StressResult extends Model
{
    use HasFactory;

    protected $fillable = [
        'student_id',
        'level',
    ];

    /**
     * Get the student that owns the stress result.
     */
    public function student()
    {
        return $this->belongsTo(Student::class);
    }
}
