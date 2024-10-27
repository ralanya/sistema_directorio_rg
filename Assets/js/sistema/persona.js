//LISTAR TABLAS
let tblPersonas;
document.addEventListener("DOMContentLoaded", function(){     
    //tabla personales
    tblPersonas = $('#tblPersonas').DataTable( {
        ajax: {
            url: base_url + "Personas/listar",
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
                'data' : 'apellidos'
            },
            {
                'data' : 'nombres'
            },
            {
                'data' : 'sexo'
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
//PERSONAL
function frmPersona() {
    document.getElementById("title").innerHTML = "Nuevo Persona";
    document.getElementById("btnAccion").innerHTML = "Registrar";
    $btnAccion = document.getElementById("btnAccion");
    btnAccion.style.display = 'inline';

    document.getElementById("frmPersona").reset();
    
    $('.nav-tabs li:eq(0) a').tab('show'); 

    $("#nueva_persona").modal("show");
    document.getElementById("txtid").value = "";    

    //habilitando input dni    
    document.getElementById('txtnumero').readOnly = false;   
    //cerrar_persona();    
}
function registrarPerson(e) {
    e.preventDefault();     
    const documento = document.getElementById("cbodocumento");    
    const numero = document.getElementById("txtnumero");    
    const apellidos = document.getElementById("txtapellidos");
    const nombres = document.getElementById("txtnombres");
    const sexo = document.getElementById("cbosexo");
    const fecha_nacimiento = document.getElementById("txtfecha");  
    const telefono = document.getElementById("txttelefono");
    const correo = document.getElementById("txtcorreo");    
        
    if(documento.value == "NA" || numero.value == "" || apellidos.value == "" || nombres.value == "" || sexo.value == "NA"
    || fecha_nacimiento.value == ""){
        $('.nav-tabs li:eq(0) a').tab('show'); 
        alertas_error('Campos obligatorios (*) del perfil','warning');         
    }else{
        const url = base_url + "Personas/registrar";
        const frm = document.getElementById("frmPersona");
        const http = new XMLHttpRequest();
        http.open("POST", url, true);
        http.send(new FormData(frm));
        http.onreadystatechange = function(){
            if (this.readyState == 4 && this.status == 200) {     
                const res = JSON.parse(this.responseText);
                if (res.icono == "success") {
                    alertas(res.msg, res.icono);                    
                    frm.reset();
                    $("#nueva_persona").modal("hide");
                    tblPersonas.ajax.reload();
                }else{
                    alertas_error(res.msg, res.icono);
                }       
            }
        }
    }
}
function btnEditarPerson(id) {
    document.getElementById("title").innerHTML = "Editar Persona";
    document.getElementById("btnAccion").innerHTML = "Actualizar";
    $btnAccion = document.getElementById("btnAccion");
    btnAccion.style.display = 'inline';

    //desabilitando input dni
    $('.nav-tabs li:eq(0) a').tab('show'); 
    document.getElementById('txtnumero').readOnly = true; 
    
    const url = base_url + "Personas/editar/"+id;
    const http = new XMLHttpRequest();
    http.open("GET", url, true);
    http.send();
    http.onreadystatechange = function(){
        if (this.readyState == 4 && this.status == 200) {            
            const res = JSON.parse(this.responseText);
            document.getElementById("txtid").value = res.id;
            document.getElementById("cbodocumento").value = res.documento;     
            document.getElementById("txtnumero").value = res.numero;            
            document.getElementById("txtapellidos").value = res.apellidos;
            document.getElementById("txtnombres").value = res.nombres;
            document.getElementById("cbosexo").value = res.sexo;
            document.getElementById("txtfecha").value = res.fecha_nacimiento;
            document.getElementById("txttelefono").value = res.telefono;
            document.getElementById("txtcorreo").value = res.correo;
            $("#nueva_persona").modal("show");
        }
    }      
}
function btnDetallePerson(id) {
    document.getElementById("title").innerHTML = "Detalle Persona";
    $btnAccion = document.getElementById("btnAccion");
    btnAccion.style.display = 'none';
    
    //desabilitando
    $('.nav-tabs li:eq(0) a').tab('show'); 
    document.getElementById('txtnumero').disabled = true;  
    document.getElementById('cbodocumento').disabled = true;  
    document.getElementById("txtnumero").disabled = true;           
    document.getElementById("txtapellidos").disabled = true; 
    document.getElementById("txtnombres").disabled = true; 
    document.getElementById("cbosexo").disabled = true; 
    document.getElementById("txtfecha").disabled = true; 
    document.getElementById("txttelefono").disabled = true; 
    document.getElementById("txtcorreo").disabled = true; 
    
    const url = base_url + "Personas/editar/"+id;
    const http = new XMLHttpRequest();
    http.open("GET", url, true);
    http.send();
    http.onreadystatechange = function(){
        if (this.readyState == 4 && this.status == 200) {            
            const res = JSON.parse(this.responseText);
            document.getElementById("txtid").value = res.id;
            document.getElementById("cbodocumento").value = res.documento;     
            document.getElementById("txtnumero").value = res.numero;            
            document.getElementById("txtapellidos").value = res.apellidos;
            document.getElementById("txtnombres").value = res.nombres;
            document.getElementById("cbosexo").value = res.sexo;
            document.getElementById("txtfecha").value = res.fecha_nacimiento;
            document.getElementById("txttelefono").value = res.telefono;
            document.getElementById("txtcorreo").value = res.correo;
            $("#nueva_persona").modal("show");
        }
    }
}
function cerrar_persona() {
    $("#nueva_persona").modal("hide");
    document.getElementById('cbodocumento').disabled = false;   
    document.getElementById('txtnumero').disabled = false;         
    document.getElementById("txtapellidos").disabled = false; 
    document.getElementById("txtnombres").disabled = false; 
    document.getElementById("cbosexo").disabled = false; 
    document.getElementById("txtfecha").disabled = false; 
    document.getElementById("txttelefono").disabled = false; 
    document.getElementById("txtcorreo").disabled = false; 
}
function btnEliminarPerson(id) {
    Swal.fire({
        title: '¿Estás seguro?',
        text: "La persona cambiara ha estado inactivo",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Si, ¡Eliminalo!',
        cancelButtonText: 'Cancelar'
      }).then((result) => {
        if (result.isConfirmed) {
            const url = base_url + "Personas/eliminar/"+id;
            const http = new XMLHttpRequest();
            http.open("GET", url, true);
            http.send();
            http.onreadystatechange = function(){
                if (this.readyState == 4 && this.status == 200) {
                    const res = JSON.parse(this.responseText);
                    if (res.icono == "success") {
                        alertas(res.msg, res.icono);
                        tblPersonas.ajax.reload();
                    }else{
                        alertas_error(res.msg, res.icono);
                    }
                }
            } 
            
        }
      })
}
function btnReingresarPerson(id) {
    Swal.fire({
        title: '¿Estás seguro?',
        text: "La persona cambiara ha estado activo",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Si, ¡Reingresalo!',
        cancelButtonText: 'Cancelar'
      }).then((result) => {
        if (result.isConfirmed) {
            const url = base_url + "Personas/reingresar/"+id;
            const http = new XMLHttpRequest();
            http.open("GET", url, true);
            http.send();
            http.onreadystatechange = function(){
                if (this.readyState == 4 && this.status == 200) {
                    const res = JSON.parse(this.responseText);
                    if (res.icono == "success") {
                        alertas(res.msg, res.icono);
                        tblPersonas.ajax.reload();
                    }else{
                        alertas_error(res.msg, res.icono);
                    }
                }
            }             
        }
      })
}
function generarPDFPersona() {
    const ruta = base_url + 'Personas/generarPDF';
    window.open(ruta); 
}