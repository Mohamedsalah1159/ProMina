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
    //get status from db and edit it
    public function getStatus(){
        if($this->status == 0){
            return 'Pending';
        }elseif($this->status == 1){
            return 'Progress';
        }else{
            return 'Done';
        }
    }

    
}
