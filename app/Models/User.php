<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Fortify\TwoFactorAuthenticatable;
use Laravel\Jetstream\HasProfilePhoto;
use Laravel\Sanctum\HasApiTokens;
use Spatie\Permission\Traits\HasRoles;
use Carbon\Carbon;

class User extends Authenticatable implements MustVerifyEmail
{
    use HasApiTokens;
    use HasFactory;
    use HasProfilePhoto;
    use Notifiable;
    use TwoFactorAuthenticatable;
    use HasRoles;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'employment_start_date',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
        'two_factor_recovery_codes',
        'two_factor_secret',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
        'password' => 'hashed',
        'employment_start_date' => 'date',
    ];

    /**
     * Accessors to append to the model's array form.
     *
     * @var array<int, string>
     */
    protected $appends = [
        'profile_photo_url',
        'current_wage_type',
        'current_wage_rate',
        'formatted_current_wage',
    ];

    /**
     * Get all wage history records for this user.
     * Always ordered by start_date descending for display.
     */
    public function wageHistory()
    {
        return $this->hasMany(UserWageHistory::class)->orderBy('start_date', 'desc');
    }

    /**
     * Get the current wage record for this user.
     * This is the wage with the most recent start_date and null end_date.
     */
    public function currentWage()
    {
        return $this->hasOne(UserWageHistory::class)
            ->whereNull('end_date')
            ->orderBy('start_date', 'desc');
    }

    /**
     * Get historical wage records for this user.
     */
    public function historicalWages()
    {
        return $this->hasMany(UserWageHistory::class)
            ->whereNotNull('end_date')
            ->orderBy('end_date', 'desc');
    }

    /**
     * Get current wage type attribute
     */
    public function getCurrentWageTypeAttribute()
    {
        return $this->currentWage?->wage_type;
    }

    /**
     * Get current wage rate attribute
     */
    public function getCurrentWageRateAttribute()
    {
        return $this->currentWage?->wage_rate;
    }

    /**
     * Get formatted current wage for display
     */
    public function getFormattedCurrentWageAttribute()
    {
        if (!$this->currentWage) {
            return 'Not set';
        }

        if ($this->currentWage->wage_type === 'salary') {
            return '$' . number_format($this->currentWage->wage_rate, 2) . '/year';
        } elseif ($this->currentWage->wage_type === 'hourly') {
            return '$' . number_format($this->currentWage->wage_rate, 2) . '/hour';
        }

        return 'Not set';
    }

    /**
     * Add or update a wage for the user
     * This will automatically recalculate all wage end dates
     */
    public function setWage($wageType, $wageRate, $startDate, $notes = null, $createdBy = null)
    {
        // Check if we're updating an existing wage with the same start date
        $existingWage = $this->wageHistory()
            ->whereDate('start_date', $startDate)
            ->first();

        if ($existingWage) {
            // Update existing wage
            $existingWage->update([
                'wage_type' => $wageType,
                'wage_rate' => $wageRate,
                'notes' => $notes,
            ]);
        } else {
            // Create new wage history record
            $this->wageHistory()->create([
                'wage_type' => $wageType,
                'wage_rate' => $wageRate,
                'start_date' => $startDate,
                'end_date' => null, // Will be recalculated
                'created_by' => $createdBy ?: auth()->id(),
                'notes' => $notes,
            ]);
        }

        // Recalculate all end dates for this user's wage history
        $this->recalculateWageEndDates();

        return $this->currentWage;
    }

    /**
     * Recalculate all wage end dates based on start dates
     * The wage with the latest start_date will have null end_date (current wage)
     */
    public function recalculateWageEndDates()
    {
        // Get all wages ordered by start_date ascending
        $wages = $this->wageHistory()
            ->orderBy('start_date', 'asc')
            ->get();

        if ($wages->isEmpty()) {
            return;
        }

        // Process each wage
        for ($i = 0; $i < $wages->count(); $i++) {
            $currentWage = $wages[$i];
            
            if ($i < $wages->count() - 1) {
                // This is not the last wage, so set end_date to day before next wage starts
                $nextWage = $wages[$i + 1];
                $endDate = Carbon::parse($nextWage->start_date)->subDay();
                
                $currentWage->update([
                    'end_date' => $endDate
                ]);
            } else {
                // This is the last wage (most recent), so it should be current (null end_date)
                $currentWage->update([
                    'end_date' => null
                ]);
            }
        }
    }

    /**
     * Delete a wage history record and recalculate dates
     */
    public function deleteWage($wageId)
    {
        $wage = $this->wageHistory()->find($wageId);
        
        if ($wage) {
            // Don't allow deletion of the only wage
            if ($this->wageHistory()->count() === 1) {
                return false;
            }
            
            $wage->delete();
            $this->recalculateWageEndDates();
            return true;
        }
        
        return false;
    }
}