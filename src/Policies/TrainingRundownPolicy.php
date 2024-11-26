<?php

namespace Module\Training\Policies;

use Module\System\Models\SystemUser;
use Module\Training\Models\TrainingRundown;
use Illuminate\Auth\Access\Response;

class TrainingRundownPolicy
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
        return $user->hasPermission('view-training-rundown');
    }

    /**
     * Determine whether the user can view the model.
     */
    public function show(SystemUser $user, TrainingRundown $trainingRundown): bool
    {
        return $user->hasPermission('show-training-rundown');
    }

    /**
     * Determine whether the user can create models.
     */
    public function create(SystemUser $user): bool
    {
        return $user->hasPermission('create-training-rundown');
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(SystemUser $user, TrainingRundown $trainingRundown): bool
    {
        return $user->hasPermission('update-training-rundown');
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(SystemUser $user, TrainingRundown $trainingRundown): bool
    {
        return $user->hasPermission('delete-training-rundown');
    }

    /**
     * Determine whether the user can restore the model.
     */
    public function restore(SystemUser $user, TrainingRundown $trainingRundown): bool
    {
        return $user->hasPermission('restore-training-rundown');
    }

    /**
     * Determine whether the user can permanently delete the model.
     */
    public function destroy(SystemUser $user, TrainingRundown $trainingRundown): bool
    {
        return $user->hasPermission('destroy-training-rundown');
    }
}
