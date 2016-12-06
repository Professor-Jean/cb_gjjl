function filtrarFinanceiro() {
    var ano = $('#selano').val();
    var datai = $('#txtdatai').val();
    var dataf = $('#txtdataf').val();
    var tipo = $('#seltipo').val();
    var cliente = $('#txtcliente').val();
    $.ajax({
        type: "POST",
        url: "reports/cb_financesfilter_reports.php",
        data: {ano: ano, datai: datai, dataf:dataf, tipo:tipo, cliente:cliente},
        success: function(dados){
            $('.consulta_ganhos tbody tr').remove();
            $('.consulta_despesas tbody tr').remove();
            var filtrar = JSON.parse(dados);
            //alert(filtrar[4]);
            //$('#grafico').html(filtrar[4]);

            gerarGraf(filtrar[4], filtrar[5], filtrar[8]);

            for(var auxG=0; auxG<filtrar[6]; auxG++) {
                $('.consulta_ganhos tbody').append(filtrar[0][auxG]);
            }
            for(var auxD=0; auxD<filtrar[7]; auxD++){
                $('.consulta_despesas tbody').append(filtrar[1][auxD]);
            }
            $('.balanco tbody').html(filtrar[2]);
            $('.ganho_aberto tbody').html(filtrar[3]);
            new List('ganho-lista', {
                valueNames: ['ganho'],
                page: 10,
                plugins: [ListPagination({})]
            });
            new List('despesa-lista', {
                valueNames: ['despesa'],
                page: 10,
                plugins: [ListPagination({})]
            });
        }
    });
}

function gerarGraf(despesas, ganhos, balanco){
    var vDespesas = JSON.parse(despesas);
    var vGanhos = JSON.parse(ganhos);
    var vBalanco = JSON.parse(balanco);
    $("#area_chart_finances").html("").html('<canvas id="chart_finances" width="100px" height="25px"></canvas>');

    var ctx = document.getElementById('chart_finances').getContext('2d');
    var chart_finances = new Chart(ctx, {
        type: 'line',
        data: {
            labels: ['Janeiro', 'Fevereiro', 'Março', 'Abril', 'Maio', 'Junho', 'Julho', 'Agosto', 'Setembro', 'Outubro', 'Novembro', 'Dezembro'],
            datasets: [ {
                label: 'Ganhos',
                data: [vGanhos[0],vGanhos[1],vGanhos[2],vGanhos[3],vGanhos[4],vGanhos[5],vGanhos[6],vGanhos[7],vGanhos[8],vGanhos[9],vGanhos[10],vGanhos[11]],
                backgroundColor: 'rgba(54, 162, 235, 0)',
                borderColor: '#32CD32',
                pointBorderColor: '#fff',
                pointBackgroundColor: '#32CD32',
                pointBorderWidth: 3,
                pointHoverRadius: 4,
                pointHoverBackgroundColor: '#32CD32',
                pointHoverBorderColor: '#fff',
                pointRadius: 4,
                pointHitRadius: 3,
            },{
                label: 'Despesas',
                data: [vDespesas[0],vDespesas[1],vDespesas[2],vDespesas[3],vDespesas[4],vDespesas[5],vDespesas[6],vDespesas[7],vDespesas[8],vDespesas[9],vDespesas[10],vDespesas[11]],
                backgroundColor: 'rgba(54, 162, 235, 0)',
                borderColor: '#FF0000',
                pointBorderColor: '#fff',
                pointBackgroundColor: '#FF0000',
                pointBorderWidth: 3,
                pointHoverRadius: 4,
                pointHoverBackgroundColor: '#FF0000',
                pointHoverBorderColor: '#fff',
                pointRadius: 4,
                pointHitRadius: 3,
            }, {
                label: 'Balanço',
                data: [vBalanco[0],vBalanco[1],vBalanco[2],vBalanco[3],vBalanco[4],vBalanco[5],vBalanco[6],vBalanco[7],vBalanco[8],vBalanco[9],vBalanco[10],vBalanco[11]],
                backgroundColor: 'rgba(54, 162, 235, 0)',
                borderColor: '#00F',
                pointBorderColor: '#fff',
                pointBackgroundColor: '#00F',
                pointBorderWidth: 3,
                pointHoverRadius: 4,
                pointHoverBackgroundColor: '#00F',
                pointHoverBorderColor: '#fff',
                pointRadius: 4,
                pointHitRadius: 3
            }]
        },
        options:  {
            legend: {
                display: false
            },
            tooltips: {
                custom: function (tooltip) {
                    if (!tooltip) {
                        return;
                    }
                    var body = tooltip.body;
                    if(tooltip.body!==undefined){
                        var text = tooltip.body[0].lines[0].split(":");
                        var label = text[0];
                        var value = parseFloat(text[1]).toFixed(2).replace(".",",");
                        tooltip.body[0].lines[0] = label + ": R$ " + value;
                    }
                }
            }
        }
    });
};
