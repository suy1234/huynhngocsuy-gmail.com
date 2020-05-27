<?php

namespace Modules\Core\Sidebar;

use Maatwebsite\Sidebar\Item;
use Maatwebsite\Sidebar\Menu;
use Maatwebsite\Sidebar\Group;
use Modules\App\Sidebar\BaseSidebarExtender;

class SidebarExtender extends BaseSidebarExtender
{
    public function extend(Menu $menu)
    {
        // $menu->group(trans('sidebar.content'), function (Group $group) {
        //     $group->item(trans('sidebar.system'), function (Item $item) {
        //         $item->weight(13);
        //         $item->icon('icon-gear');
        //         // $item->authorize(
        //         //     $this->auth->hasAccess('admin.users.index') || $this->auth->hasAccess('roles.index')
        //         // );
        //     });
        // });

    }
}
