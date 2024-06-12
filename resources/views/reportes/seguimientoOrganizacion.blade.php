<x-layoutGeneral>
@section('title', 'Seguimiento Organización')
<div id="seguimiento-organizacion">
    <nav class="navbar bg-body-tertiary nvar">
        <div class="container-fluid">
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
                <nav class="navbar bg-body-tertiary">
                    <div class="container-fliud">
                        <a class="navbar-brand" href="#">
                        <img src="{{ asset('images/LOG.png') }}" alt="Bootstrap" width="200">
                        </a>
                    </div>
                </nav>                

                <form class="d-flex float-start py-4" role="">
                        <select id="select" v-model="selectedOption" @change="onSelectChange">
                            <option value="">Seleccione una opción...</option>
                            <option value="1">Grupo Personal</option>
                            <option value="2">Árbol completo</option>
                        </select>                        
                </form>

                <form class="d-flex float-end py-4" role="search">                        
                        <input class="form-control me-2" type="search" placeholder="Ingresa tu búsqueda" id="codigo" aria-label="Buscar">
                        {{--<button class="btn btn-outline-success" type="submit" @click.prevent="consulta()">Buscar</button>--}}
                </form>
            

            </div>            
        </div>

    </div>
    
    <div class="container-fluid">
        
        <div class="row">
            <div class="col-12">

            
                <button class="btn btn-info mb-3" @click="exportToExcel">Exportar a Excel <i class="fa-solid fa-file-excel"></i></button>

                <table class="table table-striped table-hover" id="associatesTable">                    
                    <thead>
                        <tr>
                        <th scope="col">Código</th>
                        <th scope="col">Nombre</th>
                        <th scope="col">Tipo</th>
                        <th scope="col">Rango</th>
                        <th scope="col">Patrocinador</th>
                        <th scope="col" style="max-width:100px;">Teléfono</th>
                        <th scope="col" >Correo</th>
                        <th scope="col">Semana 1</th>
                        <th scope="col">Semana 2</th>
                        <th scope="col">Semana 3</th>
                        <th scope="col">Semana 4</th>
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

        <link rel="stylesheet" href="//cdn.datatables.net/2.0.8/css/dataTables.dataTables.min.css">

        <script src="//cdn.datatables.net/2.0.8/js/dataTables.min.js"></script>
        <script>
            
            var register = new Vue({
                el: '#seguimiento-organizacion',
                data: {
                    codigo: {!! json_encode($cod) !!},   
                    selectedOption: "",
                    associates: [],
                    searchQuery: ''         
                },
                filters: {},
                beforeMount: function() {                    
                },
                mounted: function() {   
					
					$('#codigo').on('keyup', function() {
                        var value = $(this).val().toLowerCase();
                        $("#associatesTable tbody tr").filter(function() {
                            $(this).toggle($(this).text().toLowerCase().indexOf(value) > -1);
                        });
                    });
                    
                },
                computed: {
                    filteredAssociates: function() {
                        const query = this.searchQuery.toLowerCase();
                        return this.associates.filter(function(item) {
                            return item.associateId.toLowerCase().includes(query) ||
                                item.associatename.toLowerCase().includes(query);
                        });
                    }
                },
                watch: {                   
                },
                methods: {                    
                    onSelectChange: function() {
                        if (this.selectedOption !== "") {
                            //console.log('Opción seleccionada:', this.selectedOption);

                            if (this.selectedOption == "1") {
                                this.fetchAssociates('{{ route("seguimientoOrganizacion.get") }}');
                            } else {
                                this.fetchAssociates('{{ route("seguimientoOrganizacion.getArbol") }}');
                            }
                            this.getDatatable();
                        }
                    },
                    fetchAssociates: function(url) {
                        axios.post(url, {
                            'codigo': this.codigo
                        }).then(response => {
                            if (response.data) {
                                //console.log('Datos recibidos:', response.data);
                                this.updateTable(response.data);
                            }
                        }).catch(error => {
                            console.error('Error al obtener datos:', error);
                        });
                    },
                    updateTable: function(data) {
                        $('#associatesTable tbody').empty();
                        data.forEach(item => {
                            var associateId = item.associateId || item.associateid;
                            var associatename = item.associatename || item.associateName;
                            var tipo = item.tipo || '';
                            var rangoSocio = item.rangoSocio || '';
                            var sponsorname = item.sponsorname || item.sponsorName;
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
                                <td>${sponsorname}</td>
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
                    },
                    getDatatable: function(){
                        setTimeout(() => {
                            $("#associatesTable").DataTable({
                                searching: false,
                                ordering: false,
                                paging: false,
                                info: true,
                                destroy: true,
                                deferRender: true,
                                dom: '<"row"<"col s12 m12 l12 xl12"<"row"<"col-md-6"B><"col-md-6"f> > ><"col-md-12"rt> <"col-md-12"<"row"<"col-md-5 mb-md-0 mb-5"i><"col-md-7"p>>> >',
                            });
                        }, 2000);            
                    }
                }
            });
            
        </script>
@endpush

</x-layoutGeneral>