<?php

namespace Modules\User\Entities;

use Illuminate\Database\Eloquent\Model;
use Modules\User\Admin\DepartmentTable;
use Modules\App\Entities\AppModel;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\ModelNotFoundException;
class Department extends AppModel
{
    protected $module = 'user';
    protected $fillable = array(
        "lang",
        "parent_id",
        "title",
        "status",
        "created_by",
        "updated_at",
        "created_at" 
    );
    
    public function role() {
        return $this->hasOne('Modules\User\Entities\Role', 'department_id', 'id');
    }

    protected static function boot() {
        parent::boot();
        static::created(function (self $department) {
            $department->created_by = auth()->id();
            if (request()->has('parent_id')) {
                $department->parent_id = $department->id;
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
