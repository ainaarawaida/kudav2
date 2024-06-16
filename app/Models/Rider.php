<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Rider extends Model
{
    use HasFactory, SoftDeletes;
    protected $guarded = [];

    public function coaches()
    {
        // return $this->belongsToMany(Coach::class, 'coach_slot', 'slot_id', 'coach_id');
        return $this->belongsToMany(Coach::class, 'slot_horse', 'rider_id', 'coach_id')->withPivot(['slot_id','horse_id']);
    }

    public function horses()
    {
        return $this->belongsToMany(Horse::class, 'slot_horse', 'rider_id', 'horse_id')->withPivot(['slot_id', 'coach_id']);
    }

    public function slots()
    {
        return $this->belongsToMany(Rider::class, 'slot_horse', 'rider_id', 'slot_id')->withPivot(['coach_id','horse_id']);
    }

    
}
