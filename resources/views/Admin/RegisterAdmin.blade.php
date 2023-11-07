<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        
        <link href="{{ asset('css/app.css') }}" rel="stylesheet">

        <title>Sign Up | Kingsmen CMTI</title>

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,600&display=swap" rel="stylesheet" />

        <!-- BoxIcons -->
        <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>

        <link rel="stylesheet" href="{{ asset('css/styles.css') }}">
        <style>
            .float-label-input:focus-within label,
            .float-label-input input:not(:placeholder-shown) + label {
                transform: translateY(-1.5rem) scale(0.85);
                background-color: white;
                border-radius: 2rem;
                color: #495a80;
                font-weight: 500;
            }
        </style>
    </head>
    <body class="font-kanit">    
        <title>{{$data['title']}}</title>

        <div class="z-10">
            <ul class="relative grid grid-cols-2 max-md:grid-cols-1 bg-gradient-to-r from-[#293145] via-[#36415B] to-rose-900">
                <!-- START GRID 1 -->
                <li class="fade-in-grid1 p-[24px] flex items-center flex-wrap gap-[20px] h-screen max-md:hidden lg:display-block">
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
                            <p class="text-[30px] font-medium">ยินดีต้อนรับสู่</p>
                            <p class="text-[30px] font-medium flex items-center animate-pulse bg-gradient-to-r from-rose-400 to-blue-400 bg-clip-text text-transparent">
                                <i class='bx bx-chevrons-right text-4xl text-rose-600'></i>ระบบตรวจสอบคุณภาพงาน
                            </p>
                            <p class="text-[30px] font-medium flex items-center justify-center ml-[36.5px] animate-pulse bg-gradient-to-r from-rose-400 to-blue-400 bg-clip-text text-transparent">
                                (Checklist System)
                            </p>
                            <p class="text-[24px] max-sm:text-[22px] text-gray-500 font-medium flex items-center justify-center whitespace-nowrap">
                                บริษัท คิงส์เมน ซี.เอ็ม.ที.ไอ. จำกัด (มหาชน)
                            </p>
                            <hr class="border-2">
                        </div>
                    </div>
                </li>
                <!-- END GRID 1 -->

                <!-- START GRID 2 -->
                <li class="flex items-center justify-center flex-wrap h-screen">
                    <!-- START LOGO -->
                    <div class="absolute top-0 w-full max-sm:display-block md:hidden">
                        <div class="w-[200px] mx-auto mt-[30px]">
                            <img src="https://demo.kcmtiplc.com/assets/images/logo/logo.png" alt="">
                        </div>
                    </div>
                    <!-- END LOGO -->

                    <!-- START FORM LOGIN -->
                    <div class="fade-in-grid2 relative w-fit m-auto bg-white rounded-md border-t-8 border-blue-600 max-md:mx-[30px]">
                        <div class="p-10">
                            <form action="#!" method="post" onsubmit="return false;">
                                @csrf
                                <div class="w-auto">
                                    <h1 class="text-[1.5rem] flex items-center justify-center font-bold uppercase">ลงทะเบียน</h1>
                                    <br>
                                    <div class="grid grid-cols-2 gap-1">
                                        <div class="relative float-label-input mt-4">
                                            <input type="text" id="firstname" placeholder=" " class="bg-gray-50 border-2 border-gray-300 text-gray-900 text-sm rounded-lg focus:outline-none focus:border-[#5c719b] focus:bg-white block w-full p-2.5" autocomplete="on">
                                            <label for="firstname" class="absolute top-2.5 left-0 text-gray-400 pointer-events-none transition duration-200 ease-in-out px-2">ชื่อ</label>
                                        </div>
                                        <div class="relative float-label-input mt-4">
                                            <input type="text" id="lastname" placeholder=" " class="bg-gray-50 border-2 border-gray-300 text-gray-900 text-sm rounded-lg focus:outline-none focus:border-[#5c719b] focus:bg-white block w-full p-2.5" autocomplete="on">
                                            <label for="lastname" class="absolute top-2.5 left-0 text-gray-400 pointer-events-none transition duration-200 ease-in-out px-2">นามสกุล</label>
                                        </div>

                                    </div>
                                    <div class="relative float-label-input mt-4">
                                        <input type="text" id="username" placeholder=" " class="bg-gray-50 border-2 border-gray-300 text-gray-900 text-sm rounded-lg focus:outline-none focus:border-[#5c719b] focus:bg-white block w-full p-2.5" autocomplete="on">
                                        <label for="username" class="absolute top-2.5 left-0 text-gray-400 pointer-events-none transition duration-200 ease-in-out px-2">ชื่อผู้ใช้</label>
                                    </div>

                                    <div class="relative w-full">
                                        <div class="absolute inset-y-0 right-0 flex items-center px-2 z-10">
                                            <input class="hidden js-password-toggle" id="toggle" type="checkbox" />
                                            <label class="js-password-label bg-gray-300 hover:bg-gray-400 duration-300 rounded px-2 py-1 text-sm text-gray-600 cursor-pointer" for="toggle">แสดง</label>
                                        </div>
                                        <div class="relative float-label-input mt-4">
                                            <input type="password" id="password" placeholder=" " class="js-password bg-gray-50 border-2 border-gray-300 text-gray-900 text-sm rounded-lg focus:outline-none focus:border-[#5c719b] focus:bg-white block w-full p-2.5" autocomplete="off">
                                            <label for="password" class="absolute top-2.5 left-0 text-gray-400 pointer-events-none transition duration-200 ease-in-out px-2">รหัสผ่าน</label>
                                        </div>
                                    </div>
                                    <div class="flex items-center justify-center text-[20px] mt-4">
                                        <button type="submit" onClick="RegisterProcess()" class="w-full text-white bg-blue-600 hover:bg-blue-700 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2 text-center">ลงทะเบียน</button>
                                    </div>
                                </div>
                            </form>
                            <div class="text-sm text-center mt-4">
                                <p class="text-gray-400">มีบัญชีอยู่แล้ว?
                                    <a href="{{ Route('Login') }}" class="text-blue-600 font-bold">เข้าสู่ระบบ</a>
                                </p>
                            </div>
                            @if(session('status') != '1')
                                <span class="text-red-600 flex items-center justify-center">
                                    {{ session('status') }}
                                </span>
                            @endif
                        </div>
                    </div>
                    <!-- END FORM LOGIN -->
                </li>
                <!-- END GRID 2 -->
            </ul>
        </div>

        <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
        <script>
            const passwordToggle = document.querySelector('.js-password-toggle')
            passwordToggle.addEventListener('change', function() {
                const password = document.querySelector('.js-password'),
                    passwordLabel = document.querySelector('.js-password-label')
                if (password.type === 'password') {
                    password.type = 'text'
                    passwordLabel.innerHTML = 'ซ่อน'
                } else {
                    password.type = 'password'
                    passwordLabel.innerHTML = 'แสดง'
                }
                password.focus()
            });

            const input_username = document.getElementById('username');
            input_username.addEventListener('focus', () => {
                input_username.setAttribute('placeholder', 'ชื่อผู้ใช้ขั้นต่ำ 4 ตัวอักษร');
            });
            input_username.addEventListener('blur', () => {
                input_username.setAttribute('placeholder', '');
            });

            const input_password = document.getElementById('password');
            input_password.addEventListener('focus', () => {
                input_password.setAttribute('placeholder', 'รหัสผ่านขั้นต่ำ 4 ตัวอักษร');
            });
            input_password.addEventListener('blur', () => {
                input_password.setAttribute('placeholder', '');
            });

            function RegisterProcess(){
                const minimum_username_length = 4;
                const minimum_password_length = 4;
                if(
                    ((document.getElementById("username").value).length >= minimum_username_length) && 
                    ((document.getElementById("password").value).length >= minimum_password_length) && 
                    document.getElementById("firstname").value != '' &&
                    document.getElementById("lastname").value != '' &&
                    document.getElementById("username").value.indexOf(' ') <= 0 && 
                    document.getElementById("password").value.indexOf(' ') <= 0
                ) {
                    fetch("{{ Route('RegisterStore') }}", {
                        method: "POST",
                        headers: {
                            "Content-Type": "application/json",
                            "Accept": "application/json",
                            "X-CSRF-Token": '{{csrf_token()}}'
                        },
                        body:JSON.stringify(
                            {
                                username: document.getElementById("username").value,
                                password: document.getElementById("password").value,
                                firstname: document.getElementById("firstname").value,
                                lastname: document.getElementById("lastname").value
                            }
                        )
                    })
                    .then(async response => {
                        const isJson = response.headers.get('content-type')?.includes('application/json');
                        const data = isJson ? await response.json() : null; 

                        if(!response.ok){
                            const error = (data && data.errorMessage) || "{{trans('general.warning.system_failed')}}" + " (CODE:"+response.status+")";
                            return Promise.reject(error);
                        }

                        Swal.fire({
                            position: 'center',
                            icon: 'success',
                            title: 'ลงทะเบียนสำเร็จ',
                            timer: 1500,
                            timerProgressBar: true
                        }).then((result) => {
                            window.location.href = "{{ Route('Login') }}";
                        })
                    }).catch((er) => {
                        console.log('Error: ' + er);
                        Swal.fire({
                            position: 'center',
                            icon: 'error',
                            title: 'ลงทำเบียนไม่สำเร็จ!',
                            html: '<b class="text-rose-800">ชื่อผู้ใช้</b>นี้ถูกใช้ไปแล้ว'
                        })
                    });
                } else {
                    Swal.fire({
                        position: 'center',
                        icon: 'error',
                        title: 'ลงทำเบียนไม่สำเร็จ!',
                        html: 'ความยาวของชื่อผู้ใช้และรหัสผ่าน<br>จะต้องมีอย่างน้อย <b class="text-rose-800">4</b> ตัวอักษร <b class="text-rose-800">และไม่มีช่องว่าง</b>'
                    })
                }
            }
        </script>
    </body>
</html>