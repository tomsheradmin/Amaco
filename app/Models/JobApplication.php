<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class JobApplication extends Model
{
    protected $fillable = [
        'job_vacancy_id',
        'candidate_name',
        'email',
        'phone',
        'cover_letter',
        'cv_path',
        'cv_original_name',
        'status',
        'admin_notes',
    ];

    public function vacancy(): BelongsTo
    {
        return $this->belongsTo(JobVacancy::class, 'job_vacancy_id');
    }
}
