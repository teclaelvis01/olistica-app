<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OptionGroupsService extends Model
{
    use HasFactory;

    protected $table = 'option_groups_services';
    protected $dates = ['deleted_at'];
    protected $fillable = ['option_groups_id', 'service_id'];

    protected $casts = [
        'option_groups_id' => 'integer',
        'service_id' => 'integer',
    ];

    public function services()
    {
        return $this->belongsTo(Service::class, 'service_id', 'id');
    }

    public function optionGroups()
    {
        return $this->belongsTo(OptionGroups::class, 'option_groups_id', 'id');
    }
}
