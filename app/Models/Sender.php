<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Sender extends Model
{
    use HasFactory;
    protected $fillable = [
        'name',
        'phone',
        'address'
    ];
    public function arwahs(){
        return $this->hasMany(Arwah::class);
    }
}
