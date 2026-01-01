<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class ServiceType extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'description',
        'is_billable',
        'is_active',
        'display_order',
        'created_by_id',
        'updated_by_id',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'is_billable' => 'boolean',
        'is_active' => 'boolean',
        'display_order' => 'integer',
    ];

    /**
     * Get the user who created this service type.
     */
    public function createdBy(): BelongsTo
    {
        return $this->belongsTo(User::class, 'created_by_id');
    }

    /**
     * Get the user who last updated this service type.
     */
    public function updatedBy(): BelongsTo
    {
        return $this->belongsTo(User::class, 'updated_by_id');
    }

    /**
     * Get the work logs for this service type.
     */
    public function workLogs(): HasMany
    {
        return $this->hasMany(WorkLog::class);
    }

    /**
     * Scope a query to only include active service types.
     */
    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    /**
     * Scope a query to only include billable service types.
     */
    public function scopeBillable($query)
    {
        return $query->where('is_billable', true);
    }

    /**
     * Scope a query to order by display order.
     */
    public function scopeOrdered($query)
    {
        return $query->orderBy('display_order', 'asc')->orderBy('name', 'asc');
    }

    /**
     * Check if this service type can be deleted.
     * Cannot delete if there are associated work logs.
     */
    public function canBeDeleted(): bool
    {
        return $this->workLogs()->count() === 0;
    }

    /**
     * Get the display name with billable indicator.
     */
    public function getDisplayNameAttribute(): string
    {
        return $this->name . ($this->is_billable ? '' : ' (Non-billable)');
    }
}
