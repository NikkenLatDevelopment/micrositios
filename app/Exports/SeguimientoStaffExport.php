<?php

namespace App\Exports;

use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Concerns\FromQuery;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\Exportable;

class SeguimientoStaffExport implements FromQuery, WithHeadings, WithMapping
{
    /**
    * @return \Illuminate\Support\Collection
    */
    use Exportable;

    public function query()
    {
        $query = "
            SELECT TOP 100 PERCENT 
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
            ORDER BY associateid";
        
        return DB::connection('75')->table(DB::raw("($query) as sub"))
            ->orderBy('associateid');
    }

    public function headings(): array
    {
        return [
            'Código',
            'Nombre',
            'Tipo',
            'Rango',
            'País',
            'Teléfono',
            'Correo',
            'Patrocinador Código',
            'Patrocinador Nombre',
            'Rango Patrocinador',
            'Semana 1',
            'Semana 2',
            'Semana 3',
            'Semana 4',
            'Semana 5',
            'Ganador'
        ];
    }

    public function map($row): array
    {
        return [
            $row->associateid,
            $row->associateName,
            $row->tipo,
            $row->rangoSocio,
            $row->pais,
            $row->telefono,
            $row->email,
            $row->sponsorid,
            $row->sponsorName,
            $row->rangoSponsor,
            $row->semana_1,
            $row->semana_2,
            $row->semana_3,
            $row->semana_4,
            $row->semana_5,
            $row->ganador
        ];
    }
}
