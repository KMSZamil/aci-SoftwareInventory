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
            $result = DB::select("EXEC usp_doLoadSoftwareList ''");
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
            'Platform',
            'Description',
            'NumberOfUser',
            'ContactPerson',
            'ImplementationDate',
            'Status',
            'EntryBy',
            'Department',
            'Developers'
        ];
    }
}
