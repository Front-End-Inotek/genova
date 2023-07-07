<?php

echo ' 
<h1 class="pago">Metodo de pago / Metodo de garantia</h1>
<p id="choosen-paymenttype">tarjeta de credito</p>

   
    <!--Principal-->
   
        <div class="container-fluid blanco " style="width: 650px;">
            <h1>Tarjeta Credito</h1>
            <h2></h2>
            <header class="tarjeta">
                <div class="card" id="cc-card">
                    <div class="flipper">
                        <div class="front">
                            <div class="shine"></div>
                            <div class="shadow"></div>
                            <div class="card-bg">
                                <img src="https://s3-us-west-2.amazonaws.com/s.cdpn.io/513985/cc-front-bg.png" />
                            </div>
                            <div class="card-content">
                                <div class="credit-card-type"></div>
                                <div class="card-number">
                                    <span>1234 1234 1234 1234</span>
                                    <span>1234 1234 1234 1234</span>
                                </div>
                                <div class="card-holder">
                                    <span>Tu nombre</span>
                                    <span>Tu nombre</span>
                                </div>
                                <div class="validuntil">
                                    <em>Expira</em>
                                    <div class="e-month">
                                        <span>
                                            MM
                                        </span>
                                        <span>
                                            MM
                                        </span>
                                    </div>
                                    <div class="e-divider">
                                        <span>
                                            /
                                        </span>
                                        <span>
                                            /
                                        </span>
                                    </div>
                                    <div class="e-year">
                                        <span>
                                            YY
                                        </span>
                                        <span>
                                            YY
                                        </span>
                                    </div>

                                </div>
                            </div>
                        </div>

                        <div class="back">
                            <div class="shine"></div>
                            <div class="shadow"></div>
                            <div class="card-bg">
                                <img src="https://s3-us-west-2.amazonaws.com/s.cdpn.io/513985/cc-back-bg-new.png" />
                            </div>
                            <div class="ccv">
                                <em>Numero CCV</em>
                                <strong></strong>
                            </div>
                            <div class="card-content">
                                <div class="card-number">
                                    <span>4111 1111 1111 1111</span>
                                    <span>4111 1111 1111 1111</span>
                                </div>
                                <div class="card-holder">
                                    <span>Tu Nombre</span>
                                    <span>Tu Nombre</span>
                                </div>
                                <div class="validuntil">
                                    <span>
                                        <strong class="e-month">MM</strong> / <strong class="e-year">YY</strong>
                                    </span>
                                    <span>
                                        <strong class="e-month">MM</strong> /
                                        <strong class="e-year">YY</strong>
                                    </span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </header>

            <form class="tarjeta-form">
                <div class="form-content">
                    <div class="form-group">
                      <label for="cardnumber">Numero de tarjeta</label>
                      <div class="input-group">
                        <input type="tel" class="form-control" id="cardnumber" maxlength="20">
                        <div class="input-group-append">
                        </div>
                      </div>
                    </div>
                    <div class="form-group">
                      <label for="cardholder">Nombre en Tarjeta</label>
                      <div class="input-group">
                        <input type="text" class="form-control" id="cardholder" maxlength="25" autocorrect="off" spellcheck="false">
                        <div class="input-group-append">
                        </div>
                      </div>
                    </div>
                    <div class="form-group">
                      <div class="row">
                        <div class="col-6">
                          <label for="expires-month">Expira</label>
                          <div class="input-group expire-date">
                            <div class="input-group-prepend">
                            </div>
                            <input type="tel" class="form-control" id="expires-month" placeholder="MM" allowed-pattern="[0-9]" maxlength="2">
                            <div class="input-group-prepend divider">
                            </div>
                            <input type="tel" class="form-control" id="expires-year" placeholder="YY" allowed-pattern="[0-9]" maxlength="2">
                            <div class="input-group-append">
                            </div>
                          </div>
                        </div>
                        <div class="col-6">
                          <label for="ccv">CCV</label>
                          <div class="input-group ccv">
                            <input type="tel" class="form-control" id="ccv" autocomplete="off" maxlength="3">
                            <div class="input-group-append">
                            </div>
                          </div>
                        </div>
                      </div>
                    </div>
                  </div>
                    <br>
                    <div class="d-flex justify-content-between col-md-12">
                        <div class="form-check form-check-inline col-md-6">
                          <input class="form-check-input" type="checkbox" name="estado" value="preautorizar" id="check1">
                          <label class="form-check-label" for="check1">Pendiente de preautorizar</label>
                        </div>
                      
                        <div class="form-check form-check-inline col-3">
                          <input class="form-check-input" type="checkbox" name="estado" value="garantizada" id="check2">
                          <label class="form-check-label" for="check2">Garantizada</label>
                        </div>
                      
                        <div class="form-check form-check-inline col-3 mb-5">
                          <input class="form-check-input" type="checkbox" name="estado" value="sin garantia" id="check3">
                          <label class="form-check-label" for="check3">Sin garantía</label>
                        </div>
                      </div>
                    <button class="btn btn-success"><span>Enviar</span></button>
                </div>
                
            </form>
        </div>
        
';

