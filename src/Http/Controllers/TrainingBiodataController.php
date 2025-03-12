<?php

namespace Module\Training\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Gate;
use Module\Training\Models\TrainingBiodata;
use Module\Training\Http\Resources\BiodataCollection;
use Module\Training\Http\Resources\BiodataShowResource;

class TrainingBiodataController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        Gate::authorize('view', TrainingBiodata::class);

        return new BiodataCollection(
            TrainingBiodata::applyMode($request->mode)
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
        Gate::authorize('create', TrainingBiodata::class);

        $request->validate([]);

        return TrainingBiodata::storeRecord($request);
    }

    /**
     * Display the specified resource.
     *
     * @param  \Module\Training\Models\TrainingBiodata $trainingBiodata
     * @return \Illuminate\Http\Response
     */
    public function show(TrainingBiodata $trainingBiodata)
    {
        Gate::authorize('show', $trainingBiodata);

        return new BiodataShowResource($trainingBiodata);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  \Module\Training\Models\TrainingBiodata $trainingBiodata
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, TrainingBiodata $trainingBiodata)
    {
        Gate::authorize('update', $trainingBiodata);

        $request->validate([]);

        return TrainingBiodata::updateRecord($request, $trainingBiodata);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \Module\Training\Models\TrainingBiodata $trainingBiodata
     * @return \Illuminate\Http\Response
     */
    public function destroy(TrainingBiodata $trainingBiodata)
    {
        Gate::authorize('delete', $trainingBiodata);

        return TrainingBiodata::deleteRecord($trainingBiodata);
    }

    /**
     * Restore the specified resource from soft-delete.
     *
     * @param  \Module\Training\Models\TrainingBiodata $trainingBiodata
     * @return \Illuminate\Http\Response
     */
    public function restore(TrainingBiodata $trainingBiodata)
    {
        Gate::authorize('restore', $trainingBiodata);

        return TrainingBiodata::restoreRecord($trainingBiodata);
    }

    /**
     * Force Delete the specified resource from soft-delete.
     *
     * @param  \Module\Training\Models\TrainingBiodata $trainingBiodata
     * @return \Illuminate\Http\Response
     */
    public function forceDelete(TrainingBiodata $trainingBiodata)
    {
        Gate::authorize('destroy', $trainingBiodata);

        return TrainingBiodata::destroyRecord($trainingBiodata);
    }
}
