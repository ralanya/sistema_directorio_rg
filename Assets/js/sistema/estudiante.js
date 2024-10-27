//LISTAR TABLAS
let tblEstudiantes;
document.addEventListener("DOMContentLoaded", function(){      
    //tabla estudiantes
    tblEstudiantes = $('#tblEstudiantes').DataTable( {
        ajax: {
            url: base_url + "Estudiantes/listar",
            dataSrc: ''
        },
        columns: [
            {
                'data' : 'id'
            },
            {
                'data' : 'numero'
            },
            {
                'data' : 'apellido_paterno'
            },
            {
                'data' : 'apellido_materno'
            },
            {
                'data' : 'nombres'
            },
            {
                'data' : 'sexo'
            },
            {
                'data' : 'grado'
            },
            {
                'data' : 'seccion'
            },           
            {
                'data' : 'estado'
            },
            {
                'data' : 'acciones'
            }           
        ],
        language: {
            "decimal": "",
            "emptyTable": "No hay información",
            "info": "Mostrando _START_ a _END_ de _TOTAL_ Registros",
            "infoEmpty": "Mostrando 0 to 0 of 0 Registros",
            "infoFiltered": "(Filtrado de _MAX_ total registros)",
            "infoPostFix": "",
            "thousands": ",",
            "lengthMenu": "Mostrar _MENU_ Registros",
            "loadingRecords": "Cargando...",
            "processing": "Procesando...",
            "search": "Buscar:",
            "zeroRecords": "Sin resultados encontrados",
            "paginate": {
                "first": "Primero",
                "last": "Ultimo",
                "next": "Siguiente",
                "previous": "Anterior"
            }
        }
    } );       
})
//ESTUDIANTES
function frmEstudiante() {
    document.getElementById("title").innerHTML = "Nuevo Estudiante";
    document.getElementById("btnAccion").innerHTML = "Registrar";
    $btnAccion = document.getElementById("btnAccion");
    btnAccion.style.display = 'inline';

    document.getElementById("frmEstudiante").reset();
    $('.nav-tabs li:eq(0) a').tab('show');
    $("#nuevo_estudiante").modal("show");
    document.getElementById("txtid").value = "";    

    //habilitando input dni
    document.getElementById('cbodocumento').readOnly = false; 
    document.getElementById('txtnumero').readOnly = false; 
    document.getElementById('txtnumeropadre').readOnly = false;  
    document.getElementById('txtnumeromadre').readOnly = false;    
    cerrar_estudiante();  
}

function registrarEst(e) {
    e.preventDefault();
    const documento = document.getElementById("cbodocumento");        
    const numero = document.getElementById("txtnumero");    
    const apellido_paterno = document.getElementById("txtapellidopaterno");
    const apellido_materno = document.getElementById("txtapellidomaterno");
    const nombres = document.getElementById("txtnombres");
    const sexo = document.getElementById("cbosexo");
    const fecha_nacimiento = document.getElementById("txtfecha");  
    const telefono = document.getElementById("txttelefono");
    const correo = document.getElementById("txtcorreo");

    //matricula
    const nivel = document.getElementById("cbonivel");
    const grado = document.getElementById("cbogrado");
    const seccion = document.getElementById("cboseccion");

    //familia
    const documentopadre = document.getElementById("cbodocumentopadre");        
    const numeropadre = document.getElementById("txtnumeropadre");  
    const apellidospadre = document.getElementById("txtapellidospadre");  
    const nombrespadre = document.getElementById("txtnombrespadre");  
    const sexopadre = document.getElementById("cbosexopadre");   
    const parentescopadre = document.getElementById("txtparentescopadre");   
    const telefonopadre = document.getElementById("txttelefonopadre");
    const correopadre = document.getElementById("txtcorreopadre");

    const documentomadre = document.getElementById("cbodocumentomadre");        
    const numeromadre = document.getElementById("txtnumeromadre");  
    const apellidosmadre = document.getElementById("txtapellidosmadre");  
    const nombresmadre = document.getElementById("txtnombresmadre");  
    const sexomadre = document.getElementById("cbosexomadre");   
    const parentescomadre = document.getElementById("txtparentescomadre");   
    const telefonomadre = document.getElementById("txttelefonomadre");
    const correomadre = document.getElementById("txtcorreomadre");

    //validacion    
    if(documento.value == "NA" || numero.value == "" || apellido_paterno.value == "" || apellido_materno.value == "" || nombres.value == "" || sexo.value == "NA" || fecha_nacimiento.value == ""){
        $('.nav-tabs li:eq(0) a').tab('show'); 
        alertas_error('Campos obligatorios (*) del perfil','warning');    
    }
    else if(nivel.value == "NA" || grado.value == "NA" || seccion.value == "NA"){
        $('.nav-tabs li:eq(1) a').tab('show'); 
        alertas_error('Campos obligatorios (*) de la matrícula','warning');           
    }
    else if(documentopadre.value == "NA" || numeropadre.value == "" || apellidospadre.value == "" || nombrespadre.value == "" || sexopadre.value == "" || parentescopadre.value == ""){
        $('.nav-tabs li:eq(2) a').tab('show'); 
        alertas_error('Campos obligatorios (*) del padre','warning');   
    }
    else if(documentomadre.value == "NA" || numeromadre.value == "" || apellidosmadre.value == "" || nombresmadre.value == "" || sexomadre.value == "" || parentescomadre.value == ""){
        $('.nav-tabs li:eq(3) a').tab('show'); 
        alertas_error('Campos obligatorios (*) de la madre','warning');   
    }
    else{
        const url = base_url + "Estudiantes/registrar";
        const frm = document.getElementById("frmEstudiante");
        const http = new XMLHttpRequest();
        http.open("POST", url, true);
        http.send(new FormData(frm));
        http.onreadystatechange = function(){
            if (this.readyState == 4 && this.status == 200) { 
                const res = JSON.parse(this.responseText);
                if (res.icono == "success") {
                    alertas(res.msg,res.icono);
                    frm.reset();
                    $("#nuevo_estudiante").modal("hide");
                    tblEstudiantes.ajax.reload();
                }else{
                    alertas_error(res.msg,res.icono);
                }
            }
        }
    }
}
//$fecha_formato = date("Y/m/d", strtotime($fecha));  
// fecha = res.fecha_nacimiento.split('/');
// fecha_format = fecha[2]+'-'+fecha[1]+'-'+fecha[0];

function btnEditarEst(id) {
    document.getElementById("title").innerHTML = "Editar Estudiante";
    document.getElementById("btnAccion").innerHTML = "Actualizar";
    $btnAccion = document.getElementById("btnAccion");
    btnAccion.style.display = 'inline';    

    //desabilitando input dni
    $('.nav-tabs li:eq(0) a').tab('show'); 
    document.getElementById('txtnumero').readOnly = true;  
      
    document.getElementById('txtnumeromadre').readOnly = true;  

    const url = base_url + "Estudiantes/editar/"+id;
    const http = new XMLHttpRequest();
    http.open("GET", url, true);
    http.send();
    http.onreadystatechange = function(){
        if (this.readyState == 4 && this.status == 200) { 
                  
            const res = JSON.parse(this.responseText);
            document.getElementById("txtid").value = res.estudiante.id;
            document.getElementById("cbodocumento").value = res.estudiante.documento;     
            document.getElementById("txtnumero").value = res.estudiante.numero;            
            document.getElementById("txtapellidopaterno").value = res.estudiante.apellido_paterno;
            document.getElementById("txtapellidomaterno").value = res.estudiante.apellido_materno;
            document.getElementById("txtnombres").value = res.estudiante.nombres;
            document.getElementById("cbosexo").value = res.estudiante.sexo;
            
            document.getElementById("txtfecha").value = res.estudiante.fecha_nacimiento;
            document.getElementById("txttelefono").value = res.estudiante.telefono;
            document.getElementById("txtcorreo").value = res.estudiante.correo;
            
            //matricula
            document.getElementById("cbonivel").value = res.matricula.nivel;    
                     
            document.getElementById("txtnivel").value = res.matricula.nivel;
            document.getElementById("txtgrado").value = res.matricula.grado;
            document.getElementById("txtseccion").value = res.matricula.seccion;
            
            document.getElementById("cbonivel").disabled = false; 
            document.getElementById("cbogrado").disabled = false; 
            document.getElementById("cboseccion").disabled = false; 

            let html1 = '';
            html1 += '<option value="'+res.matricula.grado+'">'+res.matricula.grado+'</option>';
            res.grados.forEach(row => {
                html1 += `<option value="${row['grado']}">${row['grado']}</option>`;
                });
            document.getElementById("cbogrado").innerHTML = html1; 
            let html2 = '';
            html2 += '<option value="'+res.matricula.seccion+'">'+res.matricula.seccion+'</option>';
            res.secciones.forEach(row => {
                html2 += `<option value="${row['seccion']}">${row['seccion']}</option>`;
            });
            document.getElementById("cboseccion").innerHTML = html2;            
            
            //familia
            //padre
            $documentopadre = document.getElementById("cbodocumentopadre");
            $numeropadre = document.getElementById("txtnumeropadre");
            $apellidospadre = document.getElementById("txtapellidospadre");
            $nombrespadre = document.getElementById("txtnombrespadre");
            $sexopadre = document.getElementById("cbosexopadre");
            $parentescopadre = document.getElementById("txtparentescopadre");
            $correopadre = document.getElementById("txtcorreopadre");
            $telefonopadre = document.getElementById("txttelefonopadre");
            
            //madre
            $documentomadre = document.getElementById("cbodocumentomadre");     
            $numeromadre = document.getElementById("txtnumeromadre");
            $apellidosmadre = document.getElementById("txtapellidosmadre");
            $nombresmadre = document.getElementById("txtnombresmadre");
            $sexomadre = document.getElementById("cbosexomadre");
            $parentescomadre = document.getElementById("txtparentescomadre");
            $correomadre = document.getElementById("txtcorreomadre");
            $telefonomadre = document.getElementById("txttelefonomadre"); 
            
            //padre
            if(res.padre.documento != undefined){
                $documentopadre.value = res.padre.documento;  
            }else{
                $documentopadre.value = "NA";
            }
            if(res.padre.numero != undefined){
                $numeropadre.value = res.padre.numero;  
                document.getElementById('txtnumeropadre').readOnly = true;
            }else{
                $numeropadre.value = "";
                document.getElementById('txtnumeropadre').readOnly = false;
            }            
            if(res.padre.apellidos != undefined){
                $apellidospadre.value = res.padre.apellidos;  
            }else{
                $apellidospadre.value = "";
            }
            if(res.padre.nombres != undefined){
                $nombrespadre.value = res.padre.nombres;  
            }else{
                $nombrespadre.value = "";
            }
            if(res.padre.sexo != undefined){
                $sexopadre.value = res.padre.sexo;  
            }else{
                $sexopadre.value = "H";
            }
            if(res.padre.parentesco != undefined){
                $parentescopadre.value = res.padre.parentesco;  
            }else{
                $parentescopadre.value = "";
            }
            if(res.padre.correo != undefined){
                $correopadre.value = res.padre.correo;  
            }else{
                $correopadre.value = "";
            }
            if(res.padre.telefono != undefined){
                $telefonopadre.value = res.padre.telefono;  
            }else{
                $telefonopadre.value = "";
            }
            //madre
            if(res.madre.documento != undefined){
                $documentomadre.value = res.madre.documento;  
            }else{
                $documentomadre.value = "NA";
            }
            if(res.madre.numero != undefined){
                $numeromadre.value = res.madre.numero;  
                document.getElementById('txtnumeromadre').readOnly = true;
            }else{
                $numeromadre.value = "";
                document.getElementById('txtnumeromadre').readOnly = false;
            }            
            if(res.madre.apellidos != undefined){
                $apellidosmadre.value = res.madre.apellidos;  
            }else{
                $apellidosmadre.value = "";
            }
            if(res.madre.nombres != undefined){
                $nombresmadre.value = res.madre.nombres;  
            }else{
                $nombresmadre.value = "";
            }
            if(res.madre.sexo != undefined){
                $sexomadre.value = res.madre.sexo;  
            }else{
                $sexomadre.value = "M";
            }
            if(res.madre.parentesco != undefined){
                $parentescomadre.value = res.madre.parentesco;  
            }else{
                $parentescomadre.value = "";
            }
            if(res.madre.correo != undefined){
                $correomadre.value = res.madre.correo;  
            }else{
                $correomadre.value = "";
            }
            if(res.madre.telefono != undefined){
                $telefonomadre.value = res.madre.telefono;  
            }else{
                $telefonomadre.value = "";
            }            
            $("#nuevo_estudiante").modal("show");
        }
    }      
}
function btnDetalleEst(id) {
    document.getElementById("title").innerHTML = "Detalle Estudiante";
    $btnAccion = document.getElementById("btnAccion");
    btnAccion.style.display = 'none';

    //desabilitando input dni
    $('.nav-tabs li:eq(0) a').tab('show'); 
    document.getElementById("cbodocumento").disabled = true;        
    document.getElementById("txtnumero").disabled = true; 
    document.getElementById("txtapellidopaterno").disabled = true; 
    document.getElementById("txtapellidomaterno").disabled = true; 
    document.getElementById("txtnombres").disabled = true; 
    document.getElementById("cbosexo").disabled = true; 
    document.getElementById("txtfecha").disabled = true; 
    document.getElementById("txttelefono").disabled = true; 
    document.getElementById("txtcorreo").disabled = true; 

    //matricula
    document.getElementById("cbonivel").disabled = true; 
    document.getElementById("cbogrado").disabled = true; 
    document.getElementById("cboseccion").disabled = true; 

    //familia
    document.getElementById("cbodocumentopadre").disabled = true;      
    document.getElementById("txtnumeropadre").disabled = true; 
    document.getElementById("txtapellidospadre").disabled = true; 
    document.getElementById("txtnombrespadre").disabled = true; 
    document.getElementById("cbosexopadre").disabled = true; 
    document.getElementById("txtparentescopadre").disabled = true; 
    document.getElementById("txttelefonopadre").disabled = true; 
    document.getElementById("txtcorreopadre").disabled = true; 

    document.getElementById("cbodocumentomadre").disabled = true;     
    document.getElementById("txtnumeromadre").disabled = true; 
    document.getElementById("txtapellidosmadre").disabled = true; 
    document.getElementById("txtnombresmadre").disabled = true; 
    document.getElementById("cbosexomadre").disabled = true; 
    document.getElementById("txtparentescomadre").disabled = true; 
    document.getElementById("txttelefonomadre").disabled = true; 
    document.getElementById("txtcorreomadre").disabled = true;   

    const url = base_url + "Estudiantes/editar/"+id;
    const http = new XMLHttpRequest();
    http.open("GET", url, true);
    http.send();
    http.onreadystatechange = function(){
        if (this.readyState == 4 && this.status == 200) {            
            const res = JSON.parse(this.responseText);
            document.getElementById("txtid").value = res.estudiante.id;
            document.getElementById("cbodocumento").value = res.estudiante.documento;     
            document.getElementById("txtnumero").value = res.estudiante.numero;            
            document.getElementById("txtapellidopaterno").value = res.estudiante.apellido_paterno;
            document.getElementById("txtapellidomaterno").value = res.estudiante.apellido_materno;
            document.getElementById("txtnombres").value = res.estudiante.nombres;
            document.getElementById("cbosexo").value = res.estudiante.sexo;
            document.getElementById("txtfecha").value = res.estudiante.fecha_nacimiento;
            document.getElementById("txttelefono").value = res.estudiante.telefono;
            document.getElementById("txtcorreo").value = res.estudiante.correo;

            //matricula
            document.getElementById("cbonivel").value = res.matricula.nivel;    
                     
            document.getElementById("txtnivel").value = res.matricula.nivel;
            document.getElementById("txtgrado").value = res.matricula.grado;
            document.getElementById("txtseccion").value = res.matricula.seccion;
            
            document.getElementById("cbonivel").disabled = true; 
            document.getElementById("cbogrado").disabled = true; 
            document.getElementById("cboseccion").disabled = true; 

            let html1 = '';
            html1 += '<option value="'+res.matricula.grado+'">'+res.matricula.grado+'</option>';
            res.grados.forEach(row => {
                html1 += `<option value="${row['grado']}">${row['grado']}</option>`;
                });
            document.getElementById("cbogrado").innerHTML = html1; 
            let html2 = '';
            html2 += '<option value="'+res.matricula.seccion+'">'+res.matricula.seccion+'</option>';
            res.secciones.forEach(row => {
                html2 += `<option value="${row['seccion']}">${row['seccion']}</option>`;
            });
            document.getElementById("cboseccion").innerHTML = html2; 
            
            //familia
            document.getElementById("cbodocumentopadre").value = res.padre.documento;     
            document.getElementById("txtnumeropadre").value = res.padre.numero;
            document.getElementById("txtapellidospadre").value = res.padre.apellidos;
            document.getElementById("txtnombrespadre").value = res.padre.nombres;
            document.getElementById("cbosexopadre").value = res.padre.sexo;
            document.getElementById("txtparentescopadre").value = res.padre.parentesco;
            document.getElementById("txtcorreopadre").value = res.padre.correo;
            document.getElementById("txttelefonopadre").value = res.padre.telefono; 
            
            document.getElementById("cbodocumentomadre").value = res.madre.documento;     
            document.getElementById("txtnumeromadre").value = res.madre.numero;
            document.getElementById("txtapellidosmadre").value = res.madre.apellidos;
            document.getElementById("txtnombresmadre").value = res.madre.nombres;
            document.getElementById("cbosexomadre").value = res.madre.sexo;
            document.getElementById("txtparentescomadre").value = res.madre.parentesco;
            document.getElementById("txtcorreomadre").value = res.madre.correo;
            document.getElementById("txttelefonomadre").value = res.madre.telefono; 
            
            $("#nuevo_estudiante").modal("show");
        }
    }      
}
function cerrar_estudiante() {
    $("#nuevo_estudiante").modal("hide");    
    
    document.getElementById("cbodocumento").disabled = false;        
    document.getElementById("txtnumero").disabled = false; 
    document.getElementById("txtapellidopaterno").disabled = false; 
    document.getElementById("txtapellidomaterno").disabled = false; 
    document.getElementById("txtnombres").disabled = false; 
    document.getElementById("cbosexo").disabled = false; 
    document.getElementById("txtfecha").disabled = false; 
    document.getElementById("txttelefono").disabled = false; 
    document.getElementById("txtcorreo").disabled = false; 

    //matricula
    document.getElementById("cbonivel").disabled = false; 
    document.getElementById("cbogrado").disabled = true; 
    document.getElementById("cboseccion").disabled = true; 

    //familia
    document.getElementById("cbodocumentopadre").disabled = false;      
    document.getElementById("txtnumeropadre").disabled = false; 
    document.getElementById("txtapellidospadre").disabled = false; 
    document.getElementById("txtnombrespadre").disabled = false; 
    document.getElementById("cbosexopadre").disabled = false; 
    document.getElementById("txtparentescopadre").disabled = false; 
    document.getElementById("txttelefonopadre").disabled = false; 
    document.getElementById("txtcorreopadre").disabled = false; 

    document.getElementById("cbodocumentomadre").disabled = false;     
    document.getElementById("txtnumeromadre").disabled = false; 
    document.getElementById("txtapellidosmadre").disabled = false; 
    document.getElementById("txtnombresmadre").disabled = false; 
    document.getElementById("cbosexomadre").disabled = false; 
    document.getElementById("txtparentescomadre").disabled = false; 
    document.getElementById("txttelefonomadre").disabled = false; 
    document.getElementById("txtcorreomadre").disabled = false; 

    document.getElementById("cbogrado").innerHTML = "";
    document.getElementById("cboseccion").innerHTML = "";
}
function btnEliminarEst(id) {
    Swal.fire({
        title: '¿Estás seguro?',
        text: "El estudiante cambiara ha estado inactivo",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Si, ¡Eliminalo!',
        cancelButtonText: 'Cancelar'
      }).then((result) => {
        if (result.isConfirmed) {
            const url = base_url + "Estudiantes/eliminar/"+id;
            const http = new XMLHttpRequest();
            http.open("GET", url, true);
            http.send();
            http.onreadystatechange = function(){
                if (this.readyState == 4 && this.status == 200) {
                    const res = JSON.parse(this.responseText);
                    if (res.icono == "success") {
                        alertas(res.msg, res.icono);
                        tblEstudiantes.ajax.reload();
                    }else{
                        alertas_error(res.msg, res.icono);
                    }
                }
            } 
            
        }
      })
}
function btnReingresarEst(id) {
    Swal.fire({
        title: '¿Estás seguro?',
        text: "El estudiante cambiara ha estado activo",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Si, ¡Reingresalo!',
        cancelButtonText: 'Cancelar'
      }).then((result) => {
        if (result.isConfirmed) {
            const url = base_url + "Estudiantes/reingresar/"+id;
            const http = new XMLHttpRequest();
            http.open("GET", url, true);
            http.send();
            http.onreadystatechange = function(){
                if (this.readyState == 4 && this.status == 200) {
                    const res = JSON.parse(this.responseText);
                    if (res.icono == "success") {
                        alertas(res.msg, res.icono);
                        tblEstudiantes.ajax.reload();
                    }else{
                        alertas_error(res.msg, res.icono);
                    }
                }
            }             
        }
      })
}

function cargarGrado() {
    document.getElementById("cboseccion").disabled = true; 
    document.getElementById("cbogrado").innerHTML = "";
    document.getElementById("cboseccion").innerHTML = "";
    document.getElementById("cbogrado").disabled = false; 
    let url;
    const nivel =  document.getElementById("cbonivel").value;                
    url = base_url + "Estudiantes/buscarGrado/" + nivel;
    const http = new XMLHttpRequest();
    http.open("GET", url, true);
    http.send();
    http.onreadystatechange = function(){
    if (this.readyState == 4 && this.status == 200) {
        const res = JSON.parse(this.responseText);
        let html = '';
        html += `<option value="NA">Seleccione una opción</option>`;
        res.detalle.forEach(row => {
        html += `<option value="${row['grado']}">${row['grado']}</option>`;
        });
        document.getElementById("cbogrado").innerHTML = html;                    
        }
    }
}
function cargarSeccion() {
    document.getElementById("cboseccion").innerHTML = "";
    document.getElementById("cboseccion").disabled = false; 
    let url;            
    url = base_url + "Estudiantes/buscarSeccion";
    const frm = document.getElementById("frmEstudiante");
    const http = new XMLHttpRequest();
    http.open("POST", url, true);
    http.send(new FormData(frm));
    http.onreadystatechange = function(){
    if (this.readyState == 4 && this.status == 200) {
        const res = JSON.parse(this.responseText);
        let html = '';
        html += `<option value="NA">Seleccione una opción</option>`;
        res.detalle.forEach(row => {
        html += `<option value="${row['seccion']}">${row['seccion']}</option>`;
        });
        document.getElementById("cboseccion").innerHTML = html;                    
        }
    }
}

function generarPDFEstudiante() {
    const ruta = base_url + 'Estudiantes/generarPDF';
    window.open(ruta); 
}