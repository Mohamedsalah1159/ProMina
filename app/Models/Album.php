<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Album extends Model
{
    protected $table = 'albums';
    protected $fillable =[
        'id',
        'name',
        'created_at',
        'updated_at'
    ];
    protected $hidden = [
        'created_at',
        'updated_at'
    ];
    /*   Relations   */
    public function picture(){
        return $this->hasMany('App\Models\Picture', 'album_id', 'id');
    }
}
