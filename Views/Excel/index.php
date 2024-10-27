<?php include "Views/Templates/header.php"; ?>

<div class="row">
    <div class="col-lg-6">
        <!-- Collapsable Card Example -->
        <div class="card shadow mb-4">
            <!-- Card Header - Accordion -->
            <a href="#collapseCardExample" class="d-block card-header py-3 bg-primary" data-toggle="collapse"
            role="button" aria-expanded="true" aria-controls="collapseCardExample">
                <h6 class="m-0 font-weight-bold text-white">Estudiantes</h6>
            </a>
            <!-- Card Content - Collapse -->
            <div class="collapse show" id="collapseCardExample">
                <div class="card-body">
                    <form id="frmcargaEstudiante" enctype="multipart/form-data">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="form-group">
                                <input type="file" id="file-estudiante" name="file-estudiante" accept=".cvs,.xlsx,.xls">
                            </div>
                        </div>
                        <div class="col-md-12">
                            <div class="form-group">
                                <button class="btn btn-primary btn-block" type="button" onclick="cargarExcelEstudiante(event)">Cargar</button>
                            </div>
                        </div>
                    </div>                   
                    </form>
                </div>
            </div>
        </div>
        
        <!-- Collapsable Card Example -->
        <div class="card shadow mb-4">
            <!-- Card Header - Accordion -->
            <a href="#collapseCardExample2" class="d-block card-header py-3 bg-primary" data-toggle="collapse"
            role="button" aria-expanded="true" aria-controls="collapseCardExample2">
                <h6 class="m-0 font-weight-bold text-white">Padres de familia</h6>
            </a>
            <!-- Card Content - Collapse -->
            <div class="collapse show" id="collapseCardExample2">
                <div class="card-body">
                    <form id="frmcargaFamilia" enctype="multipart/form-data">
                        <div class="row">
                            <div class="col-md-12">
                                <div class="form-group">
                                    <input type="file" id="file-familia" name="file-familia" accept=".cvs,.xlsx,.xls">
                                </div>
                            </div>
                            <div class="col-md-12">
                                <div class="form-group">
                                <button class="btn btn-primary btn-block" type="button" onclick="cargarExcelFamilia(event)">Cargar</button>
                                </div>
                            </div>
                        </div>                   
                    </form>
                </div>
            </div>
        </div>
        <!-- Collapsable Card Example -->
        <div class="card shadow mb-4">
            <!-- Card Header - Accordion -->
            <a href="#collapseCardExample4" class="d-block card-header py-3 bg-primary" data-toggle="collapse"
            role="button" aria-expanded="true" aria-controls="collapseCardExample4">
                <h6 class="m-0 font-weight-bold text-white">Matrículas</h6>
            </a>
            <!-- Card Content - Collapse -->
            <div class="collapse show" id="collapseCardExample4">
                <div class="card-body">
                    <form id="frmcargaMatricula" enctype="multipart/form-data">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="form-group">
                                <input type="file" id="file-matricula" name="file-matricula" accept=".cvs,.xlsx,.xls">
                            </div>
                        </div>
                        <div class="col-md-12">
                            <div class="form-group">
                            <button class="btn btn-primary btn-block" type="button" onclick="cargarExcelMatricula(event)">Cargar</button>
                            </div>
                        </div>
                    </div>                   
                    </form>
                </div>
            </div>
        </div>
    </div>
    <div class="col-lg-6">
        <!-- Collapsable Card Example -->
        <div class="card shadow mb-4">
            <!-- Card Header - Accordion -->
            <a href="#collapseCardExample3" class="d-block card-header py-3 bg-warning" data-toggle="collapse"
            role="button" aria-expanded="true" aria-controls="collapseCardExample3">
                <h6 class="m-0 font-weight-bold text-white">Personal</h6>
            </a>
            <!-- Card Content - Collapse -->
            <div class="collapse show" id="collapseCardExample3">
                <div class="card-body">
                    <form id="frmcargaPersonal" enctype="multipart/form-data">
                        <div class="row">
                            <div class="col-md-12">
                                <div class="form-group">
                                    <input type="file" id="file-personal" name="file-personal" accept=".cvs,.xlsx,.xls">
                                </div>
                            </div>
                            <div class="col-md-12">
                                <div class="form-group">
                                <button class="btn btn-warning btn-block text-white" type="button" onclick="cargarExcelPersonal(event)">Cargar</button>
                                </div>
                            </div>
                        </div>                   
                    </form>
                </div>
            </div>
        </div>
        <!-- Collapsable Card Example -->
        <div class="card shadow mb-4">
            <!-- Card Header - Accordion -->
            <a href="#collapseCardExample3" class="d-block card-header py-3 bg-success" data-toggle="collapse"
            role="button" aria-expanded="true" aria-controls="collapseCardExample3">
                <h6 class="m-0 font-weight-bold text-white">Descargas</h6>
            </a>
            <!-- Card Content - Collapse -->
            <div class="collapse show" id="collapseCardExample3">
                <div class="card-body">
                    <form id="frmcargaPersonal" enctype="multipart/form-data">
                        <div class="row">
                            <div class="col-md-12">
                                <div class="form-group">
                                    <a href="<?php echo base_url.'/Assets/plantillas/estudiante.xlsx'; ?>" class="d-none d-sm-inline-block btn btn-sm btn-primary shadow-sm mb-2"><i
                                    class="fas fa-download fa-sm text-white-50"></i> Plantilla Estudiante.xlsx</a>
                                    <a href="<?php echo base_url.'/Assets/plantillas/familia.xlsx'; ?>" class="d-none d-sm-inline-block btn btn-sm btn-primary shadow-sm mb-2"><i
                                    class="fas fa-download fa-sm text-white-50"></i> Plantilla Padres de Familia.xlsx</a>
                                    <a href="<?php echo base_url.'/Assets/plantillas/matricula.xlsx'; ?>" class="d-none d-sm-inline-block btn btn-sm btn-primary shadow-sm mb-2"><i
                                    class="fas fa-download fa-sm text-white-50"></i> Plantilla Matrícula.xlsx</a>
                                    <a href="<?php echo base_url.'/Assets/plantillas/personal.xlsx'; ?>" class="d-none d-sm-inline-block btn btn-sm btn-primary shadow-sm mb-2"><i
                                    class="fas fa-download fa-sm text-white-50"></i> Plantilla Personal.xlsx</a>
                                </div>
                            </div>                                                       
                        </div>                   
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<?php include "Views/Templates/footer.php"; ?>