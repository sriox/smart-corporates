<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>{{ config('app.name') }}</title>
</head>

<body style="background-color: lightgrey; margin: 0; color: #111111">
    <div role="article"
        style="-webkit-text-size-adjust:100%;-ms-text-size-adjust:100%;max-width: 900px; background-color: white; margin: auto; padding: 10px 20px; font-family: Verdana, Geneva, sans-serif">

        <head class="head">
            <table role="presentation" width="100%">
                <tr>
                    @if (isset($company) && $company->logo_url)
                        <td>
                            <img src="{{ $company->logo_url }}" style="max-width: 100%;max-height: 80px"
                                alt="" />
                        </td>
                        <td align="right" style="text-align: right">
                            <img src="https://teambuildingsas.com/wp-content/uploads/2022/11/engagement_logo_h_100.png"
                                style="max-width: 100%;max-height:80px" />
                        </td>
                    @else
                        <td><img src="https://teambuildingsas.com/wp-content/uploads/2022/11/engagement_logo_h_100.png"
                                style="max-width: 100%;max-height:80px" />
                        </td>
                        <td>&nbsp;</td>
                    @endif
                </tr>
            </table>
        </head>
        <div class="content">

            @yield('content')

        </div>
        <div class="footer" style="margin-bottom: 50px">
            @yield('footer')
        </div>
    </div>
</body>

</html>
