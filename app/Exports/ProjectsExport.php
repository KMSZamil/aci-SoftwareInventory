<?php

namespace App\Exports;

use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class ProjectsExport implements FromCollection, WithHeadings
{
    /**
     * @return \Illuminate\Support\Collection
     */
    public function collection()
    {
        try {
            $result = DB::select("SELECT SoftwareID,SoftwareName,Description,NumberOfUser,NumberOfUser,ImplementationDate,ContactPerson,EntryBy
            FROM Software");
            //dd($result);
        } catch (\Exception $e) {
            dd("Error");
        }
        return collect($result);
    }

    public function headings(): array
    {
        return [
            'SoftwareID',
            'SoftwareName',
            'Description',
            'NumberOfUser',
            'ImplementationDate',
            'ContactPerson',
            'EntryBy'
        ];
    }
}
