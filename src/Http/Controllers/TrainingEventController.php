<?php

namespace Module\Training\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Gate;
use Module\Training\Models\TrainingEvent;
use Module\Training\Http\Resources\EventCollection;
use Module\Training\Http\Resources\EventShowResource;

class TrainingEventController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        Gate::authorize('view', TrainingEvent::class);

        return new EventCollection(
            TrainingEvent::onlyActive()
                ->applyMode($request->mode)
                ->filter($request->filters)
                ->search($request->findBy)
                ->sortBy($request->sortBy)
                ->paginate($request->itemsPerPage)
        );
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        Gate::authorize('create', TrainingEvent::class);

        $request->validate([]);

        return TrainingEvent::storeRecord($request);
    }

    /**
     * Display the specified resource.
     *
     * @param  \Module\Training\Models\TrainingEvent $trainingEvent
     * @return \Illuminate\Http\Response
     */
    public function show(TrainingEvent $trainingEvent)
    {
        Gate::authorize('show', $trainingEvent);

        return new EventShowResource($trainingEvent);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  \Module\Training\Models\TrainingEvent $trainingEvent
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, TrainingEvent $trainingEvent)
    {
        Gate::authorize('update', $trainingEvent);

        $request->validate([]);

        return TrainingEvent::updateRecord($request, $trainingEvent);
    }

    /**
     * assigned function
     *
     * @param Request $request
     * @param TrainingEvent $trainingEvent
     * @return void
     */
    public function assigned(Request $request, TrainingEvent $trainingEvent)
    {
        Gate::authorize('assigned', $trainingEvent);

        $request->validate([]);

        return TrainingEvent::assignedRecord($request, $trainingEvent);
    }

    /**
     * published function
     *
     * @param Request $request
     * @param TrainingEvent $trainingEvent
     * @return void
     */
    public function published(Request $request, TrainingEvent $trainingEvent)
    {
        Gate::authorize('published', $trainingEvent);

        $request->validate([]);

        return TrainingEvent::publishedRecord($request, $trainingEvent);
    }

    /**
     * rejected function
     *
     * @param Request $request
     * @param TrainingEvent $trainingEvent
     * @return void
     */
    public function rejected(Request $request, TrainingEvent $trainingEvent)
    {
        Gate::authorize('rejected', $trainingEvent);

        $request->validate([]);

        return TrainingEvent::rejectedRecord($request, $trainingEvent);
    }

    /**
     * submission function
     *
     * @param Request $request
     * @param TrainingEvent $trainingEvent
     * @return void
     */
    public function submission(Request $request, TrainingEvent $trainingEvent)
    {
        Gate::authorize('submission', $trainingEvent);

        $request->validate([]);

        return TrainingEvent::submissionRecord($request, $trainingEvent);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \Module\Training\Models\TrainingEvent $trainingEvent
     * @return \Illuminate\Http\Response
     */
    public function destroy(TrainingEvent $trainingEvent)
    {
        Gate::authorize('delete', $trainingEvent);

        return TrainingEvent::deleteRecord($trainingEvent);
    }

    /**
     * Restore the specified resource from soft-delete.
     *
     * @param  \Module\Training\Models\TrainingEvent $trainingEvent
     * @return \Illuminate\Http\Response
     */
    public function restore(TrainingEvent $trainingEvent)
    {
        Gate::authorize('restore', $trainingEvent);

        return TrainingEvent::restoreRecord($trainingEvent);
    }

    /**
     * Force Delete the specified resource from soft-delete.
     *
     * @param  \Module\Training\Models\TrainingEvent $trainingEvent
     * @return \Illuminate\Http\Response
     */
    public function forceDelete(TrainingEvent $trainingEvent)
    {
        Gate::authorize('destroy', $trainingEvent);

        return TrainingEvent::destroyRecord($trainingEvent);
    }
}
