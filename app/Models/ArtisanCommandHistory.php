<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ArtisanCommandHistory extends Model
{
    protected $fillable = [
        'command',
        'parameters',
        'status',
        'output',
        'duration',
        'exit_code',
    ];

    protected $casts = [
        'duration' => 'float',
        'exit_code' => 'integer',
    ];

    /**
     * Scope successful command executions.
     */
    public function scopeSuccessful($query)
    {
        return $query->where('status', 'success');
    }

    /**
     * Scope failed command executions.
     */
    public function scopeFailed($query)
    {
        return $query->where('status', 'failed');
    }

    /**
     * Get a readable duration.
     */
    public function getFormattedDurationAttribute(): string
    {
        if ($this->duration < 1000) {
            return $this->duration . ' ms';
        }

        return number_format($this->duration / 1000, 2) . ' sec';
    }
}