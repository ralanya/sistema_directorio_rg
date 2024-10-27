graficaEstudiantesxNivel();
function graficaEstudiantesxNivel() {
    const url = base_url + "Dashboard/reporteEstudiantesxNivel";
    const http = new XMLHttpRequest();
    http.open("POST", url, true);
    http.send();
    http.onreadystatechange = function(){
    if (this.readyState == 4 && this.status == 200) {
            const res = JSON.parse(this.responseText);    
            let nivel = [];
            let cantidad = [];
            for (let i = 0; i < res.length; i++) {
                if(res[i]['nivel']=="I"){
                    $niveln = "Inicial";
                }else if(res[i]['nivel']=="P"){
                    $niveln = "Primaria";
                }else if(res[i]['nivel']=="S"){
                    $niveln = "Secundaria";
                }else{
                    $niveln = "Otros";
                }
                nivel.push($niveln);
                cantidad.push(res[i]['total']);                
            }    
            //productos más vendidos
            var ctx = document.getElementById("pieEstudiantesxNivel");
            var myPieChart = new Chart(ctx, {
            type: 'doughnut',
            data: {
                labels: nivel,
                datasets: [{
                data: cantidad,
                backgroundColor: ['#4e73df', '#1cc88a', '#36b9cc'],
                hoverBackgroundColor: ['#2e59d9', '#17a673', '#2c9faf'],
                hoverBorderColor: "rgba(234, 236, 244, 1)",
                }],
            },
            options: {
                maintainAspectRatio: false,
                tooltips: {
                backgroundColor: "rgb(255,255,255)",
                bodyFontColor: "#858796",
                borderColor: '#dddfeb',
                borderWidth: 1,
                xPadding: 15,
                yPadding: 15,
                displayColors: false,
                caretPadding: 10,
                },
                legend: {
                display: false
                },
                cutoutPercentage: 80,
            },
            });
        }
    }
}