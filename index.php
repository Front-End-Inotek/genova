<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="./src/styles/index.css">
    <title>Hotel Plaza Genova</title>
    <link rel="shortcut icon" href="./src/assets/img/logo_genova_color.png" type="image/x-icon">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Alata&display=swap" rel="stylesheet">
</head>
<body>

    <div class="container-carousel">
        <article class="main_home">
            <section class="main_home_header">
                <!-- <div>
                    <a href="tel:">+52 3338 824 500</a>
                </div>
                -->
                <div class="main_home_header_logo">
                    <img src="./src/assets/img/logo_genova_color.png" />
                </div>
                <button class="btn_reservar">
                    Ver mas
                </button>
            </section>

            <section class="main_home_tools">
                <div class="main_home_tools_name">
                    <input id="email" type="email" placeholder="Correo electronico" min="0" max="80"/>
                </div>
                <div class="main_home_tools_name">
                    <input id="name" type="text" placeholder="Nombre" min="0" max="80"/>
                </div>
                <div class="main_home_tools_tel">
                    <input id="tel" type="tel" placeholder="Telefono" min="0" step="5" max="100" />
                </div>
            </section>
            <section class="main_home_tools">
                <div class="main_home_tools_date">
                    <!-- Fecha inicial -->
                    <div class="main_home_tools_div_date" id="handleInicio">
                        <p>Fecha inicio</p>
                        <p id="initialDate">Selecciona una fecha</p>
                    </div>
                    <div class="main_home_tools_div_date" id="handleFinal">
                        <p>Fecha final</p>
                        <p id="endDate">Selecciona una fecha</p>
                    </div>
                    <!-- Fecha final -->
                    <img id="btnCalender" src="./src/assets/svg/calender.svg" />
                </div>
                <div class="main_home_tools_persons">
                    <select name="persons">
                        <option value="1" selected >1 HUESPED</option>
                        <option value="2">2 HUESPED</option>
                        <option value="3">3 HUESPED</option>
                        <option value="4">4 HUESPED</option>
                        <option value="5">5 HUESPED</option>
                        <option value="6">6 HUESPED</option>
                        <option value="7">7 HUESPED</option>
                    </select>
                </div>
                <div class="main_home_tools_button">
                    <button class="btn_crear_reserva" id="btn_crear_reserva">
                        Ver Disponibilidad
                    </button>
                </div>
            </section>
            <section class="calender_container" id="calender" style="display: none;">
                <img class="calender_container_img" onclick="handleCalender();" src="./src/assets/svg/close.svg" />
                <calendar-range  
                    months="2" 
                    id="calendar-range"
                    min="2024-01-01"
                    max="2100-12-31"
                >
                    <svg
                        aria-label="Previous"
                        slot="previous"
                        xmlns="http://www.w3.org/2000/svg"
                        viewBox="0 0 24 24"
                    >
                        <path d="M15.75 19.5 8.25 12l7.5-7.5"></path>
                    </svg>
                    <svg
                        aria-label="Next"
                        slot="next"
                        xmlns="http://www.w3.org/2000/svg"
                        viewBox="0 0 24 24"
                    >
                        <path d="m8.25 4.5 7.5 7.5-7.5 7.5"></path>
                    </svg>
                    <div class="calenders">
                        <calendar-month></calendar-month>
                        <calendar-month offset="1"></calendar-month>
                    </div>
                </calendar-range>
            </section>

            <section class="contenedor_hab">
                <div class="card_hab">
                    <div class="card_hab_header">
                        <img src="https://images.pexels.com/photos/1457842/pexels-photo-1457842.jpeg?auto=compress&cs=tinysrgb&w=1260&h=750&dpr=1" />
                    </div>
                    <div class="card_body">
                        <h5>Hab continental</h5>
                        <div class="card_body_info">
                            <img src="./src/assets/svg/air.svg" />
                            <p>Aire acondionado</p>
                        </div>
                        <div class="card_body_info">
                            <img src="./src/assets/svg/tv.svg" />
                            <p>TV</p>
                        </div>
                        <div class="card_body_info">
                            <img src="./src/assets/svg/wifi.svg" />
                            <p>Wifi gratis</p>
                        </div>

                        <button class="btn_select" >Seleccionar</button>
                    </div>
                </div>

                <?php
                    
                ?>
            </section>
        </article>

        <div class="carrouseles" id="slider">
            <section class="slider-section">
                <img src="./src/assets/img/1.webp" loading="lazy" alt="">
            </section>
            <section class="slider-section">
                <img src="./src/assets/img/2.webp" loading="lazy" alt="">
            </section>
            <section class="slider-section">
                <img src="./src/assets/img/3.webp" loading="lazy" alt="">
            </section>
            <section class="slider-section">
                <img src="./src/assets/img/4.webp" loading="lazy" alt="">
            </section>
            <section class="slider-section">
                <img src="./src/assets/img/5.webp" loading="lazy" alt="">
            </section>
            <section class="slider-section">
                <img src="./src/assets/img/6.webp" loading="lazy" alt="">
            </section>
            <section class="slider-section">
                <img src="./src/assets/img/7.webp" loading="lazy" alt="">
            </section>
            <section class="slider-section">
                <img src="./src/assets/img/8.webp" loading="lazy" alt="">
            </section>
            <section class="slider-section">
                <img src="./src/assets/img/9.webp" loading="lazy" alt="">
            </section>
            <section class="slider-section">
                <img src="./src/assets/img/10.webp" loading="lazy" alt="">
            </section>
        </div>
        <div class="btn-left">
            <img src="./src/assets/svg/arrow.svg" />
        </div>
        <div class="btn-right">
            <img src="./src/assets/svg/arrow-right.svg" />
        </div>
    </div>

    <script src="./src/js/index.js"></script>
    <script type="module" src="https://unpkg.com/cally"></script>
    <script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>
</body>
</html>