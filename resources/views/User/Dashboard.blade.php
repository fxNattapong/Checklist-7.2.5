<title>Dashboard | Kingsmen CMTI</title>

@extends('User/LayoutUser')

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
                        <h3 class="text-[24px] font-bold text-gray-700">{{ number_format($checklists_status->all) }}</h3>
                        <p class="text-[18px] text-gray-700">เช็คลิสต์ทั้งหมด</p>
                    </span>
                </li>
                <li class="bg-[#F9F9F9] p-[16px] rounded-3xl flex items-center flex-wrap gap-[20px] drop-shadow-md max-md:mt-[-10px] max-md:p-[12px]">
                    <i class='bx bxs-analyse bg-[#CFE8FF] text-[#3C91E6] w-[80px] h-[80px] rounded-2xl text-4xl !flex items-center justify-center' ></i>
                    <span class="text">
                        <h3 class="text-[24px] font-bold">{{ number_format($checklists_status->progress) }}</h3>
                        <p class="text-[18px]">กำลังดำเนินการ</p>
                    </span>
                </li>
                <li class="bg-[#F9F9F9] p-[16px] rounded-3xl flex items-center flex-wrap gap-[20px] drop-shadow-md max-md:mt-[-10px] max-md:p-[12px]">
                    <i class='bx bxs-calendar-check bg-[#C9F0C5] text-[#62CA59] w-[80px] h-[80px] rounded-2xl text-4xl !flex items-center justify-center' ></i>
                    <span class="text flex-col">
                        <h3 class="text-[24px] font-bold">{{ number_format($checklists_status->done) }}</h3>
                        <p class="text-[18px]">เสร็จสิ้น</p>
                    </span>
                </li>
            </ul>

            <div class="relative overflow-x-auto rounded-3xl mt-4 drop-shadow-md">
                <table class="w-full overflow-auto max-md:hidden">
                    <thead class="text-gray-700 bg-gray-100">
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
                                <tr class="bg-white text-center font-light">
                                    <td class="hidden" id="checklist_id">{{ $checklist_data->id }}</td>
                                    <td class="px-3 py-4 whitespace-nowrap">
                                        @php
                                            $created_at = date("d-m-Y H:i:s A", strtotime($checklist_data->updated_at));
                                            echo $created_at;
                                        @endphp
                                    </td>
                                    <td class="px-3 py-4 whitespace-nowrap">
                                        {{ $checklist_data->title }}
                                    </td>
                                    <td class="px-3 py-4 truncate">
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
                                        @else
                                            -
                                        @endif
                                    </td>
                                    <td class="px-3 py-4 font-medium text-center truncate">
                                        @if($checklist_data->status == '1')
                                            <p class="text-yellow-500">รอดำเนินการ</p>
                                        @elseif($checklist_data->status == '2')
                                            <p class="text-blue-500">กำลังดำเนินการ</p>
                                        @else
                                            <p class="text-teal-500">เสร็จสิ้น</p>
                                        @endif
                                    </td>
                                    <td class="px-3 py-4">
                                        <a href="{{ Route('DashboardChecklistUser', [Session::get('project_code'), $checklist_data->defect_id]) }}" target="_blank"><i class='bx bx-window-open text-2xl hover:text-rose-600'></i></a>
                                    </td>
                                </tr>
                            @endforeach
                        @else
                            <tr class="bg-white">
                                <td scope="row" colspan="5" class="px-6 py-4 whitespace-nowrap text-center">
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
                                <a href="{{ Route('DashboardChecklistUser', [Session::get('project_code'), $checklist_data->defect_id]) }}" target="_blank" class="relative grid grid-cols-6 font-medium flex items-center border border-[#CDD4E8] rounded-xl p-2 mb-2 hover:bg-gray-100 duration-300">
                                    <div class="row-span-2 w-[100%] pr-2 relative">
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
                                    <p class="col-span-5 font-medium text-[16px] text-gray-700">หัวข้อ: <span class="text-gray-700 font-light">{{ $checklist_data->title }}</span></p>
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
                    <div class="bg-white p-4 rounded-3xl drop-shadow-md mb-2 hidden max-md:block">
                        <p class="text-[18px] font-bold uppercase text-center">เช็คลิสต์ล่าสุด</p>
                        <hr class="border-[#CDD4E8] mb-2 mt-2">
                        <p class="text-center text-gray-500 font-light">ไม่พบข้อมูลเช็คลิสต์</p>
                    </div>
                @endif
                <!-- END MOBILE CHECKLISTS -->

                {!! $checklists_paginate->appends(['checklists_page' => $checklists_paginate->currentPage(), 'checklistsComment_page' => $checklistsComment_paginate->currentPage()])->links('Pagination.Checklists') !!}
                @include('Pagination.Checklists', ['checklists_paginate' => $checklists_paginate])
            </div>

            <div class="relative overflow-x-auto rounded-3xl mt-4 drop-shadow-md">
                <table class="w-full overflow-auto max-md:hidden">
                    <thead class="text-gray-700 bg-gray-100">
                        <tr>
                            <th colspan="7" class="bg-gray-100 p-2 text-center text-[18px]">ความคิดเห็นทั้งหมด<p class="font-light text-gray-500 text-[14px]"> (เรียงจากวัน เวลาที่สร้างล่าสุด)</p></th>
                        </tr>
                        <tr>
                            <td colspan="7"><hr class="border-[#CDD4E8]"></td>
                        </tr>
                        <tr class="text-center text-[16px] truncate">
                            <th scope="col" class="px-6 py-3 font-medium">
                                วันที่ เวลา
                            </th>
                            <th scope="col" class="px-6 py-3 font-medium">
                                หัวข้อ
                            </th>
                            <th scope="col" class="px-6 py-3 font-medium">
                                สร้างโดย
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
                                ลิงก์
                            </th>
                        </tr>
                    </thead>
                    <tbody class="text-[16px] text-gray-500">
                        @if(sizeof($checklistsComment_paginate))
                            @foreach($checklistsComment_paginate as $checklistComment_data)
                                <tr class="bg-white text-center font-light">
                                    <td class="hidden" id="checklist_id">{{ $checklistComment_data->id }}</td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        @php
                                            $created_at = date("d-m-Y H:i:s A", strtotime($checklistComment_data->updated_at));
                                            echo $created_at;
                                        @endphp
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        {{ $checklistComment_data->title }}
                                    </td>
                                    <td scope="row" class="px-6 py-4 whitespace-nowrap">
                                        {{ $checklistComment_data->username }}
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        {{ $checklistComment_data->comment }}
                                    </td>
                                    <td class="px-6 py-4 truncate">
                                        @if($checklistComment_data->image != '')
                                            <img src="{{ URL('/uploads/'.$checklistComment_data->image) }}" alt="" class="w-[75px] h-auto object-scale-down mx-auto hover:scale-75 duration-300 cursor-pointer rounded-md border btnImage">
                                        @else
                                            -
                                        @endif
                                    </td>
                                    <td class="px-6 py-4 truncate">
                                        @if($checklistComment_data->status == '0')
                                            <p class="text-blue-500 font-medium">กำลังดำเนินการ</p>
                                        @elseif($checklistComment_data->status == '1')
                                            <p class="text-yellow-500 font-medium">ยังไม่เสร็จสิ้น</p>
                                        @else
                                            <p class="text-teal-500 font-medium">เสร็จสิ้น</p>
                                        @endif
                                    </td>
                                    <td class="px-6 py-4">
                                        <a href="{{ Route('DashboardChecklistCommentUser', [Session::get('project_code'), $checklistComment_data->checklist_id]) }}" target="_blank"><i class='bx bx-window-open text-2xl hover:text-rose-600'></i></a>
                                    </td>
                                </tr>
                            @endforeach
                        @else
                            <tr class="bg-white">
                                <td scope="row" colspan="7" class="px-6 py-4 whitespace-nowrap text-center">
                                    <p class="text-center text-gray-500 font-light">ไม่พบข้อมูลความคิดเห็น</p>
                                </td>
                            </tr>
                        @endif
                    </tbody>
                </table>

                <!-- START MOBILE CHECKLISTS -->
                @if(sizeof($checklistsComment_paginate))
                    <div class="bg-white rounded-t-3xl hidden max-md:block">
                        <p class="text-[18px] text-gray-700 font-bold uppercase text-center bg-gray-100 py-2">ความคิดเห็นล่าสุด</p>
                        <p class="font-light text-gray-500 text-[14px] text-center -mb-3 mt-1">(เรียงจากวัน เวลาที่สร้างล่าสุด)</p>
                        <div class="p-4">
                            @foreach($checklistsComment_paginate as $checklistComment_data)
                            <div class="rounded-3xl">
                                <a href="{{ Route('DashboardChecklistCommentUser', [Session::get('project_code'), $checklistComment_data->checklist_id]) }}" target="_blank">
                                    <div class="relative border border-[#CDD4E8] rounded-3xl p-2 mb-2 hover:bg-gray-100 duration-300">
                                        <div class="grid grid-cols-3 font-medium flex items-center px-2">
                                            <div class="row-span-1">
                                                <span class="text-[16px] font-medium text-gray-800 mt-[-10px] truncate overflow-hidden">หัวข้อ: <span class="text-gray-700 font-light">{{ $checklistComment_data->title }}</span></span>
                                                <p class="text-[16px] font-medium text-gray-800 mt-[-10px] absolute">จาก: <span class="text-gray-700 font-light">{{ $checklistComment_data->username }}</span></p>
                                            </div>
                                            <div class="ml-auto mr-0 flex items-center my-auto truncate max-md:col-span-2">
                                                <div class="col-span-2 inline-flex">
                                                    @if($checklistComment_data->status == '0')
                                                        <p class="inline-block bg-blue-200 rounded-full px-2 py-1 text-[13px] font-light text-blue-600 mr-2 mb-2 max-md:text-[12px]"><i class='bx bxs-alarm-exclamation' ></i> กำลังดำเนินการ</p>
                                                    @elseif($checklistComment_data->status == '1')
                                                        <p class="inline-block bg-yellow-200 rounded-full px-2 py-1 text-[13px] font-light text-yellow-600 mr-2 mb-2 max-md:text-[12px]"><i class='bx bxs-alarm-exclamation' ></i> ยังไม่เสร็จสิ้น</p>
                                                    @else
                                                        <p class="inline-block bg-green-200 rounded-full px-2 py-1 text-[13px] font-light text-green-600 mr-2 mb-2 max-md:text-[12px]"><i class='bx bxs-alarm-exclamation' ></i> เสร็จสิ้น</p>
                                                    @endif
                                                </div>
                                                <p class="inline-block bg-gray-200 rounded-full px-3 py-1 text-sm font-light text-gray-700 mb-2 max-md:text-[12px]">
                                                    @if($checklistComment_data->type == '1')
                                                        พนักงาน
                                                    @else
                                                        ลูกค้า
                                                    @endif
                                                </p>
                                            </div>
                                            <div class="px-3 mt-3 max-md:col-span-3">
                                                @if($checklistComment_data->image)
                                                    <img src="{{ URL('/uploads/'.$checklistComment_data->image) }}" alt="" class="w-[75px] h-auto cursor-pointer rounded-2xl btnImage">
                                                @endif
                                                <p class="text-[14px] text-gray-500 font-light">{{ $checklistComment_data->comment }}</p>
                                            </div>
                                        </div>
                                        <p class="inline-flex items-center mt-1 px-2">
                                            <i class='bx bxs-time-five text-blue-500'></i>
                                            <span class="truncate text-[14px] text-gray-500 font-light">
                                                @php
                                                    $created_at = date("d-m-Y H:i:s A", strtotime($checklistComment_data->updated_at));
                                                    echo $created_at;
                                                @endphp
                                            </span>
                                        </p>
                                    </div>
                                </a>

                            </div>
                            @endforeach
                        </div>
                    </div>
                @else
                    <div class="bg-white p-4 rounded-3xl drop-shadow-md mb-2 hidden max-md:block">
                        <p class="text-[18px] font-bold uppercase text-center">ความคิดเห็นล่าสุด</p>
                        <hr class="border-[#CDD4E8] mb-2 mt-2">
                        <p class="text-center text-gray-500 font-light">ไม่พบข้อมูลความคิดเห็น</p>
                    </div>
                @endif
                <!-- END MOBILE CHECKLISTS -->

                {!! $checklistsComment_paginate->appends(['checklists_page' => $checklists_paginate->currentPage(), 'checklistsComment_page' => $checklistsComment_paginate->currentPage()])->links('Pagination.ChecklistsComment') !!}
                @include('Pagination.ChecklistsComment', ['checklistsComment_paginate' => $checklistsComment_paginate])
            </div>
        </div>

        <!-- Modal Image -->
        <div id="modalImage" class="modalImage modal hidden fixed z-[101] left-0 top-0 w-[100%] h-[100%] overflow-auto">
            <!-- Modal content -->
            <div class="modal-content fixed inset-0 flex items-center justify-center md:px-[20px]">
                <div class="relative">
                    <img id="_image" src="" alt="" class="max-w-full max-h-[80vh] object-cover border-2 border-indigo-200 bg-white">
                    <span class="closeImage text-white text-[30px] font-medium absolute top-0 right-0 mr-4 hover:text-indigo-600 duration-300 cursor-pointer">&times;</span>
                </div>
            </div>
        </div>
    </section>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
    <script>
        $(document).ready(function () {
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