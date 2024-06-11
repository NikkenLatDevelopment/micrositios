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
                        <th scope="col">Patrocinador</th>
                        <th scope="col">Teléfono</th>
                        <th scope="col">Correo</th>
                        <th scope="col">Semana 1</th>
                        <th scope="col">Semana 2</th>
                        <th scope="col">Semana 3</th>
                        <th scope="col">Semana 4</th>
                        <th scope="col">Semana 5</th>
                        <th scope="col">Cumple 4x4</th>
                        </tr>
                    </thead>
                    <tbody>
                    </tbody>
                </table>
                <nav>
                    <ul class="pagination">
                        <li class="page-item" :class="{'disabled': !pagination.prev_page_url}">
                            <a class="page-link" href="#" @click.prevent="fetchData(pagination.prev_page_url)">Previous</a>
                        </li>
                        <li class="page-item" v-for="page in pagesNumber" :class="{'active': page == pagination.current_page}" :key="page">
                            <a class="page-link" href="#" @click.prevent="fetchData(pagination.path + '?page=' + page)">@{{ page }}</a>
                        </li>
                        <li class="page-item" :class="{'disabled': !pagination.next_page_url}">
                            <a class="page-link" href="#" @click.prevent="fetchData(pagination.next_page_url)">Next</a>
                        </li>
                    </ul>
                </nav>
                
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
                    this.fetchData('{{ route("seguimiento-staff.get") }}');

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
                    pagesNumber: function() {
                        if (!this.pagination.to) {
                            return [];
                        }

                        var from = this.pagination.current_page - 2;
                        if (from < 1) {
                            from = 1;
                        }

                        var to = from + 4;
                        if (to >= this.pagination.last_page) {
                            to = this.pagination.last_page;
                        }

                        var pagesArray = [];
                        for (var page = from; page <= to; page++) {
                            pagesArray.push(page);
                        }

                        return pagesArray;
                    }
                },
                watch: {                   
                },
                methods: {
                    fetchData: function(url) {
                        axios.post(url).then(response => {
                            $("#cargando").hide();
                            this.updateTable(response.data.data);
                            this.pagination = response.data;
                        }).catch(error => {
                            $("#error").show();
                            $("#cargando").hide();
                            console.error('Error al obtener datos:', error);
                        });
                    },
                    updateTable: function(data) {
                this.associates = data;
                let tbody = $('#associatesTable tbody');
                tbody.empty();
                data.forEach(item => {
                    let row = `<tr>
                        <td>${item.associateid}</td>
                        <td>${item.associateName}</td>
                        <td>${item.tipo}</td>
                        <td>${item.rangoSocio}</td>
                        <td>${item.sponsorName}</td>
                        <td style="max-width:100px;">${item.telefono}</td>
                        <td>${item.email}</td>
                        <td>${item.semana_1}</td>
                        <td>${item.semana_2}</td>
                        <td>${item.semana_3}</td>
                        <td>${item.semana_4}</td>
                        <td>${item.semana_5}</td>
                        <td>${item.ganador}</td>
                    </tr>`;
                    tbody.append(row);
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