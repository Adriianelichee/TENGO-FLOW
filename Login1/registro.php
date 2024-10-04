<?php
if ($_SERVER["REQUEST_METHOD"]== "POST"){
    
    $nombre = $_POST["nombre"];
    $contraseña = $_POST["contra"];
    $encrypt = password_hash($contraseña, PASSWORD_DEFAULT);

    if (!empty($nombre) && !empty($encrypt)){
        $archivo = "datos.txt";

        $existe = file_exists($archivo);

        // Si el archivo existe, se lee su contenido para contar los registros.
        if ($existe) {
            $lineas = file($archivo);
        
                // Divide cada linea por el caracter ";" para separar los campos (nombre, apellido, edad).
                $datos = explode(";", $linea);
        
                // Comprobamos si el registro coincide con el que queremos actualizar
                if ($datos[0] == $nombre && $datos[1] == $encrypt) {
                    echo "Este usuario ya existe";
                } else {
                    file_put_contents($archivo, "\n$nombre;$encrypt", FILE_APPEND);
                    echo "El registro se agrego correctamente.";
                    header("Location: index.html");
                }
            
        } else {
            $file = fopen($archivo, "w");
            if ($file) {
                fwrite($file, "$nombre;$encrypt\n");
                fclose($file);
                echo "El archivo se creo y el registro se agrego correctamente.";
            } else {
                echo "Error: No se pudo crear el archivo.";
            }
        }
    } else {
        echo "Error: Debes completar todos los campos.";
    }
} else {
    echo "Error: Solo se aceptan peticiones POST.";
}
?>
