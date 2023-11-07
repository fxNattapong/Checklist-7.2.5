@php 
    $currentRoute = Request::route()->getName();
    $sessionRole = Request::session()->get('role');
    $sessionUsername = Request::session()->get('username');
@endphp

<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        
        <link href="{{ asset('css/app.css') }}" rel="stylesheet">

        <title>Layout</title>

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,600&display=swap" rel="stylesheet" />

        <!-- BoxIcons -->
        <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>

        <link rel="stylesheet" href="{{ asset('css/styles.css') }}">
    </head>

    <body class="font-kanit">
        <div class="relative float-left w-[280px] bg-[#333] min-h-[100vh] max-md:hidden" id="sidebar">
            <div class="h-full bg-gray-900 px-6 flex flex-col">
                <div class="flex items-center justify-center">
                    <img class="w-[150px] h-full flex my-auto pt-4" src="https://www.kingsmen-cmti.com/images/logo.png" alt="logo">
                </div>
                <nav class="flex-1 grow mt-4">
                    <ul role="list" class="flex flex-col h-full justify-between">
                        <li class="grow">
                            <ul role="list" class="-mx-2 space-y-1">
                                <li>
                                    <a href="{{ Route('Dashboard') }}" id="Dashboard" class="text-gray-400 hover:text-white hover:bg-gray-800 hover:duration-300 group flex gap-x-3 rounded-md p-2 text-md leading-6 font-semibold">
                                        <i class='bx bx-home text-2xl'></i>
                                        <span class="my-auto overflow-x-hidden">แดชบอร์ด</span>
                                    </a>
                                </li>
                                @if($sessionRole != '1')
                                    <li>
                                        <a href="{{ Route('Users') }}" id="Users" class="text-gray-400 hover:text-white hover:bg-gray-800 hover:duration-300 group flex gap-x-3 rounded-md p-2 text-md leading-6 font-semibold">
                                        <i class='bx bxs-user-account text-2xl' ></i>
                                            <span class="my-auto overflow-x-hidden">พนักงาน</span>
                                        </a>
                                    </li>
                                    <li>
                                        <a href="{{ Route('Projects') }}" id="Projects" class="text-gray-400 hover:text-white hover:bg-gray-800 hover:duration-300 group flex gap-x-3 rounded-md p-2 text-md leading-6 font-semibold">
                                            <i class='bx bxs-book-content text-2xl' ></i>
                                            <span class="my-auto overflow-x-hidden">โปรเจกต์</span>
                                        </a>
                                    </li>
                                @endif
                                <li>
                                    <a href="{{ Route('Checklist') }}" id="Checklist" class="text-gray-400 hover:text-white hover:bg-gray-800 hover:duration-300 group flex gap-x-3 rounded-md p-2 text-md leading-6 font-semibold">
                                        <i class='bx bx-check-square text-2xl my-auto' ></i>
                                        <span class="my-auto overflow-x-hidden truncate">เช็คลิสต์</span>
                                    </a>
                                </li>
                            </ul>
                        </li>

                        <li class="-mx-2 w-auto mt-auto flex mb-3 relative">
                            <a onClick="cogRotate()" id="cogRotate" class="flex w-[100%] text-white hover:bg-gray-800 hover:rounded-md hover:duration-300 cursor-pointer">
                                <div class="flex items-center gap-x-3 px-2 py-2 text-sm font-semibold leading-6">
                                    <div class="border-2 border-white rounded-full p-1">
                                        @if(Session::get('image'))
                                            <img class="h-7 w-7 rounded-full bg-white border-2 border-white" src="{{ URL('/uploads/'.Session::get('image')) }}" alt="">
                                        @else
                                            <img class="h-7 w-7 rounded-full bg-white border" src="{{ URL('/uploads/'.'user.png') }}" alt="">
                                        @endif
                                    </div>
                                    <span class="font-medium my-auto overflow-x-hidden">@php if(Session::get('authen')) echo Session::get('firstname') @endphp</span>
                                </div>
                                <div class="flex items-center ml-auto mr-0 px-2">
                                    <i class='bx bx-cog duration-300' id="bx-cog"></i>
                                </div>
                            </a>
                            <div class="z-50 absolute bg-black-300 rounded-md -right-[145.5px] bottom-0 duration-800 hidden" id="user">
                                <button href="#" id="btnAccount" class="text-gray-400 bg-gray-600 text-white hover:text-white hover:bg-gray-800 hover:duration-300 group flex gap-x-3 rounded-r-2xl p-2 text-sm leading-6 font-semibold"
                                onClick="DataAccount(this)" data-username="{{ Session::get('username') }}">
                                    <i class='bx bx-edit text-2xl'></i>
                                    <span class="my-auto overflow-x-hidden">ข้อมูลของฉัน</span>
                                </button>
                                <a href="{{ Route('Logout') }}" id="Checklist" class="text-gray-400 bg-rose-500 text-white hover:text-white hover:bg-rose-600 hover:duration-300 group flex gap-x-3 rounded-r-2xl p-2 text-sm leading-6 font-semibold">
                                    <i class='bx bx-log-out text-2xl'></i>
                                    <span class="my-auto overflow-x-hidden">ออกจากระบบ</span>
                                </a>
                            </div>
                        </li>
                    </ul>
                </nav>
            </div>
        </div>

        
        <!-- START TOPBAR MOBILE -->
        <div class="z-50 absolute w-full hidden max-md:block">
            <div onClick="menuButton()" class="p-1 w-fit bg-[#CDD4E8] ml-auto right-0 mr-4 mt-4 rounded-md border border-gray-400 hover:bg-gray-100 duration-300 cursor-pointer" id="menuButton">
                <i id="menu-open" class='bx bx-menu text-[1.5rem]'></i>
            </div>
        </div>
        <div class="hidden bg-gray-900 px-6 pb-3 flex flex-col md:hidden" id="topbar">
            <div class="flex items-center">
                <img class="w-[100px] flex my-auto pt-4" src="https://www.kingsmen-cmti.com/images/logo.png" alt="logo">
            </div>
            <nav class="flex-1 grow mt-4">
                <ul role="list" class="flex flex-col h-full justify-between">
                    <li class="grow">
                        <ul role="list" class="-mx-2 space-y-1">
                            <li>
                                <a href="{{ Route('Dashboard') }}" id="Dashboard_mobile" class="text-gray-400 hover:text-white hover:bg-gray-800 hover:duration-300 group flex gap-x-3 rounded-md p-2 text-md leading-6 font-semibold">
                                    <i class='bx bx-home text-2xl'></i>
                                    <span class="my-auto overflow-x-hidden">แดชบอร์ด</span>
                                </a>
                            </li>
                            @if($sessionRole != '1')
                                <li>
                                    <a href="{{ Route('Users') }}" id="Users_mobile" class="text-gray-400 hover:text-white hover:bg-gray-800 hover:duration-300 group flex gap-x-3 rounded-md p-2 text-md leading-6 font-semibold">
                                    <i class='bx bxs-user-account text-2xl' ></i>
                                        <span class="my-auto overflow-x-hidden">พนักงาน</span>
                                    </a>
                                </li>
                                <li>
                                    <a href="{{ Route('Projects') }}" id="Projects_mobile" class="text-gray-400 hover:text-white hover:bg-gray-800 hover:duration-300 group flex gap-x-3 rounded-md p-2 text-md leading-6 font-semibold">
                                        <i class='bx bxs-book-content text-2xl' ></i>
                                        <span class="my-auto overflow-x-hidden truncate">โปรเจกต์</span>
                                    </a>
                                </li>
                            @endif
                            <li>
                                <a href="{{ Route('Checklist') }}" id="Checklist_mobile" class="text-gray-400 hover:text-white hover:bg-gray-800 hover:duration-300 group flex gap-x-3 rounded-md p-2 text-md leading-6 font-semibold">
                                    <i class='bx bx-check-square text-2xl' ></i>
                                    <span class="my-auto overflow-x-hidden truncate">เช็คลิสต์</span>
                                </a>
                            </li>
                            <div class="grid grid-cols-2 gap-2">
                                <li>
                                    <a href="#" id="btnAccount" class="text-gray-400 text-gray-400 hover:text-white hover:bg-gray-800 hover:duration-300 group flex gap-x-3 rounded-md p-2 text-md leading-6 font-semibold"
                                    onClick="DataAccount(this)" data-username="{{ Session::get('username') }}">
                                        <i class='bx bx-edit text-2xl'></i>
                                        <span class="my-auto overflow-x-hidden truncate">ข้อมูลของฉัน</span>
                                    </a>
                                </li>
                                <li>
                                    <a href="{{ Route('Logout') }}" id="Logout" class="bg-rose-400 text-white hover:text-white hover:bg-rose-800 hover:duration-300 group flex gap-x-3 rounded-md p-2 text-md leading-6 font-semibold">
                                        <i class='bx bx-log-out text-2xl'></i>
                                        <span class="my-auto overflow-x-hidden truncate">ออกจากระบบ</span>
                                    </a>
                                </li>
                            </div>
                        </ul>
                    </li>
                </ul>
            </nav>
        </div>
        <!-- END TOPBAR MOBILE -->

        <div class="relative w-auto max-md:w-[100%] max-h-[100vh] overflow-y-auto">
            @yield('Dashboard')
            @yield('Users')
            @yield('Projects')
            @yield('Checklist')
            @yield('ChecklistSelected')
        </div>
        
        <!-- Modal Account -->
        <div id="modalAccount" class="modalAccount modal hidden z-[100] fixed pt-[100px] left-0 top-0 w-[100%] h-[100%] overflow-auto max-md:px-[10px]">
            <!-- Modal content -->
            <div class="modal-content bg-white m-auto p-[20px] rounded-md drop-shadow-xl xl:w-[50%] lg:w-[60%] md:w-[60%] sm:w-[70%] max-md:mt-[-45px]">
                <div class="flex items-center">
                    <p class="text-[20px] font-bold w-full ml-4 text-center">แก้ไขบัญชีนี้</p>
                    <span class="closeAccount text-gray-500 text-[30px] font-medium absolute top-0 right-0 mr-4 hover:text-indigo-600 cursor-pointer">&times;</span>
                </div>
                <hr class="mt-4">
                <div class="mt-2">
                    <form action="#!" method="post" onsubmit="return false;">
                        @csrf
                        <input type="text" id="acc_id" class="hidden" readonly>
                        <div class="grid gap-6 mb-6 grid-cols-2">
                            <div class="max-md:col-span-2">
                                <label for="acc_username" class="block mb-2 text-md font-medium text-gray-700">ชื่อผู้ใช้</label>
                                <input type="text" id="acc_username" class="bg-gray-200 border border-gray-300 text-gray-700 text-md font-light rounded-lg  block w-full p-2 outline-none cursor-not-allowed" readonly>
                            </div>
                            <div class="relative w-full max-md:col-span-2">
                                <label for="acc_password" class="block mb-2 text-md font-medium text-gray-700">รหัสผ่าน <span class="text-red-800 text-xl">*</span></label>
                                <div class="absolute inset-y-0 right-0 flex items-center px-2 z-10 mt-8">
                                    <input class="hidden js-password-toggle" id="toggle" type="checkbox" />
                                    <label class="js-password-label bg-gray-300 hover:bg-gray-400 duration-300 rounded px-2 py-1 text-sm text-gray-600 cursor-pointer" for="toggle">แสดง</label>
                                </div>
                                <div class="relative float-label-input">
                                    <input type="password" id="acc_password" class="js-password bg-gray-50 border border-gray-300 text-gray-700 text-md font-light rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2 outline-none" placeholder="รหัสผ่านขั้นต่ำ 4 ตัวอักษร">
                                </div>
                            </div>
                            <div>
                                <label for="acc_firstname" class="block mb-2 text-md font-medium text-gray-700">ชื่อ <span class="text-red-800 text-xl">*</span></label>
                                <input type="text" id="acc_firstname" class="bg-gray-50 border border-gray-300 text-gray-700 text-md font-light rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2 outline-none" placeholder="กรุณากรอกชื่อ" required>
                            </div>
                            <div>
                                <label for="acc_lastname" class="block mb-2 text-md font-medium text-gray-700">นามสกุล <span class="text-red-800 text-xl">*</span></label>
                                <input type="text" id="acc_lastname" class="bg-gray-50 border border-gray-300 text-gray-700 text-md font-light rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2 outline-none" placeholder="กรุณากรอกนามสกุล" required>
                            </div>
                            <div class="max-lg:col-span-2">
                                <p class="block mb-2 text-md font-medium text-gray-700">รูปภาพผู้ใช้</p>
                                <div class="flex items-center space-x-2 bg-gray-200 rounded-md w-full">
                                    <div class="shrink-0 ml-1 mt-1 mb-1">
                                        <img id='_image_account' class="h-11 w-11 object-cover rounded-full" src="https://icons-for-free.com/iconfiles/png/512/mountains+photo+photos+placeholder+sun+icon-1320165661388177228.png" alt="Current profile photo" />
                                    </div>
                                    <label class="block w-fit">
                                        <span class="sr-only">Choose profile photo</span>
                                        <input type="file"  onChange={fileChosenLayout(event)} id="_acc_image" name="image" accept="image/png, image/jpeg" class="block w-full text-sm text-slate-500
                                            file:mr-4 file:py-2 file:px-4
                                            file:rounded-full file:border-0
                                            file:text-sm file:font-semibold
                                            file:bg-blue-50 file:text-blue-700
                                            hover:file:bg-blue-100 duration-300
                                        "/>
                                    </label>
                                </div>
                            </div>
                        </div>
                        <hr class="mb-1 mt-3">
                        <button type="submit" onClick="AccountEdit()" class="text-white font-medium rounded-lg text-md w-full sm:w-full px-5 py-2 text-center bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300">บันทึกการแก้ไข</button>
                    </form>
                </div>
            </div>
        </div>
        
        @yield('script')
    </body>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
        $(document).on('click', '.closeAccount', function () {
            var modal = document.getElementById("modalAccount");
            modal.classList.add("fade-out-modal");

            // After the animation is complete (0.5s in this case), you can remove the modal from the DOM
            setTimeout(function() {
                modal.style.display = "none";
                modal.classList.remove("fade-out-modal");
            }, 500);
        });

        const currentRoute = '@php echo $currentRoute; @endphp';
        console.log('currentRoute: ' + currentRoute);
        if(currentRoute == 'Dashboard' || currentRoute == 'Users' || currentRoute == 'Projects' || currentRoute == 'Checklist') {
            document.getElementById(currentRoute).classList.add("bg-gray-800");
            document.getElementById(currentRoute).classList.add("text-white");
            document.getElementById(currentRoute+'_mobile').classList.add("bg-gray-800");
            document.getElementById(currentRoute+'_mobile').classList.add("text-white");
        } else if(currentRoute == 'ChecklistSelected' || currentRoute == 'SearchChecklists' || currentRoute == 'SearchProjectsChecklist') {
            document.getElementById('Checklist').classList.add("bg-gray-800");
            document.getElementById('Checklist').classList.add("text-white");
            document.getElementById('Checklist_mobile').classList.add("bg-gray-800");
            document.getElementById('Checklist_mobile').classList.add("text-white");
        } else if(currentRoute == 'SearchUsers') {
            document.getElementById('Users').classList.add("bg-gray-800");
            document.getElementById('Users').classList.add("text-white");
            document.getElementById('Users_mobile').classList.add("bg-gray-800");
            document.getElementById('Users_mobile').classList.add("text-white");
        } else if(currentRoute == 'SearchProjects') {
            document.getElementById('Projects').classList.add("bg-gray-800");
            document.getElementById('Projects').classList.add("text-white");
            document.getElementById('Projects_mobile').classList.add("bg-gray-800");
            document.getElementById('Projects_mobile').classList.add("text-white");
        }

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
            })

        var _image64_layout = '';
        function fileChosenLayout(event) {
            this.fileToDataUrlLayout(event, src => this.fileHanddleLayout(src));
        }
        function fileToDataUrlLayout(event, callback) {
            if (! event.target.files.length){ 
                callback('');
                return
            }

            let file = event.target.files[0],
                reader = new FileReader();

            reader.readAsDataURL(file);
            reader.onload = function (e) {
                var img = new Image;
                img.src = e.target.result;
                img.onload = function(){
                    var canvas = document.createElement('canvas');
                    var ctx = canvas.getContext('2d');
                    var cw = canvas.width;
                    var ch = canvas.height;
                    var maxW = '1920';
                    var maxH = '1080';

                    var iw = img.width;
                    var ih = img.height;
                    if(iw <= maxW || ih <= maxH) {
                        var _avatar_base64 = img.src;
                    }else {
                        var scale = Math.min((maxW/iw),(maxH/ih));
                        var iwScaled = iw * scale;
                        var ihScaled = ih * scale;
                        canvas.width = iwScaled;
                        canvas.height = ihScaled;
                        ctx.drawImage(img,0,0,iwScaled,ihScaled);
                        var converted_img = canvas.toDataURL();
                        var _avatar_base64 = converted_img;        
                    }                        
                    callback(_avatar_base64);                        
                }					
            };
        }
        function fileHanddleLayout(src){
            $("#_image_account").css("display","block");
            $("#_image_account").attr("src", src);
            _image64_layout = src;
        }

        function cogRotate() {
            var element = document.getElementById("user");
            element.classList.toggle("hidden");
            var cogRotate = document.getElementById("cogRotate");
            cogRotate.classList.toggle("bg-gray-800");
            cogRotate.classList.toggle("rounded-md");
            var cog = document.getElementById("bx-cog");
            cog.classList.toggle("rotate-180");
        }
        
        function menuButton() {
            var topbar = document.getElementById("topbar");
            topbar.classList.toggle("hidden");
            topbar.classList.toggle("fade-in-topbar");
        }

        function DataAccount(element){
            fetch("{{ Route('DataAccount') }}", {
                method: "POST",
                headers: {
                    "Content-Type": "application/json",
                    "Accept": "application/json",
                    "X-CSRF-Token": '{{csrf_token()}}'
                },
                body:JSON.stringify(
                    {
                        username: $(element).data('username')
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

                $('.modal-content #acc_id').val(data.id);
                $('.modal-content #acc_username').val(data.username);
                $('.modal-content #acc_password').val(data.password);
                $('.modal-content #acc_firstname').val(data.firstname);
                $('.modal-content #acc_lastname').val(data.lastname);
                if(data.image) {
                    $('.modal-content #_image_account').attr("src", '{{ URL('/uploads/') }}/'+data.image);
                    $('.modal-content #_image_account').removeClass('hidden');
                }
                $("#modalAccount").css("display","block");

                var div_user = document.getElementById("user");
                div_user.classList.toggle("hidden");
                var topbar = document.getElementById("topbar");
                topbar.classList.addClass("hidden");
            })
            .catch((er) => {
                console.log('Error' + er);
            });
        }

        function AccountEdit() {
            const minimum_password_length = 4;
            if(
                document.getElementById("acc_password").value >= minimum_password_length && 
                document.getElementById("acc_password").value != '' && 
                document.getElementById("acc_firstname").value != ''
                ) {
                fetch("{{ Route('AccountEdit') }}", {
                    method: "POST",
                    headers: {
                        "Content-Type": "application/json",
                        "Accept": "application/json",
                        "X-CSRF-Token": '{{csrf_token()}}'
                    },
                    body:JSON.stringify(
                        {
                            id: document.getElementById("acc_id").value,
                            password: document.getElementById("acc_password").value,
                            firstname: document.getElementById("acc_firstname").value,
                            image64: _image64_layout
                        }
                    )
                })
                .then(async response => {
                    const isJson = response.headers.get('content-type')?.includes('application/json');
                    const data = isJson ? await response.json() : null; 

                    console.log(data);
                    if(!response.ok){
                        const error = (data && data.errorMessage) || "{{trans('general.warning.system_failed')}}" + " (CODE:"+response.status+")";
                        return Promise.reject(error);
                    }

                    Swal.fire({
                            position: 'center',
                            icon: 'success',
                            title: 'แก้ไขบัญชีสำเร็จ',
                            timer: 1000,
                            timerProgressBar: true
                    }).then((result) => {
                        location.reload();
                    })
                })
                .catch((er) => {
                    console.log('Error' + er);
                    Swal.fire({
                        position: 'center',
                        icon: 'error',
                        title: 'แก้ไขบัญชีไม่สำเร็จ!'
                    })
                });
            }
        }
    </script>
</html>
