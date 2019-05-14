<?php $company = getCompanyObject(); ?>
<html>
    <head>
        <title>{{ $company->app_name }}</title>
    </head>
    <body style="background-color:#f2f2f2; padding:40px 0;">
        <table style="width:760px; margin:0 auto;" cellpadding="0" cellspacing="0">
            <tr>
                <td style="background-color:#4eaa40; text-align:center;"><h1 style="margin-top:20px; color:white; font-family:Helvetica Neue, Helvetica, Arial; font-weight:300;">{{ $company->app_name }}</h1></td>
            </tr>
            <tr>
                <td style="background-color:white; padding:10px 15px;">
                    @yield('content')
                </td>
            </tr>
            <tr>
                <td style="background-color:#4eaa40; text-align:center;"><p style="margin:10px 0; color:white; font-family:Helvetica Neue, Helvetica, Arial; font-weight:300;">All Rights Reserved {{ date('Y') }} ~ {{ $company->app_name }}</p></td>
            </tr>
        </table>
    </body>
</html>
