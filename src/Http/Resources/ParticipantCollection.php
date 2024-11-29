<?php

namespace Module\Training\Http\Resources;

use Module\Training\Models\TrainingParticipant;
use Illuminate\Http\Resources\Json\ResourceCollection;

class ParticipantCollection extends ResourceCollection
{
    /**
     * Transform the resource collection into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        return ParticipantResource::collection($this->collection);
    }

    /**
     * Get additional data that should be returned with the resource array.
     *
     * @param \Illuminate\Http\Request $request
     *
     * @return array
     */
    public function with($request): array
    {
        if ($request->has('initialized')) {
            return [];
        }

        return [
            'setups' => [
                /** the page combo */
                'combos' => TrainingParticipant::mapCombos($request),

                /** the page data filter */
                'filters' => TrainingParticipant::mapFilters(),

                /** the table header */
                'headers' => TrainingParticipant::mapHeaders($request),

                /** the page icon */
                'icon' => TrainingParticipant::getPageIcon('training-participant'),

                /** the record key */
                'key' => TrainingParticipant::getDataKey(),

                /** the page default */
                'recordBase' => TrainingParticipant::mapRecordBase($request),

                /** the page statuses */
                'statuses' => TrainingParticipant::mapStatuses($request),

                /** the page data mode */
                'trashed' => $request->trashed ?: false,

                /** the page title */
                'title' => TrainingParticipant::getPageTitle($request, 'training-participant'),

                /** the usetrash flag */
                'usetrash' => TrainingParticipant::hasSoftDeleted(),
            ]
        ];
    }
}
