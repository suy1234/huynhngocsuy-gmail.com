<?php

namespace Modules\User\Http\Controllers\Admin;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Routing\Controller;
use Modules\App\Traits\HasCrudActions;
use Modules\User\Entities\Role;
use Modules\User\Entities\Department;
use Modules\User\Entities\Position;
use Modules\User\Http\Requests\SaveRoleRequest;
class RoleController extends Controller
{
    use HasCrudActions;
    /**
     * Model for the resource.
     *
     * @var string
     */
    protected $model = Role::class;

    /**
     * Label of the resource.
     *
     * @var string
     */
    protected $label = 'user::roles.role';

    /**
     * View path of the resource.
     *
     * @var string
     */
    protected $viewPath = 'user::admin.roles';

    /**
     * Form requests for the resource.
     *
     * @var array|string
     */
    protected $validation = SaveRoleRequest::class;

    public function getResourceData()
    {
        $data['positions'] = Position::all()->pluck('title', 'id');
        $data['departments'] = Department::all()->pluck('title', 'id');
        return $data;
    }
    
}
