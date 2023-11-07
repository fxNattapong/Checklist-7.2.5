@php
    $checklist_status = \Session::get('checklist_status');
@endphp
<title>Checklist | Kingsmen CMTI</title>

@extends('User/LayoutUser')


<div class="font-kanit z-[100] modal absolute inset-0 flex items-center justify-center">
    <div class="w-fit text-center bg-white p-4 rounded-3xl shadow-[rgba(13,_38,_76,_0.19)_0px_9px_20px]">
        <div class="flex justify-center">
            <i class='bx bx-window-close text-[50px] text-rose-600'></i><br>
        </div>
        <span class="text-[20px] font-medium text-center">โครงการนี้ได้เสร็จสิ้นแล้ว</span>
    </div>
</div>

@section('Checklist')
    <section class="relative grow bg-[#CDD4E8] h-full">
        <!-- Header -->
        <div class="p-4 flex items-center my-auto mb-[-4px] max-md:hidden">
            <span class="font-bold text-[24px] flex pl-5 truncate">จัดการเช็คลิสต์</span>
            <i class='bx bx-chevrons-right text-[2rem] text-gray-700 mt-[2px]'></i>
            <span class="font-medium text-[24px] text-blue-500">{{ $projects->project_name }}</span>
            <button class="bg-green-500 font-medium px-1 py-[6px] rounded-md text-white flex items-center ml-auto mr-0 hover:bg-green-600 duration-150 btnAdd">
                <i class='bx bx-plus'></i>เพิ่มเช็คลิสต์
            </button>
        </div>

        <!-- START HEADER MOBILE -->
        <div class="p-4 my-auto mb-[-4px] hidden max-md:block">
            <span class="font-bold text-[24px] flex pl-5 truncate">จัดการเช็คลิสต์</span>
            <div class="flex items-center pl-5 grid grid-cols-1">
                <div class="flex items-center">
                    <i class='bx bx-chevrons-right text-[2rem] text-gray-700 mt-[2px]'></i>
                    <span class="font-medium text-[24px] text-blue-500">{{ $projects->project_name }}</span>
                </div>
                <button class="bg-green-500 w-fit font-medium p-1 mt-1 rounded-md text-white flex items-center hover:bg-green-600 duration-150 btnAdd">
                    <i class='bx bx-plus'></i>เพิ่มเช็คลิสต์
                </button>
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
            <div class="relative overflow-x-auto rounded-3xl drop-shadow-xl">
                <table class="w-full text-sm text-left text-gray-500 max-md:hidden">
                    <thead class="text-[16px] text-gray-700 uppercase bg-gray-100">
                        <tr class="text-center">
                            <th scope="col" class="px-6 py-3 font-medium">
                                วันที่ เวลา
                            </th>
                            <th scope="col" class="px-6 py-3 font-medium">
                                หัวข้อ
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
                        </tr>
                    </thead>
                    <tbody>
                        @if(sizeof($checklists_paginate))
                            @foreach($checklists_paginate as $checklist_data)
                            <tr class="bg-white text-[16px] text-center font-light">
                                <td class="hidden" id="checklist_id">{{ $checklist_data->id }}</td>
                                <td scope="row" class="px-6 py-4 truncate">
                                    @php
                                        $created_at = date("d-m-Y H:i:s A", strtotime($checklist_data->created_at));
                                        echo $created_at;
                                    @endphp
                                </td>
                                <td scope="row" class="px-6 py-4">
                                    {{ $checklist_data->title }}
                                </td>
                                <td class="px-6 py-4">
                                    <img src="{{ URL('/uploads/'.$checklist_data->image) }}" alt="" class="w-[75px] h-auto object-scale-down mx-auto rounded-md border">
                                </td>
                                <td class="px-6 py-4 truncate">
                                    @if($checklist_data->status == '1')
                                        <p class="text-yellow-500 font-medium">รอดำเนินการ</p>
                                    @elseif($checklist_data->status == '2')
                                        <p class="text-blue-500 font-medium">กำลังดำเนินการ</p>
                                    @else
                                        <p class="text-teal-500 font-medium">เสร็จสิ้น</p>
                                    @endif
                                </td>
                                <td class="px-3 py-4 truncate">
                                    <button class="bg-yellow-500 text-white p-1 px-2 rounded-md hover:bg-yellow-600 duration-150 btnView" id="btnView"
                                    data-id="{{ $checklist_data->id }}" data-title="{{ $checklist_data->title }}" data-detail="{{ $checklist_data->detail }}" 
                                    data-status="{{ $checklist_data->status }}" data-image="{{ asset('uploads/'.$checklist_data->image ) }}" onClick="ChecklistComments(this)">เรียกดู</button>
                                    <button class="bg-blue-500 text-white p-1 px-2 rounded-md hover:bg-blue-600 duration-150 btnEdit" id="btnEdit"
                                    data-id="{{ $checklist_data->id }}" data-title="{{ $checklist_data->title }}" data-detail="{{ $checklist_data->detail }}" 
                                    data-status="{{ $checklist_data->status }}" data-image="{{ asset('uploads/'.$checklist_data->image ) }}">แก้ไข</button>
                                    <button class="bg-red-500 text-white p-1 px-2 rounded-md hover:bg-red-600 duration-150 btnDelete" id="btnDelete"
                                    data-id="{{ $checklist_data->id }}" data-title="{{ $checklist_data->title }}">ลบเช็คลิสต์</button>
                                </td>
                            </tr>
                            @endforeach
                        @else
                            <tr class="bg-white border-b text-center">
                                <td class="px-6 py-4" colspan="6">
                                    <p class="text-center font-light text-gray-500">ไม่พบข้อมูลเช็คลิสต์</p>
                                </td>
                            </tr>
                        @endif
                    </tbody>
                </table>

                <!-- START MOBILE CHECKLISTS -->
                @if($checklists_paginate)
                    <div class="bg-white rounded-t-3xl hidden max-md:block">
                        <div class="p-4">
                            @foreach($checklists_paginate as $checklist_data)
                                <div class="border border-[#CDD4E8] rounded-3xl p-2 mb-2 hover:bg-gray-100 duration-300">
                                    <div class="relative font-medium flex items-center">
                                        <div class="grid grid-cols-6 flex items-center">
                                            <div class="row-span-2 w-[100%] pr-2">
                                                @if($checklist_data->image)
                                                    <img src="{{ URL('/uploads/'.$checklist_data->image) }}" alt="" class="w-[50px] h-auto object-scale-down mx-auto rounded-2xl border">
                                                @endif
                                            </div>
                                            <p class="col-span-5 font-medium text-[16px] text-gray-700 overflow-hidden truncate">หัวข้อ: {{ $checklist_data->title }}</p>
                                            <p class="col-span-5 text-gray-500 text-[14px] font-light overflow-hidden truncate">
                                                <i class='bx bxs-time-five text-blue-500'></i>
                                                @php
                                                    $created_at = date("d-m-Y H:i:s A", strtotime($checklist_data->created_at));
                                                    echo $created_at;
                                                @endphp
                                            </p>
                                        </div>
                                        @if($checklist_data->status == '1')
                                            <p class="text-yellow-600 text-[13px] font-light absolute ml-auto top-0 right-0 bg-yellow-200 rounded-2xl px-2">รอดำเนินการ</p>
                                        @elseif($checklist_data->status == '2')
                                            <p class="text-blue-600 text-[13px] font-light absolute ml-auto top-0 right-0 bg-blue-200 rounded-2xl px-2">กำลังดำเนินการ</p>
                                        @else
                                            <p class="text-teal-600 text-[13px] font-light absolute ml-auto top-0 right-0 bg-green-200 rounded-2xl px-2">เสร็จสิ้น</p>
                                        @endif
                                    </div>

                                    <div class="grid grid-cols-3 gap-1 mt-2">
                                        <button class="bg-yellow-500 text-white p-1 rounded-3xl hover:bg-yellow-600 duration-150 px-2 btnView" id="btnView"
                                        data-id="{{ $checklist_data->id }}" data-title="{{ $checklist_data->title }}" data-detail="{{ $checklist_data->detail }}" 
                                        data-status="{{ $checklist_data->status }}" data-image="{{ asset('uploads/'.$checklist_data->image ) }}" onClick="ChecklistComments(this)">เรียกดู</button>
                                        <button class="bg-blue-500 text-white p-1 rounded-3xl hover:bg-blue-600 duration-150 px-2 btnEdit" id="btnEdit"
                                        data-id="{{ $checklist_data->id }}" data-title="{{ $checklist_data->title }}" data-detail="{{ $checklist_data->detail }}" 
                                        data-status="{{ $checklist_data->status }}" data-image="{{ asset('uploads/'.$checklist_data->image ) }}">แก้ไข</button>
                                        <button class="bg-red-500 text-white p-1 rounded-3xl hover:bg-red-600 duration-150 px-2 btnDelete" id="btnDelete"
                                        data-id="{{ $checklist_data->id }}" data-title="{{ $checklist_data->title }}">ลบเช็คลิสต์</button>
                                    </div>
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
@endsection