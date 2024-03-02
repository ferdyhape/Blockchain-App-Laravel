<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Role extends Model
{
    use HasFactory, HasUuids;

    protected $guarded = ['id', 'created_at', 'updated_at'];

    public function users()
    {
        return $this->hasMany(User::class);
    }
}
