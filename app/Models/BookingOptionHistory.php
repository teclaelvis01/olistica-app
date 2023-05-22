<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BookingOptionHistory extends Model
{
    use HasFactory;
    protected $table = 'bookings_options_history';
    protected $fillable = [
        'reference', 'name' ,'price' , 'booking_id'
    ];

    public function booking(){
        return $this->belongsTo(Booking::class,'booking_id', 'id')->withTrashed();
    }
    
}
