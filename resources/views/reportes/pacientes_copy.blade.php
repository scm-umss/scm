@extends('admin.layouts.plantilla')
@section('styles')
    <style>
        .highcharts-figure, .highcharts-data-table table {
            min-width: 360px;
            max-width: 800px;
            margin: 1em auto;
        }

        .highcharts-data-table table {
            font-family: Verdana, sans-serif;
            border-collapse: collapse;
            border: 1px solid #EBEBEB;
            margin: 10px auto;
            text-align: center;
            width: 100%;
            max-width: 500px;
        }
        .highcharts-data-table caption {
            padding: 1em 0;
            font-size: 1.2em;
            color: #555;
        }
        .highcharts-data-table th {
            font-weight: 600;
            padding: 0.5em;
        }
        .highcharts-data-table td, .highcharts-data-table th, .highcharts-data-table caption {
            padding: 0.5em;
        }
        .highcharts-data-table thead tr, .highcharts-data-table tr:nth-child(even) {
            background: #f8f8f8;
        }
        .highcharts-data-table tr:hover {
            background: #f1f7ff;
        }


    </style>
@endsection

@section('content')
<div class="card">
    <form action="{{ route('reportes.pacientes') }}">
        <div class="form-group row">
            <label for="fecha_inicio" class="col-md-4 col-form-label text-md-right">Fecha inicio:</label>
    
            <div class="col-md-6">
                <input id="fecha_inicio" type="date" class="form-control " name="fecha_inicio" value='2019-01-01'/>
            </div>
        </div>
        <div class="form-group row">
            <label for="fecha_fin" class="col-md-4 col-form-label text-md-right">Fecha fin:</label>
    
            <div class="col-md-6">
                <input id="fecha_fin" type="date" class="form-control " name="fecha_fin" value='2020-12-31'/>
            </div>
        </div>
        <div class="form-group row">
            
        <button type="submit" class="btn btn-success">Recargar</button>
        </div>
    </form>

    <figure class="highcharts-figure">
        <div id="container"></div>
        <p class="highcharts-description">
            Basic line chart showing trends in a dataset. This chart includes the
            <code>series-label</code> module, which adds a label to each line for
            enhanced readability.
        </p>
    </figure>
</div>
@endsection

@section('scripts')
<script src="https://code.highcharts.com/highcharts.js"></script>
<script src="https://code.highcharts.com/modules/series-label.js"></script>
<script src="https://code.highcharts.com/modules/exporting.js"></script>
<script src="https://code.highcharts.com/modules/export-data.js"></script>
<script src="https://code.highcharts.com/modules/accessibility.js"></script>
<script>
    var render = function(objects) {
        var labels = [];
        var data = [];
        //console.log('OBJETOS ' + objects);
        objects.forEach(element => {
            labels.push(element.anio + '-' + element.mes.toString().padStart(2, '0'));
            data.push(element.cantidad);    
        });
    };
    const chart = Highcharts.chart('container', {

        title: {
            text: 'Pacientes registrados por mes'
        },

        yAxis: {
            title: {
                text: 'Número de pacientes'
            }
        },

        xAxis: {
            categories: [],
        },

        legend: {
            layout: 'vertical',
            align: 'right',
            verticalAlign: 'middle'
        },

        plotOptions: {
            series: {
                label: {
                    connectorAllowed: false
                },
                //pointStart: 2010,
                animation: false
            },
            line: {
                dataLabels: {
                    enabled: true
                },
                enableMouseTracking: false
            }
        },

        series: [{
            name: 'Registros',
            data: [1, 2, 3]
        }, ],

        responsive: {
            rules: [{
                condition: {
                    maxWidth: 500
                },
                chartOptions: {
                    legend: {
                        layout: 'horizontal',
                        align: 'center',
                        verticalAlign: 'bottom'
                    }
                }
            }]
        }

    });

    function pacientesRegistrados() {
        let fecha_inicio = document.getElementById('fecha_inicio').value;
        let fecha_fin = document.getElementById('fecha_fin').value;
        let url = `/reportes/pacientes?fecha_inicio=${fecha_inicio}&fecha_fin=${fecha_fin}`;
            '&fecha_fin=' + fecha_fin;
        fetch(url) // 1
        .then(response => response.json()) // 2
        .then(data => { 
            // render(data); 
            //console.log(fecha_inicio);
            var labels = [];
            var datos = [];
            //console.log('OBJETOS ' + objects);
            data.forEach(element => {
                labels.push(element.anio + '-' + element.mes.toString().padStart(2, '0'));
                datos.push(element.cantidad);    
            });
            // console.log(datos[0].anio);
            
            chart.xAxis[0].setCategories(labels);
            chart.addSeries({
                name: 'Registros',
                data: datos,
            });

            chart.xAxis[0].redraw();
            chart.redraw();

            console.log(datos);

        }) // 3
        .catch(error => console.log('Algo salió mal: ' + error));
    }

    pacientesRegistrados();
</script>
@endsection
