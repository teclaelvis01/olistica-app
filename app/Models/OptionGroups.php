<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class OptionGroups extends Model
{
    use HasFactory, SoftDeletes;
    protected $table = 'option_groups';
    protected $fillable = [
        'name'
    ];


    // public function category(){
    //     return $this->belongsTo('App\Models\Category','category_id','id')->withTrashed();
    // }
    // public function services(){
    //     return $this->hasMany(Service::class, 'subcategory_id','id');
    // }
    // public function scopeList($query)
    // {
    //     return $query->orderBy('deleted_at', 'asc');
    // }
}
