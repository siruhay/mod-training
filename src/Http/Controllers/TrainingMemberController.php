<?php

namespace Module\Training\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Gate;
use Module\Training\Models\TrainingMember;
use Module\Training\Http\Resources\MemberCollection;
use Module\Training\Http\Resources\MemberShowResource;

class TrainingMemberController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        Gate::authorize('view', TrainingMember::class);

        return new MemberCollection(
            TrainingMember::applyMode($request->mode)
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
        Gate::authorize('create', TrainingMember::class);

        $request->validate([]);

        return TrainingMember::storeRecord($request);
    }

    /**
     * Display the specified resource.
     *
     * @param  \Module\Training\Models\TrainingMember $trainingMember
     * @return \Illuminate\Http\Response
     */
    public function show(TrainingMember $trainingMember)
    {
        Gate::authorize('show', $trainingMember);

        return new MemberShowResource($trainingMember);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  \Module\Training\Models\TrainingMember $trainingMember
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, TrainingMember $trainingMember)
    {
        Gate::authorize('update', $trainingMember);

        $request->validate([]);

        return TrainingMember::updateRecord($request, $trainingMember);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \Module\Training\Models\TrainingMember $trainingMember
     * @return \Illuminate\Http\Response
     */
    public function destroy(TrainingMember $trainingMember)
    {
        Gate::authorize('delete', $trainingMember);

        return TrainingMember::deleteRecord($trainingMember);
    }

    /**
     * Restore the specified resource from soft-delete.
     *
     * @param  \Module\Training\Models\TrainingMember $trainingMember
     * @return \Illuminate\Http\Response
     */
    public function restore(TrainingMember $trainingMember)
    {
        Gate::authorize('restore', $trainingMember);

        return TrainingMember::restoreRecord($trainingMember);
    }

    /**
     * Force Delete the specified resource from soft-delete.
     *
     * @param  \Module\Training\Models\TrainingMember $trainingMember
     * @return \Illuminate\Http\Response
     */
    public function forceDelete(TrainingMember $trainingMember)
    {
        Gate::authorize('destroy', $trainingMember);

        return TrainingMember::destroyRecord($trainingMember);
    }
}
