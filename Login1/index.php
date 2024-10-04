<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    
    $nombre = $_POST["nombre"];
    $contraseña = $_POST["contra"];

    if (!empty($nombre) && !empty($contraseña)) {
        $archivo = "datos.txt";

        if (file_exists($archivo)) {
            $datos = file($archivo);

            // Se abre el archivo donde se registran los intentos de inicio de sesión
            $ficheroUsuario = fopen($nombre . ".txt", "a");

            // Recorremos cada línea del archivo datos.txt
            foreach ($datos as $dato) {
                // Dividimos la línea en nombre de usuario y contraseña encriptada
                $datosSeparados = explode(";", trim($dato));

                if ($datosSeparados[0] == $nombre) {
                    // Verificamos la contraseña ingresada contra la encriptada
                    if (password_verify($contraseña, trim($datosSeparados[1]))) {
                        if ($ficheroUsuario) {
                            $fecha = date("d/m/Y H:i:s");
                            fwrite($ficheroUsuario, "Inicio de sesión correcto a las " . $fecha . "\n");
                            fclose($ficheroUsuario);
                            header("Location: /SERVIDOR/login/$nombre");
                            //El header es una respuesta que manda el servidor al usuario con el codigo de estado 302 o 301 para redireccionar al usuario a otra URL

                            exit; // Es importante detener la ejecución después del header
                        }
                    } else {
                        echo "Contraseña incorrecta";
                        break; // Detenemos el bucle si la contraseña es incorrecta
                    }
                } else {
                    header("Location: registro.html");
                }
            }
        } else {
            header("Location: registro.html");
            exit; // Detenemos la ejecución después del header
        }
    } else {
        echo "Error: Debes completar todos los campos.";
    }
} else {
    echo "Error: Solo se aceptan peticiones POST.";
}
?>
