<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Status extends Model
{
    protected $fillable = ['name'];

    public function getColorClassAttribute(): string
    {
        return match (strtolower(trim($this->name))) {
            'active' => 'bg-green-100  text-greenn-800',
            'for renewal' => 'bg-yellow-100 text-red-800',
            'terminated' => 'bg-red-100 text-red-800',
            default => 'bg-gray-100 text-gray-800',
        };
    }

    public function locations(): HasMany
    {
        return $this->hasMany(Location::class);
    }
}
