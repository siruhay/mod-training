<?php

namespace Module\Training\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Gate;
use Module\Training\Models\TrainingPresence;
use Module\Training\Models\TrainingEvent;
use Module\Training\Http\Resources\PresenceCollection;
use Module\Training\Http\Resources\PresenceShowResource;

class TrainingPresenceController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @param  \Module\Training\Models\TrainingEvent $trainingEvent
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request, TrainingEvent $trainingEvent)
    {
        Gate::authorize('view', TrainingPresence::class);

        return new PresenceCollection(
            $trainingEvent
                ->presences()
                ->applyMode($request->mode)
                ->filter($request->filters)
                ->search($request->findBy)
                ->sortBy($request->sortBy, $request->sortDesc)
                ->paginate($request->itemsPerPage)
        );
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  \Module\Training\Models\TrainingEvent $trainingEvent
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request, TrainingEvent $trainingEvent)
    {
        Gate::authorize('create', TrainingPresence::class);

        $request->validate([]);

        return TrainingPresence::storeRecord($request, $trainingEvent);
    }

    /**
     * Display the specified resource.
     *
     * @param  \Module\Training\Models\TrainingEvent $trainingEvent
     * @param  \Module\Training\Models\TrainingPresence $trainingPresence
     * @return \Illuminate\Http\Response
     */
    public function show(TrainingEvent $trainingEvent, TrainingPresence $trainingPresence)
    {
        Gate::authorize('show', $trainingPresence);

        return new PresenceShowResource($trainingPresence);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  \Module\Training\Models\TrainingEvent $trainingEvent
     * @param  \Module\Training\Models\TrainingPresence $trainingPresence
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, TrainingEvent $trainingEvent, TrainingPresence $trainingPresence)
    {
        Gate::authorize('update', $trainingPresence);

        $request->validate([]);

        return TrainingPresence::updateRecord($request, $trainingPresence);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \Module\Training\Models\TrainingEvent $trainingEvent
     * @param  \Module\Training\Models\TrainingPresence $trainingPresence
     * @return \Illuminate\Http\Response
     */
    public function destroy(TrainingEvent $trainingEvent, TrainingPresence $trainingPresence)
    {
        Gate::authorize('delete', $trainingPresence);

        return TrainingPresence::deleteRecord($trainingPresence);
    }

    /**
     * Restore the specified resource from soft-delete.
     *
     * @param  \Module\Training\Models\TrainingPresence $trainingPresence
     * @return \Illuminate\Http\Response
     */
    public function restore(TrainingEvent $trainingEvent, TrainingPresence $trainingPresence)
    {
        Gate::authorize('restore', $trainingPresence);

        return TrainingPresence::restoreRecord($trainingPresence);
    }

    /**
     * Force Delete the specified resource from soft-delete.
     *
     * @param  \Module\Training\Models\TrainingPresence $trainingPresence
     * @return \Illuminate\Http\Response
     */
    public function forceDelete(TrainingEvent $trainingEvent, TrainingPresence $trainingPresence)
    {
        Gate::authorize('destroy', $trainingPresence);

        return TrainingPresence::destroyRecord($trainingPresence);
    }
}