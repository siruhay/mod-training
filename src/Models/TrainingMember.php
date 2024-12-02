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
use Module\Training\Http\Resources\MemberResource;

class TrainingMember extends Model
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
    protected $table = 'foundation_members';

    /**
     * The roles variable
     *
     * @var array
     */
    protected $roles = ['training-member'];

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
     * scopeForCombo function
     *
     * @param Builder $query
     * @return void
     */
    public function scopeForCombo(Builder $query)
    {
        return $query
            ->select('name AS title', 'id AS value', 'slug', 'phone', 'gender_id')
            ->get();
    }
}
