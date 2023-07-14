<?php

echo '
    <div class="contenedor__graficas">
        <div class="main_info">
            <main class="contenedor__graficas-main">
                <h1 class="title"> Visit Dashboard</h1>
                <p class="info"> Aqui es donde puedes ver que es lo que esta pasando en tu negocio ahora mismo </p>
                <p class="subtitle"> Total de ocupacion en el año</p>
                <canvas id="grafica"></canvas>
            </main>
            <div class="contenedor__graficas-secundario">
                <div class="graficas__card">
                    <div class="card__encabezado">
                        <div>
                            <p class="card__encabezado-titulo">Hospeje</p>
                            <p class="card__encabezado-subtitulo">Ultimos 7 dias</p>
                        </div>
                        <p class="card__encabezado-titulo">
                            <i class="bx bxs-hotel text-secondary"></i>
                        </p>
                    </div>
                    <div class="card__content">
                        <canvas id="graficaPastel"></canvas>
                    </div>
                </div>
                <div class="graficas__card">
                    <div class="card__encabezado">
                        <div>
                            <p class="card__encabezado-titulo">Formas de pago</p>
                            <p class="card__encabezado-subtitulo">Ultimos 7 dias</p>
                        </div>
                        <p class="card__encabezado-titulo">
                            <i class="bx bxs-credit-card text-secondary"></i>
                        </p>
                    </div>
                    <div class="card__content">
                        <canvas id="graficaDona"></canvas>
                    </div>
                </div>
                <div class="graficas__card">
                    <div class="card__encabezado">
                        <div>
                            <p class="card__encabezado-titulo">Ventas</p>
                            <p class="card__encabezado-subtitulo">Ultima semana</p>
                        </div>
                        <p class="card__encabezado-titulo">
                            <i class="bx bxs-dollar-circle text-secondary"></i>
                        </p>
                    </div>
                    <div class="card__content">
                        <canvas id="ventas"></canvas>
                    </div>
                </div>
                <div class="graficas__card">
                    <div class="card__encabezado">
                        <div>
                            <p class="card__encabezado-titulo">Ventas en restaurant</p>
                            <p class="card__encabezado-subtitulo">Ultimos 7 dias</p>
                        </div>
                        <p class="card__encabezado-titulo">
                            <i class="bx bxs-cookie text-secondary"></i>
                        </p>
                    </div>
                    <div class="card__content">
                        <canvas id="restaurant"></canvas>
                    </div>
                </div>
            </div>
        </div>
        <div class="secundariInfo">
            <p class="subtitle"> Ocupacio actual</p>
            <canvas id="ocupacionActual"></canvas>
        </div>
    </div>
    <script src="./js/graficas.js"></script>
';