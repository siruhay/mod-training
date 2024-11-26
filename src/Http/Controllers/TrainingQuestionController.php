<?php

namespace Module\Training\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Gate;
use Module\Training\Models\TrainingQuestion;
use Module\Training\Models\TrainingEvent;
use Module\Training\Http\Resources\QuestionCollection;
use Module\Training\Http\Resources\QuestionShowResource;

class TrainingQuestionController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @param  \Module\Training\Models\TrainingEvent $trainingEvent
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request, TrainingEvent $trainingEvent)
    {
        Gate::authorize('view', TrainingQuestion::class);

        return new QuestionCollection(
            $trainingEvent
                ->questions()
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
        Gate::authorize('create', TrainingQuestion::class);

        $request->validate([]);

        return TrainingQuestion::storeRecord($request, $trainingEvent);
    }

    /**
     * Display the specified resource.
     *
     * @param  \Module\Training\Models\TrainingEvent $trainingEvent
     * @param  \Module\Training\Models\TrainingQuestion $trainingQuestion
     * @return \Illuminate\Http\Response
     */
    public function show(TrainingEvent $trainingEvent, TrainingQuestion $trainingQuestion)
    {
        Gate::authorize('show', $trainingQuestion);

        return new QuestionShowResource($trainingQuestion);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  \Module\Training\Models\TrainingEvent $trainingEvent
     * @param  \Module\Training\Models\TrainingQuestion $trainingQuestion
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, TrainingEvent $trainingEvent, TrainingQuestion $trainingQuestion)
    {
        Gate::authorize('update', $trainingQuestion);

        $request->validate([]);

        return TrainingQuestion::updateRecord($request, $trainingQuestion);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \Module\Training\Models\TrainingEvent $trainingEvent
     * @param  \Module\Training\Models\TrainingQuestion $trainingQuestion
     * @return \Illuminate\Http\Response
     */
    public function destroy(TrainingEvent $trainingEvent, TrainingQuestion $trainingQuestion)
    {
        Gate::authorize('delete', $trainingQuestion);

        return TrainingQuestion::deleteRecord($trainingQuestion);
    }

    /**
     * Restore the specified resource from soft-delete.
     *
     * @param  \Module\Training\Models\TrainingQuestion $trainingQuestion
     * @return \Illuminate\Http\Response
     */
    public function restore(TrainingEvent $trainingEvent, TrainingQuestion $trainingQuestion)
    {
        Gate::authorize('restore', $trainingQuestion);

        return TrainingQuestion::restoreRecord($trainingQuestion);
    }

    /**
     * Force Delete the specified resource from soft-delete.
     *
     * @param  \Module\Training\Models\TrainingQuestion $trainingQuestion
     * @return \Illuminate\Http\Response
     */
    public function forceDelete(TrainingEvent $trainingEvent, TrainingQuestion $trainingQuestion)
    {
        Gate::authorize('destroy', $trainingQuestion);

        return TrainingQuestion::destroyRecord($trainingQuestion);
    }
}