<?php

namespace App\Http\Controllers\Shipments;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Shipment;
use App\Traits\SavingImageTrait;
use App\Http\Requests\Shipments\ShipmentRequest;
use App\Http\Requests\Shipments\ShipmentRequestUpdate;
use Illuminate\Support\Str;

class ShipmentController extends Controller
{
    use SavingImageTrait;

    public function addNew(){
        return view('Shipments.newShipment');
    }
    public function index(){
        $shipments = Shipment::select('*')->paginate(PAGINATION_COUNT);
        return view('welcome', compact('shipments'));
    }
    public function store(ShipmentRequest $request){
        try{
            // store in db
            $file_name = $this->saveFile($request->image, "pictures");
            if(($request->weight > 0) && ($request->weight <= 10)){
                $price = 10;
            }elseif(($request->weight > 10) && ($request->weight <= 25)){
                $price = 100;
            }else{
                $price = 300;
            }

            Shipment::create([
                'code' => $request->code,
                'shipper' => $request->shipper,
                'image' => $file_name,
                'weight' => $request->weight,
                'description' => $request->description,
                'price' => $price
            ]);


            return redirect()->route('Shipment')->with('success', 'the shipment is created successfully');
        }catch(\Exception $ex){
            return redirect()->route('addNewShipment')->with('error', 'please try again later');
        }
    }
    public function ChangeStatusToPending($id){
        try{
            $shipment = Shipment::find($id);
            if(!$shipment){
                return redirect()->route('Shipment')->with('error', 'this shipment doesn\'t exists');
            }
            $shipment->update([
                'status' => 0
            ]);
            return redirect()->route('Shipment')->with('success', 'the status is changed successfully');


        }catch(\Exception $ex){
            return redirect()->route('Shipment')->with('error', 'please try again later');

        }
    }
    
    public function ChangeStatusToProgress($id){
        try{
            $shipment = Shipment::find($id);
            if(!$shipment){
                return redirect()->route('Shipment')->with('error', 'this shipment doesn\'t exists');
            }
            $shipment->update([
                'status' => 1
            ]);
            return redirect()->route('Shipment')->with('success', 'the status is changed successfully');


        }catch(\Exception $ex){
            return redirect()->route('Shipment')->with('error', 'please try again later');

        }
    }
    public function ChangeStatusToDone($id){
        try{
            $shipment = Shipment::find($id);
            if(!$shipment){
                return redirect()->route('Shipment')->with('error', 'this shipment doesn\'t exists');
            }
            $shipment->update([
                'status' => 2
            ]);
            return redirect()->route('Shipment')->with('success', 'the status is changed successfully');


        }catch(\Exception $ex){
            return redirect()->route('Shipment')->with('error', 'please try again later');

        }
    }
    public function edit($id){
        try{
            $shipment= Shipment::find($id);
            if(!$shipment){
                return redirect()->route('Shipment')->with('error', 'this Shipment doesn\'t exists');
            }
            return view('Shipments.edit', compact('shipment'));
        }catch(\Exception $ex){
            return redirect()->route('Shipment')->with('error', 'please try again later');
        }
    }
    public function update(ShipmentRequestUpdate $request, $id){
        try{
            $shipment= Shipment::find($id);
            if(!$shipment){
                return redirect()->route('Shipment')->with('error', 'this shipment doesn\'t exists');
            }
            //if has new request images 
            if($request->hasFile('image')){
                // save pictures in folder
                $file_name = $this->saveFile($request->image, "pictures");
                //update in db
                $shipment->update([
                'image' => $file_name
                ]);
            }
            if(($request->weight > 0) && ($request->weight <= 10)){
                $price = 10;
            }elseif(($request->weight > 10) && ($request->weight <= 25)){
                $price = 100;
            }else{
                $price = 300;
            }

            //update in db
            $shipment->update([
                'code' => $request->code,
                'shipper' => $request->shipper,
                'weight' => $request->weight,
                'description' => $request->description,
                'price' => $price
            ]);

            return redirect()->route('Shipment')->with('success', 'this shipment is updated successfuly');

        }catch(\Exception $ex){
            return redirect()->route('Shipment')->with('error', 'please try again later');
        }
    }
    public function destroy($id){
        try{
            $shipment= Shipment::find($id);
            if(!$shipment){
                return redirect()->route('Shipment')->with('error', 'this shipment is dosen\'t exists');
            }
            $image = Str::afterLast($shipment->image, 'assets/');
            $image = base_path('public\pictures'. '\\' . $image);
            unlink($image); //delete photo from folder
            //delete album
            $shipment->delete();
            return redirect()->route('Shipment')->with('success', 'the shipment is successfuly deleted');

        }catch(\Exception $ex){
            return redirect()->route('Shipment')->with('error', 'please try again later');
        }
    }
    
}
