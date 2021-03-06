<?php  namespace App\Controllers;

use App\Models\Usuarios;

class HomeUser extends BaseController
{
    public function index()
    {
        if(!session()->is_logged){
            return redirect()->to(base_url('/'));
        }
            $mensaje = session('mensaje');
            return view('homeUser',["mensaje"=> $mensaje]);
        
    }

    public function login(){
        //dd($this->request->getPost());
        $usuario = trim($this->request->getVar('usuario'));
        $clave = $this->request->getVar('clave');

        $usuarios = model('Usuarios');
        $pass=$usuarios->obtenerUsuario('clave',$clave);

        if($user=$usuarios->obtenerUsuario('usuario',$usuario) && isset($pass['clave'])){

            $data = array(
                'usuario' => $usuario,
                'is_logged' => true
            );
                
            $session = session();
            $session->set($data);

            return redirect()->to(base_url('/homeUser'))->with('mensaje','0');

        }else{
            return redirect()->to(base_url('/'))->with('mensaje','1');
        }

     }  

     public function salir(){
         $session = session();
         $session->destroy();

         return redirect()->to(base_url('/'));
     }
     
}

?>