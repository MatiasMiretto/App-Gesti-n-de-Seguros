<?php

	namespace app\controllers;
	use app\models\mainModel;

	class clientController extends mainModel{

		/*----------  Controlador registrar usuario  ----------*/
		public function registrarClienteControlador(){

			# Almacenando datos#
		    $nombre=$this->limpiarCadena($_POST['cliente_nombre']);
		    $direccion=$this->limpiarCadena($_POST['cliente_direccion']);

		    $cif=$this->limpiarCadena($_POST['cliente_cif']);
		    $email=$this->limpiarCadena($_POST['cliente_email']);
		    $telefono=$this->limpiarCadena($_POST['cliente_telefono']);
		    $contacto=$this->limpiarCadena($_POST['cliente_contacto']);


		    # Verificando campos obligatorios #
		    if($nombre=="" || $direccion=="" || $cif=="" || $telefono=="" || $telefono=="" || $contacto==""){
		    	$alerta=[
					"tipo"=>"simple",
					"titulo"=>"Ocurrió un error inesperado",
					"texto"=>"No has llenado todos los campos que son obligatorios",
					"icono"=>"error"
				];
				return json_encode($alerta);
		        exit();
		    }

		    # Verificando integridad de los datos #
		    if($this->verificarDatos("[a-zA-ZáéíóúÁÉÍÓÚñÑ ]{3,40}",$nombre)){
		    	$alerta=[
					"tipo"=>"simple",
					"titulo"=>"Ocurrió un error inesperado",
					"texto"=>"El NOMBRE no coincide con el formato solicitado",
					"icono"=>"error"
				];
				return json_encode($alerta);
		        exit();
		    }

		    if($this->verificarDatos("[a-zA-ZáéíóúÁÉÍÓÚñÑ0-9 ]{3,40}",$direccion)){
		    	$alerta=[
					"tipo"=>"simple",
					"titulo"=>"Ocurrió un error inesperado",
					"texto"=>"El APELLIDO no coincide con el formato solicitado",
					"icono"=>"error"
				];
				return json_encode($alerta);
		        exit();
		    }

		    if($this->verificarDatos("[a-zA-Z0-9]{4,20}",$cif)){
		    	$alerta=[
					"tipo"=>"simple",
					"titulo"=>"Ocurrió un error inesperado",
					"texto"=>"El USUARIO no coincide con el formato solicitado",
					"icono"=>"error"
				];
				return json_encode($alerta);
		        exit();
		    }

			if($this->verificarDatos("[0-9]{9,20}",$telefono)){
		    	$alerta=[
					"tipo"=>"simple",
					"titulo"=>"Ocurrió un error inesperado",
					"texto"=>"El TELEFONO no coincide con el formato solicitado",
					"icono"=>"error"
				];
				return json_encode($alerta);
		        exit();
		    }

			if($this->verificarDatos("[a-zA-ZáéíóúÁÉÍÓÚñÑ ]{3,40}",$contacto)){
		    	$alerta=[
					"tipo"=>"simple",
					"titulo"=>"Ocurrió un error inesperado",
					"texto"=>"El NOMBRE de la persona de CONTACTO no coincide con el formato solicitado",
					"icono"=>"error"
				];
				return json_encode($alerta);
		        exit();
		    }

			

		    

		    # Verificando email #
		    if($email!=""){
				if(filter_var($email, FILTER_VALIDATE_EMAIL)){
					$check_email=$this->ejecutarConsulta("SELECT Email FROM cliente WHERE Email='$email'");
					if($check_email->rowCount()>0){
						$alerta=[
							"tipo"=>"simple",
							"titulo"=>"Ocurrió un error inesperado",
							"texto"=>"El EMAIL que acaba de ingresar ya se encuentra registrado en el sistema, por favor verifique e intente nuevamente",
							"icono"=>"error"
						];
						return json_encode($alerta);
						exit();
					}
				}else{
					$alerta=[
						"tipo"=>"simple",
						"titulo"=>"Ocurrió un error inesperado",
						"texto"=>"Ha ingresado un correo electrónico no valido",
						"icono"=>"error"
					];
					return json_encode($alerta);
					exit();
				}
            }

            # Verificando cliente #
		    $check_cliente=$this->ejecutarConsulta("SELECT Nombre FROM cliente WHERE Nombre='$nombre'");
		    if($check_cliente->rowCount()>0){
		    	$alerta=[
					"tipo"=>"simple",
					"titulo"=>"Ocurrió un error inesperado",
					"texto"=>"El CLIENTE ingresado ya se encuentra registrado, por favor elija otro",
					"icono"=>"error"
				];
				return json_encode($alerta);
		        exit();
		    }

		    
		    $cliente_datos_reg=[
				[
					"campo_nombre"=>"Nombre",
					"campo_marcador"=>":Nombre",
					"campo_valor"=>$nombre
				],
				[
					"campo_nombre"=>"Direccion",
					"campo_marcador"=>":Direccion",
					"campo_valor"=>$direccion
				],
				[
					"campo_nombre"=>"Cif",
					"campo_marcador"=>":Cif",
					"campo_valor"=>$cif
				],
				[
					"campo_nombre"=>"Email",
					"campo_marcador"=>":Email",
					"campo_valor"=>$email
				],
				[
					"campo_nombre"=>"Telefono",
					"campo_marcador"=>":Telefono",
					"campo_valor"=>$telefono
				],
				[
					"campo_nombre"=>"Persona_Contacto",
					"campo_marcador"=>":Contacto",
					"campo_valor"=>$contacto
				],
				[
					"campo_nombre"=>"Creado",
					"campo_marcador"=>":Creado",
					"campo_valor"=>date("Y-m-d H:i:s")
				],
				[
					"campo_nombre"=>"Actualizado",
					"campo_marcador"=>":Actualizado",
					"campo_valor"=>date("Y-m-d H:i:s")
				]
			];

			$registrar_cliente=$this->guardarDatos("cliente",$cliente_datos_reg);

			if($registrar_cliente->rowCount()==1){
				$alerta=[
					"tipo"=>"limpiar",
					"titulo"=>"Cliente registrado",
					"texto"=>"El cliente ".$nombre." se registro con exito",
					"icono"=>"success"
				];
			}else{
				
				
				$alerta=[
					"tipo"=>"simple",
					"titulo"=>"Ocurrió un error inesperado",
					"texto"=>"No se pudo registrar el cliente, por favor intente nuevamente",
					"icono"=>"error"
				];
			}

			return json_encode($alerta);

		}

	/*----------  Controlador listar usuario  ----------*/
	public function listarClienteControlador($pagina,$registros,$url,$busqueda){

		$pagina=$this->limpiarCadena($pagina);
		$registros=$this->limpiarCadena($registros);

		$url=$this->limpiarCadena($url);
		$url=APP_URL.$url."/";

		$busqueda=$this->limpiarCadena($busqueda);
		$tabla="";

		$pagina = (isset($pagina) && $pagina>0) ? (int) $pagina : 1;
		$inicio = ($pagina>0) ? (($pagina * $registros)-$registros) : 0;

		if(isset($busqueda) && $busqueda!=""){

			$consulta_datos="SELECT * FROM cliente WHERE ((Nombre LIKE '%$busqueda%' OR Direccion LIKE '%$busqueda%' OR Cif LIKE '%$busqueda%' OR Email LIKE '%$busqueda%' OR Telefono LIKE '%$busqueda%')) ORDER BY Nombre ASC LIMIT $inicio,$registros";

			$consulta_total="SELECT COUNT(ID_Cliente) FROM cliente WHERE ((Nombre LIKE '%$busqueda%' OR Direccion LIKE '%$busqueda%' OR Cif LIKE '%$busqueda%' OR Email LIKE '%$busqueda%' OR Telefono LIKE '%$busqueda%'))";

		}else{

			$consulta_datos="SELECT * FROM cliente ORDER BY Nombre ASC LIMIT $inicio,$registros";

			$consulta_total="SELECT COUNT(ID_Cliente) FROM cliente";

		}

		$datos = $this->ejecutarConsulta($consulta_datos);
		$datos = $datos->fetchAll();

		$total = $this->ejecutarConsulta($consulta_total);
		$total = (int) $total->fetchColumn();

		$numeroPaginas =ceil($total/$registros);

		$tabla.='
			<div class="table-container">
			<table class="table is-bordered is-striped is-narrow is-hoverable is-fullwidth">
				<thead>
					<tr>
						<th class="has-text-centered">#</th>
						<th class="has-text-centered">Nombre</th>
						<th class="has-text-centered">Direccion</th>
						<th class="has-text-centered">CIF</th>
						<th class="has-text-centered">Email</th>
						<th class="has-text-centered">Telefono</th>
						<th class="has-text-centered">Persona de contacto</th>
						<th class="has-text-centered">Creado</th>
						<th class="has-text-centered">Actualizado</th>
						<th class="has-text-centered" colspan="3">Opciones</th>
					</tr>
				</thead>
				<tbody>
		';

		if($total>=1 && $pagina<=$numeroPaginas){
			$contador=$inicio+1;
			$pag_inicio=$inicio+1;
			foreach($datos as $rows){
				$tabla.='
					<tr class="has-text-centered" >
						<td>'.$contador.'</td>
						<td>'.$rows['Nombre'].'</td>
						<td>'.$rows['Direccion'].'</td>
						<td>'.$rows['Cif'].'</td>
						<td>'.$rows['Email'].'</td>
						<td>'.$rows['Telefono'].'</td>
						<td>'.$rows['Persona_Contacto'].'</td>
						<td>'.date("d-m-Y  h:i:s A",strtotime($rows['Creado'])).'</td>
						<td>'.date("d-m-Y  h:i:s A",strtotime($rows['Actualizado'])).'</td>
						<td>
							<a href="'.APP_URL.'clientUpdate/'.$rows['ID_Cliente'].'/" class="button is-success is-rounded is-small">Actualizar</a>
						</td>
						<td>
							<form class="FormularioAjax" action="'.APP_URL.'app/ajax/clienteAjax.php" method="POST" autocomplete="off" >

								<input type="hidden" name="modulo_cliente" value="eliminar">
								<input type="hidden" name="cliente_id" value="'.$rows['ID_Cliente'].'">

								<button type="submit" class="button is-danger is-rounded is-small">Eliminar</button>
							</form>
						</td>
					</tr>
				';
				$contador++;
			}
			$pag_final=$contador-1;
		}else{
			if($total>=1){
				$tabla.='
					<tr class="has-text-centered" >
						<td colspan="7">
							<a href="'.$url.'1/" class="button is-link is-rounded is-small mt-4 mb-4">
								Haga clic acá para recargar el listado
							</a>
						</td>
					</tr>
				';
			}else{
				$tabla.='
					<tr class="has-text-centered" >
						<td colspan="7">
							No hay registros en el sistema
						</td>
					</tr>
				';
			}
		}

		$tabla.='</tbody></table></div>';

		### Paginacion ###
		if($total>0 && $pagina<=$numeroPaginas){
			$tabla.='<p class="has-text-right">Mostrando clientes <strong>'.$pag_inicio.'</strong> al <strong>'.$pag_final.'</strong> de un <strong>total de '.$total.'</strong></p>';

			$tabla.=$this->paginadorTablas($pagina,$numeroPaginas,$url,7);
		}

		return $tabla;
	}	
		
	/*----------  Controlador eliminar cliente  ----------*/
		public function eliminarClienteControlador(){

			$id=$this->limpiarCadena($_POST['cliente_id']);

			# Verificando cliente #
		    $datos=$this->ejecutarConsulta("SELECT * FROM cliente WHERE ID_Cliente='$id'");
		    if($datos->rowCount()<=0){
		        $alerta=[
					"tipo"=>"simple",
					"titulo"=>"Ocurrió un error inesperado",
					"texto"=>"No hemos encontrado el cliente en el sistema",
					"icono"=>"error"
				];
				return json_encode($alerta);
		        exit();
		    }else{
		    	$datos=$datos->fetch();
		    }

		    $eliminarCliente=$this->eliminarRegistro("cliente","ID_Cliente",$id);

		    if($eliminarCliente->rowCount()==1){

		        $alerta=[
					"tipo"=>"recargar",
					"titulo"=>"Usuario eliminado",
					"texto"=>"El cliente ".$datos['Nombre']." ha sido eliminado del sistema correctamente",
					"icono"=>"success"
				];

		    }else{

		    	$alerta=[
					"tipo"=>"simple",
					"titulo"=>"Ocurrió un error inesperado",
					"texto"=>"No hemos podido eliminar el cliente ".$datos['Nombre']." del sistema, por favor intente nuevamente",
					"icono"=>"error"
				];
		    }

		    return json_encode($alerta);
		}

	/*----------  Controlador actualizar cliente  ----------*/
	public function actualizarClienteControlador(){

		$id=$this->limpiarCadena($_POST['cliente_id']);

		# Verificando cliente #
		$datos=$this->ejecutarConsulta("SELECT * FROM cliente WHERE ID_Cliente='$id'");
		if($datos->rowCount()<=0){
			$alerta=[
				"tipo"=>"simple",
				"titulo"=>"Ocurrió un error inesperado",
				"texto"=>"No hemos encontrado el cliente en el sistema",
				"icono"=>"error"
			];
			return json_encode($alerta);
			exit();
		}else{
			$datos=$datos->fetch();
		}

		# Almacenando datos#
		$nombre=$this->limpiarCadena($_POST['cliente_nombre']);
		$direccion=$this->limpiarCadena($_POST['cliente_direccion']);

		$cif=$this->limpiarCadena($_POST['cliente_cif']);
		$email=$this->limpiarCadena($_POST['cliente_email']);
		$telefono=$this->limpiarCadena($_POST['cliente_telefono']);
		$contacto=$this->limpiarCadena($_POST['cliente_contacto']);


		# Verificando campos obligatorios #
		if($nombre=="" || $direccion=="" || $cif=="" || $email=="" || $telefono==""){
			$alerta=[
				"tipo"=>"simple",
				"titulo"=>"Ocurrió un error inesperado",
				"texto"=>"No has llenado todos los campos que son obligatorios",
				"icono"=>"error"
			];
			return json_encode($alerta);
			exit();
		}

		# Verificando integridad de los datos #
	
		if($this->verificarDatos("[a-zA-ZáéíóúÁÉÍÓÚñÑ ]{3,40}",$nombre)){
			$alerta=[
				"tipo"=>"simple",
				"titulo"=>"Ocurrió un error inesperado",
				"texto"=>"El NOMBRE no coincide con el formato solicitado",
				"icono"=>"error"
			];
			return json_encode($alerta);
			exit();
		}

		if($this->verificarDatos("[a-zA-ZáéíóúÁÉÍÓÚñÑ0-9 ]{3,40}",$direccion)){
			$alerta=[
				"tipo"=>"simple",
				"titulo"=>"Ocurrió un error inesperado",
				"texto"=>"El DIRECCION no coincide con el formato solicitado",
				"icono"=>"error"
			];
			return json_encode($alerta);
			exit();
		}

		if($this->verificarDatos("[a-zA-Z0-9]{4,20}",$cif)){
			$alerta=[
				"tipo"=>"simple",
				"titulo"=>"Ocurrió un error inesperado",
				"texto"=>"El cif no coincide con el formato solicitado",
				"icono"=>"error"
			];
			return json_encode($alerta);
			exit();
		}

		if($this->verificarDatos("[0-9]{9,20}",$telefono)){
			$alerta=[
				"tipo"=>"simple",
				"titulo"=>"Ocurrió un error inesperado",
				"texto"=>"El TELEFONO no coincide con el formato solicitado",
				"icono"=>"error"
			];
			return json_encode($alerta);
			exit();
		}

		if($this->verificarDatos("[a-zA-ZáéíóúÁÉÍÓÚñÑ ]{3,40}",$contacto)){
			$alerta=[
				"tipo"=>"simple",
				"titulo"=>"Ocurrió un error inesperado",
				"texto"=>"El NOMBRE de la persona de CONTACTO no coincide con el formato solicitado",
				"icono"=>"error"
			];
			return json_encode($alerta);
			exit();
		}

		# Verificando email #
		if($email!="" && $datos['Email']!=$email){
			if(filter_var($email, FILTER_VALIDATE_EMAIL)){
				$check_email=$this->ejecutarConsulta("SELECT Email FROM cliente WHERE Email='$email'");
				if($check_email->rowCount()>0){
					$alerta=[
						"tipo"=>"simple",
						"titulo"=>"Ocurrió un error inesperado",
						"texto"=>"El EMAIL que acaba de ingresar ya se encuentra registrado en el sistema, por favor verifique e intente nuevamente",
						"icono"=>"error"
					];
					return json_encode($alerta);
					exit();
				}
			}else{
				$alerta=[
					"tipo"=>"simple",
					"titulo"=>"Ocurrió un error inesperado",
					"texto"=>"Ha ingresado un correo electrónico no valido",
					"icono"=>"error"
				];
				return json_encode($alerta);
				exit();
			}
		}

		# Verificando cliente #
		if($datos['Nombre']!=$nombre){
			$check_cliente=$this->ejecutarConsulta("SELECT Nombre FROM cliente WHERE Nombre='$nombre'");
			if($check_cliente->rowCount()>0){
				$alerta=[
					"tipo"=>"simple",
					"titulo"=>"Ocurrió un error inesperado",
					"texto"=>"El Cliente ingresado ya se encuentra registrado, por favor elija otro",
					"icono"=>"error"
				];
				return json_encode($alerta);
				exit();
			}
		}

		$cliente_datos_up=[
			[
				"campo_nombre"=>"Nombre",
				"campo_marcador"=>":Nombre",
				"campo_valor"=>$nombre
			],
			[
				"campo_nombre"=>"Direccion",
				"campo_marcador"=>":Direccion",
				"campo_valor"=>$direccion
			],
			[
				"campo_nombre"=>"Cif",
				"campo_marcador"=>":Cif",
				"campo_valor"=>$cif
			],
			[
				"campo_nombre"=>"Email",
				"campo_marcador"=>":Email",
				"campo_valor"=>$email
			],
			[
				"campo_nombre"=>"Telefono",
				"campo_marcador"=>":Telefono",
				"campo_valor"=>$telefono
			],
			[
				"campo_nombre"=>"Persona_Contacto",
				"campo_marcador"=>":Contacto",
				"campo_valor"=>$contacto
			],
			[
				"campo_nombre"=>"Actualizado",
				"campo_marcador"=>":Actualizado",
				"campo_valor"=>date("Y-m-d H:i:s")
			]
		];

		$condicion=[
			"condicion_campo"=>"ID_Cliente",
			"condicion_marcador"=>":ID",
			"condicion_valor"=>$id
		];

		if($this->actualizarDatos("cliente",$cliente_datos_up,$condicion)){

			$alerta=[
				"tipo"=>"recargar",
				"titulo"=>"Cliente actualizado",
				"texto"=>"Los datos del cliente ".$datos['Nombre']." se actualizaron correctamente",
				"icono"=>"success"
			];
		}else{
			$alerta=[
				"tipo"=>"simple",
				"titulo"=>"Ocurrió un error inesperado",
				"texto"=>"No hemos podido actualizar los datos del cliente ".$datos['Nombre'].", por favor intente nuevamente",
				"icono"=>"error"
			];
		}

		return json_encode($alerta);
	}
	}