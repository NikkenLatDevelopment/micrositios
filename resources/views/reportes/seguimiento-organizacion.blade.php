<x-layout-general>
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

                <form class="d-flex float-end" role="search">
                        <input class="form-control me-2" type="search" placeholder="Search" aria-label="Search">
                        <button class="btn btn-outline-success" type="submit">Search</button>
                </form>
            

            </div>            
        </div>
        <div class="row">
            <div class="col-12">

                <table class="table">
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
                        <th scope="col">Teléfono</th>
                        <th scope="col">Correo</th>
                        <th scope="col">Semana 1</th>
                        <th scope="col">Semana 2</th>
                        <th scope="col">Semana 3</th>
                        <th scope="col">Semana 4</th>
                        <th scope="col">Cumple 4x4</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <th scope="row">1</th>
                            <td>Mark</td>
                            <td>Otto</td>
                            <td>@mdo</td>
                            <td>Mark</td>
                            <td>Otto</td>
                            <td>@mdo</td>
                            <td>Mark</td>
                            <td>Otto</td>
                            <td>@mdo</td>
                            <td>Mark</td>
                            <td>Otto</td>                            
                        </tr>                        
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
                },
                filters: {},
                beforeMount: function() {                    
                },
                mounted: function() {   
					
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