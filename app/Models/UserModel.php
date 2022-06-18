<?php

namespace App\Models;

use CodeIgniter\Model;

class UserModel extends Model
{
	protected $table 			= 'wk_usuario';
	protected $primaryKey 		= 'usuarioId';
	protected $allowedFields 	= ['usuarioId', 'personaId', 'usuario', 'clave', 'estado', 'rolId'];
	protected $beforeInsert 	= ['beforeInsert'];
	protected $beforeUpdate 	= ['beforeUpdate'];
	//protected $returnType 		= 'object';

	protected function beforeInsert(array $data)
	{
		$data = $this->passwordHash($data);
		$data['data']['created_at'] = date('Y-m-d H:i:s');
		return $data;
	}

	protected function beforeUpdate(array $data)
	{
		$data = $this->passwordHash($data);
		$data['data']['updated_at'] = date('Y-m-d H:i:s');
		return $data;
	}

	protected function passwordHash(array $data)
	{
		if (isset($data['data']['password'])) {
			$data['data']['password'] = password_hash($data['data']['password'], PASSWORD_DEFAULT);
		}

		return $data;
	}
}
