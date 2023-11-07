@php
    $checklist_status = \Session::get('checklist_status');
@endphp
<title>Checklist | Kingsmen CMTI</title>

@extends('User/LayoutUser')

@section('ChecklistSelected')
    <section class="relative grow bg-[#CDD4E8] h-full">
        <!-- Header -->
        <div class="p-4 flex flex-col my-auto mb-[-4px] max-md:hidden">
            <div class="flex items-center pl-5">
                <p class="font-bold text-[24px] whitespace-nowrap">จัดการเช็คลิสต์</p>
                <a href="{{ Route('ChecklistUser', [Session::get('project_code')]) }}" class="ml-4 font-medium text-[20px] text-gray-600 underline whitespace-nowrap hover:text-black duration-300">รายการเช็คลิสต์</a>
                <i class='bx bx-right-arrow-alt text-[2rem] text-gray-700 mt-[2px]'></i>
                <span class="font-medium text-[20px] text-gray-600 whitespace-nowrap">
                    {{ Session::get('defect') }}
                </span>
            </div>
            <div class="flex items-center pl-5">
                @if(!empty($projects->status))
                    <i class='bx bx-chevrons-right text-[2rem] text-gray-700 mt-[2px]'></i>
                    <span class="font-medium text-[20px] text-blue-600 truncate">{{ $projects->project_name }}</span>
                    <div class="ml-auto mr-0 inline-flex gap-2 font-medium whitespace-nowrap">
                        @if(Session::get('defect') == 'Defect รับประกันผลงาน')
                            <button class="bg-green-500 font-medium px-1 py-[6px] rounded-md text-white flex items-center ml-auto mr-0 hover:bg-green-600 duration-150 btnAdd">
                                <i class='bx bx-plus'></i>เพิ่มเช็คลิสต์
                            </button>
                        @endif
                    </div>
                @endif
            </div>
        </div>

        <!-- START HEADER MOBILE -->
        <div class="p-4 my-auto mb-[-4px] hidden max-md:block">
            <span class="font-bold text-[24px] flex pl-5 truncate">จัดการเช็คลิสต์</span>
            <div class="flex items-center pl-3">
                <a href="{{ Route('Checklist') }}" class="ml-4 font-medium text-[18px] text-gray-600 underline whitespace-nowrap hover:text-black duration-300">รายการเช็คลิสต์</a>
                <i class='bx bx-right-arrow-alt text-[2rem] text-gray-700 mt-[2px]'></i>
                <span class="font-medium text-[18px] text-gray-600 whitespace-nowrap">
                    {{ Session::get('defect') }}
                </span>
            </div>
            <div class="flex items-center pl-5 grid grid-cols-1">
                <div class="flex items-center">
                    @if(!empty($projects->status))
                        <i class='bx bx-chevrons-right text-[2rem] text-gray-700 mt-[2px]'></i>
                        <span class="font-medium text-[20px] text-blue-600">{{ $projects->project_name }}</span>
                    @endif
                </div>
                <div class="inline-flex gap-2 font-medium mr-4 mt-1">
                    @if(Session::get('defect') == 'Defect รับประกันผลงาน')
                        <button class="bg-green-500 font-medium p-1 rounded-md text-white flex items-center hover:bg-green-600 duration-150 btnAdd">
                            <i class='bx bx-plus'></i>เพิ่มเช็คลิสต์
                        </button>
                    @endif
                </div>
            </div>
        </div>
        <!-- END HEADER MOBILE -->
        
        <div class="flex items-center justify-center ml-5 mt-[4px]">
            <i class='bx bxs-circle text-[0.5rem]'></i>
            <hr class="bg-blue-300 border-solid border-1 border-gray-900 w-full ml-[-2px]">
        </div>
        <!-- End Header -->
        
        <!-- Table -->
        <div class="p-5 bg-[#CDD4E8]">

            <!-- START SEARCH -->
            <div class="grid grid-cols-3 max-lg:grid-cols-2 max-md:grid-cols-1">
                <form action="{{ Route('SearchChecklistsUser', [Session::get('project_code'), Session::get('index')]) }}" method="get" class="col-start-3 max-lg:col-start-2 max-md:col-start-1"> 
                    <label for="default-search" class="mb-2 text-sm font-medium text-gray-900 sr-only dark:text-white">Search</label>
                    <div class="relative">
                        <div class="absolute inset-y-0 left-0 flex items-center pl-3 pointer-events-none">
                            <svg class="w-4 h-4 text-gray-500 dark:text-gray-400" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 20 20">
                                <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m19 19-4-4m0-7A7 7 0 1 1 1 8a7 7 0 0 1 14 0Z"/>
                            </svg>
                        </div>
                        <input type="search" name="keyword" class="block w-full p-2 pl-10 text-sm text-gray-900 border border-gray-300 rounded-2xl bg-gray-50 focus:ring-blue-500 focus:border-blue-500" value="{{ isset($keyword) ? $keyword : '' }}" placeholder="ค้นหาเช็คลิสต์...">
                        <button type="submit" class="text-white font-medium text-sm px-3 py-1 bg-blue-700 rounded-2xl absolute top-0 right-0 mt-[4.5px] mr-2 hover:bg-blue-800 focus:ring-2 focus:ring-blue-300 duration-300">ค้นหา</button>
                    </div>
                </form>
            </div>
            <!-- END SEARCH -->

            <div class="relative overflow-x-auto rounded-3xl drop-shadow-xl">
                <table class="w-full text-sm text-left text-gray-500 max-md:hidden">
                    <thead class="text-[16px] text-gray-700 uppercase bg-gray-100">
                        <tr class="text-center truncate">
                            <th scope="col" class="px-2 py-3 font-medium">
                                วันที่ เวลา
                            </th>
                            <th scope="col" class="px-2 py-3 font-medium">
                                หัวข้อ
                            </th>
                            <th scope="col" class="px-2 py-3 font-medium">
                                รูปภาพ
                            </th>
                            <th scope="col" class="px-2 py-3 font-medium">
                                สร้างโดย
                            </th>
                            <th scope="col" class="px-2 py-3 font-medium">
                                สถานะ
                            </th>
                            <th scope="col" class="px-2 py-3 font-medium">
                                รอตรวจสอบ
                            </th>
                            <th scope="col" class="px-2 py-3 font-medium">
                                การกระทำ
                            </th>
                        </tr>
                    </thead>
                    <tbody>
                        @if(sizeof($checklists_paginate))
                            @foreach($checklists_paginate as $checklist_data)
                                <tr class="bg-white text-[16px] text-center font-light border">
                                    <td class="hidden" id="checklist_id">{{ $checklist_data->id }}</td>
                                    <td scope="row" class="px-2 py-4 truncate">
                                        @php
                                            $created_date = date("d-m-Y", strtotime($checklist_data->created_at));
                                            $created_time = date("H:i:s A", strtotime($checklist_data->created_at));
                                            echo $created_date . "<br>" . $created_time;
                                        @endphp
                                    </td>
                                    <td scope="row" class="px-2 py-4">
                                        {{ $checklist_data->title }}
                                    </td>
                                    <td class="px-2 py-4">
                                        <div class="flex flex-wrap items-center justify-center">
                                            <div class="w-[100px] h-[80px] rounded overflow-hidden drop-shadow border border-gray-400">
                                                @if($checklist_data->image)
                                                    @php
                                                        $images = json_decode($checklist_data->image, true);
                                                    @endphp
                                                    @if(count($images['urls']) > 1)
                                                        <span class="font-medium text-[14px] text-blue-500 bg-white rounded-b !rounded-r-none border border-gray-400 mt-[-2px] drop-shadow px-[3px] absolute right-0">+{{ count($images['urls'])-1 }}</span>
                                                    @endif
                                                    <img src="{{ URL('/uploads/' . $images['urls'][0]) }}" alt="" class="w-auto h-auto w-full h-full object-cover object-center">
                                                @endif
                                            </div>
                                        </div>
                                    </td>
                                    <td scope="row" class="px-2 py-4">
                                        {{ $checklist_data->created_by }}
                                    </td>
                                    <td class="px-2 py-4 truncate">
                                        @if($checklist_data->status == '1')
                                            <p class="text-yellow-500 font-medium" id="status_{{ $checklist_data->id }}">รอดำเนินการ</p>
                                        @elseif($checklist_data->status == '2')
                                            <p class="text-blue-500 font-medium" id="status_{{ $checklist_data->id }}">กำลังดำเนินการ</p>
                                        @else
                                            <p class="text-teal-500 font-medium" id="status_{{ $checklist_data->id }}">เสร็จสิ้น</p>
                                        @endif
                                    </td>
                                    <td class="px-2 py-4 truncate">
                                        <div class="flex justify-center">
                                            @if($checklist_data->status != '1' && $checklist_data->status_customer == '1')
                                                <a id="waiting_{{ $checklist_data->id }}" class="flex items-center justify-center w-fit text-white bg-indigo-500 border border-indigo-300 rounded-md px-2 py-1 hover:bg-indigo-600 duration-300 cursor-pointer"
                                                    onClick="ChecklistConfirm(this)" data-id="{{ $checklist_data->id }}" data-title="{{ $checklist_data->title }}">
                                                    <i class='bx bx-check-square text-xl'></i>รอตรวจสอบ
                                                </a>
                                            @elseif($checklist_data->status_customer == '2')
                                                <p id="confirm_{{ $checklist_data->id }}" class="flex items-center justify-center text-teal-600">
                                                    <i class='bx bxs-check-square text-xl'></i>ตรวจสอบแล้ว
                                                </p>
                                            @else
                                                <p class="">-</p>
                                            @endif
                                        </div>
                                    </td>
                                    <td class="px-2 py-4 truncate">
                                        @if(Session::get('defect') == 'Defect รับประกันผลงาน')
                                            <button class="bg-yellow-500 text-white p-1 px-2 rounded-md hover:bg-yellow-600 duration-150 btnView" id="btnView"
                                            data-id="{{ $checklist_data->id }}" data-title="{{ $checklist_data->title }}" data-detail="{{ $checklist_data->detail }}" 
                                            data-status="{{ $checklist_data->status }}" data-image="{{ $checklist_data->image }}" onClick="ChecklistComments(this)">เรียกดู</button>
                                            <button class="bg-blue-500 text-white p-1 px-2 rounded-md hover:bg-blue-600 duration-150 btnEdit" id="btnEdit"
                                            data-id="{{ $checklist_data->id }}" data-title="{{ $checklist_data->title }}" data-detail="{{ $checklist_data->detail }}" 
                                            data-status="{{ $checklist_data->status }}" data-image="{{ $checklist_data->image }}">แก้ไข</button>
                                            <button class="bg-red-500 text-white p-1 px-2 rounded-md hover:bg-red-600 duration-150 btnDelete" id="btnDelete"
                                            data-id="{{ $checklist_data->id }}" data-title="{{ $checklist_data->title }}">ลบเช็คลิสต์</button>
                                        @else
                                            <button class="bg-yellow-500 text-white p-1 px-2 rounded-md hover:bg-yellow-600 duration-150 btnView" id="btnView"
                                            data-id="{{ $checklist_data->id }}" data-title="{{ $checklist_data->title }}" data-detail="{{ $checklist_data->detail }}" 
                                            data-status="{{ $checklist_data->status }}" data-image="{{ $checklist_data->image }}" onClick="ChecklistComments(this)">เรียกดู</button>
                                        @endif
                                    </td>
                                </tr>
                            @endforeach
                        @else
                            <tr class="bg-white border-b text-center">
                                <td class="px-6 py-4" colspan="7">
                                    <p class="text-center font-light text-gray-500">ไม่พบข้อมูลเช็คลิสต์</p>
                                </td>
                            </tr>
                        @endif
                    </tbody>
                </table>

                <!-- START MOBILE CHECKLISTS -->
                @if(sizeof($checklists_paginate))
                    <div class="bg-white rounded-t-3xl hidden max-md:block">
                        <div class="p-4">
                            @foreach($checklists_paginate as $checklist_data)
                                <div class="border border-[#CDD4E8] rounded-3xl p-2 mb-2 hover:bg-gray-100 duration-300">
                                    <div class="relative font-medium flex items-center">
                                        <div class="grid grid-cols-6 flex items-center">
                                            <div class="row-span-3 w-[100%] pr-2 relative">
                                                @if($checklist_data->image)
                                                    <div class="flex flex-wrap justify-center items-center">
                                                        <div class="relative bg-white w-[80px] h-[80px] rounded p-1 overflow-hidden border">
                                                            @if($checklist_data->image)
                                                                @php
                                                                    $images = json_decode($checklist_data->image, true);
                                                                @endphp
                                                                @if(count($images['urls']) > 1)
                                                                    <span class="font-medium text-[14px] text-blue-500 bg-white rounded border drop-shadow mr-1 px-[3px] absolute right-0">+{{ count($images['urls'])-1 }}</span>
                                                                @endif
                                                                <img src="{{ URL('/uploads/' . $images['urls'][0]) }}" alt="" class="w-full h-full object-cover my-auto rounded" alt="logo">
                                                            @endif
                                                        </div>
                                                    </div>
                                                @endif
                                            </div>
                                            <p class="col-span-5 font-medium text-[16px] text-gray-700 overflow-hidden truncate">หัวข้อ: <span class="text-gray-700 font-light">{{ $checklist_data->title }}</span></p>
                                            <p class="col-span-5 font-medium text-[16px] text-gray-700 overflow-hidden truncate">สร้างโดย: <span class="text-gray-700 font-light">{{ $checklist_data->created_by }}</span></p>
                                            <p class="col-span-5 text-gray-500 text-[14px] font-light overflow-hidden truncate">
                                                <i class='bx bxs-time-five text-blue-500'></i>
                                                @php
                                                    $created_at = date("d-m-Y H:i:s A", strtotime($checklist_data->created_at));
                                                    echo $created_at;
                                                @endphp
                                            </p>
                                        </div>
                                        @if($checklist_data->status == '1')
                                            <p class="text-yellow-600 text-[13px] font-light absolute ml-auto top-0 right-0 bg-yellow-200 rounded-2xl px-2" id="status_{{ $checklist_data->id }}">รอดำเนินการ</p>
                                        @elseif($checklist_data->status == '2')
                                            <p class="text-blue-600 text-[13px] font-light absolute ml-auto top-0 right-0 bg-blue-200 rounded-2xl px-2" id="status_{{ $checklist_data->id }}">กำลังดำเนินการ</p>
                                        @else
                                            <p class="text-teal-600 text-[13px] font-light absolute ml-auto top-0 right-0 bg-green-200 rounded-2xl px-2" id="status_{{ $checklist_data->id }}">เสร็จสิ้น</p>
                                        @endif
                                    </div>

                                    @if(Session::get('defect') == 'Defect รับประกันผลงาน')
                                        <div class="grid grid-cols-2 gap-1 mt-2">
                                            <button class="bg-yellow-500 text-white p-1 rounded-3xl hover:bg-yellow-600 duration-150 px-2 btnView" id="btnView"
                                            data-id="{{ $checklist_data->id }}" data-title="{{ $checklist_data->title }}" data-detail="{{ $checklist_data->detail }}" 
                                            data-status="{{ $checklist_data->status }}" data-image="{{ $checklist_data->image }}" onClick="ChecklistComments(this)">เรียกดู</button>
                                            @if($checklist_data->status != '1' && $checklist_data->status_customer == '1')
                                                <a id="waiting_mobile_{{ $checklist_data->id }}" class="flex items-center justify-center w-full text-white bg-indigo-500 border border-indigo-300 rounded-3xl px-2 py-1 hover:bg-indigo-600 duration-300 cursor-pointer"
                                                    onClick="ChecklistConfirm(this)" data-id="{{ $checklist_data->id }}" data-title="{{ $checklist_data->title }}">
                                                    <i class='bx bx-check-square text-xl'></i>รอตรวจสอบ
                                                </a>
                                            @elseif($checklist_data->status_customer == '2')
                                                <p id="confirm_{{ $checklist_data->id }}" class="flex items-center ml-auto mr-0 text-teal-600 px-2">
                                                    <i class='bx bxs-check-square text-xl'></i>ตรวจสอบแล้ว
                                                </p>
                                            @endif
                                            <button class="bg-blue-500 text-white p-1 rounded-3xl hover:bg-blue-600 duration-150 px-2 btnEdit" id="btnEdit"
                                            data-id="{{ $checklist_data->id }}" data-title="{{ $checklist_data->title }}" data-detail="{{ $checklist_data->detail }}" 
                                            data-status="{{ $checklist_data->status }}" data-image="{{ $checklist_data->image }}">แก้ไข</button>
                                            <button class="bg-red-500 text-white p-1 rounded-3xl hover:bg-red-600 duration-150 px-2 btnDelete" id="btnDelete"
                                            data-id="{{ $checklist_data->id }}" data-title="{{ $checklist_data->title }}">ลบเช็คลิสต์</button>
                                        </div>
                                    @else
                                        <div class="grid grid-cols-2 gap-2 mt-2">
                                            <button class="bg-yellow-500 text-white p-1 rounded-3xl hover:bg-yellow-600 duration-150 px-2 btnView" id="btnView"
                                            data-id="{{ $checklist_data->id }}" data-title="{{ $checklist_data->title }}" data-detail="{{ $checklist_data->detail }}" 
                                            data-status="{{ $checklist_data->status }}" data-image="{{ $checklist_data->image }}" onClick="ChecklistComments(this)">เรียกดู</button>
                                            @if($checklist_data->status != '1' && $checklist_data->status_customer == '1')
                                                <a id="waiting_mobile_{{ $checklist_data->id }}" class="flex items-center justify-center w-full text-white bg-blue-500 border border-blue-300 rounded-3xl px-2 py-1 hover:bg-blue-600 duration-300 cursor-pointer"
                                                    onClick="ChecklistConfirm(this)" data-id="{{ $checklist_data->id }}" data-title="{{ $checklist_data->title }}">
                                                    <i class='bx bx-check-square text-xl'></i>รอตรวจสอบ
                                                </a>
                                            @elseif($checklist_data->status_customer == '2')
                                                <p id="confirm_{{ $checklist_data->id }}" class="flex items-center ml-auto mr-0 text-teal-600 px-2">
                                                    <i class='bx bxs-check-square text-xl'></i>ตรวจสอบแล้ว
                                                </p>
                                            @endif
                                        </div>
                                    @endif
                                </div>
                            @endforeach
                        </div>
                    </div>
                @else
                    <div class="bg-white p-4 rounded-3xl drop-shadow-md mb-2 hidden max-md:block">
                        <p class="text-center font-light text-gray-500">ไม่พบข้อมูลเช็คลิสต์</p>
                    </div>
                @endif
                <!-- END MOBILE CHECKLISTS -->

                {!! $checklists_paginate->links('Pagination.Checklists') !!}
                @include('Pagination.Checklists', ['checklists_paginate' => $checklists_paginate])
            </div>
        </div>
        <!-- End Table -->
    </section>

    <!-- Modal Add -->
    <div id="modalAdd" class="modal hidden fixed z-[100] pt-[100px] left-0 top-0 w-[100%] h-[100%] overflow-auto max-md:px-[10px]">
        <!-- Modal content -->
        <div class="modal-content bg-white m-auto p-[20px] rounded-md drop-shadow-xl xl:w-[40%] lg:w-[60%] md:w-[60%] sm:w-[70%] mt-[-50px] max-md:mt-[-45px]">
            <div class="flex items-center">
                <p class="text-[20px] font-bold w-full ml-4 text-center">เพิ่มเช็คลิสต์</p>
                <span class="closeAdd text-gray-500 text-[30px] font-medium absolute top-0 right-0 mr-4 hover:text-indigo-600 cursor-pointer">&times;</span>
            </div>
            <hr class="mt-4">
            <div class="mt-2">
                <form action="#!" method="post" onsubmit="return false;" encrypt="multipart/form-data">
                    @csrf
                    <input type="text" id="project_id" value="{{ $projects->id }}" hidden>
                    <input type="text" id="defect_id_add" value="{{ Session::get('defect_id') }}" hidden>
                    <div class="grid gap-6 mb-6 md:grid-cols-2">
                        <div>
                            <label for="title" class="block mb-2 text-md font-medium text-gray-700">หัวข้อ <span class="text-red-800 text-xl">*</span></label>
                            <input type="text" id="title_add" class="bg-gray-50 border border-gray-300 text-gray-700 text-md font-light rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2" placeholder="กรุณากรอกหัวข้อ" value="" required>
                        </div>
                        <div>
                            <label for="created_by_add" class="block mb-2 text-md font-medium text-gray-700">ชื่อผู้สร้างเช็คลิสต์ <span class="text-red-800 text-xl">*</span></label>
                            <input type="text" id="created_by_add" class="bg-gray-50 border border-gray-300 text-gray-700 text-md font-light rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2" placeholder="กรุณากรอกชื่อของคุณ" value="" required>
                        </div>
                    </div>
                    <div class="mb-6">
                        <label for="detail" class="block mb-2 text-md font-medium text-gray-700">รายละเอียด</label>
                        <textarea id="detail_add" class="bg-gray-50 border border-gray-300 text-gray-700 text-md font-light rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2" placeholder="กรุณากรอกรายละเอียด"></textarea>
                    </div>
                    <div class="mb-6 grid grid-cols-2 max-md:grid-cols-1">
                        <label for="image_add" class="col-span-2 block mb-2 text-md font-medium text-gray-700">รูปภาพ <span class="text-red-800 text-xl">*</span><span class="text-[12px] text-rose-800">สูงสุด 8 รูปภาพ</span></label>
                        <input type="file" multiple onChange={fileChosen(event)} id="image" name="image" accept="image/png, image/jpeg" class="font-light m-0 block w-full min-w-0 flex-auto rounded border border-solid border-neutral-300 bg-clip-padding px-3 py-[0.32rem] text-base font-normal text-neutral-700 transition duration-300 ease-in-out file:-mx-3 file:-my-[0.32rem] file:overflow-hidden file:rounded-none file:border-0 file:border-solid file:border-inherit file:bg-neutral-100 file:px-3 file:py-[0.32rem] file:text-neutral-700 file:transition file:duration-150 file:ease-in-out file:[border-inline-end-width:1px] file:[margin-inline-end:0.75rem] hover:file:bg-neutral-200 focus:border-primary focus:text-neutral-700 focus:shadow-te-primary focus:outline-none" required>
                    </div>
                    <div class="mb-6 flex flex-wrap items-center gap-2">
                        <div class="w-[100px] h-[80px] rounded overflow-hidden drop-shadow border hidden thumbnailOrigin">
                            <img src="" id='img1' alt="" class="w-full h-full object-cover object-center">
                        </div>
                    </div>
                    <hr class="mb-1">
                    <button type="submit" onClick={ChecklistAdd()} class="text-white font-medium rounded-lg text-md w-full sm:w-full px-5 py-2 text-center bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300">บันทึกข้อมูล</button>
                </form>
            </div>
        </div>
    </div>

    <!-- Modal Edit -->
    <div id="modalEdit" class="modal hidden fixed z-[100] pt-[100px] left-0 top-0 w-[100%] h-[100%] overflow-auto max-md:px-[10px]">
        <!-- Modal content -->
        <div class="modal-content bg-white m-auto p-[20px] rounded-md drop-shadow-xl xl:w-[50%] lg:w-[60%] md:w-[60%] sm:w-[70%] mt-[-50px] max-md:mt-[-45px]">
            <div class="flex items-center">
                <p class="text-[20px] font-bold w-full ml-4 text-center">แก้ไขเช็คลิสต์</p>
                <span class="closeEdit text-gray-500 text-[30px] font-medium absolute top-0 right-0 mr-4 hover:text-indigo-600 cursor-pointer">&times;</span>
            </div>
            <hr class="mt-4">
            <div class="mt-2">
                <form action="#!" method="post" onsubmit="return false;" encrypt="multipart/form-data">
                    @csrf
                    <input type="text" id="checklist_id_edit" value="" hidden>
                    <div class="grid gap-6 mb-6 md:grid-cols-2">
                        <div>
                            <label for="title" class="block mb-2 text-md font-medium text-gray-700">หัวข้อ <span class="text-red-800">*</span></label>
                            <input type="text" id="title_edit" class="bg-gray-50 border border-gray-300 text-gray-700 text-md font-light rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2" placeholder="Title..." required>
                        </div>
                        <div>
                            <label for="status" class="block mb-2 text-md font-medium text-gray-700">สถานะ</label>
                            <select id="status_edit" class="bg-gray-50 border border-gray-300 text-gray-700 text-md font-light rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2" required>
                                <option selected value="1" class="font-light text-gray-700">รอดำเนินการ</option>
                                <option value="2" class="font-light text-gray-700">กำลังดำเนินการ</option>
                                <option value="3" class="font-light text-gray-700">เสร็จสิ้น</option>
                            </select>
                            <!-- <input type="text" id="status_edit" class="bg-gray-50 border border-gray-300 text-gray-700 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2" placeholder="Status..." required> -->
                        </div>
                    </div>
                    <div class="mb-6">
                        <label for="detail" class="block mb-2 text-md font-medium text-gray-700">รายละเอียด</label>
                        <textarea id="detail_edit" class="bg-gray-50 border border-gray-300 text-gray-700 text-md font-light rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2" placeholder="กรุณากรอกรายละเอียด"></textarea>
                    </div>
                    <div class="mb-6 grid grid-cols-2 max-md:grid-cols-1">
                        <label for="image_edit" class="col-span-2 block mb-2 text-md font-medium text-gray-700">รูปภาพ <span class="text-red-800">*<span class="text-[12px] text-rose-800">สูงสุด 8 รูปภาพ</span></span></label>
                        <input type="file" multiple onChange={fileChosen(event)} id="image_edit" name="image" accept="image/png, image/jpeg" class="font-light m-0 block w-full min-w-0 flex-auto rounded border border-solid border-neutral-300 bg-clip-padding px-3 py-[0.32rem] text-base font-normal text-neutral-700 transition duration-300 ease-in-out file:-mx-3 file:-my-[0.32rem] file:overflow-hidden file:rounded-none file:border-0 file:border-solid file:border-inherit file:bg-neutral-100 file:px-3 file:py-[0.32rem] file:text-neutral-700 file:transition file:duration-150 file:ease-in-out file:[border-inline-end-width:1px] file:[margin-inline-end:0.75rem] hover:file:bg-neutral-200 focus:border-primary focus:text-neutral-700 focus:shadow-te-primary focus:outline-none">
                    </div>
                    <div class="mb-6 flex flex-wrap items-center gap-2">
                        <div class="w-[100px] h-[80px] max-md:w-[90px] max-md:h-[70px] rounded overflow-hidden drop-shadow border hidden thumbnailOrigin_edit">
                            <img src="" id='_image_edit' alt="" class="w-full h-full object-cover object-center">
                        </div>
                    </div>
                    <hr class="mb-1">
                    <button type="submit" onClick={ChecklistEdit()} class="text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-md w-full sm:w-full px-5 py-2 text-center">บันทึกการแก้ไข</button>
                </form>
            </div>
        </div>
    </div>

    <!-- Modal View -->
    <div id="modalView" class="modal hidden fixed z-[100] pt-[100px] left-0 top-0 w-[100%] h-[100%] overflow-auto max-md:px-[10px]">
        <!-- Modal content -->
        <div class="modal-content bg-white m-auto p-[20px] rounded-md drop-shadow-xl xl:w-[50%] lg:w-[60%] md:w-[70%] sm:w-[80%] mt-[-70px] max-md:mt-[-45px]">
            <div class="flex items-center">
                <p class="text-[20px] font-bold w-full ml-4 text-center">รายละเอียด</p>
                <span class="closeView text-gray-500 text-[30px] font-medium absolute top-0 right-0 mr-4 hover:text-indigo-600 cursor-pointer">&times;</span>
            </div>
            <hr class="mt-4">
            <div class="mt-2">
                <div class="grid grid-cols-2 mb-6"> 
                    <div class="">
                        <label for="title" class="block mb-2 text-md font-medium text-gray-700">หัวข้อ</label>
                        <p id="title" class="mt-[-10px] text-gray-500 font-light cursor-auto px-3 text-md break-all"></p>
                    </div>
                    <div class="row-span-2 mb-6 flex flex-wrap items-center gap-2 mx-auto">
                        <div class="w-[125px] h-[105px] rounded overflow-hidden drop-shadow border hidden thumbnailView">
                            <span class="numberImg font-medium text-[14px] text-blue-600 bg-white rounded-b !rounded-r-none border border-gray-400 mt-[-2px] drop-shadow px-[3px] absolute right-0 z-[102] hidden">+n</span>
                            <img src="" id='_image_view' alt="" class="btnImage w-full h-full object-cover object-center hover:scale-90 duration-300 cursor-pointer">
                        </div>
                    </div>
                    <div class="max-sm:col-span-2">
                        <label for="detail" class="block mb-2 text-md font-medium text-gray-700">รายละเอียด</label>
                        <p id="detail" class="mt-[-10px] text-gray-500 font-light cursor-auto px-3 text-md break-all" readonly>-</p>
                    </div>
                </div>
                <hr class="mt-7">
                <div class="p-3 max-md:p-0">
                    
                    <!-- Comment -->
                    <label for="description" class="block mb-2 text-md font-medium text-gray-700">ความคิดเห็น</label>
                    <div class="relative px-3 py-2 pl-3 mb-1 border border-gray-200 rounded-md commentBox hidden" id="commentBoxPt">
                        <div class="flex items-center grid grid-cols-2">
                            <p class="text-[16px] font-medium text-gray-600 mt-[-10px] truncate" id="commentBoxPt_name">User</p>
                            <div class="ml-auto mr-0 flex items-center my-auto truncate">
                                <p id="commentBoxPt_type" class="inline-block bg-gray-200 rounded-full px-3 py-1 text-[13px] font-light text-gray-700 mb-2 max-md:text-[12px]">Employee</p>
                            </div>
                            <div class="absolute top-0 right-0 mt-[2px] mr-[2px]">
                                <div class="flex items-center justify-center bg-white rounded-full border">
                                    <i class='bx bx-dots-horizontal-rounded text-[14px] text-gray-500 bg-white rounded-full p-[1px] border drop-shadow hover:text-black hover:font-bold hover:drop-shadow-xl duration-300 cursor-pointer'></i>
                                </div>

                                <!-- START GROUP BUTTON -->
                                <div class="z-10 log-edit-delete absolute right-0 bg-white rounded-md drop-shadow border border-gray-200 p-1 hidden">
                                    <div class="flex items-center w-[110px] div-log">
                                        <button class="btnLogComment w-full text-gray-500 flex items-center gap-1 px-[2px] rounded hover:bg-yellow-200 hover:text-yellow-600 duration-300">
                                            <i class='bx bx-history'></i>
                                            <span class="my-auto overflow-x-hidden text-[12px] whitespace-nowrap">บันทีกการแก้ไข</span>
                                        </button>
                                    </div>
                                    <hr class="my-1 tag-hr-1">
                                    <div class="flex items-center w-[110px] div-edit">
                                        <button class="btnEditComment w-full text-gray-500 flex items-center gap-1 px-[2px] rounded hover:bg-blue-200 hover:text-blue-600 duration-300">
                                            <i class='bx bx-edit'></i>
                                            <span class="my-auto overflow-x-hidden text-[12px] whitespace-nowrap">แก้ไขความคิดเห็น</span>
                                        </button>
                                    </div>
                                    <hr class="my-1 tag-hr-2">
                                    <div class="flex items-center w-[110px] div-delete">
                                        <button class="btnDeleteComment w-full text-gray-500 flex items-center gap-1 px-[2px] rounded hover:bg-red-200 hover:text-red-600 duration-300">
                                            <i class='bx bx-message-square-x'></i>
                                            <span class="my-auto overflow-x-hidden text-[12px] whitespace-nowrap">ลบความคิดเห็น</span>
                                        </button>
                                    </div>
                                </div>
                                <!-- END GROUP BUTTON -->
                            </div>
                            
                            <div class="col-span-2 max-md:col-span-3 px-3 mt-[-10px]">
                                <img id="commentBoxPt_image" src="" alt="" class="commentBoxPt_image w-[80px] h-auto cursor-pointer hover:scale-90 duration-300 rounded-md hover:rounded-none border">
                                <p class="text-[16px] text-gray-500 font-light" id="commentBoxPt_content">Lorem ipsum dolor sit amet.</p>
                            </div>
                        </div>
                        <div class="relative">
                            <div class="inline-flex items-center mt-1">
                                <i class='bx bxs-time-five text-blue-500'></i>
                                <span class="text-[14px] text-gray-500 font-light truncate" id="commentBoxPt_time">Time</span>
                            </div>
                            <div class="inline-flex absolute right-0 mr-[-10px]">
                                <p id="commentBoxPt_status0" class="hidden inline-block bg-blue-200 rounded-full px-2 py-1 text-[13px] font-light text-blue-600 mr-2 mb-2 max-md:text-[12px]"><i class='bx bxs-alarm-exclamation' ></i> กำลังดำเนินการ</p>
                                <p id="commentBoxPt_status1" class="hidden inline-block bg-yellow-200 rounded-full px-2 py-1 text-[13px] font-light text-yellow-600 mr-2 mb-2 max-md:text-[12px]"><i class='bx bxs-alarm-exclamation' ></i> ยังไม่เสร็จสิ้น</p>
                                <p id="commentBoxPt_status2" class="hidden inline-block bg-green-200 rounded-full px-2 py-1 text-[13px] font-light text-green-600 mr-2 mb-2 max-md:text-[12px]"><i class='bx bxs-alarm-exclamation' ></i> เสร็จสิ้น</p>
                            </div>
                        </div>
                    </div>
                    <!-- End Comment -->

                    <div class="p-3 mb-1 border-2 border-gray-200 rounded-md commentBox hidden" id="NoCommentBoxPt">
                        <div class="flex items-center justify-center">
                            <p class="text-md font-light text-gray-500" id="commentBoxPt_name">ไม่พบข้อมูลความคิดเห็น</p>
                        </div>
                    </div>

                    <div class="overflow-y-auto border-2 border-gray-300 p-1 rounded-md h-96 hidden" id="scrollContainer">
                        <div id="newCommentPasteHere"></div>
                    </div>
                    
                    <!-- Form Comment -->
                    <form action="#!" method="POST" onSubmit="return false;" id="commentForm" class="mt-9">
                        @csrf
                        <input type="text" id="id" hidden>
                        <div class="flex items-center text-md mb-2 grid grid-cols-3 max-md:grid-cols-2">
                            <div class="flex items-center col-span-2 max-md:col-span-1">
                                <p class="font-medium text-gray-700">จาก: </p>
                                <input type="text" id="username" value="ลูกค้า" class="max-md:w-[120px] bg-gray-50 border border-gray-300 text-gray-700 text-[16px] font-light rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-fit p-2 outline-none ml-1 h-[35px]" placeholder="กรุณากรอกชื่อ" required>
                            </div>
                            <div>
                                <select id="status_view" class="bg-gray-50 border border-gray-300 text-gray-700 font-light text-md rounded focus:ring-blue-500 focus:border-blue-500 block w-full p-1" required>
                                    <option selected value="1" class="font-light text-gray-700">ยังไม่เสร็จสิ้น</option>
                                    <option value="2" class="font-light text-gray-700">เสร็จสิ้น (ปิดเช็คลิสต์นี้)</option>
                                </select>
                            </div>
                        </div>
                        <textarea id="comment" class="bg-gray-50 border border-gray-300 text-gray-900 text-md font-light rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2 focus:outline-none rounded-b-sm" placeholder="เขียนความคิดเห็น..." required></textarea>
                        <div class="flex items-center space-x-2 bg-gray-200 rounded-b-md">
                            <div class="shrink-0 ml-1 mt-1 mb-1">
                                <img id='preview_img' class="bg-white h-11 w-11 object-cover rounded-full" src="https://icons-for-free.com/iconfiles/png/512/mountains+photo+photos+placeholder+sun+icon-1320165661388177228.png" alt="Current profile photo" />
                            </div>
                            <label class="block w-full">
                                <div class="grid grid-cols-2">
                                    <span class="sr-only">Choose profile photo</span>
                                    <input type="file"  onChange={fileChosen(event)} id="imageView" name="image" accept="image/png, image/jpeg" class="block w-full text-sm text-slate-500
                                        file:mr-4 file:py-2 file:px-4
                                        file:rounded-full file:border-0
                                        file:text-sm file:font-semibold
                                        file:bg-blue-50 file:text-blue-700
                                        hover:file:bg-blue-100 duration-300
                                    "/>
                                    <div class="ml-auto mr-1 inline-flex">
                                        <button type="submit" class="bg-blue-500 text-white text-sm hover:bg-blue-600 rounded-md h-full px-2 py-0 flex items-center ml-auto mr-0 duration-150 whitespace-nowrap"><i class='bx bxs-send'></i>&nbsp;ยืนยัน</button>
                                    </div>
                                </div>
                            </label>
                        </div>
                    </form>
                    <!-- End Form Comment -->

                    <div class="modal-body">
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal Log -->
    <div id="modalLog" class="modal hidden fixed z-[100] pt-[100px] left-0 top-0 w-[100%] h-[100%] overflow-auto max-md:px-[10px]">
        <!-- Modal content -->
        <div class="modal-content bg-white m-auto p-[20px] rounded-md drop-shadow-xl xl:w-[80%] lg:w-[80%] md:w-[80%] max-md:mt-[-50px] max-md:w-[90%]">
            <div class="flex items-center">
                <p class="text-[20px] font-bold w-full ml-4 text-center">บันทึกการแก้ไขความคิดเห็น</p>
                <span class="closeLog text-gray-500 text-[30px] font-medium absolute top-0 right-0 mr-4 hover:text-indigo-600 cursor-pointer">&times;</span>
            </div>
            <hr class="mt-4">
            <div class="mt-2 overflow-y-auto rounded-md h-96 drop-shadow-md">
                <table class="w-full border max-md:hidden">
                    <thead class="text-gray-700 uppercase bg-gray-100 text-center text-[16px]">
                        <tr class="truncate">
                            <th scope="col" class="px-6 py-3 font-medium">
                                แก้ไขเมื่อ
                            </th>
                            <th scope="col" class="px-6 py-3 font-medium">
                                ความคิดเห็น
                            </th>
                            <th scope="col" class="px-6 py-3 font-medium">
                                รูปภาพ
                            </th>
                            <th scope="col" class="px-6 py-3 font-medium">
                                สถานะ
                            </th>
                            <th scope="col" class="px-6 py-3 font-medium">
                                การกระทำ
                            </th>
                            <th scope="col" class="px-6 py-3 font-medium">
                                กระทำโดย
                            </th>
                        </tr>
                    </thead>
                    <tbody class="text-gray-500 text-[16px] text-center font-light">
                        <tr class="bg-white hidden" id="tableLogPt">
                            <td scope="row" class="px-6 py-4">
                                <p id="tableLogPt_updated_at" class="truncate">Updated At</p>
                            </td>
                            <td class="px-6 py-4 truncate">
                                <p id="tableLogPt_comment" class="truncate">Comment</p>
                            </td>
                            <td class="px-6 py-4 truncate">
                                <div class="flex flex-wrap items-center gap-2 mx-auto">
                                    <div class="w-[80px] h-[60px] rounded overflow-hidden drop-shadow border imageLog">
                                        <img src="" id='tableLogPt_image' alt="" class="commentBoxPt_image w-full h-full object-cover object-center hover:scale-90 duration-300 cursor-pointer">
                                    </div>
                                </div>
                            </td>
                            <td class="px-6 py-4 truncate">
                                <p id="tableLogPt_status">Status</p>
                            </td>
                            <td class="px-6 py-4 truncate">
                                <p id="tableLogPt_action">Action</p>
                            </td>
                            <td class="px-6 py-4 truncate">
                                <p id="tableLogPt_action_by">Action By</p>
                            </td>
                        </tr>
                    </tbody>
                    <tbody class="text-gray-500 text-[16px] text-center font-light" id="newTrPasteHere"></tbody>
                </table>

                <!-- START MOBILE -->
                <div class="bg-white p-4 rounded-md border max-md:block hidden max-md:block">
                    <div id="tableLogPt_mobile" class="text-left truncate hidden">
                        <p class="text-gray-700 font-medium">แก้ไขเมื่อ: <span id="tableLogPt_updated_at_mobile" class="text-[14px] font-light text-gray-500">Updated At</span></p>
                        <p class="text-gray-700 font-medium inline-flex flex items-center">รูปภาพ: 
                            <span id="span-noImage" class="hidden">-</span>
                            <image src="" id="tableLogPt_image_mobile" class="commentBoxPt_image w-[60px] border rounded ml-1">
                        </p>
                        <p class="text-gray-700 font-medium">ความคิดเห็น: <span id="tableLogPt_comment_mobile" class="font-light text-gray-500">Comment</span></p>
                        <p class="text-gray-700 font-medium">การกระทำ: <span id="tableLogPt_action_mobile" class="font-light text-gray-500">Action</span></p>
                        <p class="text-gray-700 font-medium">กระทำโดย: <span id="tableLogPt_action_by_mobile" class="font-light text-gray-500">Comment By</span></p>
                        <p class="text-gray-700 font-medium">สถานะ: 
                            <span id="tableLogPt_status1_mobile" class="hidden w-fit text-blue-600 text-[13px] font-light bg-blue-200 rounded-2xl px-2">Status</span>
                            <span id="tableLogPt_status2_mobile" class="hidden w-fit text-yellow-600 text-[13px] font-light bg-yellow-200 rounded-2xl px-2">Status</span>
                            <span id="tableLogPt_status3_mobile" class="hidden w-fit text-green-600 text-[13px] font-light bg-green-200 rounded-2xl px-2">Status</span>
                        </p>
                        </td>
                        <hr class="bg-blue-300 border-dashed border-gray-300 w-full my-2 rounded-2xl">
                    </div>
                    <div class="text-gray-500 text-[16px] text-center" id="newTrPasteHere_mobile"></div>
                </div>
                <!-- END MOBILE -->
            </div>
        </div>
    </div>

    <!-- Modal Edit Comment -->
    <div id="modalEditComment" class="modal hidden fixed z-[100] pt-[100px] left-0 top-0 w-[100%] h-[100%] overflow-auto max-md:px-[10px]">
        <!-- Modal content -->
        <div class="modal-content bg-white m-auto p-[20px] rounded-md drop-shadow-xl w-[40%] max-lg:w-[60%] max-md:w-[90%]">
            <div class="flex items-center">
                <p class="text-[20px] font-bold w-full ml-4 text-center">แก้ไขความคิดเห็น</p>
                <span class="closeEditComment text-gray-500 text-[30px] font-medium absolute top-0 right-0 mr-4 hover:text-indigo-600 cursor-pointer">&times;</span>
            </div>
            <hr class="mt-4">
            <div class="mt-2">
                <form action="#!" method="post" onsubmit="return false;" encrypt="multipart/form-data">
                    @csrf
                    <input type="text" id="comment_id_edit" value="" hidden>
                    <div class="mb-6">
                        <label for="comment" class="block mb-2 text-md font-medium text-gray-700">ความคิดเห็น</label>
                        <textarea id="comment_edit" class="bg-gray-50 border border-gray-300 text-gray-700 text-md font-light rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2" placeholder="เขียนความคิดเห็น..."></textarea>
                    </div>
                    <label class="block mb-2 text-md font-medium text-gray-700">รูปภาพ</label>
                    <div class="flex items-center space-x-2 bg-gray-200 rounded">
                        <div class="shrink-0 ml-1 mt-1 mb-1">
                            <img id='preview_comment_image_edit' class="bg-white h-11 w-11 object-cover rounded-full" src="https://icons-for-free.com/iconfiles/png/512/mountains+photo+photos+placeholder+sun+icon-1320165661388177228.png" alt="Current profile photo" />
                        </div>
                        <label class="block w-full">
                            <span class="sr-only">Choose profile photo</span>
                            <input type="file"  onChange={fileChosen(event)} id="comment_image_edit" name="image" accept="image/png, image/jpeg" class="block w-full text-sm text-slate-500
                                file:mr-4 file:py-2 file:px-4
                                file:rounded-full file:border-0
                                file:text-sm file:font-semibold
                                file:bg-blue-50 file:text-blue-700
                                hover:file:bg-blue-100 duration-300
                            "/>
                        </label>
                    </div>
                    <hr class="mb-1 mt-6">
                    <button type="submit" onClick={CommentEdit()} class="text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-md w-full sm:w-full px-5 py-2 text-center">บันทึกการแก้ไข</button>
                </form>
            </div>
        </div>
    </div>

    <!-- Modal Image -->
    <div id="modalImage" class="modalImage modal hidden fixed z-[101] left-0 top-0 w-[100%] h-[100%] overflow-auto">
        <!-- Modal content -->
        <div class="modal-content fixed inset-0 flex items-center justify-center max-md:px-[20px]">
            <div class="relative w-[640px] max-h-[90vh] object-cover bg-white rounded">
                <div class="w-auto max-h-[90vh] flex justify-center border-2 rounded p-3">
                    <img id="_image" src="" alt="" class="w-auto h-auto object-cover bg-white">
                </div>
                <span class="numberText absolute top-0 left-0 ml-2 mt-1 bg-white rounded drop border px-1">1 / n</span>
                <span class="closeImage text-black bg-white rounded-full drop-shadow text-[24px] font-bold h-fit font-medium absolute top-0 right-0 mt-2 mr-2 hover:text-indigo-600 hover:bg-indigo-200 duration-300 cursor-pointer"><i class='bx bx-x'></i></span>
                <a id="img_prev" class="bg-white border drop-shadow rounded-full absolute left-1 top-[50%] px-2 hover:text-indigo-600 hover:bg-indigo-200 duration-300 cursor-pointer" onclick="plusSlides(-1)">&#10094;</a>
                <a id="img_next" class="bg-white border drop-shadow rounded-full absolute right-1 top-[50%] px-2 hover:text-indigo-600 hover:bg-indigo-200 duration-300 cursor-pointer" onclick="plusSlides(1)">&#10095;</a>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
    <script>
        $(document).ready(function () {
            // Modal Add
            $('.btnAdd').on('click', function () {
                $("#modalAdd").css("display", "block");
            });
            $('.closeAdd').on('click', function () {
                var modal = document.getElementById("modalAdd");
                modal.classList.add("fade-out-modal");

                // After the animation is complete (0.5s in this case), you can remove the modal from the DOM
                setTimeout(function() {
                    modal.style.display = "none";
                    modal.classList.remove("fade-out-modal");
                }, 500);
            });

            // Modal Edit
            $('.btnEdit').on('click', function () {
                $('.modal-content #checklist_id_edit').val($(this).data('id'));
                $('.modal-content #title_edit').val($(this).data('title'));
                $('.modal-content #detail_edit').val($(this).data('detail'));
                if($(this).data('status') == '1') {
                    $('.modal-content #status_edit option[value="2"]').prop('disabled', true).addClass('text-gray-300');
                    $('.modal-content #status_edit option[value="3"]').prop('disabled', true).addClass('text-gray-300');
                    $('.modal-content #status_edit').val($(this).data('status'));
                } else if($(this).data('status') == '2') {
                    $('.modal-content #status_edit option[value="1"]').prop('disabled', true).addClass('text-gray-300');
                    $('.modal-content #status_edit option[value="3"]').prop('disabled', true).addClass('text-gray-300');
                    $('.modal-content #status_edit').val($(this).data('status'));
                } else {
                    $('.modal-content #status_edit option[value="1"]').prop('disabled', false).removeClass('text-gray-300');
                    $('.modal-content #status_edit option[value="2"]').prop('disabled', true).addClass('text-gray-300');
                    $('.modal-content #status_edit').val($(this).data('status'));
                }

                $('.thumbnailClone_edit').remove();
                var imageName_edit = $(this).data('image');
                $('.modal-content #_image_edit').empty();
                for (var i = 0; i < imageName_edit.urls.length; i++) {
                    var imageEdit = $(".thumbnailOrigin_edit").clone();
                    imageEdit.removeClass('thumbnailOrigin_edit hidden').addClass('thumbnailClone_edit').find('img').attr('src', '<?php echo URL('/uploads'); ?>' + '/' + imageName_edit.urls[i]).attr('id', 'image_' + i);
                    $(".thumbnailOrigin_edit").before(imageEdit);
                }

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
                    title: `คุณแน่ใจหรือไม่ที่ต้องการลบ?`,
                    html: `<b class="text-rose-800 font-medium">(ชื่อเช็คลิสต์: ${$(this).data('title')})</b><br>การดำเนินการนี้ไม่สามารถเรียกคืนได้`,
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
                        ChecklistDelete(id);
                    }
                })
            });

            // Modal View
            $('.btnView').on('click', function () {
                $('#newCommentPasteHere').html('<div id="preload" class="text-center"><div role="status"><svg aria-hidden="true" class="absolute inline w-8 h-8 mr-2 text-gray-200 animate-spin :text-gray-600 fill-blue-600" viewBox="0 0 100 101" fill="none" xmlns="http://www.w3.org/2000/svg"><path d="M100 50.5908C100 78.2051 77.6142 100.591 50 100.591C22.3858 100.591 0 78.2051 0 50.5908C0 22.9766 22.3858 0.59082 50 0.59082C77.6142 0.59082 100 22.9766 100 50.5908ZM9.08144 50.5908C9.08144 73.1895 27.4013 91.5094 50 91.5094C72.5987 91.5094 90.9186 73.1895 90.9186 50.5908C90.9186 27.9921 72.5987 9.67226 50 9.67226C27.4013 9.67226 9.08144 27.9921 9.08144 50.5908Z" fill="currentColor"/><path d="M93.9676 39.0409C96.393 38.4038 97.8624 35.9116 97.0079 33.5539C95.2932 28.8227 92.871 24.3692 89.8167 20.348C85.8452 15.1192 80.8826 10.7238 75.2124 7.41289C69.5422 4.10194 63.2754 1.94025 56.7698 1.05124C51.7666 0.367541 46.6976 0.446843 41.7345 1.27873C39.2613 1.69328 37.813 4.19778 38.4501 6.62326C39.0873 9.04874 41.5694 10.4717 44.0505 10.1071C47.8511 9.54855 51.7191 9.52689 55.5402 10.0491C60.8642 10.7766 65.9928 12.5457 70.6331 15.2552C75.2735 17.9648 79.3347 21.5619 82.5849 25.841C84.9175 28.9121 86.7997 32.2913 88.1811 35.8758C89.083 38.2158 91.5421 39.6781 93.9676 39.0409Z" fill="currentFill"/></svg><span class="sr-only">Loading...</span></div></div>');
                $('.modal-content #id').val($(this).data('id'));
                $('.modal-content #title').text($(this).data('title'));
                if($(this).data('detail')) {
                    $('.modal-content #detail').text($(this).data('detail'));
                }
                $('.modal-content #status').val($(this).data('status'));
                // $('.modal-content #_image_view').attr("src", $(this).data('image'));

                var imageName = $(this).data('image');
                var zIndex = 50;
                $('.modal-content #_image_view').empty();
                for (var i = 0; i < imageName.urls.length; i++) {
                    var imageView = $(".thumbnailView").clone();
                    imageView.removeClass('thumbnailView hidden').addClass('imageCloned').find('img').attr('src', '<?php echo URL('/uploads'); ?>' + '/' + imageName.urls[i]).attr('id', 'image_' + i);
                    $('.numberImg').removeClass('hidden').text('+'+(imageName.urls.length-1));
                    if(i === 0) {
                        imageView.addClass('bg-white border border-gray-400 z-[101]');
                    } else {
                        imageView.closest('.imageCloned').addClass('bg-white border border-gray-400 absolute ml-['+(i*2)+'px] z-'+zIndex);
                    }
                    $(".thumbnailView").before(imageView);

                    zIndex-=10;
                }
                
                var statusValue = $(this).data('status');
                handleStatus(statusValue);
                $('.modal-body #btnSuccessChecklist').data('id', $(this).data('id'));

                $("#modalView").data('status', statusValue).css("display","block");
            });
            $('.closeView').on('click', function () {
                var modal = document.getElementById("modalView");
                modal.classList.add("fade-out-modal");
                $("#scrollContainer").addClass("hidden");
                $('.imageCloned').remove();
                $('#preview_img').attr('src', 'https://icons-for-free.com/iconfiles/png/512/mountains+photo+photos+placeholder+sun+icon-1320165661388177228.png');
                $('#imageView').val('');

                // After the animation is complete (0.5s in this case), you can remove the modal from the DOM
                setTimeout(function() {
                    modal.style.display = "none";
                    modal.classList.remove("fade-out-modal");
                }, 500);
            });

            // Modal Image Old
            $('.btnImage').on('click', function () {
                $('.modal-content #_image').attr("src", $(this).attr("src"));
                $("#modalImage").css("display", "block");
                // $("#modalImage").removeClass("hidden");
                // $("#modalImage").addClass("opacity-100");
                // $("#modalImage").fadein();
            });
            $('.closeImage').on('click', function () {
                var modal = document.getElementById("modalImage");
                modal.classList.add("fade-out-modalImage");

                // After the animation is complete (0.5s in this case), you can remove the modal from the DOM
                setTimeout(function() {
                    modal.style.display = "none";
                    modal.classList.remove("fade-out-modalImage");
                }, 500);
            });

            // Comment
            $('#commentForm [type="submit"]').on('click', function () {
                saveComment($(this));
            });

            $('.closeLog').on('click', function () {
                var modal = document.getElementById("modalLog");
                modal.classList.add("fade-out-modal");

                $("#newTrPasteHere").empty();
                $("#newTrPasteHere_mobile").empty();

                setTimeout(function() {
                    modal.style.display = "none";
                    modal.classList.remove("fade-out-modal");
                }, 500);
            });

            $(document).on('click', '.commentBox .bx-dots-horizontal-rounded', function () {
                $(this).parent().next().toggleClass('hidden');
            });
        });

        // Modal BoxPt_image
        $(document).on('click', '.commentBoxPt_image', function () {
            // console.log($(this).attr("src"));
            $('.numberText').remove();
            $('#img_prev').remove();
            $('#img_next').remove();
            $('.modal-content #_image').attr("src", $(this).attr("src"));
            $("#modalImage").css("display", "block");
        });

        //Modal Image
        $(document).on('click', '.btnImage', function () {
            var id = $(this).attr('id');
            var index = id.split('_')[1];
            currentSlide(index);
            $('.modal-content #_image').attr("src", $(this).attr("src"));
            $("#modalImage").css("display", "block");
        });

        // Modal btnLogComment
        $(document).on('click', '.btnLogComment', function () {
            $("#modalLog").css("display","block");
        });

        // Modal btnEditComment
        $(document).on('click', '.btnEditComment', function () {
            $('.modal-content #comment_id_edit').val($(this).data('id'));
            $('.modal-content #comment_edit').val($(this).data('comment'));
            if($(this).data('image')) {
                $('.modal-content #preview_comment_image_edit').attr('src', '<?php echo URL('/uploads') ?>' + '/' + $(this).data('image'));
            }
            $("#modalEditComment").css("display","block");
        });
        $('.closeEditComment').on('click', function () {
            var modal = document.getElementById("modalEditComment");
            modal.classList.add("fade-out-modal");

            setTimeout(function() {
                modal.style.display = "none";
                modal.classList.remove("fade-out-modal");
            }, 500);
        });

        // SweetAlert btnDeleteComment
        $(document).on('click', '.btnDeleteComment', function () {
            Swal.fire({
                title: `คุณแน่ใจหรือไม่ที่ต้องการลบ?`,
                html: 'การดำเนินการนี้ไม่สามารถเรียกคืนได้',
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
                    CommentDelete(id);
                }
            })
        });

        var slideIndex = 0;
        function plusSlides(n) {
            showSlides(slideIndex + n);
        }
        function currentSlide(n) {
            showSlides(n);
        }
        function showSlides(n) {
            var i;
            var slides = document.querySelectorAll('.imageCloned img');
            slideIndex = (n + slides.length) % slides.length;
            $('#_image').attr('src', slides[slideIndex].src);
            $('.numberText').html(slideIndex + 1 + ' / ' + slides.length);
            console.log(slides.length);
            if(slides.length === 1) {
                $('#img_prev').remove();
                $('#img_next').remove();
            }
        }


        function handleStatus(status) {
            var modalContent = $('.modal-body');
            var formContent = $('#commentForm');
            if(status == '1'|| status == '2') {
                formContent.removeClass('hidden');
                // modalContent.html('<br><hr class="mb-1"><button type="button" id="btnSuccessChecklist" class="btnSuccessChecklist bg-green-500 text-white text-sm hover:bg-green-600 rounded-md py-2 px-5 w-full duration-150" onClick="ChecklistSuccess(this)">CLOSE CHECKLIST</button>');
            } else {
                formContent.addClass('hidden');
            }
        }
        

        var _image64 = [];
        function fileChosen(event) {
            this.fileToDataUrl(event);
        }
        function fileToDataUrl(event) {
            if (! event.target.files.length){ 
                callback('');
                return
            }

            var _newImgArr = [];
            count = 1;
            limit = event.target.files.length;

            $.each(event.target.files,function(){
                let file = $(this)[0],
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
                            ctx.drawImage(img, 0, 0, iwScaled, ihScaled);
                            var converted_img = canvas.toDataURL();
                            var _avatar_base64 = converted_img;   
                        }
                        _newImgArr.push(_avatar_base64);
                        // console.log('imgAr: '+JSON.stringify(_newImgArr));
                        if (count >= limit) fileHanddle(_newImgArr);
                        count++;                 
                    }					
                };            
            });

            return;
        }
        function fileHanddle(src){
            // console.log('src: '+src);
            $('.thumbnailClone').remove();
            $.each(src, function(inx, val){
                var _html = $(".thumbnailOrigin").clone();
                _html.removeClass('thumbnailOrigin hidden').addClass('thumbnailClone').find('img').attr('src',val).attr('id','img' + parseFloat($('img').length) + 1); 
                $(".thumbnailOrigin").after(_html);
            });

            $('.thumbnailClone_edit').remove();
            $.each(src, function(inx, val){
                var _html = $(".thumbnailOrigin_edit").clone();
                _html.removeClass('thumbnailOrigin_edit hidden').addClass('thumbnailClone_edit').find('img').attr('src',val).attr('id','img' + parseFloat($('img').length) + 1); 
                $(".thumbnailOrigin_edit").after(_html);
            });

            $('#preview_img').attr('src', src);
            $('#preview_comment_image_edit').attr('src', src);
            // $("#img1").css("display","block");
            // $("#img1").attr("src", src);
            // $("#_image").attr("src", src);
            // $("#_image_edit").attr("src", src);
            _image64 = src;
        }

        function ChecklistConfirm(element){
            Swal.fire({
                title: `คุณแน่ใจหรือไม่?`,
                html: `<b class="text-rose-800 font-medium">(ชื่อเช็คลิสต์: ${$(element).data('title')})</b><br>การดำเนินการนี้คือการแสดงว่าคุณได้ตรวจสอบเช็คลิสต์นี้แล้ว`,
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'ใช่, บันทึก',
                cancelButtonText: 'ยกเลิก'
            }).then((result) => {
                if (result.isConfirmed) {
                    fetch("{{ Route('ChecklistConfirm') }}", {
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
        
                        console.log(data);
                        if(!response.ok){
                            const error = (data && data.errorMessage) || "{{trans('general.warning.system_failed')}}" + " (CODE:"+response.status+")";
                            return Promise.reject(error);
                        }
        
                        Swal.fire({
                            position: 'center',
                            icon: 'success',
                            title: 'บันทึกข้อมูลสำเร็จ',
                            timer: 1000,
                            timerProgressBar: true
                        }).then((result) => {
                            $('#waiting_' + data).html("<i class='bx bxs-check-square text-xl'></i>ตรวจสอบแล้ว");
                            $('#waiting_' + data).removeAttr("onClick")
                                                .removeClass("text-white bg-indigo-500 border border-indigo-300 rounded-md px-2 py-1 hover:bg-indigo-600 duration-300 cursor-pointer")
                                                .addClass("text-teal-600");
                            $('#waiting_mobile_' + data).html("<i class='bx bxs-check-square text-xl'></i>ตรวจสอบแล้ว");
                            $('#waiting_mobile_' + data).removeAttr("onClick")
                                                        .removeClass("text-white bg-indigo-500 border border-indigo-300 rounded-3xl px-2 py-1 hover:bg-indigo-600 duration-300 cursor-pointer")
                                                        .addClass("ml-auto mr-0 text-teal-600 px-2");
                        })
                    })
                    .catch((er) => {
                        console.log('Error' + er);
                        Swal.fire({
                            position: 'center',
                            icon: 'error',
                            title: 'บันทึกข้อมูลไม่สำเร็จ!'
                        })
                    });
                }
            })
        }
        
        function ChecklistAdd(){
            if(document.getElementById("title_add").value != '' &&
                document.getElementById("image").value != '') {
                fetch("{{ Route('ChecklistAdd') }}", {
                    method: "POST",
                    headers: {
                        "Content-Type": "application/json",
                        "Accept": "application/json",
                        "X-CSRF-Token": '{{csrf_token()}}'
                    },
                    body:JSON.stringify(
                        {
                            project_id: document.getElementById("project_id").value,
                            defect_id: document.getElementById("defect_id_add").value,
                            title: document.getElementById("title_add").value,
                            detail: document.getElementById("detail_add").value,
                            created_by: document.getElementById("created_by_add").value,
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

                    console.log('Success');
                    Swal.fire({
                        position: 'center',
                        icon: 'success',
                        title: 'เพิ่มเช็คลิสต์สำเร็จ',
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
                        title: 'เพิ่มเช็คลิสต์ไม่สำเร็จ!',
                        text: 'โปรดกรอกข้อมูลให้ครบถ้วน.'
                    })
                });
            }
        }

        function ChecklistEdit(){
            console.log(document.getElementById("title").value);
            if(document.getElementById("title_edit").value) {
                fetch("{{ Route('ChecklistEdit') }}", {
                    method: "POST",
                    headers: {
                        "Content-Type": "application/json",
                        "Accept": "application/json",
                        "X-CSRF-Token": '{{csrf_token()}}'
                    },
                    body:JSON.stringify(
                        {
                            id: document.getElementById("checklist_id_edit").value,
                            title: document.getElementById("title_edit").value,
                            detail: document.getElementById("detail_edit").value,
                            status: document.getElementById("status_edit").value,
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

                    // if(document.getElementById("status_edit").value == '3') {
                    //     SendMail(data);
                    // }
    
                    Swal.fire({
                        position: 'center',
                        icon: 'success',
                        title: 'แก้ไขเช็คลิสต์สำเร็จ',
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
                        title: 'แก้ไขเช็คลิสต์ไม่สำเร็จ!',
                        text: 'โปรดกรอกข้อมูลให้ครบถ้วน.'
                    })
                });
            }
        }

        function ChecklistDelete(id) {
            fetch("{{ Route('ChecklistDelete') }}", {
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
                    title: 'ลบเช็คลิสต์สำเร็จ',
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
                    title: 'ลบเช็คลิสต์ไม่สำเร็จ!'
                })
            });
        }

        function ChecklistSuccess(_elem) {
            alert($(_elem).data('id'));
            Swal.fire({
                title: 'Are you sure?',
                text: "You won't be able to revert this!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Yes, change status!'
                }).then((result) => {
                if (result.isConfirmed) {
                    fetch("{{ Route('ChecklistSuccess') }}", {
                        method: "POST",
                        headers: {
                            "Content-Type": "application/json",
                            "Accept": "application/json",
                            "X-CSRF-Token": '{{csrf_token()}}'
                        },
                        body:JSON.stringify(
                            {
                                id: $(_elem).data('id')
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
                                title: 'Checklist has been updated.',
                                timer: 1000,
                                timerProgressBar: true
                            }).then((result) => {
                                location.reload();
                            })
                        })
                        .catch((er) => {
                            console.log('Error: ' + er);
                    });
                }
            })
        }

        function scrollToBottom() {
            var container = document.getElementById("scrollContainer");
            container.scrollTop = container.scrollHeight;
        }

        $(document).on('click', function (event) {
            if (!$(event.target).hasClass('bx-dots-horizontal-rounded')) {
                $('.log-edit-delete').addClass("hidden");
            }
        });
        function ChecklistComments(element){
            fetch("{{ Route('ChecklistComments') }}", {
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

                console.log(data);
                if(!response.ok){
                    const error = (data && data.errorMessage) || "{{trans('general.warning.system_failed')}}" + " (CODE:"+response.status+")";
                    return Promise.reject(error);
                }

                if(data[1].length < 1) {
                    $("#NoCommentBoxPt").removeClass("hidden");
                } else {
                    $("#NoCommentBoxPt").addClass("hidden");
                    for(let i=0; i<data[1].length; i++) {
                        $("#scrollContainer").removeClass("hidden");
                        var _newBox = $('#commentBoxPt').clone();
                        _newBox.removeClass("hidden");
                        _newBox.attr('id','boxNo'+data[1][i].id);
                        _newBox.find('#commentBoxPt_name').text(data[1][i].username);

                        // START FORMAT DATE
                            var dateStr = data[1][i].created_at;
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
                                var formattedDate = '0' + day + "-" + month + "-" + year + " " + hours + ":" + (minutes < 10 ? "0" : "") + minutes + ":" + (seconds < 10 ? "0" : "") + seconds + " " + ampm;
                            } else {
                                var formattedDate = day + "-" + month + "-" + year + " " + hours + ":" + (minutes < 10 ? "0" : "") + minutes + ":" + (seconds < 10 ? "0" : "") + seconds + " " + ampm;
                            }
                        // END FORMAT DATE
                        _newBox.find('#commentBoxPt_time').text(formattedDate);

                        _newBox.find('.bx-dots-horizontal-rounded').addClass('dots-'+i);
                        _newBox.find('.log-edit-delete').addClass('group-btn-'+i);

                        if(data[1][i].type == '1') {
                            _newBox.find('#commentBoxPt_type').text('พนักงาน');
                        } else if(data[1][i].type == '2') {
                            _newBox.find('#commentBoxPt_type').text('ลูกค้า');
                        } else {
                            _newBox.find('#commentBoxPt_type').text('Error');
                        }
                        _newBox.find('#commentBoxPt_content').html(data[1][i].comment);
                        if(data[1][i].image) {
                            _newBox.find("#commentBoxPt_image").attr('src', '{{ URL('/uploads/')}}/'+data[1][i].image);
                        } else {
                            _newBox.find("#commentBoxPt_image").remove();
                        }

                        if(data[1][i].status == '0') {
                            _newBox.find('#commentBoxPt_status0').removeClass('hidden');
                        } else if(data[1][i].status == '1') {
                            _newBox.find('#commentBoxPt_status1').removeClass('hidden');
                        } else if(data[1][i].status == '2') {
                            _newBox.find('#commentBoxPt_status2').removeClass('hidden');
                        } else {
                            _newBox.find("#commentBoxPt_image").remove();
                            _newBox.find('#commentBoxPt_content').html('ความคิดเห็นนี้ถูกลบไปแล้ว');
                            _newBox.find('.div-edit').remove();
                            _newBox.find('.div-delete').remove();
                            _newBox.find('.tag-hr-1').remove();
                            _newBox.find('.tag-hr-2').remove();
                        }

                        if(data[0].status == '3') {
                            _newBox.find('.div-edit').remove();
                            _newBox.find('.div-delete').remove();
                            _newBox.find('.tag-hr-1').remove();
                            _newBox.find('.tag-hr-2').remove();
                        }

                        if(data[1][i].type == '1') {
                            _newBox.find('.div-edit').remove();
                            _newBox.find('.div-delete').remove();
                            _newBox.find('.tag-hr-1').remove();
                            _newBox.find('.tag-hr-2').remove();
                        }
                        

                        $("#newCommentPasteHere").append(_newBox);

                        _newBox.find('.btnLogComment').attr('data-id',data[1][i].id).attr('onClick', 'CommentLog(this)');
                        _newBox.find('.btnEditComment').attr('data-id',data[1][i].id).attr('data-comment', data[1][i].comment).attr('data-image', data[1][i].image);
                        _newBox.find('.btnDeleteComment').attr('data-id',data[1][i].id);
                    }

                    setTimeout(function() {
                        scrollToBottom();
                    }, 100);
                }
                $('#preload').html('');
            })
            .catch((er) => {
                console.log('Error' + er);
            });
        }

        var isProcessing = false;
        const saveComment = (_elem) => {
            if(isProcessing === false && 
                document.getElementById("username").value != '' && 
                document.getElementById("comment").value != ''
                ) {
                isProcessing = true;
                if(document.getElementById("status_view").value == '2') {
                    Swal.fire({
                        title: `คุณแน่ใจหรือไม่ที่จะปิดเช็คลิสต์นี้?`,
                        icon: 'warning',
                        showCancelButton: true,
                        confirmButtonColor: '#3085d6',
                        cancelButtonColor: '#d33',
                        confirmButtonText: 'ใช่, ปิด',
                        cancelButtonText: 'ยกเลิก'
                    }).then((result) => {
                        if (result.isConfirmed) {
                            var _form = _elem.parents('form');
                            var _commentContent = _form.find('#comment').val();
                            fetch("{{ Route('CommentAdd_User') }}", {
                                method: "POST",
                                headers: {
                                    "Content-Type": "application/json",
                                    "Accept": "application/json",
                                    "X-CSRF-Token": '{{csrf_token()}}'
                                },
                                body:JSON.stringify(
                                    {
                                        checklist_id: document.getElementById("id").value,
                                        username: document.getElementById("username").value,
                                        comment: document.getElementById("comment").value,
                                        image64: _image64,
                                        status: document.getElementById("status_view").value
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

                                var _countBox = $('.commentBox').length;
                                _countBox++;

                                // START FORMAT CURRENT DATE TIME
                                    var dateStr = new Date();
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
                                        var formattedDate = '0' + day + "-" + month + "-" + year + " " + hours + ":" + (minutes < 10 ? "0" : "") + minutes + ":" + (seconds < 10 ? "0" : "") + seconds + " " + ampm;
                                    } else {
                                        var formattedDate = day + "-" + month + "-" + year + " " + hours + ":" + (minutes < 10 ? "0" : "") + minutes + ":" + (seconds < 10 ? "0" : "") + seconds + " " + ampm;
                                    }
                                // END FORMAT CURRENT DATE TIME

                                $("#NoCommentBoxPt").addClass("hidden");
                                $("#scrollContainer").removeClass("hidden");
                                var _newBox = $('#commentBoxPt').clone();
                                _newBox.removeClass("hidden");
                                _newBox.attr('id','boxNo'+_countBox);
                                _newBox.find('#commentBoxPt_name').text(username.value);
                                _newBox.find('#commentBoxPt_time').text(formattedDate);

                                if(document.getElementById("status_view").value == '0') {
                                    _newBox.find('#commentBoxPt_status0').removeClass('hidden');
                                } else if(document.getElementById("status_view").value == '1') {
                                    _newBox.find('#commentBoxPt_status1').removeClass('hidden');
                                } else {
                                    _newBox.find('#commentBoxPt_status2').removeClass('hidden');
                                }

                                _newBox.find('#commentBoxPt_type').text('ลูกค้า');

                                _newBox.find('#commentBoxPt_content').text(comment.value);

                                if(_image64.length > 0) {
                                    _newBox.find("#commentBoxPt_image").attr('src', _image64);
                                } else {
                                    _newBox.find("#commentBoxPt_image").remove();
                                }

                                var dots = document.querySelectorAll('.bx-dots-horizontal-rounded');
                                dots.forEach(function (element, index) {
                                    var i = index;
                                    $(document).on('click', '.dots-' + i, function () {
                                        $('.group-btn-' + i).toggleClass("hidden");
                                        $('.btnLogComment').attr('data-id', data[i].id);
                                        $('.btnEditComment').attr('data-id', data[i].id)
                                                            .attr('data-comment', data[i].comment)
                                                            .attr('data-image', data[i].image);
                                        $('.btnDeleteComment').attr('data-id', data[i].id);
                                    });
                                });
                                // Modal Edit Comment
                                $('.btnEditComment').on('click', function () {
                                    $('.modal-content #comment_id_edit').val($(this).data('id'));
                                    $('.modal-content #comment_edit').val($(this).data('comment'));
                                    $('.modal-content .comment_image_edit').removeClass('hidden').find('img').attr('src', '<?php echo URL('/uploads') ?>' + '/' + $(this).data('image'));
                                    $("#modalEditComment").css("display","block");
                                });
                                $('.closeEditComment').on('click', function () {
                                    var modal = document.getElementById("modalEditComment");
                                    modal.classList.add("fade-out-modal");

                                    setTimeout(function() {
                                        modal.style.display = "none";
                                        modal.classList.remove("fade-out-modal");
                                    }, 500);
                                });
                                
                                _newBox.find('.btnLogComment').attr('data-id',data.id).attr('onClick', 'CommentLog(this)');
                                _newBox.find('.btnEditComment').attr('data-id',data.id).attr('data-comment', data.comment).attr('data-image', data.image);
                                _newBox.find('.btnDeleteComment').attr('data-id',data.id);

                                // SendMail(data.id);

                                $("#newCommentPasteHere").append(_newBox);
                                setTimeout(function() {
                                    scrollToBottom();
                                }, 500);

                                _form.find('#comment').val('');
                                _form.find('#image').val('');

                                $('#status_'+document.getElementById("id").value).text('กำลังดำเนินการ');
                                $('#status_'+document.getElementById("id").value).removeClass('text-yellow-500');
                                $('#status_'+document.getElementById("id").value).addClass('text-blue-500');
                                
                                var formContent = $('#commentForm');
                                if(document.getElementById("status_view").value == '2') {
                                    // formContent.removeClass('hidden');
                                    formContent.addClass('hidden');
                                    $('#status_'+document.getElementById("id").value).text('เสร็จสิ้น');
                                    $('#status_'+document.getElementById("id").value).removeClass('text-yellow-500');
                                    $('#status_'+document.getElementById("id").value).addClass('text-teal-500');
                                } 
                            })
                            .catch((er) => {
                                console.log('Error' + er);
                                Swal.fire({
                                    position: 'center',
                                    icon: 'error',
                                    title: 'เพิ่มความคิดเห็นไม่สำเร็จ!'
                                })
                            });
                        }
                    })
                } else {
                    var _form = _elem.parents('form');
                    var _commentContent = _form.find('#comment').val();
                    fetch("{{ Route('CommentAdd_User') }}", {
                        method: "POST",
                        headers: {
                            "Content-Type": "application/json",
                            "Accept": "application/json",
                            "X-CSRF-Token": '{{csrf_token()}}'
                        },
                        body:JSON.stringify(
                            {
                                checklist_id: document.getElementById("id").value,
                                username: document.getElementById("username").value,
                                comment: document.getElementById("comment").value,
                                image64: _image64,
                                status: document.getElementById("status_view").value
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

                        var _countBox = $('.commentBox').length;
                        _countBox++;

                        // START FORMAT CURRENT DATE TIME
                            var dateStr = new Date();
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
                                var formattedDate = '0' + day + "-" + month + "-" + year + " " + hours + ":" + (minutes < 10 ? "0" : "") + minutes + ":" + (seconds < 10 ? "0" : "") + seconds + " " + ampm;
                            } else {
                                var formattedDate = day + "-" + month + "-" + year + " " + hours + ":" + (minutes < 10 ? "0" : "") + minutes + ":" + (seconds < 10 ? "0" : "") + seconds + " " + ampm;
                            }
                        // END FORMAT CURRENT DATE TIME

                        $("#NoCommentBoxPt").addClass("hidden");
                        $("#scrollContainer").removeClass("hidden");
                        var _newBox = $('#commentBoxPt').clone();
                        _newBox.removeClass("hidden");
                        _newBox.attr('id','boxNo'+_countBox);
                        _newBox.find('#commentBoxPt_name').text(username.value);
                        _newBox.find('#commentBoxPt_time').text(formattedDate);

                        if(document.getElementById("status_view").value == '0') {
                            _newBox.find('#commentBoxPt_status0').removeClass('hidden');
                        } else if(document.getElementById("status_view").value == '1') {
                            _newBox.find('#commentBoxPt_status1').removeClass('hidden');
                        } else {
                            _newBox.find('#commentBoxPt_status2').removeClass('hidden');
                        }

                        _newBox.find('#commentBoxPt_type').text('ลูกค้า');

                        _newBox.find('#commentBoxPt_content').text(comment.value);

                        if(_image64.length > 0) {
                            _newBox.find("#commentBoxPt_image").attr('src', _image64);
                        } else {
                            _newBox.find("#commentBoxPt_image").remove();
                        }

                        _newBox.find('.btnLogComment').attr('data-id',data.id).attr('onClick', 'CommentLog(this)');
                        _newBox.find('.btnEditComment').attr('data-id',data.id).attr('data-comment', data.comment).attr('data-image', data.image);
                        _newBox.find('.btnDeleteComment').attr('data-id',data.id);

                        $("#newCommentPasteHere").append(_newBox);
                        setTimeout(function() {
                            scrollToBottom();
                        }, 500);


                        _form.find('#comment').val('');
                        _form.find('#imageView').val('');
                        _image64 = '';

                        let preview_img = 'https://icons-for-free.com/iconfiles/png/512/mountains+photo+photos+placeholder+sun+icon-1320165661388177228.png';
                        _form.find('#preview_img').attr('src', preview_img);
                    })
                    .catch((er) => {
                        console.log('Error' + er);
                        Swal.fire({
                            position: 'center',
                            icon: 'error',
                            title: 'เพิ่มความคิดเห็นไม่สำเร็จ!'
                        })
                    });
                }
               
                isProcessing = false;
            }
        }

        function CommentLog(element){
            fetch("{{ Route('CommentLog') }}", {
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
                    _newBox.find('#tableLogPt_updated_at').html(formattedDate);

                    if(data[i].type == '1') {
                        var data_type = 'พนักงาน';
                    } else {
                        var data_type = 'ลูกค้า';
                    }
                    _newBox.find("#tableLogPt_comment").html(data[i].comment_by+' ('+data_type+') - '+data[i].comment);
                    
                    if(data[i].image) {
                        _newBox.find("#tableLogPt_image").attr('src', `<?php echo URL('/uploads') ?>` + '/' + data[i].image);
                    } else {
                        _newBox.find(".imageLog").removeClass('border').addClass('flex items-center justify-center').html('-');
                        _newBox.find("#tableLogPt_image").remove();
                    }

                    if(data[i].status == '0') {
                        _newBox.find("#tableLogPt_status").html('กำลังดำเนินการ');
                    } else if(data[i].status == '1'){
                        _newBox.find("#tableLogPt_status").html('ยังไม่เสร็จสิ้น');
                    } else {
                        _newBox.find("#tableLogPt_status").html('เสร็จสิ้น');
                    }

                    if(data[i].action == '0') {
                        _newBox.find("#tableLogPt_action").html('แก้ไขความคิดเห็น');
                    } else if(data[i].action == '1') {
                        _newBox.find("#tableLogPt_action").html('ลบความคิดเห็น');
                    } else {
                        _newBox.find("#tableLogPt_action").html('สร้างครั้งแรก');
                    }

                    _newBox.find("#tableLogPt_action_by").html(data[i].action_by);

                    $("#newTrPasteHere").append(_newBox);

                    $("#tableLogPt_mobile").addClass("hidden");
                    var _newBox = $('#tableLogPt_mobile').clone();
                    _newBox.removeClass("hidden");
                    _newBox.attr('id','boxNo'+data[i].id);
                    _newBox.find('#tableLogPt_name_mobile').text('name');
                    _newBox.find('#tableLogPt_updated_at_mobile').html(formattedDate);
                    if(data[i].image) {
                        _newBox.find("#tableLogPt_image_mobile").attr('src', `<?php echo URL('/uploads') ?>` + '/' + data[i].image);
                    } else {
                        _newBox.find("#span-noImage").removeClass("hidden");
                        _newBox.find("#tableLogPt_image_mobile").remove();
                    }
                    _newBox.find("#tableLogPt_comment_mobile").html(data[i].comment);
                    var data_action = data[i].action == '0' ? 'แก้ไขความคิดเห็น' : data[i].action == '1' ? 'ลบความคิดเห็น' : 'สร้างครั้งแรก';
                    _newBox.find("#tableLogPt_action_mobile").html(data_action);
                    _newBox.find("#tableLogPt_action_by_mobile").html(data[i].action_by+' ('+data_type+')');
                    if(data[i].status == '0') {
                        _newBox.find("#tableLogPt_status1_mobile").html('กำลังดำเนินการ');
                        _newBox.find("#tableLogPt_status1_mobile").removeClass('hidden');
                    } else if(data[i].status == '1') {
                        _newBox.find("#tableLogPt_status2_mobile").html('ยังไม่เสร็จสิ้น');
                        _newBox.find("#tableLogPt_status2_mobile").removeClass('hidden');
                    } else {
                        _newBox.find("#tableLogPt_status3_mobile").html('เสร็จสิ้น');
                        _newBox.find("#tableLogPt_status3_mobile").removeClass('hidden');
                    }
                    $("#newTrPasteHere_mobile").append(_newBox);
                }
                $('#preload').html('');
            })
            .catch((er) => {
                console.log('Error' + er);
            });
        }

        function CommentEdit(){
            if(document.getElementById("comment_edit").value) {
                fetch("{{ Route('CommentEdit') }}", {
                    method: "POST",
                    headers: {
                        "Content-Type": "application/json",
                        "Accept": "application/json",
                        "X-CSRF-Token": '{{csrf_token()}}'
                    },
                    body:JSON.stringify(
                        {
                            id: document.getElementById("comment_id_edit").value,
                            comment: document.getElementById("comment_edit").value,
                            action_by: `@php echo Session::get('firstname').' '.Session::get('lastname'); @endphp`,
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
                        title: 'แก้ไขความคิดเห็นสำเร็จ',
                        timer: 1000,
                        timerProgressBar: true
                    }).then((result) => {
                        var modal = document.getElementById("modalEditComment");
                        modal.classList.add("fade-out-modal");

                        setTimeout(function() {
                            modal.style.display = "none";
                            modal.classList.remove("fade-out-modal");
                        }, 500);

                        $("#newCommentPasteHere").empty();

                        var element = document.createElement('div');
                        element.setAttribute('data-id', data);
                        ChecklistComments($(element));
                    })
                })
                .catch((er) => {
                    console.log('Error' + er);
                    Swal.fire({
                        position: 'center',
                        icon: 'error',
                        title: 'แก้ไขความคิดเห็นไม่สำเร็จ!',
                        text: 'โปรดกรอกข้อมูลให้ครบถ้วน.'
                    })
                });
            }
        }

        function CommentDelete(id){
            fetch("{{ Route('CommentDelete') }}", {
                method: "POST",
                headers: {
                    "Content-Type": "application/json",
                    "Accept": "application/json",
                    "X-CSRF-Token": '{{csrf_token()}}'
                },
                body:JSON.stringify(
                    {
                        id: id,
                        action_by: `@php echo Session::get('firstname').' '.Session::get('lastname'); @endphp`
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
                    title: 'ลบความคิดเห็นสำเร็จ',
                    timer: 1000,
                    timerProgressBar: true
                }).then((result) => {
                    $("#newCommentPasteHere").empty();

                    var element = document.createElement('div');
                    element.setAttribute('data-id', data.checklist_id);
                    ChecklistComments($(element));
                })
            })
            .catch((er) => {
                console.log('Error' + er);
                Swal.fire({
                    position: 'center',
                    icon: 'error',
                    title: 'ลบความคิดเห็นไม่สำเร็จ!'
                })
            });
        }

        function SendMail(id){
            fetch("{{ Route('SendMail') }}", {
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

                console.log(data);
                if(!response.ok){
                    const error = (data && data.errorMessage) || "{{trans('general.warning.system_failed')}}" + " (CODE:"+response.status+")";
                    return Promise.reject(error);
                }
                console.log('The email has been sent.');

            })
            .catch((er) => {
                console.log('Error' + er);
            });
        }
    </script>

@endsection