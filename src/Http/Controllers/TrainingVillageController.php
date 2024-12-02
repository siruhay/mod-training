<?php

namespace Module\Training\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Gate;
use Module\Training\Models\TrainingMember;
use Module\Training\Models\TrainingVillage;
use Module\Training\Models\TrainingOfficial;
use Module\Training\Models\TrainingSubdistrict;
use Module\Training\Http\Resources\VillageCollection;
use Module\Training\Http\Resources\VillageShowResource;

class TrainingVillageController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @param  \Module\Training\Models\TrainingSubdistrict $trainingSubdistrict
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request, TrainingSubdistrict $trainingSubdistrict)
    {
        Gate::authorize('view', TrainingVillage::class);

        return new VillageCollection(
            $trainingSubdistrict
                ->villages()
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
     * @param  \Module\Training\Models\TrainingSubdistrict $trainingSubdistrict
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request, TrainingSubdistrict $trainingSubdistrict)
    {
        Gate::authorize('create', TrainingVillage::class);

        $request->validate([]);

        return TrainingVillage::storeRecord($request, $trainingSubdistrict);
    }

    /**
     * Display the specified resource.
     *
     * @param  \Module\Training\Models\TrainingSubdistrict $trainingSubdistrict
     * @param  \Module\Training\Models\TrainingVillage $trainingVillage
     * @return \Illuminate\Http\Response
     */
    public function show(TrainingSubdistrict $trainingSubdistrict, TrainingVillage $trainingVillage)
    {
        Gate::authorize('show', $trainingVillage);

        return new VillageShowResource($trainingVillage);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  \Module\Training\Models\TrainingSubdistrict $trainingSubdistrict
     * @param  \Module\Training\Models\TrainingVillage $trainingVillage
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, TrainingSubdistrict $trainingSubdistrict, TrainingVillage $trainingVillage)
    {
        Gate::authorize('update', $trainingVillage);

        $request->validate([]);

        return TrainingVillage::updateRecord($request, $trainingVillage);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \Module\Training\Models\TrainingSubdistrict $trainingSubdistrict
     * @param  \Module\Training\Models\TrainingVillage $trainingVillage
     * @return \Illuminate\Http\Response
     */
    public function destroy(TrainingSubdistrict $trainingSubdistrict, TrainingVillage $trainingVillage)
    {
        Gate::authorize('delete', $trainingVillage);

        return TrainingVillage::deleteRecord($trainingVillage);
    }

    /**
     * Restore the specified resource from soft-delete.
     *
     * @param  \Module\Training\Models\TrainingVillage $trainingVillage
     * @return \Illuminate\Http\Response
     */
    public function restore(TrainingSubdistrict $trainingSubdistrict, TrainingVillage $trainingVillage)
    {
        Gate::authorize('restore', $trainingVillage);

        return TrainingVillage::restoreRecord($trainingVillage);
    }

    /**
     * Force Delete the specified resource from soft-delete.
     *
     * @param  \Module\Training\Models\TrainingVillage $trainingVillage
     * @return \Illuminate\Http\Response
     */
    public function forceDelete(TrainingSubdistrict $trainingSubdistrict, TrainingVillage $trainingVillage)
    {
        Gate::authorize('destroy', $trainingVillage);

        return TrainingVillage::destroyRecord($trainingVillage);
    }

    /**
     * particiables function
     *
     * @param TrainingVillage $trainingVillage
     * @param Request $request
     * @return void
     */
    public function particiables(TrainingVillage $trainingVillage, Request $request)
    {
        if ($request->mode === 'LKD') {
            return TrainingMember::where('village_id', $trainingVillage->id)->forCombo();
        }

        return TrainingOfficial::where('village_id', $trainingVillage->id)->forCombo();
    }
}
