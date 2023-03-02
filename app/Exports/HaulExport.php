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

    public function view(Request $request): View
    {
        return view('exports.export', [
            'hauls' => Sender::whereYear('created_at', $request->get('year'))->with('arwahs')->get()

        ]);
    }
}
