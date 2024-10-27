<?php include "Views/Templates/header.php"; ?>
                    
                    <!-- Content Row -->
                    <div class="row">
                        <!-- Earnings (Monthly) Card Example -->
                        <div class="col-xl-3 col-md-6 mb-4">
                            <div class="card border-left-primary shadow h-100 py-2">
                                <div class="card-body">
                                    <div class="row no-gutters align-items-center">
                                        <div class="col mr-2">
                                            <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">
                                                Total Personal</div>
                                            <div class="h5 mb-0 font-weight-bold text-gray-800"><?php echo $data['Personal']['Total']; ?></div>
                                        </div>
                                        <div class="col-auto">
                                            <i class="fas fa-users-cog fa-2x text-gray-300"></i>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Earnings (Monthly) Card Example -->
                        <div class="col-xl-3 col-md-6 mb-4">
                            <div class="card border-left-success shadow h-100 py-2">
                                <div class="card-body">
                                    <div class="row no-gutters align-items-center">
                                        <div class="col mr-2">
                                            <div class="text-xs font-weight-bold text-success text-uppercase mb-1">
                                                Total Estudiantes</div>
                                            <div class="h5 mb-0 font-weight-bold text-gray-800"><?php echo $data['Estudiantes']['Total']; ?></div>
                                        </div>
                                        <div class="col-auto">
                                            <i class=" fas fa-user-friends fa-2x text-gray-300"></i>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Earnings (Monthly) Card Example -->
                        <div class="col-xl-3 col-md-6 mb-4">
                            <div class="card border-left-info shadow h-100 py-2">
                                <div class="card-body">
                                    <div class="row no-gutters align-items-center">
                                        <div class="col mr-2">
                                            <div class="text-xs font-weight-bold text-info text-uppercase mb-1">Total Padres de Familia
                                            </div>
                                            <div class="h5 mb-0 font-weight-bold text-gray-800"><?php echo $data['Familias']['Total']; ?></div>
                                        </div>
                                        <div class="col-auto">
                                            <i class="fas fa-users fa-2x text-gray-300"></i>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Pending Requests Card Example -->
                        <div class="col-xl-3 col-md-6 mb-4">
                            <div class="card border-left-warning shadow h-100 py-2">
                                <div class="card-body">
                                    <div class="row no-gutters align-items-center">
                                        <div class="col mr-2">
                                            <div class="text-xs font-weight-bold text-warning text-uppercase mb-1">
                                                Total Aulas</div>
                                            <div class="h5 mb-0 font-weight-bold text-gray-800"><?php echo $data['Aulas']['Total']; ?></div>
                                        </div>
                                        <div class="col-auto">
                                            <i class="fas fa-house-user fa-2x text-gray-300"></i>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Content Row -->
                    <div class="row">
                        <!-- Area Chart -->
                        <div class="col-xl-8 col-lg-7">
                            <div class="card shadow mb-4">
                                <!-- Card Header - Dropdown -->
                                <div
                                    class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                                    <h6 class="m-0 font-weight-bold text-primary">Cumpleaños del mes de <?php 
                                    $meseng = date("F");
                                    switch($meseng)
                                    {   
                                        case "January": $mesesp = "Enero";  break;  case "February": $mesesp = "Febrero";  break;
                                        case "March": $mesesp = "Marzo";  break;    case "April": $mesesp = "Abril";  break;
                                        case "May": $mesesp = "Mayo";  break;       case "June": $mesesp = "Junio";  break;
                                        case "July": $mesesp = "Julio";  break;     case "August": $mesesp = "Agosto";  break;
                                        case "September": $mesesp = "Setiembre";  break;  case "October": $mesesp = "Octubre";  break;
                                        case "November": $mesesp = "Noviembre";  break;   case "December": $mesesp = "Diciembre";  break;
                                    }
                                    echo $mesesp; ?>:</h6>                                    
                                </div>
                                <!-- Card Body -->
                                <div class="card-body">
                                    <div class="table-responsive">                                
                                        <table id="tblCumple" class="table table-bordered" width="100%" cellspacing="0">
                                            <thead class="thead-dark">
                                                <tr>
                                                    <th>Apellidos</th>
                                                    <th>Nombres</th>
                                                    <th>Fecha</th>                                                    
                                                    <th>Sexo</th>
                                                    <th>Cargo</th>                                                    
                                                </tr>
                                            </thead>
                                            
                                            <tbody>
                                                
                                            <?php                                             
                                            if(!empty($data['Cumples'])){
                                                foreach($data['Cumples'] as $row){
                                                    echo "<tr>";
                                                    echo "<td>".$row['apellidos']."</td>";
                                                    echo "<td>".$row['nombres']."</td>";
                                                    echo "<td>".$row['FNac']."</td>";
                                                    echo "<td>".$row['sexo']."</td>";
                                                    echo "<td>".$row['nombre']."</td>";
                                                    echo "</tr>";
                                                }
                                            }
                                            else{
                                                echo "<tr>";
                                                echo "<td colspan='5'>No hay datos para mostrar</td>";
                                                echo "</tr>";
                                            }
                                            
                                            ?>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Pie Chart -->
                        <div class="col-xl-4 col-lg-5">
                            <div class="card shadow mb-4">
                                <!-- Card Header - Dropdown -->
                                <div
                                    class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                                    <h6 class="m-0 font-weight-bold text-primary">Estudiantes matriculados por nivel</h6>                                    
                                </div>
                                <!-- Card Body -->
                                <div class="card-body">                                    
                                        <canvas id="pieEstudiantesxNivel" width="300" height="300"></canvas>                                                                      
                                </div>
                            </div>
                        </div>
                    </div>                   

<!-- Page level plugins -->    
<?php include "Views/Templates/footer.php"; ?>