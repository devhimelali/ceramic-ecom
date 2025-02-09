<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Contact Us Acknowledgment</title>
</head>

<body style="font-family: Arial, sans-serif; background-color: #f4f4f4; padding: 20px;">

    <table style="max-width: 600px; background-color: #ffffff; margin: 0 auto; padding: 20px; border-radius: 8px;">
        <tr>
            <td align="center">
                <h2 style="color: #333;">Thank You for Contacting Us</h2>
                <p>Dear {{ $contact->name }},</p>
                <p>We have received your message and will get back to you as soon as possible.</p>

                <h3>Your Submitted Details:</h3>
                <table style="width: 100%; border-collapse: collapse;">
                    <tr>
                        <td style="border-bottom: 1px solid #ddd; padding: 8px;"><strong>Name:</strong></td>
                        <td style="border-bottom: 1px solid #ddd; padding: 8px;">{{ $contact->name }}</td>
                    </tr>
                    <tr>
                        <td style="border-bottom: 1px solid #ddd; padding: 8px;"><strong>Email:</strong></td>
                        <td style="border-bottom: 1px solid #ddd; padding: 8px;">{{ $contact->email }}</td>
                    </tr>
                    <tr>
                        <td style="border-bottom: 1px solid #ddd; padding: 8px;"><strong>Subject:</strong></td>
                        <td style="border-bottom: 1px solid #ddd; padding: 8px;">{{ $contact->subject }}</td>
                    </tr>
                    <tr>
                        <td style="border-bottom: 1px solid #ddd; padding: 8px;"><strong>Message:</strong></td>
                        <td style="border-bottom: 1px solid #ddd; padding: 8px;">{{ $contact->message }}</td>
                    </tr>
                </table>

                <p>Our team will review your message and respond as soon as possible.</p>
                <p>Thank you for reaching out!</p>

                <p style="color: #777;">Best Regards, <br> {{app_setting('site_name')}}</p>
            </td>
        </tr>
    </table>

</body>

</html>
