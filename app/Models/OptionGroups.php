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

    const OPTION_LIMIT_ON_LIST = 3;

    protected static function boot()
    {
        parent::boot();
        static::deleted(function ($row) {
            $row->optionsAdded()->delete();
            if ($row->forceDeleting === true) {
                $row->optionsAdded()->forceDelete();
            }
        });
        static::restoring(function ($row) {
            $row->optionsAdded()->withTrashed()->restore();
        });
    }

    public function optionsAdded()
    {
        return $this->hasMany(OptionGroupsOptions::class, 'option_groups_id', 'id');
    }


    public function options(){
        return $this->belongsToMany(Options::class,'option_groups_options')->withTrashed();
    }
    // public function services(){
    //     return $this->hasMany(Service::class, 'subcategory_id','id');
    // }
    // public function scopeList($query)
    // {
    //     return $query->orderBy('deleted_at', 'asc');
    // }
}
