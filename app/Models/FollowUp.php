<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FollowUp extends Model
{
    use HasFactory;

    protected $fillable = [
        'student_id',
        'dosen_id',
        'note',
    ];

    /**
     * Get the student for this follow-up.
     */
    public function student()
    {
        return $this->belongsTo(Student::class);
    }

    /**
     * Get the dosen who created this follow-up.
     */
    public function dosen()
    {
        return $this->belongsTo(User::class, 'dosen_id');
    }
}
