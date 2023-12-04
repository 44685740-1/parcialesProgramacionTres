<?php
//require_once "./app/models/cliente.php";
class guardarImagen
{
	public function guardarImagenCliente($cliente)
	{
		// if (isset($_FILES['fotoPerfil']) && $_FILES['fotoPerfil']['error'] === UPLOAD_ERR_OK) {
		// 	// El archivo se cargó correctamente
		// 	// Continúa con el proceso de guardar la imagen
		// } else {
		// 	echo "Ocurrió un error al subir el archivo.";
		// }

		
		$carpeta_archivos = 'imagenesDeCliente/2023/';

		// Datos del arhivo enviado por POST
		$nombre_archivo = $cliente->numeroCliente . $cliente->tipoCliente . ".png";
		$tipo_archivo = $_FILES['fotoPerfil']['type'];
		$tamano_archivo = $_FILES['fotoPerfil']['size'];

		// Ruta destino, carpeta + nombre del archivo que quiero guardar
		$ruta_destino = $carpeta_archivos . $nombre_archivo;

		// Realizamos las validaciones del archivo
		if (!((strpos($tipo_archivo, "png") || strpos($tipo_archivo, "jpeg")) && ($tamano_archivo < 100000))) {
			//echo "La extensión o el tamaño de los archivos no es correcta. <br><br><table><tr><td><li>Se permiten archivos .png o .jpg<br><li>se permiten archivos de 100 Kb máximo.</td></tr></table>";
			return false;
		} else {
			if (move_uploaded_file($_FILES['fotoPerfil']['tmp_name'],  $ruta_destino)) {
				//echo "El archivo ha sido cargado correctamente.";
				return true;
			} else {
				//echo "Ocurrió algún error al subir el fichero. No pudo guardarse.";
				return false;
			}
		}
		
	}

	public function guardarImagenReserva($reserva){
		$carpeta_archivos = 'imagenesDeReserva2023/';

		// Datos del arhivo enviado por POST
		$nombre_archivo = $reserva->tipoCliente . $reserva->numeroCliente . "-" . $reserva->id . ".png";
		$tipo_archivo = $_FILES['fotoReserva']['type'];
		$tamano_archivo = $_FILES['fotoReserva']['size'];

		// Ruta destino, carpeta + nombre del archivo que quiero guardar
		$ruta_destino = $carpeta_archivos . $nombre_archivo;

		// Realizamos las validaciones del archivo
		if (!((strpos($tipo_archivo, "png") || strpos($tipo_archivo, "jpeg")) && ($tamano_archivo < 100000))) {
			//echo "La extensión o el tamaño de los archivos no es correcta. <br><br><table><tr><td><li>Se permiten archivos .png o .jpg<br><li>se permiten archivos de 100 Kb máximo.</td></tr></table>";
			return false;
		} else {
			if (move_uploaded_file($_FILES['fotoReserva']['tmp_name'],  $ruta_destino)) {
				//echo "El archivo ha sido cargado correctamente.";
				return true;
			} else {
				//echo "Ocurrió algún error al subir el fichero. No pudo guardarse.";
				return false;
			}
		}
	}



}