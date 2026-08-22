<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
</head>
<body style="margin:0;padding:32px;background:#F8FAFC;font-family:Arial,Helvetica,sans-serif;color:#191c1e;">
    <div style="max-width:420px;margin:0 auto;background:#ffffff;border:1px solid #E2E8F0;border-radius:12px;padding:32px;">
        <div style="font-size:18px;font-weight:700;color:#0F172A;margin-bottom:24px;">
            ClinicOS
        </div>

        <p style="font-size:14px;color:#45464d;margin:0 0 16px;">
            Use the code below to verify your identity and finish signing in.
        </p>

        <div style="font-size:32px;font-weight:700;letter-spacing:8px;color:#0F172A;background:#F1F5F9;border-radius:8px;padding:16px 24px;text-align:center;margin-bottom:16px;">
            {{ $code }}
        </div>

        <p style="font-size:13px;color:#45464d;margin:0;">
            This code expires in 5 minutes. If you didn't request this, you can safely ignore this email.
        </p>
    </div>
</body>
</html>
