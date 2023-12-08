<?php

namespace App\Models;

use App\Models\Module;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Role extends Model
{
    use HasFactory;

    protected $guarded = [];

    protected $casts = [
        'is_admin' => 'boolean',
        'is_active' => 'boolean'
    ];

    public function users()
    {
        return $this->hasMany(User::class);
    }

    public function assign($moduleIds)
    {
        //Delete all records for this specific role before inserting
        \DB::table('modules_access')->where('role_id', $this->id)->delete();

        return $this->access()->attach($moduleIds);
    }

    public function access()
    {
        return $this->belongsToMany(Module::class, 'modules_access')->withTimestamps();
    }
}
