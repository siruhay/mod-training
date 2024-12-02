<?php

namespace Module\Training\Events;

use Illuminate\Queue\SerializesModels;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Broadcasting\InteractsWithSockets;

class TrainingCommitteeUpdate
{
    use Dispatchable;
    use InteractsWithSockets;
    use SerializesModels;

    public function __construct(public Model $model) {}
}
