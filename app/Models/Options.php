<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Options extends Model
{
    use HasFactory, SoftDeletes;
    protected $table = 'options';
    protected $fillable = [
        'name',
        'price'
    ];
    protected $hidden = ['deleted_at','created_at','updated_at'];

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

    public function optionsAdded(){
        return $this->hasMany(OptionGroupsOptions::class,'options_id','id');
    }
}
