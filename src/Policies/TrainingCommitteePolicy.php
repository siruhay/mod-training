<?php

namespace Module\Training\Policies;

use Module\System\Models\SystemUser;
use Module\Training\Models\TrainingCommittee;
use Illuminate\Auth\Access\Response;

class TrainingCommitteePolicy
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
        return $user->hasPermission('view-training-committee');
    }

    /**
     * Determine whether the user can view the model.
     */
    public function show(SystemUser $user, TrainingCommittee $trainingCommittee): bool
    {
        return $user->hasPermission('show-training-committee');
    }

    /**
     * Determine whether the user can create models.
     */
    public function create(SystemUser $user): bool
    {
        return $user->hasPermission('create-training-committee');
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(SystemUser $user, TrainingCommittee $trainingCommittee): bool
    {
        return $user->hasPermission('update-training-committee');
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(SystemUser $user, TrainingCommittee $trainingCommittee): bool
    {
        return $user->hasPermission('delete-training-committee');
    }

    /**
     * Determine whether the user can restore the model.
     */
    public function restore(SystemUser $user, TrainingCommittee $trainingCommittee): bool
    {
        return $user->hasPermission('restore-training-committee');
    }

    /**
     * Determine whether the user can permanently delete the model.
     */
    public function destroy(SystemUser $user, TrainingCommittee $trainingCommittee): bool
    {
        return $user->hasPermission('destroy-training-committee');
    }
}
