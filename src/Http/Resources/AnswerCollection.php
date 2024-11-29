<?php

namespace Module\Training\Http\Resources;

use Module\Training\Models\TrainingAnswer;
use Illuminate\Http\Resources\Json\ResourceCollection;

class AnswerCollection extends ResourceCollection
{
    /**
     * Transform the resource collection into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        return AnswerResource::collection($this->collection);
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
                'combos' => TrainingAnswer::mapCombos($request),

                /** the page data filter */
                'filters' => TrainingAnswer::mapFilters(),

                /** the table header */
                'headers' => TrainingAnswer::mapHeaders($request),

                /** the page icon */
                'icon' => TrainingAnswer::getPageIcon('training-answer'),

                /** the record key */
                'key' => TrainingAnswer::getDataKey(),

                /** the page default */
                'recordBase' => TrainingAnswer::mapRecordBase($request),

                /** the page statuses */
                'statuses' => TrainingAnswer::mapStatuses($request),

                /** the page data mode */
                'trashed' => $request->trashed ?: false,

                /** the page title */
                'title' => TrainingAnswer::getPageTitle($request, 'training-answer'),

                /** the usetrash flag */
                'usetrash' => TrainingAnswer::hasSoftDeleted(),
            ]
        ];
    }
}
