# Soft Delete Database Migration - Fix for forum_likes Error

## Issue
```
Error Number: 1054
Unknown column 'deleted_at' in 'field list'
UPDATE `forum_likes` SET `deleted_at` = '2026-03-31 11:38:24' WHERE `post_id` = '39'
```

**Root Cause:** The code was converted to use soft deletes (UPDATE with deleted_at), but the database tables didn't have the `deleted_at` column.

---

## Solution

### Step 1: Apply the SQL Migration

Run this SQL in your database manager (HeidiSQL, phpMyAdmin, etc.):

```sql
-- Add deleted_at column to forum_likes table
ALTER TABLE `forum_likes` ADD COLUMN `deleted_at` TIMESTAMP NULL DEFAULT NULL AFTER `created_at`;

-- Add deleted_at column to forum_dislikes table
ALTER TABLE `forum_dislikes` ADD COLUMN `deleted_at` TIMESTAMP NULL DEFAULT NULL AFTER `created_at`;

-- Add deleted_at column to forum_comments table
ALTER TABLE `forum_comments` ADD COLUMN `deleted_at` TIMESTAMP NULL DEFAULT NULL AFTER `created_at`;

-- Add deleted_at column to forum_posts table
ALTER TABLE `forum_posts` ADD COLUMN `deleted_at` TIMESTAMP NULL DEFAULT NULL AFTER `created_at`;

-- Create indexes for better query performance
ALTER TABLE `forum_likes` ADD INDEX `idx_deleted_at` (`deleted_at`);
ALTER TABLE `forum_dislikes` ADD INDEX `idx_deleted_at` (`deleted_at`);
ALTER TABLE `forum_comments` ADD INDEX `idx_deleted_at` (`deleted_at`);
ALTER TABLE `forum_posts` ADD INDEX `idx_deleted_at` (`deleted_at`);
```

**File Location:** `application/migrations/add_soft_delete_columns.sql`

---

### Step 2: Verify Columns Were Added

Run these verification queries:

```sql
DESCRIBE forum_likes;
DESCRIBE forum_dislikes;
DESCRIBE forum_comments;
DESCRIBE forum_posts;
```

You should see `deleted_at` column with type `TIMESTAMP` and default `NULL`.

---

### Step 3: Updated Code Changes

The following files have been updated to properly handle soft deletes:

#### File: `application/models/Forum_model.php`

**Changes Made:**
1. `toggle_like()` - Now excludes soft-deleted likes when toggling
2. `toggle_dislike()` - Now excludes soft-deleted dislikes when toggling  
3. `count_likes()` - Now only counts non-deleted likes
4. `user_liked()` - Now only checks non-deleted likes

**Key Addition:** Added `WHERE deleted_at IS NULL` clauses to all queries

**Example:**
```php
// Before:
$like = $this->db->where('post_id',$post_id)
                   ->where('alumni_id',$alumni_id)
                   ->get('forum_likes')->row();

// After:
$like = $this->db->where('post_id',$post_id)
                   ->where('alumni_id',$alumni_id)
                   ->where('deleted_at IS NULL', NULL, FALSE)  // ← Added
                   ->get('forum_likes')->row();
```

---

## Soft Delete Behavior

### What is a Soft Delete?
Instead of permanently deleting records, soft deletes mark records as deleted using a timestamp:

```sql
-- Hard Delete (permanent)
DELETE FROM forum_likes WHERE id = 1;

-- Soft Delete (recoverable)
UPDATE forum_likes SET deleted_at = '2026-03-31 11:38:24' WHERE id = 1;
```

### Benefits
✅ **Recoverable** - Can restore deleted data if needed
✅ **Auditable** - Track when things were deleted
✅ **Historical** - Keep records for reporting
✅ **Safe** - Mistakes can be undone

### Querying with Soft Deletes
```sql
-- Only show non-deleted records
SELECT * FROM forum_likes WHERE deleted_at IS NULL;

-- Only show deleted records
SELECT * FROM forum_likes WHERE deleted_at IS NOT NULL;

-- Show all records (including deleted)
SELECT * FROM forum_likes;  -- No WHERE clause
```

---

## Tables Updated

| Table | Columns Added | Purpose |
|-------|--|---|
| `forum_likes` | `deleted_at` | Track when likes are removed |
| `forum_dislikes` | `deleted_at` | Track when dislikes are removed |
| `forum_comments` | `deleted_at` | Track when comments are deleted |
| `forum_posts` | `deleted_at` | Track when posts are deleted |

---

## How to Apply the Migration

### Option 1: HeidiSQL (Recommended)
1. Open HeidiSQL
2. Connect to your database
3. Click `Tools` → `Database Editor` or `Query` tab
4. Copy and paste the SQL from the migration file
5. Click `Execute`
6. Verify columns were added

### Option 2: phpMyAdmin
1. Open phpMyAdmin
2. Select your database (`aconnect_db`)
3. Go to `SQL` tab
4. Paste the SQL commands
5. Click `Go`
6. Check the tables for new columns

### Option 3: Command Line
```bash
mysql -h localhost -u root -p aconnect_db < application/migrations/add_soft_delete_columns.sql
```

---

## Testing the Fix

### Test 1: Like a Forum Post
1. Open forum
2. Click like on a post
3. ✅ Should work without "Unknown column" error
4. Click like again to unlike
5. ✅ Should update `deleted_at` without error

### Test 2: Dislike a Forum Post
1. Open forum post
2. Click dislike button
3. ✅ Should work without error
4. Click dislike again to remove
5. ✅ Should soft delete without error

### Test 3: Comment on Post
1. Open forum post
2. Add a comment
3. ✅ Should work normally
4. Delete comment
5. ✅ Should soft delete (not hard delete)

---

## Troubleshooting

### Error: "Table 'X' has no column named 'deleted_at'"
**Solution:** Run the ALTER TABLE commands again and verify the columns exist

### Error: "Duplicate key name 'idx_deleted_at'"
**Solution:** The index already exists. Skip that ALTER TABLE command.

### Likes/Dislikes Still Showing After Deletion
**Solution:** Check if the WHERE clause is working: Run this query:
```sql
SELECT * FROM forum_likes WHERE deleted_at IS NULL;
```
If you still see deleted items, they may not have been soft deleted. Run:
```sql
UPDATE forum_likes SET deleted_at = NOW() WHERE id = XX;
```

### Performance Issue After Migration
**Solution:** If queries are slow, ensure indexes were created:
```sql
CREATE INDEX idx_deleted_at ON forum_likes(deleted_at);
CREATE INDEX idx_deleted_at ON forum_dislikes(deleted_at);
CREATE INDEX idx_deleted_at ON forum_comments(deleted_at);
CREATE INDEX idx_deleted_at ON forum_posts(deleted_at);
```

---

## Code Changes Summary

### `application/models/Forum_model.php`

**Method: `toggle_like()`**
- ✅ Added `->where('deleted_at IS NULL', NULL, FALSE)` before getting likes
- ✅ Fixed table name from `forum_dislike` to `forum_dislikes`

**Method: `toggle_dislike()`**
- ✅ Added `->where('deleted_at IS NULL', NULL, FALSE)` before getting dislikes
- ✅ Fixed table name from `forum_dislike` to `forum_dislikes`

**Method: `count_likes()`**
- ✅ Added `->where('deleted_at IS NULL', NULL, FALSE)` to exclude deleted likes

**Method: `user_liked()`**
- ✅ Added `->where('deleted_at IS NULL', NULL, FALSE)` to exclude deleted likes

---

## Next Steps

1. **Apply the SQL migration** using one of the options above
2. **Verify columns exist** by running DESCRIBE commands
3. **Test forum interactions** (like, dislike, comment)
4. **Monitor logs** for any additional soft-delete issues
5. **Optional:** Create an admin view to show soft-deleted records

---

## Quick Reference

### Running the Migration in HeidiSQL:
```
1. Tools → Database Editor (or Query tab)
2. Paste the SQL from add_soft_delete_columns.sql
3. Click Execute
4. Check the status = "X rows affected"
```

### Verify Success:
```sql
-- Check forum_likes has deleted_at column
SHOW COLUMNS FROM forum_likes LIKE 'deleted_at';
-- Returns: deleted_at | timestamp | YES | | NULL |
```

---

**Status: Ready to deploy** ✅

Make sure the database migration is applied before testing forum Like/Dislike functionality.
