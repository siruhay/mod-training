<?php

namespace Module\Training\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Gate;
use Module\Training\Models\TrainingParticipant;
use Module\Training\Models\TrainingEvent;
use Module\Training\Http\Resources\ParticipantCollection;
use Module\Training\Http\Resources\ParticipantShowResource;

class TrainingParticipantController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @param  \Module\Training\Models\TrainingEvent $trainingEvent
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request, TrainingEvent $trainingEvent)
    {
        Gate::authorize('view', TrainingParticipant::class);

        return new ParticipantCollection(
            $trainingEvent
                ->participants()
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
        Gate::authorize('create', TrainingParticipant::class);

        $request->validate([]);

        return TrainingParticipant::storeRecord($request, $trainingEvent);
    }

    /**
     * Display the specified resource.
     *
     * @param  \Module\Training\Models\TrainingEvent $trainingEvent
     * @param  \Module\Training\Models\TrainingParticipant $trainingParticipant
     * @return \Illuminate\Http\Response
     */
    public function show(TrainingEvent $trainingEvent, TrainingParticipant $trainingParticipant)
    {
        Gate::authorize('show', $trainingParticipant);

        return new ParticipantShowResource($trainingParticipant);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  \Module\Training\Models\TrainingEvent $trainingEvent
     * @param  \Module\Training\Models\TrainingParticipant $trainingParticipant
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, TrainingEvent $trainingEvent, TrainingParticipant $trainingParticipant)
    {
        Gate::authorize('update', $trainingParticipant);

        $request->validate([]);

        return TrainingParticipant::updateRecord($request, $trainingParticipant);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \Module\Training\Models\TrainingEvent $trainingEvent
     * @param  \Module\Training\Models\TrainingParticipant $trainingParticipant
     * @return \Illuminate\Http\Response
     */
    public function destroy(TrainingEvent $trainingEvent, TrainingParticipant $trainingParticipant)
    {
        Gate::authorize('delete', $trainingParticipant);

        return TrainingParticipant::deleteRecord($trainingParticipant);
    }

    /**
     * Restore the specified resource from soft-delete.
     *
     * @param  \Module\Training\Models\TrainingParticipant $trainingParticipant
     * @return \Illuminate\Http\Response
     */
    public function restore(TrainingEvent $trainingEvent, TrainingParticipant $trainingParticipant)
    {
        Gate::authorize('restore', $trainingParticipant);

        return TrainingParticipant::restoreRecord($trainingParticipant);
    }

    /**
     * Force Delete the specified resource from soft-delete.
     *
     * @param  \Module\Training\Models\TrainingParticipant $trainingParticipant
     * @return \Illuminate\Http\Response
     */
    public function forceDelete(TrainingEvent $trainingEvent, TrainingParticipant $trainingParticipant)
    {
        Gate::authorize('destroy', $trainingParticipant);

        return TrainingParticipant::destroyRecord($trainingParticipant);
    }
}