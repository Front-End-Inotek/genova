        <?php
        date_default_timezone_set('America/Mexico_City');
        include_once("clase_hab.php");
        $hab= NEW Hab(0);

        echo ' <div class="main_container"> 
                        <header class="main_container_title">
                                <h2>HABITACIONES</h2>
                        </header>';
                $hab->mostrar($_GET['usuario_id']);
        echo '</div>';

        ?>
