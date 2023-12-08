<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Module extends Model
{
    use HasFactory;

    protected $guarded = [];

    protected $casts = [
        'is_active' => 'boolean'
    ];

    public function parent()
    {
        return $this->belongsTo(Module::class, 'parent_id')->where('is_active',true);
    }

    public function children()
    {
        return $this->hasMany(Module::class, 'parent_id')->where('is_active', true);
    }

    public static function byRouteName($name)
    {
        return self::where(['is_active' => true,'route_uri' => $name])->first();
    }
}
