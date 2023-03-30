    <!--todo el contenido que estre por dentro de este div sera desplegado junto a la barra de nav--->
    <!--tabla operativa--->
    <div class="row justify-content-center align-items-center">
        <div style="text-align:center;">
        <div>
            <h3>Marzo 2023<button id="btn-mes">▾</button></h3>
        </div>
        </div>

    </div>

    <!-- DISPLAY USER-->
    <div class="table-responsive">
        <div id="cal-largo">
        <div class="cal-sectionDiv">

            <table class="table table-striped table-bordered" id="tablaTotal">
            <thead class="cal-thead">
                <tr>
                <th class="cal-viewmonth" id="changemonth"></th>
                <th class="cal-dia" id="ayer">Miercoles 1</th>
                <th class="cal-dia" id="hoy">Jueves 2</th>
                <th class="cal-dia" id="dia1">Viernes 3</th>
                <th class="cal-dia" id="dia2">Sabado 4</th>
                <th class="cal-dia" id="dia3">Domingo 5</th>
                <th class="cal-dia" id="dia4">Lunes 6</th>
                <th class="cal-dia" id="dia5">Martes 7</th>
                <th class="cal-dia" id="dia6">Miercoles 8</th>
                <th class="cal-dia" id="dia7">Jueves 9</th>
                <th class="cal-dia" id="dia8">Viernes 10</th>
                <th class="cal-dia" id="dia9">Sabado 11</th>
                <th class="cal-dia" id="dia10">Domingo 12</th>
                <th class="cal-dia" id="dia11">Lunes 13</th>
                <th class="cal-dia" id="dia12">Martes 14</th>
                <th class="cal-dia" id="dia13">Miercoles 15</th>
                <th class="cal-dia" id="dia14">Jueves 16</th>
                <th class="cal-dia" id="dia15">Viernes 17</th>
                <th class="cal-dia" id="dia16">Sabado 18</th>
                <th class="cal-dia" id="dia17">Domingo 19</th>
                <th class="cal-dia" id="dia18">Lunes 20</th>
                <th class="cal-dia" id="dia19">Martes 21</th>
                <th class="cal-dia" id="dia20">Miercoles 22</th>
                <th class="cal-dia" id="dia21">Jueves 23</th>
                <th class="cal-dia" id="dia22">Viernes 24</th>
                <th class="cal-dia" id="dia23">Sabado 25</th>
                <th class="cal-dia" id="dia24">Domingo 26</th>
                <th class="cal-dia" id="dia25">Lunes 27</th>
                <th class="cal-dia" id="dia26">Martes 28</th>
                <th class="cal-dia" id="dia27">Miercoles 29</th>
                <th class="cal-dia" id="dia28">Jueves 30</th>
                <th class="cal-dia" id="dia29">Viernes 31</th>
                </tr>

            </thead>
            <tbody class="cal-tbody">

                <tr id="u1">
                <td class="cal-userinfo">
                    Habitacion #1
                </td>
                <!---colspan para agregar 2 o mas estados a una misma celda-->
                <td class="celda" data-date="1/7/2020" colspan="4">
                    <!---agregar un div task-container para agregar 2 estados en un mismo dia y con colspan alargar el restante 
                        el numero de dias de su reservacion-->
                    <div class="task-container">
                    <section class="task task--limpieza-vacia">Limpieza Vacia</section>
                    <section class="task task--reserva-pendiente-pago ajuste">Reserva pendiente de pago</section>
                    <section class="task task task--mantenimiento ajuste-2dias">Mantenimiento</section>
                    </div>
                </td>
                <td class="celdaCompleta" data-date="2/7/2020">
                    <section class="task task--vacia-sucia" title="aqui mas informacion">Vacia sucia</section>
                </td>
                <td class="celdaCompleta" data-date="3/7/2020">
                    <section class="task task--limpieza-ocupada">Limpieza Ocupada</section>
                </td>
                <td class="celdaCompleta" data-date="4/7/2020">
                    <section class="task task--vacia-sucia" onclick="mostrarInformacion()">Vacia sucia</section>
                </td>
                <td class="celdaCompleta" data-date="5/7/2020" data-userid="1">
                    <section class="task task--disponible-limpia">Disponible Limpia</section>
                </td>
                <td class="celdaCompleta" data-date="6/7/2020" data-userid="1">
                    <section class="task task--ocupada-sucia">Ocupada Sucia </section>
                </td>
                <td class="celdaCompleta" data-date="6/7/2020" data-userid="1">
                    <section class="task task--reserva-pagada">Reserva pagada </section>
                </td>
                <td class="celdaCompleta" data-date="4/7/2020" data-userid="1">
                    <section class="task task--bloqueado">Bloqueado</section>
                </td>
                <td class="celdaCompleta" data-date="6/7/2020">
                    <section class="task task--mantenimiento">Mantenimiento</section>
                </td>
                <td class="celdaCompleta" data-date="6/7/2020" data-userid="1">

                </td>
                <td class="celdaCompleta" data-date="6/7/2020" data-userid="1">

                </td>
                <td class="celdaCompleta" data-date="4/7/2020" data-userid="1">

                </td>
                </tr>
                <tr id="u1">
                <td class="cal-userinfo">
                    Habitacion #2
                    <div class="cal-usercounter">
                    </div>
                </td>
                <td class="celdaCompleta" data-date="6/7/2020">
                    <section class="task task--reserva-pendiente-pago" title="aqui mas informacion">Reserva pendiente pago
                    </section>
                    <td class="celda" data-date="1/7/2020" colspan="4">
                    <!---agregar un div task-container para agregar 2 estados en un mismo dia y con colspan alargar el restante 
                        el numero de dias de su reservacion-->
                    <div class="task-container">
                        <section class="task task--limpieza-vacia">Limpieza Vacia</section>
                        <section class="task task--reserva-pendiente-pago ajuste">Reserva pendiente de pago</section>
                        <section class="task task--limpieza-vacia ajuste-2dias">Limpieza Vacia</section>
                    </div>
                    </td>
                </td>
                <td class="celdaCompleta" data-date="1/7/2020" colspan="3">
                </td>
                </tr>
                <tr id="u1">
                <td class="cal-userinfo">
                    Habitacion #4
                </td>
                <td class="celdaCompleta" data-date="6/7/2020">
                    <section class="task task--uso-casa">Uso Casa </section>
                </td>
                </tr>
                <tr>
                <td class="cal-userinfo">
                    Habitacion #5
                </td>
                <td data-date="6/7/2020" data-userid="1">
                    <section class="task task--disponible-limpia">Disponible</section>
                </td>
                </tr>
                <tr>
                <td class="cal-userinfo">
                    Habitacion #6
                </td>
                </tr>
                <tr>
                <td class="cal-userinfo">
                    <span> Habitacion #7 </span>
                </td>
                <td class="celdaCompleta" data-date="6/7/2020" data-userid="1">
                    <section class="task task--mantenimiento">Mantenimiento</section>
                </td>
                </tr>
                <tr>
                <td class="cal-userinfo">
                    Habitacion #8
                </td>
                </tr>
                <tr>
                <td class="cal-userinfo">
                    Habitacion #9
                </td>
                </tr>
                <tr>
                <td class="cal-userinfo">
                    Habitacion #10
                </td>
                </tr>
                <tr>
                <td class="cal-userinfo">
                    Habitacion #11
                </td>
                </tr>
                <tr>
                <td class="cal-userinfo">
                    Habitacion #12
                </td>
                </tr>
                <tr>
                <td class="cal-userinfo">
                    Habitacion #13
                </td>
                </tr>
            </tbody>
            </table>
        </div>
        </div>
    </div>