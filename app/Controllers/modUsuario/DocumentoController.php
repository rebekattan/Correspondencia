<?php namespace App\Controllers\modUsuario;

use App\Controllers\BaseController;
use App\Models\modUsuario\DocumentoModel;

class DocumentoController extends BaseController{

    //LISTAR DOCUMENTO

    public function documento(){

        $nombreDocumento = new DocumentoModel();
        $datos = $nombreDocumento->listarDocumento();
        $tipoDocumento = $nombreDocumento->listarTipoDocumento();
        $tipoEnvio = $nombreDocumento->listarTipoEnvio();

        $mensaje = session('mensaje');

        $data = [
            "datos" => $datos,
            "tipoDocumento" => $tipoDocumento,
            "tipoEnvio" => $tipoEnvio,
            "mensaje" => $mensaje
        ];

        return view('modUsuario/documento', $data);
        }

    //CREAR Documento
    public function crear(){

        $nombreDocumento = new DocumentoModel();
        if($this->validate('validarDocumento')){
            $nombreDocumento->insertar(
                [
                    "nombreDocumento" => $_POST['nombreDocumento'],
                    "documento" => $_POST['documento'],
                    "tipoDocumentoId" => $_POST['tipoDocumentoId'],
                    "tipoEnvioId" => $_POST['tipoEnvioId'],
                    "transaccionActividadId" => $_POST['transaccionActividadId']
                ]
            );
            $this->_upload();

            return redirect()->to(base_url(). '/documento')->with('mensaje','0');
        }
        
            return redirect()->to(base_url(). '/documento')->with('mensaje','1');

    } 
    public function crearImage(){
            
            $documento = $_POST['documento'];

        
   /*     if(empty($_FILES['documento']['name']))
            {
                $error=array(
                    'error_img'=>'Image file empty !!!.'
                );
            }
            else
            {
                $type=explode('.',$_FILES["documento"]["name"]);
                $type=$type[count($type)-1];
                $url="./public/uploads".uniqid(rand()).'.'.$type;
                if(in_array($type,array("jpg","jpeg","gif","png")))
                if(is_uploaded_file($_FILES["documento"]["tmp_name"]))
                if(move_uploaded_file($_FILES["documento"]["tmp_name"],$url))
                return $url;
                return "";
            }  */
            $file = $this->request->getFile('documento');
                
                $path = './uploads/';

                $name = $file->getName();
                $file->move(WRITEPATH . $path);

        $nombreDocumento = new DocumentoModel();
        if($this->validate('validarDocumento')){
            $nombreDocumento->insertar(
                [
                    "nombreDocumento" => $_POST['nombreDocumento'],
                    "documento" => $_POST['documento'],
                    "tipoDocumentoId" => $_POST['tipoDocumentoId'],
                    "tipoEnvioId" => $_POST['tipoEnvioId'],
                    "transaccionActividadId" => $_POST['transaccionActividadId']
                ]

                
            );  

                
            

            return redirect()->to(base_url(). '/documento')->with('mensaje','0');
        }
        
            return redirect()->to(base_url(). '/documento')->with('mensaje','1');

    }

    //ELIMINAR DOCUMENTO
    public function eliminar(){

        $documentoId = $_POST['documentoId'];

        $documento = new DocumentoModel();
        $data = ["documentoId" => $documentoId];

        $respuesta = $documento->eliminar($data);

        if ($respuesta > 0){
            return redirect()->to(base_url(). '/documento')->with('mensaje','2');
        } else {
            return redirect()->to(base_url(). '/documento')->with('mensaje','3');
        }
    }

    //ACTUALIZAR DOC
    public function actualizar()
    {
        $datos = [
            "nombreDocumento" => $_POST['nombreDocumento'],
            "documento" => $_POST['documento'],
            "tipoDocumentoId" => $_POST['tipoDocumentoId'],
            "tipoEnvioId" => $_POST['tipoEnvioId'],
            "transaccionActividadId" => $_POST['transaccionActividadId']
        ];

        $documentoId = $_POST['documentoId'];

        $actualizarDoc = new DocumentoModel();
        $respuesta = $actualizarDoc->actualizar($datos, $documentoId);

        $datos = ["datos" => $respuesta];

        if ($respuesta) {
            return redirect()->to(base_url() . '/documento')->with('mensaje', '4');
        } else {
            return redirect()->to(base_url() . '/documento')->with('mensaje', '5');
        }
    }

    private function _upload(){
        if ($imagefile = $this->request->getFiles()) {
            foreach ($imagefile['images'] as $imagefile) {
                if ($imagefile->isValid() && ! $imagefile->hasMoved()) {
                    $newName = $imagefile->getRandomName();
                    $imagefile->move(WRITEPATH . 'uploads', $newName);
                }
            }
        }
    }

    /* public function actualizarDoc()
    {
        $actualizarDoc = new DocumentoModel();

        //$documentoI =  $actualizarDoc->asArray()->select('max(d.documentoId) AS id')->from('wk_documento d')->first();

        $documentoId = 2;

        $documento = $this->request->getVar('documento');

        $datos = [
            "documento" => $documento
        ];

        $respuesta = $actualizarDoc->actualizarDoc($datos, $documentoId);

        $datos = ["datos" => $respuesta];

        echo json_encode($documentoId);

    } */
    
}

?>