<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
class Location extends Model
    {
    protected $fillable = [
        'site_name',
        'barangay',
        'municipality_id',
        'status_id',
        'latitude',
        'longitude',
        'start_date',
        'renewal_date',
        ];

    protected $casts = [
        'start_date'   => 'date',
        'renewal_date' => 'date',
        'latitude'     => 'decimal:7',
        'longitude'    => 'decimal:7',
    ];

    public function province(): BelongsTo
    {
        return $this->belongsTo(Province::class);
    }

    public function municipality(): BelongsTo
    {
        return $this->belongsTo(Municipality::class);
    }

    public function status(): BelongsTo
    {
        return $this->belongsTo(Status::class);
    }
}
