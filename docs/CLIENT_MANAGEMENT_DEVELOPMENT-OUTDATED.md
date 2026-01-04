# Client Management Development Plan

## 📋 Project Overview
The Client Management system is a comprehensive time tracking module for the Lingo Client Tracker that tracks employee time against client contracts, monitors monthly hour allocations, identifies billable overages, and provides detailed reporting capabilities.

**Created**: January 2025  
**Status**: 🚧 In Development  
**Priority**: High  
**Focus**: Time tracking and contract hours management

---

## 🎯 Development Principles

### UI/UX Standards (MANDATORY)
- [ ] **daisyUI Components ONLY** - No raw Tailwind for components
- [ ] **Dark Theme** - Use `bg-base-100/200/300` exclusively
- [ ] **Mobile Responsive** - Test at 375px, 768px, 1024px
- [ ] **Consistent with User Management** - Match existing patterns
- [ ] **Loading States** - All async operations must show feedback
- [ ] **Error Handling** - User-friendly error messages
- [ ] **Form Validation** - Real-time validation with Livewire

### Code Standards
- [ ] **Reuse Existing Components** - Check `/resources/views/components/` first
- [ ] **Follow Naming Conventions** - Match existing file/class patterns
- [ ] **Complete Files Only** - No partial implementations
- [ ] **Test Each Feature** - Full debugging before moving on
- [ ] **Document Complex Logic** - Clear comments where needed

---

## 📊 Database Schema

### Key Business Rules
✅ **No Hour Rollover** - Unused hours expire each month  
✅ **Account Numbers** - First 8 letters of company name (e.g., "Lingo Technologies" → "LINGOTEC")  
✅ **Contract Numbers** - Format: ACCOUNT-CON-SERVICE-YEAR (e.g., "LINGOTEC-CON-WEB-2024")  
✅ **Anniversary Reset** - Hours reset on contract start date each month  
✅ **Multiple Contracts** - Clients can have IT, WEB, MARKETING contracts simultaneously  
✅ **Overage Rates** - Each contract has its own overage rate  
✅ **Work Location** - Track if work was performed remotely or onsite  
✅ **Email Reports** - Monthly overage reports sent on contract anniversary  

### Tables Required

#### 1. `clients` Table
```sql
- id (bigint, primary key)
- account_number (string[10], unique, indexed) // First 8 chars of company name
- company_name (string, required, indexed)
- trading_name (string, nullable) // DBA name
- website (string, nullable)
- email (string, nullable)
- phone (string, nullable)
- address_line_1 (string, nullable)
- address_line_2 (string, nullable)
- city (string, nullable)
- state (string, nullable)
- zip_code (string, nullable)
- country (string, default: 'USA')
- status (enum: 'active', 'inactive', 'suspended')
- billing_address_same (boolean, default: true)
- billing_address_line_1 (string, nullable)
- billing_address_line_2 (string, nullable)
- billing_city (string, nullable)
- billing_state (string, nullable)
- billing_zip_code (string, nullable)
- billing_country (string, nullable)
- payment_terms (enum: 'net15', 'net30', 'net45', 'net60', 'due_on_receipt')
- tax_id (string, nullable)
- notes (text, nullable)
- created_by_id (foreign key -> users.id)
- updated_by_id (foreign key -> users.id, nullable)
- created_at (timestamp)
- updated_at (timestamp)
- deleted_at (timestamp, soft deletes)
```

#### 2. `client_contacts` Table
```sql
- id (bigint, primary key)
- client_id (foreign key -> clients.id, cascade delete)
- first_name (string, required)
- last_name (string, required)
- title (string, nullable)
- email (string, nullable, indexed)
- phone (string, nullable)
- mobile (string, nullable)
- is_primary (boolean, default: false)
- is_billing_contact (boolean, default: false)
- receives_invoices (boolean, default: false)
- notes (text, nullable)
- status (enum: 'active', 'inactive')
- created_by_id (foreign key -> users.id)
- updated_by_id (foreign key -> users.id, nullable)
- created_at (timestamp)
- updated_at (timestamp)
- deleted_at (timestamp, soft deletes)
```

#### 3. `contracts` Table
```sql
- id (bigint, primary key)
- client_id (foreign key -> clients.id, cascade delete)
- contract_number (string, unique, indexed) // Format: ACCOUNT-CON-SERVICE-YEAR
- name (string, required) // Contract description
- service_category (enum: 'IT', 'WEB', 'MARKETING', 'OTHER', required)
- type (enum: 'monthly_retainer', 'project_based', 'pay_as_you_go')
- status (enum: 'active', 'inactive', 'expired')
- start_date (date, required) // Determines monthly reset day
- end_date (date, nullable)
- auto_renew (boolean, default: false)
- monthly_hours (decimal 6,2, nullable)
- overage_rate (decimal 8,2, required) // Rate for exceeded hours
- standard_rate (decimal 8,2, nullable)
- billing_cycle (enum: 'monthly', 'quarterly', 'annual')
- notification_email (string, nullable) // For monthly reports
- send_monthly_report (boolean, default: true)
- description (text, nullable)
- notes (text, nullable)
- created_by_id (foreign key -> users.id)
- updated_by_id (foreign key -> users.id, nullable)
- created_at (timestamp)
- updated_at (timestamp)
- deleted_at (timestamp, soft deletes)
```

#### 4. `service_types` Table
```sql
- id (bigint, primary key)
- name (string, required, unique) // Admin-manageable list
- description (text, nullable)
- is_billable (boolean, default: true)
- is_active (boolean, default: true)
- display_order (integer, default: 0)
- created_by_id (foreign key -> users.id, nullable)
- updated_by_id (foreign key -> users.id, nullable)
- created_at (timestamp)
- updated_at (timestamp)

Default Values:
- Consultation
- Computer Repair
- Maintenance
- Network Management
- Web Development
- SEO
- ADs
- Social Media
```

#### 5. `work_logs` Table
```sql
- id (bigint, primary key)
- client_id (foreign key -> clients.id, indexed)
- contract_id (foreign key -> contracts.id, indexed)
- service_type_id (foreign key -> service_types.id, indexed)
- user_id (foreign key -> users.id, indexed) // Employee who performed work
- work_date (date, required, indexed)
- start_time (datetime, nullable) // For timer
- end_time (datetime, nullable) // For timer
- duration_minutes (integer, required)
- duration_hours (decimal 4,2, required) // Calculated
- work_location (enum: 'remote', 'onsite', required, default: 'remote')
- description (text, required)
- is_billable (boolean, default: true)
- is_overage (boolean, default: false) // Exceeded monthly allocation
- rate_applied (decimal 8,2, nullable)
- created_at (timestamp)
- updated_at (timestamp)
- deleted_at (timestamp, soft deletes)
```

#### 6. `contract_periods` Table
```sql
- id (bigint, primary key)
- contract_id (foreign key -> contracts.id, indexed)
- client_id (foreign key -> clients.id, indexed) // Denormalized
- period_start (date, required, indexed) // Anniversary date
- period_end (date, required, indexed) // Day before next anniversary
- allocated_hours (decimal 6,2, required)
- used_hours (decimal 6,2, default: 0.00)
- overage_hours (decimal 6,2, default: 0.00) // MAX(0, used - allocated)
- standard_rate (decimal 8,2, nullable)
- overage_rate (decimal 8,2, required)
- total_overage_amount (decimal 10,2, default: 0.00)
- report_sent (boolean, default: false)
- report_sent_date (datetime, nullable)
- is_billed (boolean, default: false)
- invoice_id (bigint, nullable) // Future reference
- notes (text, nullable)
- created_at (timestamp)
- updated_at (timestamp)
```

---

## 🚀 Development Phases

### Phase 1: Database Foundation ⏳
- [ ] Create migration for `service_types` table
- [ ] Create migration for `clients` table
- [ ] Create migration for `client_contacts` table
- [ ] Create migration for `contracts` table
- [ ] Create migration for `work_logs` table
- [ ] Create migration for `contract_periods` table
- [ ] Run migrations and verify structure
- [ ] Create Client model with relationships
- [ ] Create ClientContact model
- [ ] Create Contract model with relationships
- [ ] Create ServiceType model
- [ ] Create WorkLog model
- [ ] Create ContractPeriod model
- [ ] Set up model factories for testing
- [ ] Create database seeders with sample data
- [ ] Seed service_types with default values

### Phase 2: Navigation & Basic Structure ⏳
- [ ] Add "Clients" link to navigation menu
- [ ] Create `/clients` route
- [ ] Create ClientsController
- [ ] Create basic clients index page
- [ ] Implement breadcrumb navigation
- [ ] Set up proper middleware/permissions

### Phase 3: Client CRUD Operations ⏳
- [ ] Create Livewire component `ClientManagement`
- [ ] Implement client listing table
  - [ ] Search functionality
  - [ ] Pagination
  - [ ] Sort by columns
  - [ ] Account # display (first 8 chars)
- [ ] Create client form modal
  - [ ] Company name field
  - [ ] Auto-generate account # from company name
  - [ ] Contact information section
  - [ ] Billing address section (toggle same as main)
  - [ ] Payment terms selection
  - [ ] Notes textarea
- [ ] Implement create client functionality
  - [ ] Form validation
  - [ ] Account number generation logic
  - [ ] Success/error messages
  - [ ] Real-time validation
- [ ] Implement edit client functionality
  - [ ] Pre-populate form
  - [ ] Update validation
  - [ ] Prevent account number changes
- [ ] Implement delete client functionality
  - [ ] Confirmation modal
  - [ ] Soft delete implementation
  - [ ] Check for related contracts
- [ ] Create client detail view page
  - [ ] Client information card
  - [ ] Tabs for contracts/work logs
  - [ ] Quick stats display

### Phase 4: Contract Management ⏳
- [ ] Create Livewire component `ContractManagement`
- [ ] Add contracts tab to client detail page
- [ ] Implement contract listing table within client
  - [ ] Status indicators (active/inactive/expired)
  - [ ] Service category display (IT/WEB/MARKETING)
  - [ ] Monthly hours allocation display
  - [ ] Anniversary date display
  - [ ] Hours remaining in current period
- [ ] Create contract form modal
  - [ ] Contract name field
  - [ ] Service category selector
  - [ ] Auto-generate contract number (ACCOUNT-CON-SERVICE-YEAR)
  - [ ] Start date picker (determines anniversary)
  - [ ] End date picker (optional)
  - [ ] Monthly hours input
  - [ ] Overage rate input (required)
  - [ ] Notification email field
  - [ ] Monthly report toggle
- [ ] Implement multiple contracts per client
  - [ ] Allow different service categories
  - [ ] Independent hour tracking
  - [ ] Separate anniversary dates
- [ ] Contract status management
  - [ ] Auto-expire based on end date
  - [ ] Manual status toggle
  - [ ] Status change logging
- [ ] Anniversary-based period creation
  - [ ] Calculate period based on start date
  - [ ] Handle month-end edge cases
  - [ ] Auto-create periods via scheduled job

### Phase 5: Service Type Management ⏳
- [ ] Create Livewire component `ServiceTypeManagement`
- [ ] Add admin panel for service types
- [ ] Implement CRUD for service types
  - [ ] Add new service types
  - [ ] Edit existing types
  - [ ] Toggle active/inactive
  - [ ] Set display order
- [ ] Prevent deletion if work logs exist
- [ ] Add to admin navigation menu

### Phase 6: Work Log System ⏳
- [ ] Create Livewire component `WorkLogEntry`
- [ ] Create work log entry form
  - [ ] Client selector (with active contracts)
  - [ ] Contract selector (shows service category)
  - [ ] Service type dropdown
  - [ ] Work location toggle (Remote/Onsite)
  - [ ] Timer interface (start/stop)
  - [ ] Manual time entry option
  - [ ] Date picker (default today)
  - [ ] Description field
- [ ] Implement timer functionality
  - [ ] Start/stop/pause buttons
  - [ ] Auto-save timer state
  - [ ] Calculate duration
  - [ ] Prevent data loss
- [ ] Employee work log view
  - [ ] List own work logs
  - [ ] Filter by date range
  - [ ] Filter by client/contract
  - [ ] Edit pending entries only
- [ ] Implement overage detection
  - [ ] Check current period allocation
  - [ ] Mark as overage if exceeded
  - [ ] Apply correct rate
- [ ] Add work log to contract detail view
  - [ ] Chronological list
  - [ ] Filter by employee
  - [ ] Filter by date range
  - [ ] Show remote/onsite indicator

### Phase 7: Contract Period Management ⏳
- [ ] Create scheduled job for period creation
  - [ ] Run daily to check anniversaries
  - [ ] Create new periods on anniversary date
  - [ ] Handle month-end edge cases (31st → 28/29th)
- [ ] Implement period calculations
  - [ ] Sum work logs for period
  - [ ] Calculate overage hours
  - [ ] Apply overage rates
- [ ] Create period overview interface
  - [ ] Current period status
  - [ ] Hours used vs allocated
  - [ ] Overage amount if applicable
  - [ ] Period history view
- [ ] Email notification system
  - [ ] Monthly report generation
  - [ ] Send on anniversary date
  - [ ] Include work details
  - [ ] Include overage summary
  - [ ] Mark as sent

### Phase 8: Reporting & Analytics ⏳
- [ ] Hours tracking dashboard
  - [ ] Used vs allocated hours per contract
  - [ ] Visual progress bars
  - [ ] Alerts for overages (80% warning)
  - [ ] Multiple contract display per client
- [ ] Client summary cards
  - [ ] Active contracts count by service
  - [ ] Total hours this month
  - [ ] Current period status
- [ ] Date range reporting
  - [ ] Preset options (Current Month, Last Month, etc.)
  - [ ] Custom date ranges
  - [ ] Work by location (remote/onsite)
  - [ ] Service type breakdown
- [ ] Export functionality
  - [ ] Work logs to CSV/Excel
  - [ ] Client list export
  - [ ] Contract summary export
  - [ ] Monthly overage report

### Phase 9: Polish & Optimization ⏳
- [ ] Add loading states to all operations
- [ ] Implement proper error handling
- [ ] Add success notifications
- [ ] Mobile responsiveness testing
- [ ] Performance optimization
  - [ ] Eager loading relationships
  - [ ] Query optimization
  - [ ] Caching where appropriate
- [ ] Accessibility review
  - [ ] ARIA labels
  - [ ] Keyboard navigation
  - [ ] Screen reader testing

### Phase 10: Testing & Documentation ⏳
- [ ] Write feature tests
  - [ ] Client CRUD tests
  - [ ] Contract management tests
  - [ ] Work log entry tests
  - [ ] Timer functionality tests
  - [ ] Overage calculation tests
  - [ ] Period creation tests
- [ ] Write unit tests for models
- [ ] Create user documentation
- [ ] Update README.md
- [ ] Add inline code documentation

---

## 🎨 UI Component Patterns

### Standard List View Pattern
```blade
<div class="card bg-base-200 shadow-xl">
    <div class="card-body">
        <!-- Header with Add Button -->
        <div class="flex justify-between items-center mb-4">
            <h2 class="card-title">Clients</h2>
            <button class="btn btn-primary btn-sm">
                Add Client
            </button>
        </div>
        
        <!-- Search Bar -->
        <div class="form-control mb-4">
            <input type="text" 
                   placeholder="Search clients..." 
                   class="input input-bordered w-full">
        </div>
        
        <!-- Table -->
        <div class="overflow-x-auto">
            <table class="table table-zebra">
                <!-- table content -->
            </table>
        </div>
        
        <!-- Pagination -->
        <div class="join justify-center mt-4">
            <!-- pagination buttons -->
        </div>
    </div>
</div>
```

### Timer Interface Pattern
```blade
<div class="card bg-base-200">
    <div class="card-body">
        <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
            <!-- Client/Contract Selection -->
            <x-form-control label="Client" for="client">
                <select class="select select-bordered w-full">
                    @foreach($activeClients as $client)
                        <option value="{{ $client->id }}">
                            {{ $client->company_name }} ({{ $client->account_number }})
                        </option>
                    @endforeach
                </select>
            </x-form-control>
            
            <!-- Timer Display -->
            <div class="text-center">
                <div class="text-4xl font-mono">
                    {{ $timer }}
                </div>
                <div class="btn-group mt-2">
                    <button class="btn btn-success">Start</button>
                    <button class="btn btn-warning">Pause</button>
                    <button class="btn btn-error">Stop</button>
                </div>
            </div>
            
            <!-- Work Location Toggle -->
            <div class="form-control">
                <label class="label">Work Location</label>
                <div class="btn-group">
                    <button class="btn btn-active">Remote</button>
                    <button class="btn">Onsite</button>
                </div>
            </div>
        </div>
    </div>
</div>
```

---

## 📝 Account Number Generation Logic

Generate account numbers from company names:
1. Remove all spaces and special characters
2. Take first 8 characters
3. Convert to uppercase
4. If duplicate exists, append number (2, 3, etc.)

**Examples:**
- "Lingo Technologies LLC" → "LINGOTEC"
- "ABC Company Inc" → "ABCCOMPA"
- "Joe's IT Services" → "JOESITSE"
- "IBM Corporation" → "IBMCORPO"

```php
// In Client model observer
public function creating(Client $client)
{
    $companyName = preg_replace('/[^A-Za-z0-9]/', '', $client->company_name);
    $accountNumber = strtoupper(substr($companyName, 0, 8));
    
    // Check for duplicates and append number if needed
    $suffix = 1;
    $testNumber = $accountNumber;
    while (Client::where('account_number', $testNumber)->exists()) {
        $suffix++;
        $testNumber = $accountNumber . $suffix;
    }
    
    $client->account_number = $testNumber;
}
```

## 📝 Contract Number Generation Logic

Generate contract numbers using account and service:

```php
// In Contract model observer
public function creating(Contract $contract)
{
    $accountNumber = $contract->client->account_number;
    $service = $contract->service_category; // IT, WEB, MARKETING, OTHER
    $year = Carbon::parse($contract->start_date)->year;
    
    $contract->contract_number = "{$accountNumber}-CON-{$service}-{$year}";
}
```

---

## 🔒 Permission Requirements

### Role-Based Access
- **Admin**: Full access to all features
- **Manager**: View all, manage work logs, approve time entries
- **Employee**: Create own work logs, use timer, view assigned contracts

### Specific Permissions
```php
// Permissions to create
'view-clients'
'create-clients'
'edit-clients'
'delete-clients'
'manage-contracts'
'manage-service-types'
'create-work-logs'
'edit-own-work-logs'
'view-all-work-logs'
'manage-contract-periods'
'view-reports'
'export-data'
'send-reports'
```

---

## 🚦 Status Workflows

### Contract Status
```
active → expired (automatic based on end_date)
active → inactive (manual deactivation)
inactive → active (manual reactivation)
```

### Work Log Workflow
```
Any employee → Creates work log entry
System → Checks if over allocation
System → Marks as overage if exceeded
System → Applies appropriate rate
```

### Contract Period Workflow
```
Daily Job → Check for anniversaries
Create period → Set start/end dates
Track usage → Sum work logs
Calculate overage → Apply rates
Send report → Email on anniversary
```

---

## 📅 Anniversary Date Handling

### Monthly Reset Logic
- Contract starts May 24, 2025
- First period: May 24 - June 23, 2025
- Second period: June 24 - July 23, 2025
- Continues monthly on the 24th

### Month-End Edge Cases
- If start date is 29, 30, or 31
- Use last valid day of shorter months
- Example: January 31 contract
  - February: Resets on 28th (or 29th in leap year)
  - March: Resets on 31st
  - April: Resets on 30th

```php
// Calculate next anniversary date
public function getNextAnniversaryDate($contractStartDate, $currentDate)
{
    $startDay = $contractStartDate->day;
    $nextMonth = $currentDate->copy()->addMonth();
    
    // Handle month-end edge cases
    $lastDayOfNextMonth = $nextMonth->copy()->endOfMonth()->day;
    $anniversaryDay = min($startDay, $lastDayOfNextMonth);
    
    return $nextMonth->day($anniversaryDay);
}
```

---

## 📁 File Storage Structure
```
storage/
└── app/
    └── clients/
        └── contracts/
            └── {client-account-number}/
                ├── contract_001.pdf
                ├── contract_002.pdf
                └── ...
```

---

## ✅ Testing Checklist

### Functional Testing
- [ ] Client CRUD operations work correctly
- [ ] Account numbers generate uniquely
- [ ] Contract numbers follow format
- [ ] Timer calculates time correctly
- [ ] Overage detection works
- [ ] Anniversary dates calculate properly
- [ ] Month-end edge cases handled
- [ ] Email notifications send
- [ ] Multiple contracts track independently

### UI/UX Testing
- [ ] All forms validate in real-time
- [ ] Loading states appear during operations
- [ ] Error messages are user-friendly
- [ ] Mobile layout works at 375px
- [ ] Tablet layout works at 768px
- [ ] Desktop layout works at 1024px+
- [ ] Dark theme is consistent throughout
- [ ] Timer interface is intuitive
- [ ] Work location toggle works

### Edge Cases
- [ ] Duplicate account numbers handled
- [ ] Multiple active contracts per client
- [ ] Overlapping work logs prevented
- [ ] Anniversary on February 29th
- [ ] Contract started on 31st in short months
- [ ] Timer session recovery after browser crash
- [ ] Timezone handling for distributed teams

---

## 🎯 Success Criteria

The Client Management module will be considered complete when:

1. ✅ All 6 database tables are created and properly related
2. ✅ Account number generation works (8 characters)
3. ✅ Contract number generation follows format
4. ✅ Timer functionality tracks time accurately
5. ✅ Anniversary-based hour reset works
6. ✅ Overage detection and calculation works
7. ✅ Multiple contracts per client supported
8. ✅ Work location tracking implemented
9. ✅ Email notifications send on anniversaries
10. ✅ Mobile responsive design verified
11. ✅ Dark theme consistent throughout
12. ✅ Service types are admin-manageable
13. ✅ All permissions properly enforced
14. ✅ Feature and unit tests pass

---

## 📚 Reference Documents

- **Database Schema**: `/docs/DATABASE_SCHEMA.md`
- **AI Instructions**: `/docs/ai-instructions.md`
- **daisyUI Conversion Guide**: `/docs/DAISYUI_CONVERSION_GUIDE.md`
- **Component Reference**: `/resources/views/components/COMPONENT_REFERENCE.md`
- **User Management Reference**: `/resources/views/livewire/user-management.blade.php`

---

## 🔄 Version History

| Date | Version | Changes | Author |
|------|---------|---------|--------|
| Jan 2025 | 1.0.0 | Initial development plan created | System |
| Jan 2025 | 2.0.0 | Revised for time tracking focus | System |

---

## 📌 Notes & Decisions

**Important Decisions:**
- No hour rollover - unused hours expire monthly
- Account numbers use first 8 characters of company name
- Contract numbers include service category (IT/WEB/MARKETING)
- Hours reset on contract anniversary date (not calendar month)
- Each contract has independent hour allocations and overage rates
- Work location must be specified (remote/onsite)
- Monthly reports auto-send on anniversary dates
- Any employee can log time for any client/contract

**Technical Considerations:**
- Use Livewire for all interactive components
- Implement timer with auto-save to prevent data loss
- Use scheduled jobs for period creation and notifications
- Cache contract period lookups for performance
- Use database transactions for time entry creation
- Consider implementing websockets for real-time timer sync
- Add indices on frequently queried columns

**Future Enhancements:**
- Integration with external ticketing system
- Client portal for viewing their own usage
- Automated invoice generation for overages
- Mobile app for time tracking
- Slack/Teams integration for notifications
- API endpoints for third-party integrations

---

**Status Legend:**
- ⏳ Pending
- 🚧 In Progress
- ✅ Complete
- 🔴 Blocked
- 🔄 Needs Review

---

*This document should be updated as development progresses. Check off completed items and add notes about any deviations from the plan.*
