<?php

namespace Modules\User\Http\Controllers\Admin;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Routing\Controller;
use Modules\App\Traits\HasCrudActions;
use Modules\User\Entities\Employees;
class EmployeeController extends Controller
{
    use HasCrudActions;
    /**
     * Model for the resource.
     *
     * @var string
     */
    protected $model = Employees::class;

    /**
     * Label of the resource.
     *
     * @var string
     */
    protected $label = 'user::employees.employee';

    /**
     * View path of the resource.
     *
     * @var string
     */
    protected $viewPath = 'user::admin.employees';

    /**
     * Form requests for the resource.
     *
     * @var array|string
     */
    protected $validation = SaveEmployeesRequest::class;
}
