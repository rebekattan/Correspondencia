<?php

namespace App\Models\modAdministracion;

use CodeIgniter\Model;

class RolModMenuModel extends Model
{
    protected $table = 'co_rol_modulo_menu';
    protected $primaryKey = 'rolModuloMenuId';

    public function getRolMM()
    {
        $rolModMenu = $this->db->query("SELECT rmm.rolModuloMenuId as 'rolModuloMenuId', r.nombreRol as 'rol', m.nombre as 'modulo', me.nombreMenu as 'menu'
                                        FROM co_rol_modulo_menu rmm
                                        INNER JOIN wk_rol r ON rmm.rolId = r.rolId
                                        INNER JOIN co_modulo_menu mm ON rmm.moduloMenuId = mm.moduloMenuId 
                                        INNER JOIN co_modulo m ON mm.moduloId = m.moduloId 
                                        INNER JOIN co_menu me ON mm.menuId = me.menuId
                                        ORDER BY rmm.rolModuloMenuId");
        return $rolModMenu->getResult();
    }

    public function getModMenu()
    {
        $modMenu = $this->db->query("SELECT mm.moduloMenuId as 'moduloMenuId', m.nombre as 'modulo', me.nombreMenu as 'menu'
                                        FROM co_modulo_menu mm
                                        INNER JOIN co_modulo m ON mm.moduloId = m.moduloId 
                                        INNER JOIN co_menu me ON mm.menuId = me.menuId
                                        ORDER BY mm.moduloMenuId");
        return $modMenu->getResult();
    }

    public function obtenerId($data)
    {
        $rol = $this->db->table('co_rol_modulo_menu');
        $rol->where($data);
        return $rol->get()->getResultArray();
    }
}