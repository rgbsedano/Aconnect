# Gemini AI Integration Setup Guide

This project uses Google's Gemini 2.5 Flash API for intelligent job matching between alumni profiles and job postings in CodeIgniter 3.

## Prerequisites

- PHP 7.0+ (with cURL support)
- CodeIgniter 3
- Google Account (free tier available)

## Setup Instructions

### 1. Get Your Gemini API Key

1. Visit [Google AI Studio](https://aistudio.google.com/app/apikey)
2. Click "Create API key in new project"
3. Copy your API key

### 2. Configure the API Key

**Option A: Environment Variable (Recommended for Production)**

Create a `.env` file in your project root:

```
GEMINI_API_KEY=your_api_key_here
```

Make sure your server loads environment variables (most modern PHP setups do this automatically).

**Option B: Direct Configuration (Development Only)**

Edit `application/config/gemini.php`:

```php
$config['gemini_api_key'] = 'your_api_key_here';
```

### 3. Verify Configuration

The AI helper will automatically:
- Load the Gemini config on every request
- Check for the API key in environment variables first, then the config file
- Use algorithmic fallback if API is unavailable

## How It Works

### Job Matching Flow

1. **User views jobs page** → Jobs are loaded from database
2. **Job card displayed** → `compute_ai_match($alumni, $job)` is called
3. **AI Analysis** → Gemini API compares:
   - Skills alignment
   - Experience level
   - Location preferences
   - Education/degree relevance
   - Job description fit
4. **Match Score** → Returns 0-100 percentage
5. **Fallback** → If API fails, uses algorithm-based matching

### API Response Structure

```json
{
  "match_percentage": 85,
  "reason": "Strong technical background in required skills with relevant experience"
}
```

## Files Modified

- **application/helpers/ai_helper.php** - Main AI matching logic with Gemini API integration
- **application/config/gemini.php** - Gemini API configuration
- **application/config/autoload.php** - Auto-loads gemini config and ai_helper

## Error Handling

The integration includes robust error handling:

- **API Timeout** (30 seconds) → Falls back to algorithm
- **Invalid API Key** → Logs error, uses fallback matching
- **Network Error** → Gracefully degrades to local algorithm
- **Malformed Response** → Uses fallback algorithm

All errors are logged to `application/logs/` for debugging.

## API Limits

Google's free tier includes:
- 60 requests per minute per API key
- 1,500 requests per day per API key

For production use, consider:
- Caching results to reduce API calls
- Implementing request throttling
- Upgrading to a paid plan for higher limits

## Testing

To test the integration:

```php
// In a controller
$this->load->helper('ai_helper');
$alumni = $this->db->get_where('alumni', ['id' => 1])->row();
$job = $this->db->get_where('jobs', ['id' => 1])->row();
$match = compute_ai_match($alumni, $job);
echo "Match Score: " . $match . "%";
```

## Troubleshooting

### "Unable to load the requested file: helpers/ai_helper.php"
- Ensure `ai_helper` is added to `$autoload['helper']` in `config/autoload.php`

### Low Match Scores
- Reduce fallback reliance by ensuring API key is properly configured
- Check logs for API errors

### API Errors
- Verify API key is valid at [Google AI Studio](https://aistudio.google.com/app/apikey)
- Check cURL is enabled on your server: `php -m | grep curl`
- Check your account quota hasn't been exceeded

## Security Notes

⚠️ **Never commit your API key to version control**

- Always use environment variables in production
- Use `.gitignore` to exclude `.env` files
- Rotate API keys periodically
- Monitor usage in Google Cloud Console

## Support

For issues with:
- **Gemini API** → [Google AI Documentation](https://ai.google.dev/docs)
- **CodeIgniter 3** → [CodeIgniter Documentation](https://codeigniter.com/user_guide/index.html)
- **This Integration** → Check logs and ensure proper configuration
