<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Horse extends Model
{
    use HasFactory, SoftDeletes;
    protected $guarded = [];

    public function coach()
    {
        // return $this->belongsToMany(Coach::class, 'coach_slot', 'slot_id', 'coach_id');
        return $this->belongsToMany(Coach::class, 'slot_horse', 'horse_id', 'coach_id')->withPivot(['rider_id','slot_id']);
    }

    public function slots()
    {
        return $this->belongsToMany(Slot::class, 'slot_horse', 'horse_id', 'slot_id')->withPivot(['rider_id', 'coach_id']);
    }

    public function rider()
    {
        return $this->belongsToMany(Rider::class, 'slot_horse', 'horse_id', 'rider_id')->withPivot(['coach_id','slot_id']);
    }

}
