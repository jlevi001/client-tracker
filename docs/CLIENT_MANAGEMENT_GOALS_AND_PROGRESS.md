# Client Management Goals and Progress

**Document Created**: January 4, 2026
**Last Updated**: June 7, 2026 (Contract spec locked — ready to build Phase 2)
**Status**: [DONE] Phase 1A Complete | [DONE] Phase 1B Complete | [DONE] Phase 1C Complete | Ready for Phase 2
**Priority**: High

---

## Executive Summary

The Client Management system is the core module of the Lingo Client Tracker application. It enables Lingo Technologies to:

1. **Track billable time** against client contracts or directly to clients
2. **Monitor contract allocations** with automatic overage detection
3. **Generate billing reports** on contract anniversary dates
4. **Automate billing notifications** to the ticketing system

This document reflects the finalized architecture and requirements as discussed on January 4-7, 2026, with updates through February 9, 2026.

---

## Progress Overview

### Overall Progress

| Phase | Status | Progress |
|-------|--------|----------|
| Phase 1A: Client Management | [DONE] **COMPLETE** | **100%** |
| Phase 1B: Hosting & Domain | [DONE] **COMPLETE** | **100%** |
| Phase 1C: Software Tracking & UI Polish | [DONE] **COMPLETE** | **100%** |
| Phase 2: Contract Management | [NEXT] Next Up | 0% |
| Phase 3: Time Logging | [PLANNED] Planned | 0% |
| Phase 4: Reporting & Billing | [PLANNED] Planned | 0% |

### Phase 1A: Client Management - Basic [DONE] COMPLETE
**Completion Date**: January 5, 2026 | **Development Time**: 2 days | **Records Tested**: 255 live client records

**What We Built:**
- [DONE] Complete client CRUD (Create, Read, Update, Delete) with search, sort, pagination (10/25/50 per page)
- [DONE] CSV Import system - single-pass processing, 255+ records in ~30 seconds, smart quotes handling
- [DONE] Multi-word account number generation (no more duplicates)
- [DONE] Data validation & formatting (phone: +1 AAA BBB CCCC, state abbreviation, email validation)
- [DONE] Mobile responsive at all breakpoints (375px, 768px, 1024px)
- [DONE] Dark theme consistent with daisyUI throughout
- [DONE] Real-time progress feedback during imports (updates every 25 rows)
- [DONE] Loading states, error handling, success confirmations

**Files Created/Modified:**
- `/database/migrations/` - Add `default_hourly_rate` to clients table
- `/app/Livewire/ClientManagement.php` - Livewire component
- `/resources/views/livewire/client-management.blade.php` - Blade view
- `/resources/views/clients/index.blade.php` - Page view
- `/app/Models/Client.php` - Model with formatters

### Phase 1B: Client Detail View & Hosting/Domain [DONE] COMPLETE
**Completion Date**: January 7, 2026

**What We Built:**
- [DONE] Hosting Provider dropdown (Bluehost, GoDaddy, SiteGround, HostGator, DreamHost, A2 Hosting, InMotion, Cloudways, AWS, DigitalOcean, and more)
- [DONE] Hosting Managed By radio buttons (Lingo/Client/Not Set)
- [DONE] Domain Registrar dropdown (GoDaddy, Namecheap, Namesilo, Google Domains, Cloudflare, Network Solutions, Hover, Name.com, Wix, Other, Unknown)
- [DONE] DNS Managed Elsewhere toggle with conditional DNS Provider field
- [DONE] Contact column prefixes - "m:" for mobile, "o:" for office phone
- [DONE] Clickable account numbers - opens edit modal directly
- [DONE] CSV template updated with all hosting/domain columns
- [DONE] All Phase 1A features verified still working

**Files Modified:**
- `/database/migrations/` - Hosting & domain columns migration
- `/app/Livewire/ClientManagement.php` - Updated with hosting/domain logic
- `/resources/views/livewire/client-management.blade.php` - Updated UI
- `/app/Models/Client.php` - Updated with new field handling
- CSV template - New columns added

### Phase 1C: Client Software Tracking & UI Polish [DONE] COMPLETE
**Completion Date**: February 9, 2026

**What We Built:**
- [DONE] Client Software textarea - track software paid for by Lingo per client (comma-separated list)
- [DONE] Monthly Software Cost input with `$` prefix and decimal validation (nullable, numeric, min:0, max:99999.99)
- [DONE] All form inputs now use `w-full` for consistent full-width rendering
- [DONE] Boolean fields (DNS Managed Elsewhere, Billing Address Same) converted from checkboxes to daisyUI toggles
- [DONE] Section header renamed to "Hosting, Domain, & Software Information"
- [DONE] All Phase 1A and 1B features verified still working

**Files Modified:**
- `/database/migrations/2026_02_09_000001_add_software_fields_to_clients_table.php` - New migration
- `/app/Livewire/ClientManagement.php` - Properties, validation, save, edit, and reset logic
- `/resources/views/livewire/client-management.blade.php` - New fields + UI polish
- `/app/Models/Client.php` - Added to `$fillable` and `$casts`

### Phase 1 Metrics

| Goal | Target | Actual | Status |
|------|--------|--------|--------|
| CSV Import Speed | <60s for 250 records | ~30s for 255 records | [DONE] Exceeded |
| CSV Import Success Rate | >95% | 100% | [DONE] Exceeded |
| Account Number Uniqueness | >99% | 100% | [DONE] Exceeded |
| Mobile Responsiveness | All breakpoints | 375px, 768px, 1024px | [DONE] Met |
| Dark Theme Consistency | 100% | 100% | [DONE] Met |
| User Feedback | Loading states | Progress updates + states | [DONE] Exceeded |
| Error Handling | Basic messages | Detailed error reporting | [DONE] Exceeded |
| Hosting/Domain Tracking | Basic fields | Full dropdowns + conditional | [DONE] Exceeded |

### Configuration Changes
- Published Livewire config [DONE]
- Cleared all caches [DONE]
- Extended PHP timeout to 300 seconds [DONE]
- Configured CSV upload directory [DONE]

### Known Issues Resolved
- [DONE] **CSV Import Timeout** - Fixed with single-pass processing
- [DONE] **Smart Quotes** - Auto-detection and conversion implemented
- [DONE] **Duplicate Account Numbers** - Multi-word algorithm implemented
- [DONE] **Company Name Duplicates** - Case-sensitive matching implemented
- [DONE] **Progress Feedback** - Updates every 25 rows

---

## System Architecture

### Rate Hierarchy

```
+-----------------------------------------------------------------+
| BILLING RATE LOGIC                                              |
+-----------------------------------------------------------------+
|                                                                 |
| Time logged WITHOUT contract ("Non-contract labor"):            |
|   -> Bill at CLIENT'S default hourly rate (fully billable)      |
|   -> Appears in billing email as non-contract line items        |
|                                                                 |
| Time logged WITH contract (within monthly allocation):          |
|   -> Covered by the contract's flat monthly fee                 |
|   -> No extra charge                                            |
|                                                                 |
| Time logged WITH contract (overage):                            |
|   -> Bill at CONTRACT overage rate (discounted_hourly_rate)     |
|   -> If no overage rate set -> use client's default rate        |
|   -> Billed on 1st of following month                           |
|                                                                 |
| Hours are tracked PER CONTRACT CATEGORY:                        |
|   -> WEB hours only count against a WEB contract                |
|   -> IT hours with no IT contract = 100% non-contract labor     |
|                                                                 |
+-----------------------------------------------------------------+
```

### Time Logging Flow

```
Employee opens Time Tracker
 |
 v
 Select Client
 |
 v
 Select Contract (or "Non-contract labor")
 |
 +---> Contract selected
 |     |
 |     v
 |     Log time -> tracked against contract allocation
 |     Hours within allotment: covered by flat fee
 |     Hours exceeding allotment: flagged as overage
 |
 +---> "Non-contract labor" selected
       |
       v
       Log time -> billed at client's default hourly rate
       Appears in billing email as non-contract line item
```

### Entity Relationships

```
CLIENT (Company)
 |
 +-- default_hourly_rate: $130.00 (editable per client)
 +-- status: derived (active = has active contract) or manually suspended
 |
 +-- CONTRACTS (0 to many)
 |    |
 |    +-- contract_number: "LINGOTEC-CON-001" (sequential per client)
 |    +-- name: "Digital Marketing Package" (custom, required)
 |    +-- service_category: IT | WEB | MARKETING | OTHER
 |    +-- project_manager_id -> assigned PM (receives renewal alerts)
 |    +-- monthly_price: $500.00 (flat monthly fee)
 |    +-- discounted_hourly_rate: $100.00 (overage rate, or null = default rate)
 |    +-- allotted_hours_monthly: 10 hours
 |    +-- contract_length_months: 12
 |    +-- start_date / end_date
 |    +-- auto_renew: true (default) — extends end_date +12 months automatically
 |    +-- do_not_renew: false (PM sets true if client gives 30-day notice)
 |    +-- renewal_notice_received_at: date client gave notice
 |    +-- google_drive_url: link to signed contract document
 |    +-- status: active | inactive | expired
 |    |
 |    +-- SERVICE TYPES (many-to-many, shown as tags)
 |    |    +-- SEO, Web Development, Social Media, etc.
 |    |
 |    +-- WORK LOGS for this contract (labor notes)
 |         +-- date, description, hours, employee
 |         +-- Aggregated into billing email on 1st of month
 |
 +-- WORK LOGS — Non-contract labor (contract_id = null)
      +-- Billed at client's default hourly rate
      +-- Included in billing email as non-contract section
      +-- Tracked and reported same as contract labor
```

---

## Billing Rules

### Standard Rates
- **System Default**: $130/hour (applied to new clients)
- **Client Default**: Editable per client (inherits system default initially)
- **Contract Flat Fee**: Monthly price charged regardless of hours used
- **Overage Rate**: `discounted_hourly_rate` on the contract (falls back to client default if null)

### Billing Period
- **Reset Date**: 1st of each calendar month (not contract anniversary)
- All contracts share the same billing period regardless of start date
- Hours are tallied from the 1st through the last day of the month

### Billing Email Trigger
- **When**: 1st of every month
- **Where**: Email sent to `billing@itjames.support`
- **Content**: For each client — flat monthly fee(s), overage hours and amounts, non-contract labor hours and amounts
- **Always sent**: Billing email goes out on the 1st whether or not there is overage (flat fee is always billed)

### Contract Status & Client Status
- **Client status** is derived from contracts: client = active if they have at least one active contract
- **Suspended** is a manual override for situations like payment hold
- A client with no contracts defaults to inactive

### Reporting Requirements
- Filter by: All clients OR selected clients
- Date range: Current month OR custom date range
- Shows: Flat monthly fee, hours worked vs allocation, overage hours, overage amount, non-contract hours and cost

---

## Database Schema

### Current Tables ([DONE] Complete)

| Table | Status | Description |
|-------|--------|-------------|
| `clients` | [DONE] Complete | Client company information with hosting/domain/software fields |
| `service_types` | [DONE] Complete | 8 default service categories (seeded) |

### Schema - `clients` table ([DONE] FULLY COMPLETE)

```sql
-- Core Fields (Phase 1A)
id BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY
account_number VARCHAR(10) UNIQUE INDEXED
company_name VARCHAR(255) INDEXED
trading_name VARCHAR(255) NULL
website VARCHAR(255) NULL
email VARCHAR(255) NULL
phone VARCHAR(255) NULL
mobile VARCHAR(255) NULL
address_line_1 VARCHAR(255) NULL
address_line_2 VARCHAR(255) NULL
city VARCHAR(255) NULL
state VARCHAR(10) NULL
zip_code VARCHAR(20) NULL
country VARCHAR(50) DEFAULT 'United States'
billing_address_same BOOLEAN DEFAULT TRUE
billing_address_line_1 VARCHAR(255) NULL
billing_address_line_2 VARCHAR(255) NULL
billing_city VARCHAR(255) NULL
billing_state VARCHAR(10) NULL
billing_zip_code VARCHAR(20) NULL
billing_country VARCHAR(50) NULL
payment_terms ENUM('net15', 'net30', 'net45', 'net60', 'due_on_receipt') DEFAULT 'net30'
tax_id VARCHAR(255) NULL
notes TEXT NULL
default_hourly_rate DECIMAL(8,2) NOT NULL DEFAULT 130.00

-- Hosting & Domain Fields (Phase 1B) [DONE]
hosting_provider VARCHAR(100) NULL
hosting_managed_by ENUM('lingo', 'client') NULL
domain_registrar VARCHAR(100) NULL
domain_registrar_other VARCHAR(100) NULL
dns_managed_elsewhere BOOLEAN NOT NULL DEFAULT FALSE
dns_provider VARCHAR(100) NULL

-- Software Tracking Fields (Phase 1C) [DONE]
client_software TEXT NULL -- Comma-separated list of software paid for by Lingo
software_cost DECIMAL(8,2) NULL -- Monthly software cost

-- Tracking Fields
status ENUM('active', 'inactive', 'suspended') DEFAULT 'active'
created_by_id BIGINT UNSIGNED NULL (FK -> users.id)
updated_by_id BIGINT UNSIGNED NULL (FK -> users.id)
created_at TIMESTAMP
updated_at TIMESTAMP
deleted_at TIMESTAMP NULL (soft deletes)
```

### Dropdown Options

**Hosting Provider:** Select..., Bluehost, GoDaddy, SiteGround, HostGator, DreamHost, A2 Hosting, InMotion, Cloudways, AWS, DigitalOcean (expandable as needed)

**Domain Registrar:** Select..., GoDaddy, Namecheap, Namesilo, Google Domains, Cloudflare, Network Solutions, Hover, Name.com, Wix, Other, Unknown

### Future Tables (Phase 2+)

| Table | Phase | Description |
|-------|-------|-------------|
| `contracts` | 2 | Service contracts with allocations |
| `contract_service_type` | 2 | Pivot: contracts <-> service_types |
| `client_contacts` | 2 | Contact persons for clients |
| `work_logs` | 3 | Time entries |
| `contract_periods` | 4 | Monthly period tracking |

#### `contracts` table (Phase 2):
```sql
CREATE TABLE contracts (
    id BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    client_id BIGINT UNSIGNED NOT NULL,
    project_manager_id BIGINT UNSIGNED NULL,        -- PM who receives renewal alerts
    contract_number VARCHAR(50) NOT NULL UNIQUE,    -- LINGOTEC-CON-001 (sequential)
    name VARCHAR(255) NOT NULL,                     -- Custom display name (required)
    service_category ENUM('IT','WEB','MARKETING','OTHER') NOT NULL,
    monthly_price DECIMAL(8,2) NOT NULL,            -- Flat monthly fee
    discounted_hourly_rate DECIMAL(8,2) NULL,       -- Overage rate; NULL = use client default
    allotted_hours_monthly DECIMAL(6,2) NOT NULL,
    contract_length_months INT NOT NULL DEFAULT 12,
    start_date DATE NOT NULL,
    end_date DATE NULL,
    auto_renew BOOLEAN NOT NULL DEFAULT TRUE,       -- Extends end_date +12 months on expiry
    do_not_renew BOOLEAN NOT NULL DEFAULT FALSE,    -- PM sets TRUE on 30-day client notice
    renewal_notice_received_at DATE NULL,           -- Date client gave non-renewal notice
    google_drive_url VARCHAR(500) NULL,             -- Link to signed contract on Google Drive
    status ENUM('active', 'inactive', 'expired') DEFAULT 'inactive',
    description TEXT NULL,
    notes TEXT NULL,
    created_by_id BIGINT UNSIGNED NULL,
    updated_by_id BIGINT UNSIGNED NULL,
    created_at TIMESTAMP NULL,
    updated_at TIMESTAMP NULL,
    deleted_at TIMESTAMP NULL,

    FOREIGN KEY (client_id) REFERENCES clients(id) ON DELETE CASCADE,
    FOREIGN KEY (project_manager_id) REFERENCES users(id) ON DELETE SET NULL,
    FOREIGN KEY (created_by_id) REFERENCES users(id) ON DELETE SET NULL,
    FOREIGN KEY (updated_by_id) REFERENCES users(id) ON DELETE SET NULL,

    INDEX idx_client_id (client_id),
    INDEX idx_project_manager_id (project_manager_id),
    INDEX idx_status (status),
    INDEX idx_end_date (end_date),
    UNIQUE INDEX idx_contract_number (contract_number)
);
```

#### `contract_service_type` pivot table (Phase 2):
```sql
CREATE TABLE contract_service_type (
    id BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    contract_id BIGINT UNSIGNED NOT NULL,
    service_type_id BIGINT UNSIGNED NOT NULL,
    created_at TIMESTAMP NULL,

    FOREIGN KEY (contract_id) REFERENCES contracts(id) ON DELETE CASCADE,
    FOREIGN KEY (service_type_id) REFERENCES service_types(id) ON DELETE CASCADE,

    UNIQUE INDEX idx_contract_service (contract_id, service_type_id)
);
```

#### `client_contacts` table (Phase 2):
```sql
CREATE TABLE client_contacts (
    id BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    client_id BIGINT UNSIGNED NOT NULL,
    first_name VARCHAR(255) NOT NULL,
    last_name VARCHAR(255) NOT NULL,
    title VARCHAR(255) NULL,
    email VARCHAR(255) NULL,
    phone VARCHAR(255) NULL,
    mobile VARCHAR(255) NULL,
    is_primary BOOLEAN DEFAULT FALSE,
    is_billing_contact BOOLEAN DEFAULT FALSE,
    receives_invoices BOOLEAN DEFAULT FALSE,
    notes TEXT NULL,
    status ENUM('active', 'inactive') DEFAULT 'active',
    created_by_id BIGINT UNSIGNED NULL,
    updated_by_id BIGINT UNSIGNED NULL,
    created_at TIMESTAMP NULL,
    updated_at TIMESTAMP NULL,
    deleted_at TIMESTAMP NULL,

    FOREIGN KEY (client_id) REFERENCES clients(id) ON DELETE CASCADE,
    FOREIGN KEY (created_by_id) REFERENCES users(id) ON DELETE SET NULL,
    FOREIGN KEY (updated_by_id) REFERENCES users(id) ON DELETE SET NULL,

    INDEX idx_client_id (client_id),
    INDEX idx_email (email)
);
```

#### `work_logs` table (Phase 3):
```sql
CREATE TABLE work_logs (
    id BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    client_id BIGINT UNSIGNED NOT NULL, -- Always required
    contract_id BIGINT UNSIGNED NULL, -- NULL = bill at client rate
    service_type_id BIGINT UNSIGNED NOT NULL,
    user_id BIGINT UNSIGNED NOT NULL, -- Employee who logged
    work_date DATE NOT NULL,
    start_time DATETIME NULL,
    end_time DATETIME NULL,
    duration_minutes INT NOT NULL,
    duration_hours DECIMAL(4,2) NOT NULL, -- Calculated
    work_location ENUM('remote', 'onsite') DEFAULT 'remote',
    description TEXT NOT NULL,
    is_billable BOOLEAN DEFAULT TRUE,
    is_overage BOOLEAN DEFAULT FALSE, -- Auto-set when exceeds allocation
    rate_applied DECIMAL(8,2) NOT NULL, -- Captured at time of logging
    created_at TIMESTAMP NULL,
    updated_at TIMESTAMP NULL,
    deleted_at TIMESTAMP NULL,

    FOREIGN KEY (client_id) REFERENCES clients(id) ON DELETE RESTRICT,
    FOREIGN KEY (contract_id) REFERENCES contracts(id) ON DELETE SET NULL,
    FOREIGN KEY (service_type_id) REFERENCES service_types(id) ON DELETE RESTRICT,
    FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE RESTRICT,

    INDEX idx_client_id (client_id),
    INDEX idx_contract_id (contract_id),
    INDEX idx_user_id (user_id),
    INDEX idx_work_date (work_date)
);
```

---

## Contract Document Storage

Contract documents are stored on company Google Drive (not uploaded to the server).

**Workflow:**
1. PM uploads the signed contract PDF to the appropriate Google Drive folder
2. PM copies the shareable link and pastes it into the `google_drive_url` field on the contract record
3. Anyone with access to the app can click the link to view the document

**Field:** `google_drive_url VARCHAR(500) NULL`

**UI Behavior:**
- If URL is set: display a "View Contract" link that opens in a new tab
- If URL is blank: display a muted placeholder ("No document linked")
- Admins and PMs can edit the URL field at any time

**No local file storage is needed for contracts.**

---

## Contract Lifecycle

### Workflow Steps
```
1. Proposal sent to client (tracked manually or via notes)
2. Contract created in app (status: inactive)
3. Signed contract uploaded to Google Drive; URL added to contract record
4. Contract activated (status: active)
5. Monthly billing runs on 1st of each month
6. 30 days before end_date: system emails PM ("Contract expiring in 30 days")
7a. If auto_renew = TRUE and do_not_renew = FALSE:
    -> end_date extended +12 months automatically on the expiry date
7b. If do_not_renew = TRUE:
    -> Contract expires on end_date (status: expired)
    -> No auto-extension
```

### Status Transitions
```
                  +----------------+
   Create ------->|   INACTIVE     |<------ Deactivate manually
                  +-------+--------+
                          |
                      Activate
                          |
                          v
                  +----------------+
                  |    ACTIVE      |<------ Reactivate manually
                  +-------+--------+
                          |
            +-------------+-------------+
            |                           |
     End date reached          Manual deactivate
     (do_not_renew=TRUE)                |
            |                           v
            |                  +----------------+
            |                  |   INACTIVE     |
            v                  +----------------+
   +----------------+
   |    EXPIRED     |
   +----------------+

   Auto-renew path (do_not_renew=FALSE):
   end_date reached -> end_date += 12 months -> stays ACTIVE
```

### Auto-Renewal Logic
- **Scheduled Job**: Runs daily to check contracts with `end_date = today`
- **If `do_not_renew = FALSE`**: Push `end_date` forward 12 months; contract stays active; email PM to confirm
- **If `do_not_renew = TRUE`**: Set status to `expired`; no extension

### 30-Day Renewal Warning
- **Scheduled Job**: Runs daily; checks for contracts where `end_date = today + 30 days`
- **Action**: Email sent to the contract's assigned `project_manager_id`
- **Content**: "Contract [number] for [client] expires on [date]. Set 'Do Not Renew' to stop auto-renewal."

### Client Gives Non-Renewal Notice
1. PM opens the contract record
2. PM sets `do_not_renew = TRUE` and fills in `renewal_notice_received_at` (date received)
3. Contract continues to run until `end_date`, then expires — no further auto-extension

---

## CSV Import Feature [DONE] COMPLETE

### Matching Logic
- **Primary Match**: `account_number` column (if provided and exists)
- **Secondary Match**: `company_name` column (exact match, case-sensitive)
- If account_number exists -> **UPDATE** that record
- If account_number blank BUT company_name exists -> **UPDATE** that record
- If neither match -> **CREATE** new client (auto-generate account number)

**Important**: Company name matching is **case-sensitive** ("ACME Corp" != "Acme Corp")

### Multi-Word Account Number Generation

**Algorithm:**
- **2+ words**: First 4 chars of word 1 + First 4 chars of word 2
- **1 word**: First 8 characters
- **Padding**: Zeros if needed to reach 8 chars

**Examples from Production:**
| Company Name | Account Number |
|--------------|----------------|
| Arkansas Investigations | ARKAINVE |
| Arkansas Man Camp | ARKAMANC |
| Arkansas Pro Wash | ARKAPROW |
| God's Armorbearer Coaching | GODSARMO |
| Mama B's Tea and Coffee | MAMABSTE |
| Taj Mahal | TAJMAHAL |
| ABBA Adoption | ABBAADOP |

### Smart Quotes Handling

**Problem**: Excel auto-converts regular apostrophes to smart quotes (Windows-1252 encoding), causing PHP CSV parser failures.

**Solution**: Auto-detection and conversion of:
- Right/Left single quotes -> `'`
- Right/Left double quotes -> `"`
- Non-breaking spaces -> regular space
- En/Em dashes -> `-`

### Import Process Flow
```
1. User clicks "Import CSV" button
2. User selects/uploads CSV file
3. System validates file format
4. SINGLE-PASS PREVIEW with progress:
    +-- Processes entire file in one pass
    +-- Extended timeout: 300 seconds
    +-- Progress updates every 25 rows
    +-- Shows count: X new clients to create
    +-- Shows count: Y existing clients to update
    +-- Shows count: Z rows with errors (with details)
5. User reviews and confirms
6. User clicks "Confirm Import"
7. SINGLE-PASS IMPORT with progress:
    +-- Processes entire file in one pass
    +-- Progress updates every 25 rows
    +-- Updates progress: "Importing X of Y..."
8. Success message with summary
```

### CSV Template Columns
```csv
account_number,company_name,trading_name,email,phone,mobile,website,address_line_1,address_line_2,city,state,zip_code,country,billing_address_same,billing_address_line_1,billing_address_line_2,billing_city,billing_state,billing_zip_code,billing_country,payment_terms,tax_id,default_hourly_rate,hosting_provider,hosting_managed_by,domain_registrar,domain_registrar_other,dns_managed_elsewhere,dns_provider,notes
```

### Validation Rules
- `company_name`: Required, max 255 chars
- `email`: Optional, must be valid email format if provided
- `phone`/`mobile`: Optional, formatted on save (+1 AAA BBB CCCC)
- `state`: Optional, abbreviated on save (Texas -> TX)
- `payment_terms`: Must be one of: net15, net30, net45, net60, due_on_receipt
- `default_hourly_rate`: Optional, numeric, defaults to 130.00
- `hosting_provider`: Optional, must match dropdown values
- `hosting_managed_by`: Optional, must be 'lingo' or 'client'
- `domain_registrar`: Optional, must match dropdown values
- `dns_managed_elsewhere`: Optional, boolean (TRUE/FALSE)
- `dns_provider`: Optional, text field

---

## Permissions

### Role Capabilities

| Action | Admin | Manager | Employee |
|--------|-------|---------|----------|
| View clients | [DONE] | [DONE] | [DONE] |
| Create clients | [DONE] | [DONE] | [X] |
| Edit clients | [DONE] | [DONE] | [X] |
| Delete clients | [DONE] | [X] | [X] |
| Import CSV | [DONE] | [X] | [X] |
| View contracts | [DONE] | [DONE] | [DONE] |
| Manage contracts | [DONE] | [DONE] | [X] |
| Upload contract PDF | [DONE] | [DONE] | [X] |
| Create work logs | [DONE] | [DONE] | [DONE] |
| Edit own work logs | [X] | [X] | [X] |
| Edit any work logs | [DONE] | [X] | [X] |
| View all work logs | [DONE] | [DONE] | Own only |
| View reports | [DONE] | [DONE] | [X] |
| Export data | [DONE] | [DONE] | [X] |

### Permissions to Create (Future Phases)
```php
'view-clients'        // Phase 1A [DONE]
'create-clients'      // Phase 1A [DONE]
'edit-clients'        // Phase 1A [DONE]
'delete-clients'      // Phase 1A [DONE]
'import-clients'      // Phase 1A [DONE]
'view-contracts'      // Phase 2
'manage-contracts'    // Phase 2
'upload-contract-pdf' // Phase 2
'create-work-logs'    // Phase 3
'edit-work-logs'      // Phase 3 (Admin only)
'view-all-work-logs'  // Phase 3
'view-reports'        // Phase 4
'export-data'         // Phase 4
```

---

## UI/UX Standards

### Component Framework
- **daisyUI 5.0.50** - Primary UI framework [DONE]
- **No raw Tailwind** for components (use daisyUI semantic classes) [DONE]
- **Tailwind utilities** only for layout and spacing [DONE]

### Theme
- **Dark theme only** - No light mode
- `bg-base-100` - Main background
- `bg-base-200` - Cards, sections
- `bg-base-300` - Darker accents, borders
- `text-base-content` - Primary text
- `text-base-content/70` - Muted text

### Responsive Breakpoints
- **Mobile**: 375px (base)
- **Tablet**: 768px (`sm:`)
- **Desktop**: 1024px (`lg:`)

### Required States
- Loading states for all async operations
- Error states with clear messages
- Empty states for lists/tables
- Confirmation dialogs for destructive actions
- Success feedback after actions
- Progress feedback for batch operations

### Contact Display Rules
```
Display Logic:
1. If mobile exists -> show "m: XXX-XXX-XXXX"
2. Else if phone exists -> show "o: XXX-XXX-XXXX"
3. Else -> show "—"
```

---

## Development Roadmap

### Phase 2: Contract Management [NEXT] **NEXT UP!**
**Goal**: Full contract lifecycle — Contracts section in top nav, contract link on client, calendar-month billing

- [ ] **Migration**: Create `contracts` table (see updated schema above)
- [ ] **Migration**: Create `contract_service_type` pivot table
- [ ] **Migration**: Create `client_contacts` table
- [ ] **Model**: Create `Contract` model with relationships
- [ ] **Model**: Create `ClientContact` model with relationships
- [ ] **Livewire Component**: `ContractManagement.php` — top-level Contracts section (own nav item)
- [ ] **Features - Contracts**:
    - [ ] Top-level "Contracts" nav item (its own section, not buried in Clients)
    - [ ] Contract link/summary on client info panel (quick access from client view)
    - [ ] Add / Edit / Delete contract modals
    - [ ] Contract status management (active / inactive / expired)
    - [ ] Service category field (IT | WEB | MARKETING | OTHER)
    - [ ] Assigned project manager dropdown (users list)
    - [ ] Monthly price (flat fee) field
    - [ ] Overage rate field (optional)
    - [ ] Sequential contract number auto-generation (`ACCOUNT-CON-001`)
    - [ ] Google Drive URL field with "View Contract" link
    - [ ] Multiple contracts per client tracked independently by category
    - [ ] `auto_renew` toggle (default ON)
    - [ ] `do_not_renew` toggle + `renewal_notice_received_at` date picker
    - [ ] Service types displayed as tags (many-to-many)
    - [ ] Monthly hours allocation display
    - [ ] Hours used in current calendar month (real-time)
- [ ] **Features - Client Contacts**:
    - [ ] Contact list per client
    - [ ] Add/Edit/Delete contacts
    - [ ] Primary contact designation
    - [ ] Billing contact designation
- [ ] **Scheduled Job**: Daily — 30-day renewal warning email to PM
- [ ] **Scheduled Job**: Daily — auto-renew or expire contracts on end_date
- [ ] **Scheduled Job**: Monthly (1st) — generate and send billing email to `billing@itjames.support`

**Estimated Effort**: 4-5 days

---

### Phase 3: Time Logging [PLANNED] **PLANNED**
**Goal**: Timer interface with contract selection

- [ ] **Migration**: Create `work_logs` table
- [ ] **Model**: Create WorkLog model
- [ ] **Livewire Component**: Create `TimeLogger.php`
- [ ] **Features**:
    - [ ] Timer interface (start/stop/pause)
    - [ ] Auto-save timer state to prevent data loss
    - [ ] Client selection dropdown (with active contracts shown)
    - [ ] Contract selection (conditional, shows service category)
    - [ ] Service type selection
    - [ ] Work location toggle (Remote/Onsite)
    - [ ] Date picker (default today)
    - [ ] Description field
    - [ ] Rate display (shows applicable rate based on contract selection)
    - [ ] Manual time entry option (alternative to timer)
    - [ ] Overage detection (check current period allocation, mark if exceeded)
- [ ] **Employee View**: List own work logs, filter by date/client/contract
- [ ] **Admin View**: View all work logs, edit any entry
- [ ] **Permissions**: Employee/Admin views properly enforced
- [ ] **Rate Application**: Capture at logging time

**Estimated Effort**: 4-5 days

---

### Phase 4: Reporting & Billing [PLANNED] **PLANNED**
**Goal**: Overage calculations and automated billing

- [ ] **Migration**: Create `contract_periods` table
- [ ] **Model**: Create ContractPeriod model
- [ ] **Scheduled Job**: Period creation on anniversary (daily check, handle month-end edge cases)
- [ ] **Scheduled Job**: Overage calculation (sum work logs, apply rates)
- [ ] **Email**: Billing notification automation (send on anniversary, only if overage exists)
- [ ] **Reports**:
    - [ ] Hours tracking dashboard (used vs allocated, visual progress bars)
    - [ ] 80% allocation warning alerts
    - [ ] Hours by client/contract
    - [ ] Overage summary with amounts
    - [ ] Work by location breakdown (remote/onsite)
    - [ ] Service type breakdown
    - [ ] Filters (date range, clients, preset options: Current Month, Last Month, etc.)
    - [ ] Export (CSV/PDF) for work logs, client list, contract summary, monthly overage

**Estimated Effort**: 5-6 days

### Overall System Acceptance Criteria
1. Time can be logged against a specific contract or as non-contract labor
2. Contracts track monthly hour allocations per service category
3. Overages are automatically detected and flagged
4. Billing email sent on 1st of each month to `billing@itjames.support`
5. Billing email includes: flat fees, overages, and non-contract labor per client
6. Contracts auto-renew (extend end_date +12 months) unless `do_not_renew = TRUE`
7. PM receives 30-day renewal warning email before contract expires
8. Reports can be filtered and exported
9. All permissions properly enforced
10. Client status derives from active contracts (suspended = manual override)

---

## Code Patterns & Reference Logic

### Contract Number Auto-Generation

**Format:** Sequential per client — `{ACCOUNT_NUMBER}-CON-{NNN}`

**Examples:**
- Lingo Technologies, 1st contract  = `LINGOTEC-CON-001`
- Lingo Technologies, 2nd contract  = `LINGOTEC-CON-002`
- ABC Company, 1st contract         = `ABCCOMPA-CON-001`

**PHP Implementation (Contract model observer):**
```php
public function creating(Contract $contract)
{
    $accountNumber = $contract->client->account_number;
    $count = Contract::where('client_id', $contract->client_id)->withTrashed()->count() + 1;

    $contract->contract_number = $accountNumber . '-CON-' . str_pad($count, 3, '0', STR_PAD_LEFT);
}
```

### Calendar-Month Billing Period

**Monthly Reset Logic:**
- All contracts reset on the **1st of each calendar month**
- Start date does not affect the billing period
- Example: Contract starts May 24 → first full period is June 1–30

**Scheduled Job — 1st of Month:**
```php
// Runs on the 1st of each month
// 1. Tally all work_logs for the previous calendar month per contract
// 2. Calculate overage (hours used - allotted_hours_monthly)
// 3. Generate billing email for each client with active contracts or non-contract labor
// 4. Send to billing@itjames.support
```

**Email Content:**
- Client name, contract(s) with flat monthly fee
- Overage hours + overage charge per contract (if any)
- Non-contract labor hours + charge (if any)
- Total amount due for the month

### Timer Interface Pattern (Phase 3 Reference)

**Blade Template Mockup:**
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

### Monthly Billing Workflow

```
Scheduled Job: Runs on 1st of each month
 |
 v
For each client with active contracts or non-contract work last month:
 |
 +---> Per contract:
 |     Sum work_logs for previous calendar month
 |     Overage = MAX(0, hours_used - allotted_hours_monthly)
 |     Overage charge = overage * (discounted_hourly_rate ?? client.default_hourly_rate)
 |     Flat fee = contract.monthly_price
 |
 +---> Per client (non-contract labor):
 |     Sum work_logs where contract_id IS NULL
 |     Non-contract charge = hours * client.default_hourly_rate
 |
 +---> Build billing email:
       Flat fees + overages + non-contract charges
       Send to billing@itjames.support
       Mark report_sent = true on period record

Scheduled Job: Runs daily
 |
 +---> Check contracts where end_date = today + 30 days
 |     Email assigned project_manager_id: "Contract expiring in 30 days"
 |
 +---> Check contracts where end_date = today
       If do_not_renew = FALSE: extend end_date +12 months; email PM confirmation
       If do_not_renew = TRUE:  set status = 'expired'
```

### Work Log Workflow

```
Employee creates work log entry
 |
 v
System checks: Does contract have allocation?
 |
 +---> Yes --> Check current period hours
 |              |
 |              +---> Within allocation --> is_overage = false, rate = standard_rate
 |              +---> Exceeds allocation --> is_overage = true, rate = overage_rate
 |
 +---> No contract --> Bill at client's default_hourly_rate
```

---

## Technical Considerations

- **Timer auto-save**: Implement auto-save to prevent data loss on browser crash/close
- **Database transactions**: Use transactions for time entry creation to ensure data integrity
- **Caching**: Cache contract period lookups for performance on frequently accessed data
- **Eager loading**: Use eager loading for relationships to avoid N+1 query problems
- **Websockets**: Consider implementing for real-time timer sync across multiple devices/tabs
- **Indices**: Add indices on frequently queried columns (work_date, client_id, contract_id)
- **Queue jobs**: Use Laravel queues for email report generation to avoid blocking requests

---

## Testing Checklist

### Functional Testing
- [ ] Contract numbers generate sequentially per client (ACCOUNT-CON-001, 002, etc.)
- [ ] Timer calculates time correctly
- [ ] Overage detection works when hours exceed allocation
- [ ] Billing period resets on 1st of calendar month (not start date)
- [ ] Email sent on 1st of month includes flat fees + overages + non-contract labor
- [ ] Multiple contracts per client track independently by service category
- [ ] do_not_renew flag prevents auto-extension on expiry
- [ ] auto_renew extends end_date +12 months when contract expires
- [ ] PM receives 30-day warning email before end_date
- [ ] Client status = active when at least one contract is active

### Edge Cases to Test
- [ ] Duplicate contract numbers handled gracefully
- [ ] Multiple active contracts per client (different categories) work independently
- [ ] Overlapping work log entries prevented
- [ ] Non-contract labor billed at client default rate when no contract exists
- [ ] IT hours logged by client with only a WEB contract → treated as non-contract labor
- [ ] Timer session recovery after browser crash
- [ ] Contract activated mid-month: first billing period = partial month
- [ ] Contract with do_not_renew = TRUE expires cleanly without extension
- [ ] Google Drive URL field: blank → shows "No document linked"; set → shows clickable link

---

## Decision Log

| Date | Decision | Rationale |
|------|----------|-----------|
| Jan 4, 2026 | Hourly rate at client level (not system-wide only) | Allows per-client pricing flexibility |
| Jan 4, 2026 | Contract discount rate is optional | Falls back to client rate, simplifies common case |
| Jan 4, 2026 | Time can be logged without contract | Supports one-off billable work |
| Jan 4, 2026 | Contracts use many-to-many with services | One package can include multiple services |
| Jan 4, 2026 | Contract name is custom (not auto-generated) | More flexibility in naming packages |
| Jan 4, 2026 | PDF required for contract activation | Ensures documentation before billing |
| Jan 4, 2026 | CSV import matches on account_number | Reliable unique identifier |
| Jan 4, 2026 | Only admins can edit work logs | Prevents accidental/unauthorized changes |
| Jan 4, 2026 | Auto-expire contracts with notification | Reduces manual oversight |
| Jan 4, 2026 | Anniversary-based billing periods | Aligns with contract start, not calendar |
| Jan 5, 2026 | CSV import also matches on company_name | Prevents duplicates when account_number not provided |
| Jan 5, 2026 | Company name matching is case-sensitive | Exact matching prevents false positives |
| Jan 5, 2026 | Contact display: mobile priority with prefixes | "m:" for mobile, "o:" for office clarifies type |
| Jan 5, 2026 | Add hosting_provider and hosting_managed_by fields | Track where sites are hosted and who manages |
| Jan 5, 2026 | Add domain_registrar with dropdown | Consistent data entry for domain info |
| Jan 5, 2026 | Add dns_managed_elsewhere with conditional dns_provider | Track DNS location when different from registrar |
| Jan 5, 2026 | Single-pass CSV processing (removed batching) | 255 rows small enough, simpler = more reliable |
| Jan 5, 2026 | Extended timeout to 300 seconds | Prevents timeouts on large imports |
| Jan 5, 2026 | Progress updates every 25 rows | User feedback without complexity |
| Jan 5, 2026 | Auto-detect and convert smart quotes | Excel compatibility, prevents parse failures |
| Jan 5, 2026 | Multi-word account number generation | Eliminates duplicate account numbers |
| Jan 7, 2026 | Hosting Provider as dropdown (not free text) | Consistent data, easier reporting |
| Jan 7, 2026 | Domain Registrar with "Other" option | Covers common cases + flexibility |
| Jan 7, 2026 | List + modal approach (no separate detail page) | Simpler UX, faster navigation |
| Jan 7, 2026 | Account numbers clickable to edit | Faster access to edit functionality |
| Feb 9, 2026 | Add client_software text field | Track software Lingo pays for per client |
| Feb 9, 2026 | Add software_cost decimal field | Track monthly software expenses per client |
| Feb 9, 2026 | All form inputs use w-full | Consistent full-width rendering across all fields |
| Feb 9, 2026 | Checkboxes converted to toggles | Better UX for boolean fields (daisyUI toggle) |
| Feb 9, 2026 | Section header includes "Software" | Reflects expanded scope of hosting/domain/software section |
| Jun 7, 2026 | Contract docs stored on Google Drive (URL only, no PDF upload) | Avoids server storage complexity; team already uses Google Drive |
| Jun 7, 2026 | Billing resets on 1st of calendar month (not anniversary) | Simpler — all contracts bill on the same date each month |
| Jun 7, 2026 | Billing email sent on 1st of month to billing@itjames.support | Integrates with existing ticketing/billing workflow |
| Jun 7, 2026 | Contract pricing = flat monthly fee + optional overage rate | Clients pay a fixed amount; overages billed on top |
| Jun 7, 2026 | Contract number format: ACCOUNT-CON-001 (sequential per client) | Simple, readable, no year/service in the number |
| Jun 7, 2026 | Service category on contract: IT, WEB, MARKETING, OTHER | Hours only count against same-category contract |
| Jun 7, 2026 | Contracts section is top-level nav item | Contracts are first-class, not nested under clients |
| Jun 7, 2026 | Contract link also accessible from client info panel | PMs need quick access from the client view |
| Jun 7, 2026 | auto_renew defaults to TRUE | Most contracts auto-renew; opt-out rather than opt-in |
| Jun 7, 2026 | do_not_renew flag + renewal_notice_received_at date | PM records when client gives 30-day notice |
| Jun 7, 2026 | PM assigned per contract; receives renewal warnings | Contract-level PM accountability for renewals |
| Jun 7, 2026 | Contracts auto-extend end_date +12 months on expiry (if not flagged) | Reduces manual work; mirrors real-world auto-renewal |
| Jun 7, 2026 | Suspended status remains as manual override | Useful for payment holds without ending the contract |
| Jun 7, 2026 | Non-contract labor tracked same as contracted (time tracker, category, billing) | Ensures all billable hours are captured regardless of contract status |
| Jun 7, 2026 | Client status derived from contracts (active = has active contract) | Status reflects commercial reality, not manual maintenance |
| Jun 7, 2026 | Phone display format changed to XXX-XXX-XXXX (no country code) | US-only business; +1 prefix is noise |

---

## Next Steps

### Immediate (Phase 2 - Contract Management):
1. Design contract management UI
2. Create contracts database table
3. Create contract_service_type pivot table
4. Build contract CRUD operations
5. Implement PDF upload functionality
6. Add contract status management
7. Create scheduled job for expiration

### Short-term (Phase 3 - Time Logging):
1. Design time logging interface
2. Create work_logs table
3. Build timer functionality
4. Implement contract selection
5. Add admin approval workflow

### Medium-term (Phase 4 - Reporting):
1. Build reporting dashboard
2. Implement overage calculations
3. Create billing email automation
4. Add export functionality
5. Performance optimization

---

## Future Enhancements (Post-MVP)

- Client portal for viewing usage
- Automated invoice generation
- Slack/Teams integration for notifications
- Mobile app for time tracking
- Integration with external ticketing system
- API endpoints for third-party tools
- Recurring contract auto-renewal with new PDF upload
- Multi-currency support
- Websockets for real-time timer sync across devices

---

## Reference & Support

### Reference Files
- `/docs/ai-instructions.md` - Coding standards
- `/docs/DAISYUI_CONVERSION_GUIDE.md` - Component conversion
- `/docs/database_tables_current.md` - Current DB state
- `/docs/CLIENT_MANAGEMENT_GOALS_AND_PROGRESS.md` - This file (consolidated)

### Existing Code Patterns to Follow
- `/app/Livewire/UserManagement.php` - Component structure
- `/resources/views/livewire/user-management.blade.php` - UI patterns
- `/app/Livewire/ClientManagement.php` - Client management
- `/app/Models/Client.php` - Model with formatters
- `/resources/views/components/` - Reusable components

### CSV Import Troubleshooting
- **Smart quotes causing failure**: Use auto-fix feature or download clean template
- **Duplicate company names**: CSV import matches on company name (case-sensitive)
- **Account number duplicates**: Multi-word algorithm prevents duplicates
- **Timeout on large files**: Single-pass processing handles 255+ records

### Additional Documentation
- `/docs/CSV_CLEANUP_GUIDE.md` - Smart quotes prevention guide
- `/docs/CSV_CLEANUP_QUICK_REFERENCE.md` - Quick reference
- `/docs/UPLOAD_INSTRUCTIONS.md` - Deployment instructions

**Note:** `CLIENT_MANAGEMENT_DEVELOPMENT.md` was merged into this file on Feb 9, 2026. All unique content preserved here.

---

**Status Legend:**
- [PLANNED] Planned
- [FOCUS] Current Focus
- [WIP] In Progress
- [NEXT] Next Up
- [REVIEW] Debugging/Review
- [DONE] Complete

---

*This document should be updated as development progresses. Check off completed items and add notes about any deviations from the plan.*

*Last Updated: June 7, 2026 — Contract Management spec fully locked. Billing model updated to calendar-month (1st), Google Drive URLs replace PDF upload, sequential contract numbers, auto-renewal logic, PM notifications, non-contract labor architecture. Ready to build Phase 2.*
