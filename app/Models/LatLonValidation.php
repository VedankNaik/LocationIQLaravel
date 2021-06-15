<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class LatLonValidation extends Model
{
    use HasFactory;
    public $timestamps = false;

    protected $fillable = [
        'ID','RefID','City','OldLatitude','OldLongitude','PlaceID','NewLatitude', 
        'NewLongitude', 'DisplayName', 'Importance'
    ];
}
