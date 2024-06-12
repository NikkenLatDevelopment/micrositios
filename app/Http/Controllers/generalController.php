<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Pagination\LengthAwarePaginator;
use Maatwebsite\Excel\Concerns\WithHeadings;

class generalController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index_seguimiento_organizacion($cod)
    {
        //
        //dd("ss");
        $decodedCod = base64_decode($cod);
        return view('reportes.seguimientoOrganizacion', ['cod' => $decodedCod]);
    }


    public function get_seguimiento_organizacion_personal(Request $request){

        $sap_code = $request->sap_code;
        $query = "EXEC grupoPersonal4x4 $sap_code";
        $results['data'] = DB::connection('75')->select($query);
        return $results;
    }

    public function get_seguimiento_organizacion_arbol_completo(Request $request){
        $sap_code = $request->sap_code;
        $results['data'] = DB::connection('75')->select("EXEC detalle_organizacional4x4 $sap_code");
        return $results;
    }

    public function seguimientoOrganizacionGen(Request $request){
        $sap_code = $request->sap_code;
        $type = $request->type;
        if(intval($type) == 1){
            $query = "EXEC grupoPersonal4x4 $sap_code";
            $results['data'] = DB::connection('75')->select($query);
            return $results;
        }
        else{
            $results['data'] = DB::connection('75')->select("EXEC detalle_organizacional4x4 $sap_code");
            return $results;
        }
    }


    public function index_seguimiento_staff(){
        return view('reportes.seguimiento-staff');        
    }

    public function get_seguimiento_staff()
    {
        
        $query = "
            SELECT 
                associateid,
                associateName,
                tipo,
                CASE WHEN rangoSocio = 9 THEN 'DRL'
                    WHEN rangoSocio = 8 THEN 'DIA'
                    WHEN rangoSocio = 7 THEN 'PLO'
                    WHEN rangoSocio = 6 THEN 'ORO'
                    WHEN rangoSocio = 5 THEN 'PLA'
                    WHEN rangoSocio = 3 THEN 'EXE'
                    WHEN rangoSocio = 2 THEN 'SUP'
                ELSE 'DIR' END AS rangoSocio,
                pais,
                telefono,
                email,
                sponsorid, 
                sponsorName,
                CASE WHEN rangoSponsor = 9 THEN 'DRL'
                    WHEN rangoSponsor = 8 THEN 'DIA'
                    WHEN rangoSponsor = 7 THEN 'PLO'
                    WHEN rangoSponsor = 6 THEN 'ORO'
                    WHEN rangoSponsor = 5 THEN 'PLA'
                    WHEN rangoSponsor = 3 THEN 'EXE'
                    WHEN rangoSponsor = 2 THEN 'SUP'
                ELSE 'DIR' END AS rangoSponsor,
                CASE WHEN semana_1= 1 THEN 'SI' ELSE 'NO' END AS semana_1,
                CASE WHEN semana_2= 1 THEN 'SI' ELSE 'NO' END AS semana_2,
                CASE WHEN semana_3= 1 THEN 'SI' ELSE 'NO' END AS semana_3,
                CASE WHEN semana_4= 1 THEN 'SI' ELSE 'NO' END AS semana_4,
                CASE WHEN semana_5= 1 THEN 'SI' ELSE 'NO' END AS semana_5,
                CASE WHEN ganador= 1 THEN 'SI' ELSE 'NO' END AS ganador
            FROM dwt_estrategiareto4x4
            WHERE semana_1 = 1
            OR semana_2 = 1
            OR semana_3 = 1
            OR semana_4 = 1
            OR semana_5 = 1
            OR ganador = 1";
        
        $results = DB::connection('75')->select($query);
        return $results;
    }

    public function index_seguimiento_personal($cod)
    {

        $decodedCod = base64_decode($cod);
        
        // $query = "
        //     SELECT  associateid
        //         , associateName
        //         , tipo
        //         , CASE WHEN rangoSocio = 9 THEN 'DRL'
        //         WHEN rangoSocio = 8 THEN 'DIA'
        //         WHEN rangoSocio = 7 THEN 'PLO'
        //         WHEN rangoSocio = 6 THEN 'ORO'
        //         WHEN rangoSocio = 5 THEN 'PLA'
        //         WHEN rangoSocio = 3 THEN 'EXE'
        //         WHEN rangoSocio = 2 THEN 'SUP'
        //         ELSE 'DIR' END AS rangoSocio
        //         , telefono
        //         , email
        //         , sponsorName
        //         , CASE WHEN semana_1= 1 THEN 'SI' ELSE 'NO' END AS semana_1
        //         , CASE WHEN semana_2= 1 THEN 'SI' ELSE 'NO' END AS semana_2
        //         , CASE WHEN semana_3= 1 THEN 'SI' ELSE 'NO' END AS semana_3
        //         , CASE WHEN semana_4= 1 THEN 'SI' ELSE 'NO' END AS semana_4
        //         , CASE WHEN semana_5= 1 THEN 'SI' ELSE 'NO' END AS semana_5
        //         , CASE WHEN ganador= 1 THEN 'SI' ELSE 'NO' END AS ganador
        //     FROM dwt_estrategiareto4x4
        //     WHERE associateid = ".$decodedCod.";";
        
        $query = "EXEC consultaSocio4x4 $decodedCod";


        //dd($query);
        $results = DB::connection('75')->select($query);
        $s1 = "";
        $s2 = "";
        $s3 = "";
        $s4 = "";
        foreach ($results as $result) {
            $s1 = $result->semana_1;
            $s2 = $result->semana_2;
            $s3 = $result->semana_3;
            $s4 = $result->semana_4;
            // Puedes acceder a otras propiedades de la misma manera
            //echo $s1;
        }
        //dd($s1);

        return view('reportes.seguimiento-personal',compact("s1","s2","s3","s4"));
    }
    
    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    
}
