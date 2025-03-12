<?php

namespace Module\Training\Policies;

use Module\System\Models\SystemUser;
use Module\Training\Models\TrainingBiodata;
use Illuminate\Auth\Access\Response;

class TrainingBiodataPolicy
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
        return $user->hasPermission('view-training-biodata');
    }

    /**
     * Determine whether the user can view the model.
     */
    public function show(SystemUser $user, TrainingBiodata $trainingBiodata): bool
    {
        return $user->hasPermission('show-training-biodata');
    }

    /**
     * Determine whether the user can create models.
     */
    public function create(SystemUser $user): bool
    {
        return $user->hasPermission('create-training-biodata');
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(SystemUser $user, TrainingBiodata $trainingBiodata): bool
    {
        return $user->hasPermission('update-training-biodata');
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(SystemUser $user, TrainingBiodata $trainingBiodata): bool
    {
        return $user->hasPermission('delete-training-biodata');
    }

    /**
     * Determine whether the user can restore the model.
     */
    public function restore(SystemUser $user, TrainingBiodata $trainingBiodata): bool
    {
        return $user->hasPermission('restore-training-biodata');
    }

    /**
     * Determine whether the user can permanently delete the model.
     */
    public function destroy(SystemUser $user, TrainingBiodata $trainingBiodata): bool
    {
        return $user->hasPermission('destroy-training-biodata');
    }
}
