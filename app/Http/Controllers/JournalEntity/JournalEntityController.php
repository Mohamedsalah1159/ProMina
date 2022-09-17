<?php

namespace App\Http\Controllers\JournalEntity;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Requests\JournalRequest;
use App\Models\JournalEntity;
use App\Models\Shipment;
use Illuminate\Support\Carbon;
use Illuminate\Support\Arr;


class JournalEntityController extends Controller
{
    public function addNew(){
        return view('Journals.journal');
    }
    public function index(){
        $journals = JournalEntity::select('*')->paginate(PAGINATION_COUNT);
        return view('Journals.journal', compact('journals'));
    }
    public function store(){
        try{
            //get all shipments today 
        $shipments = Shipment::whereDate('created_at' ,Carbon::today())->get();
        // get price of shipments if done and today 
        $amount = array();
        foreach($shipments as $shipment){
                            
            if($shipment->status == 2){
                array_push($amount, $shipment->price);
            }
        }
        //get all amount after some
        $totalAmount = array_sum($amount);
        // store in db
        $data=[
            ['amount'=>$totalAmount, 'type'=> 'depetCach', 'created_at'=>now(), 'updated_at'=>now()],
            ['amount'=>$totalAmount*20/100, 'type'=> 'creditRevenue', 'created_at'=>now(), 'updated_at'=>now()],
            ['amount'=>$totalAmount*80/100, 'type'=> 'creditPayable', 'created_at'=>now(), 'updated_at'=>now()]
        ];
        JournalEntity::insert($data);
        
        return redirect()->route('journal')->with('success', 'the jornal is created successfully');
        }catch(\Exception $ex){
            return redirect()->route('journal')->with('error', 'please try again later');
        }
        

    }
}
