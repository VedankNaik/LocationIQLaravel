<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Validation extends Model
{
    use HasFactory;
    public $timestamps = false;

    protected $fillable = [
        'id','EGID','Street', 'Zip', 'Town','PlaceID','Latitide',
        'Longitude','DisplayName', 'Class', 'Type', 'Importance'
    ];
}
