<?php

namespace Modules\App\Providers;

use Illuminate\Support\Facades\View;
use Illuminate\Support\ServiceProvider;
use Maatwebsite\Sidebar\SidebarManager;
use Modules\App\Sidebar\AdminSidebar;
use Modules\App\Http\ViewCreators\AdminSidebarCreator;

class SidebarServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot(SidebarManager $manager)
    {
    	$manager->register(AdminSidebar::class);
        View::creator('app::admin.layouts.sidebar', AdminSidebarCreator::class);
    }
}
