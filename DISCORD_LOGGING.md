# Discord Logging Setup

This project uses Discord logging to track important events, including document expiry checks.

## Setting up Discord Webhook

1. **Create a Discord Webhook:**
   - Go to your Discord server
   - Navigate to Server Settings → Integrations → Webhooks
   - Click "New Webhook"
   - Choose the channel where you want notifications
   - Copy the webhook URL

2. **Configure Environment Variables:**
   Add these variables to your `.env` file:
   ```bash
   LOG_DISCORD_WEBHOOK_URL=https://discord.com/api/webhooks/YOUR_WEBHOOK_URL_HERE
   LOG_DISCORD_IGNORE_EXCEPTIONS=false
   ```

3. **Test the Setup:**
   ```bash
   php artisan app:checkandremindaboutexpireddocuments
   ```

## Discord Log Messages

The `Checkandremindaboutexpireddocuments` command will send the following Discord notifications:

### 🔍 Document Expiry Check Started
- Logs when the command begins execution
- Includes timestamp and environment information

### 📧 Document Expiry Notifications Sent (when expired documents found)
- Lists all therapists who were notified
- Shows which documents have expired for each therapist
- Includes therapist names and email addresses

### ✅ No Expired Documents Found (when no expired documents)
- Confirms the command ran successfully
- Shows how many users were checked

### 🏁 Document Expiry Check Completed
- Logs when the command finishes
- Summarizes total users checked and notifications sent

## Webhook Security

- Keep your webhook URL secure and do not commit it to version control
- The webhook URL should only be added to your production `.env` file
- Consider using Discord webhook rate limiting if running frequently
