<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserWageHistory extends Model
{
    use HasFactory;

    protected $table = 'user_wage_history';

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'user_id',
        'wage_type',
        'wage_rate',
        'start_date',
        'end_date',
        'created_by',
        'notes',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'wage_rate' => 'decimal:2',
        'start_date' => 'date',
        'end_date' => 'date',
    ];

    /**
     * Get the user that this wage history belongs to.
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Get the user who created this wage history record.
     */
    public function createdBy()
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    /**
     * Scope to get current wage records (where end_date is null).
     */
    public function scopeCurrent($query)
    {
        return $query->whereNull('end_date');
    }

    /**
     * Scope to get historical wage records (where end_date is not null).
     */
    public function scopeHistorical($query)
    {
        return $query->whereNotNull('end_date');
    }

    /**
     * Get formatted wage rate for display
     */
    public function getFormattedWageAttribute()
    {
        if ($this->wage_type === 'salary') {
            return '$' . number_format($this->wage_rate, 2) . '/year';
        } elseif ($this->wage_type === 'hourly') {
            return '$' . number_format($this->wage_rate, 2) . '/hour';
        }
        return 'Not set';
    }

    /**
     * Check if this wage history record can be edited
     * Only current wages and notes can be edited
     */
    public function canEdit()
    {
        // Allow editing notes for historical records
        // Allow full editing for current records
        return $this->end_date === null;
    }
}