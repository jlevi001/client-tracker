<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class WageHistory extends Model
{
    use HasFactory;

    protected $table = 'user_wage_history';

    protected $fillable = [
        'user_id',
        'wage_type',
        'wage_rate',
        'start_date',
        'end_date',
        'created_by',
        'notes',
    ];

    protected $casts = [
        'wage_rate' => 'decimal:2',
        'start_date' => 'date',
        'end_date' => 'date',
    ];

    /**
     * Get the user that owns this wage history record
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Get the admin user who created this record
     */
    public function createdBy()
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    /**
     * Scope to get only current/active wage records
     */
    public function scopeCurrent($query)
    {
        return $query->whereNull('end_date');
    }

    /**
     * Scope to get historical (ended) wage records
     */
    public function scopeHistorical($query)
    {
        return $query->whereNotNull('end_date');
    }

    /**
     * Scope to get records ordered by start date (newest first)
     */
    public function scopeLatest($query)
    {
        return $query->orderBy('start_date', 'desc');
    }

    /**
     * Check if this is the current active wage record
     */
    public function isCurrent()
    {
        return is_null($this->end_date);
    }

    /**
     * Format wage rate for display
     */
    public function getFormattedWageAttribute()
    {
        return '$' . number_format($this->wage_rate, 2);
    }
}