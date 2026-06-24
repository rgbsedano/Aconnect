# Employer Grouping System Implementation Guide

## Overview
This system allows employers to be organized into groups. Employers in the same group can see each other's job postings, while employers in different groups cannot see each other's jobs.

## Database Schema

### employer_groups Table
```sql
CREATE TABLE employer_groups (
    id INT PRIMARY KEY AUTO_INCREMENT,
    group_name VARCHAR(150) UNIQUE NOT NULL,
    description TEXT,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
);
```

### employer_group_assignments Table
```sql
CREATE TABLE employer_group_assignments (
    id INT PRIMARY KEY AUTO_INCREMENT,
    employer_id INT NOT NULL,
    group_id INT NOT NULL,
    assigned_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    UNIQUE KEY unique_employer_group (employer_id, group_id),
    FOREIGN KEY (employer_id) REFERENCES employers(id) ON DELETE CASCADE,
    FOREIGN KEY (group_id) REFERENCES employer_groups(id) ON DELETE CASCADE
);
```

## Implementation Details

### Step 1: Create Database Tables
Run the SQL migration script:
```bash
d:\xamp1\htdocs\Aconnect_ci3\create_employer_groups_table.sql
```

Or navigate to the admin panel and run:
```
/adminpagevisibility/manage_groups
```

### Step 2: Admin Interface - Manage Groups
**URL**: `/adminpagevisibility/manage_groups`

**Features**:
- View all employer groups
- Create new groups with optional descriptions
- Edit group membership (add/remove employers)
- Delete groups (removes all assignments)
- View count of employers in each group

**Available Methods**:
- `manage_groups()` - Display groups management interface
- `create_group()` - AJAX endpoint to create a new group
- `delete_group()` - AJAX endpoint to delete a group
- `get_group_employers()` - AJAX endpoint to get employers in a group
- `add_employer_to_group()` - AJAX endpoint to add employer to group
- `remove_employer_from_group()` - AJAX endpoint to remove employer from group

### Step 3: Model Methods - Rbac_model.php

#### Group Management Methods
```php
// Get all employer groups
get_all_employer_groups() → array

// Get specific group by ID
get_employer_group($group_id) → object|NULL

// Create new group
create_employer_group($group_name, $description) → int (group_id)

// Update group
update_employer_group($group_id, $data) → bool

// Delete group
delete_employer_group($group_id) → bool
```

#### Employer-Group Assignment Methods
```php
// Get employers in a group
get_employers_in_group($group_id) → array of employers

// Get groups for an employer
get_employer_groups_for_employer($employer_id) → array of groups

// Assign employer to group
assign_employer_to_group($employer_id, $group_id) → bool

// Remove employer from group
remove_employer_from_group($employer_id, $group_id) → bool

// Check if employer is in group
is_employer_in_group($employer_id, $group_id) → bool

// Get employers NOT in a group (for UI dropdowns)
get_employers_not_in_group($group_id) → array of employers
```

#### Job Visibility Methods
```php
// Get visible employer IDs for an employer
// Returns: own ID + all employers in same group(s)
get_visible_employer_ids($employer_id) → array of IDs
```

### Step 4: Job Model Integration

**New Method in Job_model.php**:
```php
// Get jobs visible to an employer
get_jobs_for_employer($employer_id) → array of jobs
```

This method:
1. Gets the employer's group(s) via Rbac_model
2. Gets all employers in those group(s)
3. Returns jobs from those employers

**Usage Example**:
```php
// In controller when employer is viewing jobs
$employer_id = $this->session->userdata('employer_id');
$jobs = $this->Job_model->get_jobs_for_employer($employer_id);
```

## How It Works

### Scenario: Three Employers in System

**Setup**:
- Employer A (ID: 1) - in Group 1
- Employer B (ID: 2) - in Group 1
- Employer C (ID: 3) - in Group 2

**Job Posting Visibility**:

| Posting by | A sees | B sees | C sees |
|-----------|--------|--------|--------|
| Employer A | ✓ | ✓ | ✗ |
| Employer B | ✓ | ✓ | ✗ |
| Employer C | ✗ | ✗ | ✓ |

**Logic**:
- When **Employer A** views jobs:
  - Visible IDs = [1] (A's ID) + [1, 2] (all in same groups) = [1, 2]
  - Shows: Jobs from A and B ✓
  
- When **Employer C** views jobs:
  - Visible IDs = [3] (C's ID) + [3] (all in same groups) = [3]
  - Shows: Jobs from C only ✓

### Ungrouped Employers

An employer not in ANY group:
- `get_visible_employer_ids()` returns only their own ID
- They can only see their own jobs
- Other employers cannot see their jobs

## Implementation Checklist

- [x] Create `employer_groups` table
- [x] Create `employer_group_assignments` table
- [x] Add model methods in Rbac_model
- [x] Add controller methods in AdminPageVisibility
- [x] Create manage_employer_groups view
- [x] Add Job_model integration method
- [ ] Update employer job posting controller to use group filtering
- [ ] Update employer job browsing feature to use group filtering
- [ ] Test employer can see group jobs
- [ ] Test employer cannot see non-group jobs

## Files Modified/Created

### New Files:
- `create_employer_groups_table.sql` - Database migration script
- `application/views/admin/manage_employer_groups.php` - Admin UI for group management

### Modified Files:
- `application/models/Rbac_model.php` - Added ~13 new group management methods
- `application/controllers/AdminPageVisibility.php` - Added ~6 new controller methods
- `application/models/Job_model.php` - Added `get_jobs_for_employer()` method

## Usage Examples

### Admin Creating a Group
```javascript
// Via admin panel at /adminpagevisibility/manage_groups
// 1. Click "New Group"
// 2. Enter group name: "Tech Companies"
// 3. Enter description: "Technology and software companies"
// 4. Click Create Group
```

### Admin Adding Employers to a Group
```javascript
// Via admin panel at /adminpagevisibility/manage_groups
// 1. Find the group card
// 2. Click "Manage"
// 3. Select employer from dropdown
// 4. Click "Add to Group"
// 5. Employer now appears in "Employers in Group" list
```

### Employer Viewing Group Jobs
```php
// In Employer Job Controller
$this->load->model('user/Job_model');
$employer_id = $this->session->userdata('employer_id');

// Get only jobs visible to this employer
$jobs = $this->Job_model->get_jobs_for_employer($employer_id);

// Use $jobs in view to display job listings
```

## API Endpoints

### Admin Group Management
```
POST /adminpagevisibility/create_group
  - group_name (required)
  - description (optional)

POST /adminpagevisibility/delete_group
  - group_id (required)

GET /adminpagevisibility/get_group_employers
  - group_id (required)
  - Returns: employers in group + available employers

POST /adminpagevisibility/add_employer_to_group
  - employer_id (required)
  - group_id (required)

POST /adminpagevisibility/remove_employer_from_group
  - employer_id (required)
  - group_id (required)
```

## Security Considerations

1. **Admin-Only Access**: All group management endpoints check for administrator role
2. **Authentication**: Session-based checks (`login_status` verification)
3. **Database Constraints**: Unique constraints on employer_id + group_id combinations
4. **Cascading Deletes**: Deleting a group automatically removes all assignments
5. **Input Validation**: All endpoints validate required parameters

## Testing Checklist

- [ ] Can create a group successfully
- [ ] Can add employer to group
- [ ] Can remove employer from group
- [ ] Can delete a group (and it cascades properly)
- [ ] Employer in Group A can only see Group A's jobs
- [ ] Employer in Group A cannot see Group B's jobs
- [ ] Ungrouped employer can only see their own jobs
- [ ] Admin can view all employers and their group assignments
- [ ] UI displays correct employer count per group
- [ ] Modal forms validate required fields

## Next Steps

1. **Run the migration script** to create tables:
   - Execute `create_employer_groups_table.sql` in phpMyAdmin or CLI

2. **Access the admin panel**:
   - Go to `/adminpagevisibility/manage_groups`

3. **Create your first group**:
   - Click "New Group"
   - Add employers to the group

4. **Update employer job views** to filter by group:
   - Modify job listing controllers to use `$this->Job_model->get_jobs_for_employer($employer_id)`

5. **Test the system**:
   - Create groups and assign employers
   - Log in as different employers and verify job visibility
