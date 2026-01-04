<DOCTYPE html>
    <html lang="en-US">

    <head>
        <meta charset="utf-8">
    </head>

    <body>
        <table border="0" cellpadding="0" cellspacing="0" width="100%"
            style="table-layout:fixed;background-color:#f9f9f9" id="bodyTable">
            <tbody>
                <tr>
                    <td style="font-size:1px;line-height:1px" height="30">&nbsp;</td>
                </tr>
                <tr>
                    <td style="padding-right:10px;padding-left:10px;" align="center" valign="top" id="bodyCell">
                        <table border="0" cellpadding="0" cellspacing="0" width="100%" class="wrapperBody"
                            style="max-width:600px">
                            <tbody>
                                <tr>
                                    <td align="center" valign="top">
                                        <table border="0" cellpadding="0" cellspacing="0" width="100%"
                                            class="tableCard"
                                            style="background-color:#fff;border-color:#e5e5e5;border-style:solid;border-width:0 1px 1px 1px;">
                                            <tbody>
                                                <tr>
                                                    <td style="background-color:#3249b3;font-size:1px;line-height:3px"
                                                        class="topBorder" height="3">&nbsp;</td>
                                                </tr>
                                                <tr>
                                                    <td style="padding-top: 60px; padding-bottom: 20px;" align="center"
                                                        valign="middle" class="emailLogo"></td>
                                                </tr>
                                                <tr>
                                                    <td style="padding-bottom: 5px; padding-left: 20px; padding-right: 20px;"
                                                        valign="top" class="mainTitle">
                                                        <h2 class="text"
                                                            style="color:#000;font-family:Poppins,Helvetica,Arial,sans-serif;font-size:28px;font-weight:500;font-style:normal;letter-spacing:normal;line-height:36px;text-transform:none;padding:0;margin:0; text-transform: capitalize;">
                                                            Hello Dear Customer,</h2>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td style="padding-bottom: 10px; padding-left: 20px; padding-right: 20px;"
                                                        valign="top" class="subTitle">
                                                        <h4 class="text"
                                                            style="color:#999;font-family:Poppins,Helvetica,Arial,sans-serif;font-size:16px;font-weight:500;font-style:normal;letter-spacing:normal;line-height:24px;text-transform:none;padding:0;margin:0">
                                                            New Payment has been made.</h4>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td style="padding-bottom: 10px; padding-left: 20px; padding-right: 20px;"
                                                        valign="top" class="subTitle">
                                                        <h4 class="text"
                                                            style="color:#999;font-family:Poppins,Helvetica,Arial,sans-serif;font-size:16px;font-weight:500;font-style:normal;letter-spacing:normal;line-height:24px;text-transform:none;padding:0;margin:0">
                                                            User Details</h4>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td style="padding-bottom: 10px; padding-left: 20px; padding-right: 20px;"
                                                        valign="top" class="subTitle">
                                                        <h5 class="text"
                                                            style="color:#999;font-family:Poppins,Helvetica,Arial,sans-serif;font-size:16px;font-weight:500;font-style:normal;letter-spacing:normal;line-height:24px;text-transform:none;padding:0;margin:0">
                                                            User Name: {{ $emailData['user']->name }}</h5>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td style="padding-bottom: 10px; padding-left: 20px; padding-right: 20px;"
                                                        valign="top" class="subTitle">
                                                        <h5 class="text"
                                                            style="color:#999;font-family:Poppins,Helvetica,Arial,sans-serif;font-size:16px;font-weight:500;font-style:normal;letter-spacing:normal;line-height:24px;text-transform:none;padding:0;margin:0">
                                                            User E-mail: {{ $emailData['user']->email }}</h5>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td style="padding-bottom: 10px; padding-left: 20px; padding-right: 20px;"
                                                        valign="top" class="subTitle">
                                                        <h4 class="text"
                                                            style="color:#999;font-family:Poppins,Helvetica,Arial,sans-serif;font-size:16px;font-weight:500;font-style:normal;letter-spacing:normal;line-height:24px;text-transform:none;padding:0;margin:0">
                                                            Payment Details</h4>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td style="padding-bottom: 10px; padding-left: 20px; padding-right: 20px;"
                                                        valign="top" class="subTitle">
                                                        <h5 class="text"
                                                            style="color:#999;font-family:Poppins,Helvetica,Arial,sans-serif;font-size:16px;font-weight:500;font-style:normal;letter-spacing:normal;line-height:24px;text-transform:none;padding:0;margin:0">
                                                           Subscribed to {{$emailData['payment_details']->plan_name}},{{ $emailData['payment_details']->currency == 'usd' ? '$' : $emailData['payment_details']->currency }}{{ $emailData['payment_details']->amount }}
                                                            paid on {{ $emailData['payment_details']->started_at }}.</h5>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td style="font-size:1px;line-height:1px" height="20">&nbsp;</td>
                                                </tr>
                                                <tr>
                                                    <td style="padding-bottom: 5px; padding-left: 20px; padding-right: 20px;"
                                                        valign="top" class="mainTitle">
                                                        <h2 class="text"
                                                            style="color:#000;font-family:Poppins,Helvetica,Arial,sans-serif;font-size:16px;font-weight:500;font-style:normal;letter-spacing:normal;line-height:16px;text-transform:none;padding:0;margin:0">
                                                            Regards</h2>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td style="padding-bottom: 30px; padding-left: 20px; padding-right: 20px;"
                                                        valign="top" class="subTitle">
                                                        <h4 class="text"
                                                            style="color:#999;font-family:Poppins,Helvetica,Arial,sans-serif;font-size:13px;font-weight:500;font-style:normal;letter-spacing:normal;line-height:15px;text-transform:none;padding:0;margin:0">
                                                            {{env('APP_NAME')}}</h4>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td style="background-color:#3249b3;font-size:1px;line-height:3px"
                                                        class="topBorder" height="3">&nbsp;</td>
                                                </tr>
                                            </tbody>
                                        </table>
                                        <table border="0" cellpadding="0" cellspacing="0" width="100%"
                                            class="space">
                                            <tbody>
                                                <tr>
                                                    <td style="font-size:1px;line-height:1px" height="10">&nbsp;</td>
                                                </tr>
                                            </tbody>
                                        </table>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                        <table border="0" cellpadding="0" cellspacing="0" width="100%" class="wrapperFooter"
                            style="max-width:600px">
                            <tbody>
                                <tr>
                                    <td align="center" valign="top">
                                        <table border="0" cellpadding="0" cellspacing="0" width="100%"
                                            class="footer">
                                            <tbody>
                                                <tr>
                                                    <td style="padding: 10px 10px 5px;" align="center" valign="top"
                                                        class="brandInfo">
                                                        <p class="text"
                                                            style="color:#bbb;font-family:'Open Sans',Helvetica,Arial,sans-serif;font-size:12px;font-weight:400;font-style:normal;letter-spacing:normal;line-height:20px;text-transform:none;text-align:center;padding:0;margin:0">
                                                            ©&nbsp;{{env('APP_NAME')}}.</p>
                                                    </td>
                                                </tr>
                                            </tbody>
                                        </table>
                                    </td>
                                </tr>
                                <tr>
                                    <td style="font-size:1px;line-height:1px" height="30">&nbsp;</td>
                                </tr>
                            </tbody>
                        </table>
                    </td>
                </tr>
            </tbody>
        </table>
    </body>

    </html>
