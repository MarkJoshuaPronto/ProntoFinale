<?php

namespace App\Exports;

use App\Models\DonationModel;
use Maatwebsite\Excel\Concerns\FromCollection;

class DonationsExport implements FromCollection
{
    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        return DonationModel::where('status', 'accepted')->get();
    }
}
