<?php
include_once('clase_configuracion.php');
include_once('clase_correo.php');
$config = NEW Configuracion();
$correo = New Email();

$nombreHotel = $config->nombre;
$domicilio = $config->domicilio;
$pagina = $config->credencial_auto;
$imagen = $config->imagen;

$emisor_email = $correo->emisor_email;
$emisor_nombre = $correo->emisor_nombre;
$emisor_password = $correo->emisor_password;
$receptor_email = $correo->receptor_email;
$receptor_nombre = $correo->receptor_nombre;

    echo '
    <div class="herramientas_admin_container">
        <div class="herramientas_admin_container_header">
            <h1>Panel de Configuraciones Avanzadas</h1>
            <p>Acceso restringido: Solo usuarios autorizados pueden realizar cambios críticos en el sistema.</p>
        </div>

        <div class="herramientas_admin_item">
            <div class="herramientas_admin_item_header">
                <p>Informacion Basica</p>
            </div>
            <div class="herramientas_admin_item_body">
                <div class="form-floating input_container">
                    <input type="text" class="form-control custom_input" id="nombre_hotel" placeholder="Nombre del hotel" value="'.$nombreHotel.'" />
                    <label for="nombre_hotel">Nombre del hotel</label>
                </div>
                <div class="form-floating input_container">
                    <input type="text" class="form-control custom_input" id="direccion_hotel" placeholder="Direccion del hotel" value="'.$domicilio.'"/>
                    <label for="direccion_hotel">Direccion del hotel</label>
                </div>
                <div class="form-floating input_container">
                    <input type="text" class="form-control custom_input" id="pagina_web" placeholder="Pagina web" value="'.$pagina.'"/>
                    <label for="pagina_web">Pagina web</label>
                </div>
                <div class="form-floating input_container">
                    <input type="text" class="form-control custom_input" id="path_imagen" placeholder="Ruta imagen" value="'.$imagen.'"/>
                    <label for="path_imagen">Ruta imagen</label>
                </div>
            </div>
            <button class="btn btn-primary" onclick="selectior_super_admin(`infoBasica`)">
                Guardar
            </button>
        </div>

        <div class="herramientas_admin_item">
            <div class="herramientas_admin_item_header">
                <p>Facturación</p>
            </div>
            <div class="herramientas_admin_item_body">
                <div class="form-floating input_container">
                    <input type="text" class="form-control custom_input" id="nombre_emisor" placeholder="Email emisor" value="'.$emisor_nombre.'"/>
                    <label for="nombre_emisor">Nombre emisor</label>
                </div>
                <div class="form-floating input_container">
                    <input type="text" class="form-control custom_input" id="email_emisor" placeholder="Email emisor" value="'.$emisor_email.'"/>
                    <label for="email_emisor">Email emisor</label>
                </div>
                <div class="form-floating input_container">
                    <input type="password" class="form-control custom_input" id="emisor_password" placeholder="Password emisor" value="'.$emisor_password.'" />
                    <label for="emisor_password">Password emisor</label>
                </div>
                <div class="form-floating input_container">
                    <input type="text" class="form-control custom_input" id="email_receptor" placeholder="Nombre emisor" value="'.$receptor_email.'" />
                    <label for="nombre_emisor">Email receptor</label>
                </div>
                <div class="form-floating input_container">
                    <input type="text" class="form-control custom_input" id="nombre_receptor" placeholder="Email receptor" value="'.$receptor_nombre.'" />
                    <label for="nombre_receptor">Nombre receptor</label>
                </div>
            </div>
            <button class="btn btn-primary" onclick="selectior_super_admin(`facturacion`)">
                Guardar
            </button>
        </div>

        <div class="herramientas_admin_item">
            <div class="herramientas_admin_item_header">
                <p>Configuracion especial</p>
            </div>
            <div class="herramientas_admin_item_body">

                <div class="herramientas_admin_item_item">
                    <div class="form-check">
                        <input class="form-check-input" type="checkbox" id="abono_reserva">
                        <label for="abono_reserva">
                            Cargar abono de reserva
                        </label>
                    </div>
                    <button class="btn btn-primary" onclick="selectior_super_admin(`abono_reserva`)">
                        Guardar
                    </button>
                </div>

            </div>
        </div>

        <div class="herramientas_admin_item">
            <div class="herramientas_admin_item_header">
                <p>Configuracion avanzada</p>
            </div>
            <div class="herramientas_admin_item_body">

                <div class="herramientas_admin_item_item">
                    <div class="form-check">
                        <input class="form-check-input" type="checkbox" value="" id="base_datos">
                        <label for="base_datos">
                            Borrar toda la base de datos
                        </label>
                    </div>
                    <button class="btn btn-danger" onclick="selectior_super_admin(`borrar_db`)">
                        Ejecutar
                    </button>
                </div>

                <div class="herramientas_admin_item_item">
                    <div class="form-check">
                        <input class="form-check-input" type="checkbox" value="" id="chats">
                        <label for="chats">
                            Borrar chats
                        </label>
                    </div>
                    <button class="btn btn-danger" onclick="selectior_super_admin(`borrar_chats`)">
                        Ejecutar
                    </button>
                </div>

                <div class="herramientas_admin_item_item">
                    <div class="form-check">
                        <input class="form-check-input" type="checkbox" value="" id="chat_global">
                        <label for="chat_global">
                            Borrar chat global
                        </label>
                    </div>
                    <button class="btn btn-danger" onclick="selectior_super_admin(`borrar_global`)">
                        Ejecutar
                    </button>
                </div>

                <div class="herramientas_admin_item_item">
                    <div class="form-check">
                        <input class="form-check-input" type="checkbox" value="" id="chat_hab">
                        <label for="chat_hab">
                            Borrar chats habitaciones
                        </label>
                    </div>
                    <button class="btn btn-danger" onclick="selectior_super_admin(`borrar_hab`)">
                        Ejecutar
                    </button>
                </div>
            </div>
        </div>

        

    </div>';
?>