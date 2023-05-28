<?php
// Datos de conexión a la base de datos
$host = "localhost";
$user = "usuario";
$password = "contraseña";
$database = "nombre_de_la_base_de_datos";

// Conexión a la base de datos
$conn = mysqli_connect($host, $user, $password, $database);

// Verificación de la conexión
if (!$conn) {
	die("Error al conectar a la base de datos: " . mysqli_connect_error());
}

// Procesamiento del archivo subido
if (isset($_FILES["archivo"])) {
	$nombre_archivo = $_FILES["archivo"]["name"];
	$tipo_archivo = $_FILES["archivo"]["type"];
	$tamaño_archivo = $_FILES["archivo"]["size"];
	$archivo_temporal = $_FILES["archivo"]["tmp_name"];

	// Lectura del archivo temporal
	$archivo = fopen($archivo_temporal, "rb");
	$contenido_archivo = fread($archivo, $tamaño_archivo);
	fclose($archivo);

	// Escapado de caracteres para evitar inyección SQL
	$nombre_archivo = mysqli_real_escape_string($conn, $nombre_archivo);
	$tipo_archivo = mysqli_real_escape_string($conn, $tipo_archivo);

	// Inserción del archivo en la base de datos
	$sql = "INSERT INTO archivos (nombre, tipo, contenido) VALUES ('$nombre_archivo', '$tipo_archivo', '$contenido_archivo')";
	if (mysqli_query($conn, $sql)) {
		echo "El archivo se ha cargado correctamente";
	} else {
		echo "Error al cargar el archivo: " . mysqli_error($conn);
	}
}

// Cierre de la conexión
mysqli_close($conn);
?>
