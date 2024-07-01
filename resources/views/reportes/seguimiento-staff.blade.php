<x-layoutGeneral>
@section('title', 'Seguimiento Staff')
<div id="seguimiento-organizacion">
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
    <div class="container-fluid">
        <div class="row">
            <div class="col-12 py-4">
                <h1>Seguimiento Staff</h1>

                <form class="d-flex float-end" role="search">
                        <input class="form-control me-2" type="search" placeholder="Ingresa tu búsqueda" id="codigo" aria-label="Search">                        
                </form>
            

            </div>            
        </div>
        <div class="row">
            <div class="col-12">

                <button class="btn btn-info mb-3" @click="exportToExcel">Exportar a Excel <i class="fa-solid fa-file-excel"></i></button>
                <div class="w-100 text-center">
                    <div id="cargando" class="text-success fw-bold fs-4">
                        <span class="spinner-border spinner-border-sm" aria-hidden="true"></span>
                        <span role="status">Cargando datos...</span>
                    </div>
                    <div id="error" class="text-danger fw-bold fs-4" style="display:none;">                        
                        <span role="status">Hubo un problema al extraer la información...</span>
                    </div>
                </div>

                <table class="table table-striped table-hover" id="associatesTable">                   
                    <thead>
                        <tr>
                        <th scope="col">Código</th>
                        <th scope="col">Nombre</th>
                        <th scope="col">Tipo</th>
                        <th scope="col">Rango</th>
                        <th scope="col">País</th>
                        <th scope="col">Codigo Patricinador</th>
                        <th scope="col">Patrocinador</th>
                        <th scope="col">Rango Patrocinador</th>
                        <th scope="col">Teléfono</th>
                        <th scope="col">Correo</th>
                        <th scope="col">Semana 1</th>
                        <th scope="col">Semana 2</th>
                        <th scope="col">Semana 3</th>
                        <th scope="col">Semana 4</th>
                        <th scope="col">Día Comodín</th>
                        <th scope="col">Cumple 4x4</th>
                        </tr>
                    </thead>
                    <tbody>
                    </tbody>
                </table>                
                
            </div>
        </div>

    </div>

</div>

@push('scripts')
        <script>
            
            var register = new Vue({
                el: '#seguimiento-organizacion',
                data: {  
                    associates: [],
            pagination: {}                 
                },
                filters: {},
                beforeMount: function() {                    
                },
                mounted: function() {   
                    var url = '{{ route("seguimiento-staff.get") }}';
                    axios.post(url, {
                            'codigo': this.codigo
                        }).then(response => {
                            if (response.data) {
                                //console.log('Datos recibidos:', response.data);
                                $("#cargando").hide();
                                this.updateTable(response.data);
                            }
                    }).catch(error => {
                            console.error('Error al obtener datos:', error);
                    });

                    $('#codigo').on('keyup', function() {
                        var value = $(this).val().toLowerCase();
                        $("#associatesTable tbody tr").filter(function() {
                            $(this).toggle($(this).text().toLowerCase().indexOf(value) > -1);
                        });
                    });
					
						//alert("hola");
                },
                computed: {
                    filteredAssociates: function() {
                        const query = this.searchQuery.toLowerCase();
                        return this.associates.filter(function(item) {
                            return item.associateId.toLowerCase().includes(query) ||
                                item.associatename.toLowerCase().includes(query);
                        });
                    },                    
                },
                watch: {                   
                },
                methods: {
                    
                    updateTable: function(data) {
                        $('#associatesTable tbody').empty();
                        data.forEach(item => {
                            var associateId = item.associateId || item.associateid;
                            var associatename = item.associatename || item.associateName;
                            var tipo = item.tipo || '';
                            var rangoSocio = item.rangoSocio || '';
                            var pais = item.pais || '';
                            var sponsorid = item.sponsorid || item.sponsorid;
                            var sponsorname = item.sponsorname || item.sponsorName;
                            var rangoSponsor = item.rangoSponsor || item.rangoSponsor;
                            var telefono = item.telefono ? item.telefono.trim() : '';
                            var email = item.email ? item.email.trim() : '';
                            var semana_1 = item.semana_1 || 'NO';
                            var semana_2 = item.semana_2 || 'NO';
                            var semana_3 = item.semana_3 || 'NO';
                            var semana_4 = item.semana_4 || 'NO';
                            var ganador = item.ganador || 'NO';

                            var row = `<tr>
                                <td>${associateId}</td>
                                <td>${associatename}</td>
                                <td>${tipo}</td>
                                <td>${rangoSocio}</td>
                                <td>${pais}</td>
                                <td>${sponsorid}</td>
                                <td>${sponsorname}</td>
                                <td>${rangoSponsor}</td>
                                <td style="max-width:100px;">${telefono}</td>
                                <td>${email}</td>
                                <td>${semana_1}</td>
                                <td>${semana_2}</td>
                                <td>${semana_3}</td>
                                <td>${semana_4}</td>
                                <td>${ganador}</td>
                            </tr>`;
                            $('#associatesTable tbody').append(row);
                        });
                    },        
                    exportToExcel: function() {
                        /* Obtener los datos de la tabla */
                        var wb = XLSX.utils.table_to_book(document.getElementById('associatesTable'), { sheet: "Sheet JS" });
                        /* Generar el archivo Excel */
                        XLSX.writeFile(wb, "seguimiento_organizacion.xlsx");
                    }
                }
            });
        </script>
@endpush

</x-layoutGeneral>