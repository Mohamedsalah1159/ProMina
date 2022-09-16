<?php

namespace App\Traits;

trait SavingImageTrait
{
    public function saveFile($pic, $file){
        // save  in folder
        $file_extentions = $pic->getClientOriginalExtension();
        $file_name = rand() . '.' . $file_extentions;
        $path = $file;
        $pic->move($path, $file_name);
        return $file_name;
    }

}
