<?php namespace App\Controllers\modTransaccion;

use App\Controllers\BaseController;
use App\Models\modTransaccion\TransaccionConfigModel;

class TransaccionConfigController extends BaseController{

    //LISTAR TRANSACCION

    public function index(){
        $nombreProceso = new TransaccionConfigModel();
        $datos = $nombreProceso->listarProceso();
        $institucion = $nombreProceso->listarInstitucion();
        $transaccion = $nombreProceso->transaccionData();
        $persona= $nombreProceso->listarPersona();

        $mensaje = session('mensaje');

        $data = [
            "datos" => $datos,
            "institucion" => $institucion,
            "transaccion" => $transaccion,
            "persona" => $persona,
            "mensaje" => $mensaje
        ];

        return view('modTransaccion/transaccionConfig', $data);
    }

    public function etapas(){

        $etapa = new TransaccionConfigModel();
        $procesoId = $this->request->getVar('procesoId');
        $datos = $etapa->listarEtapa($procesoId);
        
        echo json_encode($datos);
    }

    public function tDetId(){
        $etapaDet = new TransaccionConfigModel();

        $etapaId = $etapaDet->obtenerTDID();

        echo json_encode($etapaId);
    }

    public function tAcId(){
        $etapaDetA = new TransaccionConfigModel();

        $actividadId = $etapaDetA->obtenerTAID();

        echo json_encode($actividadId);
    }

    public function actividad(){

        $actividad = new TransaccionConfigModel();
        $etapaId = $this->request->getVar('etapaId');
        $datos = $actividad->listarActividad($etapaId);
        
        echo json_encode($datos);
    }

    /* public function tDetalle(){

        $etapa = new TransaccionConfigModel();
        $transaccionId = $this->request->getVar('transaccionId');
        $etapaId = $this->request->getVar('etapaId');
        $fechaHora = date('Y-m-d H:i:s');
        $porciones = explode(" ", $fechaHora);

        $datos = [ 
            "estadoTransaccion" => 'A',
            "fechaInicio" => $porciones[0],
            "horaInicio" => $porciones[1]
        ];

        for ($i=0; $i < count($etapaId); $i++) 
        {
            if ($i == 0) {
                $data = array('transaccionId' => $transaccionId, 'etapaId' => $etapaId[$i], "fechaInicio" => $porciones[0], "horaInicio" => $porciones[1]);
                $insertar = $etapa->insertarT($data);
            }else{
                $data = array('transaccionId' => $transaccionId, 'etapaId' => $etapaId[$i]);
                $insertar = $etapa->insertarT($data);
            }
        }

        $tDetalle = $etapa->listarTransaccionDet($transaccionId);
        $actalizarEstado = $etapa->actualizar($datos, $transaccionId);
        
        echo json_encode($tDetalle);
    } */

    public function tDetalle(){

        $etapa = new TransaccionConfigModel();
        $transaccionId = $this->request->getVar('transaccionId');
        //$tActividadId = $this->request->getVar('transaccionActividadId');
        //$transaccionDetId = $this->request->getVar('transaccionDetalleId');
        $etapaId = $this->request->getVar('etapaId');
        //$actividadId = $this->request->getVar('actividadId');
        $fechaHora = date('Y-m-d H:i:s');
        $porciones = explode(" ", $fechaHora);
        /* $transaccionDetalleId = $transaccionDetId + 1;
        $transaccionActividadId = $tActividadId +1; */

        $datos = [ 
            "estadoTransaccion" => 'P',
            "fechaInicio" => $porciones[0],
            "horaInicio" => $porciones[1]
        ];

        /* for ($i=0; $i < count($etapaId); $i++) 
        {
            if ($i == 0) {
                $data = array('transaccionId' => $transaccionId, 'etapaId' => $etapaId[$i], "fechaInicio" => $porciones[0], "horaInicio" => $porciones[1]);
                $insertar = $etapa->insertarT($data);
            }else{
                $data = array('transaccionId' => $transaccionId, 'etapaId' => $etapaId[$i]);
                $insertar = $etapa->insertarT($data);
            }
        } */

        $data = [
            'transaccionId' => $transaccionId, 
            'etapaId' => $etapaId,
            "estado" => 'P',
            "fechaInicio" => $porciones[0],
            "horaInicio" => $porciones[1]
        ];

        /* $dataA = [
            'transaccionDetalleId' => $transaccionDetalleId, 
            'actividadId' => $actividadId
        ]; */

        $insertar = $etapa->insertarT($data);
        //$insertarActividad = $etapa->insertarAct($dataA);

        $actalizarEstado = $etapa->actualizar($datos, $transaccionId);
        //$actalizarEstadoE = $etapa->actualizarT($datos, $transaccionDetalleId);
        //$actalizarEstadoA = $etapa->actualizarA($datos, $transaccionActividadId);

        $tDetalle = $etapa->listarTransaccionDet($transaccionId);
        
        echo json_encode($tDetalle);
    }

    public function etapasList(){

        $etapaLista = new TransaccionConfigModel();
        $transaccionId = $this->request->getVar('transaccionId');
        

        $tDetalleList = $etapaLista->listarTransaccionDet($transaccionId);
        
        echo json_encode($tDetalleList);
    }

    public function tActividades(){

        $actividad = new TransaccionConfigModel();
        $transaccionDetalleId = $this->request->getVar('transaccionDetalleId');
        $actividadId = $this->request->getVar('actividadId');
        $fechaHora = date('Y-m-d H:i:s');
        $porciones = explode(" ", $fechaHora);

        /* $datos = [ 
            "estadoTransaccion" => 'A',
            "fechaInicio" => $porciones[0],
            "horaInicio" => $porciones[1]
        ]; */

        $data = [
            'transaccionDetalleId' => $transaccionDetalleId, 
            'actividadId' => $actividadId,
            "estado" => 'I',
            "fechaCreacion" => $porciones[0],
            "horaCreacion" => $porciones[1]
        ];

        $insertar = $actividad->insertarAct($data);

        /* for ($i=0; $i < count($actividadId); $i++) 
        {
            $data = array('transaccionDetalleId' => $transaccionDetalleId, 'actividadId' => $actividadId[$i]);
            $insertar = $actividad->insertarAct($data);
            //$data = array($etapaId[$i]);
        } */

        $tActDetalle = $actividad->listarTransaccionAct($transaccionDetalleId);
        //$actalizarEstado = $actividad->actualizar($datos, $transaccionDetalleId);
        
        echo json_encode($tActDetalle);
    }

    public function actividadList(){

        $actividadLista = new TransaccionConfigModel();
        $transaccionDetalleId = $this->request->getVar('transaccionDetalleId');
        

        $tActividadList = $actividadLista->listarTransaccionAct($transaccionDetalleId);
        
        echo json_encode($tActividadList);
    }

    public function transaccionListado(){

        $transaccion = new TransaccionConfigModel();
        $list = $transaccion->transaccionData();
        
        echo json_encode($list);
    }

    public function transaccionObservaciones(){

        $transaccionO = new TransaccionConfigModel();
        
        $transaccionId = $this->request->getVar('transaccionId');

        $respuesta = $transaccionO->transaccionDataO($transaccionId);

        echo json_encode($respuesta);
    }

    //CREAR TRANSACCION
    public function crear(){

        $datos = [
            "procesoId" => $_POST['procesoId'],
            "personaId" => $_POST['personaId'],
            "institucionId" => $_POST['institucionId'],
            "observaciones" => $_POST['observaciones'],
            "estadoTransaccion" => 'I'
        ];

        $transaccion = new TransaccionConfigModel();
        $respuesta = $transaccion->insertar($datos);

        if ($respuesta > 0){
            return redirect()->to(base_url(). '/transaccionConfig')->with('mensaje','0');
        } else {
            return redirect()->to(base_url(). '/transaccionConfig')->with('mensaje','1');
        } 
    } 

    //ELIMINAR TRANSACCION
    public function eliminarT(){

        $transaccion = new TransaccionConfigModel();
        
        $transaccionId = $this->request->getVar('transaccionId');

        $data = ["transaccionId" => $transaccionId];

        $respuesta = $transaccion->eliminarP($data);

        echo json_encode($respuesta);
    }

    public function eliminarP(){

        $transaccion = new TransaccionConfigModel();

        $transaccionId = $this->request->getVar('transaccionId');

        $datos = [
            "estadoTransaccion" => 'A'
        ];

        $respuesta = $transaccion->actualizar($datos, $transaccionId);

        $datos = ["datos" => $respuesta];
        
        echo json_encode($respuesta);
    }

    //ACTUALIZAR TRANSACCION
    public function actualizar()
    {
        $datos = [
            "estadoTransaccion" => 'P'
        ];

        $transaccionId = $this->request->getVar('transaccionId');

        $transaccion = new TransaccionConfigModel();
        $respuesta = $transaccion->actualizar($datos, $transaccionId);

        $datos = ["datos" => $respuesta];

        if ($respuesta) {
            return redirect()->to(base_url() . '/transaccionConfig')->with('mensaje', '4');
        } else {
            return redirect()->to(base_url() . '/transaccionConfig')->with('mensaje', '5');
        }
    }

    //ACTUALIZAR OBSERVACIONES
    public function actualizarO()
    {
        $datos = [
            "observaciones" => $_POST['observaciones']
        ];

        $transaccionId = $_POST['transaccionId'];

        $transaccion = new TransaccionConfigModel();
        $respuesta = $transaccion->actualizar($datos, $transaccionId);

        $datos = ["datos" => $respuesta];

        if ($respuesta) {
            return redirect()->to(base_url() . '/transaccionConfig')->with('mensaje', '4');
        } else {
            return redirect()->to(base_url() . '/transaccionConfig')->with('mensaje', '5');
        }
    }
}

?>