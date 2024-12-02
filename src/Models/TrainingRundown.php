<?php

namespace Module\Training\Models;

use Illuminate\Http\Request;
use Module\System\Traits\HasMeta;
use Illuminate\Support\Facades\DB;
use Module\System\Traits\Filterable;
use Module\System\Traits\Searchable;
use Module\System\Traits\HasPageSetup;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Module\Training\Models\TrainingEvent;
use Module\Training\Http\Resources\RundownResource;

class TrainingRundown extends Model
{
    use Filterable;
    use HasMeta;
    use HasPageSetup;
    use Searchable;
    use SoftDeletes;

    /**
     * The connection name for the model.
     *
     * @var string|null
     */
    protected $connection = 'platform';

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'training_rundowns';

    /**
     * The roles variable
     *
     * @var array
     */
    protected $roles = ['training-rundown'];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'meta' => 'array'
    ];

    /**
     * The default key for the order.
     *
     * @var string
     */
    protected $defaultOrder = 'name';

    /**
     * mapCombos function
     *
     * @param Request $request
     * @return array
     */
    public static function mapCombos(Request $request): array
    {
        $event = TrainingEvent::find($request->segment(4));

        return [
            'speakers' => $event->committees()->where('type', 'SPEAKER')->forCombo()
        ];
    }

    /**
     * mapResourceShow function
     *
     * @param Request $request
     * @return array
     */
    public static function mapResourceShow(Request $request, $model): array
    {
        return [
            'id' => $model->id,
            'name' => $model->name,
            'slug' => $model->slug,
            'datemark' => $model->datemark,
            'starttime' => $model->starttime,
            'finishtime' => $model->finishtime,
            'agenda' => $model->agenda,
            'speaker_id' => $model->speaker_id,
        ];
    }

    /**
     * The model store method
     *
     * @param Request $request
     * @return void
     */
    public static function storeRecord(Request $request, TrainingEvent $parent)
    {
        $model = new static();

        DB::connection($model->connection)->beginTransaction();

        try {
            $model->name = $request->starttime . ' - ' . $request->finishtime;
            $model->slug = sha1($parent->id . '-' . $request->datemark . '-' . $model->name);
            $model->datemark = $request->datemark;
            $model->starttime = $request->starttime;
            $model->finishtime = $request->finishtime;
            $model->agenda = $request->agenda;
            $model->speaker_id = $request->speaker_id;
            $parent->rundowns()->save($model);

            DB::connection($model->connection)->commit();

            return new RundownResource($model);
        } catch (\Exception $e) {
            DB::connection($model->connection)->rollBack();

            return response()->json([
                'success' => false,
                'message' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * The model update method
     *
     * @param Request $request
     * @param [type] $model
     * @return void
     */
    public static function updateRecord(Request $request, $model, $parent)
    {
        DB::connection($model->connection)->beginTransaction();

        try {
            $model->name = $request->starttime . ' - ' . $request->finishtime;
            $model->slug = sha1($parent->id . '-' . $request->datemark . '-' . $model->name);
            $model->datemark = $request->datemark;
            $model->starttime = $request->starttime;
            $model->finishtime = $request->finishtime;
            $model->agenda = $request->agenda;
            $model->speaker_id = $request->speaker_id;
            $model->save();

            DB::connection($model->connection)->commit();

            return new RundownResource($model);
        } catch (\Exception $e) {
            DB::connection($model->connection)->rollBack();

            return response()->json([
                'success' => false,
                'message' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * The model delete method
     *
     * @param [type] $model
     * @return void
     */
    public static function deleteRecord($model)
    {
        DB::connection($model->connection)->beginTransaction();

        try {
            $model->delete();

            DB::connection($model->connection)->commit();

            return new RundownResource($model);
        } catch (\Exception $e) {
            DB::connection($model->connection)->rollBack();

            return response()->json([
                'success' => false,
                'message' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * The model restore method
     *
     * @param [type] $model
     * @return void
     */
    public static function restoreRecord($model)
    {
        DB::connection($model->connection)->beginTransaction();

        try {
            $model->restore();

            DB::connection($model->connection)->commit();

            return new RundownResource($model);
        } catch (\Exception $e) {
            DB::connection($model->connection)->rollBack();

            return response()->json([
                'success' => false,
                'message' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * The model destroy method
     *
     * @param [type] $model
     * @return void
     */
    public static function destroyRecord($model)
    {
        DB::connection($model->connection)->beginTransaction();

        try {
            $model->forceDelete();

            DB::connection($model->connection)->commit();

            return new RundownResource($model);
        } catch (\Exception $e) {
            DB::connection($model->connection)->rollBack();

            return response()->json([
                'success' => false,
                'message' => $e->getMessage()
            ], 500);
        }
    }
}
