<?php

namespace App\Http\Controllers\Shipments;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Shipment;
use App\Models\Picture;
use App\Traits\SavingImageTrait;
use App\Http\Requests\Albums\ShipmentRequest;
use App\Http\Requests\Albums\AlbumRequestUpdate;

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
    public function edit($id){
        try{
            $album= Album::find($id);
            if(!$album){
                return redirect()->route('albums')->with('error', 'this album doesn\'t exists');
            }
            $picsOfAlbum = Picture::select('id','name', 'created_at')->where('album_id', $id)->paginate(PAGINATION_COUNT);
            return view('Album.edit', compact(['album', 'picsOfAlbum']));
        }catch(\Exception $ex){
            return redirect()->route('albums')->with('error', 'please try again later');
        }
    }
    public function update(AlbumRequestUpdate $request, $id){
        try{
            $album= Album::find($id);
            if(!$album){
                return redirect()->route('albums')->with('error', 'this album doesn\'t exists');
            }
            //if has new request images 
            if($request->hasFile('pic')){
                foreach($request->pic as $newPic){
                                // save pictures in folder
                        $file_name = $this->saveFile($newPic, "pictures");


                        // get last album id saved

                        Picture::create([
                            'name' => $file_name,
                            'album_id' => $album->id
                        ]);
                    }

                }

            //update in db
            $album->update([
                'name' => $request->name
            ]);

            return redirect()->route('albums')->with('success', 'this album is updated successfuly');

        }catch(\Exception $ex){
            return redirect()->route('albums')->with('error', 'please try again later');
        }
    }
    public function destroy($id){
        try{
            $album= Album::find($id);
            if(!$album){
                return redirect()->route('albums')->with('error', 'this album is dosen\'t exists');

            }
            
            $allData = Picture::select('*')->where('album_id', $id);
            
            //delete pics in album 
            $allData->delete();
            //delete album
            $album->delete();
            return redirect()->route('albums')->with('success', 'the album is successfuly deleted');

        }catch(\Exception $ex){
            return redirect()->route('albums')->with('error', 'please try again later');
        }
    }
    
}
