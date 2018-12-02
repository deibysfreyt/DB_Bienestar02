<?php
		//Llamamos al modelo
	require_once("../modelos/modelo_informe_social.php");
		// Validamos si la Sesión esta iniciada
	if (strlen(session_id()) < 1)
		session_start();

	$informe_social = new Informe_social();
		// Limpiamos cada variable que es enviada por el AJAX con la función "LimpiarCadena()"

		//Solicitante
	$id_solicitante = isset($_POST["id_solicitante"])? limpiarCadena($_POST["id_solicitante"]): "";
	$cedula = isset($_POST["cedula"])? limpiarCadena($_POST["cedula"]): "";
	$nombre_apellido = isset($_POST["nombre_apellido"])? limpiarCadena($_POST["nombre_apellido"]): "";
	$fecha_nacimiento = isset($_POST["fecha_nacimiento"])? limpiarCadena($_POST["fecha_nacimiento"]): "";
	$sexo = isset($_POST["sexo"])? limpiarCadena($_POST["sexo"]): "";
	$direccion = isset($_POST["direccion"])? limpiarCadena($_POST["direccion"]): "";
	$telefono_1 = isset($_POST["telefono_1"])? limpiarCadena($_POST["telefono_1"]): "";
	$telefono_2 = isset($_POST["telefono_2"])? limpiarCadena($_POST["telefono_2"]): "";
	$email = isset($_POST["email"])? limpiarCadena($_POST["email"]): "";
	$parroquia = isset($_POST["parroquia"])? limpiarCadena($_POST["parroquia"]): "";
	$estado_civil = isset($_POST["estado_civil"])? limpiarCadena($_POST["estado_civil"]): "";
	$ocupacion = isset($_POST["ocupacion"])? limpiarCadena($_POST["ocupacion"]): "";
	$esterilizada = isset($_POST["esterilizada"])? limpiarCadena($_POST["esterilizada"]): "";
	$beneficio_gubernamental = isset($_POST["beneficio_gubernamental"])? limpiarCadena($_POST["beneficio_gubernamental"]): "";
	$num_hijo = isset($_POST["num_hijo"])? limpiarCadena($_POST["num_hijo"]): "";
	$ingreso = isset($_POST["ingreso"])? limpiarCadena($_POST["ingreso"]): "";

		//Solicitud
	$id_solicitud = isset($_POST["id_solicitud"])? limpiarCadena($_POST["id_solicitud"]): "";
	$id_tipo_solicitud = isset($_POST["id_tipo_solicitud"])? limpiarCadena($_POST["id_tipo_solicitud"]): "";
	$fecha = isset($_POST["fecha"])? limpiarCadena($_POST["fecha"]): "";
	$medio_informacion = isset($_POST["medio_informacion"])? limpiarCadena($_POST["medio_informacion"]): "";
	$tipo_vivienda = isset($_POST["tipo_vivienda"])? limpiarCadena($_POST["tipo_vivienda"]): "";
	$tenencia = isset($_POST["tenencia"])? limpiarCadena($_POST["tenencia"]): "";
	$construccion = isset($_POST["construccion"])? limpiarCadena($_POST["construccion"]): "";
	$tipo_piso = isset($_POST["tipo_piso"])? limpiarCadena($_POST["tipo_piso"]): "";

		//Beneficiario
	$id_persona = isset($_POST["id_persona"])? limpiarCadena($_POST["id_persona"]): "";
	$cedula_b = isset($_POST["cedula_b"])? limpiarCadena($_POST["cedula_b"]): "";
	$nombre_apellido_b = isset($_POST["nombre_apellido_b"])? limpiarCadena($_POST["nombre_apellido_b"]): "";
	$fecha_nacimiento_b = isset($_POST["fecha_nacimiento_b"])? limpiarCadena($_POST["fecha_nacimiento_b"]): "";
	$parentesco_b = isset($_POST["parentesco_b"])? limpiarCadena($_POST["parentesco_b"]): "";
	$semana_embarazo_b = isset($_POST["semana_embarazo_b"])? limpiarCadena($_POST["semana_embarazo_b"]): "";
	$talla_zapato = isset($_POST["talla_zapato"])? limpiarCadena($_POST["talla_zapato"]): "";
	$talla_pantalon = isset($_POST["talla_pantalon"])? limpiarCadena($_POST["talla_pantalon"]): "";
	$talla_franela = isset($_POST["talla_franela"])? limpiarCadena($_POST["talla_franela"]): "";
	
	$id_usuario = $_SESSION["id_usuario"];

	switch ($_GET["op"]) { // según la opción "op" enviado por el AJAX se procede a comparar

		case 'guardaryeditar':
				//Verificamos si ambos ID esta vació
			if (empty($id_solicitante) && empty($id_persona)) { //si el ID esta vació guardamos un nuevo registro
					//Si no existe el solicitante y el beneficiario, ambos se agrega
				$rspta = $informe_social->insertar($cedula,$nombre_apellido,$fecha_nacimiento,$sexo,$direccion,$telefono_1,$telefono_2,$email,$parroquia,$estado_civil,$ocupacion,$esterilizada,$beneficio_gubernamental,$num_hijo,$ingreso,$cedula_b,$nombre_apellido_b,$fecha_nacimiento_b,$parentesco_b,$semana_embarazo_b,$talla_zapato,$talla_pantalon,$talla_franela,$id_tipo_solicitud,$medio_informacion,$fecha,$tipo_vivienda,$tenencia,$construccion,$tipo_piso,$id_usuario,$_POST["id_familiar"],$_POST["nombre_apellido_f"],$_POST["fecha_nacimiento_f"],$_POST["parentesco_f"],$_POST["ocupacion_f"],$_POST["ingreso_f"],$_POST["peso_f"],$_POST["talla_f"]);
					//Dependiendo de la inserción, la variable "repta" puede ser True o false
				echo $rspta ? "El Informe Social a sido Registrado Correctamente en agregar ambos" : "No se pudo Registrar Todo los campos del informe social en agregar ambos ..!!!!!";

				//Verificamos si uno de los ID esta vació
			}else if (empty($id_persona) && !empty($id_solicitante)){
				// Se actualiza el Solicitante cuando este existe en la base de datos pero no el beneficiario
				$rspta = $informe_social->editars($id_solicitante,$cedula,$nombre_apellido,$fecha_nacimiento,$sexo,$direccion,$telefono_1,$telefono_2,$email,$parroquia,$estado_civil,$ocupacion,$esterilizada,$beneficio_gubernamental,$num_hijo,$ingreso,$cedula_b,$nombre_apellido_b,$fecha_nacimiento_b,$parentesco_b,$semana_embarazo_b,$talla_zapato,$talla_pantalon,$talla_franela,$id_tipo_solicitud,$medio_informacion,$fecha,$tipo_vivienda,$tenencia,$construccion,$tipo_piso,$id_usuario,$_POST["id_familiar"],$_POST["nombre_apellido_f"],$_POST["fecha_nacimiento_f"],$_POST["parentesco_f"],$_POST["ocupacion_f"],$_POST["ingreso_f"],$_POST["peso_f"],$_POST["talla_f"]);
					//Dependiendo de la inserción, la variable "repta" puede ser True o false
				echo $rspta ? "La Solicitud a sido Registrado y Actualizar el Solicitante Correctamente" : "No se pudo Registrar la solicitud y actualizar al Solicitante ..!!!!!";

				//Verificamos si uno de los ID esta vació
			}else if (!empty($id_persona) && empty($id_solicitante)){
				// Cuando existe el beneficiario pero no el Solicitante
				$rspta = $informe_social->editarb($cedula,$nombre_apellido,$fecha_nacimiento,$sexo,$direccion,$telefono_1,$telefono_2,$email,$parroquia,$estado_civil,$ocupacion,$esterilizada,$beneficio_gubernamental,$num_hijo,$ingreso,$id_persona,$cedula_b,$nombre_apellido_b,$fecha_nacimiento_b,$parentesco_b,$semana_embarazo_b,$talla_zapato,$talla_pantalon,$talla_franela,$id_tipo_solicitud,$medio_informacion,$fecha,$tipo_vivienda,$tenencia,$construccion,$tipo_piso,$id_usuario,$_POST["id_familiar"],$_POST["nombre_apellido_f"],$_POST["fecha_nacimiento_f"],$_POST["parentesco_f"],$_POST["ocupacion_f"],$_POST["ingreso_f"],$_POST["peso_f"],$_POST["talla_f"]);
					//Dependiendo de la inserción, la variable "repta" puede ser True o false
				echo $rspta ? "La Solicitud a sido Registrado y Actualizado el Beneficiario Correctamente" : "No se pudo Registrar Todo los campos del beneficiario ..!!!!!";

			}else {
				//Cundo El beneficiario y el Solicitante Existe en el Sistema
				$rspta = $informe_social->insertarbs($id_solicitante,$cedula,$nombre_apellido,$fecha_nacimiento,$sexo,$direccion,$telefono_1,$telefono_2,$email,$parroquia,$estado_civil,$ocupacion,$esterilizada,$beneficio_gubernamental,$num_hijo,$ingreso,$id_persona,$cedula_b,$nombre_apellido_b,$fecha_nacimiento_b,$parentesco_b,$semana_embarazo_b,$talla_zapato,$talla_pantalon,$talla_franela,$id_tipo_solicitud,$medio_informacion,$fecha,$tipo_vivienda,$tenencia,$construccion,$tipo_piso,$id_usuario,$_POST["id_familiar"],$_POST["nombre_apellido_f"],$_POST["fecha_nacimiento_f"],$_POST["parentesco_f"],$_POST["ocupacion_f"],$_POST["ingreso_f"],$_POST["peso_f"],$_POST["talla_f"]);
					//Dependiendo de la inserción, la variable "repta" puede ser True o false
				echo $rspta ? "La Solicitud a sido Registrado y Actualizado el Solicitante y el Beneficiario" : "No se pudo Registrar Todo los campos del informe social Solicitante y Beneficiario...!!!!!";
			}
		break;

		case 'mostrar':
				//Enviamos el ID para traer todo los datos referente a ella
			$rspta = $informe_social->mostrar($id_solicitud);
				//Codificar el resultado utilizando json
			echo json_encode($rspta);
		break;

		case 'listar':
				//Listamos todo los datos para mostrarlo en el DATA TABLE
			$rspta=$informe_social->listar();
	 			//declaramos un array almacenar todos los registro que voy a listar
	 		$data= Array();
	 			//Recorrernos todos los registro 1 a 1 y lo almaceno en la variable $reg
	 		while ($reg=$rspta->fetchObject()){
	 				//Almacenamos todos los datos obtenido en el array $data
	 			$data[]=array( //Los almacenamos en cada variable
	 				"0"=>'<button class="btn btn-warning" onclick="mostrart('.$reg->id_solicitud.')"><i class="fa fa-users"></i></button>',
	 				"1"=>'<button class="btn btn-warning" onclick="mostrars('.$reg->id_solicitud.')"><i class="fa fa-user"></i></button> '.$reg->solicitante.' - '.$reg->cedulas,
	 				"2"=>'<button class="btn btn-warning" onclick="mostrarb('.$reg->id_solicitud.')"><i class="fa fa-user"></i></button> '.$reg->beneficiario.' - '.$reg->cedulab,
	 				"3"=>$reg->id_solicitud,
	 				"4"=>$reg->solicitud.' - '.$reg->descripcion,
	 				"5"=>$reg->fecha
	 				);
	 		} //Declaramos un nuevo array y le asignamos los valores
	 		$results = array(
	 			"sEcho"=>1, //Información para el datatables
	 			"iTotalRecords"=>count($data), //enviamos el total registros al datatable
	 			"iTotalDisplayRecords"=>count($data), //enviamos el total registros a visualizar
	 			"aaData"=>$data); // le enviamos el array que almacenamos los datos
				//Devolvemos a la petición AJAX el ultimo array
	 		echo json_encode($results);
		break;

		case 'selectTipoSolicitud': //Seleccionamos la solicitud a Mostrar
				//Llamamos el Modelo para acceder a el
			require_once("../modelos/modelo_tipo_solicitud.php");
				//Almacenamos todo los datos que se fueron a consultar
			$tipo_solicitud = new Tipo_solicitud();
				//Recorrernos todos los registro 1 a 1 y lo almaceno en la variable $reg
			$rspta = $tipo_solicitud->select();

			while ($reg = $rspta->fetchObject()) {
					//Mostramos o imprimimos los dato uno a uno
				echo '<option value='.$reg->id_tipo_solicitud.'>'.$reg->solicitud.'-'.$reg->descripcion.'</option>';
			}
		break;

	}

 ?>