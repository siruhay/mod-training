<?php

namespace Module\Training\Models;

use Illuminate\Http\Request;
use Module\System\Traits\HasMeta;
use Illuminate\Support\Facades\DB;
use Module\System\Traits\Filterable;
use Module\System\Traits\Searchable;
use Module\System\Traits\HasPageSetup;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;
use Module\Training\Http\Resources\EventResource;

class TrainingEvent extends Model
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
    protected $table = 'training_events';

    /**
     * The roles variable
     *
     * @var array
     */
    protected $roles = ['training-event'];

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
    public static function mapCombos(Request $request, $model = null): array
    {
        return [
            'subdistricts'  => TrainingSubdistrict::where('regency_id', 3)->forCombo(),
            'villages'      => optional($model)->subdistrict_id ?
                TrainingVillage::where('district_id', $model->subdistrict_id)->forCombo() :
                []
        ];
    }

    /**
     * mapRecordBase function
     *
     * @param Request $request
     * @return array
     */
    public static function mapRecordBase(Request $request): array
    {
        return [
            'id'                => null,
            'name'              => null,
            'startdate'         => null,
            'finishdate'        => null,
            'village_id'        => null,
            'subdistrict_id'    => null,
            'regency_id'        => null,
            'mode'              => null,
            'status'            => null,
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
            'id'                => $model->id,
            'name'              => $model->name,
            'slug'              => $model->slug,
            'mode'              => $model->mode,
            'startdate'         => $model->startdate,
            'finishdate'        => $model->finishdate,
            'village_id'        => $model->village_id,
            'subdistrict_id'    => $model->subdistrict_id,
            'regency_id'        => $model->regency_id,
            'status'            => $model->status,
        ];
    }

    /**
     * committees function
     *
     * @return HasMany
     */
    public function committees(): HasMany
    {
        return $this->hasMany(TrainingCommittee::class, 'event_id');
    }

    /**
     * participants function
     *
     * @return HasMany
     */
    public function participants(): HasMany
    {
        return $this->hasMany(TrainingParticipant::class, 'event_id');
    }

    /**
     * presences function
     *
     * @return HasMany
     */
    public function presences(): HasMany
    {
        return $this->hasMany(TrainingPresence::class, 'event_id');
    }

    /**
     * rundowns function
     *
     * @return HasMany
     */
    public function rundowns(): HasMany
    {
        return $this->hasMany(TrainingRundown::class, 'event_id');
    }

    /**
     * The model store method
     *
     * @param Request $request
     * @return void
     */
    public static function storeRecord(Request $request)
    {
        $model      = new static();
        $village    = TrainingVillage::find($request->village_id);

        DB::connection($model->connection)->beginTransaction();

        try {
            $model->name = $request->name;
            $model->slug = sha1(now()->toString());
            $model->startdate = $request->startdate;
            $model->finishdate = $request->finishdate;
            $model->village_id = optional($village)->id;
            $model->subdistrict_id = optional($village)->district_id;
            $model->regency_id = optional($village)->regency_id;
            $model->mode = $request->mode;
            $model->status = 'DRAFTED';
            $model->save();

            DB::connection($model->connection)->commit();

            return new EventResource($model);
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
    public static function updateRecord(Request $request, $model)
    {
        $village    = TrainingVillage::find($request->village_id);

        DB::connection($model->connection)->beginTransaction();

        try {
            $model->name = $request->name;
            $model->slug = sha1(now()->toString());
            $model->startdate = $request->startdate;
            $model->finishdate = $request->finishdate;
            $model->village_id = optional($village)->id;
            $model->subdistrict_id = optional($village)->district_id;
            $model->regency_id = optional($village)->regency_id;
            $model->save();

            DB::connection($model->connection)->commit();

            return new EventResource($model);
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

            return new EventResource($model);
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

            return new EventResource($model);
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

            return new EventResource($model);
        } catch (\Exception $e) {
            DB::connection($model->connection)->rollBack();

            return response()->json([
                'success' => false,
                'message' => $e->getMessage()
            ], 500);
        }
    }
}
