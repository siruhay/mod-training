<?php

namespace Module\Training\Events;

use Illuminate\Queue\SerializesModels;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Broadcasting\InteractsWithSockets;

class TrainingSettingUpdate
{
    use Dispatchable;
    use InteractsWithSockets;
    use SerializesModels;

    /**
     * Undocumented function
     *
     * @param Model $model
     * @param array $abilities
     */
    public function __construct(public Model $model, public array $abilities)
    {
    }
}
