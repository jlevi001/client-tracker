<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
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
        'default_hourly_rate',
        'hosting_provider',
        'hosting_managed_by',
        'domain_registrar',
        'domain_registrar_other',
        'dns_managed_elsewhere',
        'dns_provider',
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
        'dns_managed_elsewhere' => 'boolean',
        'default_hourly_rate' => 'decimal:2',
    ];

    /**
     * State abbreviation mapping
     */
    public static $stateAbbreviations = [
        // US States
        'alabama' => 'AL', 'alaska' => 'AK', 'arizona' => 'AZ', 'arkansas' => 'AR',
        'california' => 'CA', 'colorado' => 'CO', 'connecticut' => 'CT', 'delaware' => 'DE',
        'florida' => 'FL', 'georgia' => 'GA', 'hawaii' => 'HI', 'idaho' => 'ID',
        'illinois' => 'IL', 'indiana' => 'IN', 'iowa' => 'IA', 'kansas' => 'KS',
        'kentucky' => 'KY', 'louisiana' => 'LA', 'maine' => 'ME', 'maryland' => 'MD',
        'massachusetts' => 'MA', 'michigan' => 'MI', 'minnesota' => 'MN', 'mississippi' => 'MS',
        'missouri' => 'MO', 'montana' => 'MT', 'nebraska' => 'NE', 'nevada' => 'NV',
        'new hampshire' => 'NH', 'new jersey' => 'NJ', 'new mexico' => 'NM', 'new york' => 'NY',
        'north carolina' => 'NC', 'north dakota' => 'ND', 'ohio' => 'OH', 'oklahoma' => 'OK',
        'oregon' => 'OR', 'pennsylvania' => 'PA', 'rhode island' => 'RI', 'south carolina' => 'SC',
        'south dakota' => 'SD', 'tennessee' => 'TN', 'texas' => 'TX', 'utah' => 'UT',
        'vermont' => 'VT', 'virginia' => 'VA', 'washington' => 'WA', 'west virginia' => 'WV',
        'wisconsin' => 'WI', 'wyoming' => 'WY',
        // Canadian Provinces
        'alberta' => 'AB', 'british columbia' => 'BC', 'manitoba' => 'MB', 'new brunswick' => 'NB',
        'newfoundland and labrador' => 'NL', 'northwest territories' => 'NT', 'nova scotia' => 'NS',
        'nunavut' => 'NU', 'ontario' => 'ON', 'prince edward island' => 'PE', 'quebec' => 'QC',
        'saskatchewan' => 'SK', 'yukon' => 'YT',
    ];

    /**
     * Hosting provider options
     */
    public static $hostingProviders = [
        '' => 'Select...',
        'bluehost' => 'Bluehost',
        'godaddy' => 'GoDaddy',
        'siteground' => 'SiteGround',
        'hostgator' => 'HostGator',
        'dreamhost' => 'DreamHost',
        'a2hosting' => 'A2 Hosting',
        'inmotion' => 'InMotion',
        'cloudways' => 'Cloudways',
        'aws' => 'AWS',
        'digitalocean' => 'DigitalOcean',
        'linode' => 'Linode',
        'vultr' => 'Vultr',
        'wpengine' => 'WP Engine',
        'kinsta' => 'Kinsta',
        'flywheel' => 'Flywheel',
        'other' => 'Other',
        'none' => 'None',
        'unknown' => 'Unknown',
    ];

    /**
     * Domain registrar options
     */
    public static $domainRegistrars = [
        '' => 'Select...',
        'godaddy' => 'GoDaddy',
        'namecheap' => 'Namecheap',
        'namesilo' => 'Namesilo',
        'google' => 'Google Domains',
        'cloudflare' => 'Cloudflare',
        'networksolutions' => 'Network Solutions',
        'hover' => 'Hover',
        'namecom' => 'Name.com',
        'wix' => 'Wix',
        'other' => 'Other',
        'unknown' => 'Unknown',
    ];

    /**
     * Generate account number from company name
     */
    public static function generateAccountNumber(string $companyName): string
    {
        // Remove special characters and convert to uppercase
        $cleanName = preg_replace('/[^A-Za-z0-9]/', '', $companyName);
        $cleanName = strtoupper($cleanName);
        
        // Get first 8 characters
        $baseNumber = substr($cleanName, 0, 8);
        
        // Pad with zeros if less than 8 characters
        $baseNumber = str_pad($baseNumber, 8, '0', STR_PAD_RIGHT);
        
        // Check for duplicates and add suffix if needed
        $accountNumber = $baseNumber;
        $suffix = 2;
        
        while (self::where('account_number', $accountNumber)->exists()) {
            $accountNumber = $baseNumber . $suffix;
            $suffix++;
        }
        
        return $accountNumber;
    }

    /**
     * Format phone number to: +1 XXX XXX XXXX
     */
    public static function formatPhoneNumber(?string $phone): ?string
    {
        if (empty($phone)) {
            return null;
        }

        // Remove all non-numeric characters
        $cleaned = preg_replace('/[^0-9]/', '', $phone);
        
        // Handle different lengths
        if (strlen($cleaned) === 10) {
            // US number without country code
            return '+1 ' . substr($cleaned, 0, 3) . ' ' . substr($cleaned, 3, 3) . ' ' . substr($cleaned, 6, 4);
        } elseif (strlen($cleaned) === 11 && $cleaned[0] === '1') {
            // US number with country code
            return '+1 ' . substr($cleaned, 1, 3) . ' ' . substr($cleaned, 4, 3) . ' ' . substr($cleaned, 7, 4);
        }
        
        // Return original if format not recognized
        return $phone;
    }

    /**
     * Abbreviate state name
     */
    public static function abbreviateState(?string $state): ?string
    {
        if (empty($state)) {
            return null;
        }

        $stateLower = strtolower(trim($state));
        
        // If already abbreviated (2 characters), return uppercase
        if (strlen($state) === 2) {
            return strtoupper($state);
        }
        
        // Look up abbreviation
        return self::$stateAbbreviations[$stateLower] ?? $state;
    }

    /**
     * Mutator for phone
     */
    public function setPhoneAttribute($value): void
    {
        $this->attributes['phone'] = self::formatPhoneNumber($value);
    }

    /**
     * Mutator for mobile
     */
    public function setMobileAttribute($value): void
    {
        $this->attributes['mobile'] = self::formatPhoneNumber($value);
    }

    /**
     * Mutator for state
     */
    public function setStateAttribute($value): void
    {
        $this->attributes['state'] = self::abbreviateState($value);
    }

    /**
     * Mutator for billing_state
     */
    public function setBillingStateAttribute($value): void
    {
        $this->attributes['billing_state'] = self::abbreviateState($value);
    }

    /**
     * Get formatted contact information for display
     */
    public function getFormattedContactAttribute(): string
    {
        if (!empty($this->mobile)) {
            return 'm: ' . $this->mobile;
        } elseif (!empty($this->phone)) {
            return 'o: ' . $this->phone;
        }
        return '—';
    }

    /**
     * Get display name for hosting provider
     */
    public function getHostingProviderDisplayAttribute(): string
    {
        if (empty($this->hosting_provider)) {
            return '—';
        }
        return self::$hostingProviders[$this->hosting_provider] ?? ucfirst($this->hosting_provider);
    }

    /**
     * Get display name for domain registrar
     */
    public function getDomainRegistrarDisplayAttribute(): string
    {
        if (empty($this->domain_registrar)) {
            return '—';
        }
        
        if ($this->domain_registrar === 'other' && !empty($this->domain_registrar_other)) {
            return $this->domain_registrar_other;
        }
        
        return self::$domainRegistrars[$this->domain_registrar] ?? ucfirst($this->domain_registrar);
    }

    /**
     * Relationships
     */
    public function createdBy()
    {
        return $this->belongsTo(User::class, 'created_by_id');
    }

    public function updatedBy()
    {
        return $this->belongsTo(User::class, 'updated_by_id');
    }

    /**
     * Scopes
     */
    public function scopeActive($query)
    {
        return $query->where('status', 'active');
    }

    public function scopeSearch($query, $search)
    {
        return $query->where(function ($q) use ($search) {
            $q->where('company_name', 'like', '%' . $search . '%')
              ->orWhere('account_number', 'like', '%' . $search . '%')
              ->orWhere('email', 'like', '%' . $search . '%')
              ->orWhere('trading_name', 'like', '%' . $search . '%');
        });
    }
}
