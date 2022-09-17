<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Shipment extends Model
{
    protected $table = 'shipments';
    protected $fillable =[
        'id',
        'code',
        'shipper',
        'image',
        'weight',
        'description',
        'price',
        'status',
        'created_at',
        'updated_at'
    ];

    /*   Relations   */

    //
    public function picture(){
        return $this->hasMany('App\Models\Picture', 'album_id', 'id');
    }
}
