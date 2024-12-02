<?php

namespace Module\Training\Policies;

use Module\System\Models\SystemUser;
use Module\Training\Models\TrainingOfficial;
use Illuminate\Auth\Access\Response;

class TrainingOfficialPolicy
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
        return $user->hasPermission('view-training-official');
    }

    /**
     * Determine whether the user can view the model.
     */
    public function show(SystemUser $user, TrainingOfficial $trainingOfficial): bool
    {
        return $user->hasPermission('show-training-official');
    }

    /**
     * Determine whether the user can create models.
     */
    public function create(SystemUser $user): bool
    {
        return $user->hasPermission('create-training-official');
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(SystemUser $user, TrainingOfficial $trainingOfficial): bool
    {
        return $user->hasPermission('update-training-official');
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(SystemUser $user, TrainingOfficial $trainingOfficial): bool
    {
        return $user->hasPermission('delete-training-official');
    }

    /**
     * Determine whether the user can restore the model.
     */
    public function restore(SystemUser $user, TrainingOfficial $trainingOfficial): bool
    {
        return $user->hasPermission('restore-training-official');
    }

    /**
     * Determine whether the user can permanently delete the model.
     */
    public function destroy(SystemUser $user, TrainingOfficial $trainingOfficial): bool
    {
        return $user->hasPermission('destroy-training-official');
    }
}
