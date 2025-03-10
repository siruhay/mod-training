<?php

namespace Module\Training\Policies;

use Module\System\Models\SystemUser;
use Module\Training\Models\TrainingEvent;
use Illuminate\Auth\Access\Response;

class TrainingEventPolicy
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
        return $user->hasPermission('view-training-event');
    }

    /**
     * Determine whether the user can view the model.
     */
    public function show(SystemUser $user, TrainingEvent $trainingEvent): bool
    {
        return $user->hasPermission('show-training-event');
    }

    /**
     * Determine whether the user can create models.
     */
    public function create(SystemUser $user): bool
    {
        return $user->hasPermission('create-training-event');
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(SystemUser $user, TrainingEvent $trainingEvent): bool
    {
        return $user->hasPermission('update-training-event');
    }

    /**
     * assigned function
     *
     * @param SystemUser $user
     * @param TrainingEvent $trainingEvent
     * @return boolean
     */
    public function assigned(SystemUser $user, TrainingEvent $trainingEvent): bool
    {
        return
            $user->hasLicenseAs('training-officer') &&
            $trainingEvent->status === 'SUBMITTED' &&
            $user->hasPermission('update-training-event');
    }

    /**
     * published function
     *
     * @param SystemUser $user
     * @param TrainingEvent $trainingEvent
     * @return boolean
     */
    public function published(SystemUser $user, TrainingEvent $trainingEvent): bool
    {
        return
            $user->hasLicenseAs('training-administrator') &&
            $trainingEvent->status === 'ASSIGNED' &&
            $user->hasPermission('update-training-event');
    }

    /**
     * rejected function
     *
     * @param SystemUser $user
     * @param TrainingEvent $trainingEvent
     * @return boolean
     */
    public function rejected(SystemUser $user, TrainingEvent $trainingEvent): bool
    {
        return
            $user->hasLicenseAs('training-officer') &&
            $trainingEvent->status === 'SUBMITTED' &&
            $user->hasPermission('update-training-event');
    }

    /**
     * submission function
     *
     * @param SystemUser $user
     * @param TrainingEvent $trainingEvent
     * @return boolean
     */
    public function submission(SystemUser $user, TrainingEvent $trainingEvent): bool
    {
        return
            $user->hasLicenseAs('training-administrator') &&
            $trainingEvent->status === 'DRAFTED' || $trainingEvent->status === 'REPAIRED' &&
            $user->hasPermission('update-training-event');
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(SystemUser $user, TrainingEvent $trainingEvent): bool
    {
        return $user->hasPermission('delete-training-event');
    }

    /**
     * Determine whether the user can restore the model.
     */
    public function restore(SystemUser $user, TrainingEvent $trainingEvent): bool
    {
        return $user->hasPermission('restore-training-event');
    }

    /**
     * Determine whether the user can permanently delete the model.
     */
    public function destroy(SystemUser $user, TrainingEvent $trainingEvent): bool
    {
        return $user->hasPermission('destroy-training-event');
    }
}
