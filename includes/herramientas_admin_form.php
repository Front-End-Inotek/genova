<?php
    echo '
    <div class="herramientas_admin_container">
        <div>
            <h1>Panel de Configuraciones Avanzadas</h1>
            <p>Acceso restringido: Solo usuarios autorizados pueden realizar cambios críticos en el sistema.</p>
        </div>

        <div class="herramientas_admin_item">
            <div class="herramientas_admin_item_header">
                <p>Informacion Basica</p>
            </div>
            <div class="herramientas_admin_item_body">
                <div class="form-floating input_container">
                    <input type="text" class="form-control custom_input" id="nombre_hotel" placeholder="Nombre del hotel" />
                    <label for="nombre_hotel">Nombre del hotel</label>
                </div>
                <div class="form-floating input_container">
                    <input type="text" class="form-control custom_input" id="direccion_hotel" placeholder="Direccion del hotel" />
                    <label for="direccion_hotel">Direccion del hotel</label>
                </div>
                <div class="form-floating input_container">
                    <input type="text" class="form-control custom_input" id="pagina_web" placeholder="Pagina web" />
                    <label for="pagina_web">Pagina web</label>
                </div>
                <div class="form-floating input_container">
                    <input type="text" class="form-control custom_input" id="path_imagen" placeholder="PATH imagen" />
                    <label for="path_imagen">PATH imagen</label>
                </div>
            </div>
            <button class="btn btn-primary" onclick="selectior_super_admin(0)">
                Guardar
            </button>
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
                    <button class="btn btn-danger" onclick="selectior_super_admin(1)">
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
                    <button class="btn btn-danger" onclick="selectior_super_admin(2)">
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
                    <button class="btn btn-danger" onclick="selectior_super_admin(3)">
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
                    <button class="btn btn-danger" onclick="selectior_super_admin(4)">
                        Ejecutar
                    </button>
                </div>
            </div>
        </div>

        

    </div>';
?>