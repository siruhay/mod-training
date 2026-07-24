<?php

namespace Module\Training\Models;

use Illuminate\Http\Request;
use Module\System\Traits\HasMeta;
use Illuminate\Support\Facades\DB;
use Module\System\Traits\Filterable;
use Module\System\Traits\Searchable;
use Module\System\Traits\HasPageSetup;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Module\Training\Http\Resources\EventResource;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Module\Training\Database\Factories\TrainingEventFactory;

class TrainingEvent extends Model
{
    use Filterable;
    use HasFactory;
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
        'meta' => 'array',
        'startdate' => 'date:Y-m-d',
        'finishdate' => 'date:Y-m-d'
    ];

    /**
     * The default key for the order.
     *
     * @var string
     */
    protected $defaultOrder = 'name';

    protected static function newFactory(): TrainingEventFactory
    {
        return TrainingEventFactory::new();
    }

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
     * mapStatuses function
     *
     * @param Request $request
     * @return array
     */
    public static function mapStatuses(Request $request, $model = null): array
    {
        return [
            'canCreate' => $request->user()->hasLicenseAs('training-administrator'),
            'canEdit' => true,
            'canUpdate' => true,
            'canDelete' => $request->user()->hasLicenseAs('training-administrator') && optional($model)->status === 'DRAFTED',
            'canRestore' => false,
            'canDestroy' => false,

            'isAdministrator' => $request->user()->hasLicenseAs('training-administrator'),
            'isOfficer' => $request->user()->hasLicenseAs('training-officer')
        ];
    }

    /**
     * mapHeaders function
     *
     * readonly value?: SelectItemKey<any>
     * readonly title?: string | undefined
     * readonly align?: 'start' | 'end' | 'center' | undefined
     * readonly width?: string | number | undefined
     * readonly minWidth?: string | undefined
     * readonly maxWidth?: string | undefined
     * readonly nowrap?: boolean | undefined
     * readonly sortable?: boolean | undefined
     *
     * @param Request $request
     * @return array
     */
    public static function mapHeaders(Request $request): array
    {
        return [
            ['title' => 'Name', 'value' => 'name'],
            ['title' => 'Status', 'value' => 'status'],
            ['title' => 'Updated', 'value' => 'updated_at', 'sortable' => false, 'width' => '170'],
        ];
    }

    /**
     * mapResource function
     *
     * @param Request $request
     * @return array
     */
    public static function mapResource(Request $request, $model): array
    {
        return [
            'id' => $model->id,
            'name' => $model->name,
            'status' => $model->status,

            'subtitle' => (string) $model->updated_at,
            'updated_at' => (string) $model->updated_at,
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
            'startdate'         => optional($model->startdate)->format('d/m/Y'),
            'finishdate'        => optional($model->finishdate)->format('d/m/Y'),
            'village_id'        => $model->village_id,
            'subdistrict_id'    => $model->subdistrict_id,
            'regency_id'        => $model->regency_id,
            'status'            => $model->status,
            'hasCommittee'      => $model->committees->count() > 0,
            'hasParticipant'    => $model->participants->count() > 0,
            'hasRundown'        => $model->rundowns->count() > 0
        ];
    }

    /**
     * Undocumented function
     *
     * @param Builder $query
     * @return void
     */
    public function scopeOnlyActive(Builder $query)
    {
        return $query->whereNotIn('status', ['REJECTED', 'COMPLETED']);
    }

    /**
     * Undocumented function
     *
     * @param Builder $query
     * @return void
     */
    public function scopeOnlyHistory(Builder $query)
    {
        return $query->whereIn('status', ['REJECTED', 'COMPLETED']);
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
     * subdistrict function
     *
     * @return BelongsTo
     */
    public function subdistrict(): BelongsTo
    {
        return $this->belongsTo(TrainingSubdistrict::class, 'subdistrict_id');
    }

    /**
     * village function
     *
     * @return BelongsTo
     */
    public function village(): BelongsTo
    {
        return $this->belongsTo(TrainingVillage::class, 'village_id');
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
     * assignedRecord function
     *
     * @param Request $request
     * @param [type] $model
     * @return void
     */
    public static function assignedRecord(Request $request, $model)
    {
        DB::connection($model->connection)->beginTransaction();

        try {
            $model->status = 'ASSIGNED';
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
     * completedRecord function
     *
     * @param Request $request
     * @param [type] $model
     * @return void
     */
    public static function completedRecord(Request $request, $model)
    {
        DB::connection($model->connection)->beginTransaction();

        try {
            $model->status = 'COMPLETED';
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
     * publishedRecord function
     *
     * @param Request $request
     * @param [type] $model
     * @return void
     */
    public static function publishedRecord(Request $request, $model)
    {
        DB::connection($model->connection)->beginTransaction();

        try {
            $model->status = 'PUBLISHED';
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
     * rejectedRecord function
     *
     * @param Request $request
     * @param [type] $model
     * @return void
     */
    public static function rejectedRecord(Request $request, $model)
    {
        DB::connection($model->connection)->beginTransaction();

        try {
            $model->status = 'REJECTED';
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
     * submissionRecord function
     *
     * @param Request $request
     * @param [type] $model
     * @return void
     */
    public static function submissionRecord(Request $request, $model)
    {
        DB::connection($model->connection)->beginTransaction();

        try {
            $model->status = 'SUBMITTED';
            $model->save();

            /** GENERATE SURAT KETERANGAN */

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
