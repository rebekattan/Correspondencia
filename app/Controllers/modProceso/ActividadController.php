<?php

namespace App\Controllers\modProceso;

use App\Controllers\BaseController;
use App\Models\modProceso\ActividadModel;
use App\Models\modUsuario\ContactoModel;

class ActividadController extends BaseController
{

    //LISTAR ACTIVIDAD

    public function actividad()
    {

        $nombreActividad = new ActividadModel();

        $etapaId = $this->request->getVar('etapaId');

        $datos = $nombreActividad->listarActividad($etapaId);

        echo json_encode($datos);
    }

    //list
    public function actList()
    {

        $nombreActividad = new ActividadModel();

        $etapaId = $this->request->getVar('etapaId');

        $datos = $nombreActividad->listarActividad($etapaId);

        echo json_encode($datos);
    }

    public function personaList()
    {

        $actividad = new ActividadModel();

        $datos = $actividad->listarPersona();

        echo json_encode($datos);
    }

    public function personaListA()
    {

        $actividad = new ActividadModel();

        $datos = $actividad->listarPersona();

        echo json_encode($datos);
    }

    public function personaListC()
    {

        $actividad = new ActividadModel();

        $datos = $actividad->listarPersona();

        echo json_encode($datos);
    }

    public function etapaL()
    {

        $etapa = new ActividadModel();

        $etapaId = $this->request->getVar('etapaId');

        $datos = $etapa->etapaL($etapaId);

        echo json_encode($datos);
    }

    //CREAR ACTIVIDAD
    public function crear()
    {

        $actividad = new ActividadModel();

        $etapaId = $this->request->getVar('etapaId');
        $nombreActividad = $this->request->getVar('nombreActividad');
        $descripcion = $this->request->getVar('descripcion');
        $orden = $this->request->getVar('orden');
        $personaId = $this->request->getVar('personaId');

        $datos = [
            "nombreActividad" => $nombreActividad,
            "descripcion" => $descripcion,
            "ordenActividad" => $orden,
            "etapaId" => $etapaId,
            "personaId" => $personaId
        ];

        $respuesta = $actividad->insertar($datos);

        if ($respuesta) {
            $model = new ContactoModel();
            $anio = date('Y');

            $contacto = $model->select('contacto')->where('personaId', $personaId);

            $msm ='
            <tbody>
                <tr>
                    <td style="background-color:#fff;text-align:left;padding:0">
                        <img width="100%" style="display:block" src="https://ci5.googleusercontent.com/proxy/P25cH7v50GgGMWFREqDuajcm2OkK3RY5n34zWsarDel-wtDsvs1Oljgt504DztdGajplibawaNrACXM7NVKg=s0-d-e1-ft#https://ucadvirtual.com/EduWS/encabezado.png" class="CToWUd a6T" tabindex="0"><div class="a6S" dir="ltr" style="opacity: 0.01; left: 816px; top: 64px;"><div id=":vp" class="T-I J-J5-Ji aQv T-I-ax7 L3 a5q" role="button" tabindex="0" aria-label="Descargar el archivo adjunto " data-tooltip-class="a1V" data-tooltip="Descargar"><div class="akn"><div class="aSK J-J5-Ji aYr"></div></div></div></div>
                    </td>
                <tr>
                <tr>
                    <td style="background-color:#ffffff">
                    <div style="color:#34495e;margin:4% 10% 2%;text-align:justify;font-family:sans-serif">
                        <h2 style="color:#003366;margin:0 0 7px">Buen día, estimado(a).</h2><br>
                        <p style="margin:2px;font-size:15px">
                            Se le ha asignado una actividad.<br><br>
                            '.$nombreActividad.'<br>
                        </p>
                        <p style="margin:2px;font-size:15px"></p><p style="margin:2px;font-size:15px;font-weight:bold;display:inline">
                        </p>Descripcion:</p>'.$descripcion.'<p></p>
                        <p style="margin:2px;font-size:15px">Por favor, no responda a este mensaje ya que ha sido generado de forma automática.</p>
                            <div style="width:100%;text-align:center;margin-top:10%">
                                <a style="text-decoration:none;border-radius:5px;padding:11px 23px;color:white;background-color:#172d44" href="#">Ir a Login - Correspondencia</a>	
                            </div>
                        <p style="color:#b3b3b3;font-size:12px;text-align:center;margin:30px 0 0">Universidad Cristiana de las Asambleas de Dios - '.$anio.'</p>
                    </div>
                    </td>
                </tr>
            </tbody>
            ';
            $email = \Config\Services::email();
            $email->setFrom('correspondencia.ucad@gmail.com', 'Nueva Actividad Asignada');
            $email->setTo('avelarjr77@gmail.com');
            $email->setSubject('Nueva Actividad Asignada');
            $email->setMessage($msm);
            if ($email->send()) {
                $mensaje = 12;
            }
        } else {

            $mensaje = 13;
        }

        echo json_encode($mensaje);
    }

    //ELIMINAR ACTIVIDAD
    public function eliminar()
    {

        $actividad = new ActividadModel();

        $actividadId = $this->request->getVar('actividadId');

        $data = ["actividadId" => $actividadId];

        $respuesta = $actividad->eliminar($data);

        if ($respuesta > 0) {
            $mensaje = 14;
        } else {
            $mensaje = 15;
        }

        echo json_encode($mensaje);
    }

    //ELIMINAR ACTIVIDAD
    public function actualizar()
    {
        $actividad = new ActividadModel();

        $actividadId = $this->request->getVar('actividadId');
        $etapaId = $this->request->getVar('etapaId');
        $nombreActividad = $this->request->getVar('nombreActividad');
        $descripcion = $this->request->getVar('descripcion');
        $orden = $this->request->getVar('orden');
        $personaId = $this->request->getVar('personaId');

        $datos = [
            "nombreActividad" => $nombreActividad,
            "descripcion" => $descripcion,
            "ordenActividad" => $orden,
            "etapaId" => $etapaId,
            "personaId" => $personaId
        ];

        $respuesta = $actividad->actualizar($datos, $actividadId);

        $datos = ["datos" => $respuesta];

        if ($respuesta) {
            $mensaje = 16;
        } else {
            $mensaje = 17;
        }

        echo json_encode($mensaje);
    }
}
