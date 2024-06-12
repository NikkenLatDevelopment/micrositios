<!DOCTYPE html>
<html>
<head>
    <title>Seguimiento Organización</title>
   
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    
    
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.3.1/css/all.css" integrity="sha384-mzrmE5qonljUremFsqc01SB46JvROS7bZs3IO2EmfFsd15uHvIt+Y8vEf7N7fWAU" crossorigin="anonymous">

    <link rel="stylesheet" href="/css/app.css">
    
</head>
<body>
    <input type="hidden" id="sap_code" value="{{ $sap_code }}">
    <div id="seguimiento-organizacion">
        <nav class="navbar bg-body-tertiary nvar">
            <div class="container-fluid">
                <a class="navbar-brand" href="#">
                    <img src="https://micrositios.nikkenlatam.com/images/logo-nikken.png" alt="NIKKEN">
                </a>
            </div>
        </nav>

        <div class="container-fluid">
            <div class="row">
                <div class="col-12 py-4">
                    <nav class="navbar bg-body-tertiary">
                        <div class="container-fliud">
                            <a class="navbar-brand" href="#">
                            <img src="https://micrositios.nikkenlatam.com/images/LOG.png" alt="Bootstrap" width="200">
                            </a>
                        </div>
                    </nav>
                    <form class="d-flex float-start py-4" role="">
                        <select id="select" v-model="selectedOption" onchange="getGenTable(this.value)">
                            <option value="" disabled selected>Seleccione una opción...</option>
                            <option value="1">Grupo Personal</option>
                            <option value="2">Árbol completo</option>
                        </select>                        
                    </form>
                    {{-- <form class="d-flex float-end py-4" role="search">                        
                        <input class="form-control me-2" type="search" placeholder="Ingresa tu búsqueda" id="codigo" aria-label="Buscar">
                    </form> --}}
                </div>            
            </div>
        </div>
        
        <div class="container-fluid">
            <div class="row">
                <div class="col-12">
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
                    </table>
                </div>
            </div>
        </div>
    </div>

    <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.19.3/jquery.validate.min.js" integrity="sha512-37T7leoNS06R80c8Ulq7cdCDU5MNQBwlYoy1TX/WUsLFC2eYNqtKlV0QjH7r8JpG/S0GUMZwebnVFLPd6SU5yg==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    <script src="https://cdn.jsdelivr.net/npm/axios/dist/axios.min.js"></script>
    <script src="https://kit.fontawesome.com/19cc44ce18.js" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/xlsx/0.16.2/xlsx.full.min.js"></script>
    <script src="/js/app.js"></script>

    <link rel="stylesheet" type="text/css" href="https://testmicrositios.nikkenlatam.com/fpro/plugins/table/datatable/datatables.css">
    <link rel="stylesheet" type="text/css" href="https://testmicrositios.nikkenlatam.com/fpro/plugins/table/datatable/custom_dt_zero_config.css">
    <link rel="stylesheet" type="text/css" href="https://testmicrositios.nikkenlatam.com/fpro/plugins/table/datatable/custom_dt_html5.css">

    <script src="https://testmicrositios.nikkenlatam.com/fpro/plugins/table/datatable/datatables.js"></script>
    <script src="https://testmicrositios.nikkenlatam.com/fpro/plugins/table/datatable/button-ext/dataTables.buttons.min.js"></script>
    <script src="https://testmicrositios.nikkenlatam.com/fpro/plugins/table/datatable/button-ext/jszip.min.js"></script>
    <script src="https://testmicrositios.nikkenlatam.com/fpro/plugins/table/datatable/button-ext/buttons.html5.min.js"></script>
    <script src="https://testmicrositios.nikkenlatam.com/fpro/plugins/table/datatable/button-ext/buttons.print.min.js"></script>

</body>
    <script>

        $("#select").val('');
        function getGenTable(type){
            sap_code = $("#sap_code").val();
            $("#associatesTable").DataTable({
                searching: true,
                ordering: true,
                paging: true,
                info: true,
                destroy: true,
                ajax: "/seguimientoOrganizacionGen?sap_code=" + sap_code + "&type=" + type,
                deferRender: true,
                columns: [
                    { data: 'associateid' },
                    { data: 'associateName' },
                    { data: 'tipo' },
                    { data: 'rangoSocio' },
                    { data: 'telefono' },
                    { data: 'email' },
                    { data: 'semana_1' },
                    { data: 'semana_2' },
                    { data: 'semana_2' },
                    { data: 'semana_3' },
                    { data: 'semana_4' },
                    { data: 'ganador' },
                    
                ],
                dom: '<"row"<"col s12 m12 l12 xl12"<"row"<"col-md-6"B><"col-md-6"f> > ><"col-md-12"rt> <"col-md-12"<"row"<"col-md-5 mb-md-0 mb-5"i><"col-md-7"p>>> >',
                buttons: {
                    buttons: [
                        { 
                            extend: 'excel', 
                            className: 'btn btn-fill btn-fill-dark btn-rounded mb-4 mr-3 btnExcel btn-info', 
                            text:"<img src='https://services.nikken.com.mx/retos/img/excel.png' width='15px'></img> Exportar a Excel",
                        },
                    ]
                },
                language:{
                    "paginate": {
                        "previous": "Anterior",
                        "next": "Siguiente"
                    },
                    "search": "Buscar" ,
                    "searchPlaceholder": "Buscar por nombre o por código...",
                    "info": "&nbsp;&nbsp;&nbsp; Mostrando _START_ a _END_ de _TOTAL_ registros",
                    "loadingRecords": '<center><div class="box">Cargando registros...',
                    'sEmptyTable': 'No se encontraron registros',
                    "sZeroRecords": "No se encontraron coincidencias.",
                    "sInfoEmpty": "",
                }
            });
        }
    </script>
</html>
