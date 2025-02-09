<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Contact Reply</title>
</head>

<body style="font-family: Arial, sans-serif; background-color: #f4f4f4; padding: 20px;">

    <table style="max-width: 600px; background-color: #ffffff; margin: 0 auto; padding: 20px; border-radius: 8px;">
        <tr>
            <td align="center">
                <h2 style="color: #333;">Response to Your Inquiry</h2>
                <p>Dear {{ $contact->name }},</p>
                <p>Thank you for reaching out to us. Below is our response to your inquiry:</p>

                <blockquote style="background-color: #f9f9f9; padding: 15px; border-left: 5px solid #007bff;">
                    <strong>Subject:</strong> {{ $contact->subject }} <br>
                    <strong>Your Message:</strong> {{ $contact->message }}
                </blockquote>

                <h3>Our Response:</h3>
                <p style="background-color: #f1f1f1; padding: 15px; border-radius: 5px;">
                    {{ $replyMessage }}
                </p>

                <p>If you have any further questions, feel free to reply to this email.</p>
                <p>Best regards,</p>
                <p><strong>{{ app_setting('site_name') }}</strong><br>
                    Customer Support Team<br>
                    <a href="mailto:{{ app_setting('contact_email') }}">{{ app_setting('contact_email') }}</a>
                </p>
            </td>
        </tr>
    </table>

</body>

</html>
