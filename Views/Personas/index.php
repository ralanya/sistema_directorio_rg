<?php include "Views/Templates/header.php"; 
$id_rol = $_SESSION['id_rol'];
?>
                    <!-- Page Heading -->
                    <h1 class="h3 mb-2 text-gray-800">Personas</h1>
                    <!-- DataTales Example -->
                    <div class="card shadow mb-4">
                        <div class="card-header py-3">
                            <h6 class="m-0 font-weight-bold text-primary">Listado</h6>
                        </div>
                        <div class="card-body">
                            <div class="table-responsive">
                                <?php if($id_rol == 1 || $id_rol == 2){ ?>
                                    <button class="btn btn-primary mb-2" type="button" onclick="frmPersona();">Nuevo <i class="fas fa-plus"></i></button>
                                <?php }else{}?> 
                                <button class="btn btn-danger mb-2" type="button" onclick="generarPDFPersona();">Generar PDF <i class="far fa-file-pdf"></i></button>                                                    
                                <table id="tblPersonas" class="table table-bordered" width="100%" cellspacing="0">
                                    <thead class="thead-dark">
                                        <tr>
                                            <th>Id</th>
                                            <th>Número</th>
                                            <th>Apellidos</th>
                                            <th>Nombres</th>
                                            <th>Sexo</th>                                      
                                            <th>Estado</th>
                                            <th width="12%">Acciones</th>
                                        </tr>
                                    </thead>
                                    <tfoot class="thead-dark">
                                        <tr>
                                            <th>Id</th>
                                            <th>Número</th>
                                            <th>Apellidos</th>
                                            <th>Nombres</th>
                                            <th>Sexo</th>
                                            <th>Estado</th>
                                            <th width="12%">Acciones</th>
                                        </tr>
                                    </tfoot>
                                    <tbody>
                                        
                                    </tbody>
                                </table>
                                <div id="nueva_persona" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="my-modal-title" aria-hidden="true">
                                    <div class="modal-dialog" role="document">
                                        <div class="modal-content">
                                            <div class="modal-header bg-primary">
                                                <h5 class="modal-title text-white" id="title"></h5>
                                                <button class="close" onclick="cerrar_persona(event);">
                                                    <span aria-hidden="true">&times;</span>
                                                </button>
                                            </div>
                                            <div class="modal-body">
                                                <form id="frmPersona" method="post">
                                                <input id="txtid" class="form-control" type="hidden" name="txtid">
                                                <!-- TAB NAVS -->
                                                <ul class="nav nav-tabs" id="myTab" role="tablist">
                                                    <li class="nav-item">
                                                        <a class="nav-link active" id="home-tab" data-toggle="tab" href="#home" role="tab" aria-controls="home" aria-selected="true">Perfil</a>
                                                    </li>                                                    
                                                    <li class="nav-item">
                                                        <a class="nav-link" id="contact-tab" data-toggle="tab" href="#contact" role="tab" aria-controls="contact" aria-selected="false">Contácto</a>
                                                    </li>
                                                </ul>
                                                <div class="tab-content" id="myTabContent">
                                                    <div class="tab-pane fade show active mt-2" id="home" role="tabpanel" aria-labelledby="home-tab">
                                                        <div class="row">
                                                            <div class="col md 6">
                                                                <div class="form-group">
                                                                    <label for="cbodocumento">Tipo Documento <span style="color:red">(*)</span></label>
                                                                    <select id="cbodocumento" class="form-control" name="cbodocumento">                                                                
                                                                        <option value="NA">Seleccione una opción</option>
                                                                        <option value="DNI">DNI</option>     
                                                                        <option value="CI">Cédula de Identidad</option>                                                   
                                                                    </select>
                                                                </div>                                                            
                                                            </div>
                                                            <div class="col md 6">
                                                                <div class="form-group">
                                                                    <label for="txtnumero">Número del Documento <span style="color:red">(*)</span></label>
                                                                    <input id="txtnumero" class="form-control" type="text" name="txtnumero" placeholder="Número del documento" maxlength="20" onkeypress="return solonumeros(event);">
                                                                </div>
                                                            </div>
                                                        </div>                                                    
                                                        <div class="form-group">
                                                            <label for="txtapellidos">Apellidos <span style="color:red">(*)</span></label>
                                                            <input id="txtapellidos" class="form-control" type="text" name="txtapellidos" placeholder="Apellidos" maxlength="30" onkeypress="return sololetras(event);">
                                                        </div>                                                 
                                                        <div class="form-group">
                                                            <label for="txtnombres">Nombres <span style="color:red">(*)</span></label>
                                                            <input id="txtnombres" class="form-control" type="text" name="txtnombres" placeholder="Nombres" maxlength="30" onkeypress="return sololetras(event);">
                                                        </div> 
                                                        <div class="row">
                                                            <div class="col md 6">
                                                                <div class="form-group">
                                                                    <label for="cbosexo">Sexo <span style="color:red">(*)</span></label>
                                                                    <select id="cbosexo" class="form-control" name="cbosexo">                                                                
                                                                        <option value="NA">Seleccione una opción</option>
                                                                        <option value="H">Hombre</option>     
                                                                        <option value="M">Mujer</option>                                                   
                                                                    </select>
                                                                </div>
                                                            </div>
                                                            <div class="col md 6">
                                                                <div class="form-group">
                                                                    <label for="txtfecha">F. Nacimiento <span style="color:red">(*)</span></label>
                                                                    <input id="txtfecha" class="form-control" type="date" name="txtfecha">
                                                                </div>
                                                            </div>
                                                        </div>       
                                                        <span style="color:red; font-size:0.8em;">Campos obligatorios (*)</span>                                                  
                                                        <div class="row">
                                                            <div class="col">
                                                                <span class="float-right"><button type="button" class="btn btn-light btn-sm ml-1" onclick="$('#contact-tab').trigger('click')"><i class="fas fa-arrow-right"></i> Siguiente</button></span>
                                                            </div>                                                            
                                                        </div>
                                                    </div>
                                                    <div class="tab-pane fade mt-2" id="contact" role="tabpanel" aria-labelledby="contact-tab">
                                                        <div class="row">                                                        
                                                            <div class="col md 6">
                                                                <div class="form-group">
                                                                    <label for="txtcorreo">Correo electrónico</label>
                                                                    <input id="txtcorreo" class="form-control" type="text" name="txtcorreo" placeholder="Correo electrónico">
                                                                </div>
                                                            </div>
                                                            <div class="col md 6">
                                                                <div class="form-group">
                                                                    <label for="txttelefono">Teléfono</label>
                                                                    <input id="txttelefono" class="form-control" type="text" name="txttelefono" placeholder="Teléfono">
                                                                </div>
                                                            </div>
                                                        </div> 
                                                        <div class="row">
                                                            <div class="col">                                                                
                                                                <span class="float-right"><button type="button" class="btn btn-light btn-sm ml-1" onclick="$('#home-tab').trigger('click')"><i class="fas fa-arrow-left"></i> Anterior</button></span>
                                                            </div>                                                            
                                                        </div>
                                                    </div>
                                                </div>
                                                <!-- FIN TABS -->                                             
                                                    <button class="btn btn-primary" type="button" onclick="registrarPerson(event);" id="btnAccion">Guardar</button>
                                                    <button class="btn btn-danger" type="button" onclick="cerrar_persona(event);">Cancelar</button>
                                                </form>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
<?php include "Views/Templates/footer.php"; ?>