<?php
    session_start();
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $target_dir = '../comprobantes/';
        $target_file = $target_dir . basename($_FILES['imagen']['name']);

        $uploadOk = 1;
        $imageFileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));
        //$_SESSION['target_file']=$target_file;
        // Verificar si es una imagen real o una imagen falsa
        if (isset($_POST['submit'])) {
            $check = getimagesize($_FILES['imagen']['tmp_name']);
            if ($check !== false) {
                $uploadOk = 1;
            } else {
                $uploadOk = 0;
            }
        }
        echo "ipload 1= ".$uploadOk;
        // Verificar si el archivo ya existe
        if (file_exists($target_file)) {
            $uploadOk = 0;
        }

        // Verificar el tamaño del archivo
        if ($_FILES['imagen']['size'] > 500000) {
            $uploadOk = 0;
        }

        // Permitir solo ciertos formatos de archivo
        if ($imageFileType != 'jpg' && $imageFileType != 'png' && $imageFileType != 'jpeg'
            && $imageFileType != 'gif') {
            $uploadOk = 0;
        }

        // Verificar si $uploadOk es 0 por alguna razón
        if ($uploadOk == 0) {
            echo 'Error al subir la imagen.';
        } else {
            if (move_uploaded_file($_FILES['imagen']['tmp_name'], $target_file)) {
                echo 'La imagen ' . basename($_FILES['imagen']['name']) . ' ha sido subida correctamente.';
            } else {
                echo 'Error al subir la imagen.';
            }
        }
    } else {
        echo 'Acceso denegado.';
    }
?>