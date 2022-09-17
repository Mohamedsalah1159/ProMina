<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class JournalEntity extends Model
{
    protected $table = 'journals';
    protected $fillable =[
        'id',
        'amount',
        'type',
        'created_at',
        'updated_at'
    ];


}
