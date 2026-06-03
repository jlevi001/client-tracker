# Current Database Tables

**Last Updated**: June 3, 2026
**Database**: fmayejttab (MySQL 8)

---

## Table Summary

| # | Table Name | Description | Status |
|---|------------|-------------|--------|
| 1 | `clients` | Client company information | **New** |
| 2 | `failed_jobs` | Laravel queue failed jobs | Standard |
| 3 | `migrations` | Laravel migration tracking | Standard |
| 4 | `model_has_permissions` | Spatie permission pivot | Standard |
| 5 | `model_has_roles` | Spatie role pivot | Standard |
| 6 | `password_reset_tokens` | Password reset tokens | Standard |
| 7 | `permissions` | Spatie permissions | Standard |
| 8 | `personal_access_tokens` | Laravel Sanctum tokens | Standard |
| 9 | `role_has_permissions` | Spatie role-permission pivot | Standard |
| 10 | `roles` | Spatie roles | Standard |
| 11 | `service_types` | Admin-managed service categories | Custom |
| 12 | `users` | Application users | Modified |
| 13 | `user_wages` | Current user wage records | Custom |
| 14 | `user_wage_history` | Historical wage records | Custom |
| 15 | `wage_histories` | Additional wage tracking | Custom |

---

## Table List (Raw)

```
+------------------------+
| Tables_in_fmayejttab   |
+------------------------+
| clients                |
| failed_jobs            |
| migrations             |
| model_has_permissions  |
| model_has_roles        |
| password_reset_tokens  |
| permissions            |
| personal_access_tokens |
| role_has_permissions   |
| roles                  |
| service_types          |
| user_wage_history      |
| user_wages             |
| users                  |
| wage_histories         |
+------------------------+
```

**Total: 15 tables**

---

## Table Details

### Standard Laravel Tables
- `failed_jobs` - Stores failed queue job information
- `migrations` - Tracks which migrations have been run
- `password_reset_tokens` - Stores password reset tokens
- `personal_access_tokens` - Laravel Sanctum API tokens

### Spatie Permission Tables
- `permissions` - Stores individual permissions
- `roles` - Stores roles (Admin, Manager, Employee)
- `model_has_permissions` - User-permission relationships
- `model_has_roles` - User-role relationships
- `role_has_permissions` - Role-permission relationships

### Custom Application Tables

#### `clients` â­ NEW
Client company information with contact details and billing settings.
```sql
- id (bigint, primary key)
- account_number (varchar 10, unique, indexed) -- Auto-generated from company name
- company_name (varchar 255, indexed)
- trading_name (varchar 255, nullable) -- DBA name
- website (varchar 255, nullable)
- email (varchar 255, nullable)
- phone (varchar 255, nullable) -- Formatted: +1 AAA BBB CCCC
- mobile (varchar 255, nullable)
- address_line_1 (varchar 255, nullable)
- address_line_2 (varchar 255, nullable)
- city (varchar 255, nullable)
- state (varchar 10, nullable) -- Abbreviated (TX, CA, ON, etc.)
- zip_code (varchar 20, nullable)
- country (varchar 50, default: 'United States')
- billing_address_same (boolean, default: true)
- billing_address_line_1 (varchar 255, nullable)
- billing_address_line_2 (varchar 255, nullable)
- billing_city (varchar 255, nullable)
- billing_state (varchar 10, nullable)
- billing_zip_code (varchar 20, nullable)
- billing_country (varchar 50, nullable)
- payment_terms (enum: 'net15', 'net30', 'net45', 'net60', 'due_on_receipt', default: 'net30')
- tax_id (varchar 255, nullable)
- hosting_provider (varchar 100, nullable) -- Phase 1B
- hosting_managed_by (enum: 'lingo', 'client', nullable) -- Phase 1B
- domain_registrar (varchar 100, nullable) -- Phase 1B
- domain_registrar_other (varchar 100, nullable) -- Phase 1B
- dns_managed_elsewhere (boolean, default: false) -- Phase 1B
- dns_provider (varchar 100, nullable) -- Phase 1B
- client_software (text, nullable) -- Phase 1C: comma-separated list of software paid for by Lingo
- software_cost (decimal 8,2, nullable) -- Phase 1C: monthly software cost
- status (enum: 'active', 'inactive', 'suspended', default: 'active')
- notes (text, nullable)
- created_by_id (foreign key â†' users.id, nullable)
- updated_by_id (foreign key â†' users.id, nullable)
- created_at (timestamp)
- updated_at (timestamp)
- deleted_at (timestamp, nullable) -- Soft deletes

Indexes:
- account_number (unique)
- company_name
- status
- created_at
```

**Account Number Generation:**
- First 8 alphanumeric characters of company name, uppercase
- Examples: "Lingo Technologies" â†’ "LINGOTEC", "ABC Company" â†’ "ABCCOMPA"
- Duplicates get suffix: "CANYONVI", "CANYONVI2"

#### `users`
Core user table with authentication and profile fields.
```sql
- id (bigint, primary key)
- name (varchar 255)
- email (varchar 255, unique)
- email_verified_at (timestamp, nullable)
- employment_start_date (date, nullable)
- employment_end_date (date, nullable) -- Set when employee leaves; drives Active/Inactive status
- password (varchar 255)
- two_factor_secret (text, nullable)
- two_factor_recovery_codes (text, nullable)
- two_factor_confirmed_at (timestamp, nullable)
- remember_token (varchar 100, nullable)
- created_at (timestamp)
- updated_at (timestamp)
```

#### `user_wages`
Current wage assignments for users.
```sql
- id (bigint, primary key)
- user_id (foreign key â†’ users.id, cascade delete)
- wage_type (enum: 'hourly', 'salary')
- wage_rate (decimal 10,2)
- start_date (date)
- end_date (date, nullable)
- notes (varchar 255, nullable)
- created_by (foreign key â†’ users.id, nullable)
- created_at (timestamp)
- updated_at (timestamp)

Indexes:
- user_id + start_date
- end_date
```

#### `user_wage_history`
Historical record of all wage changes.
```sql
- id (bigint, primary key)
- user_id (foreign key â†’ users.id, cascade delete)
- wage_type (enum: 'hourly', 'salary')
- wage_rate (decimal 10,2)
- start_date (date)
- end_date (date, nullable)
- created_by (foreign key â†’ users.id)
- notes (text, nullable)
- created_at (timestamp)
- updated_at (timestamp)

Indexes:
- user_id + start_date
- user_id + end_date
```

#### `wage_histories`
Additional wage history tracking table.
```sql
- id (bigint, primary key)
- user_id (foreign key â†’ users.id, cascade delete)
- wage_amount (decimal 10,2)
- wage_type (enum: 'hourly', 'salary', default: 'hourly')
- effective_date (date)
- notes (text, nullable)
- created_by (foreign key â†’ users.id, nullable)
- created_at (timestamp)
- updated_at (timestamp)

Indexes:
- user_id + effective_date
```

#### `service_types`
Admin-managed list of service categories for work logs.
```sql
- id (bigint, primary key)
- name (varchar 255, unique)
- description (text, nullable)
- is_billable (boolean, default: true)
- is_active (boolean, default: true)
- display_order (int, default: 0)
- created_by_id (foreign key â†’ users.id, nullable)
- updated_by_id (foreign key â†’ users.id, nullable)
- created_at (timestamp)
- updated_at (timestamp)

Indexes:
- name
- is_active
- display_order
```

**Default Seed Data:**
| ID | Name | Description | Billable | Active | Order |
|----|------|-------------|----------|--------|-------|
| 1 | Consultation | General consultation and advisory services | âœ“ | âœ“ | 1 |
| 2 | Computer Repair | Hardware and software repair services | âœ“ | âœ“ | 2 |
| 3 | Maintenance | Regular maintenance and upkeep services | âœ“ | âœ“ | 3 |
| 4 | Network Management | Network setup, configuration, and management | âœ“ | âœ“ | 4 |
| 5 | Web Development | Website design and development services | âœ“ | âœ“ | 5 |
| 6 | SEO | Search Engine Optimization services | âœ“ | âœ“ | 6 |
| 7 | ADs | Advertising and marketing campaigns | âœ“ | âœ“ | 7 |
| 8 | Social Media | Social media management and marketing | âœ“ | âœ“ | 8 |

---

## Current Users

| ID | Name | Email | Role | Employment Start |
|----|------|-------|------|------------------|
| 1 | James Levisee | james@lingoit.net | Admin | 2017-01-13 |
| 2 | Chance Levisee | chance@lingoit.net | Employee | 2022-05-17 |
| 3 | Carson Smith | carson@lingoit.net | Employee | 2025-07-29 |
| 4 | Zak Jones | zak@lingoit.net | Employee | 2023-07-25 |

---

## Current Roles

| ID | Name | Guard |
|----|------|-------|
| 1 | Admin | web |
| 2 | Manager | web |
| 3 | Employee | web |

---

## Current Permissions

| ID | Name | Guard |
|----|------|-------|
| 1 | view.hourly.rates | web |
| 2 | manage users | web |
| 3 | create users | web |
| 4 | edit users | web |
| 5 | delete users | web |
| 6 | assign roles | web |

---

## Pending Tables (Client Management)

The following tables are planned for the Client Management system:

| Table | Status | Description |
|-------|--------|-------------|
| `clients` | âœ… Complete | Client company information |
| `client_contacts` | ðŸ“œ Pending | Contact persons for clients |
| `contracts` | ðŸ“œ Pending | Service contracts with hour allocations |
| `work_logs` | ðŸ“œ Pending | Time entries against contracts |
| `contract_periods` | ðŸ“œ Pending | Monthly period tracking |

---

## Migration History

| Batch | Migration | Date |
|-------|-----------|------|
| 1 | 2014_10_12_000000_create_users_table | Initial |
| 1 | 2014_10_12_100000_create_password_reset_tokens_table | Initial |
| 1 | 2014_10_12_200000_add_two_factor_columns_to_users_table | Initial |
| 1 | 2019_08_19_000000_create_failed_jobs_table | Initial |
| 1 | 2019_12_14_000001_create_personal_access_tokens_table | Initial |
| 1 | 2025_08_15_201654_create_permission_tables | Initial |
| 2 | 2025_08_24_190000_add_wage_fields_to_users_table | â€” |
| 3 | 2025_08_26_183920_add_wage_type_to_users_table | â€” |
| 4 | 2025_08_26_184150_add_wage_fields_to_users_table | â€” |
| 5 | 2025_08_26_200000_create_user_wage_history_table | â€” |
| 5 | 2025_08_26_210000_remove_wage_fields_from_users_table | â€” |
| 6 | 2025_08_31_000000_create_user_wages_table | â€” |
| 7 | 2025_01_10_000000_add_employment_start_date_to_users_table | â€” |
| 8 | 2025_01_01_000001_create_service_types_table | â€” |
| 8 | 2025_01_10_000001_create_wage_histories_table | â€” |
| 9 | 2025_01_04_000001_create_clients_table | Jan 4, 2026 |
| 10 | 2026_02_09_000001_add_software_fields_to_clients_table | Feb 9, 2026 |
| 11 | 2026_06_03_195000_add_employment_end_date_to_users_table | Jun 3, 2026 |

---

## Notes

- **clients** table is now live (migrated January 4, 2026, updated February 9, 2026)
- **service_types** table is seeded with 8 default service categories
- Client model includes auto-generation for account numbers (first 8 chars of company name)
- Phone numbers formatted as +1 AAA BBB CCCC
- State/province abbreviated (US states and Canadian provinces supported)
- All Spatie permission tables are properly configured
- User management system is fully functional with wage tracking
- Phase 1B added hosting/domain fields to clients table (Jan 7, 2026)
- Phase 1C added `client_software` and `software_cost` fields to clients table (Feb 9, 2026)
- Next: Phase 2 - Contract Management (contracts table, contract_service_type pivot table)

---

- Phase 2 (Jun 3, 2026): Added `employment_end_date` to users table for inactive employee tracking. Setting this date marks the user inactive and auto-closes their current wage record.

*Last SQL dump: February 9, 2026*