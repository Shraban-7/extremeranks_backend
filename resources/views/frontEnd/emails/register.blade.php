<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Email</title>
</head>
 <style>
     #email a{
         color:#FFF!important;
     }
 </style>
<body style="padding: 0px 50px; margin-top: 0px; width:100%; background:#f1f1f1">
    <div style="width:600px;margin:0 auto">
        <header style="width:100%">
            <div>
                <div style="background-color: #4862CB; padding: 30px;text-align:center">
                    <a href="https://extremeranks.com" target="_blank">
                        <img src="https://extremeranks.com/backend/public/backend/assets/images/email-logo.png" alt="Website Logo" style="max-width: 100%; height: auto; margin:0 auto;text-align:center" />
                    </a>
                </div>
            </div>
        </header>
        <main style="width:100%">
            <div style="margin: 20px 0px; padding:30px">
                <div style="padding: 20px">
                    <h4 style="font-size: 25px; text-align: center; color: blue;margin:0">Account  OTP</h4>
                    <p style="font-size: 18px; color: blue;margin:15px 0">Upon logging in, you will be able to access other services including reviewing past orders, printing invoices and editing your account information</p>
                    <h5 style="font-size: 20px; font-weight: 400;margin:0">Account Verify OTP: {{$verifyToken}}</h5>
                    <div style="margin-top:20px">
                        <span style="display: block;font-size:16px">Thanks,</span>
                        <span style="font-size:16px">{{$generalsetting->name}}</span>
                    </div>
                </div>
            </div>
        </main>
        <footer style="width="100%">
            <div>
                <div style="display: flex; background-color: #4862CB; padding: 50px 50px; color: white; font-size: 20px;">
                    <div style="width: 100%; border-right: 1px solid;">
                        <div id="logo">
                            <img style="width: 100px;" src="https://extremeranks.com/backend/public/backend/assets/images/email-logo.png" alt="Logo">
                        </div>
                        <p style="font-size: 16px;"><strong>Address:</strong> {{$generalsetting->address}}</p>
                        <p style="font-size: 16px;color:#fff !important"><strong>Email:</strong> <a style="color:#fff;" href="mailto:{{$generalsetting->email}}">{{$generalsetting->email}}</a></p>
                        <p style="font-size: 16px;"><strong>Phone:</strong> {{$generalsetting->phone}}</p>
                    </div>
                    <div style="margin-right: 5px;padding-left:15px;">
                        <p style="font-size: 16px; text-align: left;">Copyright © {{date('Y')}} {{$generalsetting->name}}, All rights reserved. {{$generalsetting->address}}. Click here to <a
                                href="https://extremeranks.com/morepage/terms-of-service" target="_blank"
                                style="color: white;">unsubscribe</a></p>
                    </div>
                </div>
            </div>
        </footer>
    </div>
</body>
</html>
