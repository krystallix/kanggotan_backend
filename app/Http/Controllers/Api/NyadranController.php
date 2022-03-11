<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Api\Controller;
use Illuminate\Http\Request;
use App\Models\Sender;
use App\Models\Arwah;
use Illuminate\Support\Facades\DB;
use App\Http\Requests\Api\NyadranRequest;
use App\Exports\HaulExport;
use Maatwebsite\Excel\Facades\Excel;
use Carbon\Carbon;
use App\Models\Log;

class NyadranController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $nyadrans = Sender::with('arwahs')->paginate($request->get('per_page', 15))->withQueryString();
        return $this->ok($nyadrans, "Success");
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
    public function addArwah(Sender $sender, Request $request) {
        if(auth()->user()->hasAnyRole(['Super Admin','Admin','Officer'])){
            foreach($request->all() as $arwah){        
                     Arwah::create([
                        "sender_id" => $sender->id,
                        "arwah_name" => $arwah['arwah_name'],
                        "arwah_address" => $arwah['arwah_address'],
                        "arwah_type" => $arwah['arwah_type'],
                    ]);
            }
            $senderOk = Sender::where('id', $sender->id)->with('arwahs')->get();
            $this->logging("Add Arwah by Sender", $sender->arwahs);
            return $this->ok($sender,"Success");
            // try{
            //     DB::beginTransaction();
            //     $sender = Sender::create([
            //         'name' => $request->data['name'],
            //         'phone' => $request->data['phone'],
            //         'address' => $request->data['address']
            //     ]);
            //     $arwahs = $request->data;
            //     $senderId = $sender->id;
            //     foreach($arwahs['data'] as $arwah){
            //         Arwah::create([
            //             "sender_id" => $senderId,
            //             "arwah_name" => $arwah['arwah_name'],
            //             "arwah_address" => $arwah['arwah_address'],
            //             "arwah_type" => $arwah['arwah_type'],
            //         ]);
            //     }
            //     $data = Sender::find($senderId)->with('arwahs')->get();
            // }catch(\Throwable $th){
            //     DB::rollBack();
            //     return $this->error($th);
            // }
            // DB::commit();
            // return $this->ok($data,"Success");
        }else {
            return $this->error("Not Authorized");
        }
    }
    public function store(Request $request)
    {
        if(auth()->user()->hasAnyRole(['Super Admin','Admin','Officer'])){
            try{
                DB::beginTransaction();
                $sender = Sender::create([
                    'name' => $request->data['name'],
                    'phone' => $request->data['phone'],
                    'address' => $request->data['address']
                ]);
                $arwahs = $request->data;
                $senderId = $sender->id;
                foreach($arwahs['data'] as $arwah){
                    Arwah::create([
                        "sender_id" => $senderId,
                        "arwah_name" => $arwah['arwah_name'],
                        "arwah_address" => $arwah['arwah_address'],
                        "arwah_type" => $arwah['arwah_type'],
                    ]);
                }
                $data = Sender::where('id', $senderId)->with('arwahs')->first();
            }catch(\Throwable $th){
                DB::rollBack();
                return $this->error($th);
            }
            DB::commit();
            $this->logging("Create Arwah", $data);
            return $this->ok($data,"Success");
        }else {
            return $this->error("Not Authorized");
        }
        //return $this->ok($request->data['data'],"Success")   
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $sender = Sender::findOrFail($id)->with('arwahs')->first();
        if($sender == null){
            return $this->error("Tidak Ditemukan");   
        }
        return $this->ok($sender, 'Success');
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
    public function destroyArwah(Arwah $arwah)
    {
        $arwah->delete();
        $this->logging("Destroy Arwah", $arwah);
        return $this->ok('','Success');
    }
    public function editArwah(Arwah $arwah, Request $request)
    {
        $arwah->update($request->all());
        $this->logging("Edit Arwah", $arwah);
        return $this->ok($arwah,'Success');
    }
    public function destroySender(Sender $sender)
    {
        $sender->delete();
        $this->logging("Destroy Sender", $sender);
        return $this->ok('','Success');
    }
    public function editSender(Sender $sender, Request $request)
    {
        $sender->update($request->all());
        $this->logging("Edit Sender", $sender);
        return $this->ok($sender,'Success');
    }

    public function search(Request $request){
        $senders = Sender::where('name','like', "%".$request->name."%")->with('arwahs')->get();
        return $this->ok($senders, 'Success');
    }

    public function stats() {
        $senders = Sender::count();
        $arwahs  = Arwah::count();
        return $this->ok([
            'total_sender' => $senders,
            'total_arwah' => $arwahs
        ],'Success');
    }

    public function export(){
        $nameFile = Carbon::now()->toDateTimeString() .'-Haul-2022.xlsx';
        return Excel::download(new HaulExport, $nameFile);
    }

    public function addresses(){
        $address = Arwah::distinct()->get(['arwah_address']);

        return $this->ok($address, 'Success');
    }
    public function arwahs(){
        $address = Arwah::distinct()->get(['arwah_name']);

        return $this->ok($address, 'Success');
    }

    public function logging($action, $data){
        $createLog = Log::create([
            'user' => auth()->user()->name,
            'action' => $action,
            'data' => $data
        ]);
        return $createLog;
    }
    public function logIndex(){
        $log = Log::all();
        return $this->ok($log, 'Success');
    }
}
