# Discord Logging Setup

This project uses Discord logging to track important events, including document expiry and missing document checks.

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

### 🔍 Document Check Started
- Logs when the command begins execution
- Includes timestamp, environment information, and what is being checked (expired and missing documents)

### 📧 Document Notifications Sent (when issues found)
- Lists all therapists who were notified
- Shows which documents are expired or missing for each therapist
- Includes therapist names, email addresses, and issue types
- Shows breakdown of expired vs missing document notifications
- Confirms that kellie@pineapplesupport.org is CC'd on all emails

### ✅ No Document Issues Found (when no issues)
- Confirms the command ran successfully
- Shows how many users were checked
- Indicates no expired or missing documents were found

### 🏁 Document Check Completed
- Logs when the command finishes
- Summarizes total users checked, expired notifications sent, missing notifications sent, and total notifications

## Required Documents Checked

The command checks for the following required documents:

### Documents with Expiration Dates:
- **Clinical License** - Must be current and not expired
- **Photographic ID** - Must be current and not expired  
- **Public Liability Insurance** - Must be current and not expired

### Documents without Expiration Dates:
- **Headshot** - Must be uploaded (no expiration check)
- **W9 or W8BEN** - Tax documents, must be uploaded (no expiration check)

## Email Notifications

The system sends two types of email notifications:

### DocumentsExpired
- Sent when uploaded documents have passed their expiration date
- CC's kellie@pineapplesupport.org
- Directs users to update expired documents

### DocumentsMissing  
- Sent when required documents have never been uploaded
- CC's kellie@pineapplesupport.org
- Directs users to upload missing documents

## Webhook Security

- Keep your webhook URL secure and do not commit it to version control
- The webhook URL should only be added to your production `.env` file
- Consider using Discord webhook rate limiting if running frequently
