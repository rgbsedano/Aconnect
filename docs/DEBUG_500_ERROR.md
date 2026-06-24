# Debugging "Unable to load AI analysis" 500 Error

## Issue Summary
When clicking a job's match percentage badge, the modal shows "Unable to load AI analysis" error. Browser console shows `jobs/get_match_explanation/{id}` returns HTTP 500.

## Root Cause Analysis
The 500 error likely stems from:
1. **PHP errors/warnings** corrupting JSON output
2. **Config file loading issues** with Gemini API key
3. **Object serialization issues** when debug logging
4. **Database query failures** not caught in try-catch

## Testing Strategy

### Step 1: Test Basic JSON Response (SAFE)
Navigate to: `http://localhost/Aconnect_ci3/index.php/jobs/test_json_response`

**Expected Output:**
```json
{
  "status": "success",
  "message": "JSON response test working",
  "timestamp": "2026-03-27 10:50:00"
}
```

**If this works:** JSON response pipe is functional
**If you see a 500 error:** Problem is with output system or PHP config

### Step 2: Examine PHP Error Logs
Check for PHP error logs in:
- **XAMPP:** `C:\xampp\apache\logs\error.log`
- **Browser:** F12 → Network tab → click `get_match_explanation/X` → Response tab

**Look for:**
- Parse errors in config/gemini.php
- Uncaught exceptions in ai_helper.php
- Database connection issues

### Step 3: Check Debug Log
View the debug output:
```
d:\xamp1\htdocs\Aconnect_ci3\application\logs\cache_insert.log
```

**Expected logs when clicking match percentage:**
```
[2026-03-27 10:50:10] CONTROLLER: Alumni ID from session: 50
[2026-03-27 10:50:10] CONTROLLER: Alumni loaded: 50, Job loaded: 18
[2026-03-27 10:50:10] CONTROLLER: Match computed: 75%
[2026-03-27 10:50:10] CONTROLLER: Insight type: array, is_array: YES
[2026-03-27 10:50:10] CONTROLLER: Returning insight as JSON
```

### Step 4: Manual Database Test
Run this SQL to verify cache tables exist:
```sql
SELECT * FROM ai_explanation_cache LIMIT 5;
SELECT * FROM ai_match_cache LIMIT 5;
```

### Step 5: Test Fallback Response
If issues persist, add this temporary test code to `Jobs.php` `get_match_explanation()`:

```php
// TEMPORARY DEBUG: Test basic response
if ($_GET['debug'] === 'test') {
    $this->output->set_output(json_encode([
        'percentage' => 75,
        'status' => 'Test Match',
        'strengths' => ['Test strength'],
        'gaps' => [],
        'summary' => 'This is a test response'
    ]));
    return;
}
```

Then test: `GET /jobs/get_match_explanation/18?debug=test`

## Quick Fixes to Try

### Fix 1: Disable Object Logging
The issue might be that job/alumni objects contain non-serializable data. The fix has already been applied to remove `json_encode()` calls on the objects. If 500 error still occurs after this fix, the problem is elsewhere.

### Fix 2: Ensure Error Reporting is Configured
Add to `application/config/config.php`:
```php
ini_set('display_errors', '0');
error_reporting(E_ALL);
```

This prevents PHP errors from corrupting JSON output.

### Fix 3: Check Gemini Config
Verify `application/config/gemini.php` has:
```php
$config['gemini_api_key'] = getenv('GEMINI_API_KEY') ?: 'YOUR_API_KEY_HERE';
```

The API key should not be empty.

## Complete Log Analysis Reference

### Successful Response Log Pattern:
```
[2026-03-27 10:50:10] CONTROLLER: Alumni ID from session: 50
[2026-03-27 10:50:10] CONTROLLER: Alumni loaded: 50, Job loaded: 18
[2026-03-27 10:50:10] CONTROLLER: Match computed: 75%
===== get_detailed_match_insight() CALLED =====
[2026-03-27 10:50:10] Extracted IDs: Alumni=50, Job=18, Score=75
[2026-03-27 10:50:10] Checking cache for Alumni=50, Job=18
[2026-03-27 10:50:10] ✅ CACHE HIT! Returning cached data
[2026-03-27 10:50:10] CONTROLLER: Insight type: array, is_array: YES
[2026-03-27 10:50:10] CONTROLLER: Returning insight as JSON
```

### Error Log Pattern to Look For:
```
[2026-03-27 10:50:10] CONTROLLER EXCEPTION: <error message>
```

This indicates the try-catch is working and should return error JSON.

## Next Steps

1. **Test Step 1:** Navigate to `jobs/test_json_response` and verify you see valid JSON
2. **Check Logs:** Click match percentage and check if new entries appear in `cache_insert.log`
3. **Check PHP Errors:** Look at XAMPP error log for any PHP parse errors
4. **Report:** Share the output of all three checks and the latest log entries
