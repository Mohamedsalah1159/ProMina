<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Picture extends Model
{
    protected $table = 'journal_entity';
    protected $fillable =[
        'id',
        'amount',
        'type',
        'created_at',
        'updated_at'
    ];
    protected $hidden = [
        'created_at',
        'updated_at'
    ];
    /*   Relations   */
    ///
    public function album(){
        return $this->belongsTo('App\Models\Album', 'album_id', 'id');
    }
}
