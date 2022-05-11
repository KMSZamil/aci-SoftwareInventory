<?php

namespace App\Exports;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class MyProjectsExport implements FromCollection, WithHeadings
{
    /**
     * @return \Illuminate\Support\Collection
     */
    public function collection()
    {
        $UserID = Auth::user()->UserID;
        try {
            $result = DB::select("EXEC usp_doLoadSoftwareList '$UserID'");
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
