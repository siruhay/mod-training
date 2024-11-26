<?php

namespace Module\Training\Http\Resources;

use Module\Training\Models\TrainingRating;
use Illuminate\Http\Resources\Json\ResourceCollection;

class RatingCollection extends ResourceCollection
{
    /**
     * Transform the resource collection into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        return RatingResource::collection($this->collection);
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
                'combos' => TrainingRating::mapCombos($request),

                /** the page data filter */
                'filters' => TrainingRating::mapFilters(),

                /** the table header */
                'headers' => TrainingRating::mapHeaders($request),

                /** the page icon */
                'icon' => TrainingRating::getPageIcon('training-rating'),

                /** the record key */
                'key' => TrainingRating::getDataKey(),

                /** the page default */
                'recordBase' => TrainingRating::mapRecordBase($request),

                /** the page statuses */
                'statuses' => TrainingRating::mapStatuses($request),

                /** the page data mode */
                'trashed' => $request->trashed ?: false,

                /** the page title */
                'title' => TrainingRating::getPageTitle($request, 'training-rating'),

                /** the usetrash flag */
                'usetrash' => TrainingRating::hasSoftDeleted(),
            ]
        ];
    }
}
