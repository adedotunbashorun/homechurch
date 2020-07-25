<?php

namespace Modules\Users\Sidebar;


use Maatwebsite\Sidebar\Group;
use Maatwebsite\Sidebar\Item;
use Maatwebsite\Sidebar\Menu;
use Maatwebsite\Sidebar\SidebarExtender as PackageSideBarExtender;
use Modules\Core\Sidebar\BaseSidebarExtender;

class SidebarExtender extends BaseSidebarExtender implements PackageSideBarExtender
{
    public function extendWith(Menu $menu)
    {

        $menu->group(trans('core::global.menus.user'), function (Group $group) {
            //$group->hideHeading();
            $group->weight(80);
            $group->item('Administartors', function (Item $item) {
                $item->weight(18);
                $item->icon('fa fa-user');
                $item->route('admin.users.index');
                $item->authorize($this->auth->hasAccess('users.index'));
            });
            $group->item('Members', function (Item $item) {
                $item->weight(1);
                $item->icon('fa fa-list');
                $item->route('admin.users.members');
                $item->authorize(
                    $this->auth->hasAccess('users.members')
                );
            });
            $group->item('Roles', function (Item $item) {
                $item->weight(20);
                $item->icon('fa fa-user-friends');
                $item->route('admin.users.roles.index');
                $item->authorize($this->auth->hasAccess('users.roles.index'));
            });
        });


        return $menu;
    }
}