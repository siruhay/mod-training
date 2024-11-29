<?php

namespace Module\Training\Policies;

use Module\System\Models\SystemUser;
use Module\Training\Models\TrainingSubdistrict;
use Illuminate\Auth\Access\Response;

class TrainingSubdistrictPolicy
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
        return $user->hasPermission('view-training-subdistrict');
    }

    /**
     * Determine whether the user can view the model.
     */
    public function show(SystemUser $user, TrainingSubdistrict $trainingSubdistrict): bool
    {
        return $user->hasPermission('show-training-subdistrict');
    }

    /**
     * Determine whether the user can create models.
     */
    public function create(SystemUser $user): bool
    {
        return $user->hasPermission('create-training-subdistrict');
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(SystemUser $user, TrainingSubdistrict $trainingSubdistrict): bool
    {
        return $user->hasPermission('update-training-subdistrict');
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(SystemUser $user, TrainingSubdistrict $trainingSubdistrict): bool
    {
        return $user->hasPermission('delete-training-subdistrict');
    }

    /**
     * Determine whether the user can restore the model.
     */
    public function restore(SystemUser $user, TrainingSubdistrict $trainingSubdistrict): bool
    {
        return $user->hasPermission('restore-training-subdistrict');
    }

    /**
     * Determine whether the user can permanently delete the model.
     */
    public function destroy(SystemUser $user, TrainingSubdistrict $trainingSubdistrict): bool
    {
        return $user->hasPermission('destroy-training-subdistrict');
    }
}
