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
        <main style="width:100%">
            <div style="margin: 20px 0px; border: 2px dotted #222; padding:30px">
                <div style="padding: 20px">
                    <h4 style="font-size: 25px; text-align: center; color: blue;margin:0">A New Mail For SEO Checker </h4>
                    <table>
                        <tbody>
                             <tr style="font-family: 'Helvetica Neue',Helvetica,Arial,sans-serif; box-sizing: border-box; font-size: 14px; margin: 0;">
                                <td class="content-block" style="font-family: 'Helvetica Neue',Helvetica,Arial,sans-serif; box-sizing: border-box; color: #222; font-size: 16px; font-weight: 700; text-align: left; vertical-align: top; margin: 0; padding: 0 0 10px;"
                                    valign="top"> Name : {{$name}}</td>
                            </tr>
                            <tr style="font-family: 'Helvetica Neue',Helvetica,Arial,sans-serif; box-sizing: border-box; font-size: 14px; margin: 0;">
                                <td class="content-block" style="font-family: 'Helvetica Neue',Helvetica,Arial,sans-serif; box-sizing: border-box; color: #222; font-size: 16px; font-weight: 700; text-align: left; vertical-align: top; margin: 0; padding: 0 0 10px;"
                                    valign="top"> Email : {{$email}}</td>
                            </tr>
                            <tr style="font-family: 'Helvetica Neue',Helvetica,Arial,sans-serif; box-sizing: border-box; font-size: 14px; margin: 0;">
                                <td class="content-block" style="font-family: 'Helvetica Neue',Helvetica,Arial,sans-serif; box-sizing: border-box; color: #222; font-size: 16px; font-weight: 700; text-align: left; vertical-align: top; margin: 0; padding: 0 0 10px;"
                                    valign="top"> Deadline : {{$deadline}}</td>
                            </tr>
                            <tr style="font-family: 'Helvetica Neue',Helvetica,Arial,sans-serif; box-sizing: border-box; font-size: 14px; margin: 0;">
                                <td class="content-block" style="font-family: 'Helvetica Neue',Helvetica,Arial,sans-serif; box-sizing: border-box; color: #222; font-size: 16px; font-weight: 700; text-align: left; vertical-align: top; margin: 0; padding: 0 0 10px;"
                                    valign="top"> Package : {{$package}}</td>
                            </tr>
                            <tr style="font-family: 'Helvetica Neue',Helvetica,Arial,sans-serif; box-sizing: border-box; font-size: 14px; margin: 0;">
                                <td class="content-block" style="font-family: 'Helvetica Neue',Helvetica,Arial,sans-serif; box-sizing: border-box; color: #222; font-size: 16px; font-weight: 700; text-align: left; vertical-align: top; margin: 0; padding: 0 0 10px;"
                                    valign="top"> Budget : {{$deadline}}</td>
                            </tr>
                        </tbody>
                            <tr style="font-family: 'Helvetica Neue',Helvetica,Arial,sans-serif; box-sizing: border-box; font-size: 14px; margin: 0;">
                                <td class="content-block" style="font-family: 'Helvetica Neue',Helvetica,Arial,sans-serif; box-sizing: border-box; color: #222; font-size: 16px; font-weight: 700; text-align: left; vertical-align: top; margin: 0; padding: 0 0 10px;"
                                    valign="top"> Summary : {{$summary}}</td>
                            </tr>
                        </tbody>
                    </table>
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
                        <p style="font-size: 16px;color:#fff !important"><strong>Email:</strong> {{$generalsetting->email}}</p>
                        <p style="font-size: 16px;"><strong>Phone:</strong> {{$generalsetting->phone}}</p>
                    </div>
                    <div style="margin-right: 5px;">
                        <p style="font-size: 16px; text-align: center;">Copyright © {{date('Y')}} {{$generalsetting->name}}, All rights reserved. {{$generalsetting->address}}. Click here to <a
                                href="https://extremeranks.com/morepage/terms-of-service" target="_blank"
                                style="color: white;">unsubscribe</a></p>
                    </div>
                </div>
            </div>
        </footer>
    </div>
</body>
</html>