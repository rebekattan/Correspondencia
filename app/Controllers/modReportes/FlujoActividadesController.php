<?php

namespace App\Controllers\modReportes;

use App\Controllers\BaseController;
use App\Models\modReportes\PruebaModel;

use \Mpdf\Mpdf;
require_once 'vendors/mpdf/vendor/autoload.php';
require_once '../sql/conexion.php';

class FlujoActividadesController extends BaseController
{
    //LISTADO DE ROL MODULO MENU
    public function index()
    {
        $prueba = new PruebaModel();

        $procesoId = $_POST['procesoId'];

        $datos =  $prueba->reporteProcesoAct($procesoId);

        $contexto="";
        $correlativo=1;

        if ($datos>0) {
            foreach($datos as $row) {
                $contexto = $contexto . '
                <tr class="estilo" style="font-size:12;">
                    <td style="text-align:center;">'.$correlativo.'</td>
                    <td style="text-align:center;">'.$row->etapa.'</td>
                    <td style="text-align:center;">'.$row->actividad.'</td>
                    <td style="text-align:center;">'.$row->persona.'</td>
                    <td style="text-align:center;">'.$row->estado.'</td>
                    <td style="text-align:center;">'.$row->fechaInicio.'</td>
                    <td style="text-align:center;">'.$row->horaInicio.'</td>
                    <td style="text-align:center;">'.$row->fechaFin.'</td>
                    <td style="text-align:center;">'.$row->horaFin.'</td>
                </tr><br>
                ';
                $correlativo++;
            
        
                $tabla_a_imprimir='
                <style>
                    .estilo{
                        border: 1px solid black;
                        border-collapse: collapse;
                    }
                </style>
                <p style="text-align:center; font-size:16;"><b>Flujo de Actividades del Proceso: '.$row->proceso.'</b></p><br>
                <table border="0" style="width:100%;">
                    <thead>
                        <tr class="estilo">
                            <th style="width:3%;">#</th>
                            <th style="width:18%;">Etapa</th>
                            <th style="width:18%;">Actividad</th>
                            <th style="width:20%;">Encargado</th>
                            <th style="width:12%;">Estado</th>
                            <th style="width:15%;">Fecha Inicio</th>
                            <th style="width:15%;">Hora Inicio</th>
                            <th style="width:15%;">Fecha Fin</th>
                            <th style="width:12%;">Hora Fin</th>
                        </tr>
                    </thead><br>
                    <tbody>'.$contexto.'</tbody>
                </table>';

            }
            
            $mpdf = new \Mpdf\Mpdf(['mode'=>'utf8', 'format'=>'Letter-P', 'setAutoTopMargin'=>'stretch']);
        
            $mpdf->allow_charset_conversion=true;

            $mpdf->defaultheaderline = 0;
            $mpdf->defaultfooterline = 0;
        
            $mpdf->SetHeader('
            <table style="width=100%;">
                <tr>
                    <td><img src="images/membrete.jpg"></td>
                </tr>
            </table>
            ');
        
            $mpdf->setHTMLFooter(
                '
                <img src="images/Sin-título-1.jpg">
                <table style="width=100%;">
                    <tr>
                        <td style="float:left;width:68%;">Página {PAGENO} de {nb}</td>
                        <td style="float:right;width:32%;">Fecha de Impresión: '.date('d/m/Y H:i:s').'</td>
                    </tr>
                </table>
                '
            );
        
            $mpdf->charset_in='utf8';
        
            $mpdf->writeHTML($tabla_a_imprimir);
        
            $file="procesoActividades.pdf";

            $mpdf->Output($file,'I');
            $this->response->setHeader('Content-Type', 'application/pdf');
        
        }else{
            echo json_encode($datos);
        }

    }
}