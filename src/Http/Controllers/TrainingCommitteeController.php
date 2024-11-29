<?php

namespace Module\Training\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Gate;
use Module\Training\Models\TrainingCommittee;
use Module\Training\Models\TrainingEvent;
use Module\Training\Http\Resources\CommitteeCollection;
use Module\Training\Http\Resources\CommitteeShowResource;

class TrainingCommitteeController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @param  \Module\Training\Models\TrainingEvent $trainingEvent
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request, TrainingEvent $trainingEvent)
    {
        Gate::authorize('view', TrainingCommittee::class);

        return new CommitteeCollection(
            $trainingEvent
                ->committees()
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
        Gate::authorize('create', TrainingCommittee::class);

        $request->validate([]);

        return TrainingCommittee::storeRecord($request, $trainingEvent);
    }

    /**
     * Display the specified resource.
     *
     * @param  \Module\Training\Models\TrainingEvent $trainingEvent
     * @param  \Module\Training\Models\TrainingCommittee $trainingCommittee
     * @return \Illuminate\Http\Response
     */
    public function show(TrainingEvent $trainingEvent, TrainingCommittee $trainingCommittee)
    {
        Gate::authorize('show', $trainingCommittee);

        return new CommitteeShowResource($trainingCommittee);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  \Module\Training\Models\TrainingEvent $trainingEvent
     * @param  \Module\Training\Models\TrainingCommittee $trainingCommittee
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, TrainingEvent $trainingEvent, TrainingCommittee $trainingCommittee)
    {
        Gate::authorize('update', $trainingCommittee);

        $request->validate([]);

        return TrainingCommittee::updateRecord($request, $trainingCommittee);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \Module\Training\Models\TrainingEvent $trainingEvent
     * @param  \Module\Training\Models\TrainingCommittee $trainingCommittee
     * @return \Illuminate\Http\Response
     */
    public function destroy(TrainingEvent $trainingEvent, TrainingCommittee $trainingCommittee)
    {
        Gate::authorize('delete', $trainingCommittee);

        return TrainingCommittee::deleteRecord($trainingCommittee);
    }

    /**
     * Restore the specified resource from soft-delete.
     *
     * @param  \Module\Training\Models\TrainingCommittee $trainingCommittee
     * @return \Illuminate\Http\Response
     */
    public function restore(TrainingEvent $trainingEvent, TrainingCommittee $trainingCommittee)
    {
        Gate::authorize('restore', $trainingCommittee);

        return TrainingCommittee::restoreRecord($trainingCommittee);
    }

    /**
     * Force Delete the specified resource from soft-delete.
     *
     * @param  \Module\Training\Models\TrainingCommittee $trainingCommittee
     * @return \Illuminate\Http\Response
     */
    public function forceDelete(TrainingEvent $trainingEvent, TrainingCommittee $trainingCommittee)
    {
        Gate::authorize('destroy', $trainingCommittee);

        return TrainingCommittee::destroyRecord($trainingCommittee);
    }
}