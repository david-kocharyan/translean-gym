<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class Dimmer extends Model
{
    protected $table = "dimmer";
    public $timestamps = false;
    
    protected $fillable = [
        'user_id','date', 'dimmer'
    ];

    public function resolveChildRouteBinding($childType, $value, $field)
    {
        // TODO: Implement resolveChildRouteBinding() method.
    }

}
