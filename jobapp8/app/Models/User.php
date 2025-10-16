<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'user_type',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var list<string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    /**
     * Check if user is a job seeker
     */
    public function isJobSeeker(): bool
    {
        return $this->user_type === 'job_seeker';
    }

    /**
     * Check if user is an employer
     */
    public function isEmployer(): bool
    {
        return $this->user_type === 'employer';
    }

    /**
     * Check if user is an admin
     */
    public function isAdmin(): bool
    {
        return $this->user_type === 'admin';
    }

    /**
     * Get job postings created by this employer
     */
    public function jobPostings(): HasMany
    {
        return $this->hasMany(JobPosting::class, 'employer_id');
    }

    /**
     * Get job applications made by this job seeker
     */
    public function jobApplications(): HasMany
    {
        return $this->hasMany(JobApplication::class, 'job_seeker_id');
    }
}
