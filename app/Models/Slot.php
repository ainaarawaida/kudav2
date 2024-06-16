<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Slot extends Model
{
    use HasFactory, SoftDeletes;
    protected $guarded = [];

    public function time()
    {
        return $this->belongsTo(Time::class);
    }

    public function coaches()
    {
        // return $this->belongsToMany(Coach::class, 'coach_slot', 'slot_id', 'coach_id');
        return $this->belongsToMany(Coach::class, 'slot_horse', 'slot_id', 'coach_id')->withPivot(['rider_id','horse_id']);
    }

    public function horses()
    {
        return $this->belongsToMany(Horse::class, 'slot_horse', 'slot_id', 'horse_id')->withPivot(['rider_id', 'coach_id']);
    }

    public function riders()
    {
        return $this->belongsToMany(Rider::class, 'slot_horse', 'slot_id', 'rider_id')->withPivot(['coach_id','horse_id']);
    }

    public function slot_horse()
    {
        return $this->hasMany(SlotHorse::class);
    }




}
