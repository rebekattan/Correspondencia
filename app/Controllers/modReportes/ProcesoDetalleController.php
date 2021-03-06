<?php

namespace App\Controllers\modReportes;

use App\Controllers\BaseController;
use App\Models\modReportes\PruebaModel;

use \Mpdf\Mpdf;
require_once 'vendors/mpdf/vendor/autoload.php';
require_once '../sql/conexion.php';

class ProcesoDetalleController extends BaseController
{
    //LISTADO DE ROL MODULO MENU
    public function index()
    {
        $prueba = new PruebaModel();

        $datos =  $prueba->reporte3();

        $contexto="";
        $correlativo=1;
        $data = [];

        if ($datos>0) {
            foreach($datos as $row) {
                $contexto = $contexto . '
                <tr>
                    <td>'.$correlativo.'</td>
                    <td>'.$row->proceso.'</td>
                    <td style="text-align:center;">'.$row->etapa.'</td>
                    <td style="text-align:center;">'.$row->actividad.'</td>
                    <td style="text-align:center;">'.$row->estado.'</td>
                </tr><br>
                ';
                $correlativo++;
            
        
            $tabla_a_imprimir='
            <h3 style="text-align:center;"><b>Detalle de Procesos del mes de '.$row->mes.'</b></h3><br>
            <table border="0" style="width:100%;">
                <thead>
                    <tr>
                        <th style="width:5%;">#</th>
                        <th style="width:30%;">Proceso</th>
                        <th style="width:28%;">Etapa</th>
                        <th style="width:22%;">Actividad</th>
                        <th style="width:15%;">Estado del Proceso</th>
                    </tr>
                </thead><br>
                <tbody>'.$contexto.'</tbody>
            </table>';

            }
            
            $mpdf = new \Mpdf\Mpdf(['mode'=>'utf8', 'format'=>'Letter-P', 'setAutoTopMargin'=>'stretch']);
            //$mpdf = new \Mpdf\Mpdf(['orientation' => 'L']);
            /* $mpdf->AddPage('L', // L - landscape, P - portrait
            '', '', '', '',
            '', // margin_left
            '', // margin right
            18, // margin top
            '', // margin bottom
            '', // margin header
            ''); // margin footer */
        
            $mpdf->allow_charset_conversion=true;
        
            $mpdf->SetHeader('
            <table style="width=100%;">
                <tr>
                    <td><img src="images/membrete.jpg"></td>
                </tr>
            </table>
            ');
        
            $mpdf->setHTMLFooter(
                '
                <img src="images/Sin-t??tulo-1.jpg">
                <table style="width=100%;">
                    <tr>
                        <td style="float:left;width:55%;">P??gina {PAGENO} de {nb}</td>
                        <td style="float:right;width:45%;">Fecha de Impresi??n: '.date('d/m/Y H:i:s').'</td>
                    </tr>
                </table>
                '
            );
        
            $mpdf->charset_in='utf8';
        
            $mpdf->writeHTML($tabla_a_imprimir);
        
            $file="../../../media/tmp/reporte3.pdf";

            return redirect()->to($mpdf->Output($file,'I'));
        
        }else{
            echo json_encode($datos);
        }
    }
}
