<?php

namespace App\Http\Middleware;

use Closure;
use App\UserRoles;
use App\Menu;
use App\MenuAction;
use Auth;

class menuPermission
{
    public function handle($request, Closure $next)
    {
        $routeName = \Request::route()->getName();
        $userMenus = Menu::where('menu_link', $routeName)->first();
        $userMenuAction = MenuAction::where('action_link', $routeName)->first();
        $roleId =  Auth::user()->role;
        $userRoles = UserRoles::where('id', $roleId)->first();

        if ($userRoles) {
            $rolePermission = explode(',', $userRoles->permission);
            $actionLinkPermission = explode(',', $userRoles->action_permission);
        }

        if ($userMenus != null) {
            if (in_array($userMenus->id, @$rolePermission)) {
                return $next($request);
            } else {
                return redirect(route('admin.index'));
            }
        } elseif ($userMenuAction != null) {
            if (in_array($userMenuAction->id, @$actionLinkPermission)) {
                return $next($request);
            } else {
                return redirect(route('admin.index'));
            }
        } else {
            return $next($request);
        }
    }
}
