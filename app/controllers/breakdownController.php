<?php

	namespace app\controllers;
	use app\models\mainModel;

	class breakdownController extends mainModel{

		/*----------  Controlador registrar averia  ----------*/
		public function registrarAveriaControlador(){

			# Almacenando datos#
		    $cliente=$this->limpiarCadena($_POST['averia_cliente']);
		    $asegurado=$this->limpiarCadena($_POST['averia_asegurado']);
            $fecha=$this->limpiarCadena($_POST['averia_fecha']);
		    $descripcion=$this->limpiarCadena($_POST['averia_descripcion']);
		   


		    # Verificando campos obligatorios #
		    if($cliente=="" || $asegurado=="" || $fecha=="" || $descripcion==""){
		    	$alerta=[
					"tipo"=>"simple",
					"titulo"=>"Ocurrió un error inesperado",
					"texto"=>"No has llenado todos los campos que son obligatorios",
					"icono"=>"error"
				];
				return json_encode($alerta);
		        exit();
		    }

		    
		    $averia_datos_reg=[
				[
					"campo_nombre"=>"Cliente",
					"campo_marcador"=>":Cliente",
					"campo_valor"=>$cliente
				],
				[
					"campo_nombre"=>"Asegurado",
					"campo_marcador"=>":Asegurado",
					"campo_valor"=>$asegurado
				],
				[
					"campo_nombre"=>"Fecha",
					"campo_marcador"=>":Fecha",
					"campo_valor"=>$fecha
				],
				[
					"campo_nombre"=>"Descripcion",
					"campo_marcador"=>":Descripcion",
					"campo_valor"=>$descripcion
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

			$registrar_averia=$this->guardarDatos("averias",$averia_datos_reg);

			if($registrar_averia->rowCount()==1){
				$alerta=[
					"tipo"=>"limpiar",
					"titulo"=>"Averia registrada",
					"texto"=>"La averia se registro con exito",
					"icono"=>"success"
				];
			}else{
				
				
				$alerta=[
					"tipo"=>"simple",
					"titulo"=>"Ocurrió un error inesperado",
					"texto"=>"No se pudo registrar la averia, por favor intente nuevamente",
					"icono"=>"error"
				];
			}

			return json_encode($alerta);

		}

	/*----------  Controlador listar averia  ----------*/
	public function listarAveriaControlador($pagina,$registros,$url,$busqueda){

		$pagina=$this->limpiarCadena($pagina);
		$registros=$this->limpiarCadena($registros);

		$url=$this->limpiarCadena($url);
		$url=APP_URL.$url."/";

		$busqueda=$this->limpiarCadena($busqueda);
		$tabla="";

		$pagina = (isset($pagina) && $pagina>0) ? (int) $pagina : 1;
		$inicio = ($pagina>0) ? (($pagina * $registros)-$registros) : 0;

		if(isset($busqueda) && $busqueda!=""){

			$consulta_datos="SELECT * FROM averias WHERE ((Cliente LIKE '%$busqueda%' OR Asegurado LIKE '%$busqueda%' OR Fecha LIKE '%$busqueda%' OR Descripcion LIKE '%$busqueda%' ASC LIMIT $inicio,$registros";

			$consulta_total="SELECT COUNT(ID_Averia) FROM averias WHERE (Cliente LIKE '%$busqueda%' OR Asegurado LIKE '%$busqueda%' OR Fecha LIKE '%$busqueda%' OR Descripcion LIKE '%$busqueda%'))";

		}else{

			$consulta_datos="SELECT * FROM averias ORDER BY ID_Averia ASC LIMIT $inicio,$registros";

			$consulta_total="SELECT COUNT(ID_Averia) FROM averias";

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
						<th class="has-text-centered">ID</th>
						<th class="has-text-centered">Cliente</th>
						<th class="has-text-centered">Asegurado</th>
						<th class="has-text-centered">Fecha</th>
						<th class="has-text-centered">Descripcion</th>
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
						
						<td>'.$rows['ID_Averia'].'</td>
						<td>'.$rows['Cliente'].'</td>
						<td>'.$rows['Asegurado'].'</td>
						<td>'.$rows['Fecha'].'</td>
						<td>'.$rows['Descripcion'].'</td>
						
						<td>'.date("d-m-Y  h:i:s A",strtotime($rows['Creado'])).'</td>
						<td>'.date("d-m-Y  h:i:s A",strtotime($rows['Actualizado'])).'</td>
						
						<td>
							<form class="FormularioAjax" action="'.APP_URL.'app/ajax/breakdownAjax.php" method="POST" autocomplete="off" >

								<input type="hidden" name="modulo_averia" value="eliminar">
								<input type="hidden" name="averia_id" value="'.$rows['ID_Averia'].'">

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
		
	/*----------  Controlador eliminar averia  ----------*/
		public function eliminarAveriaControlador(){

			$id=$this->limpiarCadena($_POST['averia_id']);

			# Verificando averia #
		    $datos=$this->ejecutarConsulta("SELECT * FROM averias WHERE ID_Averia='$id'");
		    if($datos->rowCount()<=0){
		        $alerta=[
					"tipo"=>"simple",
					"titulo"=>"Ocurrió un error inesperado",
					"texto"=>"No hemos encontrado la averia en el sistema",
					"icono"=>"error"
				];
				return json_encode($alerta);
		        exit();
		    }else{
		    	$datos=$datos->fetch();
		    }

		    $eliminarAveria=$this->eliminarRegistro("averias","ID_Averia",$id);

		    if($eliminarAveria->rowCount()==1){

		        $alerta=[
					"tipo"=>"recargar",
					"titulo"=>"Averia eliminada",
					"texto"=>"La averia ID ".$datos['ID_Averia']." ha sido eliminada del sistema correctamente",
					"icono"=>"success"
				];

		    }else{

		    	$alerta=[
					"tipo"=>"simple",
					"titulo"=>"Ocurrió un error inesperado",
					"texto"=>"No hemos podido eliminar la averia ".$datos['ID_Averia']." del sistema, por favor intente nuevamente",
					"icono"=>"error"
				];
		    }

		    return json_encode($alerta);
		}

	
	}