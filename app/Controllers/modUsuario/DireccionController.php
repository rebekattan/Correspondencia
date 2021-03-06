<?php namespace App\Controllers\modUsuario;

use CodeIgniter\I18n\Time;
use App\Controllers\BaseController;
use App\Models\modUsuario\DireccionModel;
use App\Models\modAdministracion\MovimientosModel;

class DireccionController extends BaseController{

    //LISTAR DIRECCION

    public function direccion(){

        $direccion      = new DireccionModel();
        $datos          = $direccion->listarDireccion();
        $persona        = $direccion->listarPersona();
        $departamento   = $direccion->listarDepartamento();
        $municipio      = $direccion->listarMunicipioA();


        $mensaje = session('mensaje');

        $data = [
            "datos"         => $datos,
            "persona"       => $persona,
            "municipioA"    => $municipio,
            "departamento"  => $departamento,
            "mensaje"       => $mensaje
        ];

        return view('modUsuario/direccion', $data);
    }

    public function municipio(){

        $mun = new DireccionModel();

        $deptoId = $this->request->getVar('deptoId');

        $respuesta = $mun->listarMunicipio($deptoId);

        echo json_encode($respuesta);
    }

    //CREAR DIRECCION
    public function crearDireccion(){

        $datos = [
            "personaId"         => $_POST['personaId'],
            "tipoDireccion"     => $_POST['tipoDireccion'],
            "nombreDireccion"   => $_POST['nombreDireccion'],
            "municipioId"       => $_POST['municipioId']
        ];

        $municipioId  = $_POST['municipioId'];

        $direccion = new DireccionModel();

        $nombreMunicipio = $direccion->listarMunicipioA();

        //PARA REGISTRAR EN BITACORA QUIEN CREÓ LA DIRECCIÓN
        $this->bitacora  = new MovimientosModel();
        $hora=new Time('now');
        $session = session('usuario');

        $this->bitacora->save([
            'bitacoraId'    => null,
            'usuario'       => $session,
            'accion'        => 'Agregó dirección',
            'descripcion'   => $_POST['tipoDireccion'].':'.$_POST['nombreDireccion'].','.$_POST['municipioId'],
            'hora'          => $hora,
        ]);
        //END

        $direccion = new DireccionModel();
        $respuesta = $direccion->insertar($datos);

        if ($respuesta > 0){
            return redirect()->to(base_url(). '/direccion')->with('mensaje','0');
        } else {
            return redirect()->to(base_url(). '/direccion')->with('mensaje','1');
        } 
    } 

    //ELIMINAR DIRECCION
    public function eliminarDireccion(){

        $direccionId = $_POST['direccionId'];

        $direccion = new DireccionModel();
        $data = ["direccionId" => $direccionId];

        $nombreDireccion = $direccion->asArray()->select("nombreDireccion")
        ->where("direccionId", $direccionId)->first();

        $respuesta = $direccion->eliminar($data);

        if ($respuesta > 0){

            //PARA REGISTRAR EN BITACORA QUIEN ELIMINO LA DIRECCIÓN
            $this->bitacora  = new MovimientosModel();
            $hora=new Time('now');
            $session = session('usuario');

            $this->bitacora->save([
                'bitacoraId'    => null,
                'usuario'       => $session,
                'accion'        => 'Eliminó Dirección',
                'descripcion'   => $nombreDireccion,
                'hora'          => $hora,
            ]);
            //END

            return redirect()->to(base_url(). '/direccion')->with('mensaje','2');
        } else {
            return redirect()->to(base_url(). '/direccion')->with('mensaje','3');
        }
    }

    //ACTUALIZAR DIRECCION
    public function actualizarDireccion()
    {
        $datos = [
            "personaId"         => $_POST['personaId'],
            "tipoDireccion"     => $_POST['tipoDireccion'],
            "nombreDireccion"   => $_POST['nombreDireccion'],
            "municipioId"       => $_POST['municipioId']
        ];

        $direccionId = $_POST['direccionId'];

        $direccion = new DireccionModel();
        $respuesta = $direccion->actualizar($datos, $direccionId);

        $datos = ["datos" => $respuesta];

        //PARA REGISTRAR EN BITACORA QUIEN EDITÓ LA DIRECCIÓN
        $this->bitacora  = new MovimientosModel();
        $hora=new Time('now');
        $session = session('usuario');

        $this->bitacora->save([
            'bitacoraId'    => null,
            'usuario'       => $session,
            'accion'        => 'Editó dirección',
            'descripcion'   => $_POST['tipoDireccion'].':'.$_POST['nombreDireccion'].','.$_POST['municipioId'],
            'hora'          => $hora,
        ]);
        //END

        if ($respuesta) {
            return redirect()->to(base_url() . '/direccion')->with('mensaje', '4');
        } else {
            return redirect()->to(base_url() . '/direccion')->with('mensaje', '5');
        }
    }
    
}

?>