<?php

namespace Modules\User\Http\Controllers\Admin;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Routing\Controller;
use Modules\App\Traits\HasCrudActions;
use Modules\User\Entities\Department;
use Modules\User\Http\Requests\SaveDepartmentRequest;
class DepartmentController extends Controller
{
    use HasCrudActions;
    /**
     * Model for the resource.
     *
     * @var string
     */
    protected $model = Department::class;

    /**
     * Label of the resource.
     *
     * @var string
     */
    protected $label = 'user::departments.department';

    /**
     * View path of the resource.
     *
     * @var string
     */
    protected $viewPath = 'user::admin.departments';

    /**
     * Form requests for the resource.
     *
     * @var array|string
     */
    protected $validation = SaveDepartmentRequest::class;
}
