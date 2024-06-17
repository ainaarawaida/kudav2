<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SlotHorse extends Model
{
    use HasFactory;
    protected $guarded = [];
    protected $table = 'slot_horse';

    
    public function slots()
    {
        return $this->belongsTo(Slot::class, 'slot_id', 'id');
    }

    public function horse()
    {
        return $this->belongsTo(Horse::class, 'horse_id', 'id');
    }

    public function coach()
    {
        return $this->belongsTo(Coach::class, 'coach_id', 'id');
    }

    public function rider()
    {
        return $this->belongsTo(Rider::class, 'rider_id', 'id');
    }


}
