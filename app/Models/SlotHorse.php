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
        return $this->belongsTo(Slot::class);
    }

    public function horse()
    {
        return $this->belongsTo(Horse::class);
    }

    public function coach()
    {
        return $this->belongsTo(Coach::class);
    }

    public function rider()
    {
        return $this->belongsTo(Rider::class);
    }


}
