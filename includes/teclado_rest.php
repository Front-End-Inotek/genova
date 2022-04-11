            <div class="col-sm-12" >
            <div class="card">
              <div class="card-header alinear_centro">
                <h5>Teclado</h5>
              </div>
              <div class="card-body alinear_izq" style="background-color:white;">';
                  <div class="row">
                    <div class="col-sm-2 margen_inf">
                      <button type="button" class="btn btn-warning btn-lg btn-block" onclick="agregar_text_rest(<?php echo $_GET['ident']?> , 7,<?php echo $_GET['total']?>)">7</button>
                    </div>
                    <div class="col-sm-2 margen_inf">
                      <button type="button" class="btn btn-warning btn-lg btn-block" onclick="agregar_text_rest(<?php echo $_GET['ident']?> , 8,<?php echo $_GET['total']?>)">8</button>
                    </div>
                    <div class="col-sm-2 margen_inf">
                      <button type="button" class="btn btn-warning btn-lg btn-block" onclick="agregar_text_rest(<?php echo $_GET['ident']?> , 9,<?php echo $_GET['total']?>)">9</button>
                    </div>
                  </div>
                  </br>
                  <div class="row">
                    <div class="col-sm-2 margen_inf">
                      <button type="button" class="btn btn-warning btn-lg btn-block" onclick="agregar_text_rest(<?php echo $_GET['ident']?> , 4,<?php echo $_GET['total']?>)">4</button>
                    </div>
                    <div class="col-sm-2 margen_inf">
                      <button type="button" class="btn btn-warning btn-lg btn-block" onclick="agregar_text_rest(<?php echo $_GET['ident']?> , 5,<?php echo $_GET['total']?>)">5</button>
                    </div>
                    <div class="col-sm-2 margen_inf">
                      <button type="button" class="btn btn-warning btn-lg btn-block" onclick="agregar_text_rest(<?php echo $_GET['ident']?> , 6,<?php echo $_GET['total']?>)">6</button>
                    </div>
                  </div>
                  </br>
                  <div class="row">
                    <div class="col-sm-2 margen_inf">
                      <button type="button" class="btn btn-warning btn-lg btn-block" onclick="agregar_text_rest(<?php echo $_GET['ident']?> , 1,<?php echo $_GET['total']?>)">1</button>
                    </div>
                    <div class="col-sm-2 margen_inf">
                      <button type="button" class="btn btn-warning btn-lg btn-block" onclick="agregar_text_rest(<?php echo $_GET['ident']?> , 2,<?php echo $_GET['total']?>)">2</button>
                    </div>
                    <div class="col-sm-2 margen_inf">
                      <button type="button" class="btn btn-warning btn-lg btn-block" onclick="agregar_text_rest(<?php echo $_GET['ident']?> , 3,<?php echo $_GET['total']?>)">3</button>
                    </div>
                  </div>
                  </br>
                  <div class="row">
                    <div class="col-sm-4 margen_inf">
                      <button type="button" class="btn btn-warning btn-lg btn-block" onclick="agregar_text_rest(<?php echo $_GET['ident']?> , 0,<?php echo $_GET['total']?>)">0</button>
                    </div>
                    <div class="col-sm-2 margen_inf">
                      <button type="button" class="btn btn-warning btn-lg btn-block" onclick="agregar_text_rest(<?php echo $_GET['ident']?> , '*',<?php echo $_GET['total']?>)">Borrar</button>
                    </div>

                  </div>
                </div>
              </div>
            </div>