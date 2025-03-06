<?php

namespace Module\Training\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Gate;
use Module\Training\Models\TrainingSubdistrict;
use Module\Training\Http\Resources\SubdistrictCollection;
use Module\Training\Http\Resources\SubdistrictShowResource;

class TrainingSubdistrictController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        Gate::authorize('view', TrainingSubdistrict::class);

        return new SubdistrictCollection(
            TrainingSubdistrict::with(['regency'])
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
        Gate::authorize('create', TrainingSubdistrict::class);

        $request->validate([]);

        return TrainingSubdistrict::storeRecord($request);
    }

    /**
     * Display the specified resource.
     *
     * @param  \Module\Training\Models\TrainingSubdistrict $trainingSubdistrict
     * @return \Illuminate\Http\Response
     */
    public function show(TrainingSubdistrict $trainingSubdistrict)
    {
        Gate::authorize('show', $trainingSubdistrict);

        return new SubdistrictShowResource($trainingSubdistrict);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  \Module\Training\Models\TrainingSubdistrict $trainingSubdistrict
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, TrainingSubdistrict $trainingSubdistrict)
    {
        Gate::authorize('update', $trainingSubdistrict);

        $request->validate([]);

        return TrainingSubdistrict::updateRecord($request, $trainingSubdistrict);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \Module\Training\Models\TrainingSubdistrict $trainingSubdistrict
     * @return \Illuminate\Http\Response
     */
    public function destroy(TrainingSubdistrict $trainingSubdistrict)
    {
        Gate::authorize('delete', $trainingSubdistrict);

        return TrainingSubdistrict::deleteRecord($trainingSubdistrict);
    }

    /**
     * Restore the specified resource from soft-delete.
     *
     * @param  \Module\Training\Models\TrainingSubdistrict $trainingSubdistrict
     * @return \Illuminate\Http\Response
     */
    public function restore(TrainingSubdistrict $trainingSubdistrict)
    {
        Gate::authorize('restore', $trainingSubdistrict);

        return TrainingSubdistrict::restoreRecord($trainingSubdistrict);
    }

    /**
     * Force Delete the specified resource from soft-delete.
     *
     * @param  \Module\Training\Models\TrainingSubdistrict $trainingSubdistrict
     * @return \Illuminate\Http\Response
     */
    public function forceDelete(TrainingSubdistrict $trainingSubdistrict)
    {
        Gate::authorize('destroy', $trainingSubdistrict);

        return TrainingSubdistrict::destroyRecord($trainingSubdistrict);
    }

    /**
     * villages function
     *
     * @param TrainingSubdistrict $trainingSubdistrict
     * @return \Illuminate\Http\Response
     */
    public function villages(TrainingSubdistrict $trainingSubdistrict)
    {
        return $trainingSubdistrict->villages()->forCombo();
    }
}
