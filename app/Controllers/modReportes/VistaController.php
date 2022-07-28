<?php

namespace App\Controllers\modReportes;

use App\Controllers\BaseController;
use App\Models\modReportes\PruebaModel;

use \Mpdf\Mpdf;
require_once 'vendors/mpdf/vendor/autoload.php';
require_once '../sql/conexion.php';

class VistaController extends BaseController
{
    public function index()
    {
        $prueba = new PruebaModel();

        $datos =  $prueba->reporteUsuario();

        $contexto="";
        $correlativo=1;

        if ($datos>0) {
            foreach($datos as $row) {
                $contexto = $contexto . '
                <tr class="estilo" style="font-size:12;">
                    <td style="text-align:center;">'.$correlativo.'</td>
                    <td style="text-align:center;">'.$row->usuario.'</td>
                    <td style="text-align:center;">'.$row->persona.'</td>
                    <td style="text-align:center;">'.$row->genero.'</td>
                    <td style="text-align:center;">'.$row->departamento.'</td>
                    <td style="text-align:center;">'.$row->cargo.'</td>
                    <td style="text-align:center;">'.$row->estado.'</td>
                </tr><br>
                ';
                $correlativo++;
            
        
                $tabla_a_imprimir='
                <p style="text-align:center; font-size:16;"><b>Información de usuarios del sistema</b></p><br>
                <table class="estilo" style="width:100%;">
                    <thead>
                        <tr class="estilo">
                            <th style="width:5%;">#</th>
                            <th style="width:12%;">Usuario</th>
                            <th style="width:25%;">Persona</th>
                            <th style="width:12%;">Género</th>
                            <th style="width:30%;">Departamento</th>
                            <th style="width:20%;">Cargo</th>
                            <th style="width:15%;">Estado</th>
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
        
            $file="Usuarios.pdf";

            $mpdf->Output($file,'I');
            $this->response->setHeader('Content-Type', 'application/pdf');
        
        }else{
            echo json_encode($datos);
        }
    }
}
