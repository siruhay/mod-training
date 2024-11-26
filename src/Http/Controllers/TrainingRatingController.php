<?php

namespace Module\Training\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Gate;
use Module\Training\Models\TrainingRating;
use Module\Training\Models\TrainingEvent;
use Module\Training\Http\Resources\RatingCollection;
use Module\Training\Http\Resources\RatingShowResource;

class TrainingRatingController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @param  \Module\Training\Models\TrainingEvent $trainingEvent
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request, TrainingEvent $trainingEvent)
    {
        Gate::authorize('view', TrainingRating::class);

        return new RatingCollection(
            $trainingEvent
                ->ratings()
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
        Gate::authorize('create', TrainingRating::class);

        $request->validate([]);

        return TrainingRating::storeRecord($request, $trainingEvent);
    }

    /**
     * Display the specified resource.
     *
     * @param  \Module\Training\Models\TrainingEvent $trainingEvent
     * @param  \Module\Training\Models\TrainingRating $trainingRating
     * @return \Illuminate\Http\Response
     */
    public function show(TrainingEvent $trainingEvent, TrainingRating $trainingRating)
    {
        Gate::authorize('show', $trainingRating);

        return new RatingShowResource($trainingRating);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  \Module\Training\Models\TrainingEvent $trainingEvent
     * @param  \Module\Training\Models\TrainingRating $trainingRating
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, TrainingEvent $trainingEvent, TrainingRating $trainingRating)
    {
        Gate::authorize('update', $trainingRating);

        $request->validate([]);

        return TrainingRating::updateRecord($request, $trainingRating);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \Module\Training\Models\TrainingEvent $trainingEvent
     * @param  \Module\Training\Models\TrainingRating $trainingRating
     * @return \Illuminate\Http\Response
     */
    public function destroy(TrainingEvent $trainingEvent, TrainingRating $trainingRating)
    {
        Gate::authorize('delete', $trainingRating);

        return TrainingRating::deleteRecord($trainingRating);
    }

    /**
     * Restore the specified resource from soft-delete.
     *
     * @param  \Module\Training\Models\TrainingRating $trainingRating
     * @return \Illuminate\Http\Response
     */
    public function restore(TrainingEvent $trainingEvent, TrainingRating $trainingRating)
    {
        Gate::authorize('restore', $trainingRating);

        return TrainingRating::restoreRecord($trainingRating);
    }

    /**
     * Force Delete the specified resource from soft-delete.
     *
     * @param  \Module\Training\Models\TrainingRating $trainingRating
     * @return \Illuminate\Http\Response
     */
    public function forceDelete(TrainingEvent $trainingEvent, TrainingRating $trainingRating)
    {
        Gate::authorize('destroy', $trainingRating);

        return TrainingRating::destroyRecord($trainingRating);
    }
}