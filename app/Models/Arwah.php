<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Arwah extends Model
{
    use HasFactory;

    protected $fillable = [
        'sender_id',
        'arwah_name',
        'arwah_address',
        'arwah_type'
    ];
    public function sender(){
        return $this->belongsTo(Sender::class);
    }
}
