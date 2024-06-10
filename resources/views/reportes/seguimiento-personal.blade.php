<x-layout-general>
@section('title', 'Seguimiento Personal')
<div id="seguimiento-personal">
    <nav class="navbar bg-body-tertiary nvar">
        <div class="container">
            <a class="navbar-brand" href="#">
                <img src="{{asset('images/logo-nikken.png')}}" alt="NIKKEN">
            </a>        
            {{--<form class="d-flex" role="search">
            <input class="form-control me-2" type="search" placeholder="Search" aria-label="Search">
            <button class="btn btn-outline-success" type="submit">Search</button>
            </form>--}}
        </div>
    </nav>
    <div class="container">
        <div class="row">
            <div class="col-12 py-4">
                <h1>Seguimiento Personal</h1>

            </div>            
        </div>
        <div class="row">
            <div class="col-12 col-md-6">
                <div class="row">
                    <div class="col-12 text-center">
                        <img src="{{ asset('images/LOG.png') }}" class="logo-4x4" alt="Logo">
                    </div>
                </div>
                <div class="row">
                    <div class="col-12">
                        <div class="terms py-5">
                            <h2>Terminos y Condiciones</h2>
                            <ul class="ul-question1">
                                <li>
                                    La estrategia de descuento del 10% está dirigida a los socios independientes y clientes afiliados que cumplan requisito.       
                                </li>
                                <li>
                                    Para acceder a este beneficio es necesario participar con la compra mínima de al menos un producto participante en cada una de las semanas de estrategia.
                                </li>
                                <li>
                                    Este descuento no es acumulable con otras estrategias en el mes de julio.  
                                </li>
                                <li>
                                    Si aplica el descuento en compras sistemas de agua PiMag participantes en seguimiento perfecto podrá acceder a los bonos regulares de julio.
                                </li>
                                <li>
                                    Si el socio accede al descuento este solo será aplicable bajo su código, este se extiende a los clientes afiliados incorporados bajo su código que cumplieron requisitos.
                                </li>
                                <li>
                                    Este descuento será de uso exclusivo del socio ganador, no podrá publicarlo en redes sociales.    
                                </li>
                            </ul>
                            <strong>NIKKEN Latinoamérica se reserva la interpretación de esta estrategia.</strong>
                        </div>
                        
                    </div>
                </div>
            </div>
            <div class="col-12 col-md-6">                
                <canvas id="myChart"></canvas>
            </div>
        </div>

    </div>

</div>

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script src="https://cdn.jsdelivr.net/npm/chartjs-plugin-datalabels@2.0.0"></script>
        <script>
            
            var register = new Vue({
                el: '#seguimiento-personal',
                data: {
                   semana1: "",
                   semana2: "",
                   semana3: "",
                   semana4: "",
                   colo1: "",
                   colo2: "",
                   colo3: "",
                   colo4: "",                   
                },
                filters: {},
                beforeMount: function() {                    
                },
                mounted: function() {   
                    var ctx = document.getElementById('myChart').getContext('2d');

                    if(this.semana1 == ""){
                        this.colo1="gray";
                    }else{
                        this.colo1="#004c6d";
                    }

                    if(this.semana2 == ""){
                        this.colo2="gray";
                    }else{
                        this.colo2="#f58220";
                    }

                    if(this.semana3 == ""){
                        this.colo3="gray";
                    }else{
                        this.colo3="#1c8039";
                    }

                    if(this.semana4 == ""){
                        this.colo4="gray";
                    }else{
                        this.colo4="#00a3e0";
                    }

                    new Chart(ctx, {
                        type: 'doughnut',
                        data: {
                            labels: ['SEMANA 1', 'SEMANA 2', 'SEMANA 3', 'SEMANA 4'],
                            datasets: [{
                                data: [25, 25, 25, 25], // Valores de cada semana
                                backgroundColor: [
                                    this.colo1, // Color para SEMANA 1
                                    this.colo2, // Color para SEMANA 2
                                    this.colo3, // Color para SEMANA 3
                                    this.colo4, // Color para SEMANA 4
                                ],
                                borderColor: [
                                    "white", // Color para SEMANA 1
                                    "white", // Color para SEMANA 2
                                    "white", // Color para SEMANA 3
                                    "white", // Color para SEMANA 4
                                ],
                                borderWidth: 1
                            }]
                        },
                        options: {
                            responsive: true,
                            plugins: {
                                legend: {
                                    position: 'bottom',
                                },
                                title: {
                                    display: true,
                                    text: 'Distribución Semanal'
                                },
                                datalabels: {
                                    formatter: function(value, context) {
                                        return context.chart.data.labels[context.dataIndex];
                                    },
                                    color: '#fff',
                                    font: {
                                        weight: 'bold',
                                        size: '16'
                                    },
                                    align: 'end',
                                    anchor: 'end',
                                    offset: 10,
                                    borderColor: 'rgba(0, 0, 0, 0.1)',
                                    borderWidth: 2,
                                    borderRadius: 25,
                                    backgroundColor: function(context) {
                                        return context.dataset.backgroundColor[context.dataIndex];
                                    },
                                    padding: 6
                                }
                            }
                        },
                        plugins: [ChartDataLabels]
                    });
					
						//alert("hola");
                },
                computed: {
                },
                watch: {                   
                },
                methods: {
                }                
            });
        </script>
@endpush

</x-layout-general>