<?php

namespace Module\Training\Policies;

use Module\System\Models\SystemUser;
use Module\Training\Models\TrainingMember;
use Illuminate\Auth\Access\Response;

class TrainingMemberPolicy
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
        return $user->hasPermission('view-training-member');
    }

    /**
     * Determine whether the user can view the model.
     */
    public function show(SystemUser $user, TrainingMember $trainingMember): bool
    {
        return $user->hasPermission('show-training-member');
    }

    /**
     * Determine whether the user can create models.
     */
    public function create(SystemUser $user): bool
    {
        return $user->hasPermission('create-training-member');
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(SystemUser $user, TrainingMember $trainingMember): bool
    {
        return $user->hasPermission('update-training-member');
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(SystemUser $user, TrainingMember $trainingMember): bool
    {
        return $user->hasPermission('delete-training-member');
    }

    /**
     * Determine whether the user can restore the model.
     */
    public function restore(SystemUser $user, TrainingMember $trainingMember): bool
    {
        return $user->hasPermission('restore-training-member');
    }

    /**
     * Determine whether the user can permanently delete the model.
     */
    public function destroy(SystemUser $user, TrainingMember $trainingMember): bool
    {
        return $user->hasPermission('destroy-training-member');
    }
}
