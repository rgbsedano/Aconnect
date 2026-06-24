# URGENT: Database Migration Required

## The Problem
When you tried to like/unlike a forum post, the system crashed with:
```
Error Number: 1054
Unknown column 'deleted_at' in 'field list'
UPDATE `forum_likes` SET `deleted_at` = '2026-03-31 11:38:24' WHERE ...
```

## Why It Happened
Earlier, all DELETE queries were converted to soft deletes (UPDATE with `deleted_at` timestamp). However, the database tables don't have the `deleted_at` column yet.

## What You Need to Do

### 🔴 CRITICAL: Run This SQL NOW

Open **HeidiSQL** (or phpMyAdmin) and execute this SQL:

```sql
ALTER TABLE `forum_likes` ADD COLUMN `deleted_at` TIMESTAMP NULL DEFAULT NULL AFTER `created_at`;
ALTER TABLE `forum_dislikes` ADD COLUMN `deleted_at` TIMESTAMP NULL DEFAULT NULL AFTER `created_at`;
ALTER TABLE `forum_comments` ADD COLUMN `deleted_at` TIMESTAMP NULL DEFAULT NULL AFTER `created_at`;
ALTER TABLE `forum_posts` ADD COLUMN `deleted_at` TIMESTAMP NULL DEFAULT NULL AFTER `created_at`;

-- Create indexes for performance
ALTER TABLE `forum_likes` ADD INDEX `idx_deleted_at` (`deleted_at`);
ALTER TABLE `forum_dislikes` ADD INDEX `idx_deleted_at` (`deleted_at`);
ALTER TABLE `forum_comments` ADD INDEX `idx_deleted_at` (`deleted_at`);
ALTER TABLE `forum_posts` ADD INDEX `idx_deleted_at` (`deleted_at`);
```

### Steps to Apply:

**In HeidiSQL:**
1. Click your database name on the left (aconnect_db)
2. Click `Tools` menu
3. Select `Database Editor` or use the `Query` tab (SQL icon)
4. Paste the SQL above into the editor
5. Click the green `Execute` button
6. You should see "Query OK" messages

**Verify it worked:**
```sql
DESCRIBE forum_likes;
```
You should see `deleted_at` column in the results.

---

## Files Changed

✅ **application/models/Forum_model.php**
   - Updated toggle_like() to filter deleted records
   - Updated toggle_dislike() to filter deleted records  
   - Updated count_likes() to exclude deletes
   - Updated user_liked() to exclude deletes

✅ **application/migrations/add_soft_delete_columns.sql**
   - Created migration file with all ALTER TABLE commands

✅ **Documentation created:**
   - DATABASE_MIGRATION_GUIDE.md (full technical guide)
   - FORUM_SPAM_PREVENTION.md (earlier spam prevention)

---

## After Running the Migration

Test these forum actions to confirm it works:

1. ✅ **Like a post** → Should work without errors
2. ✅ **Unlike a post** → Should work without errors
3. ✅ **Dislike a post** → Should work without errors
4. ✅ **Remove dislike** → Should work without errors
5. ✅ **Comment on post** → Should work without errors
6. ✅ **Delete comment** → Should work without errors

---

## Current Implementations

### Layer 1: Backend Rate Limiting
- 60 requests/minute per IP (all endpoints)
- Immediate 429 for bots
- Location: `application/config/rate_limiter.php`

### Layer 2: Forum Post Cooldown
- 30 seconds between posts
- Frontend countdown + backend enforcement
- Location: `application/controllers/Forum.php` 

### Layer 3: Forum Comment Cooldown  
- 10 seconds between comments
- Frontend countdown + backend enforcement
- Location: `application/controllers/Forum.php`

### Layer 4: Soft Deletes
- Soft delete instead of hard delete
- **Requires: Database migration** ← YOU ARE HERE
- Location: `application/models/Forum_model.php`

---

## Summary Table

| Feature | Status | What's Needed |
|---------|--------|---|
| Instant UX (no loading screens) | ✅ DONE | None |
| Global rate limiting (60 req/min) | ✅ DONE | None |
| Post cooldown (30 sec) | ✅ DONE | None |
| Comment cooldown (10 sec) | ✅ DONE | None |
| Soft deletes | ❌ **NEEDS DB MIGRATION** | Run SQL above |
| Spam prevention | ✅ DONE | None |

---

## Support

If you have questions or issues:

1. **Check the DATABASE_MIGRATION_GUIDE.md** for detailed instructions
2. **Check FORUM_SPAM_PREVENTION.md** for spam features
3. **Check INSTANT_UX_RATE_LIMITING.md** for rate limiting details

---

## Next Steps After Migration

1. Run the SQL migration (see above)
2. Test forum like/dislike/comment features
3. Check logs if any errors occur
4. Everything should work smoothly!

**Do not skip the migration** - forum features will crash without it.
