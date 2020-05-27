<?php

namespace Modules\User\Http\Controllers\Admin;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Routing\Controller;
use Modules\App\Traits\HasCrudActions;
use Modules\User\Entities\Position;
use Modules\User\Http\Requests\SavePositionRequest;
class PositionController extends Controller
{
    use HasCrudActions;
    /**
     * Model for the resource.
     *
     * @var string
     */
    protected $model = Position::class;

    /**
     * Label of the resource.
     *
     * @var string
     */
    protected $label = 'user::positions.position';

    /**
     * View path of the resource.
     *
     * @var string
     */
    protected $viewPath = 'user::admin.positions';

    /**
     * Form requests for the resource.
     *
     * @var array|string
     */
    protected $validation = SavePositionRequest::class;
}
