<?php

namespace Module\Training\Policies;

use Module\System\Models\SystemUser;
use Module\Training\Models\TrainingQuestion;
use Illuminate\Auth\Access\Response;

class TrainingQuestionPolicy
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
        return $user->hasPermission('view-training-question');
    }

    /**
     * Determine whether the user can view the model.
     */
    public function show(SystemUser $user, TrainingQuestion $trainingQuestion): bool
    {
        return $user->hasPermission('show-training-question');
    }

    /**
     * Determine whether the user can create models.
     */
    public function create(SystemUser $user): bool
    {
        return $user->hasPermission('create-training-question');
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(SystemUser $user, TrainingQuestion $trainingQuestion): bool
    {
        return $user->hasPermission('update-training-question');
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(SystemUser $user, TrainingQuestion $trainingQuestion): bool
    {
        return $user->hasPermission('delete-training-question');
    }

    /**
     * Determine whether the user can restore the model.
     */
    public function restore(SystemUser $user, TrainingQuestion $trainingQuestion): bool
    {
        return $user->hasPermission('restore-training-question');
    }

    /**
     * Determine whether the user can permanently delete the model.
     */
    public function destroy(SystemUser $user, TrainingQuestion $trainingQuestion): bool
    {
        return $user->hasPermission('destroy-training-question');
    }
}
