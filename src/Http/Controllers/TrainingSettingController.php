<?php

namespace Module\Training\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Gate;
use Module\Training\Models\TrainingSetting;
use Module\Training\Http\Resources\SettingCollection;
use Module\Training\Http\Resources\SettingShowResource;

class TrainingSettingController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        Gate::authorize('view', TrainingSetting::class);

        return new SettingCollection(
            TrainingSetting::applyMode($request->mode)
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
        Gate::authorize('create', TrainingSetting::class);

        $request->validate([]);

        return TrainingSetting::storeRecord($request);
    }

    /**
     * Display the specified resource.
     *
     * @param  \Module\Training\Models\TrainingSetting $trainingSetting
     * @return \Illuminate\Http\Response
     */
    public function show(TrainingSetting $trainingSetting)
    {
        Gate::authorize('show', $trainingSetting);

        return new SettingShowResource($trainingSetting);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  \Module\Training\Models\TrainingSetting $trainingSetting
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, TrainingSetting $trainingSetting)
    {
        Gate::authorize('update', $trainingSetting);

        $request->validate([]);

        return TrainingSetting::updateRecord($request, $trainingSetting);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \Module\Training\Models\TrainingSetting $trainingSetting
     * @return \Illuminate\Http\Response
     */
    public function destroy(TrainingSetting $trainingSetting)
    {
        Gate::authorize('delete', $trainingSetting);

        return TrainingSetting::deleteRecord($trainingSetting);
    }

    /**
     * Restore the specified resource from soft-delete.
     *
     * @param  \Module\Training\Models\TrainingSetting $trainingSetting
     * @return \Illuminate\Http\Response
     */
    public function restore(TrainingSetting $trainingSetting)
    {
        Gate::authorize('restore', $trainingSetting);

        return TrainingSetting::restoreRecord($trainingSetting);
    }

    /**
     * Force Delete the specified resource from soft-delete.
     *
     * @param  \Module\Training\Models\TrainingSetting $trainingSetting
     * @return \Illuminate\Http\Response
     */
    public function forceDelete(TrainingSetting $trainingSetting)
    {
        Gate::authorize('destroy', $trainingSetting);

        return TrainingSetting::destroyRecord($trainingSetting);
    }
}
