<?php

namespace Modules\App\Sidebar;

use Modules\User\Contracts\Authentication;

class BaseSidebarExtender
{
    protected $auth;

    public function __construct()
    {
        $this->auth = '';
    }

    // public function __construct(Authentication $auth)
    // {
    // 	dd(11);
    //     $this->auth = $auth;
    // }
}
