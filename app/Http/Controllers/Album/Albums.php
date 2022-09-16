<?php

namespace App\Http\Controllers\Album;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Album;
use App\Models\Picture;
use App\Traits\SavingImageTrait;
use App\Http\Requests\Albums\AlbumRequest;
use App\Http\Requests\Albums\AlbumRequestUpdate;

class Albums extends Controller
{
    use SavingImageTrait;

    public function addNew(){
        return view('Album.newAlbum');
    }
    public function index(){
        $albums = Album::select('*')->paginate(PAGINATION_COUNT);
        return view('welcome', compact('albums'));
    }
    public function store(AlbumRequest $request){
        try{
            // store in db
            Album::create([
                'name' => $request->name
            ]);
            if($request->hasFile('pic')){
                foreach($request->pic as $newPic){
                                // save pictures in folder
                        $file_name = $this->saveFile($newPic, "pictures");


                        // get last album id saved

                        $lastAlbumId = Album::select('id')->latest()->first();
                        $lastID = $lastAlbumId->id;
                        Picture::create([
                            'name' => $file_name,
                            'album_id' => $lastID
                        ]);

                }
            }

            return redirect()->route('albums')->with('success', 'the album is created successfully');
        }catch(\Exception $ex){
            return redirect()->route('addNewAlbum')->with('error', 'please try again later');
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
            return $ex;
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
