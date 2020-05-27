<?php

namespace Modules\User\Entities;

use Illuminate\Database\Eloquent\Model;
use Modules\App\Entities\AppModel;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\ModelNotFoundException;
class Position extends AppModel
{
    protected $module = 'user';
    protected $fillable = array(
        "lang",
        "parent_id",
        "title",
        "created_by",
        "updated_at",
        "created_at"           
    );
    
    public function role() {
        return $this->hasOne('Modules\User\Entities\Role', 'position_id', 'id');
    }

    protected static function boot() {
        parent::boot();
        static::created(function (self $position) {
            $position->created_by = auth()->id();
            if (request()->has('parent_id')) {
                $position->parent_id = $position->id;
            }
        });
        static::addGlobalScope('active', function (Builder $builder) {
            $builder->where('status', 1);
        });
    }

    public function search($request)
    {
        $query = $this->newQuery()->withoutGlobalScopes();
        if(!empty($keyword = array_get(request()->all(), 'keyword'))){
            $query = $query->where('title', 'like', '%'.$keyword.'%');
        }
        return $query;
    }
}
