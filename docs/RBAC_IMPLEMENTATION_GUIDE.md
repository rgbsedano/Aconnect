# Role-Based Access Control (RBAC) Implementation Guide

## Overview
This guide walks you through implementing a complete RBAC system in your CodeIgniter 3 application using PHP 7.4+.

---

## Step 1: Run the Migrations

The migrations create the necessary database tables. Run them in order:

```bash
php index.php migrate
```

This will create:
- `roles` - Stores role definitions (admin, employer, alumni, etc.)
- `permissions` - Stores permission definitions (view_employers_page, manage_employers, etc.)
- `role_permissions` - Junction table mapping roles to permissions
- `page_visibility_settings` - Admin control to hide/show pages per role

**Note:** The migration also adds `role_id` and `is_visible` columns to your `users` table.

---

## Step 2: Seed Initial Data

Execute the SQL in [RBAC_SETUP_GUIDE.php](RBAC_SETUP_GUIDE.php):

1. Create roles (admin, employer, alumni, moderator, guest)
2. Create permissions (manage_users, view_jobs, etc.)
3. Map permissions to roles (which roles get which permissions)
4. Update existing users with role assignments

Execute in your database client (MySQL Workbench, phpMyAdmin, etc.)

---

## Step 3: Load the Auth Helper

In your **BaseController** or **MY_Controller** (if you have one):

```php
class MY_Controller extends CI_Controller {
    
    public function __construct()
    {
        parent::__construct();
        $this->load->helper('auth');  // Load auth helper globally
        $this->load->library('session');
    }
}
```

Or load it in specific controllers:

```php
public function __construct()
{
    parent::__construct();
    $this->load->helper('auth');
}
```

---

## Step 4: Protect Controllers

### Method A: Hide entire page with 404 (Recommended)

```php
class EmployersController extends CI_Controller {
    
    public function __construct()
    {
        parent::__construct();
        $this->load->helper('auth');
        
        // This makes the ENTIRE page invisible to unauthorized users
        if (!has_permission('view_employers_page')) {
            show_404();  // Shows "Page not found" error
        }
    }
    
    public function dashboard() { ... }
}
```

**Why this is best:**
- No hint that the page exists
- Completely invisible to unauthorized users
- Simple and effective

### Method B: Check per-method

```php
public function manage_employers()
{
    if (!has_permission('manage_employers')) {
        show_404();
    }
    
    // Your code here
}
```

### Method C: Redirect to dashboard

```php
public function restricted_action()
{
    if (!has_permission('delete_employers')) {
        $this->session->set_flashdata('error', 'Permission denied');
        redirect('dashboard');
    }
    
    // Your code here
}
```

---

## Step 5: Use Auth Helper Functions in Views

In your sidebar, navigation, or any template:

```php
<?php if (has_permission('view_employers_page')): ?>
    <li class="sidebar-item">
        <a href="<?php echo base_url('employers'); ?>">
            <i class="fas fa-briefcase"></i>
            <span>Employers</span>
        </a>
    </li>
<?php endif; ?>
```

### Available Functions

#### Permission Checks
```php
has_permission('view_employers_page')           // Single permission
has_any_permission(['perm1', 'perm2'])         // Has at least one
has_all_permissions(['perm1', 'perm2'])        // Has all permissions
```

#### Role Checks
```php
has_role('admin')                              // Check specific role
current_role()                                 // Get current role name
get_role_permissions()                         // Get all user permissions
```

#### Visibility Checks
```php
is_page_visible('page_slug')                   // Is page visible?
is_hidden_by_admin('page_slug')                // Is admin hiding this page?
```

---

## Step 6: Admin Control Panel (Optional)

Create an admin page to manage page visibility:

```php
class AdminVisibilityController extends CI_Controller {
    
    public function index()
    {
        if (!has_role('admin')) {
            show_404();
        }
        
        $this->load->model('Visibility_model');
        
        $data['roles'] = $this->db->get('roles')->result();
        $data['pages'] = $this->Get_pages_list();
        $data['settings'] = $this->Visibility_model->get_all_settings();
        
        $this->load->view('admin/visibility_settings', $data);
    }
    
    public function toggle_page_visibility($page_slug, $role_id, $is_visible)
    {
        if (!has_role('admin')) {
            show_404();
        }
        
        $this->db->update('page_visibility_settings', 
            ['is_visible' => (int) $is_visible],
            ['page_slug' => $page_slug, 'role_id' => $role_id]
        );
        
        redirect('admin/visibility');
    }
    
    private function get_pages_list()
    {
        return [
            ['slug' => 'employers_management', 'name' => 'Employers Management'],
            ['slug' => 'events_page', 'name' => 'Events'],
            ['slug' => 'forum_page', 'name' => 'Forum'],
            ['slug' => 'jobs_page', 'name' => 'Jobs'],
        ];
    }
}
```

---

## Common Use Cases

### 1. Hide Employers Page from Alumni

**In Controller:**
```php
class EmployersController extends CI_Controller {
    
    public function __construct()
    {
        parent::__construct();
        $this->load->helper('auth');
        
        // Only show to admin and employers
        if (!has_any_permission(['manage_employers', 'view_employers_page'])) {
            show_404();
        }
    }
}
```

**In View (Sidebar):**
```php
<?php if (has_permission('view_employers_page')): ?>
    <li><a href="<?php echo base_url('employers'); ?>">Employers</a></li>
<?php endif; ?>
```

### 2. Admin-Only Actions

```php
public function delete_employer($employer_id)
{
    if (!has_permission('delete_employers') || !has_role('admin')) {
        show_404();
    }
    
    // Delete logic
}
```

### 3. Role-Specific Dashboards

```php
<?php 
$current_role = current_role();

if ($current_role === 'admin'): ?>
    <!-- Admin dashboard -->
    <div class="admin-stats">...</div>
<?php elseif ($current_role === 'employer'): ?>
    <!-- Employer dashboard -->
    <div class="employer-stats">...</div>
<?php else: ?>
    <!-- Alumni dashboard -->
    <div class="alumni-stats">...</div>
<?php endif; ?>
```

### 4. Nested Sidebar Dropdowns

```php
<?php if (has_any_permission(['view_reports', 'export_data'])): ?>
<li class="sidebar-item">
    <a href="#" class="dropdown-toggle">Reports</a>
    <ul class="submenu">
        <?php if (has_permission('view_reports')): ?>
        <li><a href="<?php echo base_url('admin/reports'); ?>">View Reports</a></li>
        <?php endif; ?>
        
        <?php if (has_permission('export_data')): ?>
        <li><a href="<?php echo base_url('admin/export'); ?>">Export Data</a></li>
        <?php endif; ?>
    </ul>
</li>
<?php endif; ?>
```

---

## Debugging

### Check User's Permissions (in controller)

```php
$user_id = $this->session->userdata('alumni_id');
$user_permissions = get_role_permissions();
var_dump($user_permissions);  // See what permissions the user has
```

### Check Database

```sql
-- View user's role
SELECT u.id, u.email, r.role_name 
FROM users u
LEFT JOIN roles r ON u.role_id = r.role_id
WHERE u.id = 1;

-- View role's permissions
SELECT r.role_name, p.permission_slug
FROM role_permissions rp
JOIN roles r ON r.role_id = rp.role_id
JOIN permissions p ON p.permission_id = rp.permission_id
WHERE rp.role_id = 2;  -- Replace 2 with role_id
```

---

## Best Practices

1. **Always load auth helper** at the top of controllers that use it
2. **Use show_404()** for complete page invisibility
3. **Check multiple conditions** when needed:
   ```php
   if (!has_permission('view_employers') || is_hidden_by_admin('employers_page')) {
       show_404();
   }
   ```
4. **Cache permissions** in session after first check (reduces DB queries)
5. **Document permissions** in a spreadsheet for admin reference
6. **Test all roles** - Create test accounts for each role type
7. **Log access attempts** - Track who tried to access denied pages

---

## FAQ

**Q: Do I need to modify the users table?**  
A: The migration handles this automatically, but make sure your users table exists first.

**Q: Can I create dynamic permissions?**  
A: Yes, add them to the `permissions` table and map them in `role_permissions`.

**Q: How do I change a user's role?**  
A: `UPDATE users SET role_id = 2 WHERE id = 123;`

**Q: What if a user has no role?**  
A: They'll fail all permission checks. Always assign a role when creating users.

**Q: Does this work with CodeIgniter caching?**  
A: Yes, but cache busting might be needed if permissions change frequently. Consider adding a cache clear on permission updates.

---

## Files Created

- [application/migrations/004_create_rbac_tables.php](application/migrations/004_create_rbac_tables.php) - Database schema
- [application/migrations/005_create_page_visibility_settings.php](application/migrations/005_create_page_visibility_settings.php) - Visibility table
- [application/helpers/auth_helper.php](application/helpers/auth_helper.php) - Auth functions
- [application/controllers/RBAC_Controller_Example.php](application/controllers/RBAC_Controller_Example.php) - Controller examples
- [application/views/RBAC_View_Example.php](application/views/RBAC_View_Example.php) - View examples
- [RBAC_SETUP_GUIDE.php](RBAC_SETUP_GUIDE.php) - SQL seed data
