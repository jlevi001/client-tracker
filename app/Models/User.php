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
     */
    public function wageHistory()
    {
        return $this->hasMany(UserWageHistory::class)->orderBy('start_date', 'desc');
    }

    /**
     * Get the current wage record for this user.
     */
    public function currentWage()
    {
        return $this->hasOne(UserWageHistory::class)->whereNull('end_date');
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
     * Set a new wage for the user
     * This will close the current wage record and create a new one
     */
    public function setWage($wageType, $wageRate, $startDate, $notes = null, $createdBy = null)
    {
        // Get the current active wage
        $currentWage = $this->currentWage;

        // If there's a current wage and the start date is different, close it
        if ($currentWage && $currentWage->start_date->format('Y-m-d') !== $startDate) {
            $currentWage->update([
                'end_date' => \Carbon\Carbon::parse($startDate)->subDay()
            ]);
        }

        // If updating the same wage record (same start date), update it
        if ($currentWage && $currentWage->start_date->format('Y-m-d') === $startDate) {
            $currentWage->update([
                'wage_type' => $wageType,
                'wage_rate' => $wageRate,
                'notes' => $notes,
            ]);
            return $currentWage;
        }

        // Create new wage history record
        return $this->wageHistory()->create([
            'wage_type' => $wageType,
            'wage_rate' => $wageRate,
            'start_date' => $startDate,
            'end_date' => null,
            'created_by' => $createdBy ?: auth()->id(),
            'notes' => $notes,
        ]);
    }
}