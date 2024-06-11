<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

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
        
        return view('reportes.seguimientoOrganizacion', ['cod' => $cod]);
    }


    public function get_seguimiento_organizacion_personal(Request $request){
        
        //dd($request->codigo);
        $query = "
            SELECT associateid, associateName, tipo,
                CASE WHEN rangoSocio = 9 THEN 'DRL'
                    WHEN rangoSocio = 8 THEN 'DIA'
                    WHEN rangoSocio = 7 THEN 'PLO'
                    WHEN rangoSocio = 6 THEN 'ORO'
                    WHEN rangoSocio = 5 THEN 'PLA'
                    WHEN rangoSocio = 3 THEN 'EXE'
                    WHEN rangoSocio = 2 THEN 'SUP'
                    ELSE 'DIR' END AS rangoSocio,
                telefono, email, sponsorName,
                CASE WHEN semana_1 = 1 THEN 'SI' ELSE 'NO' END AS semana_1,
                CASE WHEN semana_2 = 1 THEN 'SI' ELSE 'NO' END AS semana_2,
                CASE WHEN semana_3 = 1 THEN 'SI' ELSE 'NO' END AS semana_3,
                CASE WHEN semana_4 = 1 THEN 'SI' ELSE 'NO' END AS semana_4,
                CASE WHEN semana_5 = 1 THEN 'SI' ELSE 'NO' END AS semana_5,
                CASE WHEN ganador = 1 THEN 'SI' ELSE 'NO' END AS ganador
            FROM dwt_estrategiareto4x4
            WHERE sponsorid = ".$request->codigo." AND rangoSocio <= 3

            UNION

            SELECT a.associateid, a.associateName, a.tipo,
                CASE WHEN a.rangoSocio = 9 THEN 'DRL'
                    WHEN a.rangoSocio = 8 THEN 'DIA'
                    WHEN a.rangoSocio = 7 THEN 'PLO'
                    WHEN a.rangoSocio = 6 THEN 'ORO'
                    WHEN a.rangoSocio = 5 THEN 'PLA'
                    WHEN a.rangoSocio = 3 THEN 'EXE'
                    WHEN a.rangoSocio = 2 THEN 'SUP'
                    ELSE 'DIR' END AS rangoSocio,
                a.telefono, a.email, a.sponsorName,
                CASE WHEN a.semana_1 = 1 THEN 'SI' ELSE 'NO' END AS semana_1,
                CASE WHEN a.semana_2 = 1 THEN 'SI' ELSE 'NO' END AS semana_2,
                CASE WHEN a.semana_3 = 1 THEN 'SI' ELSE 'NO' END AS semana_3,
                CASE WHEN a.semana_4 = 1 THEN 'SI' ELSE 'NO' END AS semana_4,
                CASE WHEN a.semana_5 = 1 THEN 'SI' ELSE 'NO' END AS semana_5,
                CASE WHEN a.ganador = 1 THEN 'SI' ELSE 'NO' END AS ganador
            FROM dwt_estrategiareto4x4 a
            INNER JOIN (
                SELECT associateid 
                FROM dwt_estrategiareto4x4 
                WHERE sponsorid = ".$request->codigo." AND rangoSocio <= 3
            ) b ON a.sponsorid = b.associateid
            ORDER BY associateName ASC
        ";
        //dd($query);

        try {
            $results = DB::connection('75')->select($query);
            //dd($results);
            return $results;
        } catch (\Exception $e) {
            //Log::error('SQL Error: ' . $e->getMessage());
            dd($e->getMessage());
        }

        
    }

    public function get_seguimiento_organizacion_arbol_completo(Request $request){

        $results = DB::connection('75')
                ->select('EXEC detalle_organizacional4x4 :sponsorId', ['sponsorId' => $request->codigo]);        

        return $results;
        

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
        FROM dwt_estrategiareto4x4";
        
    $results = DB::connection('75')->select($query);
    
    $currentPage = LengthAwarePaginator::resolveCurrentPage();
    $perPage = 20;
    $currentItems = array_slice($results, ($currentPage - 1) * $perPage, $perPage);

    $paginatedResults = new LengthAwarePaginator($currentItems, count($results), $perPage, $currentPage, [
        'path' => LengthAwarePaginator::resolveCurrentPath()
    ]);

    return view('seguimiento-staff', ['results' => $paginatedResults]);
    }

    public function index_seguimiento_personal($cod)
    {
        
        $query = "
        SELECT  associateid
        , associateName
        , tipo
        , CASE WHEN rangoSocio = 9 THEN 'DRL'
        WHEN rangoSocio = 8 THEN 'DIA'
        WHEN rangoSocio = 7 THEN 'PLO'
        WHEN rangoSocio = 6 THEN 'ORO'
        WHEN rangoSocio = 5 THEN 'PLA'
        WHEN rangoSocio = 3 THEN 'EXE'
        WHEN rangoSocio = 2 THEN 'SUP'
        ELSE 'DIR' END AS rangoSocio
        , telefono
        , email
        , sponsorName
        , CASE WHEN semana_1= 1 THEN 'SI' ELSE 'NO' END AS semana_1
        , CASE WHEN semana_2= 1 THEN 'SI' ELSE 'NO' END AS semana_2
        , CASE WHEN semana_3= 1 THEN 'SI' ELSE 'NO' END AS semana_3
        , CASE WHEN semana_4= 1 THEN 'SI' ELSE 'NO' END AS semana_4
        , CASE WHEN semana_5= 1 THEN 'SI' ELSE 'NO' END AS semana_5
        , CASE WHEN ganador= 1 THEN 'SI' ELSE 'NO' END AS ganador
        FROM dwt_estrategiareto4x4
        WHERE associateid = ".$cod.";";
        //
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
