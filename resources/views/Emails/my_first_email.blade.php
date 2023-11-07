<!DOCTYPE html>
<html lang="en" xmlns="http://www.w3.org/1999/xhtml" xmlns:o="urn:schemas-microsoft-com:office:office">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width,initial-scale=1">
  <meta name="x-apple-disable-message-reformatting">
  <title></title>
  <link href='https://fonts.googleapis.com/css?family=Kanit' rel='stylesheet'>
  <style>
        body {
            font-family: 'Kanit';
        }
</style>
</head>

<body style="margin:0; padding:0;">
    <table role="presentation" style="width:100%; border-collapse:collapse; border:0; border-spacing:0; background:#ffffff;">
        <tr>
            <td align="center" style="padding:0;">
                <table role="presentation" style="width:602px; border-collapse:collapse; border:1px solid #cccccc; border-spacing:0; text-align:left;">
                    <tr>
                        <td>
                            <div align="center" style="display:flex; padding:10px 100px 15px 40px; background:#3d3d3d; border: 1px solid #cccccc; overflow: hidden;">
                                <div style="display: flex; flex-wrap: wrap; align-items: center;">
                                    <div style="position: relative; background-color: white; width: 80px; height: 80px; border: 1px solid #000; overflow: hidden; border-radius: 50%; padding: 7px;">
                                        <img src="{{ asset('/uploads/'.$data['project']->image) }}" alt="" style="width: 100%; height: 100%; object-fit: cover; display: block; border-radius: 50%;" alt="logo">
                                    </div>
                                </div>
                                <h1 style="font-family: 'Kanit'; color:#ffffff; font-size:24px; font-weight:800; margin-top:30px; margin-left:10px;">{{ $data['project']->project_name }}</h1>
                            </div>
                        </td>
                    </tr>
                    
                    <tr>
                        <td style="padding:12px 125px 42px 125px;">
                            <table role="presentation" style="width:100%; border-collapse:collapse; border:0; border-spacing:0;">
                                <tr>
                                    <td style="padding:0;">
                                        <table role="presentation" style="width:100%; border-collapse:collapse; border:0; border-spacing:0;">
                                            <tr>
                                                <td style="width:260px; padding:0; vertical-align:top; color:#153643;">
                                                    <p style="font-family: 'Kanit'; color:#525252; margin:0; font-size:20px; font-weight:600;">รายการเช็คลิสต์ {{ $data['DefectText'] }}</p>
                                                    <p style="font-family: 'Kanit'; color:#6d6d6d; margin:0; font-size:16px; font-weight:400; margin-left:12px;">เสร็จสิ้นทั้งหมดแล้ว</p>
                                                    <p style="margin:0; margin-top:36px; font-size:16px; display:relative;">
                                                        <a href="{{ Route('ChecklistUser', [$data['project']->project_code]) }}" target="_blank" style="font-family: 'Kanit'; font-size:16px; color:white; text-decoration:none; background-color:#ff5757; border: 2px solid #FF4C4C; border-radius:7px; padding:7px 14px; margin-left:80px; margin-right:80px;">ลิงก์รายการเช็คลิสต์นี้</a>
                                                    </p>
                                                </td>
                                            </tr>
                                        </table>
                                    </td>
                                </tr>
                            </table>
                        </td>
                    </tr>

                    <tr>
                        <td style="padding:24px; background:#3d3d3d;">
                            <table role="presentation" style="width:100%; border-collapse:collapse; border:0; border-spacing:0; font-size:9px">
                                <tr>
                                    <td style="padding:0 0 0 40px;width:70%;" align="left">
                                        <a href="https://www.kingsmen-cmti.com" style="color:#ffffff;"><img src="https://www.kingsmen-cmti.com/images/logo.png" alt="Twitter" width="100" style="height:auto;display:block;border:0;" /></a>
                                        <p style="font-family: 'Kanit'; margin:10 0 0 0; font-size:14px; line-height:16px; color:#bdbdbd;">
                                            &reg; พัฒนาโดย บริษัท คิงส์เมน ซี.เอ็ม.ที.ไอ. จำกัด (มหาชน)
                                        </p>
                                    </td>
                                    <td style="padding:0 40px 0 0; width:30%;" align="right">
                                        <table role="presentation" style="border-collapse:collapse;border:0;border-spacing:0;">
                                            <tr>
                                                <td style="margin:0 0 0 10px; width:38px; background:white; border-radius:50%;">
                                                    <a href="https://www.facebook.com/kingsmencmtiplc/?locale=th_TH" style="color:#ffffff;"><img src="https://assets.codepen.io/210284/fb_1.png" alt="Facebook" width="38" style="height:auto; display:block; border:0;" /></a>
                                                </td>
                                            </tr>
                                        </table>
                                    </td>
                                </tr>
                            </table>
                        </td>
                    </tr>
                </table>
            </td>
        </tr>
    </table>
</body>

</html>