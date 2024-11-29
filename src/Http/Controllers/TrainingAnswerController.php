<?php

namespace Module\Training\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Gate;
use Module\Training\Models\TrainingAnswer;
use Module\Training\Models\TrainingEvent;
use Module\Training\Http\Resources\AnswerCollection;
use Module\Training\Http\Resources\AnswerShowResource;

class TrainingAnswerController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @param  \Module\Training\Models\TrainingEvent $trainingEvent
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request, TrainingEvent $trainingEvent)
    {
        Gate::authorize('view', TrainingAnswer::class);

        return new AnswerCollection(
            $trainingEvent
                ->answers()
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
        Gate::authorize('create', TrainingAnswer::class);

        $request->validate([]);

        return TrainingAnswer::storeRecord($request, $trainingEvent);
    }

    /**
     * Display the specified resource.
     *
     * @param  \Module\Training\Models\TrainingEvent $trainingEvent
     * @param  \Module\Training\Models\TrainingAnswer $trainingAnswer
     * @return \Illuminate\Http\Response
     */
    public function show(TrainingEvent $trainingEvent, TrainingAnswer $trainingAnswer)
    {
        Gate::authorize('show', $trainingAnswer);

        return new AnswerShowResource($trainingAnswer);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  \Module\Training\Models\TrainingEvent $trainingEvent
     * @param  \Module\Training\Models\TrainingAnswer $trainingAnswer
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, TrainingEvent $trainingEvent, TrainingAnswer $trainingAnswer)
    {
        Gate::authorize('update', $trainingAnswer);

        $request->validate([]);

        return TrainingAnswer::updateRecord($request, $trainingAnswer);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \Module\Training\Models\TrainingEvent $trainingEvent
     * @param  \Module\Training\Models\TrainingAnswer $trainingAnswer
     * @return \Illuminate\Http\Response
     */
    public function destroy(TrainingEvent $trainingEvent, TrainingAnswer $trainingAnswer)
    {
        Gate::authorize('delete', $trainingAnswer);

        return TrainingAnswer::deleteRecord($trainingAnswer);
    }

    /**
     * Restore the specified resource from soft-delete.
     *
     * @param  \Module\Training\Models\TrainingAnswer $trainingAnswer
     * @return \Illuminate\Http\Response
     */
    public function restore(TrainingEvent $trainingEvent, TrainingAnswer $trainingAnswer)
    {
        Gate::authorize('restore', $trainingAnswer);

        return TrainingAnswer::restoreRecord($trainingAnswer);
    }

    /**
     * Force Delete the specified resource from soft-delete.
     *
     * @param  \Module\Training\Models\TrainingAnswer $trainingAnswer
     * @return \Illuminate\Http\Response
     */
    public function forceDelete(TrainingEvent $trainingEvent, TrainingAnswer $trainingAnswer)
    {
        Gate::authorize('destroy', $trainingAnswer);

        return TrainingAnswer::destroyRecord($trainingAnswer);
    }
}