<?php

echo '
<div class="admin_section">

    <div class="admin_section_login_container">
        <header>
            Configuraciones de nivel super usuario
        </header>

        <section class="admin_section_login_body">
            <h2>Advertencia.</h2>
            <p>Ingresa las credenciales para poder ingresar a las configuraciones de super usuario</p>
            <input class="custom_input_admin" type="text" id="username" placeholder="usuario" autocomplete="off" />
            <input class="custom_input_admin" type="password" id="password" placeholder="contraseña" autocomplete="off" />
            <div>
                <button class="btn btn-primary" onclick="login_super_admin()" >Ingresar</button>
            </div>
        </section>
    </div>

</div>';

?>