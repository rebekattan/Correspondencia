<?php namespace App\Controllers\modUsuario;

use CodeIgniter\I18n\Time;
use App\Controllers\BaseController;
use App\Models\modUsuario\UsuarioModel;
use App\Models\modAdministracion\MovimientosModel;

class UsuarioController extends BaseController{

    //LISTAR USUARIO

    public function usuario(){

        $nombreUsuario  = new UsuarioModel();
        $datos          = $nombreUsuario->listarUsuario();
        $persona        = $nombreUsuario->listarPersona();
        $rol            = $nombreUsuario->listarRol();

        $mensaje = session('mensaje');

        $data = [
            "datos"     => $datos,
            "persona"   => $persona,
            "rol"       => $rol,
            "mensaje"   => $mensaje
        ];

        return view('modUsuario/usuario', $data);
        }

    //CREAR USUARIO
    public function crear(){

        $usuario = new UsuarioModel();

        if($this->validate('validarUsuario')){
            $usuario->insertar(
                [
                    "personaId" => $_POST['personaId'],
                    "usuario"   => $_POST['usuario'],
                    "clave"     => $_POST['clave'],
                    "estado"    => $_POST['estado'],
                    "rolId"     => $_POST['rolId']
                ]
            );

            //PARA REGISTRAR EN BITACORA QUIEN CREÓ USUARIO
            $this->bitacora  = new MovimientosModel();
            $hora=new Time('now');
            $session = session('usuario');

            $this->bitacora->save([
                'bitacoraId'    => null,
                'usuario'       => $session,
                'accion'        => 'Agregó usuario',
                'descripcion'   => $_POST['usuario'],
                'hora'          => $hora,
            ]);
         //END

            return redirect()->to(base_url(). '/usuario')->with('mensaje','0');
        }

            return redirect()->to(base_url(). '/usuario')->with('mensaje','1');
    }

    //ELIMINAR USUARIO
    public function eliminar(){

        $usuarioId  = $_POST['usuarioId'];

        $usuario    = new UsuarioModel();

        $data       = ["usuarioId" => $usuarioId];

        $nombreUsuario = $usuario->asArray()->select("usuario")
        ->where("usuarioId", $usuarioId)->first();

        $respuesta = $usuario->eliminar($data);

        if ($respuesta > 0){

            //PARA REGISTRAR EN BITACORA QUIEN ELIMINÓ USUARIO
            $this->bitacora  = new MovimientosModel();
            $hora=new Time('now');
            $session = session('usuario');

            $this->bitacora->save([
                'bitacoraId'    => null,
                'usuario'       => $session,
                'accion'        => 'Eliminó usuario',
                'descripcion'   => $nombreUsuario,
                'hora'          => $hora,
            ]);
            //END

            return redirect()->to(base_url(). '/usuario')->with('mensaje','2');
        } else {
            return redirect()->to(base_url(). '/usuario')->with('mensaje','3');
        }
    }

    //ACTUALIZAR USUARIO
    public function actualizar()
    {
        $usuario = new UsuarioModel();
        if ($this->validate([
            'usuario'        => 'is_unique[wk_usuario.usuario]|alpha_numeric'
            ])) {
                $datos = [
                    "personaId" => $_POST['personaId'],
                    "usuario"   => $_POST['usuario'],
                    "clave"     => $_POST['clave'],
                    "estado"    => $_POST['estado'],
                    "rolId"     => $_POST['rolId']
                ];

            $usuarioId = $_POST['usuarioId'];

            $respuesta = $usuario->actualizar($datos, $usuarioId);

            $datos = ["datos" => $respuesta];

            //PARA REGISTRAR EN BITACORA QUIEN EDITÓ USUARIO
            $this->bitacora  = new MovimientosModel();
            $hora=new Time('now');
            $session = session('usuario');

            $this->bitacora->save([
                'bitacoraId'    => null,
                'usuario'       => $session,
                'accion'        => 'Editó usuario',
                'descripcion'   => $_POST['usuario'],
                'hora'          => $hora,
            ]);
         //END

            return redirect()->to(base_url() . '/usuario')->with('mensaje', '4');

            } else {
                return redirect()->to(base_url() . '/usuario')->with('mensaje', '5');
        }
    }
}

?>