<?php

namespace Module\Training\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Gate;
use Module\Training\Models\TrainingOfficial;
use Module\Training\Http\Resources\OfficialCollection;
use Module\Training\Http\Resources\OfficialShowResource;

class TrainingOfficialController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        Gate::authorize('view', TrainingOfficial::class);

        return new OfficialCollection(
            TrainingOfficial::applyMode($request->mode)
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
        Gate::authorize('create', TrainingOfficial::class);

        $request->validate([]);

        return TrainingOfficial::storeRecord($request);
    }

    /**
     * Display the specified resource.
     *
     * @param  \Module\Training\Models\TrainingOfficial $trainingOfficial
     * @return \Illuminate\Http\Response
     */
    public function show(TrainingOfficial $trainingOfficial)
    {
        Gate::authorize('show', $trainingOfficial);

        return new OfficialShowResource($trainingOfficial);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  \Module\Training\Models\TrainingOfficial $trainingOfficial
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, TrainingOfficial $trainingOfficial)
    {
        Gate::authorize('update', $trainingOfficial);

        $request->validate([]);

        return TrainingOfficial::updateRecord($request, $trainingOfficial);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \Module\Training\Models\TrainingOfficial $trainingOfficial
     * @return \Illuminate\Http\Response
     */
    public function destroy(TrainingOfficial $trainingOfficial)
    {
        Gate::authorize('delete', $trainingOfficial);

        return TrainingOfficial::deleteRecord($trainingOfficial);
    }

    /**
     * Restore the specified resource from soft-delete.
     *
     * @param  \Module\Training\Models\TrainingOfficial $trainingOfficial
     * @return \Illuminate\Http\Response
     */
    public function restore(TrainingOfficial $trainingOfficial)
    {
        Gate::authorize('restore', $trainingOfficial);

        return TrainingOfficial::restoreRecord($trainingOfficial);
    }

    /**
     * Force Delete the specified resource from soft-delete.
     *
     * @param  \Module\Training\Models\TrainingOfficial $trainingOfficial
     * @return \Illuminate\Http\Response
     */
    public function forceDelete(TrainingOfficial $trainingOfficial)
    {
        Gate::authorize('destroy', $trainingOfficial);

        return TrainingOfficial::destroyRecord($trainingOfficial);
    }
}
