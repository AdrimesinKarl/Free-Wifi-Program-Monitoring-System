<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsTo;


class Province extends Model
{
    protected $fillable = ['name', 'region_id'];

    public function municipalities(): HasMany
    {
        return $this->hasMany(Municipality::class);
    }

    public function region(): BelongsTo
    {
        return $this->belongsTo(Region::class);
    }

}