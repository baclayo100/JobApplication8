<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class JobPosting extends Model
{
    use HasFactory;

    protected $fillable = [
        'employer_id',
        'title',
        'description',
        'company',
        'company_logo',
        'location',
        'salary_range',
        'employment_type',
        'experience_level',
        'required_skills',
        'benefits',
        'is_active',
        'application_deadline',
    ];

    protected $casts = [
        'required_skills' => 'array',
        'benefits' => 'array',
        'application_deadline' => 'datetime',
    ];

    /**
     * Get the employer that owns the job posting
     */
    public function employer(): BelongsTo
    {
        return $this->belongsTo(User::class, 'employer_id');
    }

    /**
     * Get the applications for this job posting
     */
    public function applications(): HasMany
    {
        return $this->hasMany(JobApplication::class);
    }

    /**
     * Scope to get only active job postings
     */
    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }
}
