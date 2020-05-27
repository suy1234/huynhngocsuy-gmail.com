<?php

namespace Modules\User\Entities;

use Modules\Admin\Ui\AdminTable;
use Modules\User\Repositories\Permission;
use Modules\App\Entities\AppModel;
class Role extends AppModel
{
    protected $fillable = array(
        "department_id",
        "position_id",
        "user_id",
        "permissions",
        "created_by",
        "updated_at",
        "created_at" 
    );
    // protected $casts = [
    //     'permissions' => 'array',
    // ];
    protected static function boot() {
        parent::boot();
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
