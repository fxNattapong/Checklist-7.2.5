<title>Projects | Kingsmen CMTI</title>

@extends('Admin/LayoutAdmin')

@section('Projects')
    <section class="relative h-[100vh] grow bg-[#CDD4E8]">
        <div class="my-auto flex p-4">
            <span class="font-bold text-[24px] flex pl-5">จัดการโปรเจกต์</span>
            <button class="max-md:hidden bg-green-500 font-medium p-1 rounded-md text-white flex items-center ml-auto mr-0 hover:bg-green-600 duration-150" id="btnAdd">
                <i class='bx bx-plus'></i> เพิ่มโปรเจกต์
            </button>
        </div>
        <button class="hidden max-md:block bg-green-500 font-medium p-1 ml-8 mb-3 mt-[-9px] rounded-md text-white flex items-center hover:bg-green-600 duration-150" id="btnAdd_mobile">
            <i class='bx bx-plus'></i> เพิ่มโปรเจกต์
        </button>
        
        <div class="flex items-center justify-center ml-5">
            <i class='bx bxs-circle text-[0.5rem]'></i>
            <hr class="bg-blue-300 border-solid border-1 border-gray-900 w-full ml-[-2px]">
        </div>

        <div class="p-5 bg-[#CDD4E8]">
            <!-- START SEARCH -->
            <div class="grid grid-cols-3 max-lg:grid-cols-2 max-md:grid-cols-1">
                <form action="{{ Route('SearchProjects') }}" method="get" class="col-start-3 max-lg:col-start-2 max-md:col-start-1"> 
                    <div class="grid grid-cols-2 gap-2 mb-2">
                        <div class="relative">
                            <label for="start_date_search" class="absolute text-[12px] text-gray-700 bg-white rounded-full px-1 mt-[-10px] ml-2 border">วันที่เริ่ม</label>
                            <input type="date" name="start_date_search" oninput="validateDatesSearch();" class="bg-gray-50 border border-gray-300 text-gray-700 text-md font-light rounded-full focus:ring-blue-500 focus:border-blue-500 block w-full p-1 px-2 outline-none" value="{{ isset($start_date_search) ? $start_date_search : '' }}">
                        </div>
                        <div class="relative">
                            <label for="end_date_search" class="absolute text-[12px] text-gray-700 bg-white rounded-full px-1 mt-[-10px] ml-2 border">วันที่สิ้นสุด</label>
                            <input type="date" name="end_date_search" oninput="validateDatesSearch();" class="bg-gray-50 border border-gray-300 text-gray-700 text-md font-light rounded-full focus:ring-blue-500 focus:border-blue-500 block w-full p-1 px-2 outline-none" value="{{ isset($end_date_search) ? $end_date_search : '' }}">
                        </div>
                    </div>
                    <label for="default-search" class="mb-2 text-sm font-medium text-gray-900 sr-only dark:text-white">Search</label>
                    <div class="relative">
                        <div class="absolute inset-y-0 left-0 flex items-center pl-3 pointer-events-none">
                            <svg class="w-4 h-4 text-gray-500 dark:text-gray-400" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 20 20">
                                <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m19 19-4-4m0-7A7 7 0 1 1 1 8a7 7 0 0 1 14 0Z"/>
                            </svg>
                        </div>
                        <input type="search" name="keyword" class="block w-full p-2 pl-10 text-sm text-gray-900 border border-gray-300 rounded-2xl bg-gray-50 focus:ring-blue-500 focus:border-blue-500" value="{{ isset($keyword) ? $keyword : '' }}" placeholder="ค้นหาโปรเจกต์...">
                        <button type="submit" class="text-white font-medium text-sm px-3 py-1 bg-blue-700 rounded-2xl absolute top-0 right-0 mt-[4.5px] mr-2 hover:bg-blue-800 focus:ring-2 focus:ring-blue-300 duration-300">ค้นหา</button>
                    </div>
                </form>
            </div>
            <!-- END SEARCH -->

            <div class="relative overflow-x-auto rounded-3xl drop-shadow-md">
                <table class="w-full max-md:hidden table-fixed">
                    <thead class="text-gray-700 uppercase bg-gray-100 text-center text-[16px]">
                        <tr class="truncate">
                            <th scope="col" class="px-3 py-3 font-medium w-[140px]">
                                วันที่
                            </th>
                            <th scope="col" class="px-3 py-3 font-medium w-[80px]">
                                โลโก้บริษัท
                            </th>
                            <th scope="col" class="px-3 py-3 font-medium w-[200px]">
                                ชื่อโปรเจกต์
                            </th>
                            <th scope="col" class="px-3 py-3 font-medium w-[160px]">
                                ผู้รับผิดชอบ
                            </th>
                            <th scope="col" class="px-3 py-3 font-medium w-[155px]">
                                สถานะ
                            </th>
                            <th scope="col" class="px-3 py-3 font-medium w-[150px]">
                                ลิงก์สำหรับลูกค้า
                            </th>
                            <th scope="col" class="px-3 py-3 font-medium w-[260px]">
                                การกระทำ
                            </th>
                        </tr>
                    </thead>
                    <tbody class="text-gray-500 text-[16px] text-center">
                        @if(sizeof($projects_paginate))
                            @foreach($projects_paginate as $project_data)
                                <tr class="bg-white font-light border">
                                    <td class="hidden">{{ $project_data->id }}</td>
                                    <td scope="row" class="px-3 py-4 truncate">
                                        @php
                                            $start_date = date("d-m-Y", strtotime($project_data->start_date));
                                            $end_date = date("d-m-Y", strtotime($project_data->end_date));
                                            echo $start_date . "<br>ถึง<br> " . $end_date;
                                        @endphp
                                    </td>
                                    <td>
                                        <div class="flex flex-wrap items-center">
                                            <div class="relative bg-white w-[80px] h-[80px] rounded p-1 overflow-hidden border">
                                                <img src="{{ URL('/uploads/'.$project_data->image) }}" alt="" class="w-full h-full object-cover my-auto rounded" alt="logo">
                                            </div>
                                        </div>
                                    </td>
                                    <td class="px-3 py-4 truncate">
                                        {{ $project_data->project_name }}
                                    </td>
                                    <td class="px-3 py-4 truncate">
                                        {{ $project_data->manager_name }}
                                    </td>
                                    <td class="px-3 py-4">
                                        <div class="w-fit font-medium w-full text-center truncate">
                                            @if($project_data->status == '1')
                                                <p class="text-blue-500">กำลังดำเนินการ</p>
                                            @elseif($project_data->status == '2')
                                                <p class="text-rose-500">ขยายระยะเวลา</p>
                                            @else
                                                <p class="text-teal-500">เสร็จสิ้น</p>
                                            @endif
                                        </div>
                                    </td>
                                    <td class="px-0 py-4 text-center">
                                        <a href="{{ Route('DashboardUser', [$project_data->project_code]) }}" target="_blank"><i class='bx bx-window-open text-2xl hover:text-rose-600'></i></a>
                                    </td>
                                    <td class="px-0 py-4 truncate">
                                        <button class="bg-yellow-500 text-white p-1 px-2 rounded-md hover:bg-yellow-600 duration-150 btnLog" id="btnLog" 
                                            data-id="{{ $project_data->id }}" onClick="ProjectsLog(this)">บันทึก</button>
                                        <button class="bg-blue-500 text-white p-1 px-2 rounded-md hover:bg-blue-600 duration-150 btnEdit" id="btnEdit" 
                                            data-id="{{ $project_data->id }}" data-start_date="{{ $project_data->start_date }}" data-end_date="{{ $project_data->end_date }}" 
                                            data-email-company="{{ $project_data->email_company }}" data-email-customer="{{ $project_data->email_customer }}"
                                            data-project_name="{{ $project_data->project_name }}" data-manager_name="{{ $project_data->manager_name }}" data-description="{{ $project_data->description }}" 
                                            data-image="{{ asset('uploads/'.$project_data->image) }}" data-status="{{ $project_data->status }}">แก้ไข</button>
                                        <button class="bg-red-500 w-fit text-white p-1 px-2 rounded-md hover:bg-red-600 duration-150 btnDelete" id="btnDelete" 
                                            data-id="{{ $project_data->id }}" data-project_name="{{ $project_data->project_name }}">ลบโปรเจกต์</button>
                                    </td>
                                </tr>
                            @endforeach
                        @else
                            <tr class="bg-white">
                                <td scope="row" colspan="7" class="px-6 py-4 whitespace-nowrap text-center">
                                    ไม่มีข้อมูลโปรเจกต์
                                </td>
                            </tr>
                        @endif
                    </tbody>
                </table>

                <!-- START MOBILE -->
                @if($projects_paginate)
                    <div class="bg-white p-4 rounded-t-3xl hidden max-md:block">
                        @foreach($projects_paginate as $project_data)
                            <div class="relative grid grid-cols-2 truncate">
                                <span class="flex items-center">
                                    <div class="flex flex-wrap items-center gap-2">
                                        <div class="w-[60px] h-[60px] rounded overflow-hidden drop-shadow border border">
                                            <img src="{{ URL('/uploads/'.$project_data->image) }}" alt="" class="btnImage p-1 w-full h-full object-cover object-center hover:scale-90 duration-300 cursor-pointer">
                                        </div>
                                    </div>
                                    @if($project_data->status == '1')
                                        <p class="text-blue-600 text-[13px] font-light absolute top-0 right-0 bg-blue-200 rounded-2xl px-2">กำลังดำเนินการ</p>
                                    @elseif($project_data->status == '2')
                                        <p class="text-rose-600 text-[13px] font-light absolute top-0  right-0 bg-rose-200 rounded-2xl px-2">ขยายระยะเวลา</p>
                                    @else
                                        <p class="text-teal-600 text-[13px] font-light absolute top-0 right-0 bg-green-200 rounded-2xl px-2">เสร็จสิ้น</p>
                                    @endif
                                </span>
                            </div>
                            <div class="relative truncate">
                                <p class="font-medium text-[16px] text-gray-700">ชื่อโปรเจกต์: <span class="font-light">{{ $project_data->project_name }}</span></p>
                            </div>
                            <span class="flex items-center">
                                <p class="truncate text-[14px] text-gray-700 font-medium">ลิงก์สำหรับลูกค้า</p><i class='bx bx-chevrons-right text-xl'></i>
                                <a href="{{ Route('DashboardUser', [$project_data->project_code]) }}" target="_blank"><i class='bx bx-window-open text-2xl hover:text-rose-600'></i></a>
                            </span>
                            <p class="flex items-center overflow-hidden">
                                <span class="truncate text-[14px] text-gray-700 font-light">
                                    <i class='bx bxs-time-five text-blue-500'></i>
                                    @php
                                        $start_date = date("d-m-Y", strtotime($project_data->start_date));
                                        $end_date = date("d-m-Y", strtotime($project_data->end_date));
                                        echo $start_date . " To " . $end_date;
                                    @endphp
                                </span>
                            </p>
                            <div class="grid grid-cols-3 gap-1 mt-2">
                                <button class="bg-yellow-500 text-white text-[14px] py-1 rounded-3xl hover:bg-yellow-600 duration-150 btnLog" id="btnLog" 
                                    data-id="{{ $project_data->id }}" onClick="ProjectsLog(this)">บันทึก</button>
                                <button class="bg-blue-500 text-white text-[14px] py-1 rounded-3xl hover:bg-blue-600 duration-150 btnEdit" id="btnEdit" 
                                    data-id="{{ $project_data->id }}" data-start_date="{{ $project_data->start_date }}" data-end_date="{{ $project_data->end_date }}"
                                    data-email-company="{{ $project_data->email_company }}" data-email-customer="{{ $project_data->email_customer }}"
                                    data-project_name="{{ $project_data->project_name }}" data-manager_name="{{ $project_data->manager_name }}" data-description="{{ $project_data->description }}" 
                                    data-image="{{ asset('uploads/'.$project_data->image) }}" data-status="{{ $project_data->status }}">แก้ไข</button>
                                <button class="bg-red-500 text-white text-[14px] py-1 rounded-3xl hover:bg-red-600 duration-150 btnDelete" id="btnDelete" 
                                    data-id="{{ $project_data->id }}" data-project_name="{{ $project_data->project_name }}">ลบโปรเจกต์</button>
                            </div>
                            <hr class="bg-blue-300 border-dashed border-gray-300 w-full my-2 rounded-2xl mt-4">
                        @endforeach
                    </div>
                @else
                    <div class="bg-white p-4 rounded-3xl drop-shadow-md mb-2 hidden max-md:block">
                        <p class="text-center text-gray-700 font-light">ไม่มีข้อมูลโปรเจกต์</p>
                    </div>
                @endif
                <!-- END MOBILE -->
                {!! $projects_paginate->links('Pagination.Projects') !!}
                @include('Pagination.Projects', ['projects_paginate' => $projects_paginate])
            </div>
        </div>
    </section>

    <!-- Modal Add -->
    <div id="modalAdd" class="modal hidden fixed z-[100] pt-[100px] left-0 top-0 w-[100%] h-[100%] overflow-auto max-md:px-[10px]">
        <!-- Modal content -->
        <div class="modal-content bg-white m-auto p-[20px] rounded-md drop-shadow-xl xl:w-[50%] lg:w-[60%] md:w-[60%] sm:w-[70%] mt-[-50px]">
            <div class="flex items-center">
                <p class="text-[20px] font-bold w-full ml-4 text-center">เพิ่มโปรเจกต์</p>
                <span class="closeAdd text-gray-500 text-[30px] font-medium absolute top-0 right-0 mr-4 hover:text-indigo-600 cursor-pointer">&times;</span>
            </div>
            <hr class="mt-4">
            <div class="mt-2">
                <form action="#!" method="post" onsubmit="return false;">
                    @csrf
                    <div class="grid grid-cols-2 gap-6 mb-6">
                        <div>
                            <label for="start_date" class="block mb-2 text-md font-medium text-gray-700">วันที่เริ่ม <span class="text-red-800 text-xl">*</span></label>
                            <input type="date" id="start_date" oninput="validateDates();" class="bg-gray-50 border border-gray-300 text-gray-700 text-md font-light rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2 outline-none" required>
                        </div>
                        <div>
                            <label for="last_name" class="block mb-2 text-md font-medium text-gray-700">วันที่สิ้นสุด <span class="text-red-800 text-xl">*</span></label>
                            <input type="date" id="end_date" oninput="validateDates();" class="bg-gray-50 border border-gray-300 text-gray-700 text-md font-light rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2 outline-none" required>
                        </div>
                        <div class="max-md:col-span-2">
                            <label for="email_company" class="block mb-2 text-md font-medium text-gray-700">อีเมลบริษัท <span class="text-red-800 text-xl">*</span></label>
                            <input type="text" id="email_company" class="bg-gray-50 border border-gray-300 text-gray-700 text-md font-light rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2 outline-none" placeholder="กรุณากรอกอีเมลที่ต้องการใช้ส่ง" required>
                        </div>
                        <div class="max-md:col-span-2">
                            <label for="email_customer" class="block mb-2 text-md font-medium text-gray-700">อีเมลลูกค้า</label>
                            <input type="text" id="email_customer" class="bg-gray-50 border border-gray-300 text-gray-700 text-md font-light rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2 outline-none" placeholder="กรุณากรอกอีเมลลูกค้า">
                        </div>
                        <div class="max-md:col-span-2">
                            <label for="project_name" class="block mb-2 text-md font-medium text-gray-700">ชื่อโปรเจกต์ <span class="text-red-800 text-xl">*</span></label>
                            <input type="text" id="project_name" class="bg-gray-50 border border-gray-300 text-gray-700 text-md font-light rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2 outline-none" placeholder="กรุณากรอกชื่อโปรเจกต์" required>
                        </div>  
                        <div class="max-md:col-span-2">
                            <label for="manager_name" class="block mb-2 text-md font-medium text-gray-700">ผู้รับผิดชอบ <span class="text-red-800 text-xl">*</span></label>
                            <input type="text" id="manager_name" class="bg-gray-50 border border-gray-300 text-gray-700 text-md font-light rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2 outline-none" placeholder="กรุณากรอกชื่อผู้รับผิดชอบ" required>
                        </div>
                        <div class="col-span-2">
                            <label for="description" class="block mb-2 text-md font-medium text-gray-700">รายละเอียด</label>
                            <textarea id="description" class="bg-gray-50 border border-gray-300 text-gray-700 text-md font-light rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2 outline-none" placeholder="กรุณากรอกรายละเอียด"></textarea>
                        </div>
                        <div class="max-lg:col-span-2">
                            <p class="block mb-2 text-md font-medium text-gray-700">โลโก้บริษัท <span class="text-red-800 text-xl">*</span></p>
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
                    <button type="submit" onClick="ProjectAdd()" class="text-white font-medium rounded-lg text-md w-full sm:w-full px-5 py-2 text-center bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300">บันทึกข้อมูล</button>
                </form>
            </div>
        </div>
    </div>

    <!-- Modal Edit -->
    <div id="modalEdit" class="modal hidden fixed z-[100] pt-[100px] left-0 top-0 w-[100%] h-[100%] overflow-auto max-md:px-[10px]">
        <!-- Modal content -->
        <div class="modal-content bg-white m-auto p-[20px] rounded-md drop-shadow-xl xl:w-[50%] lg:w-[60%] md:w-[60%] sm:w-[70%] mt-[-50px] max-md:mt-[-45px]">
            <div class="flex items-center">
                <p class="text-[20px] font-bold w-full ml-4 text-center">แก้ไขโปรเจกต์</p>
                <span class="closeEdit text-gray-500 text-[30px] font-medium absolute top-0 right-0 mr-4 hover:text-indigo-600 cursor-pointer">&times;</span>
            </div>
            <hr class="mt-4">
            <div class="mt-2">
                <form action="#!" method="post" onsubmit="return false;">
                    @csrf
                    <div class="grid gap-6 mb-6 grid-cols-2">
                        <input type="text" id="id_edit" class="hidden">
                        <div>
                            <label for="start_date" class="block mb-2 text-md font-medium text-gray-700">วันที่เริ่ม <span class="text-red-800 text-xl">*</span></label>
                            <input type="date" id="start_date_edit" oninput="validateDatesEdit();" class="bg-gray-50 border border-gray-300 text-gray-700 text-md font-light rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2 outline-none" value="" required>
                        </div>
                        <div>
                            <label for="last_name" class="block mb-2 text-md font-medium text-gray-700">วันที่สิ้นสุด <span class="text-red-800 text-xl">*</span></label>
                            <input type="date" id="end_date_edit" oninput="validateDatesEdit();" class="bg-gray-50 border border-gray-300 text-gray-700 text-md font-light rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2 outline-none" required>
                            <input type="date" id="end_date_current" class="hidden" readonly>
                        </div>
                        <div class="max-md:col-span-2">
                            <label for="email_company_edit" class="block mb-2 text-md font-medium text-gray-700">อีเมลบริษัท <span class="text-red-800 text-xl">*</span></label>
                            <input type="text" id="email_company_edit" class="bg-gray-50 border border-gray-300 text-gray-700 text-md font-light rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2 outline-none" placeholder="กรุณากรอกอีเมลที่ต้องการใช้ส่ง" required>
                        </div>
                        <div class="max-md:col-span-2 mt-[4px]">
                            <label for="email_customer_edit" class="block mb-2 text-md font-medium text-gray-700">อีเมลลูกค้า</label>
                            <input type="text" id="email_customer_edit" class="bg-gray-50 border border-gray-300 text-gray-700 text-md font-light rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2 outline-none" placeholder="กรุณากรอกอีเมลลูกค้า">
                        </div>
                        <div class="max-md:col-span-2">
                            <label for="project_name" class="block mb-2 text-md font-medium text-gray-700 overflow-hidden">ชื่อโปรเจกต์ <span class="text-red-800 text-xl">*</span></label>
                            <input type="text" id="project_name_edit" class="bg-gray-50 border border-gray-300 text-gray-700 text-md font-light rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2 outline-none" placeholder="กรุณากรอกชื่อโปรเจกต์" required>
                            <input type="text" id="project_name_current" class="hidden" readonly>
                        </div>  
                        <div class="max-md:col-span-2">
                            <label for="manager_name" class="block mb-2 text-md font-medium text-gray-700">ผู้รับผิดชอบ <span class="text-red-800 text-xl">*</span></label>
                            <input type="text" id="manager_name_edit" class="bg-gray-50 border border-gray-300 text-gray-700 text-md font-light rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2 outline-none" placeholder="กรุณากรอกชื่อผู้รับผิดชอบ" required>
                        </div>
                    </div>

                    <div>
                        <label for="website" class="block mb-2 text-md font-medium text-gray-700">รายละเอียด</label>
                        <textarea id="description_edit" class="bg-gray-50 border border-gray-300 text-gray-700 text-md font-light rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2 outline-none" placeholder="กรุณากรอกรายละเอียด" required>
                            <input type="text" id="description_edit">
                        </textarea>
                    </div>
                    
                    <div class="grid gap-6 mb-6 grid-cols-2">
                        <div class="mt-5 max-lg:col-span-2">
                            <p class="block mb-2 text-md font-medium text-gray-700">โลโก้</p>
                            <div class="flex items-center space-x-2 bg-gray-200 rounded-md w-full h-[43px]">
                                <div class="shrink-0 ml-1 mt-1 mb-1">
                                    <img id='_image_edit' class="btnImage cursor-pointer p-1 h-11 w-11 object-cover rounded-full" src="https://icons-for-free.com/iconfiles/png/512/mountains+photo+photos+placeholder+sun+icon-1320165661388177228.png" alt="Current profile photo" />
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
                        <div class="mt-5 max-lg:col-span-2 max-lg:mt-0">
                            <label for="status" class="block mb-2 text-md font-medium text-gray-700">สถานะ</label>
                            <select id="status_edit" class="bg-gray-50 border border-gray-300 text-gray-700 text-md font-light rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2" required>
                                <option selected value="1" class="font-light">กำลังดำเนินการ</option>
                                <option value="2" class="font-light">ขยายระยะเวลา</option>
                                <option value="3" class="font-light">เสร็จสิ้น</option>
                            </select>
                        </div>
                    </div>
                    <hr class="mb-1">
                    <button type="submit" onClick="ProjectEdit()" class="text-white font-medium rounded-lg text-md w-full sm:w-full px-5 py-2 text-center bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300">บันทึกการแก้ไข</button>
                </form>
            </div>
        </div>
    </div>

    <!-- Modal Log -->
    <div id="modalLog" class="modal hidden fixed z-[100] pt-[100px] left-0 top-0 w-[100%] h-[100%] overflow-auto max-md:px-[10px]">
        <!-- Modal content -->
        <div class="modal-content bg-white m-auto p-[20px] rounded-md drop-shadow-xl xl:w-[70%] lg:w-[70%] md:w-[70%] max-md:mt-[-50px] max-md:w-[90%]">
            <div class="flex items-center">
                <p class="text-[20px] font-bold w-full ml-4 text-center">บันทึกการแก้ไขโปรเจกต์</p>
                <span class="closeLog text-gray-500 text-[30px] font-medium absolute top-0 right-0 mr-4 hover:text-indigo-600 cursor-pointer">&times;</span>
            </div>
            <hr class="mt-4">
            <div class="mt-2 overflow-y-auto border-2 border-gray-200 p-1 rounded-md h-96 drop-shadow-md">
                <table class="w-full border max-md:hidden">
                    <thead class="text-gray-700 uppercase bg-gray-100 text-center text-[16px]">
                        <tr class="truncate">
                            <th scope="col" class="px-2 py-3 font-medium">
                                แก้ไขเมื่อ
                            </th>
                            <th scope="col" class="px-2 py-3 font-medium">
                                เหตุผล
                            </th>
                            <th scope="col" class="px-2 py-3 font-medium">
                                วันที่
                            </th>
                            <th scope="col" class="px-2 py-3 font-medium">
                                สถานะ
                            </th>
                            <th scope="col" class="px-2 py-3 font-medium">
                                แก้ไขโดย
                            </th>
                        </tr>
                    </thead>
                    <tbody class="text-gray-500 text-[16px] text-center font-light">
                        <tr class="bg-white hidden " id="tableLogPt">
                            <td scope="row" class="px-2 py-4">
                                <p id="tableLogPt_updated_at" class="truncate">Updated At</p>
                            </td>
                            <td class="px-2 py-4 truncate">
                                <p id="tableLogPt_reason">Reason</p>
                            </td>
                            <td class="px-2 py-4 truncate">
                                <p id="tableLogPt_start_to_end" class="truncate">Date</p>
                            </td>
                            <td class="px-2 py-4 truncate">
                                <p id="tableLogPt_status">Status</p>
                            </td>
                            <td class="px-2 py-4 truncate">
                                <p id="tableLogPt_fullname">Edit By</p>
                            </td>
                        </tr>
                    </tbody>
                    <tbody class="text-gray-500 text-[16px] text-center font-light" id="newTrPasteHere"></tbody>
                </table>

                <!-- START MOBILE -->
                <div class="bg-white p-4 rounded-md border max-md:block hidden max-md:block">
                    <div id="tableLogPt_mobile" class="text-left truncate hidden">
                        <p class="text-gray-700 font-medium">แก้ไขเมื่อ: <span id="tableLogPt_updated_at_mobile" class="text-[14px] font-light text-gray-500">Updated At</span></p>
                        <p class="text-gray-700 font-medium">วันที่: <span id="tableLogPt_start_to_end_mobile" class="text-[14px] font-light text-gray-500">Updated At</span></p>
                        <p class="text-gray-700 font-medium">เหตุผล: <span id="tableLogPt_reason_mobile" class="font-light text-gray-500">Reason</span></p>
                        <p class="text-gray-700 font-medium">แก้ไขโดย: <span id="tableLogPt_fullname_mobile" class="font-light text-gray-500">Edit By</span></p>
                        <p class="text-gray-700 font-medium">สถานะ: 
                            <span id="tableLogPt_status1_mobile" class="hidden text-blue-600 text-[13px] font-light w-fit bg-blue-200 rounded-2xl px-2 mt-[2px]">Status</span>
                            <span id="tableLogPt_status2_mobile" class="hidden text-rose-600 text-[13px] font-light w-fit bg-rose-200 rounded-2xl px-2 mt-[2px]">Status</span>
                            <span id="tableLogPt_status3_mobile" class="hidden text-teal-600 text-[13px] font-light w-fit bg-green-200 rounded-2xl px-2 mt-[2px]">Status</span>
                        </p>
                        <hr class="bg-blue-300 border-dashed border-gray-300 w-full my-2 rounded-2xl">
                    </div>
                    <div class="text-gray-500 text-[16px] text-center" id="newTrPasteHere_mobile"></div>
                </div>
                <!-- END MOBILE -->
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

            // Modal Log
            $('.btnLog').on('click', function () {
                $('#newCommentPasteHere').html('<div id="preload" class="text-center"><div role="status"><svg aria-hidden="true" class="absolute inline w-8 h-8 mr-2 text-gray-200 animate-spin :text-gray-600 fill-blue-600" viewBox="0 0 100 101" fill="none" xmlns="http://www.w3.org/2000/svg"><path d="M100 50.5908C100 78.2051 77.6142 100.591 50 100.591C22.3858 100.591 0 78.2051 0 50.5908C0 22.9766 22.3858 0.59082 50 0.59082C77.6142 0.59082 100 22.9766 100 50.5908ZM9.08144 50.5908C9.08144 73.1895 27.4013 91.5094 50 91.5094C72.5987 91.5094 90.9186 73.1895 90.9186 50.5908C90.9186 27.9921 72.5987 9.67226 50 9.67226C27.4013 9.67226 9.08144 27.9921 9.08144 50.5908Z" fill="currentColor"/><path d="M93.9676 39.0409C96.393 38.4038 97.8624 35.9116 97.0079 33.5539C95.2932 28.8227 92.871 24.3692 89.8167 20.348C85.8452 15.1192 80.8826 10.7238 75.2124 7.41289C69.5422 4.10194 63.2754 1.94025 56.7698 1.05124C51.7666 0.367541 46.6976 0.446843 41.7345 1.27873C39.2613 1.69328 37.813 4.19778 38.4501 6.62326C39.0873 9.04874 41.5694 10.4717 44.0505 10.1071C47.8511 9.54855 51.7191 9.52689 55.5402 10.0491C60.8642 10.7766 65.9928 12.5457 70.6331 15.2552C75.2735 17.9648 79.3347 21.5619 82.5849 25.841C84.9175 28.9121 86.7997 32.2913 88.1811 35.8758C89.083 38.2158 91.5421 39.6781 93.9676 39.0409Z" fill="currentFill"/></svg><span class="sr-only">Loading...</span></div></div>');
                $("#modalLog").css("display","block");
            });
            $('.closeLog').on('click', function () {
                var modal = document.getElementById("modalLog");
                modal.classList.add("fade-out-modal");

                $("#newTrPasteHere").empty();
                $("#newTrPasteHere_mobile").empty();

                // After the animation is complete (0.5s in this case), you can remove the modal from the DOM
                setTimeout(function() {
                    modal.style.display = "none";
                    modal.classList.remove("fade-out-modal");
                }, 500);
            });

            // Modal Edit
            $('.btnEdit').on('click', function () {
                $('.modal-content #id_edit').val($(this).data('id'));
                $('.modal-content #start_date_edit').val($(this).data('start_date'));
                $('.modal-content #end_date_edit').val($(this).data('end_date'));
                $('.modal-content #end_date_current').val($(this).data('end_date'));
                $('.modal-content #email_company_edit').val($(this).data('email-company'));
                $('.modal-content #email_customer_edit').val($(this).data('email-customer'));
                $('.modal-content #project_name_edit').val($(this).data('project_name'));
                $('.modal-content #project_name_current').val($(this).data('project_name'));
                $('.modal-content #manager_name_edit').val($(this).data('manager_name'));
                $('.modal-content #description_edit').val($(this).data('description'));
                $('.modal-content #_image_edit').attr("src", $(this).data('image'));
                $('.modal-content #status_edit').val($(this).data('status'));
                $("#modalEdit").css("display","block");
            });
            $('.closeEdit').on('click', function () {
                var modal = document.getElementById("modalEdit");
                modal.classList.add("fade-out-modal");

                // After the animation is complete (0.5s in this case), you can remove the modal from the DOM
                setTimeout(function() {
                    modal.style.display = "none";
                    modal.classList.remove("fade-out-modal");
                }, 500);
            });

            // SweetAlert Delete
            $('.btnDelete').on('click', function () {
                Swal.fire({
                    title: `คุณแน่ใจหรือไม่ที่ต้องการจะลบ?`,
                    html: `<b class="text-rose-800 font-medium">(ชื่อโปรเจกต์: ${$(this).data('project_name')})</b><br>การดำเนินการนี้ไม่สามารถเรียกคืนได้`,
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'ใช่, ลบ',
                    cancelButtonText: 'ยกเลิก'
                }).then((result) => {
                    if (result.isConfirmed) {
                        id = $(this).data('id');
                        console.log('id = ', id);
                        ProjectDelete(id);
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

        function validateDatesSearch() {
            var startDateInput = document.getElementById("start_date_search");
            var endDateInput = document.getElementById("end_date_search");
            var endDate = new Date(document.getElementById("end_date_search").value);
            var startDate = new Date(startDateInput.value);
            if (startDate > endDate) {
                Swal.fire({
                    position: 'center',
                    icon: 'error',
                    title: 'รูปแบบวันที่ไม่ถูกต้อง!',
                    html: 'วันที่เริ่มต้องไม่ <b class="text-rose-800">มากกว่า</b> วันที่สิ้นสุด',
                    confirmButtonText: 'ตกลง'
                });
                startDateInput.classList.add("border-red-500");
                endDateInput.classList.add("border-red-500");
                // startDateInput.value = "";
                return false;
            }

            startDateInput.classList.remove("border-red-500");
            endDateInput.classList.remove("border-red-500");
            return true;
        }

        function validateDates() {
            var startDateInput = document.getElementById("start_date");
            var endDateInput = document.getElementById("end_date");
            var endDate = new Date(document.getElementById("end_date").value);
            var startDate = new Date(startDateInput.value);
            if (startDate > endDate) {
                Swal.fire({
                    position: 'center',
                    icon: 'error',
                    title: 'รูปแบบวันที่ไม่ถูกต้อง!',
                    html: 'วันที่เริ่มต้องไม่ <b class="text-rose-800">มากกว่า</b> วันที่สิ้นสุด',
                    confirmButtonText: 'ตกลง'
                });
                startDateInput.classList.add("border-red-500");
                endDateInput.classList.add("border-red-500");
                // startDateInput.value = "";
                return false;
            }

            startDateInput.classList.remove("border-red-500");
            endDateInput.classList.remove("border-red-500");
            return true;
        }

        function validateDatesEdit() {
            var startDateInput = document.getElementById("start_date_edit");
            var endDateInput = document.getElementById("end_date_edit");
            var endDate = new Date(document.getElementById("end_date_edit").value);
            var startDate = new Date(startDateInput.value);
            if (startDate > endDate) {
                Swal.fire({
                    position: 'center',
                    icon: 'error',
                    title: 'รูปแบบวันที่ไม่ถูกต้อง!',
                    html: 'วันที่เริ่มต้องไม่ <b class="text-rose-800">มากกว่า</b> วันที่สิ้นสุด',
                    confirmButtonText: 'ตกลง'
                });
                startDateInput.classList.add("border-red-500");
                endDateInput.classList.add("border-red-500");
                // startDateInput.value = "";
                return false;
            }

            startDateInput.classList.remove("border-red-500");
            endDateInput.classList.remove("border-red-500");
            return true;
        }

        function ProjectAdd() {
            if(
                document.getElementById("start_date").value != '' && 
                document.getElementById("end_date").value != '' && 
                document.getElementById("email_company").value != '' && 
                document.getElementById("project_name").value != '' && 
                document.getElementById("manager_name").value != '' &&
                document.getElementById("_image_add").value != '' 
                ) {
                fetch("{{ Route('ProjectAdd') }}", {
                    method: "POST",
                    headers: {
                        "Content-Type": "application/json",
                        "Accept": "application/json",
                        "X-CSRF-Token": '{{csrf_token()}}'
                    },
                    body:JSON.stringify(
                        {
                            start_date: document.getElementById("start_date").value,
                            end_date: document.getElementById("end_date").value,
                            email_company: document.getElementById("email_company").value,
                            email_customer: document.getElementById("email_customer").value,
                            project_name: document.getElementById("project_name").value,
                            manager_name: document.getElementById("manager_name").value,
                            description: document.getElementById("description").value,
                            image64: _image64
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
                        title: 'เพิ่มโปรเจกต์สำเร็จ',
                        timer: 1000,
                        timerProgressBar: true
                    }).then((result) => {
                        location.reload();
                    })
                    // modalAdd.style.display = "none";
                })
                .catch((er) => {
                    console.log('Error' + er);
                    Swal.fire({
                        position: 'center',
                        icon: 'error',
                        title: 'เพิ่มโปรเจกต์ไม่สำเร็จ!',
                        html: '<b class="text-rose-800">ชื่อโปรเจกต์</b>นี้ถูกใช้ไปแล้ว'
                    })
                });
            }
        }

        async function ProjectEdit() {
            if(
                document.getElementById("start_date_edit").value != '' &&
                document.getElementById("end_date_edit").value != '' &&
                document.getElementById("email_company_edit").value != '' &&
                document.getElementById("project_name_edit").value != '' &&
                document.getElementById("manager_name_edit").value != ''
            ) {
                const { value: reason } = await Swal.fire({
                    icon: 'warning',
                    input: 'textarea',
                    title: 'เหตุผลในการแก้ไข',
                    inputPlaceholder: 'กรุณากรอกเหตุผลในการแก้ไข...',
                    inputAttributes: {
                        'aria-label': 'Type your message here',
                        'required': 'true'
                    },
                    showCancelButton: true,
                    confirmButtonText: 'บันทึกการแก้ไข',
                    cancelButtonText: 'ยกเลิก',
                })
                if (reason) {
                    const firstname = '<?php echo Session::get('firstname'); ?>';
                    const lastname = '<?php echo Session::get('lastname'); ?>';
                    fetch("{{ Route('ProjectEdit') }}", {
                        method: "POST",
                        headers: {
                            "Content-Type": "application/json",
                            "Accept": "application/json",
                            "X-CSRF-Token": '{{csrf_token()}}'
                        },
                        body:JSON.stringify(
                            {
                                id: document.getElementById("id_edit").value,
                                start_date: document.getElementById("start_date_edit").value,
                                end_date: document.getElementById("end_date_edit").value,
                                end_date_current: document.getElementById("end_date_current").value,
                                project_name: document.getElementById("project_name_edit").value,
                                project_name_current: document.getElementById("project_name_current").value,
                                email_company: document.getElementById("email_company_edit").value,
                                email_customer: document.getElementById("email_customer_edit").value,
                                manager_name: document.getElementById("manager_name_edit").value,
                                description: document.getElementById("description_edit").value,
                                status: document.getElementById("status_edit").value,
                                image64: _image64,
                                reason: reason,
                                firstname: firstname,
                                lastname: lastname
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
                            html: '<b class="text-rose-800">ชื่อโปรเจกต์</b>นี้ถูกใช้ไปแล้ว'
                        })
                    });
                }
            }
        }

        function ProjectDelete(id) {
            fetch("{{ Route('ProjectDelete') }}", {
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

        function ProjectsLog(element){
            fetch("{{ Route('ProjectsLog') }}", {
                method: "POST",
                headers: {
                    "Content-Type": "application/json",
                    "Accept": "application/json",
                    "X-CSRF-Token": '{{csrf_token()}}'
                },
                body:JSON.stringify(
                    {
                        id: $(element).data('id')
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

                if(data.length < 1) {
                    $("#noRecords").removeClass("hidden");
                } else {
                    for(let i=0; i<data.length; i++) {
                        $("#tableLogPt").addClass("hidden");
                        var _newBox = $('#tableLogPt').clone();
                        _newBox.removeClass("hidden");
                        _newBox.attr('id','boxNo'+data[i].id);

                        // START FORMATED CREATED DATE
                            var dateStr = data[i].created_at;
                            var date = new Date(dateStr);
                            var monthNumber = ["01", "02", "03", "04", "05", "06", "07", "08", "09", "10", "11", "12"];
                            var day = date.getDate(); // Day (1-31)
                            var month = monthNumber[date.getMonth()]; // Month (0-11)
                            var year = date.getFullYear(); // Year (4-digit)
                            var hours = date.getHours(); // Hours (0-23)
                            var minutes = date.getMinutes(); // Minutes (0-59)
                            var seconds = date.getSeconds(); // Seconds (0-59)
                            var ampm = hours >= 12 ? "PM" : "AM"; // AM or PM
                            if(day < 10) {
                                var formattedDate = '0'+ day + "-" + month + "-" + year + " " + hours + ":" + (minutes < 10 ? "0" : "") + minutes + ":" + (seconds < 10 ? "0" : "") + seconds + " " + ampm;
                            } else {
                                var formattedDate = day + "-" + month + "-" + year + " " + hours + ":" + (minutes < 10 ? "0" : "") + minutes + ":" + (seconds < 10 ? "0" : "") + seconds + " " + ampm;
                            }
                        // END FORMATED CREATED DATE
                        _newBox.find('#tableLogPt_name').text('name');
                        _newBox.find('#tableLogPt_updated_at').html(formattedDate);

                        // START FORMATED START DATE
                            var dateStr = data[i].start_date;
                            var date = new Date(dateStr);
                            var monthNumber = ["01", "02", "03", "04", "05", "06", "07", "08", "09", "10", "11", "12"];
                            var day = date.getDate();
                            var month = monthNumber[date.getMonth()];
                            var year = date.getFullYear();
                            if(day < 10) {
                                var formatted_startDate = '0'+ day + "-" + month + "-" + year;
                            } else {
                                var formatted_startDate = day + "-" + month + "-" + year;
                            }
                        // END FORMATED START DATE

                        // START FORMATED END DATE
                            var dateStr = data[i].end_date;
                            var date = new Date(dateStr);
                            var monthNumber = ["01", "02", "03", "04", "05", "06", "07", "08", "09", "10", "11", "12"];
                            var day = date.getDate();
                            var month = monthNumber[date.getMonth()];
                            var year = date.getFullYear();
                            if(day < 10) {
                                var formatted_endDate = '0'+ day + "-" + month + "-" + year;
                            } else {
                                var formatted_endDate = day + "-" + month + "-" + year;
                            }
                        // END FORMATED END DATE
                        _newBox.find('#tableLogPt_start_to_end').html(formatted_startDate + ' ถึง ' + formatted_endDate);

                        _newBox.find("#tableLogPt_reason").html(data[i].reason);

                        if(data[i].status == '1') {
                            _newBox.find("#tableLogPt_status").html('กำลังดำเนินการ');
                        } else if(data[i].status == '2') {
                            _newBox.find("#tableLogPt_status").html('ขยายระยะเวลา');
                        } else {
                            _newBox.find("#tableLogPt_status").html('เสร็จสิ้น');
                        }

                        _newBox.find("#tableLogPt_fullname").html(data[i].fullname);
                        $("#newTrPasteHere").append(_newBox);

                        $("#tableLogPt_mobile").addClass("hidden");
                        var _newBox = $('#tableLogPt_mobile').clone();
                        _newBox.removeClass("hidden");
                        _newBox.attr('id','boxNo'+data[i].id);
                        _newBox.find('#tableLogPt_name_mobile').text('name');
                        _newBox.find('#tableLogPt_updated_at_mobile').html(formattedDate);
                        _newBox.find('#tableLogPt_start_to_end_mobile').html(formatted_startDate + ' ถึง ' + formatted_endDate);
                        _newBox.find("#tableLogPt_reason_mobile").html(data[i].reason);
                        if(data[i].status == '1') {
                            _newBox.find("#tableLogPt_status1_mobile").html('กำลังดำเนินการ');
                            _newBox.find("#tableLogPt_status1_mobile").removeClass('hidden');
                        } else if(data[i].status == '2') {
                            _newBox.find("#tableLogPt_status2_mobile").html('ขยายระยะเวลา');
                            _newBox.find("#tableLogPt_status2_mobile").removeClass('hidden');
                        } else {
                            _newBox.find("#tableLogPt_status3_mobile").html('เสร็จสิ้น');
                            _newBox.find("#tableLogPt_status3_mobile").removeClass('hidden');
                        }
                        _newBox.find("#tableLogPt_fullname_mobile").html(data[i].fullname);
                        $("#newTrPasteHere_mobile").append(_newBox);
                    }
                }
                $('#preload').html('');
            })
            .catch((er) => {
                console.log('Error' + er);
            });
        }
    </script>
@endsection