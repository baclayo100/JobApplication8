<?php

namespace App\Policies;

use App\Models\User;
use App\Models\JobPosting;

class JobPostingPolicy
{
    /**
     * Determine whether the user can view the job posting.
     */
    public function view(User $user, JobPosting $jobPosting)
    {
        return $user->id === $jobPosting->employer_id;
    }

    /**
     * Determine whether the user can update the job posting.
     */
    public function update(User $user, JobPosting $jobPosting)
    {
        return $user->id === $jobPosting->employer_id;
    }

    /**
     * Determine whether the user can delete the job posting.
     */
    public function delete(User $user, JobPosting $jobPosting)
    {
        return $user->id === $jobPosting->employer_id;
    }
}
