<title>Users | Kingsmen CMTI</title>

@extends('Admin/LayoutAdmin')

@section('Users')
    <section class="relative h-[100vh] grow bg-[#CDD4E8]">
        <div class="my-auto flex p-4">
            <span class="font-bold text-[24px] flex pl-5">จัดการพนักงาน</span>
            <button class="max-md:hidden bg-green-500 font-medium p-1 rounded-md text-white flex items-center ml-auto mr-0 hover:bg-green-600 duration-150" id="btnAdd">
                <i class='bx bx-plus'></i> เพิ่มพนักงาน
            </button>
        </div>
        <button class="hidden max-md:block bg-green-500 font-medium p-1 ml-8 mb-3 mt-[-9px] rounded-md text-white flex items-center hover:bg-green-600 duration-150" id="btnAdd_mobile">
            <i class='bx bx-plus'></i> เพิ่มพนักงาน
        </button>
        
        <div class="flex items-center justify-center ml-5">
            <i class='bx bxs-circle text-[0.5rem]'></i>
            <hr class="bg-blue-300 border-solid border-1 border-gray-900 w-full ml-[-2px]">
        </div>

        <div class="p-5 bg-[#CDD4E8]">

            <!-- START SEARCH -->
            <div class="grid grid-cols-3 max-lg:grid-cols-2 max-md:grid-cols-1">
                <form action="{{ Route('SearchUsers') }}" method="get" class="col-start-3 max-lg:col-start-2 max-md:col-start-1"> 
                    <label for="default-search" class="mb-2 text-sm font-medium text-gray-900 sr-only dark:text-white">Search</label>
                    <div class="relative">
                        <div class="absolute inset-y-0 left-0 flex items-center pl-3 pointer-events-none">
                            <svg class="w-4 h-4 text-gray-500 dark:text-gray-400" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 20 20">
                                <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m19 19-4-4m0-7A7 7 0 1 1 1 8a7 7 0 0 1 14 0Z"/>
                            </svg>
                        </div>
                        <input type="search" name="keyword" class="block w-full p-2 pl-10 text-sm text-gray-900 border border-gray-300 rounded-2xl bg-gray-50 focus:ring-blue-500 focus:border-blue-500" value="{{ isset($keyword) ? $keyword : '' }}" placeholder="ค้นหาพนักงาน...">
                        <button type="submit" class="text-white font-medium text-sm px-3 py-1 bg-blue-700 rounded-2xl absolute top-0 right-0 mt-[4.5px] mr-2 hover:bg-blue-800 focus:ring-2 focus:ring-blue-300 duration-300">ค้นหา</button>
                    </div>
                </form>
            </div>
            <!-- END SEARCH -->

            <div class="relative overflow-x-auto rounded-3xl drop-shadow-md">
                <table class="w-full max-md:hidden bg-blue-200">
                    <thead class="text-gray-700 uppercase bg-gray-100 text-center text-[16px]">
                        <tr class="truncate">
                            <th scope="col" class="px-6 py-3 font-medium">
                                #
                            </th>
                            <th scope="col" class="px-6 py-3 font-medium">
                                ชื่อผู้ใช้
                            </th>
                            <th scope="col" class="px-6 py-3 font-medium">
                                ชื่อ-นามสกุล
                            </th>
                            <th scope="col" class="px-6 py-3 font-medium">
                                รูปภาพ
                            </th>
                            <th scope="col" class="px-6 py-3 font-medium">
                                สิทธิ์การใช้
                            </th>
                            <th scope="col" class="px-6 py-3 font-medium">
                                การกระทำ
                            </th>
                        </tr>
                    </thead>
                    <tbody class="text-gray-500 text-[16px] text-center">
                        @if($users_paginate)
                            @php
                                $count = 1;
                            @endphp
                            @foreach($users_paginate as $user_data)
                                <tr class="bg-white font-light border">
                                    <td class="px-3 py-4">
                                        {{ $count }}
                                    </td>
                                    <td class="px-3 py-4">
                                        {{ $user_data->username }}
                                    </td>
                                    <td class="px-3 py-4 truncate">
                                        {{ $user_data->firstname . ' ' . $user_data->lastname }}
                                    </td>
                                    <td class="px-3 py-4">
                                        @if($user_data->image)
                                            <div class="flex flex-wrap justify-center items-center">
                                                <div class="relative bg-white w-[60px] h-[60px] rounded p-1 overflow-hidden border">
                                                    <img src="{{ URL('/uploads/'.$user_data->image) }}" alt="" class="w-full h-full object-cover my-auto rounded" alt="logo">
                                                </div>
                                            </div>
                                        @else
                                            -
                                        @endif
                                    </td>
                                    <td class="px-3 py-4">
                                        @if($user_data->role == '1')
                                            พนักงาน
                                        @else
                                            แอดมิน
                                        @endif
                                    </td>
                                    <td class="px-3 py-4 truncate">
                                        <button class="bg-blue-500 text-white p-1 px-2 rounded-md hover:bg-blue-600 duration-150 btnEdit" id="btnEdit" 
                                            data-id="{{ $user_data->id }}" data-firstname="{{ $user_data->firstname }}" data-lastname="{{ $user_data->lastname }}"
                                            data-username="{{ $user_data->username }}" data-password="{{ $user_data->password }}" data-role="{{ $user_data->role }}"
                                            data-image="{{ asset('uploads/'.$user_data->image) }}">แก้ไข</button>
                                        <button class="bg-red-500 w-fit text-white p-1 px-2 rounded-md hover:bg-red-600 duration-150 btnDelete" id="btnDelete" 
                                            data-id="{{ $user_data->id }}" data-username="{{ $user_data->username }}">ลบบัญชี</button>
                                    </td>
                                </tr>
                                @php
                                    $count++;
                                @endphp
                            @endforeach
                        @else
                            <tr class="bg-white">
                                <td scope="row" colspan="6" class="px-6 py-4 whitespace-nowrap text-center">
                                    <p class="text-center text-gray-500 font-light">ไม่พบข้อมูลพนักงาน</p>
                                </td>
                            </tr>
                        @endif
                    </tbody>
                </table>

                <!-- START MOBILE -->
                @if($users_paginate)
                    @php
                        $count = 1;
                    @endphp
                    <div class="bg-white p-4 rounded-t-3xl hidden max-md:block">
                        @foreach($users_paginate as $user_data)
                            <div class="grid grid-cols-6 flex items-center relative">
                                <div class="absolute top-0 right-0 bg-gray-200 rounded-full px-2 text-gray-500 text-[14px]"># {{ $count }}</div>
                                <div class="row-span-3 w-[100%] pr-2">
                                    @if($user_data->image)
                                        <img src="{{ URL('/uploads/'.$user_data->image) }}" alt="" class="w-full h-auto object-scale-down mx-auto rounded border p-1">
                                    @else
                                        <img src="{{ URL('/uploads/'.'user.png') }}" alt="" class="w-full h-auto object-scale-down mx-auto rounded border p-1">
                                    @endif
                                </div>
                                <p class="col-span-5 font-medium text-[16px] text-gray-500 truncate">ชื่อผู้ใช้: <span class="font-light">{{ $user_data->username }}</span></p>
                                <p class="col-span-5 font-medium text-[16px] text-gray-500 truncate">ชื่อ-นามสกุล: <span class="font-light">{{ $user_data->firstname . ' ' . $user_data->lastname }}</span></p>
                                @if($user_data->role == '1')
                                    <p class="col-span-5 font-medium text-[16px] text-gray-500 truncate">สิทธิ์การใช้: <span class="font-light">พนักงาน</span></p>
                                @else
                                    <p class="col-span-5 font-medium text-[16px] text-gray-500 truncate">สิทธิ์การใช้: <span class="font-light">แอดมิน</span></p>
                                @endif
                            </div>
                            <div class="grid grid-cols-2 gap-1 mt-2">
                                <button class="bg-blue-500 text-white text-[14px] py-1 rounded-3xl hover:bg-blue-600 duration-150 btnEdit" id="btnEdit" 
                                    data-id="{{ $user_data->id }}" data-firstname="{{ $user_data->firstname }}" data-lastname="{{ $user_data->lastname }}"
                                    data-username="{{ $user_data->username }}" data-password="{{ $user_data->password }}" data-role="{{ $user_data->role }}"
                                    data-image="{{ asset('uploads/'.$user_data->image) }}">แก้ไข</button>
                                <button class="bg-red-500 text-white text-[14px] py-1 rounded-3xl hover:bg-red-600 duration-150 btnDelete" id="btnDelete" 
                                    data-id="{{ $user_data->id }}" data-username="{{ $user_data->username }}">ลบบัญชี</button>
                            </div>
                            <hr class="bg-blue-300 border-dashed border-gray-300 w-full my-2 rounded-2xl mt-4">
                            @php
                                $count++;
                            @endphp
                        @endforeach
                    </div>
                @else
                    <div class="bg-white p-4 rounded-3xl drop-shadow-md mb-2 hidden max-md:block">
                        <p class="text-center text-gray-500 font-light">ไม่พบข้อมูลพนักงาน</p>
                    </div>
                @endif
                <!-- END MOBILE -->
                {!! $users_paginate->links('Pagination.Users') !!}
                @include('Pagination.Users', ['users_paginate' => $users_paginate])
            </div>
        </div>
    </section>

    <!-- Modal Add -->
    <div id="modalAdd" class="modal hidden fixed z-[100] pt-[100px] left-0 top-0 w-[100%] h-[100%] overflow-auto max-md:px-[10px]">
        <!-- Modal content -->
        <div class="modal-content bg-white m-auto p-[20px] rounded-md drop-shadow-xl xl:w-[50%] lg:w-[60%] md:w-[60%] sm:w-[70%] mt-[-50px] max-md:mt-[-45px]">
            <div class="flex items-center">
                <p class="text-[20px] font-bold w-full ml-4 text-center">เพิ่มพนักงาน</p>
                <span class="closeAdd text-gray-500 text-[30px] font-medium absolute top-0 right-0 mr-4 hover:text-indigo-600 cursor-pointer">&times;</span>
            </div>
            <hr class="mt-4">
            <div class="mt-2">
                <form action="#!" method="post" onsubmit="return false;">
                    @csrf
                    <div class="grid gap-6 mb-6 grid-cols-2">
                        <div>
                            <label for="firstname" class="block mb-2 text-md font-medium text-gray-700">ชื่อ <span class="text-red-800 text-xl">*</span></label>
                            <input type="text" id="firstname" class="bg-gray-50 border border-gray-300 text-gray-700 font-light text-md rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2 outline-none" placeholder="กรุณากรอกชื่อ" required>
                        </div>
                        <div>
                            <label for="lastname" class="block mb-2 text-md font-medium text-gray-700">นามสกุล <span class="text-red-800 text-xl">*</span></label>
                            <input type="text" id="lastname" class="bg-gray-50 border border-gray-300 text-gray-700 font-light text-md rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2 outline-none" placeholder="กรุณากรอกนามสกุล" required>
                        </div>
                        <div>
                            <label for="username" class="block mb-2 text-md font-medium text-gray-700">ชื่อผู้ใช้ <span class="text-red-800 text-xl">*</span></label>
                            <input type="text" id="username" class="bg-gray-50 border border-gray-300 text-gray-700 font-light text-md rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2 outline-none" placeholder="กรุณากรอกชื่อผู้ใช้" required>
                        </div>  
                        <div>
                            <label for="password" class="block mb-2 text-md font-medium text-gray-700">รหัสผ่าน <span class="text-red-800 text-xl">*</span></label>
                            <input type="text" id="password" class="bg-gray-50 border border-gray-300 text-gray-700 font-light text-md rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2 outline-none" placeholder="กรุณากรอกรหัสผ่าน" required>
                        </div>
                        <div class="max-lg:col-span-2">
                            <label for="role" class="block mb-2 text-md font-medium text-gray-700">สิทธิ์การใช้</label>
                            <select id="role" class="bg-gray-50 border border-gray-300 text-gray-700 font-light text-md rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2" required>
                                <option selected value="1" class="font-light">พนักงาน</option>
                                <option value="2" class="font-light">แอดมิน</option>
                            </select>
                        </div>
                        <div class="max-lg:col-span-2">
                            <p class="block mb-2 text-md font-medium text-gray-700">รูปภาพผู้ใช้</p>
                            <div class="flex items-center space-x-2 bg-gray-200 rounded-md w-full h-[43px]">
                                <div class="shrink-0 ml-1 mt-1 mb-1">
                                    <img id='_image_add' class="btnImage cursor-pointer bg-white p-1 h-10 w-10 object-cover rounded-full" src="https://icons-for-free.com/iconfiles/png/512/mountains+photo+photos+placeholder+sun+icon-1320165661388177228.png" alt="Current profile photo" />
                                </div>
                                <label class="block w-fit">
                                    <span class="sr-only">Choose profile photo</span>
                                    <input type="file"  onChange={fileChosen(event)} id="_image_add" name="image" accept="image/png, image/jpeg" class="block w-full text-sm text-slate-500
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
                    <hr class="mb-1">
                    <button type="submit" onClick="UserAdd()" class="text-white font-medium rounded-lg text-md w-full sm:w-full px-5 py-2 text-center bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300">บันทึกข้อมูล</button>
                </form>
            </div>
        </div>
    </div>

    <!-- Modal Edit -->
    <div id="modalEdit" class="modal hidden fixed z-[100] pt-[100px] left-0 top-0 w-[100%] h-[100%] overflow-auto max-md:px-[10px]">
        <!-- Modal content -->
        <div class="modal-content bg-white m-auto p-[20px] rounded-md drop-shadow-xl xl:w-[50%] lg:w-[60%] md:w-[60%] sm:w-[70%] mt-[-50px] max-md:mt-[-45px]">
            <div class="flex items-center">
                <p class="text-[20px] font-bold w-full ml-4 text-center">แก้ไขบัญชี</p>
                <span class="closeEdit text-gray-500 text-[30px] font-medium absolute top-0 right-0 mr-4 hover:text-indigo-600 cursor-pointer">&times;</span>
            </div>
            <hr class="mt-4">
            <div class="mt-2">
                <form action="#!" method="post" onsubmit="return false;">
                    @csrf
                    <input type="text" id="id_edit" class="hidden" readonly>
                    <div class="grid gap-6 mb-6 grid-cols-2">
                        <div>
                            <label for="firstname_edit" class="block mb-2 text-md font-medium text-gray-700">ชื่อ <span class="text-red-800 text-xl">*</span></label>
                            <input type="text" id="firstname_edit" class="bg-gray-50 border border-gray-300 text-gray-700 text-md font-light rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2 outline-none" placeholder="กรุณากรอกชื่อ" required>
                        </div>
                        <div>
                            <label for="lastname_edit" class="block mb-2 text-md font-medium text-gray-700">นามสกุล <span class="text-red-800 text-xl">*</span></label>
                            <input type="text" id="lastname_edit" class="bg-gray-50 border border-gray-300 text-gray-700 text-md font-light rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2 outline-none" placeholder="กรุณากรอกนามสกุล" required>
                        </div>
                        <div>
                            <label for="username_edit" class="block mb-2 text-md font-medium text-gray-700">ชื่อผู้ใช้ <span class="text-red-800 text-xl">*</span></label>
                            <input type="text" id="username_edit" class="bg-gray-50 border border-gray-300 text-gray-700 text-md font-light rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2 outline-none" placeholder="กรุณากรอกชื่อผู้ใช้ขั้นต่ำ 4 ตัวอักษร" required>
                            <input type="text" id="username_current" class="hidden" readonly>
                        </div>
                        <div class="relative w-full">
                                <label for="password_edit" class="block mb-2 text-md font-medium text-gray-700">รหัสผ่าน <span class="text-red-800 text-xl">*</span></label>
                                <div class="absolute inset-y-0 right-0 flex items-center px-2 z-10 mt-8">
                                    <input class="hidden js-password-toggle" id="toggle" type="checkbox" />
                                    <label class="js-password-label bg-gray-300 hover:bg-gray-400 duration-300 rounded px-2 py-1 text-sm text-gray-600 cursor-pointer" for="toggle">แสดง</label>
                                </div>
                                <div class="relative float-label-input">
                                    <input type="password" id="password_edit" class="js-password bg-gray-50 border border-gray-300 text-gray-700 text-md font-light rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2 outline-none" placeholder="รหัสผ่านขั้นต่ำ 4 ตัวอักษร">
                                </div>
                            </div>
                        <div class="max-lg:col-span-2">
                            <label for="role_edit" class="block mb-2 text-md font-medium text-gray-700">สิทธิ์การใช้</label>
                            <select id="role_edit" class="bg-gray-50 border border-gray-300 text-gray-700 text-md font-light rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2">
                                <option selected value="1" class="font-light">พนักงาน</option>
                                <option value="2" class="font-light">แอดมิน</option>
                            </select>
                        </div>
                        <div class="max-lg:col-span-2">
                            <p class="block mb-2 text-md font-medium text-gray-700">รูปภาพผู้ใช้</p>
                            <div class="flex items-center space-x-2 bg-gray-200 rounded-md w-full h-[43px]">
                                <div class="shrink-0 ml-1 mt-1 mb-1">
                                    <img id='_image_edit' class="btnImage cursor-pointer bg-white p-1 h-10 w-10 object-cover rounded-full" src="https://icons-for-free.com/iconfiles/png/512/mountains+photo+photos+placeholder+sun+icon-1320165661388177228.png" alt="Current profile photo" />
                                </div>
                                <label class="block w-fit">
                                    <span class="sr-only">Choose profile photo</span>
                                    <input type="file"  onChange={fileChosen(event)} id="_image_edit" name="image" accept="image/png, image/jpeg" class="block w-full text-sm text-slate-500
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
                    <hr class="mb-1">
                    <button type="submit" onClick="UserEdit()" class="text-white font-medium rounded-lg text-md w-full sm:w-full px-5 py-2 text-center bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300">บันทึกการแก้ไข</button>
                </form>
            </div>
        </div>
    </div>

    <!-- Modal Image -->
    <div id="modalImage" class="modalImage modal hidden fixed z-[101] left-0 top-0 w-[100%] h-[100%] overflow-auto">
        <!-- Modal content -->
        <div class="modal-content fixed inset-0 flex items-center justify-center max-md:px-[20px]">
            <div class="relative w-[640px] h-auto max-h-[90vh] object-cover bg-white rounded">
                <div class="w-auto h-auto flex justify-center border-2 rounded p-3">
                    <img id="_image" src="" alt="" class="w-auto h-auto object-cover bg-white">
                </div>
                <span class="closeImage text-black bg-white rounded-full drop-shadow text-[24px] font-bold h-fit font-medium absolute top-0 right-0 mt-2 mr-2 hover:text-indigo-600 hover:bg-indigo-200 duration-300 cursor-pointer"><i class='bx bx-x'></i></span>
            </div>
        </div>
    </div>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script type="text/javascript">
        $(document).ready(function () {
            // Modal Add
            $('#btnAdd').on('click', function () {
                $("#modalAdd").css("display","block");
            });
            $('.closeAdd').on('click', function () {
                var modal = document.getElementById("modalAdd");
                modal.classList.add("fade-out-modal");

                setTimeout(function() {
                    modal.style.display = "none";
                    modal.classList.remove("fade-out-modal");
                }, 500);
            });
            $('#btnAdd_mobile').on('click', function () {
                $("#modalAdd").css("display","block");
            });
            $('.closeAdd').on('click', function () {
                var modal = document.getElementById("modalAdd");
                modal.classList.add("fade-out-modal");

                setTimeout(function() {
                    modal.style.display = "none";
                    modal.classList.remove("fade-out-modal");
                }, 500);
            });

            // Modal Edit
            $('.btnEdit').on('click', function () {
                const username = '<?php echo Session::get('username')?>';
                if(username == $(this).data('username')) {
                    $('.modal-content #id_edit').val($(this).data('id'));
                    $('.modal-content #firstname_edit').val($(this).data('firstname'));
                    $('.modal-content #lastname_edit').val($(this).data('lastname'));
                    $('.modal-content #username_edit').val($(this).data('username'));
                    $('.modal-content #username_current').val($(this).data('username'));
                    $('.modal-content #password_edit').val($(this).data('password'));
                    $('.modal-content #role_edit').val($(this).data('role')).prop('disabled', true);
                    if($(this).data('image') == 'http://127.0.0.1:8000/uploads') {
                    } else {
                        $('.modal-content #_image_edit').attr("src", $(this).data('image'));
                        $('.modal-content #_image_edit').removeClass('hidden');
                    }
                } else {
                    $('.modal-content #id_edit').val($(this).data('id'));
                    $('.modal-content #firstname_edit').val($(this).data('firstname'));
                    $('.modal-content #lastname_edit').val($(this).data('lastname'));
                    $('.modal-content #username_edit').val($(this).data('username'));
                    $('.modal-content #username_current').val($(this).data('username'));
                    $('.modal-content #password_edit').val($(this).data('password'));
                    $('.modal-content #role_edit').val($(this).data('role'));
                    if($(this).data('image') == 'http://127.0.0.1:8000/uploads') {
                    } else {
                        $('.modal-content #_image_edit').attr("src", $(this).data('image'));
                        $('.modal-content #_image_edit').removeClass('hidden');
                    }
                }
                $("#modalEdit").css("display","block");
            });
            $('.closeEdit').on('click', function () {
                var modal = document.getElementById("modalEdit");
                modal.classList.add("fade-out-modal");
                $('.modal-content #role_edit').prop('disabled', false);

                setTimeout(function() {
                    modal.style.display = "none";
                    modal.classList.remove("fade-out-modal");
                }, 500);
            });

            // SweetAlert Delete
            $('.btnDelete').on('click', function () {
                Swal.fire({
                    title: `คุณแน่ใจหรือไม่ที่ต้องการลบผู้ใช้นี้? <br><b class="text-rose-800 font-medium">(ชื่อผู้ใช้: ${$(this).data('username')})</b>`,
                    text: "การดำเนินการนี้ไม่สามารถเรียกคืนได้",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'ใช่, ลบ',
                    cancelButtonText: 'ยกเลิก',
                    }).then((result) => {
                    if (result.isConfirmed) {
                        if($(this).data('username') != `@php echo Session::get('username'); @endphp`) {
                            id = $(this).data('id');
                            console.log('id = ', id);
                            UserDelete(id);
                        } else {
                            Swal.fire({
                                position: 'center',
                                icon: 'error',
                                title: 'คุณไม่สามารถลบบัญชีตัวเองได้!',

                            })
                        }
                    }
                })
            });

            // Modal Image
            $('.btnImage').on('click', function () {
                $('.modal-content #_image').attr("src", $(this).attr("src"));
                $("#modalImage").css("display", "block");
            });
            $('.closeImage').on('click', function () {
                var modal = document.getElementById("modalImage");
                modal.classList.add("fade-out-modalImage");

                setTimeout(function() {
                    modal.style.display = "none";
                    modal.classList.remove("fade-out-modalImage");
                }, 500);
            });
        });

        var _image64 = '';
        function fileChosen(event) {
            this.fileToDataUrl(event, src => this.fileHanddle(src));
        }
        function fileToDataUrl(event, callback) {
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
        function fileHanddle(src){
            $("#_image_add").css("display","block");
            $("#_image_add").attr("src", src);
            $("#_image_edit").attr("src", src);
            _image64 = src;
        }

        function UserAdd(){
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
                            lastname: document.getElementById("lastname").value,
                            role: document.getElementById("role").value,
                            image64: _image64
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
                        title: 'เพิ่มข้อมูลสำเร็จ',
                        timer: 1500,
                        timerProgressBar: true
                    }).then((result) => {
                        location.reload();
                    })
                }).catch((er) => {
                    console.log('Error: ' + er);
                    Swal.fire({
                        position: 'center',
                        icon: 'error',
                        title: 'เพิ่มข้อมูลไม่สำเร็จ!',
                        html: '<b class="text-rose-800">ชื่อผู้ใช้</b>นี้ถูกใช้ไปแล้ว'
                    })
                });
            } else {
                Swal.fire({
                    position: 'center',
                    icon: 'error',
                    title: 'เพิ่มข้อมูลไม่สำเร็จ!',
                    html: 'ความยาวของชื่อผู้ใช้และรหัสผ่าน<br>จะต้องมีอย่างน้อย <b class="text-rose-800">4</b> ตัวอักษร <b class="text-rose-800">และไม่มีช่องว่าง</b>'
                })
            }
        }

        async function UserEdit() {
            if(
                document.getElementById("firstname_edit").value != '' &&
                document.getElementById("lastname_edit").value != '' &&
                document.getElementById("username_edit").value != '' &&
                document.getElementById("password_edit").value != ''
            ) {
                fetch("{{ Route('UserEdit') }}", {
                    method: "POST",
                    headers: {
                        "Content-Type": "application/json",
                        "Accept": "application/json",
                        "X-CSRF-Token": '{{csrf_token()}}'
                    },
                    body:JSON.stringify(
                        {
                            id: document.getElementById("id_edit").value,
                            firstname: document.getElementById("firstname_edit").value,
                            lastname: document.getElementById("lastname_edit").value,
                            username: document.getElementById("username_edit").value,
                            username_current: document.getElementById("username_current").value,
                            password: document.getElementById("password_edit").value,
                            role: document.getElementById("role_edit").value,
                            image64: _image64
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
                        title: 'แก้ไขข้อมูลสำเร็จ',
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
                        title: 'แก้ไขข้อมูลไม่สำเร็จ!',
                        html: '<b class="text-rose-800">ชื่อผู้ใช้</b>นี้ถูกใช้ไปแล้ว'
                    })
                });
            }
        }

        function UserDelete(id) {
            fetch("{{ Route('UserDelete') }}", {
                method: "POST",
                headers: {
                    "Content-Type": "application/json",
                    "Accept": "application/json",
                    "X-CSRF-Token": '{{csrf_token()}}'
                },
                body:JSON.stringify(
                    {
                        id: id
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
                    title: 'ลบข้อมูลสำเร็จ',
                    timer: 1000,
                    timerProgressBar: true
                }).then((result) => {
                    location.reload();
                })
            })
            .catch((er) => {
                console.log('Error: ' + er);
                Swal.fire({
                    position: 'center',
                    icon: 'error',
                    title: 'ลบข้อมูลไม่สำเร็จ!'
                })
            });
        }

    </script>
@endsection