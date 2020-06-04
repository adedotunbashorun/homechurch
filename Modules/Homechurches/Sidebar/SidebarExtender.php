<?php

namespace Modules\Homechurches\Sidebar;


use Maatwebsite\Sidebar\Group;
use Maatwebsite\Sidebar\Item;
use Maatwebsite\Sidebar\Menu;
use Maatwebsite\Sidebar\SidebarExtender as PackageSideBarExtender;
use Modules\Core\Sidebar\BaseSidebarExtender;

class SidebarExtender extends BaseSidebarExtender implements PackageSideBarExtender
{
    public function extendWith(Menu $menu)
    {
        $menu->group(trans('core::global.menus.manage'), function (Group $group)
        {
            $group->item(trans('homechurches::global.name'),function(Item $item){
                $item->weight(config('homechurches.sidebar.weight'));
                $item->item(trans('homechurches::global.name'), function (Item $item) {
                    $item->weight(0);
                    $item->icon(config('homechurches.sidebar.icon'));
                    $item->route('admin.homechurches.index');
                    $item->authorize($this->auth->hasAccess('homechurches.index'));
                });
                $item->item(trans('homechurches::global.sumitted'), function (Item $item) {
                    $item->weight(1);
                    $item->icon('fa fa-list');
                    $item->route('admin.homechurches.submittedHomechurches');
                    $item->authorize(
                        $this->auth->hasAccess('homechurches.submittedHomechurches')
                    );
                });
                $item->item(trans('homechurches::global.hierachy'), function (Item $item) {
                    $item->weight(1);
                    $item->icon('fa fa-cog');
                    $item->route('admin.homechurches.homechurchesHierachy');
                    $item->authorize(
                        $this->auth->hasAccess('homechurches.homechurchesHierachy')
                    );
                });
            });
        });

        return $menu;
    }
}