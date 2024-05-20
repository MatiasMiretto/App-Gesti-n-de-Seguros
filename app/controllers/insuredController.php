<?php

	namespace app\controllers;
	use app\models\mainModel;

	class insuredController extends mainModel{

		/*----------  Controlador registrar asegurado  ----------*/
		public function registrarAseguradoControlador(){

			# Almacenando datos#
		    $nombre=$this->limpiarCadena($_POST['asegurado_nombre']);
		    $apellidos=$this->limpiarCadena($_POST['asegurado_apellido']);
            $dni=$this->limpiarCadena($_POST['asegurado_dni']);
		    $direccion=$this->limpiarCadena($_POST['asegurado_direccion']);
		    $email=$this->limpiarCadena($_POST['asegurado_email']);
		    $telefono=$this->limpiarCadena($_POST['asegurado_telefono']);
		    $domReparacion=$this->limpiarCadena($_POST['asegurado_dom_reparacion']);
			$cliente=$this->limpiarCadena($_POST['asegurado_cliente']);


		    # Verificando campos obligatorios #
		    if($nombre=="" || $apellidos=="" || $dni=="" || $direccion=="" || $telefono=="" || $domReparacion==""){
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

		    if($this->verificarDatos("[a-zA-ZáéíóúÁÉÍÓÚñÑ0-9 ]{3,40}",$apellidos)){
		    	$alerta=[
					"tipo"=>"simple",
					"titulo"=>"Ocurrió un error inesperado",
					"texto"=>"El APELLIDO no coincide con el formato solicitado",
					"icono"=>"error"
				];
				return json_encode($alerta);
		        exit();
		    }

            if($this->verificarDatos("[a-zA-Z0-9]{9}",$dni)){
		    	$alerta=[
					"tipo"=>"simple",
					"titulo"=>"Ocurrió un error inesperado",
					"texto"=>"El DNI no coincide con el formato solicitado",
					"icono"=>"error"
				];
				return json_encode($alerta);
		        exit();
		    }

		    if($this->verificarDatos("[a-zA-ZáéíóúÁÉÍÓÚñÑ0-9 ]{3,40}",$direccion)){
		    	$alerta=[
					"tipo"=>"simple",
					"titulo"=>"Ocurrió un error inesperado",
					"texto"=>"La DIRECCION no coincide con el formato solicitado",
					"icono"=>"error"
				];
				return json_encode($alerta);
		        exit();
		    }

			if($this->verificarDatos("[0-9]{7,20}",$telefono)){
		    	$alerta=[
					"tipo"=>"simple",
					"titulo"=>"Ocurrió un error inesperado",
					"texto"=>"El TELEFONO no coincide con el formato solicitado",
					"icono"=>"error"
				];
				return json_encode($alerta);
		        exit();
		    }

			if($this->verificarDatos("[a-zA-ZáéíóúÁÉÍÓÚñÑ0-9 ]{3,40}",$domReparacion)){
		    	$alerta=[
					"tipo"=>"simple",
					"titulo"=>"Ocurrió un error inesperado",
					"texto"=>"El DOMICILIO de REPARACION no coincide con el formato solicitado",
					"icono"=>"error"
				];
				return json_encode($alerta);
		        exit();
		    }

			

		    

		    # Verificando email #
		    if($email!=""){
				if(filter_var($email, FILTER_VALIDATE_EMAIL)){
					$check_email=$this->ejecutarConsulta("SELECT Email FROM asegurados WHERE Email='$email'");
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

            # Verificando asegurado #
		    $check_asegurado=$this->ejecutarConsulta("SELECT Dni FROM asegurados WHERE Dni='$dni'");
		    if($check_asegurado->rowCount()>0){
		    	$alerta=[
					"tipo"=>"simple",
					"titulo"=>"Ocurrió un error inesperado",
					"texto"=>"El Asegurado ingresado ya se encuentra registrado, por favor elija otro",
					"icono"=>"error"
				];
				return json_encode($alerta);
		        exit();
		    }

		    
		    $asegurado_datos_reg=[
				[
					"campo_nombre"=>"Nombre",
					"campo_marcador"=>":Nombre",
					"campo_valor"=>$nombre
				],
				[
					"campo_nombre"=>"Apellidos",
					"campo_marcador"=>":Apellidos",
					"campo_valor"=>$apellidos
				],
                [
					"campo_nombre"=>"Dni",
					"campo_marcador"=>":Dni",
					"campo_valor"=>$dni
				],
				[
					"campo_nombre"=>"Direccion",
					"campo_marcador"=>":Direccion",
					"campo_valor"=>$direccion
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
					"campo_nombre"=>"Dom_Reparacion",
					"campo_marcador"=>":DomicilioDeReparacion",
					"campo_valor"=>$domReparacion
				],
				[
					"campo_nombre"=>"ID_Cliente",
					"campo_marcador"=>":IdCliente",
					"campo_valor"=>$cliente
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

			$registrar_asegurado=$this->guardarDatos("asegurados",$asegurado_datos_reg);

			if($registrar_asegurado->rowCount()==1){
				$alerta=[
					"tipo"=>"limpiar",
					"titulo"=>"Asegurado registrado",
					"texto"=>"El asegurado ".$nombre. " ".$apellidos." se registro con exito",
					"icono"=>"success"
				];
			}else{
				
				
				$alerta=[
					"tipo"=>"simple",
					"titulo"=>"Ocurrió un error inesperado",
					"texto"=>"No se pudo registrar al asegurado, por favor intente nuevamente",
					"icono"=>"error"
				];
			}

			return json_encode($alerta);

		}

	/*----------  Controlador listar asegurado  ----------*/
	public function listarAseguradoControlador($pagina,$registros,$url,$busqueda){

		$pagina=$this->limpiarCadena($pagina);
		$registros=$this->limpiarCadena($registros);

		$url=$this->limpiarCadena($url);
		$url=APP_URL.$url."/";

		$busqueda=$this->limpiarCadena($busqueda);
		$tabla="";

		$pagina = (isset($pagina) && $pagina>0) ? (int) $pagina : 1;
		$inicio = ($pagina>0) ? (($pagina * $registros)-$registros) : 0;

		if(isset($busqueda) && $busqueda!=""){

			$consulta_datos="SELECT * FROM asegurados WHERE ((Nombre LIKE '%$busqueda%' OR Apellidos LIKE '%$busqueda%' OR Dni LIKE '%$busqueda%' OR Direccion LIKE '%$busqueda%' OR Email LIKE '%$busqueda%' OR Telefono LIKE '%$busqueda%' OR Dom_Reparacion LIKE '%$busqueda%' OR ID_Cliente LIKE '%$busqueda%')) ORDER BY Apellidos ASC LIMIT $inicio,$registros";

			$consulta_total="SELECT COUNT(ID_Asegurado) FROM asegurados WHERE ((Nombre LIKE '%$busqueda%' OR Apellidos LIKE '%$busqueda%' OR Dni LIKE '%$busqueda%' OR Direccion LIKE '%$busqueda%' OR Email LIKE '%$busqueda%' OR Telefono LIKE '%$busqueda%' OR Dom_Reparacion LIKE '%$busqueda%' OR ID_Cliente LIKE '%$busqueda%'))";

		}else{

			$consulta_datos="SELECT * FROM asegurados ORDER BY Apellidos ASC LIMIT $inicio,$registros";

			$consulta_total="SELECT COUNT(ID_Asegurado) FROM asegurados";

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
						<th class="has-text-centered">Apellidos</th>
                        <th class="has-text-centered">Dni</th>
						<th class="has-text-centered">Direccion</th>
						<th class="has-text-centered">Email</th>
						<th class="has-text-centered">Telefono</th>
						<th class="has-text-centered">Domicilio de reparacion</th>
						<th class="has-text-centered">Cliente</th>
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
						<td>'.$rows['Apellidos'].'</td>
                        <td>'.$rows['Dni'].'</td>
						<td>'.$rows['Direccion'].'</td>
						<td>'.$rows['Email'].'</td>
						<td>'.$rows['Telefono'].'</td>
						<td>'.$rows['Dom_Reparacion'].'</td>
						<td>'.$rows['ID_Cliente'].'</td>
						<td>'.date("d-m-Y  h:i:s A",strtotime($rows['Creado'])).'</td>
						<td>'.date("d-m-Y  h:i:s A",strtotime($rows['Actualizado'])).'</td>
						<td>
							<a href="'.APP_URL.'insuredUpdate/'.$rows['ID_Asegurado'].'/" class="button is-success is-rounded is-small">Actualizar</a>
						</td>
						<td>
							<form class="FormularioAjax" action="'.APP_URL.'app/ajax/aseguradoAjax.php" method="POST" autocomplete="off" >

								<input type="hidden" name="modulo_asegurado" value="eliminar">
								<input type="hidden" name="asegurado_id" value="'.$rows['ID_Asegurado'].'">

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
			$tabla.='<p class="has-text-right">Mostrando asegurados <strong>'.$pag_inicio.'</strong> al <strong>'.$pag_final.'</strong> de un <strong>total de '.$total.'</strong></p>';

			$tabla.=$this->paginadorTablas($pagina,$numeroPaginas,$url,7);
		}

		return $tabla;
	}	
		
	/*----------  Controlador eliminar asegurado  ----------*/
		public function eliminarAseguradoControlador(){

			$id=$this->limpiarCadena($_POST['asegurado_id']);

			# Verificando asegurado #
		    $datos=$this->ejecutarConsulta("SELECT * FROM asegurados WHERE ID_Asegurado='$id'");
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

		    $eliminarAsegurado=$this->eliminarRegistro("asegurados","ID_Asegurado",$id);

		    if($eliminarAsegurado->rowCount()==1){

		        $alerta=[
					"tipo"=>"recargar",
					"titulo"=>"Asegurado eliminado",
					"texto"=>"El asegurado ".$datos['Nombre']." ".$datos['Apellidos']." ha sido eliminado del sistema correctamente",
					"icono"=>"success"
				];

		    }else{

		    	$alerta=[
					"tipo"=>"simple",
					"titulo"=>"Ocurrió un error inesperado",
					"texto"=>"No hemos podido eliminar el asegurado ".$datos['Nombre']." ".$datos['Apellidos']." del sistema, por favor intente nuevamente",
					"icono"=>"error"
				];
		    }

		    return json_encode($alerta);
		}

	/*----------  Controlador actualizar asegurado  ----------*/
	public function actualizarAseguradoControlador(){

		$id=$this->limpiarCadena($_POST['asegurado_id']);

		# Verificando asegurado #
		$datos=$this->ejecutarConsulta("SELECT * FROM asegurados WHERE ID_Asegurado='$id'");
		if($datos->rowCount()<=0){
			$alerta=[
				"tipo"=>"simple",
				"titulo"=>"Ocurrió un error inesperado",
				"texto"=>"No hemos encontrado al asegurado en el sistema",
				"icono"=>"error"
			];
			return json_encode($alerta);
			exit();
		}else{
			$datos=$datos->fetch();
		}

		# Almacenando datos#
		$nombre=$this->limpiarCadena($_POST['asegurado_nombre']);
		$apellidos=$this->limpiarCadena($_POST['asegurado_apellido']);
        $dni=$this->limpiarCadena($_POST['asegurado_dni']);
		$direccion=$this->limpiarCadena($_POST['asegurado_direccion']);
		$email=$this->limpiarCadena($_POST['asegurado_email']);
		$telefono=$this->limpiarCadena($_POST['asegurado_telefono']);
		$domReparacion=$this->limpiarCadena($_POST['asegurado_dom_reparacion']);
		$cliente=$this->limpiarCadena($_POST['asegurado_cliente']);
		


		# Verificando campos obligatorios #
		if($nombre=="" || $apellidos=="" || $dni=="" || $direccion=="" || $telefono=="" || $domReparacion=="" || $cliente==""){
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

        if($this->verificarDatos("[a-zA-ZáéíóúÁÉÍÓÚñÑ0-9 ]{3,40}",$apellidos)){
            $alerta=[
                "tipo"=>"simple",
                "titulo"=>"Ocurrió un error inesperado",
                "texto"=>"El APELLIDO no coincide con el formato solicitado",
                "icono"=>"error"
            ];
            return json_encode($alerta);
            exit();
        }

        if($this->verificarDatos("[a-zA-Z0-9]{9}",$dni)){
            $alerta=[
                "tipo"=>"simple",
                "titulo"=>"Ocurrió un error inesperado",
                "texto"=>"El DNI no coincide con el formato solicitado",
                "icono"=>"error"
            ];
            return json_encode($alerta);
            exit();
        }

        if($this->verificarDatos("[a-zA-ZáéíóúÁÉÍÓÚñÑ0-9 ]{3,40}",$direccion)){
            $alerta=[
                "tipo"=>"simple",
                "titulo"=>"Ocurrió un error inesperado",
                "texto"=>"La DIRECCION no coincide con el formato solicitado",
                "icono"=>"error"
            ];
            return json_encode($alerta);
            exit();
        }

        if($this->verificarDatos("[0-9]{7,20}",$telefono)){
            $alerta=[
                "tipo"=>"simple",
                "titulo"=>"Ocurrió un error inesperado",
                "texto"=>"El TELEFONO no coincide con el formato solicitado",
                "icono"=>"error"
            ];
            return json_encode($alerta);
            exit();
        }

        if($this->verificarDatos("[a-zA-ZáéíóúÁÉÍÓÚñÑ0-9 ]{3,40}",$domReparacion)){
            $alerta=[
                "tipo"=>"simple",
                "titulo"=>"Ocurrió un error inesperado",
                "texto"=>"El DOMICILIO de REPARACION no coincide con el formato solicitado",
                "icono"=>"error"
            ];
            return json_encode($alerta);
            exit();
        }

        # Verificando email #
		if($email!="" && $datos['Email']!=$email){
			if(filter_var($email, FILTER_VALIDATE_EMAIL)){
				$check_email=$this->ejecutarConsulta("SELECT Email FROM asegurados WHERE Email='$email'");
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

		# Verificando asegurado #
		if($datos['Dni']!=$dni){
			$check_cliente=$this->ejecutarConsulta("SELECT Dni FROM asegurados WHERE Dni='$dni'");
			if($check_cliente->rowCount()>0){
				$alerta=[
					"tipo"=>"simple",
					"titulo"=>"Ocurrió un error inesperado",
					"texto"=>"El Asegurado ingresado ya se encuentra registrado, por favor elija otro",
					"icono"=>"error"
				];
				return json_encode($alerta);
				exit();
			}
		}

		$asegurado_datos_up=[
            [
                "campo_nombre"=>"Nombre",
                "campo_marcador"=>":Nombre",
                "campo_valor"=>$nombre
            ],
            [
                "campo_nombre"=>"Apellidos",
                "campo_marcador"=>":Apellidos",
                "campo_valor"=>$apellidos
            ],
            [
                "campo_nombre"=>"Dni",
                "campo_marcador"=>":Dni",
                "campo_valor"=>$dni
            ],
            [
                "campo_nombre"=>"Direccion",
                "campo_marcador"=>":Direccion",
                "campo_valor"=>$direccion
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
                "campo_nombre"=>"Dom_Reparacion",
                "campo_marcador"=>":DomicilioDeReparacion",
                "campo_valor"=>$domReparacion
            ],
			[
                "campo_nombre"=>"ID_Cliente",
                "campo_marcador"=>":IdCliente",
                "campo_valor"=>$cliente
            ],
            
            [
                "campo_nombre"=>"Actualizado",
                "campo_marcador"=>":Actualizado",
                "campo_valor"=>date("Y-m-d H:i:s")
            ]
        ];
		$condicion=[
			"condicion_campo"=>"ID_Asegurado",
			"condicion_marcador"=>":ID",
			"condicion_valor"=>$id
		];

		if($this->actualizarDatos("asegurados",$asegurado_datos_up,$condicion)){

			$alerta=[
				"tipo"=>"recargar",
				"titulo"=>"Asegurado actualizado",
				"texto"=>"Los datos del asegurado ".$datos['Nombre']."".$datos['Apellidos']." se actualizaron correctamente",
				"icono"=>"success"
			];
		}else{
			$alerta=[
				"tipo"=>"simple",
				"titulo"=>"Ocurrió un error inesperado",
				"texto"=>"No hemos podido actualizar los datos del asegurado ".$datos['Nombre']."".$datos['Apellidos'].", por favor intente nuevamente",
				"icono"=>"error"
			];
		}

		return json_encode($alerta);
	}
	}