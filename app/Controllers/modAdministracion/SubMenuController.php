<?php

namespace App\Controllers\modAdministracion;

use CodeIgniter\I18n\Time;
use App\Controllers\BaseController;
use App\Models\modAdministracion\SubmenuModel;
use App\Models\modAdministracion\MenuSubmenuModel;
use App\Models\modAdministracion\MovimientosModel;

class SubMenuController extends BaseController
{
    //Funcion para MOSTRAR DATOS DE LA TABLA MENU
    public function submenus()
    {
        $submenu = new SubmenuModel();
        $menu = new MenuSubmenuModel();

        $mensaje = session('mensaje');

        $data = [
            "submenu"     => $submenu->select()->asObject()->join('co_menu', 'co_menu.menuId = co_submenu.menuId')->findAll(),
            "menu"     => $menu->select()->asObject()->join('wk_icono', 'wk_icono.iconoId = co_menu.iconoId')->findAll(),
            "mensaje"   => $mensaje
        ];

        return view('modAdministracion/submenus', $data);
    }

    //Funcion para INSERTAR
    public function agregarSubMenu()
    {

        $submenu = new SubmenuModel();

        if ($this->validate('validarsubmenu')) {
            $submenu->crearSubmenu(
                [
                    "nombreSubMenu"     => $_POST['nombreSubMenu'],
                    "menuId"            => $_POST['menuId'],
                    "nombreArchivo"     => $_POST['nombreArchivo']
                ]
            );

            $menu = new MenuSubmenuModel();
            $menuId=$_POST['menuId'];
            $nombreMenu = $menu->asArray()->select("nombreMenu")
            ->where("menuId", $menuId)->first();

            //PARA REGISTRAR EN BITACORA QUIEN CREO SUBMENÚ
            $this->bitacora  = new MovimientosModel();
            $hora=new Time('now');
            $session = session('usuario');

            $this->bitacora->save([
                'bitacoraId'    => null,
                'usuario'       => $session,
                'accion'        => 'Agregó Submenú',
                'descripcion'   => $_POST['nombreSubMenu'],
                'hora'          => $hora,
            ]);
            //END
            return redirect()->to(base_url() . '/submenus')->with('mensaje', '1');
        }

        //Mensaje si el registro esta duplicado
        return redirect()->to(base_url() . '/submenus')->with('mensaje', '0');
    }
    //Funcion para EDITAR
    public function actualizarSubmenu()
    {

        $MenuSubmenu = new SubmenuModel();
        if ($this->validate('validarsubmenu')) {
                $datos = [
                    "nombreSubMenu"     => $_POST['nombreSubMenu'],
                    "menuId"            => $_POST['menuId'],
                    "nombreArchivo"     => $_POST['nombreArchivo']
                ];

            $subMenuId = $_POST['subMenuId'];
            $respuesta = $MenuSubmenu->actualizarSubmenu($datos, $subMenuId);
            $datos = ["datos" => $respuesta];

            return redirect()->to(base_url() . '/submenus')->with('mensaje', '2');

            } else {
                return redirect()->to(base_url() . '/submenus')->with('mensaje', '3');
            } 
    }

    public function eliminar()
    {
        $subMenuId = $_POST['subMenuId'];

        $submenu = new SubmenuModel();

        $data = ["subMenuId" => $subMenuId];

        $respuesta = $submenu->eliminar($data);

        if ($respuesta) {

            $nombreSubMenu = $submenu->asArray()->select("nombreSubMenu")
            ->where("subMenuId", $subMenuId)->first();

            //PARA REGISTRAR EN BITACORA QUIEN ELIMINO EL SUBMENÚ
            $this->bitacora  = new MovimientosModel();
            $hora=new Time('now');
            $session = session('usuario');

            $this->bitacora->save([
                'bitacoraId'    => null,
                'usuario'       => $session,
                'accion'        => 'Eliminó Submenú',
                'descripcion'   => $nombreSubMenu,
                'hora'          => $hora,
            ]);
            //END
            return redirect()->to(base_url() . '/submenus')->with('mensaje', '4');
        } else {
            return redirect()->to(base_url() . '/submenus')->with('mensaje', '5');
        }
    }
}
