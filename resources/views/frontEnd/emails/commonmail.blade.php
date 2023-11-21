<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Email</title>
</head>
 
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
        <style>
             #email a{
                 color:#FFF!important;
             }
         </style>
        <main style="width:100%">
            <div style="margin: 20px 0px;padding:30px">
                <div style="padding: 20px">
                    <b>Message From: {{$customername}}</b><br/>
                    Message:{{$maildetails}}<br/>
                    <a href="https://extremeranks.com/backend/admin/support/chat?customer_id={{$customer_id}}" target="_blank">Click to view</a>
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
                        <p style="font-size: 16px;color:#fff !important"><strong>Email:</strong> <span id="email"><a style="color:#fff;" href="mailto:{{$generalsetting->email}}">{{$generalsetting->email}}</a></span></p>
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