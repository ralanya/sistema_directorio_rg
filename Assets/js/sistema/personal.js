//LISTAR TABLAS
let tblPersonales;
document.addEventListener("DOMContentLoaded", function(){     
    //tabla personales
    tblPersonales = $('#tblPersonales').DataTable( {
        ajax: {
            url: base_url + "Personales/listar",
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
                'data' : 'nombre'
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
function frmPersonal() {
    document.getElementById("title").innerHTML = "Nuevo Personal";
    document.getElementById("btnAccion").innerHTML = "Registrar";
    $btnAccion = document.getElementById("btnAccion");
    btnAccion.style.display = 'inline';

    document.getElementById("frmPersonal").reset();
    
    $('.nav-tabs li:eq(0) a').tab('show'); 

    $("#nuevo_personal").modal("show");
    document.getElementById("txtid").value = "";    

    //habilitando input dni    
    document.getElementById('txtnumero').readOnly = false;   
    cerrar_personal();    
}
function registrarPers(e) {
    e.preventDefault();     
    const documento = document.getElementById("cbodocumento");    
    const numero = document.getElementById("txtnumero");    
    const apellidos = document.getElementById("txtapellidos");
    const nombres = document.getElementById("txtnombres");
    const sexo = document.getElementById("cbosexo");
    const fecha_nacimiento = document.getElementById("txtfecha");  
    const telefono = document.getElementById("txttelefono");
    const correo = document.getElementById("txtcorreo");
    const especialidad = document.getElementById("txtespecialidad");
    const cargo = document.getElementById("cbocargo");
        
    if(documento.value == "NA" || numero.value == "" || apellidos.value == "" || nombres.value == "" || sexo.value == "NA"
    || fecha_nacimiento.value == ""){
        $('.nav-tabs li:eq(0) a').tab('show'); 
        alertas_error('Campos obligatorios (*) del perfil','warning'); 
    }
    else if(cargo.value == "NA"){
        $('.nav-tabs li:eq(1) a').tab('show');
        alertas_error('Campos obligatorios (*) de institucional','warning');   
    }else{
        const url = base_url + "Personales/registrar";
        const frm = document.getElementById("frmPersonal");
        const http = new XMLHttpRequest();
        http.open("POST", url, true);
        http.send(new FormData(frm));
        http.onreadystatechange = function(){
            if (this.readyState == 4 && this.status == 200) {         
                const res = JSON.parse(this.responseText);
                if (res.icono == "success") {
                    alertas(res.msg, res.icono);                    
                    frm.reset();
                    $("#nuevo_personal").modal("hide");
                    tblPersonales.ajax.reload();
                }else{
                    alertas_error(res.msg, res.icono);
                }       
            }
        }
    }
}
function btnEditarPers(id) {
    document.getElementById("title").innerHTML = "Editar Personal";
    document.getElementById("btnAccion").innerHTML = "Actualizar";
    $btnAccion = document.getElementById("btnAccion");
    btnAccion.style.display = 'inline';

    //desabilitando input dni
    $('.nav-tabs li:eq(0) a').tab('show'); 
    document.getElementById('txtnumero').readOnly = true; 
    
    const url = base_url + "Personales/editar/"+id;
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
            document.getElementById("txtespecialidad").value = res.especialidad;
            document.getElementById("cbocargo").value = res.id_cargo;
            $("#nuevo_personal").modal("show");
        }
    }      
}
function btnDetallePers(id) {
    document.getElementById("title").innerHTML = "Detalle Personal";
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
    document.getElementById("txtespecialidad").disabled = true; 
    document.getElementById("cbocargo").disabled = true; 
    
    const url = base_url + "Personales/editar/"+id;
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
            document.getElementById("txtespecialidad").value = res.especialidad;
            document.getElementById("cbocargo").value = res.id_cargo;
            $("#nuevo_personal").modal("show");
        }
    }
}
function cerrar_personal() {
    $("#nuevo_personal").modal("hide");
    document.getElementById('cbodocumento').disabled = false;   
    document.getElementById('txtnumero').disabled = false;         
    document.getElementById("txtapellidos").disabled = false; 
    document.getElementById("txtnombres").disabled = false; 
    document.getElementById("cbosexo").disabled = false; 
    document.getElementById("txtfecha").disabled = false; 
    document.getElementById("txttelefono").disabled = false; 
    document.getElementById("txtcorreo").disabled = false; 
    document.getElementById("txtespecialidad").disabled = false; 
    document.getElementById("cbocargo").disabled = false; 
}
function btnEliminarPers(id) {
    Swal.fire({
        title: '¿Estás seguro?',
        text: "El personal cambiara ha estado inactivo",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Si, ¡Eliminalo!',
        cancelButtonText: 'Cancelar'
      }).then((result) => {
        if (result.isConfirmed) {
            const url = base_url + "Personales/eliminar/"+id;
            const http = new XMLHttpRequest();
            http.open("GET", url, true);
            http.send();
            http.onreadystatechange = function(){
                if (this.readyState == 4 && this.status == 200) {
                    const res = JSON.parse(this.responseText);
                    if (res.icono == "success") {
                        alertas(res.msg, res.icono);
                        tblPersonales.ajax.reload();
                    }else{
                        alertas_error(res.msg, res.icono);
                    }
                }
            } 
            
        }
      })
}
function btnReingresarPers(id) {
    Swal.fire({
        title: '¿Estás seguro?',
        text: "El personal cambiara ha estado activo",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Si, ¡Reingresalo!',
        cancelButtonText: 'Cancelar'
      }).then((result) => {
        if (result.isConfirmed) {
            const url = base_url + "Personales/reingresar/"+id;
            const http = new XMLHttpRequest();
            http.open("GET", url, true);
            http.send();
            http.onreadystatechange = function(){
                if (this.readyState == 4 && this.status == 200) {
                    const res = JSON.parse(this.responseText);
                    if (res.icono == "success") {
                        alertas(res.msg, res.icono);
                        tblPersonales.ajax.reload();
                    }else{
                        alertas_error(res.msg, res.icono);
                    }
                }
            } 
            
        }
      })
}
function generarPDFPersonal() {
    const ruta = base_url + 'Personales/generarPDF';
    window.open(ruta); 
}