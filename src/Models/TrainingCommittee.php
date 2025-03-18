<?php

namespace Module\Training\Models;

use Illuminate\Http\Request;
use Module\System\Traits\HasMeta;
use Illuminate\Support\Facades\DB;
use Module\System\Models\SystemUser;
use Module\System\Traits\Filterable;
use Module\System\Traits\Searchable;
use Module\System\Traits\HasPageSetup;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;
use Module\Training\Models\TrainingEvent;
use Illuminate\Database\Eloquent\SoftDeletes;
use Module\Training\Events\TrainingCommitteeUpdate;
use Illuminate\Database\Eloquent\Relations\MorphOne;
use Module\Training\Http\Resources\CommitteeResource;

class TrainingCommittee extends Model
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
    protected $table = 'training_committees';

    /**
     * The roles variable
     *
     * @var array
     */
    protected $roles = ['training-committee'];

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
        return [
            'biodatas' => TrainingBiodata::forCombo()
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
            ['title' => 'N.I.K', 'value' => 'slug'],
            ['title' => 'Name', 'value' => 'name'],
            ['title' => 'Type', 'value' => 'type'],
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
            'slug' => $model->slug,
            'type' => $model->type,

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
            'id' => $model->id,
            'slug' => $model->slug,
            'name' => $model->name,
            'type' => $model->type,
        ];
    }

    /**
     * user function
     *
     * @return MorphOne
     */
    public function user(): MorphOne
    {
        return $this->morphOne(SystemUser::class, 'userable');
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
            $name       = is_array($request->name) ? $request->name['title'] : $request->name;
            $slug       = $request->slug;

            if (! $biodata = TrainingBiodata::firstWhere('slug', $slug)) {
                $biodata = new TrainingBiodata();
                $biodata->name = $name;
                $biodata->slug = $slug;
                $biodata->type = $request->type;
                $biodata->save();
            }

            $model->name = $name;
            $model->slug = $slug;
            $model->type = $request->type;
            $model->biodata_id = $biodata->id;

            $parent->committees()->save($model);

            switch ($model->type) {
                case 'MODERATOR':
                    TrainingCommitteeUpdate::dispatch($model, ['training-moderator']);
                    break;

                case 'SPEAKER':
                    TrainingCommitteeUpdate::dispatch($model, ['mytraining-speaker']);
                    break;

                default:
                    TrainingCommitteeUpdate::dispatch($model, ['training-fellow']);
                    break;
            }

            DB::connection($model->connection)->commit();

            return new CommitteeResource($model);
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
        DB::connection($model->connection)->beginTransaction();

        try {
            $name       = is_array($request->name) ? $request->name['title'] : $request->name;
            $slug       = $request->slug;

            if (! $biodata = TrainingBiodata::firstWhere('slug', $slug)) {
                $biodata = new TrainingBiodata();
                $biodata->name = $name;
                $biodata->slug = $slug;
                $biodata->type = $request->type;
                $biodata->save();
            }

            $model->name = $name;
            $model->slug = $slug;
            $model->type = $request->type;
            $model->biodata_id = $biodata->id;
            $model->save();

            switch ($model->type) {
                case 'MODERATOR':
                    TrainingCommitteeUpdate::dispatch($model, ['training-moderator']);
                    break;

                case 'SPEAKER':
                    TrainingCommitteeUpdate::dispatch($model, ['mytraining-speaker']);
                    break;

                default:
                    TrainingCommitteeUpdate::dispatch($model, ['training-fellow']);
                    break;
            }

            DB::connection($model->connection)->commit();

            return new CommitteeResource($model);
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

            return new CommitteeResource($model);
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

            return new CommitteeResource($model);
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

            return new CommitteeResource($model);
        } catch (\Exception $e) {
            DB::connection($model->connection)->rollBack();

            return response()->json([
                'success' => false,
                'message' => $e->getMessage()
            ], 500);
        }
    }
}
