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
            $result = DB::select("SELECT SoftwareID,SoftwareName,Description,NumberOfUser,NumberOfUser,ImplementationDate,ContactPerson,EntryBy
            FROM Software Where EntryBy = '$UserID'");
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
