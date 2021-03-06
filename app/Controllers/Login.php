<?php

namespace App\Controllers;

use App\Models\modUsuario\UsuarioModel;
use App\Models\modUsuario\ContactoModel;

class Login extends BaseController
{

    public function index()
    {

        return view('login');
    }



    public function recuperarContrase├▒a()
    {
        $data = [];
        helper(['form']);
        if ($this->request->getMethod() == 'post') {
            $rules = [
                'email' => 'required|min_length[6]|max_length[50]|valid_email[wk_contacto.contacto]',
            ];

            $errors = [
                'email' => ['valid_email' => 'Email no existe, por favor verifique'],
            ];

            if (!$this->validate($rules, $errors)) {
                $data['validation'] = $this->validator;
            } else {
                $model = new ContactoModel();
                $user = $model->where('contacto', $this->request->getVar('email'))
                    ->first();
                $usuario = $model->select('u.usuario')->from('wk_contacto c')
                    ->join('wk_usuario u', 'c.personaID=u.personaId')->where('c.contacto', $this->request->getVar('email'))
                    ->first();
                $session = session();
                $pass = new UsuarioModel();
                $clave = $pass->select('clave')->where('usuario', $usuario)
                    ->first();
                if ($user) {
                    $newReset = [
                        'email'      => $user['contacto'],
                        'clave'     => $clave,
                    ];
                    $anio = date('Y');

                    $message = '
                    <tbody>
                        <tr>
                            <td style="background-color:#fff;text-align:left;padding:0">
                                <img width="100%" style="display:block" src="https://ci5.googleusercontent.com/proxy/P25cH7v50GgGMWFREqDuajcm2OkK3RY5n34zWsarDel-wtDsvs1Oljgt504DztdGajplibawaNrACXM7NVKg=s0-d-e1-ft#https://ucadvirtual.com/EduWS/encabezado.png" class="CToWUd a6T" tabindex="0"><div class="a6S" dir="ltr" style="opacity: 0.01; left: 816px; top: 64px;"><div id=":vp" class="T-I J-J5-Ji aQv T-I-ax7 L3 a5q" role="button" tabindex="0" aria-label="Descargar el archivo adjunto " data-tooltip-class="a1V" data-tooltip="Descargar"><div class="akn"><div class="aSK J-J5-Ji aYr"></div></div></div></div>
                            </td>
                        </tr>
                        <tr>
                            <td style="background-color:#fff;text-align:left;padding:0">
                                Soporte T├ęcnico | Correspondencia UCAD<br><hr
                            </td>
                        </tr>
                        <tr>
                            <td style="background-color:#ffffff">
                                <div style="color:#34495e;margin:4% 10% 2%;text-align:justify;font-family:sans-serif">
                                    <h2 style="color:#003366;margin:0 0 7px">Buen d├şa, estimado(a).</h2><br>
                                <p style="margin:2px;font-size:15px">
                                Hemos recibido una solicitud para recordar su contrase├▒a.<br><br>
                                A continuaci├│n, le mostramos su contrase├▒a:<br>
                                </p>
                                <h1 style="font-weight:bold;text-align:center">' . $clave['clave'] . '</h1><br>
                                <p style="margin:2px;font-size:15px"></p><p style="margin:2px;font-size:15px;font-weight:bold;display:inline">Nota:</p>Recuerde que la contrase├▒a es personal y no debe compartirla con nadie m├ís.<p></p>
                                <p style="margin:2px;font-size:15px">Por favor, no responda a este mensaje ya que ha sido generado de forma autom├ítica.</p>
                                <div style="width:100%;text-align:center;margin-top:10%">
                                <a style="text-decoration:none;border-radius:5px;padding:11px 23px;color:white;background-color:#172d44" href="#">Ir a Login - Correspondencia</a>	
                                </div>
                                <p style="color:#b3b3b3;font-size:12px;text-align:center;margin:30px 0 0">Universidad Cristiana de las Asambleas de Dios - ' . $anio . '</p>
                                </div>
                            </td>
                        </tr>
                    </tbody>';
                    $email = \Config\Services::email();
                    $email->setFrom('correspondencia.ucad@gmail.com', 'Recuperar Contrase├▒a');
                    $email->setTo($user['contacto']);
                    $email->setSubject('Recuperar Contrase├▒a');
                    $email->setMessage($message);
                    if ($email->send()) {
                        $session->setFlashdata('success', 'Se ha enviado un correo electr├│nico para recordar la contrase├▒a');
                    } else {
                        $session->setFlashdata('danger', 'Error en el env├şo, por favor intenta m├ís tarde.');
                    }
                } else {
                    $session->setFlashdata('danger', 'Este email no esta registrado, por favor verifique.');
                }
            }
        }
        return view('login', $data);
    }
}
