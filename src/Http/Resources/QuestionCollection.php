<?php

namespace Module\Training\Http\Resources;

use Module\Training\Models\TrainingQuestion;
use Illuminate\Http\Resources\Json\ResourceCollection;

class QuestionCollection extends ResourceCollection
{
    /**
     * Transform the resource collection into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        return QuestionResource::collection($this->collection);
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
                'combos' => TrainingQuestion::mapCombos($request),

                /** the page data filter */
                'filters' => TrainingQuestion::mapFilters(),

                /** the table header */
                'headers' => TrainingQuestion::mapHeaders($request),

                /** the page icon */
                'icon' => TrainingQuestion::getPageIcon('training-question'),

                /** the record key */
                'key' => TrainingQuestion::getDataKey(),

                /** the page default */
                'recordBase' => TrainingQuestion::mapRecordBase($request),

                /** the page statuses */
                'statuses' => TrainingQuestion::mapStatuses($request),

                /** the page data mode */
                'trashed' => $request->trashed ?: false,

                /** the page title */
                'title' => TrainingQuestion::getPageTitle($request, 'training-question'),

                /** the usetrash flag */
                'usetrash' => TrainingQuestion::hasSoftDeleted(),
            ]
        ];
    }
}
