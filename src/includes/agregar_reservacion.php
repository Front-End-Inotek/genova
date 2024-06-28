<?php   
    $initialDate = strtotime($_GET['initial']);
    $endDate = strtotime($_GET['end']);       
    $cantidadPersonas = $_GET['guests']; 
    $name = $_GET['name'];
    $hab_id = $_GET['hab_id'];
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>

    <?php
    echo $name;
    echo $hab_id;
    ?>

</body>
</html>