<?php

namespace Module\Training\Policies;

use Module\System\Models\SystemUser;
use Module\Training\Models\TrainingSetting;
use Illuminate\Auth\Access\Response;

class TrainingSettingPolicy
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
        return $user->hasPermission('view-training-setting');
    }

    /**
     * Determine whether the user can view the model.
     */
    public function show(SystemUser $user, TrainingSetting $trainingSetting): bool
    {
        return $user->hasPermission('show-training-setting');
    }

    /**
     * Determine whether the user can create models.
     */
    public function create(SystemUser $user): bool
    {
        return $user->hasPermission('create-training-setting');
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(SystemUser $user, TrainingSetting $trainingSetting): bool
    {
        return $user->hasPermission('update-training-setting');
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(SystemUser $user, TrainingSetting $trainingSetting): bool
    {
        return $user->hasPermission('delete-training-setting');
    }

    /**
     * Determine whether the user can restore the model.
     */
    public function restore(SystemUser $user, TrainingSetting $trainingSetting): bool
    {
        return $user->hasPermission('restore-training-setting');
    }

    /**
     * Determine whether the user can permanently delete the model.
     */
    public function destroy(SystemUser $user, TrainingSetting $trainingSetting): bool
    {
        return $user->hasPermission('destroy-training-setting');
    }
}
