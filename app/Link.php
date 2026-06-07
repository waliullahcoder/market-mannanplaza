<?php

namespace App;

use  File;
use App\Menu;
use App\UserRoles;
use App\MenuAction;
use Illuminate\Support\Facades\Auth;
use Intervention\Image\ImageManagerStatic as Image;

class Link
{
    public static function action($id = null)
    {
        $data_link = "";
        $roleId =  Auth::user()->role;
        $userRoles = UserRoles::where('id',$roleId)->first();

        if ($userRoles)
        {
            $rolePermission = explode(',', $userRoles->action_permission);
            $routeName = \Request::route()->getName();
            $Menus = Menu::where('menu_link',$routeName)->first();
            $MenuAction = MenuAction::orderBy('order_by','ASC')->where('parent_menu_id',@$Menus->id)->where('status',1)->get();
            $data_link = '';

            if (!empty(@$MenuAction)) {
                foreach ($MenuAction as $action) {
                    if (in_array($action->id, @$rolePermission)) {
                        // Edit Option
                        if($action->menu_type == 2){
                            $data_link .= '<a href="'.route($action->action_link,$id).'"> <i class="fas fa-edit text-inverse m-r-10"  data-id="'.$id.'"></i> </a>';
                            }

                        if($action->menu_type == 7){
                        $data_link .= '<a href="javascript:void(0)"  data-id="'.$id.'"> <i class="fa fa-eye text-success m-r-10"></i> </a>';
                        }

                        if($action->menu_type == 8){
                        $data_link .= '<a href="'.route($action->action_link,$id).'" data-id="'.$id.'"> <i class="fa fa-eye text-success m-r-10"></i> </a>';
                        }

                        // Delete Option
                        if($action->menu_type == 4){
                        $data_link .= '<a id="cancel_'.$id.'" href="javascript:void(0)" data-id="'.$id.'"  data-token="{{ csrf_token() }}"> <i class="fa fa-trash text-danger"></i> </a>';
                        }

                        if($action->menu_type == 5){
                        $data_link .= '<a href="'.route($action->action_link,$id).'" onclick="if (confirm(&quot;Are you sure you want to Permission ?&quot;)) { return true; } return false;"> <i class="fa fa-lock text-inverse m-r-10"></i> </a>';
                        }

                        if($action->menu_type == 6){
                        $data_link .= '<a href="'.route($action->action_link,$id).'"> <i class="fas fa-exchange-alt m-r-10"></i> </a>';
                        }

                        if($action->menu_type == 9){
                        $data_link .= '<a href="javascript:void(0)" data-id="'.$id.'"> <i class="fa fa-shopping-bag text-danger m-r-10"></i>
                            </a>';
                        }

                        if($action->menu_type == 10){
                        $data_link .= '<a href="'.route($action->action_link,$id).'" > <i class="fa fa-list text-success m-r-10"></i> </a>';
                        }

                        if($action->menu_type == 11){
                        $data_link .= '<a href="'.route($action->action_link,$id).'" target="_blank"> <i class="fa fa-print text-success m-r-10"></i> </a>';
                        }
                    }
                }
            }
        }

        return $data_link;
    }

    public static function status($id = null,$status = null)
    {
        // echo $id."  ".$status; exit();
        $data_link = "";
        $roleId =  Auth::user()->role;
        $userRoles = UserRoles::where('id',$roleId)->first();
        // dd($userRoles);
        if ($userRoles)
        {
            $rolePermission = explode(',', $userRoles->action_permission);
            $routeName = \Request::route()->getName();
            $Menus = Menu::where('menu_link',$routeName)->first();

            if ($Menus)
            {
                $MenuAction = MenuAction::orderBy('order_by','ASC')->where('parent_menu_id',$Menus->id)->where('menu_type', 3)->where('status',1)->get();
                if (!empty(@$MenuAction))
                {

                    foreach ($MenuAction as $action)
                    {
                        if (in_array($action->id, @$rolePermission))
                        {
                            if($action->menu_type == 3)
                            {
                                if($status == 1)
                                {
                                    $checked = 'checked';
                                }
                                else
                                {
                                    $checked = '';
                                }
                                $data_link .= '<span class="switchery-demo m-b-30" onclick="statusChange('.$id.')">
                                    <input type="checkbox"'.$checked.' class="js-switch" data-color="#00c292" data-switchery="true" style="display: none;" >
                                    </span>';
                                }
                        }
                    }
                }
            }
        }

        // echo $data_link; exit();

        return $data_link;
    }
}
