<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class Client extends Model
{
    use HasFactory, SoftDeletes;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'account_number',
        'company_name',
        'trading_name',
        'website',
        'email',
        'phone',
        'mobile',
        'address_line_1',
        'address_line_2',
        'city',
        'state',
        'zip_code',
        'country',
        'billing_address_same',
        'billing_address_line_1',
        'billing_address_line_2',
        'billing_city',
        'billing_state',
        'billing_zip_code',
        'billing_country',
        'payment_terms',
        'tax_id',
        'status',
        'notes',
        'created_by_id',
        'updated_by_id',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'billing_address_same' => 'boolean',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
        'deleted_at' => 'datetime',
    ];

    /**
     * US State abbreviations mapping.
     */
    public const US_STATES = [
        'Alabama' => 'AL', 'Alaska' => 'AK', 'Arizona' => 'AZ', 'Arkansas' => 'AR',
        'California' => 'CA', 'Colorado' => 'CO', 'Connecticut' => 'CT', 'Delaware' => 'DE',
        'Florida' => 'FL', 'Georgia' => 'GA', 'Hawaii' => 'HI', 'Idaho' => 'ID',
        'Illinois' => 'IL', 'Indiana' => 'IN', 'Iowa' => 'IA', 'Kansas' => 'KS',
        'Kentucky' => 'KY', 'Louisiana' => 'LA', 'Maine' => 'ME', 'Maryland' => 'MD',
        'Massachusetts' => 'MA', 'Michigan' => 'MI', 'Minnesota' => 'MN', 'Mississippi' => 'MS',
        'Missouri' => 'MO', 'Montana' => 'MT', 'Nebraska' => 'NE', 'Nevada' => 'NV',
        'New Hampshire' => 'NH', 'New Jersey' => 'NJ', 'New Mexico' => 'NM', 'New York' => 'NY',
        'North Carolina' => 'NC', 'North Dakota' => 'ND', 'Ohio' => 'OH', 'Oklahoma' => 'OK',
        'Oregon' => 'OR', 'Pennsylvania' => 'PA', 'Rhode Island' => 'RI', 'South Carolina' => 'SC',
        'South Dakota' => 'SD', 'Tennessee' => 'TN', 'Texas' => 'TX', 'Utah' => 'UT',
        'Vermont' => 'VT', 'Virginia' => 'VA', 'Washington' => 'WA', 'West Virginia' => 'WV',
        'Wisconsin' => 'WI', 'Wyoming' => 'WY', 'District of Columbia' => 'DC',
    ];

    /**
     * Canadian Province abbreviations mapping.
     */
    public const CA_PROVINCES = [
        'Alberta' => 'AB', 'British Columbia' => 'BC', 'Manitoba' => 'MB',
        'New Brunswick' => 'NB', 'Newfoundland and Labrador' => 'NL',
        'Northwest Territories' => 'NT', 'Nova Scotia' => 'NS', 'Nunavut' => 'NU',
        'Ontario' => 'ON', 'Prince Edward Island' => 'PE', 'Quebec' => 'QC',
        'Saskatchewan' => 'SK', 'Yukon' => 'YT',
    ];

    /**
     * Boot the model.
     */
    protected static function boot()
    {
        parent::boot();

        static::creating(function (Client $client) {
            // Auto-generate account number if not provided
            if (empty($client->account_number)) {
                $client->account_number = static::generateAccountNumber($client->company_name);
            }
        });
    }

    /**
     * Generate account number from company name.
     * Takes first 8 alphanumeric characters, uppercase.
     * Appends number suffix if duplicate exists.
     *
     * @param string $companyName
     * @return string
     */
    public static function generateAccountNumber(string $companyName): string
    {
        // Remove all non-alphanumeric characters and convert to uppercase
        $cleaned = preg_replace('/[^A-Za-z0-9]/', '', $companyName);
        $baseNumber = strtoupper(substr($cleaned, 0, 8));
        
        // Handle empty or very short names
        if (strlen($baseNumber) < 3) {
            $baseNumber = str_pad($baseNumber, 3, 'X');
        }

        // Check for duplicates and append suffix if needed
        $accountNumber = $baseNumber;
        $suffix = 1;
        
        while (static::withTrashed()->where('account_number', $accountNumber)->exists()) {
            $suffix++;
            // Ensure we don't exceed 10 characters
            $maxBaseLength = 10 - strlen((string)$suffix);
            $accountNumber = substr($baseNumber, 0, $maxBaseLength) . $suffix;
        }

        return $accountNumber;
    }

    /**
     * Convert state/province name to abbreviation.
     *
     * @param string|null $stateName
     * @param string $country
     * @return string|null
     */
    public static function abbreviateState(?string $stateName, string $country = 'United States'): ?string
    {
        if (empty($stateName)) {
            return null;
        }

        $stateName = trim($stateName);
        
        // If already abbreviated (2-3 chars), return as-is (uppercase)
        if (strlen($stateName) <= 3) {
            return strtoupper($stateName);
        }

        // Check US states
        if (stripos($country, 'United States') !== false || stripos($country, 'USA') !== false) {
            foreach (self::US_STATES as $name => $abbr) {
                if (strcasecmp($name, $stateName) === 0) {
                    return $abbr;
                }
            }
        }

        // Check Canadian provinces
        if (stripos($country, 'Canada') !== false) {
            foreach (self::CA_PROVINCES as $name => $abbr) {
                if (strcasecmp($name, $stateName) === 0) {
                    return $abbr;
                }
            }
        }

        // Return first 2 characters uppercase as fallback
        return strtoupper(substr($stateName, 0, 2));
    }

    /**
     * Format phone number to +1 AAA BBB CCCC format.
     *
     * @param string|null $phone
     * @return string|null
     */
    public static function formatPhoneNumber(?string $phone): ?string
    {
        if (empty($phone)) {
            return null;
        }

        // Remove all non-numeric characters except + at the beginning
        $cleaned = preg_replace('/[^0-9]/', '', $phone);
        
        // Handle numbers that already start with country code
        if (strlen($cleaned) === 11 && $cleaned[0] === '1') {
            $cleaned = substr($cleaned, 1);
        }
        
        // If we don't have exactly 10 digits, return cleaned version
        if (strlen($cleaned) !== 10) {
            // Still try to format if we have enough digits
            if (strlen($cleaned) >= 10) {
                $cleaned = substr($cleaned, -10); // Take last 10 digits
            } else {
                return $phone; // Return original if can't format
            }
        }

        // Format as +1 AAA BBB CCCC
        return sprintf('+1 %s %s %s',
            substr($cleaned, 0, 3),
            substr($cleaned, 3, 3),
            substr($cleaned, 6, 4)
        );
    }

    /**
     * Format Canadian postal code.
     *
     * @param string|null $postalCode
     * @return string|null
     */
    public static function formatCanadianPostalCode(?string $postalCode): ?string
    {
        if (empty($postalCode)) {
            return null;
        }

        // Remove all spaces and convert to uppercase
        $cleaned = strtoupper(preg_replace('/\s+/', '', $postalCode));
        
        // If it's 6 characters (Canadian format), add space in middle
        if (strlen($cleaned) === 6 && preg_match('/^[A-Z]\d[A-Z]\d[A-Z]\d$/', $cleaned)) {
            return substr($cleaned, 0, 3) . ' ' . substr($cleaned, 3, 3);
        }

        return $postalCode;
    }

    /**
     * Get the user who created this client.
     */
    public function createdBy(): BelongsTo
    {
        return $this->belongsTo(User::class, 'created_by_id');
    }

    /**
     * Get the user who last updated this client.
     */
    public function updatedBy(): BelongsTo
    {
        return $this->belongsTo(User::class, 'updated_by_id');
    }

    /**
     * Get the contacts for this client.
     */
    public function contacts(): HasMany
    {
        return $this->hasMany(ClientContact::class);
    }

    /**
     * Get the primary contact for this client.
     */
    public function primaryContact()
    {
        return $this->contacts()->where('is_primary', true)->first();
    }

    /**
     * Get the contracts for this client.
     */
    public function contracts(): HasMany
    {
        return $this->hasMany(Contract::class);
    }

    /**
     * Get the work logs for this client.
     */
    public function workLogs(): HasMany
    {
        return $this->hasMany(WorkLog::class);
    }

    /**
     * Scope a query to only include active clients.
     */
    public function scopeActive($query)
    {
        return $query->where('status', 'active');
    }

    /**
     * Scope a query to only include inactive clients.
     */
    public function scopeInactive($query)
    {
        return $query->where('status', 'inactive');
    }

    /**
     * Scope a query to search by company name or account number.
     */
    public function scopeSearch($query, string $search)
    {
        return $query->where(function ($q) use ($search) {
            $q->where('company_name', 'like', "%{$search}%")
              ->orWhere('account_number', 'like', "%{$search}%")
              ->orWhere('trading_name', 'like', "%{$search}%")
              ->orWhere('email', 'like', "%{$search}%");
        });
    }

    /**
     * Get the full address as a formatted string.
     */
    public function getFullAddressAttribute(): ?string
    {
        $parts = array_filter([
            $this->address_line_1,
            $this->address_line_2,
            $this->city,
            $this->state,
            $this->zip_code,
            $this->country,
        ]);

        return !empty($parts) ? implode(', ', $parts) : null;
    }

    /**
     * Get the billing address as a formatted string.
     */
    public function getBillingAddressAttribute(): ?string
    {
        if ($this->billing_address_same) {
            return $this->full_address;
        }

        $parts = array_filter([
            $this->billing_address_line_1,
            $this->billing_address_line_2,
            $this->billing_city,
            $this->billing_state,
            $this->billing_zip_code,
            $this->billing_country,
        ]);

        return !empty($parts) ? implode(', ', $parts) : null;
    }

    /**
     * Check if this client can be deleted.
     * Cannot delete if there are associated contracts or work logs.
     */
    public function canBeDeleted(): bool
    {
        return $this->contracts()->count() === 0 && $this->workLogs()->count() === 0;
    }

    /**
     * Get display name (company name with trading name if different).
     */
    public function getDisplayNameAttribute(): string
    {
        if ($this->trading_name && $this->trading_name !== $this->company_name) {
            return "{$this->company_name} (DBA: {$this->trading_name})";
        }
        
        return $this->company_name;
    }
}
