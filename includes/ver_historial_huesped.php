<?php
    date_default_timezone_set('America/Mexico_CIty');
    echo '
    <div class="container-fluid blanco">
    <div class="col-12 text-center"><h2 class="text-dark">Historial del cliente</h2></div>

    <div class="flex-wrap row>
        <div class="col-12 col-sm-4">
        <p>Nombre del huesped</p>
    </div>

    <table class="table table-striped">
  <thead>
    <tr>
      <th scope="col">Fecha</th>
      <th scope="col">Tipo</th>
      <th scope="col">Cargo</th>
      <th scrop="col">Abono</th>
      <th scope="col">Descripción</th>
    </tr>
  </thead>
  <tbody>
    <tr>
      <th scope="row">26/7/2023</th>
      <td>Hospedaje </td>
      <td>$8070</td>
      <td>0</td>
      <td>Hospedaje en suite </td>
    </tr>
    <tr>
      <th scope="row">26/7/2023</th>
      <td>Extra hab</td>
      <td>400</td>
      <td>0</td>
      <td>1 adulto extra</td>
    </tr>
    <tr>
      <th scope="row">26/7/2023</th>
      <td>Comida rest</td>
      <td>$500</td>
      <td>0</td>
      <td>Buffet</td>
    </tr>
  </tbody>
</table>
    ';
?>