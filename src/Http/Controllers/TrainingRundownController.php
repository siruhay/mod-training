<?php

namespace Module\Training\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Gate;
use Module\Training\Models\TrainingRundown;
use Module\Training\Models\TrainingEvent;
use Module\Training\Http\Resources\RundownCollection;
use Module\Training\Http\Resources\RundownShowResource;

class TrainingRundownController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @param  \Module\Training\Models\TrainingEvent $trainingEvent
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request, TrainingEvent $trainingEvent)
    {
        Gate::authorize('view', TrainingRundown::class);

        return new RundownCollection(
            $trainingEvent
                ->rundowns()
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
        Gate::authorize('create', TrainingRundown::class);

        $request->validate([]);

        return TrainingRundown::storeRecord($request, $trainingEvent);
    }

    /**
     * Display the specified resource.
     *
     * @param  \Module\Training\Models\TrainingEvent $trainingEvent
     * @param  \Module\Training\Models\TrainingRundown $trainingRundown
     * @return \Illuminate\Http\Response
     */
    public function show(TrainingEvent $trainingEvent, TrainingRundown $trainingRundown)
    {
        Gate::authorize('show', $trainingRundown);

        return new RundownShowResource($trainingRundown);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  \Module\Training\Models\TrainingEvent $trainingEvent
     * @param  \Module\Training\Models\TrainingRundown $trainingRundown
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, TrainingEvent $trainingEvent, TrainingRundown $trainingRundown)
    {
        Gate::authorize('update', $trainingRundown);

        $request->validate([]);

        return TrainingRundown::updateRecord($request, $trainingRundown, $trainingEvent);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \Module\Training\Models\TrainingEvent $trainingEvent
     * @param  \Module\Training\Models\TrainingRundown $trainingRundown
     * @return \Illuminate\Http\Response
     */
    public function destroy(TrainingEvent $trainingEvent, TrainingRundown $trainingRundown)
    {
        Gate::authorize('delete', $trainingRundown);

        return TrainingRundown::deleteRecord($trainingRundown);
    }

    /**
     * Restore the specified resource from soft-delete.
     *
     * @param  \Module\Training\Models\TrainingRundown $trainingRundown
     * @return \Illuminate\Http\Response
     */
    public function restore(TrainingEvent $trainingEvent, TrainingRundown $trainingRundown)
    {
        Gate::authorize('restore', $trainingRundown);

        return TrainingRundown::restoreRecord($trainingRundown);
    }

    /**
     * Force Delete the specified resource from soft-delete.
     *
     * @param  \Module\Training\Models\TrainingRundown $trainingRundown
     * @return \Illuminate\Http\Response
     */
    public function forceDelete(TrainingEvent $trainingEvent, TrainingRundown $trainingRundown)
    {
        Gate::authorize('destroy', $trainingRundown);

        return TrainingRundown::destroyRecord($trainingRundown);
    }
}
