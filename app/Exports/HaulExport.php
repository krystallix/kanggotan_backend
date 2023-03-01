<?php

namespace App\Exports;

use App\Models\Sender;
use Illuminate\Contracts\View\View;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Concerns\FromView;

class HaulExport implements FromView
{
    /**
    * @return \Illuminate\Support\Collection
    */
    // public function collection()
    // {
    //     return Sender::with('arwahs')->get();
    // }
    public function view(): View
    {
        return view('exports.export', [
            'hauls' => Sender::whereYear('created_at', 2023)->with('arwahs')->get()
        ]);
    }
}
