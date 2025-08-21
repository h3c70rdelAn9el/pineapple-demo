<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Important: Update Your Tax Documents - Address Change</title>
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
        .content { 
            margin: 20px 0;
        }
        .address-box {
            background-color: #f8f9fa;
            border: 1px solid #dee2e6;
            border-radius: 5px;
            padding: 15px;
            margin: 15px 0;
        }
        .footer { 
            margin-top: 30px; 
            padding-top: 20px; 
            border-top: 1px solid #f0f0f0; 
            font-size: 12px; 
            color: #666; 
        }
        .important {
            background-color: #fff3cd;
            border: 1px solid #ffeaa7;
            border-radius: 5px;
            padding: 15px;
            margin: 15px 0;
            color: #856404;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <h2>Important: Update Your Tax Documents</h2>
        </div>
        
        <div class="content">
            <p>Dear {{ $therapistName }},</p>

            <p>We've noticed that you recently updated your address information in your therapist profile. Thank you for keeping your information current!</p>

            <div class="address-box">
                <strong>Your updated address:</strong><br>
                {{ $newAddress }}
            </div>

            <div class="important">
                <strong>Action Required:</strong> Since your address has changed, you'll need to update your tax documents (W9 for US residents or W8BEN for non-US residents) to reflect your new address.
            </div>

            <p><strong>What you need to do:</strong></p>
            <ul>
                <li>Download a new W9 form (US residents) or W8BEN form (non-US residents)</li>
                <li>Fill it out with your new address information</li>
                <li>Upload the updated form to your therapist profile</li>
            </ul>

            <p><strong>Why is this important?</strong></p>
            <p>Updated tax documents ensure that:</p>
            <ul>
                <li>Your tax reporting is accurate and compliant</li>
                <li>Any tax forms we send you (like 1099s) are sent to the correct address</li>
                <li>There are no delays in processing your payments</li>
            </ul>

            <p><strong>Forms:</strong></p>
            <ul>
                <li><strong>US residents:</strong> Download W9 form from the IRS website</li>
                <li><strong>Non-US residents:</strong> Download W8BEN form from the IRS website</li>
            </ul>

            <p>Please update your tax documents as soon as possible. If you have any questions or need assistance, please don't hesitate to contact our support team.</p>

            <p>Thank you for your prompt attention to this matter.</p>
        </div>
        
        <div class="footer">
            <p>Best regards,<br>
            The Pineapple Support Team</p>
            <p>This is an automated message sent when your address information is updated.</p>
        </div>
    </div>
</body>
</html>
