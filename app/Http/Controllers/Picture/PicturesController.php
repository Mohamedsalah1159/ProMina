<?php

namespace App\Http\Controllers\Picture;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Picture;

class PicturesController extends Controller
{
    public function destroy($id){
        try{
            $pic= Picture::find($id);
            if(!$pic){
                return redirect()->back()->with('error', 'this photo is dosen\'t exists');

            }
            $pic->delete();
            return redirect()->back()->with('success', 'the photo is successfuly deleted');

        }catch(\Exception $ex){
            return redirect()->back()->with('error', 'please try again later');
        }
    }
}
