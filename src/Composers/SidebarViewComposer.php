<?php

namespace Codivist\Modules\Customers\Composers;

use Illuminate\Contracts\View\View;
use Illuminate\Support\Facades\Gate;
use Maatwebsite\Sidebar\SidebarGroup;
use Maatwebsite\Sidebar\SidebarItem;

class SidebarViewComposer
{
    public function compose(View $view)
    {
        if (Gate::denies('see-all-customers')) {
            return;
        }
        $view->sidebar->group(__('Customers and roles'), function (SidebarGroup $group) {
            $group->id = 'customers';
            $group->weight = 50;
            $group->addItem(__('Customers'), function (SidebarItem $item) {
                $item->id = 'customers';
                $item->icon = config('typicms.customers.sidebar.icon', 'icon fa fa-fw fa-users');
                $item->weight = config('typicms.customers.sidebar.weight');
                $item->route('admin::index-customers');
                $item->append('admin::create-customer');
            });
        });
    }
}
