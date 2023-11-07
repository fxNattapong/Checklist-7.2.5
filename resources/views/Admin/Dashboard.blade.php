<title>Dashboard | Kingsmen CMTI</title>

@extends('Admin/LayoutAdmin')

@section('Dashboard')
    <section class="relative grow bg-[#CDD4E8] h-full"><!--E4E9F7 -->
        <!-- START HEADER -->
        <div class="my-auto flex p-4">
            <span class="font-bold text-[24px] flex pl-5">แดชบอร์ด</span>
        </div>

        <div class="flex items-center justify-center ml-5">
            <i class='bx bxs-circle text-[0.5rem]'></i>
            <hr class="bg-blue-300 border-solid border-1 border-gray-900 w-full ml-[-2px]">
        </div>
        <!-- END HEADER -->

        <div class="p-5 bg-[#CDD4E8]">
            <ul class="grid grid-cols-3 gap-[24px] max-sm:grid-cols-1">
                <li class="bg-[#F9F9F9] p-[16px] rounded-3xl flex items-center flex-wrap gap-[20px] drop-shadow-md max-md:mt-[-10px] max-md:p-[12px]">
                    <i class='bx bxs-book-content bg-[#FFF2C6] text-[#FFCE26] w-[80px] h-[80px] rounded-2xl text-4xl !flex items-center justify-center' ></i>
                    <span class="text">
                        <h3 class="text-[24px] font-bold text-gray-700">{{ number_format($projects_status->all) }}</h3>
                        <p class="text-[18px] text-gray-700">โปรเจกต์ทั้งหมด</p>
                    </span>
                </li>
                <li class="bg-[#F9F9F9] p-[16px] rounded-3xl flex items-center flex-wrap gap-[20px] drop-shadow-md max-md:mt-[-10px] max-md:p-[12px]">
                    <i class='bx bxs-analyse bg-[#CFE8FF] text-[#3C91E6] w-[80px] h-[80px] rounded-2xl text-4xl !flex items-center justify-center' ></i>
                    <span class="text">
                        <h3 class="text-[24px] font-bold text-gray-700">{{ number_format($projects_status->progress) }}</h3>
                        <p class="text-[18px] text-gray-700">กำลังดำเนินการ</p>
                    </span>
                </li>
                <li class="bg-[#F9F9F9] p-[16px] rounded-3xl flex items-center flex-wrap gap-[20px] drop-shadow-md max-md:mt-[-10px] max-md:p-[12px]">
                    <i class='bx bxs-calendar-check bg-[#C9F0C5] text-[#62CA59] w-[80px] h-[80px] rounded-2xl text-4xl !flex items-center justify-center' ></i>
                    <span class="text flex-col">
                        <h3 class="text-[24px] font-bold text-gray-700">{{ number_format($projects_status->done) }}</h3>
                        <p class="text-[18px] text-gray-700">เสร็จสิ้น</p>
                    </span>
                </li>
            </ul>

            <div class="relative overflow-x-auto rounded-3xl mt-4 drop-shadow-md">
                <table class="w-full overflow-x-auto max-md:hidden">
                    <thead class="text-gray-700 uppercase bg-gray-100">
                        <tr>
                            <th colspan="6" class="bg-gray-100 p-2 text-center text-[18px]">โปรเจกต์ทั้งหมด<p class="font-light text-gray-500 text-[14px]">(เรียงจากวันที่สิ้นสุด)</p></th>
                        </tr>
                        <tr>
                            <td colspan="6"><hr class="border-[#CDD4E8]"></td>
                        </tr>
                        <tr class="text-center text-[16px] truncate">
                            <th scope="col" class="px-6 py-3 font-medium">
                                วันที่
                            </th>
                            <th scope="col" class="px-6 py-3 font-medium">
                                ชื่อโปรเจกต์
                            </th>
                            <th scope="col" class="px-6 py-3 font-medium">
                                ผู้รับผิดชอบ
                            </th>
                            <th scope="col" class="px-6 py-3 font-medium">
                                โลโก้
                            </th>
                            <th scope="col" class="px-6 py-3 font-medium">
                                สถานะ
                            </th>
                            <th scope="col" class="px-6 py-3 font-medium">
                                ลิงก์
                            </th>
                        </tr>
                    </thead>
                    <tbody class="text-[16px] text-gray-500">
                        @if(sizeof($projects_paginate))
                            @foreach($projects_paginate as $key => $project_data)
                                <tr class="bg-white text-center font-light">
                                    <td class="hidden">
                                        {{ $project_data->id }}
                                    </td>
                                    <td scope="row" class="px-6 py-4 whitespace-nowrap">
                                        @php
                                            $start_date = date("d-m-Y", strtotime($project_data->start_date));
                                            $end_date = date("d-m-Y", strtotime($project_data->end_date));
                                            echo $start_date . " ถึง " . $end_date;
                                        @endphp
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        {{ $project_data->project_name }}
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        {{ $project_data->manager_name }}
                                    </td>
                                    <td class="px-6 py-4">
                                        <div class="flex flex-wrap items-center">
                                            <div class="relative bg-white w-[80px] h-[80px] rounded p-1 overflow-hidden border">
                                                <img src="{{ URL('/uploads/'.$project_data->image) }}" alt="" class="w-full h-full object-cover my-auto rounded" alt="logo">
                                            </div>
                                        </div>
                                    </td>
                                    <td class="px-6 py-4 truncate">
                                        <div class="w-fit font-medium w-full text-center truncate">
                                            @if($project_data->status == '1')
                                                <p class="text-blue-500">กำลังดำเนินการ</p>
                                            @elseif($project_data->status == '2')
                                                <p class="text-red-500">ขยายระยะเวลา</p>
                                            @else
                                                <p class="text-teal-500">เสร็จสิ้น</p>
                                            @endif
                                        </div>
                                    </td>
                                    <td class="px-3 py-4">
                                        <a href="{{ Route('Checklist', [$project_data->project_code]) }}" target="_blank"><i class='bx bx-window-open text-2xl hover:text-rose-600'></i></a>
                                    </td>
                                </tr>
                            @endforeach
                        @else
                            <tr class="bg-white">
                                <td scope="row" colspan="6" class="px-6 py-4 whitespace-nowrap text-center">
                                    <p class="text-center text-gray-500 font-light">ไม่พบข้อมูลโปรเจกต์</p>
                                </td>
                            </tr>
                        @endif
                    </tbody>
                </table>

                <!-- START MOBILE PROJECTS -->
                @if(sizeof($projects_paginate))
                    <div class="bg-white rounded-t-3xl hidden max-md:block">
                        <p class="text-[18px] text-gray-700 font-bold uppercase text-center bg-gray-100 py-2">โปรเจกต์ทั้งหมด</p>
                        <p class="font-light text-gray-500 text-[14px] text-center -mb-3 mt-1">(เรียงจากวันที่สิ้นสุด)</p>
                        <div class="p-4">
                            @foreach($projects_paginate as $project_data)
                                <a href="{{ Route('Checklist', [$project_data->project_code]) }}" target="_blank" class="relative grid grid-cols-6 font-medium flex items-center border border-[#CDD4E8] rounded-xl p-2 mb-2 hover:bg-gray-100 duration-300">
                                    <div class="row-span-2 w-[100%] pr-2">
                                        @if($project_data->image)
                                            <div class="flex flex-wrap items-center">
                                                <div class="relative bg-white w-[60px] h-[60px] rounded p-1 overflow-hidden border">
                                                    <img src="{{  URL('/uploads/'.$project_data->image) }}" alt="" class="w-full h-full object-cover my-auto rounded" alt="logo">
                                                </div>
                                            </div>
                                        @endif
                                    </div>
                                    <p class="col-span-5 font-medium text-[16px] text-gray-700 whitespace-nowrap overflow-hidden">ชื่อโปรเจกต์:
                                        <br><span class="pl-4 -mt-2 text-gray-700 font-light">{{ $project_data->project_name }}</span>
                                    </p>
                                    @if($project_data->status == '1')
                                        <p class="text-blue-600 text-[13px] font-light absolute ml-auto top-0 right-0 bg-blue-200 rounded-2xl px-2 mt-2 mr-2">กำลังดำเนินการ</p>
                                    @elseif($project_data->status == '2')
                                        <p class="text-red-600 text-[13px] font-light absolute ml-auto top-0 right-0 bg-red-200 rounded-2xl px-2 mt-2 mr-2">ขยายระยะเวลา</p>
                                    @else
                                        <p class="text-teal-600 text-[13px] font-light absolute ml-auto top-0 right-0 bg-green-200 rounded-2xl px-2 mt-2 mr-2">เสร็จสิ้น</p>
                                    @endif
                                    <p class="col-span-5 flex items-center overflow-hidden">
                                        <span class="truncate text-[14px] text-gray-500 font-light">
                                            <i class='bx bxs-time-five text-blue-500'></i>
                                            @php
                                                $start_date = date("d-m-Y", strtotime($project_data->start_date));
                                                $end_date = date("d-m-Y", strtotime($project_data->end_date));
                                                echo $start_date . " ถึง " . $end_date;
                                            @endphp
                                        </span>
                                    </p>
                                </a>
                            @endforeach
                        </div>
                    </div>
                @else
                    <div class="bg-white rounded-3xl drop-shadow-md mb-2 hidden max-md:block">
                        <p class="text-[18px] text-gray-700 font-bold uppercase text-center rounded-t-3xl bg-gray-100 p-2">โปรเจกต์ล่าสุด</p>
                        <hr class="mb-2">
                        <p class="text-center text-gray-500 font-light">ไม่พบข้อมูลโปรเจกต์</p>
                    </div>
                @endif
                <!-- END MOBILE PROJECTS -->

                {!! $projects_paginate->appends(['projects_page' => $projects_paginate->currentPage(), 'checklists_page' => $checklists_paginate->currentPage()])->links('Pagination.Projects') !!}
                @include('Pagination.Projects', ['projects_paginate' => $projects_paginate])
            </div>

            <div class="relative overflow-x-auto rounded-3xl mt-4 drop-shadow-md">
                <table class="w-full overflow-x-auto max-md:hidden">
                    <thead class="text-gray-700 uppercase bg-gray-100">
                        <tr>
                            <th colspan="6" class="bg-gray-100 p-2 text-center text-[18px]">เช็คลิสต์ทั้งหมด<p class="font-light text-gray-500 text-[14px]"> (เรียงจากวันที่สร้างล่าสุด)</p></th>
                        </tr>
                        <tr>
                            <td colspan="6"><hr class="border-[#CDD4E8]"></td>
                        </tr>
                        <tr class="text-center text-[16px] truncate">
                            <th scope="col" class="px-6 py-3 font-medium">
                                วันที่ เวลา
                            </th>
                            <th scope="col" class="px-6 py-3 font-medium">
                                โปรเจกต์
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
                                ลิงก์
                            </th>
                        </tr>
                    </thead>
                    <tbody class="text-[16px] text-gray-500">
                        @if(sizeof($checklists_paginate))
                            @foreach($checklists_paginate as $checklist_data)
                                <tr class="bg-white text-center">
                                    <td class="hidden" id="checklist_id">{{ $checklist_data->id }}</td>
                                    <td class="px-6 py-4 font-light whitespace-nowrap">
                                        @php
                                            $created_at = date("d-m-Y H:i:s A", strtotime($checklist_data->updated_at));
                                            echo $created_at;
                                        @endphp
                                    </td>
                                    <td scope="row" class="px-6 py-4 font-light whitespace-nowrap">
                                        @php
                                            $found_key = array_search($checklist_data->project_id, array_column($projects_data, 'id'));                                            
                                        @endphp

                                        {{ ((!empty($found_key) || ($found_key == 0)) && !empty($projects_data[$found_key])) ? $projects_data[$found_key]->project_name : '-' }}
                                    </td>
                                    <td class="px-6 py-4 font-light whitespace-nowrap">
                                        {{ $checklist_data->title }}
                                    </td>
                                    <td class="px-6 py-4">
                                        <div class="flex flex-wrap items-center">
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
                                    </td>
                                    <td class="px-6 py-4 font-medium truncate">
                                        @if($checklist_data->status == '1')
                                            <p class="text-yellow-500">รอดำเนินการ</p>
                                        @elseif($checklist_data->status == '2')
                                            <p class="text-blue-500">กำลังดำเนินการ</p>
                                        @else
                                            <p class="text-teal-500">เสร็จสิ้น</p>
                                        @endif
                                    </td>
                                    <td class="px-3 py-4">
                                        <a href="{{ Route('DashboardChecklist', [((!empty($found_key) || ($found_key == 0)) && !empty($projects_data[$found_key])) ? $projects_data[$found_key]->project_code : '-', $checklist_data->defect_id]) }}" target="_blank"><i class='bx bx-window-open text-2xl hover:text-rose-600'></i></a>
                                    </td>
                                </tr>
                            @endforeach
                        @else
                            <tr class="bg-white">
                                <td scope="row" colspan="6" class="px-6 py-4 whitespace-nowrap text-center">
                                    <p class="text-center text-gray-500 font-light">ไม่พบข้อมูลเช็คลิสต์</p>
                                </td>
                            </tr>
                        @endif
                    </tbody>
                </table>

                <!-- START MOBILE CHECKLISTS -->
                @if(sizeof($checklists_paginate))
                    <div class="bg-white rounded-t-3xl hidden max-md:block">
                        <p class="text-[18px] text-gray-700 font-bold uppercase text-center bg-gray-100 py-2">เช็คลิสต์ทั้งหมด</p>
                        <p class="font-light text-gray-500 text-[14px] text-center -mb-3 mt-1">(เรียงจากวันที่สร้างล่าสุด)</p>
                        <div class="p-4">
                            @foreach($checklists_paginate as $checklist_data)
                                @php
                                    $found_key = array_search($checklist_data->project_id, array_column($projects_data, 'id'));                                            
                                @endphp
                                <a href="{{ Route('DashboardChecklist', [((!empty($found_key) || ($found_key == 0)) && !empty($projects_data[$found_key])) ? $projects_data[$found_key]->project_code : '-', $checklist_data->defect_id]) }}" target="_blank" class="relative grid grid-cols-6 font-medium flex items-center border border-[#CDD4E8] rounded-xl p-2 mb-2 hover:bg-gray-100 duration-300">
                                    <div class="row-span-5 w-[100%] pr-2 relative">
                                        @if($checklist_data->image)
                                            @php
                                                $images = json_decode($checklist_data->image, true);
                                            @endphp
                                            @if(count($images['urls']) > 1)
                                                <span class="z-10 font-medium text-[14px] text-blue-500 bg-white rounded border drop-shadow mr-3 mt-1 px-[3px] absolute right-0">+{{ count($images['urls'])-1 }}</span>
                                            @endif
                                            <div class="flex flex-wrap items-center">
                                                <div class="relative bg-white w-[60px] h-[60px] rounded p-1 overflow-hidden border">
                                                    <img src="{{ URL('/uploads/' . $images['urls'][0]) }}" alt="" class="w-full h-full object-cover my-auto rounded" alt="logo">
                                                </div>
                                            </div>
                                        @endif
                                    </div>
                                    <p class="col-span-5">
                                        @php
                                            $found_key = array_search($checklist_data->project_id, array_column($projects_data, 'id'));                                            
                                        @endphp

                                        <p class="col-span-5 font-medium text-[16px] text-gray-700 whitespace-nowrap overflow-hidden">ชื่อโปรเจกต์: <span class="font-light text-gray-700">{{ ((!empty($found_key) || ($found_key == 0)) && !empty($projects_data[$found_key])) ? $projects_data[$found_key]->project_name : '-' }}</span></p>
                                    </p>
                                    <p class="col-span-5 font-medium text-[16px] text-gray-700 whitespace-nowrap overflow-hidden">หัวข้อ: <span class="font-light">{{ $checklist_data->title }}</span></p>
                                    @if($checklist_data->status == '1')
                                        <p class="text-yellow-600 text-[13px] font-light absolute ml-auto top-0 right-0 bg-yellow-200 rounded-2xl px-2 mt-2 mr-2">รอดำเนินการ</p>
                                    @elseif($checklist_data->status == '2')
                                        <p class="text-blue-600 text-[13px] font-light absolute ml-auto top-0 right-0 bg-blue-200 rounded-2xl px-2 mt-2 mr-2">กำลังดำเนินการ</p>
                                    @else
                                        <p class="text-teal-600 text-[13px] font-light absolute ml-auto top-0 right-0 bg-green-200 rounded-2xl px-2 mt-2 mr-2">เสร็จสิ้น</p>
                                    @endif
                                    <p class="col-span-5 flex items-center overflow-hidden">
                                        <span class="truncate text-[14px] text-gray-500 font-light">
                                            <i class='bx bxs-time-five text-blue-500'></i>
                                            @php
                                                $created_at = date("d-m-Y H:i:s A", strtotime($checklist_data->updated_at));
                                                echo $created_at;
                                            @endphp
                                        </span>
                                    </p>
                                </a>
                            @endforeach
                        </div>
                    </div>
                @else
                    <div class="bg-white rounded-3xl drop-shadow-md mb-2 hidden max-md:block">
                        <p class="text-[18px] text-gray-700 font-bold uppercase text-center rounded-t-3xl bg-gray-100 p-2">เช็คลิสต์ล่าสุด</p>
                        <hr class="mb-2">
                        <p class="text-center text-gray-500 font-light">ไม่พบข้อมูลเช็คลิสต์</p>
                    </div>
                @endif
                <!-- END MOBILE CHECKLISTS -->
                
                {!! $checklists_paginate->appends(['projects_page' => $projects_paginate->currentPage(), 'checklists_page' => $checklists_paginate->currentPage()])->links('Pagination.Checklists') !!}
                @include('Pagination.Checklists', ['checklists_paginate' => $checklists_paginate])
            </div>
        </div>
    </section>

    <script>
    const menuBar = document.getElementById('btn-toggle-menu');
    const sideBar = document.getElementById('sidebar');
    const span = document.querySelector('nav ul li a span');

    menuBar.addEventListener('click', function() {
        sideBar.classList.toggle('w-[75px]');
        span.forEach((element) => {
            span.classList.toggle('hidden');
        });
    });
    </script>
@endsection