<?php

namespace Module\Training\Policies;

use Module\System\Models\SystemUser;
use Module\Training\Models\TrainingAnswer;
use Illuminate\Auth\Access\Response;

class TrainingAnswerPolicy
{
    /**
    * Perform pre-authorization checks.
    */
    public function before(SystemUser $user, string $ability): bool|null
    {
        if ($user->hasLicenseAs('training-superadmin')) {
            return true;
        }
    
        return null;
    }

    /**
     * Determine whether the user can view any models.
     */
    public function view(SystemUser $user): bool
    {
        return $user->hasPermission('view-training-answer');
    }

    /**
     * Determine whether the user can view the model.
     */
    public function show(SystemUser $user, TrainingAnswer $trainingAnswer): bool
    {
        return $user->hasPermission('show-training-answer');
    }

    /**
     * Determine whether the user can create models.
     */
    public function create(SystemUser $user): bool
    {
        return $user->hasPermission('create-training-answer');
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(SystemUser $user, TrainingAnswer $trainingAnswer): bool
    {
        return $user->hasPermission('update-training-answer');
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(SystemUser $user, TrainingAnswer $trainingAnswer): bool
    {
        return $user->hasPermission('delete-training-answer');
    }

    /**
     * Determine whether the user can restore the model.
     */
    public function restore(SystemUser $user, TrainingAnswer $trainingAnswer): bool
    {
        return $user->hasPermission('restore-training-answer');
    }

    /**
     * Determine whether the user can permanently delete the model.
     */
    public function destroy(SystemUser $user, TrainingAnswer $trainingAnswer): bool
    {
        return $user->hasPermission('destroy-training-answer');
    }
}
