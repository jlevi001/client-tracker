# Client Management Development Plan

## 📋 Project Overview
The Client Management system is a comprehensive module for the Lingo Client Tracker that manages client information, contracts, tasks, and work logging with full audit capabilities.

**Created**: January 2025  
**Status**: 🚧 In Development  
**Priority**: High  

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

### Tables Required

#### 1. `clients` Table
```sql
- id (bigint, primary)
- company_name (string, required, unique)
- account_number (string, auto-generated, unique, indexed)
- primary_contact_first_name (string, required)
- primary_contact_last_name (string, required)
- primary_contact_phone (string, nullable)
- primary_contact_email (string, required)
- secondary_contact_first_name (string, nullable)
- secondary_contact_last_name (string, nullable)
- secondary_contact_phone (string, nullable)
- secondary_contact_email (string, nullable)
- website_url (string, nullable)
- address (text, nullable)
- notes (text, nullable)
- created_at (timestamp)
- updated_at (timestamp)
- deleted_at (timestamp, soft deletes)
```

#### 2. `contracts` Table
```sql
- id (bigint, primary)
- client_id (foreign key -> clients.id, cascade delete)
- contract_number (string, unique)
- contract_file_path (string, nullable)
- allocated_hours (decimal 8,2)
- start_date (date, required)
- end_date (date, nullable)
- status (enum: 'active', 'inactive', 'expired')
- manually_inactivated (boolean, default false)
- inactivated_reason (string, nullable)
- created_at (timestamp)
- updated_at (timestamp)
- deleted_at (timestamp, soft deletes)
```

#### 3. `contract_tasks` Table
```sql
- id (bigint, primary)
- contract_id (foreign key -> contracts.id, cascade delete)
- task_name (string, required)
- description (text, nullable)
- assigned_admin_id (foreign key -> users.id, nullable)
- status (enum: 'pending', 'in_progress', 'completed')
- priority (enum: 'low', 'medium', 'high')
- due_date (date, nullable)
- created_at (timestamp)
- updated_at (timestamp)
```

#### 4. `work_logs` Table
```sql
- id (bigint, primary)
- contract_id (foreign key -> contracts.id)
- employee_id (foreign key -> users.id)
- task_id (foreign key -> contract_tasks.id, nullable)
- work_date (date, required)
- start_time (time, required)
- end_time (time, required)
- hours_worked (decimal 5,2, calculated)
- description (text, required)
- status (enum: 'pending', 'approved', 'rejected')
- reviewed_by (foreign key -> users.id, nullable)
- reviewed_at (timestamp, nullable)
- rejection_reason (text, nullable)
- created_at (timestamp)
- updated_at (timestamp)
```

#### 5. `work_log_edits` Table (Audit Trail)
```sql
- id (bigint, primary)
- work_log_id (foreign key -> work_logs.id)
- edited_by (foreign key -> users.id)
- edit_reason (text, required)
- original_data (json)
- new_data (json)
- created_at (timestamp)
```

---

## 🚀 Development Phases

### Phase 1: Database Foundation ⏳
- [ ] Create migration for `clients` table
- [ ] Create migration for `contracts` table
- [ ] Create migration for `contract_tasks` table
- [ ] Create migration for `work_logs` table
- [ ] Create migration for `work_log_edits` table
- [ ] Run migrations and verify structure
- [ ] Create Client model with relationships
- [ ] Create Contract model with relationships
- [ ] Create ContractTask model
- [ ] Create WorkLog model
- [ ] Create WorkLogEdit model
- [ ] Set up model factories for testing
- [ ] Create database seeders with sample data

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
  - [ ] Account # display
- [ ] Create client form modal
  - [ ] Company name field
  - [ ] Auto-generate account # from company name
  - [ ] Primary contact section
  - [ ] Secondary contact section (collapsible)
  - [ ] Website URL field
  - [ ] Address field
  - [ ] Notes textarea
- [ ] Implement create client functionality
  - [ ] Form validation
  - [ ] Success/error messages
  - [ ] Real-time validation
- [ ] Implement edit client functionality
  - [ ] Pre-populate form
  - [ ] Update validation
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
  - [ ] Allocated hours display
  - [ ] Date range display
- [ ] Create contract form modal
  - [ ] Contract number (auto-generated?)
  - [ ] Start/end date pickers
  - [ ] Allocated hours input
  - [ ] File upload for contract document
- [ ] Implement file upload functionality
  - [ ] Create directory structure `/storage/clients/contracts/{client-name}/`
  - [ ] File validation (PDF, DOC, DOCX)
  - [ ] File size limits
  - [ ] Secure file storage
- [ ] Implement contract status management
  - [ ] Auto-expire based on end date (cron job?)
  - [ ] Manual status toggle with reason
  - [ ] Status change logging
- [ ] Contract download functionality
- [ ] Contract deletion (with confirmation)

### Phase 5: Task Management ⏳
- [ ] Create Livewire component `TaskManagement`
- [ ] Add tasks section to contract view
- [ ] Implement task CRUD
  - [ ] Task creation form
  - [ ] Admin assignment dropdown (filtered by role)
  - [ ] Priority setting
  - [ ] Due date picker
- [ ] Task status management
  - [ ] Status workflow (pending → in_progress → completed)
  - [ ] Quick status toggle buttons
- [ ] Task assignment notifications (if applicable)
- [ ] Task filtering/sorting within contract

### Phase 6: Work Log System ⏳
- [ ] Create Livewire component `WorkLogEntry`
- [ ] Create work log entry form
  - [ ] Date/time pickers
  - [ ] Contract selection (filtered by active)
  - [ ] Task selection (optional, filtered by contract)
  - [ ] Description field
  - [ ] Hours auto-calculation
- [ ] Employee work log view
  - [ ] List own work logs
  - [ ] Status indicators
  - [ ] Edit pending entries only
- [ ] Implement time overlap validation
- [ ] Add work log to contract detail view
  - [ ] Chronological list
  - [ ] Filter by employee
  - [ ] Filter by date range

### Phase 7: Admin Work Log Management ⏳
- [ ] Create Livewire component `WorkLogAdmin`
- [ ] Create admin review interface
  - [ ] Pending logs queue
  - [ ] Bulk approval options
  - [ ] Individual review modal
- [ ] Implement approval workflow
  - [ ] Approve with optional note
  - [ ] Reject with required reason
  - [ ] Email notifications (optional)
- [ ] Create edit interface for approved logs
  - [ ] Edit modal with reason field
  - [ ] Original vs new comparison
  - [ ] Audit trail creation
- [ ] Work log audit trail view
  - [ ] Show all edits
  - [ ] Show who/when/why
  - [ ] Original vs modified data

### Phase 8: Reporting & Analytics ⏳
- [ ] Hours tracking dashboard
  - [ ] Used vs allocated hours per contract
  - [ ] Visual progress bars
  - [ ] Alerts for overages
- [ ] Client summary cards
  - [ ] Active contracts count
  - [ ] Total hours this month
  - [ ] Pending work logs
- [ ] Export functionality
  - [ ] Work logs to CSV/Excel
  - [ ] Client list export
  - [ ] Contract summary export

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
  - [ ] Work log tests
  - [ ] Permission tests
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

### Standard Form Modal Pattern
```blade
<div class="modal @if($showModal) modal-open @endif">
    <div class="modal-box max-w-3xl">
        <h3 class="font-bold text-lg">{{ $modalTitle }}</h3>
        
        <form wire:submit.prevent="save">
            <!-- Form fields using x-form-control -->
            
            <div class="modal-action">
                <button type="button" 
                        class="btn btn-ghost" 
                        wire:click="closeModal">
                    Cancel
                </button>
                <button type="submit" 
                        class="btn btn-primary"
                        wire:loading.attr="disabled">
                    <span wire:loading.remove>Save</span>
                    <span wire:loading>
                        <span class="loading loading-spinner loading-sm"></span>
                        Saving...
                    </span>
                </button>
            </div>
        </form>
    </div>
    <form method="dialog" class="modal-backdrop">
        <button wire:click="closeModal">close</button>
    </form>
</div>
```

---

## 📝 Account Number Generation Logic

The account number should be generated from the company name following these rules:
1. Take the first letter of each word in the company name
2. Convert to uppercase
3. Remove spaces and special characters
4. If less than 3 characters, pad with company name letters
5. Add a numeric suffix if duplicate exists

**Examples:**
- "Lingo Technologies LLC" → "LTL"
- "ABC Corp" → "ABC"
- "The Widget Company" → "TWC"
- "IBM" → "IBM"
- "A1 Services" → "A1S"

---

## 🔒 Permission Requirements

### Role-Based Access
- **Admin**: Full access to all features
- **Manager**: View all, edit work logs, manage tasks
- **Employee**: Create/edit own work logs, view assigned tasks

### Specific Permissions
```php
// Permissions to create
'view-clients'
'create-clients'
'edit-clients'
'delete-clients'
'manage-contracts'
'upload-contracts'
'manage-tasks'
'create-work-logs'
'approve-work-logs'
'edit-all-work-logs'
'view-reports'
'export-data'
```

---

## 🚦 Status Workflows

### Contract Status
```
active → expired (automatic based on end_date)
active → inactive (manual with reason)
inactive → active (manual reactivation)
```

### Work Log Status
```
pending → approved (by admin/manager)
pending → rejected (by admin/manager with reason)
approved → edited (by admin only with reason)
```

### Task Status
```
pending → in_progress → completed
(any status can go back to any other status)
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
- [ ] Contracts upload and store properly
- [ ] Work logs calculate hours correctly
- [ ] Status changes trigger appropriately
- [ ] Permissions restrict access properly

### UI/UX Testing
- [ ] All forms validate in real-time
- [ ] Loading states appear during operations
- [ ] Error messages are user-friendly
- [ ] Mobile layout works at 375px
- [ ] Tablet layout works at 768px
- [ ] Desktop layout works at 1024px+
- [ ] Dark theme is consistent throughout

### Edge Cases
- [ ] Duplicate account numbers handled
- [ ] Large file uploads handled gracefully
- [ ] Overlapping work logs prevented
- [ ] Expired contracts auto-update
- [ ] Soft deletes cascade properly
- [ ] Time zone handling is correct

---

## 🎯 Success Criteria

The Client Management module will be considered complete when:

1. ✅ All database tables are created and properly related
2. ✅ Full CRUD operations work for clients
3. ✅ Contract upload and management is functional
4. ✅ Task assignment and tracking works
5. ✅ Work log entry and approval system is complete
6. ✅ All audit trails are properly logged
7. ✅ Mobile responsive design is verified
8. ✅ Dark theme is consistent throughout
9. ✅ All permissions are properly enforced
10. ✅ Feature and unit tests pass

---

## 📚 Reference Documents

- **AI Instructions**: `/docs/ai-instructions.md`
- **daisyUI Conversion Guide**: `/docs/DAISYUI_CONVERSION_GUIDE.md`
- **Component Reference**: `/resources/views/components/COMPONENT_REFERENCE.md`
- **User Management Reference**: `/resources/views/livewire/user-management.blade.php`

---

## 🔄 Version History

| Date | Version | Changes | Author |
|------|---------|---------|--------|
| Jan 2025 | 1.0.0 | Initial development plan created | System |

---

## 📌 Notes & Decisions

**Important Decisions:**
- Account numbers will be auto-generated and unique
- Contracts will be soft-deleted to maintain history
- Work logs require admin approval by default
- All timestamps will use the application's timezone setting
- File uploads limited to 10MB per contract

**Technical Considerations:**
- Use Livewire for all interactive components
- Implement eager loading to prevent N+1 queries
- Use database transactions for critical operations
- Consider implementing caching for report data
- Add indices on frequently queried columns

---

**Status Legend:**
- ⏳ Pending
- 🚧 In Progress
- ✅ Complete
- 🔴 Blocked
- 🔄 Needs Review

---

*This document should be updated as development progresses. Check off completed items and add notes about any deviations from the plan.*
