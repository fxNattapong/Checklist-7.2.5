@php 
    $currentRoute = Request::route()->getName();
    $projectcode = \Session::get('project_code');
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
                <div class="flex items-center mt-4 grid grid-cols-4">
                    <div class="relative bg-white w-[60px] h-[60px] rounded-full p-2 overflow-hidden">
                        <img class="w-full h-full object-cover my-auto" src="{{  URL('/uploads/'.$projects->image) }}" alt="logo">
                    </div>
                    <p class="col-span-3 ml-4 text-[18px] text-white font-medium">{{ $projects->project_name}}</p>
                </div>
                <nav class="flex-1 grow mt-4">
                    <ul role="list" class="flex flex-col h-full justify-between">
                        <li class="grow">
                            <ul role="list" class="-mx-2 space-y-1">
                                <li>
                                    <a href="{{ Route('DashboardUser', [$projectcode]) }}" id="DashboardUser" class="text-gray-400 hover:text-white hover:bg-gray-800 hover:duration-300 group flex gap-x-3 rounded-md p-2 text-md leading-6 font-semibold">
                                        <i class='bx bx-home text-2xl'></i>
                                        <span class="my-auto overflow-x-hidden">แดชบอร์ด</span>
                                    </a>
                                </li>
                                <li>
                                    <a href="{{ Route('ChecklistUser', [$projectcode]) }}" id="ChecklistUser" class="text-gray-400 hover:text-white hover:bg-gray-800 hover:duration-300 group flex gap-x-3 rounded-md p-2 text-md leading-6 font-semibold">
                                        <i class='bx bx-check-square text-2xl' ></i>
                                        <span class="my-auto overflow-x-hidden">เช็คลิสต์</span>
                                    </a>
                                </li>
                            </ul>
                        </li>
                    </ul>
                </nav>
            </div>
        </div>

        
        <!-- START TOPBAR MOBILE -->
        <div class="z-50 absolute w-full hidden max-md:block">
            <div onClick="menuButton()" class="p-1 w-fit bg-[#CDD4E8] ml-auto right-0 mr-4 mt-4 rounded-md border border-gray-400 hover:bg-gray-100 duration-300 cursor-pointer" id="menuButton">
                <i class='bx bx-menu text-[1.5rem]'></i>
            </div>
        </div>
        <div class="hidden bg-gray-900 px-6 pb-3 flex flex-col md:hidden" id="topbar">
            <div class="flex items-center pt-2">
                <div class="relative bg-white w-[60px] h-[60px] rounded-full p-2 overflow-hidden">
                    <img class="w-full h-full object-cover my-auto" src="{{  URL('/uploads/'.$projects->image) }}" alt="logo">
                </div>
                <p class="ml-4 text-[20px] text-white font-medium whitespace-nowrap overflow-hidden">{{ $projects->project_name}}</p>
            </div>
            <nav class="flex-1 grow mt-4">
                <ul role="list" class="flex flex-col h-full justify-between">
                    <li class="grow">
                        <ul role="list" class="-mx-2 space-y-1">
                            <li>
                                <a href="{{ Route('DashboardUser', [$projectcode]) }}" id="Dashboard_mobile" class="text-gray-400 hover:text-white hover:bg-gray-800 hover:duration-300 group flex gap-x-3 rounded-md p-2 text-md leading-6 font-semibold">
                                    <i class='bx bx-home text-2xl'></i>
                                    <span class="my-auto overflow-x-hidden">แดชบอร์ด</span>
                                </a>
                            </li>
                            <li>
                                <a href="{{ Route('ChecklistUser', [$projectcode]) }}" id="Checklist_mobile" class="text-gray-400 hover:text-white hover:bg-gray-800 hover:duration-300 group flex gap-x-3 rounded-md p-2 text-md leading-6 font-semibold">
                                    <i class='bx bx-check-square text-2xl' ></i>
                                    <span class="my-auto overflow-x-hidden">เช็คลิสต์</span>
                                </a>
                            </li>
                        </ul>
                    </li>
                </ul>
            </nav>
        </div>
        <!-- END TOPBAR MOBILE -->

        <div class="relative w-[calc(100% - 250px)] max-md:w-[100%] max-h-[100vh] overflow-y-auto">
            @yield('Dashboard')
            @yield('Checklist')
            @yield('ChecklistSelected')
        </div>
        
        @yield('script')
    </body>

    <script>
        const currentRoute = '@php echo $currentRoute; @endphp';
        console.log(currentRoute);
        if(currentRoute == 'DashboardUser') {
            document.getElementById('DashboardUser').classList.add("bg-gray-800");
            document.getElementById('DashboardUser').classList.add("text-white");
            document.getElementById('Dashboard_mobile').classList.add("bg-gray-800");
            document.getElementById('Dashboard_mobile').classList.add("text-white");
        } else {
            document.getElementById('ChecklistUser').classList.add("bg-gray-800");
            document.getElementById('ChecklistUser').classList.add("text-white");
            document.getElementById('Checklist_mobile').classList.add("bg-gray-800");
            document.getElementById('Checklist_mobile').classList.add("text-white");
        }
        
        function menuButton() {
            var topbar = document.getElementById("topbar");
            topbar.classList.toggle("hidden");
            topbar.classList.toggle("fade-in-sidebar");
        }
    </script>
</html>
