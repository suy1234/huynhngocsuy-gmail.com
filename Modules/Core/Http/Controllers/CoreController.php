<?php

namespace Modules\Core\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Routing\Controller;
use Illuminate\Notifications\Messages\SlackMessage;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Support\Facades\Auth;
use Illuminate\Container\Container;

class CoreController extends Controller
{
    protected $lang;
    public function __construct()
    {
        $this->middleware('admin');
        $this->lang = 'vi';
    }
}
