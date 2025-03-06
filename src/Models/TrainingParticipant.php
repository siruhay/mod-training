<?php

namespace Module\Training\Models;

use Illuminate\Http\Request;
use Module\System\Traits\HasMeta;
use Illuminate\Support\Facades\DB;
use Module\System\Traits\Filterable;
use Module\System\Traits\Searchable;
use Module\System\Traits\HasPageSetup;
use Illuminate\Database\Eloquent\Model;
use Module\Training\Models\TrainingEvent;
use Module\Reference\Models\ReferenceGender;
use Illuminate\Database\Eloquent\SoftDeletes;
use Module\Training\Http\Resources\ParticipantResource;

class TrainingParticipant extends Model
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
    protected $table = 'training_participants';

    /**
     * The roles variable
     *
     * @var array
     */
    protected $roles = ['training-participant'];

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
            'genders' => ReferenceGender::forCombo(),
            'subdistricts' => TrainingSubdistrict::where('regency_id', 3)->forCombo(),
            'villages'      => optional($model)->subdistrict_id ?
                TrainingVillage::where('district_id', $model->subdistrict_id)->forCombo() :
                [],
            'particiables' => optional($model)->village_id ? (
                $model->mode === 'LKD' ?
                TrainingMember::where('village_id', $model->village_id)->forCombo() :
                TrainingOfficial::where('village_id', $model->village_id)->forCombo()
            ) : []
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
        $event = TrainingEvent::find($request->segment(4));

        return [
            'id' => null,
            'name' => null,
            'mode' => $event->mode,
            'particiable' => null,
            'nik' => null,
            'phone' => null,
            'subdistrict_id' => null,
            'village_id' => null,
            'gender_id' => null,
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
            'mode' => $model->mode,
            'nik' => $model->nik,
            'phone' => $model->phone,
            'particiable' => [
                'title' => $model->name,
                'value' => $model->particiable_id
            ],
            'gender_id' => $model->gender_id,
            'subdistrict_id' => $model->subdistrict_id,
            'village_id' => $model->village_id,
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
            $model->name = $request->name;
            $model->slug = sha1($parent->id . '-' . $request->nik);
            $model->mode = $request->mode;
            $model->particiable_type = $request->mode === 'LKD' ? get_class(new TrainingMember()) : get_class(new TrainingOfficial());
            $model->particiable_id = $request->particiable['value'];
            $model->nik = $request->nik;
            $model->phone = $request->phone;
            $model->gender_id = $request->gender_id;
            $model->subdistrict_id = $request->subdistrict_id;
            $model->village_id = $request->village_id;

            $parent->participants()->save($model);

            DB::connection($model->connection)->commit();

            return new ParticipantResource($model);
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
            $model->name = $request->name;
            $model->slug = sha1($parent->id . '-' . $request->nik);
            $model->mode = $request->mode;
            $model->particiable_type = $request->mode === 'LKD' ? get_class(new TrainingMember()) : get_class(new TrainingOfficial());
            $model->particiable_id = $request->particiable['value'];
            $model->nik = $request->nik;
            $model->phone = $request->phone;
            $model->gender_id = $request->gender_id;
            $model->subdistrict_id = $request->subdistrict_id;
            $model->village_id = $request->village_id;
            $model->save();

            DB::connection($model->connection)->commit();

            return new ParticipantResource($model);
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

            return new ParticipantResource($model);
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

            return new ParticipantResource($model);
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

            return new ParticipantResource($model);
        } catch (\Exception $e) {
            DB::connection($model->connection)->rollBack();

            return response()->json([
                'success' => false,
                'message' => $e->getMessage()
            ], 500);
        }
    }
}
