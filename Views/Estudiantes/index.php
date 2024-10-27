<?php include "Views/Templates/header.php"; 
$id_rol = $_SESSION['id_rol'];
?>
                    <!-- Page Heading -->
                    <h1 class="h3 mb-2 text-gray-800">Estudiantes</h1>

                    <!-- DataTales Example -->
                    <div class="card shadow mb-4">
                        <div class="card-header py-3">
                            <h6 class="m-0 font-weight-bold text-primary">Listado</h6>
                        </div>
                        <div class="card-body">
                            <div class="table-responsive">
                                <?php if($id_rol == 1 || $id_rol == 2){ ?>
                                    <button class="btn btn-primary mb-2" type="button" onclick="frmEstudiante();">Nuevo <i class="fas fa-plus"></i></button>                                
                                <?php }else{}?>
                                <button class="btn btn-danger mb-2" type="button" onclick="generarPDFEstudiante();">Generar PDF <i class="far fa-file-pdf"></i></button>                                                    
                                <table id="tblEstudiantes" class="table table-bordered" width="100%" cellspacing="0">
                                    <thead class="thead-dark">
                                        <tr>
                                            <th>Id</th>
                                            <th>Número</th>
                                            <th>A. Paterno</th>
                                            <th>A. Materno</th>
                                            <th>Nombres</th>
                                            <th>Sexo</th>
                                            <th>Grado</th>
                                            <th>Sección</th>
                                            <th>Estado</th>
                                            <th width="18%">Acciones</th>
                                        </tr>
                                    </thead>
                                    <tfoot class="thead-dark">
                                        <tr>
                                            <th>Id</th>                                            
                                            <th>Número</th>
                                            <th>A. Paterno</th>
                                            <th>A. Materno</th>
                                            <th>Nombres</th>
                                            <th>Sexo</th>
                                            <th>Grado</th>
                                            <th>Sección</th>
                                            <th>Estado</th>
                                            <th width="18%">Acciones</th>
                                        </tr>
                                    </tfoot>
                                    <tbody>
                                        
                                    </tbody>
                                </table>
                                <div id="nuevo_estudiante" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="my-modal-title" aria-hidden="true">
                                    <div class="modal-dialog" role="document">
                                        <div class="modal-content">
                                            <div class="modal-header bg-primary">
                                                <h5 class="modal-title text-white" id="title"></h5>
                                                <button class="close" onclick="cerrar_estudiante(event);">
                                                    <span aria-hidden="true">&times;</span>
                                                </button>
                                            </div>
                                            <div class="modal-body">
                                                <form id="frmEstudiante" method="post">
                                                    <input id="txtid" class="form-control" type="hidden" name="txtid">
                                                    <!-- TAB NAVS -->
                                                    <ul class="nav nav-tabs" id="myTab" role="tablist">
                                                        <li class="nav-item">
                                                            <a class="nav-link active" id="home-tab" data-toggle="tab" href="#home" role="tab" aria-controls="home" aria-selected="true">Perfil</a>
                                                        </li>
                                                        <li class="nav-item">
                                                            <a class="nav-link" id="profile-tab" data-toggle="tab" href="#profile" role="tab" aria-controls="profile" aria-selected="false">Matrícula</a>
                                                        </li>
                                                        <li class="nav-item">
                                                            <a class="nav-link" id="family-tab" data-toggle="tab" href="#family" role="tab" aria-controls="family" aria-selected="false">Padre</a>
                                                        </li>
                                                        <li class="nav-item">
                                                            <a class="nav-link" id="family2-tab" data-toggle="tab" href="#family2" role="tab" aria-controls="family2" aria-selected="false">Madre</a>
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
                                                                        <label for="cbodocumento">Documento <span style="color:red">(*)</span></label>
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
                                                            <div class="row">
                                                                <div class="col md 6">
                                                                    <div class="form-group">
                                                                        <label for="txtapellidopaterno">Apellido Paterno <span style="color:red">(*)</span></label>
                                                                        <input id="txtapellidopaterno" class="form-control" type="text" name="txtapellidopaterno" placeholder="Apellido Paterno" onkeypress="return sololetras(event);">
                                                                    </div>
                                                                </div>
                                                                <div class="col md 6">
                                                                    <div class="form-group">
                                                                        <label for="txtapellidomaterno">Apellido Materno <span style="color:red">(*)</span></label>
                                                                        <input id="txtapellidomaterno" class="form-control" type="text" name="txtapellidomaterno" placeholder="Apellido Materno" onkeypress="return sololetras(event);">
                                                                    </div>
                                                                </div>
                                                            </div>                                                    
                                                            <div class="form-group">
                                                                <label for="txtnombres">Nombres <span style="color:red">(*)</span></label>
                                                                <input id="txtnombres" class="form-control" type="text" name="txtnombres" placeholder="Nombres" onkeypress="return sololetras(event);">
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
                                                                        <label for="txtfecha">Fecha Nacimiento <span style="color:red">(*)</span></label>
                                                                        <input id="txtfecha" class="form-control" type="date" name="txtfecha">
                                                                    </div>
                                                                </div>
                                                            </div>    
                                                            <span style="color:red; font-size:0.8em;">Campos obligatorios (*)</span>                                                         
                                                            <div class="row">
                                                                <div class="col">
                                                                    <span class="float-right"><button type="button" class="btn btn-light btn-sm ml-1" onclick="$('#profile-tab').trigger('click')"><i class="fas fa-arrow-right"></i> Siguiente</button></span>
                                                                </div>                                                            
                                                            </div>                                                            
                                                        </div>
                                                        <div class="tab-pane fade mt-2" id="profile" role="tabpanel" aria-labelledby="profile-tab">
                                                            <div class="row">
                                                                <div class="col md 12">
                                                                    <div class="form-group">
                                                                        <label for="cbonivel">Nivel <span style="color:red">(*)</span></label>
                                                                        <input id="txtnivel" class="form-control" type="hidden" name="txtnivel">
                                                                        <select id="cbonivel" class="form-control" name="cbonivel" onchange="cargarGrado()">                                                                
                                                                            <option value="NA">Seleccione una opción</option>
                                                                            <option value="I">Inicial</option>     
                                                                            <option value="P">Primaria</option>
                                                                            <option value="S">Secundaria</option>                                                   
                                                                        </select>
                                                                    </div>
                                                                </div>                                                                
                                                            </div>
                                                            <div class="row">                                                                
                                                                <div class="col md 6">
                                                                    <div class="form-group">                                                                       
                                                                        <label for="cbogrado">Grado <span style="color:red">(*)</span></label>
                                                                        <input id="txtgrado" class="form-control" type="hidden" name="txtgrado">
                                                                        <select id="cbogrado" class="form-control" name="cbogrado" onchange="cargarSeccion()" >                                                         
                                                                        </select>
                                                                    </div>
                                                                </div>
                                                                <div class="col md 6">
                                                                    <div class="form-group">
                                                                        <label for="cboseccion">Sección <span style="color:red">(*)</span></label>
                                                                        <input id="txtseccion" class="form-control" type="hidden" name="txtseccion" >
                                                                        <select id="cboseccion" class="form-control" name="cboseccion">                                                                                                                                     
                                                                        </select>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <span style="color:red; font-size:0.8em;">Campos obligatorios (*)</span> 
                                                            <div class="row">
                                                                <div class="col">
                                                                    <span class="float-right"><button type="button" class="btn btn-light btn-sm ml-1" onclick="$('#family-tab').trigger('click')"><i class="fas fa-arrow-right"></i> Siguiente</button></span>
                                                                    <span class="float-right"><button type="button" class="btn btn-light btn-sm ml-1" onclick="$('#home-tab').trigger('click')"><i class="fas fa-arrow-left"></i> Anterior</button></span>
                                                                </div>                                                            
                                                            </div>                                                             
                                                        </div>
                                                        <div class="tab-pane fade mt-2" id="family" role="tabpanel" aria-labelledby="family-tab">
                                                            <div class="row">
                                                                <div class="col md 6">
                                                                    <div class="form-group">
                                                                        <label for="cbodocumentopadre">Documento <span style="color:red">(*)</span></label>
                                                                        <select id="cbodocumentopadre" class="form-control" name="cbodocumentopadre">                                                                
                                                                            <option value="NA">Seleccione una opción</option>
                                                                            <option value="DNI">DNI</option>     
                                                                            <option value="CI">Cédula de Identidad</option>                                                   
                                                                        </select>
                                                                    </div>                                                            
                                                                </div>
                                                                <div class="col md 6">
                                                                    <div class="form-group">
                                                                        <label for="txtnumeropadre">Número del Documento <span style="color:red">(*)</span></label>
                                                                        <input id="txtnumeropadre" class="form-control" type="text" name="txtnumeropadre" placeholder="Número del documento" maxlength="20" onkeypress="return solonumeros(event);">
                                                                    </div>
                                                                </div>
                                                            </div>                                                    
                                                            <div class="row">
                                                                <div class="col md 6">
                                                                    <div class="form-group">
                                                                        <label for="txtapellidospadre">Apellidos <span style="color:red">(*)</span></label>
                                                                        <input id="txtapellidospadre" class="form-control" type="text" name="txtapellidospadre" placeholder="Apellidos" onkeypress="return sololetras(event);">
                                                                    </div>                                                    
                                                                </div>
                                                                <div class="col md 6">
                                                                    <div class="form-group">
                                                                        <label for="txtnombrespadre">Nombres <span style="color:red">(*)</span></label>
                                                                        <input id="txtnombrespadre" class="form-control" type="text" name="txtnombrespadre" placeholder="Nombres" onkeypress="return sololetras(event);">
                                                                    </div> 
                                                                </div>
                                                            </div> 
                                                            <div class="row">
                                                                <div class="col md 6">
                                                                    <div class="form-group">
                                                                        <label for="cbosexopadre">Sexo <span style="color:red">(*)</span></label>
                                                                        <select id="cbosexopadre" class="form-control" name="cbosexopadre">                                                                
                                                                            <option value="H">Hombre</option>   
                                                                        </select>
                                                                    </div>
                                                                </div>
                                                                <div class="col md 6">
                                                                    <div class="form-group">
                                                                        <label for="txtparentescopadre">Parentesco <span style="color:red">(*)</span></label>
                                                                        <input id="txtparentescopadre" class="form-control" type="text" name="txtparentescopadre" placeholder="Parentesco">
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div class="row">                                                        
                                                                <div class="col md 6">
                                                                    <div class="form-group">
                                                                        <label for="txtcorreopadre">Correo electrónico</label>
                                                                        <input id="txtcorreopadre" class="form-control" type="text" name="txtcorreopadre" placeholder="Correo electrónico">
                                                                    </div>
                                                                </div>
                                                                <div class="col md 6">
                                                                    <div class="form-group">
                                                                        <label for="txttelefonopadre">Teléfono</label>
                                                                        <input id="txttelefonopadre" class="form-control" type="text" name="txttelefonopadre" placeholder="Teléfono">
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <span style="color:red; font-size:0.8em;">Campos obligatorios (*)</span>  
                                                            <div class="row">
                                                                <div class="col">
                                                                    <span class="float-right"><button type="button" class="btn btn-light btn-sm ml-1" onclick="$('#family2-tab').trigger('click')"><i class="fas fa-arrow-right"></i> Siguiente</button></span>
                                                                    <span class="float-right"><button type="button" class="btn btn-light btn-sm ml-1" onclick="$('#profile-tab').trigger('click')"><i class="fas fa-arrow-left"></i> Anterior</button></span>
                                                                </div>                                                            
                                                            </div>
                                                        </div>
                                                        <div class="tab-pane fade mt-2" id="family2" role="tabpanel" aria-labelledby="family2-tab">
                                                            <div class="row">
                                                                <div class="col md 6">
                                                                    <div class="form-group">
                                                                        <label for="cbodocumentomadre">Documento <span style="color:red">(*)</span></label>
                                                                        <select id="cbodocumentomadre" class="form-control" name="cbodocumentomadre">                                                                
                                                                            <option value="NA">Seleccione una opción</option>
                                                                            <option value="DNI">DNI</option>     
                                                                            <option value="CI">Cédula de Identidad</option>                                                   
                                                                        </select>
                                                                    </div>                                                            
                                                                </div>
                                                                <div class="col md 6">
                                                                    <div class="form-group">
                                                                        <label for="txtnumeromadre">Número del Documento <span style="color:red">(*)</span></label>
                                                                        <input id="txtnumeromadre" class="form-control" type="text" name="txtnumeromadre" placeholder="Número del documento" maxlength="20" onkeypress="return solonumeros(event);">
                                                                    </div>
                                                                </div>
                                                            </div> 
                                                            <div class="row">
                                                                <div class="col md 6">
                                                                    <div class="form-group">
                                                                        <label for="txtapellidosmadre">Apellidos <span style="color:red">(*)</span></label>
                                                                        <input id="txtapellidosmadre" class="form-control" type="text" name="txtapellidosmadre" placeholder="Apellidos" onkeypress="return sololetras(event);">
                                                                    </div>                                                    
                                                                </div>
                                                                <div class="col md 6">
                                                                    <div class="form-group">
                                                                        <label for="txtnombresmadre">Nombres <span style="color:red">(*)</span></label>
                                                                        <input id="txtnombresmadre" class="form-control" type="text" name="txtnombresmadre" placeholder="Nombres" onkeypress="return sololetras(event);">
                                                                    </div> 
                                                                </div>
                                                            </div>                                                 
                                                            <div class="row">
                                                                <div class="col md 6">
                                                                    <div class="form-group">
                                                                        <label for="cbosexomadre">Sexo <span style="color:red">(*)</span></label>
                                                                        <select id="cbosexomadre" class="form-control" name="cbosexomadre">                                                                
                                                                            <option value="M">Mujer</option>                                                   
                                                                        </select>
                                                                    </div>
                                                                </div>
                                                                <div class="col md 6">
                                                                    <div class="form-group">
                                                                        <label for="txtparentescomadre">Parentesco <span style="color:red">(*)</span></label>
                                                                        <input id="txtparentescomadre" class="form-control" type="text" name="txtparentescomadre" placeholder="Parentesco">
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div class="row">                                                        
                                                                <div class="col md 6">
                                                                    <div class="form-group">
                                                                        <label for="txtcorreomadre">Correo electrónico</label>
                                                                        <input id="txtcorreomadre" class="form-control" type="text" name="txtcorreomadre" placeholder="Correo electrónico">
                                                                    </div>
                                                                </div>
                                                                <div class="col md 6">
                                                                    <div class="form-group">
                                                                        <label for="txttelefonomadre">Teléfono</label>
                                                                        <input id="txttelefonomadre" class="form-control" type="text" name="txttelefonomadre" placeholder="Teléfono">
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <span style="color:red; font-size:0.8em;">Campos obligatorios (*)</span>  
                                                            <div class="row">
                                                                <div class="col">
                                                                    <span class="float-right"><button type="button" class="btn btn-light btn-sm ml-1" onclick="$('#contact-tab').trigger('click')"><i class="fas fa-arrow-right"></i> Siguiente</button></span>
                                                                    <span class="float-right"><button type="button" class="btn btn-light btn-sm ml-1" onclick="$('#family-tab').trigger('click')"><i class="fas fa-arrow-left"></i> Anterior</button></span>
                                                                </div>                                                            
                                                            </div>
                                                        </div>
                                                        <div class="tab-pane fade mt-2" id="contact" role="tabpanel" aria-labelledby="contact-tab">
                                                            <div class="row">
                                                                <div class="col md 6">
                                                                    <div class="form-group">
                                                                        <label for="txttelefono">Teléfono</label>
                                                                        <input id="txttelefono" class="form-control" type="text" name="txttelefono" placeholder="Teléfono">
                                                                    </div>
                                                                </div>
                                                                <div class="col md 6">
                                                                    <div class="form-group">
                                                                        <label for="txtcorreo">Correo electrónico</label>
                                                                        <input id="txtcorreo" class="form-control" type="text" name="txtcorreo" placeholder="Correo electrónico">
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div class="row">
                                                                <div class="col">                                                                    
                                                                    <span class="float-right"><button type="button" class="btn btn-light btn-sm ml-1" onclick="$('#family2-tab').trigger('click')"><i class="fas fa-arrow-left"></i> Anterior</button></span>
                                                                </div>                                                            
                                                            </div>
                                                        </div>
                                                                                                              
                                                    </div>
                                                    <!-- FIN TABS -->   
                                                    <button class="btn btn-primary" type="button" onclick="registrarEst(event);" id="btnAccion">Guardar</button>
                                                    <button class="btn btn-danger" type="button" onclick="cerrar_estudiante(event);">Cancelar</button>
                                                </form>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
<?php include "Views/Templates/footer.php"; ?>