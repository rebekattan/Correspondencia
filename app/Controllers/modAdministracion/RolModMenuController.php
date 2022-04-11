<?php

namespace App\Controllers\modAdministracion;

use App\Controllers\BaseController;
use App\Models\modAdministracion\RolModel;
use App\Models\modAdministracion\RolModMenuModel;
use App\Models\modAdministracion\MenuSubmenuModel;

class RolModMenuController extends BaseController
{
    //LISTADO DE ROL MODULO MENU
    public function rolModMenu()
    {
        $rolModMenu = new RolModMenuModel();

        $datos = $rolModMenu->getRolMM();
        $modMenu = $rolModMenu->getModMenu();

        $data = [
            "datos" =>$datos,
            "modMenu" =>$modMenu
        ];

        return view('modAdministracion/rolModMenu',$data);
    }



    //FUNCION PARA TRAER EL NOMBRE DEL ROL
    public function obtenerId($rolModuloMenuId)
    {
        $data = ["rolModuloMenuId" => $rolModuloMenuId];
        $rolModMenu = new RolModMenuModel();
        $respuesta = $rolModMenu->obtenerId($data);//fun editar

        $datos = [
            "datos" =>$respuesta
        ];

        return view('modAdministracion/editRolMM', $datos);
    }

}
