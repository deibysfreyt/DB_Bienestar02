<?php 
		//Llamamos al modelo
	require_once("../modelos/modelo_consultas.php");
		// Validamos si la Sesión esta iniciada
	if (strlen(session_id()) < 1)
		session_start();

	$consultas = new Consultas();
	

	switch ($_GET["op"]) { // según la opción "op" enviado por el AJAX se procede a comparar

		case 'aceptar':
				// Recibimos las variables y las almacenamos
			$fecha_actual = $_REQUEST["fecha_actual"];
			$id_usuario = $_SESSION["id_usuario"];
			$id_solicitud =  $_REQUEST["id_solicitud"];
				// Enviamos las tres variables
			$rspta=$consultas->aceptar($id_solicitud,$id_usuario,$fecha_actual);
				//Dependiendo de la inserción, la variable "repta" puede ser True o false
	 		echo $rspta ? "La Solicitud ha sido Aprobada" : "Solicitud no se puedo Aprobar";
		break;

		case 'mostrar':
			$id_solicitud = isset($_POST["id_solicitud"])? limpiarCadena($_POST["id_solicitud"]): "";
				//Enviamos el ID para traer todo los datos referente a ella
			$rspta = $consultas->mostrar($id_solicitud);
				//Codificar el resultado utilizando json
			echo json_encode($rspta);
		break;

		case 'listarFamiliar':
			//Recibimos el id de la solicitud
			$id = isset($_GET["id"])? limpiarCadena($_GET["id"]): "";
			//$id=$_GET["id"];
			//echo $id;

			$rspta = $consultas->listarFamiliar($id);

			echo '<thead style="background-color:#A9D0F5">
                	<th>N°</th>
                    <th>Nombre y Apellido</th>
                    <th>Fech. de Naci.</th>
                    <th>Parentesco</th>
                    <th>Ocupacion</th>
                    <th>Ingreso Bs</th>
                    <th>Peso Kg</th>
                    <th>Talla cm</th>
                 </thead>';
                 $num = 1;
			while ($reg = $rspta->fetchObject()) {
				echo '<tr class="filas"><td>'.$num.'</td><td>'.$reg->nombre_apellido_f.'</td><td>'.$reg->fecha_nacimiento_f.'</td><td>'.$reg->parentesco_f.'</td><td>'.$reg->ocupacion_f.'</td><td>'.$reg->ingreso_f.'</td><td>'.$reg->peso_f.'</td><td>'.$reg->talla_f.'</td></tr>';
				$num= $num + 1;
			}

			echo '<tfoot>
                    <th></th>
                    <th></th>
                    <th></th>
                    <th></th>
                    <th></th>
                    <th></th>
                    <th></th>
                    <th></th> 
                </tfoot>';
		break;

		case 'consultasfecha':
				// Recibimos las variables y las almacenamos
			$fecha_inicio = $_REQUEST["fecha_inicio"];
			$fecha_fin = $_REQUEST["fecha_fin"];
				// Enviamos ambos parámetros
			$rspta = $consultas->consultasfecha($fecha_inicio,$fecha_fin);
				//declaramos un array almacenar todos los registro que voy a listar
			$data = Array();
				//Recorrernos todos los registro 1 a 1 y lo almaceno en la variable $reg
			while ($reg = $rspta->fetchObject()) { //Los almacenamos en cada variable
				$url='../reportes/informe_social.php?id=';
				$data[] = array(
					"0"=>($reg->estado =='En espera')?'<button class="btn btn-success" onclick="aceptar('.$reg->id_solicitud.')"><i class="fa fa-check-square-o"></i></button>'.' <button class="btn btn-warning" onclick="mostrar('.$reg->id_solicitud.')"><i class="fa fa-eye"></i></button>':'<a target="_blank" href="'.$url.$reg->id_solicitud.'"> <button class="btn btn-info"><i class="fa fa-file"></i></button></a>'.' <button class="btn btn-warning" onclick="mostrar('.$reg->id_solicitud.')"><i class="fa fa-eye"></i></button>',
					"1"=>$reg->id_solicitud,
					"2"=>$reg->fecha,
					"3"=>$reg->solicitante.' - '.$reg->cedula_s,
					"4"=>$reg->beneficiario.' - '.$reg->cedula_p,
					"5"=>$reg->solicitud.' - '.$reg->descripcion,
					"6"=>$reg->parroquia,					
					"7"=>($reg->estado == 'En espera')?'<span class="label bg-red">En espera</span>':
	 				'<span class="label bg-green">Aprobado</span>'
				);
			} //Declaramos un nuevo array y le asignamos los valores
			$results = array(
				"sEcho"=>1, // Información para datatables
				"iTotalRecords"=>count($data), // Enviamos el total registros al datatable
				"iTotalDisplayRecords"=>count($data), //Enviamos el total registro a Visualizar
				"aaData"=>$data); // le enviamos el array que almacenamos los datos
				//Devolvemos a la petición AJAX el ultimo array
			echo json_encode($results);
		break;

		case 'consultasistema':
				// Recibimos las variables y las almacenamos
			$fecha_inicio = $_REQUEST["fecha_inicio"];
			$fecha_fin = $_REQUEST["fecha_fin"];
				// Enviamos ambos parámetros
			$rspta = $consultas->consultasistema($fecha_inicio,$fecha_fin);
				//declaramos un array almacenar todos los registro que voy a listar
			$data = Array();
				//Recorrernos todos los registro 1 a 1 y lo almaceno en la variable $reg
			while ($reg = $rspta->fetchObject()) {
				$data[] = array(
					"0"=>$reg->fecha_us,
					"1"=>$reg->id_solicitud,
					"2"=>$reg->usuario,
					"3"=>$reg->cargo,
					"4"=>$reg->descripcion_u
				);
			} //Declaramos un nuevo array y le asignamos los valores
			$results = array(
				"sEcho"=>1, // Información para datatables
				"iTotalRecords"=>count($data), // Enviamos el total registros al datatable
				"iTotalDisplayRecords"=>count($data), //Enviamos el total registro a Visualizar
				"aaData"=>$data); // le enviamos el array que almacenamos los datos
				//Devolvemos a la petición AJAX el ultimo array
			echo json_encode($results);
		break;

	}

 ?>