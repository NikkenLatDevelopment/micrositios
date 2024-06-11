<x-layoutGeneral>
@section('title', 'Seguimiento Organización')
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
    <div class="container">
        <div class="row">
            <div class="col-12 py-4">
                <h1>Seguimiento Organización</h1>

                <form class="d-flex float-start" role="">
                        <select id="select" v-model="selectedOption" @change="onSelectChange">
                            <option value="">Seleccione una opción...</option>
                            <option value="1">Grupo Personal</option>
                            <option value="2">Árbol completo</option>
                        </select>                        
                </form>

                <form class="d-flex float-end" role="search">                        
                        <input class="form-control me-2" type="search" placeholder="Ingresa tu búsqueda" id="codigo" aria-label="Buscar">
                        {{--<button class="btn btn-outline-success" type="submit" @click.prevent="consulta()">Buscar</button>--}}
                </form>
            

            </div>            
        </div>
        <div class="row">
            <div class="col-12">

                <table class="table" id="associatesTable">
                    <thead>
                        <tr>
                            <th scope="col" style="border: none;">Guardar <i class="fa-solid fa-file-excel"></i></th>                            
                        </tr>
                    </thead>
                    <thead>
                        <tr>
                        <th scope="col">Código</th>
                        <th scope="col">Nombre</th>
                        <th scope="col">Tipo</th>
                        <th scope="col">Rango</th>
                        <th scope="col">Patrocinador</th>
                        <th scope="col" style="max-width:100px;">Teléfono</th>
                        <th scope="col">Correo</th>
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
                    consulta: function(){
                        //alert("sss");                        
                    },
                    onSelectChange: function() {
                        if (this.selectedOption !== "") {
                            alert('Opción seleccionada: ' + this.selectedOption);
                            if(this.selectedOption == "1"){

                                var url = '{{ route("seguimientoOrganizacion.get") }}';
                                axios.post(url, {
                                    'codigo': this.codigo,                                                                

                                }).then(response => {                                                        
                                    if (response.data) {     
                                        console.log("1");
                                        //this.associates = response.data;
                                        $('#associatesTable tbody').empty();

                                        var data = response.data;

                                        data.forEach(function(item) {
                                            var row = '<tr>' +
                                                    '<td>' + item.associateId + '</td>' +
                                                    '<td>' + item.associatename.trim() + '</td>' +
                                                    '<td>' + item.tipo + '</td>' +
                                                    '<td>' + item.rangoSocio + '</td>' +
                                                    '<td style="max-width:100px;">' + item.telefono.trim() + '</td>' +
                                                    '<td>' + item.email.trim() + '</td>' +
                                                    '<td>' + item.sponsorname + '</td>' +
                                                    '<td>' + item.semana_1 + '</td>' +
                                                    '<td>' + item.semana_2 + '</td>' +
                                                    '<td>' + item.semana_3 + '</td>' +
                                                    '<td>' + item.semana_4 + '</td>' +
                                                    '<td>' + item.ganador + '</td>' +
                                                    '</tr>';
                                            $('#associatesTable tbody').append(row);
                                        });

                                    }
                                }).catch(error => {
                                    console.log("ssd");
                                
                                });
                                
                            }else{

                                var url = '{{ route("seguimientoOrganizacion.getArvol") }}';
                                axios.post(url, {
                                    'codigo': this.codigo,                                                                

                                }).then(response => {                                                        
                                    if (response.data) { 
                                        console.log("2"); 
                                        $('#associatesTable tbody').empty();

                                        var data = response.data;                                        

                                        data.forEach(function(item) {
                                            var row = '<tr>' +
                                                    '<td>' + item.associateId + '</td>' +
                                                    '<td>' + item.associatename.trim() + '</td>' +
                                                    '<td>' + item.tipo + '</td>' +
                                                    '<td>' + item.rangoSocio + '</td>' +
                                                    '<td>' + item.sponsorname + '</td>' +
                                                    '<td>' + item.telefono.trim() + '</td>' +
                                                    '<td>' + item.email.trim() + '</td>' +                                                    
                                                    '<td>' + item.semana_1 + '</td>' +
                                                    '<td>' + item.semana_2 + '</td>' +
                                                    '<td>' + item.semana_3 + '</td>' +
                                                    '<td>' + item.semana_4 + '</td>' +
                                                    '<td>' + item.ganador + '</td>' +
                                                    '</tr>';
                                            $('#associatesTable tbody').append(row);
                                        });                              
                                    
                                    }
                                }).catch(error => {
                                    console.log("ssd");
                                
                                });

                            }
                            
                            // Aquí puedes llamar a otra función o realizar alguna acción adicional
                        }
                    }
                }
            });
        </script>
@endpush

</x-layoutGeneral>