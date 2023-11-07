<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>Home | Kingsmen CMTI</title>

        <link href="{{ asset('css/app.css') }}" rel="stylesheet">

        <!-- BoxIcons -->
        <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>

        <link rel="stylesheet" href="{{ asset('css/styles.css') }}">
    </head>
    <body class="font-kanit">    
        <title>{{$data['title']}}</title>

        <div class="z-10">
            <ul class="relative bg-gradient-to-r from-[#293145] via-[#36415B] to-rose-900">
                <!-- START GRID 1 -->
                <li class="fade-in-grid1 p-[24px] max-sm:p-0 flex items-center flex-wrap gap-[20px] h-screen lg:display-block">
                    <!-- START LOGO -->
                    <div class="absolute top-0 w-[175px] pt-[30px] pl-[30px]">
                        <img src="https://demo.kcmtiplc.com/assets/images/logo/logo.png" alt="">
                    </div>
                    <!-- END LOGO -->
                    <div class="relative text-white text-2xl w-fit mx-auto max-sm:scale-75">
                        <div class="flex justify-center w-full">
                            <i class='bx bx-layer text-[150px] bg-gradient-to-r from-rose-700 to-blue-500 bg-clip-text text-transparent animate-bounce'></i>
                        </div>
                        <div class="fade-in-grid1-title">
                            <p class="text-[24px] font-medium">ยินดีต้อนรับสู่</p>
                            <p class="text-[24px] font-medium flex items-center animate-pulse bg-gradient-to-r from-rose-400 to-blue-400 bg-clip-text text-transparent">
                                <i class='bx bx-chevrons-right text-4xl text-rose-600'></i>ระบบตรวจสอบคุณภาพงาน
                            </p>
                            <p class="text-[24px] font-medium flex items-center justify-center ml-[36.5px] animate-pulse bg-gradient-to-r from-rose-400 to-blue-400 bg-clip-text text-transparent">
                                (Checklist System)
                            </p>
                            <p class="text-[24px] max-sm:text-[22px] text-gray-500 font-medium flex items-center justify-center whitespace-nowrap">
                                บริษัท คิงส์เมน ซี.เอ็ม.ที.ไอ. จำกัด (มหาชน)
                            </p>
                            <hr class="border-2 mb-4">
                            <a href="{{ Route('Login') }}" class="text-[18px] flex items-center justify-center bg-blue-500 text-gray-300 rounded-md hover:bg-blue-600 hover:text-white focus:ring-4 focus:outline-none focus:ring-blue-300 duration-300">
                                <i class='bx bx-chevrons-right text-4xl text-rose-600 animate-pulse'></i>หน้าเข้าสู่ระบบ
                            </a>
                        </div>
                    </div>
                </li>
                <!-- END GRID 1 -->
            </ul>
        </div>
    </body>
</html>