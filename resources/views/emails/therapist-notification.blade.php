<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>{{ $subject }}</title>
    <style>
        body { 
            font-family: Arial, sans-serif; 
            line-height: 1.6; 
            color: #333; 
            margin: 0;
            padding: 0;
        }
        .container { 
            max-width: 600px; 
            margin: 0 auto; 
            padding: 20px; 
        }
        .header { 
            border-bottom: 2px solid #f0f0f0; 
            padding-bottom: 20px; 
            margin-bottom: 20px; 
        }
        .messagebody { 
            white-space: pre-line; 
            margin: 20px 0;
        }
        .footer { 
            margin-top: 30px; 
            padding-top: 20px; 
            border-top: 1px solid #f0f0f0; 
            font-size: 12px; 
            color: #666; 
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <h2>Message from Pineapple Support</h2>
        </div>
        
        <p>Dear {{ $therapist->name }},</p>

        <div class="messagebody">
            {{ $messagebody }}
        </div>
        
        <div class="footer">
            <p>Best regards,<br>
            Pineapple Support Team</p>
            <p>This email was sent from the Pineapple Support admin portal.</p>
        </div>
    </div>
</body>
</html>
