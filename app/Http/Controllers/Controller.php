<?php

namespace App\Http\Controllers;

use App\Menu;
use App\MenuAction;
use Illuminate\Support\Facades\Auth;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;


class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    public function __construct()
    {
        //Link for Add New Button
        view()->composer('*', function ($addLink) {
            $actionLink = 'admin.index';
            $routeName = request()->route()->getName();
            if ($routeName) {
                $userMenus = Menu::where('menu_link', $routeName)->first();
                if ($userMenus) {
                    $userMenuAction = MenuAction::where('parent_menu_id', @$userMenus->id)->where('menu_type', 1)->first();

                    if (@$userMenuAction->action_link) {
                        $actionLink = @$userMenuAction->action_link;
                    }
                }
            }
            $link = 'admin.index';
            $routeName = request()->route()->getName();

            if ($routeName) {
                $userMenuAction = MenuAction::where('action_link', @$routeName)->first();
                if ($userMenuAction) {
                    $userMenu = Menu::where('id', @$userMenuAction->parent_menu_id)->first();
                    if ($userMenu) {
                        $link = $userMenu->menu_link;
                    }
                }
            }

            $addLink->with(['addNewLink' => $actionLink, 'goBackLink' => @$link]);
        });

        // check if user logged in
        // if (Auth::user()) {

        $this->middleware(function ($request, $next) {
            if (Auth::user()) {
                $this->userId = Auth::user()->id;
                $this->userRole = Auth::user()->role;
            }
            return $next($request);
        });
        // }
    }
}
