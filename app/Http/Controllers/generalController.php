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
    public function index_seguimiento_organizacion()
    {
        //
        //dd("ss");
        
        return view('reportes.seguimientoOrganizacion');
    }


    public function get_seguimiento_organizacion(Request $request){

        
        

    }


    public function index_seguimiento_staff()
    {
        //
        //dd("ss");

        $results = DB::connection('75')
        ->table('dwt_estrategiareto4x4')
            ->select(
                'associateid',
                'associateName',
                'tipo',
                DB::raw("CASE WHEN rangoSocio = 9 THEN 'DRL'
                              WHEN rangoSocio = 8 THEN 'DIA'
                              WHEN rangoSocio = 7 THEN 'PLO'
                              WHEN rangoSocio = 6 THEN 'ORO'
                              WHEN rangoSocio = 5 THEN 'PLA'
                              WHEN rangoSocio = 3 THEN 'EXE'
                              WHEN rangoSocio = 2 THEN 'SUP'
                              ELSE 'DIR' END AS rangoSocio"),
                'pais',
                'telefono',
                'email',
                'sponsorid',
                'sponsorName',
                DB::raw("CASE WHEN rangoSponsor = 9 THEN 'DRL'
                              WHEN rangoSponsor = 8 THEN 'DIA'
                              WHEN rangoSponsor = 7 THEN 'PLO'
                              WHEN rangoSponsor = 6 THEN 'ORO'
                              WHEN rangoSponsor = 5 THEN 'PLA'
                              WHEN rangoSponsor = 3 THEN 'EXE'
                              WHEN rangoSponsor = 2 THEN 'SUP'
                              ELSE 'DIR' END AS rangoSponsor"),
                DB::raw("CASE WHEN semana_1 = 1 THEN 'SI' ELSE 'NO' END AS semana_1"),
                DB::raw("CASE WHEN semana_2 = 1 THEN 'SI' ELSE 'NO' END AS semana_2"),
                DB::raw("CASE WHEN semana_3 = 1 THEN 'SI' ELSE 'NO' END AS semana_3"),
                DB::raw("CASE WHEN semana_4 = 1 THEN 'SI' ELSE 'NO' END AS semana_4"),
                DB::raw("CASE WHEN semana_5 = 1 THEN 'SI' ELSE 'NO' END AS semana_5"),
                DB::raw("CASE WHEN ganador = 1 THEN 'SI' ELSE 'NO' END AS ganador")
            )
            ->get();
        return view('reportes.seguimiento-staff',compact('results'));
    }

    public function index_seguimiento_personal()
    {
        //
        //dd("ss");
        return view('reportes.seguimiento-personal');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
