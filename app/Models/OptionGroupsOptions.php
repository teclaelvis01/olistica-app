<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OptionGroupsOptions extends Model
{
    use HasFactory;
    protected $table = 'option_groups_options';
    protected $dates = ['deleted_at'];
    protected $fillable = ['options_id', 'option_groups_id'];

    protected $casts = [
        'options_id' => 'integer',
        'option_groups_id' => 'integer',
    ];

    public function options()
    {
        return $this->belongsTo(Options::class, 'options_id', 'id');
    }

    public function optionGroups()
    {
        return $this->belongsTo(OptionGroups::class, 'option_groups_id', 'id');
    }
}
