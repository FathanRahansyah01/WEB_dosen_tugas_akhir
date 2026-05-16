<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Student extends Model
{
    use HasFactory;

    protected $fillable = [
        'nama',
        'nim',
        'email',
        'password',
        'dosen_id',
    ];

    /**
     * Field yang disembunyikan dari JSON response.
     */
    protected $hidden = [
        'password',
    ];

    /**
     * Auto-hash password saat di-set.
     */
    protected function casts(): array
    {
        return [
            'password' => 'hashed',
        ];
    }

    /**
     * Get the dosen that supervises this student.
     */
    public function dosen()
    {
        return $this->belongsTo(User::class, 'dosen_id');
    }

    /**
     * Get the stress results for this student.
     */
    public function stressResults()
    {
        return $this->hasMany(StressResult::class);
    }

    /**
     * Get the follow-ups for this student.
     */
    public function followUps()
    {
        return $this->hasMany(FollowUp::class);
    }

    /**
     * Get the latest stress result level.
     */
    public function latestStressLevel()
    {
        return $this->stressResults()->latest()->first()?->level ?? 'N/A';
    }
}
