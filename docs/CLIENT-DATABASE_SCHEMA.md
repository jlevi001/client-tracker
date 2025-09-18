# Client Management Database Schema - Time Tracking Focus

## Overview
This document defines the database schema for the Lingo Client Tracker's time tracking and contract hours management system. The primary purpose is to track employee time against client contracts to monitor usage against monthly allocations and identify billable overages.

## Key Business Rules Summary
✅ **No Hour Rollover** - Unused hours expire each month
✅ **Account Numbers** - First 8 letters of company name (e.g., "Lingo Technologies" → "LINGOTEC")
✅ **Contract Numbers** - Format: ACCOUNT-CON-SERVICE-YEAR (e.g., "LINGOTEC-CON-WEB-2024")
✅ **Anniversary Reset** - Hours reset on contract start date each month (May 24 start = resets every 24th)
✅ **Multiple Contracts** - Clients can have IT, WEB, MARKETING contracts simultaneously
✅ **Overage Rates** - Each contract has its own overage rate for exceeded hours
✅ **Work Location** - Track if work was performed remotely or onsite
✅ **Email Reports** - Monthly overage reports sent on contract anniversary
✅ **Flexible Entry** - Any employee can log time for any client/contract

## System Purpose
Track time spent by any employee on any client contract to:
- Monitor hours used vs. contracted monthly allocation
- Identify when clients exceed their contracted hours
- Generate billing for overage hours
- Provide reporting on time usage by client, contract, and date range

## Table Structure

### 1. clients
Main table for storing client company information.

```sql
clients
├── id (bigint, primary key, auto-increment)
├── account_number (string[10], unique, indexed) // First 8 chars of company name (may append number for uniqueness)
├── company_name (string, required, indexed)
├── trading_name (string, nullable) // DBA name if different
├── website (string, nullable)
├── email (string, nullable) // General company email
├── phone (string, nullable)
├── address_line_1 (string, nullable)
├── address_line_2 (string, nullable)
├── city (string, nullable)
├── state (string, nullable)
├── zip_code (string, nullable)
├── country (string, default: 'USA')
├── status (enum: 'active', 'inactive', 'suspended', default: 'active')
├── billing_address_same (boolean, default: true)
├── billing_address_line_1 (string, nullable)
├── billing_address_line_2 (string, nullable)
├── billing_city (string, nullable)
├── billing_state (string, nullable)
├── billing_zip_code (string, nullable)
├── billing_country (string, nullable)
├── payment_terms (enum: 'net15', 'net30', 'net45', 'net60', 'due_on_receipt', default: 'net30')
├── tax_id (string, nullable) // EIN or Tax ID
├── notes (text, nullable) // Internal notes about the client
├── created_by_id (foreign key → users.id, indexed)
├── updated_by_id (foreign key → users.id, nullable)
├── created_at (timestamp)
├── updated_at (timestamp)
└── deleted_at (timestamp, nullable) // Soft deletes

Indexes:
- account_number (unique)
- company_name
- status
- created_by_id
```

### 2. client_contacts
Stores contact information for client companies.

```sql
client_contacts
├── id (bigint, primary key, auto-increment)
├── client_id (foreign key → clients.id, indexed, cascade on delete)
├── first_name (string, required)
├── last_name (string, required)
├── title (string, nullable) // Job title
├── email (string, nullable, indexed)
├── phone (string, nullable)
├── mobile (string, nullable)
├── is_primary (boolean, default: false) // Primary contact
├── is_billing_contact (boolean, default: false)
├── receives_invoices (boolean, default: false)
├── notes (text, nullable)
├── status (enum: 'active', 'inactive', default: 'active')
├── created_by_id (foreign key → users.id)
├── updated_by_id (foreign key → users.id, nullable)
├── created_at (timestamp)
├── updated_at (timestamp)
└── deleted_at (timestamp, nullable)

Indexes:
- client_id
- email
- is_primary
Compound Index:
- (client_id, is_primary) // For quick primary contact lookup
```

### 3. contracts
Service contracts with monthly hour allocations.

```sql
contracts
├── id (bigint, primary key, auto-increment)
├── client_id (foreign key → clients.id, indexed, cascade on delete)
├── contract_number (string, unique, indexed) // Format: ACCOUNT-CON-SERVICE-YEAR
├── name (string, required) // Contract name/description
├── service_category (enum: 'IT', 'WEB', 'MARKETING', 'OTHER', required)
├── type (enum: 'monthly_retainer', 'project_based', 'pay_as_you_go', required)
├── status (enum: 'active', 'inactive', 'expired', default: 'active')
├── start_date (date, required) // Determines monthly reset day
├── end_date (date, nullable) // Null for ongoing contracts
├── auto_renew (boolean, default: false)
├── monthly_hours (decimal 6,2, nullable) // Hours included per month
├── overage_rate (decimal 8,2, required) // Rate for hours over allocation
├── standard_rate (decimal 8,2, nullable) // Standard hourly rate (for pay-as-you-go)
├── billing_cycle (enum: 'monthly', 'quarterly', 'annual', default: 'monthly')
├── notification_email (string, nullable) // Email for monthly overage reports
├── send_monthly_report (boolean, default: true) // Send reports on anniversary
├── description (text, nullable)
├── notes (text, nullable) // Internal notes
├── created_by_id (foreign key → users.id)
├── updated_by_id (foreign key → users.id, nullable)
├── created_at (timestamp)
├── updated_at (timestamp)
└── deleted_at (timestamp, nullable)

Indexes:
- client_id
- contract_number (unique)
- service_category
- status
- start_date
- end_date
Compound Index:
- (client_id, status) // For filtering client's active contracts
- (client_id, service_category, status) // For filtering by service type
```

### 4. service_types
Admin-manageable categories of work that can be performed.

```sql
service_types
├── id (bigint, primary key, auto-increment)
├── name (string, required, unique) // e.g., "Consultation", "Computer Repair", etc.
├── description (text, nullable)
├── is_billable (boolean, default: true)
├── is_active (boolean, default: true)
├── display_order (integer, default: 0) // For sorting in dropdown
├── created_by_id (foreign key → users.id, nullable)
├── updated_by_id (foreign key → users.id, nullable)
├── created_at (timestamp)
└── updated_at (timestamp)

Indexes:
- name (unique)
- is_active
- display_order

Note: Admin panel allows CRUD operations on service types
```

### 5. work_logs
Time tracking entries for work performed on client contracts.

```sql
work_logs
├── id (bigint, primary key, auto-increment)
├── client_id (foreign key → clients.id, indexed)
├── contract_id (foreign key → contracts.id, indexed)
├── service_type_id (foreign key → service_types.id, indexed)
├── user_id (foreign key → users.id, indexed) // Employee who performed work
├── work_date (date, required, indexed)
├── start_time (datetime, nullable) // For timer functionality
├── end_time (datetime, nullable) // For timer functionality
├── duration_minutes (integer, required) // Total minutes worked
├── duration_hours (decimal 4,2, required) // Calculated: duration_minutes / 60
├── work_location (enum: 'remote', 'onsite', required, default: 'remote')
├── description (text, required) // What was done
├── is_billable (boolean, default: true)
├── is_overage (boolean, default: false) // Exceeded monthly allocation
├── rate_applied (decimal 8,2, nullable) // Rate at time of entry
├── created_at (timestamp)
├── updated_at (timestamp)
└── deleted_at (timestamp, nullable)

Indexes:
- client_id
- contract_id
- service_type_id
- user_id
- work_date
- work_location
- is_billable
- is_overage
Compound Indexes:
- (contract_id, work_date) // For contract period calculations
- (user_id, work_date) // For employee daily logs
- (client_id, work_date) // For client reports
```

### 6. contract_periods
Tracks monthly allocations and usage for contracts based on contract anniversary date.

```sql
contract_periods
├── id (bigint, primary key, auto-increment)
├── contract_id (foreign key → contracts.id, indexed)
├── client_id (foreign key → clients.id, indexed) // Denormalized
├── period_start (date, required, indexed) // Contract anniversary date
├── period_end (date, required, indexed) // Day before next anniversary
├── allocated_hours (decimal 6,2, required) // Hours included this period
├── used_hours (decimal 6,2, default: 0.00) // Sum of work_logs
├── overage_hours (decimal 6,2, default: 0.00) // MAX(0, used - allocated)
├── standard_rate (decimal 8,2, nullable) // Rate for included hours
├── overage_rate (decimal 8,2, required) // Rate for overage hours
├── total_overage_amount (decimal 10,2, default: 0.00) // overage_hours * overage_rate
├── report_sent (boolean, default: false) // Monthly report emailed
├── report_sent_date (datetime, nullable)
├── is_billed (boolean, default: false) // Has overage been billed
├── invoice_id (bigint, nullable) // Future reference
├── notes (text, nullable)
├── created_at (timestamp)
├── updated_at (timestamp)

Indexes:
- contract_id
- client_id
- period_start
- period_end
- is_billed
Compound Indexes:
- (contract_id, period_start) // Unique constraint
- (contract_id, period_end) // For current period lookup
```

## Relationships

```
clients
    ├── has many → client_contacts
    ├── has many → contracts
    │               ├── has many → contract_periods
    │               └── has many → work_logs
    └── has many → work_logs

service_types
    └── has many → work_logs

users (employees)
    └── has many → work_logs (time entries)
```

## Business Rules

### Account Number Generation
- Uses first 8 characters of company name (excluding spaces)
- Converts to uppercase
- Example: "Lingo Technologies" → `LINGOTEC`
- Example: "ABC Company Inc" → `ABCCOMPA`
- Example: "Joe's IT Services" → `JOESITSE`
- Generated automatically on client creation
- Must be unique (append number if duplicate: LINGOTEC2)

### Contract Number Generation
- Format: `[ACCOUNT]-CON-[SERVICE]-[YEAR]`
- ACCOUNT = Company account number (8 chars)
- SERVICE = Service type (WEB, IT, MARKETING, OTHER)
- YEAR = Contract start year
- Example: "LINGOTEC-CON-WEB-2024"
- Example: "ABCCOMPA-CON-IT-2025"
- Multiple contracts per client differentiated by service type

### Monthly Hours Tracking
1. **Period Creation**: Based on contract start date anniversary
   - Contract started May 24, 2025
   - First period: May 24 - June 23, 2025
   - Second period: June 24 - July 23, 2025
   - Continues monthly on the 24th

2. **End of Month Handling**: 
   - If start date is 29, 30, or 31, use last day of month for shorter months
   - Example: Contract started January 31
     - February period: Feb 28/29 - Mar 30
     - March period: Mar 31 - Apr 30

3. **Hours Reset**: No rollover - unused hours expire each period

4. **Overage Detection**: 
   - Real-time check when work_log created
   - If period used_hours + new entry > allocated_hours
   - Mark excess as overage with higher rate

5. **Monthly Reporting**:
   - On each contract anniversary date
   - Email report to notification_email if configured
   - Include: hours used, overage hours, work details

### Time Entry Workflow
1. Employee selects:
   - Client (can have multiple active contracts)
   - Contract (filtered by client, shows service category)
   - Service Type (from managed list)
   - Work Location (Remote/Onsite)
2. Starts timer (captures start_time)
3. Stops timer (captures end_time, calculates duration)
4. Enters work description
5. System checks current period allocation
6. If over allocation, marks as overage with contract's overage_rate

### Billing Cycle Management
- Contracts reset on their start date anniversary each month
- System handles month-end edge cases automatically
- Each client can have multiple active contracts (IT, WEB, MARKETING)
- Each contract tracks its own hours independently
- Overage reports sent on each contract's anniversary date
- Different overage rates per contract

### Multiple Contracts Per Client
- Clients can have simultaneous contracts for different services
- Example: LINGOTEC-CON-IT-2024 and LINGOTEC-CON-WEB-2024
- Each contract has independent:
  - Monthly hour allocations
  - Anniversary dates
  - Overage rates
  - Notification settings
- Time entries must specify which contract is being worked on

## Indexes Strategy

### Primary Indexes:
- All foreign keys indexed for JOIN performance
- Date fields indexed for reporting queries
- Status fields indexed for filtering

### Compound Indexes:
- Optimize for common queries (contract + date ranges)
- Support time tracking dashboard views
- Enable fast overage calculations

## Data Integrity Rules

### Cascading:
- Client deletion → soft delete contracts, work_logs
- Contract deletion → soft delete work_logs, contract_periods
- Service type deletion → prevented if work_logs exist

### Constraints:
- work_logs.duration_minutes must be positive
- contract_periods.used_hours cannot be negative
- contract_periods.period_start must be before period_end
- Only one active contract_period per contract at a time

### Constraints:
- work_logs.duration_minutes must be positive
- contract_periods.used_hours cannot be negative
- contract_periods.period_start must be before period_end
- Only one active contract_period per contract at a time
- Contract anniversary dates must be handled for month-end edge cases

### Calculations:
- work_logs.duration_hours = duration_minutes / 60
- contract_periods.overage_hours = MAX(0, used_hours - allocated_hours)
- contract_periods.total_overage_amount = overage_hours * overage_rate
- Period dates based on contract start date (anniversary tracking)

## Migration Order
1. Create service_types table (independent)
2. Create clients table (depends on users table - already exists)
3. Create client_contacts table (depends on clients)
4. Create contracts table (depends on clients)
5. Create work_logs table (depends on contracts, service_types, users)
6. Create contract_periods table (depends on contracts)
7. Seed service_types with default categories

## Default Service Types (Seed Data)
Admin-manageable service categories:
- Consultation
- Computer Repair
- Maintenance
- Network Management
- Web Development
- SEO
- ADs (Advertising/Marketing)
- Social Media
- Other

## Reporting Capabilities

### Key Reports Enabled:
1. **Monthly Usage Report**: Hours used vs. allocated per contract
2. **Overage Report**: Contracts exceeding allocations with amounts
3. **Employee Time Report**: Hours logged by employee by date range
4. **Client Activity Report**: All work performed for client across all contracts
5. **Contract Status Report**: Active contracts with remaining hours
6. **Service Category Report**: Hours by IT/WEB/MARKETING service
7. **Location Report**: Breakdown of remote vs. onsite work
8. **Anniversary Report**: Upcoming contract reset dates
9. **Multi-Contract Analysis**: Clients with multiple active contracts

### Date Range Presets:
- Current Month
- Last Month
- This Week
- Last Week
- This Year
- Last Year
- Last 30 Days
- Last 90 Days
- Last 12 Months
- Custom Range

## Future Enhancements

### Potential Features:
- **Timer Sessions**: Save incomplete timer sessions
- **Bulk Time Entry**: Enter multiple logs at once
- **Time Entry Templates**: Common recurring tasks
- **Approval Workflow**: Manager approval for time entries
- **Client Portal**: Clients view their own usage
- **Automated Alerts**: Notify when approaching limits
- **Invoice Generation**: Auto-create invoices for overages
- **API Integration**: Sync with external ticketing system

### Potential Tables:
- **invoices**: Billing records
- **invoice_items**: Line items with work_logs reference
- **timer_sessions**: Incomplete/paused timers
- **alerts**: Notifications for limit approaching
- **audit_logs**: Track all data changes

## Performance Considerations

### Query Optimization:
- Denormalized client_id in multiple tables
- Pre-calculated duration_hours in work_logs
- Materialized overage_hours in contract_periods
- Indexed all date fields for range queries

### Data Volume Planning:
- Expecting ~100-500 work_logs per day
- Monthly aggregation in contract_periods reduces calculations
- Soft deletes maintain audit trail without impacting performance

## Security & Compliance

### Access Control:
- Employees can only create/edit their own work_logs
- Managers can view all work_logs
- Admin can modify contract allocations
- Audit trail via created_at/updated_at

### Data Protection:
- Soft deletes for recovery
- Immutable time entries after billing
- Change tracking for compliance

---

## Implementation Notes

### Laravel Specific:
1. Use Laravel's scheduled jobs for:
   - Period creation on contract anniversaries
   - Sending monthly overage reports
2. Implement model observers for:
   - Automatic account number generation (first 8 chars of company name)
   - Contract number generation (ACCOUNT-CON-SERVICE-YEAR)
   - Duration calculations
3. Use database transactions for time entry creation
4. Cache contract period lookups for performance

### Account Number Generation Logic:
```php
// In Client model observer
$companyName = str_replace(' ', '', $client->company_name);
$accountNumber = strtoupper(substr($companyName, 0, 8));
// Check uniqueness and append number if needed
```

### Contract Number Generation Logic:
```php
// In Contract model observer
$accountNumber = $contract->client->account_number;
$service = $contract->service_category; // IT, WEB, MARKETING
$year = Carbon::parse($contract->start_date)->year;
$contractNumber = "{$accountNumber}-CON-{$service}-{$year}";
```

### UI Considerations:
1. Timer component with start/stop/pause
2. Quick-select for recent clients/contracts
3. Contract selector shows service category (IT/WEB/MARKETING)
4. Work location toggle (Remote/Onsite)
5. Real-time hours remaining display
6. Visual indicators for overage status
7. Calendar view for time entries
8. Filter by service category when multiple contracts exist
9. Anniversary date display for each contract
10. Warning when approaching monthly limit (e.g., 80% used)

### Business Logic:
1. Prevent time entries for inactive contracts
2. Warn user when approaching limit (e.g., 80% used)
3. Auto-save timer state to prevent loss
4. Support manual time entry (not just timer)
5. Bulk edit capabilities for corrections
6. Anniversary email notifications:
   - Triggered on contract start date anniversary each month
   - Include: total hours used, overage hours, detailed work log
   - Send to contract.notification_email if configured
   - Mark contract_period.report_sent = true when sent

This schema is optimized for time tracking and contract hours management while maintaining flexibility for future enhancements.
