<title>Checklist | Kingsmen CMTI</title>

@extends('Admin/LayoutAdmin')

@section('Checklist')
    <section class="relative h-[100vh] grow bg-[#CDD4E8]">
        <!-- Header -->
        <div class="p-4 flex my-auto">
            <span class="text-[24px] font-bold flex pl-5">จัดการเช็คลิสต์</span>
        </div>
        <!-- End Header -->
        
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

            <div class="relative overflow-x-auto bg-white rounded-3xl drop-shadow-md">
                <p class="p-2 bg-gray-100 font-medium text-gray-700 text-[18px] text-center">กรุณาเลือกโปรเจกต์</p>
                <div class="px-4 py-3 max-md:hidden">
                    @if(sizeof($projects_paginate))
                        @foreach($projects_paginate as $index => $project_data)
                            <div id="toggle-div-{{ $index }}" class="z-50 relative h-fit bg-white rounded-full hover:bg-gray-100 mb-2 duration-300 border border-gray-300 max-sm:rounded-full overflow-auto cursor-pointer"
                                data-id="{{ $project_data->id }}" onClick="DefectLists(this)">
                                <div class="relative px-4 m-2">
                                    <div class="absolute h-full flex items-center text-[1.5rem]">
                                        @if($project_data->status == '1')
                                            <i class='bx bxs-circle text-blue-500'></i>
                                        @elseif($project_data->status == '2')
                                            <i class='bx bxs-circle text-rose-500'></i>
                                        @else
                                            <i class='bx bxs-circle text-teal-500'></i>
                                        @endif
                                    </div>
                                    <table class="w-full text-sm text-left text-gray-500 mx-[10px] md:table-fixed">
                                        <thead class="text-gray-700 uppercase text-[16px]">
                                            <tr class="text-center truncate">
                                                <th scope="col" class="px-6 py-1 font-medium w-[250px]">
                                                    วันที่
                                                </th>
                                                <th scope="col" class="px-6 py-1 font-medium w-[200px]">
                                                    ชื่อโปรเจกต์
                                                </th>
                                                <th scope="col" class="px-6 py-1 font-medium w-[180px]">
                                                    ผู้รับผิดชอบ
                                                </th>
                                                <th scope="col" class="px-6 py-1 font-medium w-[129px]">
                                                    สถานะ
                                                </th>
                                            </tr>
                                        </thead>
                                        <tbody class="text-gray-600 text-[16px]">
                                            <tr class="text-center font-light">
                                                <td scope="row" class="px-6 py-1 truncate">
                                                    @php
                                                        $start_date = date("d-m-Y", strtotime($project_data->start_date));
                                                        $end_date = date("d-m-Y", strtotime($project_data->end_date));
                                                        echo $start_date . " ถึง " . $end_date;
                                                    @endphp
                                                <td class="px-6 py-1 truncate">
                                                    {{ $project_data->project_name }}
                                                </td>
                                                <td class="px-6 py-1 truncate">
                                                    {{ $project_data->manager_name }}
                                                </td>
                                                <td class="px-6 py-1 truncate">
                                                    @if($project_data->status == '1')
                                                        <p class="text-blue-500 font-medium">กำลังดำเนินการ</p>
                                                    @elseif($project_data->status == '2')
                                                        <p class="text-rose-500 font-medium">ขยายระยะเวลา</p>
                                                    @else
                                                        <p class="text-teal-500 font-medium">เสร็จสิ้น</p>
                                                    @endif
                                                </td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                            <div class="display-div-{{ $index }} w-[310px] mt-[-12px] mx-[95px] mb-4 px-6 py-2 border border-gray-300 rounded hidden">
                                @if(Session::get('role') == '2')
                                    <div class="w-full border border-gray-300 p-1 rounded-md hover:bg-rose-200 duration-300">
                                        <a href="{{ Route('DashboardUser', [$project_data->project_code]) }}" target="_blank"
                                            class="flex items-center justify-center whitespace-nowrap overflow-hidden font-light text-gray-500 hover:text-rose-600 duration-300">
                                            <i class='bx bx-window-open text-xl'></i>&nbsp;ลิงก์สำหรับลูกค้า
                                        </a>
                                    </div>
                                
                                    <div class="grid grid-cols-1 mt-4">
                                        <button id="btnAdd_{{ $project_data->id }}" class="flex items-center justify-center bg-blue-500 text-white p-1 px-2 rounded-md hover:bg-blue-600 duration-300 truncate"
                                                data-id="{{ $project_data->id }}" onClick="DefectCount(this)">
                                            <i class='bx bx-plus text-md'></i>เพิ่มรายการ Defect
                                        </button>
                                    </div>
                                @endif

                                <div id="DefectNone" class="text-center text-gray-500 font-light hidden">ไม่พบรายการเช็คลิสต์ Defect</div>

                                <div class="w-fit max-md:mt-1 hidden" id="DefectListPt_{{ $project_data->id }}">
                                    <div class="relative inline-flex w-full">
                                        <a href="" data-url="{{ Route('ChecklistSelected', [$project_data->project_code, 'defect']) }}" target="_blank" 
                                            id="DefectListPt_a" class="flex items-center whitespace-nowrap overflow-hidden font-light text-gray-500 max-md:text-[15px] hover:text-black duration-300">
                                            <i class='bx bx-chevrons-right text-yellow-700 text-[18px]'></i>รายการเช็คลิสต์ Defect ครั้งที่ n
                                        </a>
                                    </div>
                                    <hr class="border border-gray-400 w-[262px] max-md:w-[238px]">
                                </div>

                                <div id="newDefectListPasteHere_{{ $project_data->id }}" class="mt-4"></div>
                            </div>
                        @endforeach
                    @else
                        <div class="flex justify-center items-center text-gray-500 font-light">ไม่พบข้อมูลโปรเจกต์</div>
                    @endif
                </div>

                <!-- START MOBILE PROJECTS -->
                @if($projects_paginate)
                    <div class="bg-white rounded-t-3xl hidden max-md:block">
                        <div class="p-4">
                            @foreach($projects_paginate as $index => $project_data)
                                <div id="toggle-div-{{ $index }}-mobile" class="relative grid grid-cols-6 font-medium flex items-center border border-[#CDD4E8] rounded-2xl p-2 mb-2 bg-white hover:bg-gray-100 duration-300 cursor-pointer"
                                    data-id="{{ $project_data->id }}" onClick="DefectLists(this)">
                                    <div class="row-span-3 pr-2">
                                        @if($project_data->image)
                                            <img src="{{ URL('/uploads/'.$project_data->image) }}" alt="" class="w-[100px] h-auto object-scale-down mx-auto rounded border p-1">
                                        @endif
                                    </div>
                                    <p class="col-span-5 font-medium text-[16px] text-gray-700">ชื่อโปรเจกต์:</p>
                                    <p class="col-span-5 font-light text-[14px] text-gray-500 overflow-hidden ml-4">{{ $project_data->project_name }}</p>
                                    @if($project_data->status == '1')
                                        <p class="text-blue-600 text-[13px] font-light absolute mr-3 ml-auto top-0 right-0 bg-blue-200 rounded-2xl px-2 mt-2">กำลังดำเนินการ</p>
                                    @elseif($project_data->status == '2')
                                        <p class="text-rose-600 text-[13px] font-light absolute mr-3 ml-auto top-0 right-0 bg-rose-200 rounded-2xl px-2 mt-2">ขยายระยะเวลา</p>
                                    @else
                                        <p class="text-teal-600 text-[13px] font-light absolute mr-3 ml-auto top-0 right-0 bg-green-200 rounded-2xl px-2 mt-2">เสร็จสิ้น</p>
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
                                </div>
                                <div class="display-div-{{ $index }}-mobile mt-[-12px] mx-[15px] w-[290px] mb-4 px-6 py-2 border border-gray-300 rounded hidden">
                                    @if(Session::get('role') == '2')
                                        <div class="w-full border border-gray-300 p-1 rounded-md hover:bg-rose-200 duration-300">
                                            <a href="{{ Route('DashboardUser', [$project_data->project_code]) }}" target="_blank"
                                                class="flex items-center justify-center whitespace-nowrap overflow-hidden font-light text-gray-500 hover:text-rose-600 duration-300">
                                                <i class='bx bx-window-open text-xl'></i>&nbsp;ลิงก์สำหรับลูกค้า
                                            </a>
                                        </div>
                                        <div class="grid grid-cols-1 mt-4">
                                            <button id="btnAdd_mobile_{{ $project_data->id }}" class="flex items-center justify-center bg-blue-500 text-white p-1 px-2 rounded-md hover:bg-blue-600 duration-300 truncate"
                                                    data-id="{{ $project_data->id }}" onClick="DefectCount(this)">
                                                <i class='bx bx-plus text-md'></i>เพิ่มรายการ Defect
                                            </button>
                                        </div>
                                    @endif

                                    <div id="newDefectListPasteHere_mobile_{{ $project_data->id }}" class="mt-4"></div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                @else
                    <div class="bg-white p-4 hidden max-md:block">
                        <p class="text-center text-gray-700 font-light">ไม่พบข้อมูลโปรเจกต์</p>
                    </div>
                @endif
                <!-- END MOBILE PROJECTS -->

                {!! $projects_paginate->links('Pagination.Projects') !!}
                @include('Pagination.Projects', ['projects_paginate' => $projects_paginate])


                <!-- START Propotype Button Success -->
                <div class="grid grid-col-1 mt-4 hidden">
                    <button id="btnSuccessProject" class="flex items-center justify-center bg-green-500 text-white p-1 px-2 rounded-md hover:bg-green-600 duration-300 truncate"
                            data-id="" data-status="" onClick="ProjectSuccess(this)">
                        <i class='bx bx-check-square text-xl'></i></i>ส่งมอบโปรเจคต์
                    </button>
                </div>
                <!-- END Propotype Button Success -->

            </div>
        </div>
    </section>

    <!-- Modal Add -->
    <div id="modalAdd" class="modal hidden fixed z-[100] pt-[100px] left-0 top-0 w-[100%] h-[100%] overflow-auto max-md:px-[10px]">
        <!-- Modal content -->
        <div class="modal-content bg-white m-auto p-[20px] rounded-md drop-shadow-xl w-[400px] max-sm:w-[300px]">
            <div class="flex items-center">
                <p class="text-[20px] font-bold w-full ml-4 text-center">เพิ่มรายการ Defect</p>
                <span class="closeAdd text-gray-500 text-[30px] font-medium absolute top-0 right-0 mr-4 hover:text-indigo-600 cursor-pointer">&times;</span>
            </div>
            <hr class="mt-4">
            <div class="mt-4">
                <form action="#!" method="post" onsubmit="return false;">
                    @csrf
                    <div class="flex justify-center mb-4">
                        <input type="text" id="project_name" class="w-full border-none outline-none cursor-auto" value="รายการเช็คลิสต์ Defect ครั้งที่ 1" readonly>
                    </div>
                    <hr class="mb-1">
                    <button type="submit" onClick="defectAdd()" class="text-white font-medium rounded-lg text-md w-full sm:w-full px-5 py-1 text-center bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300">บันทึกข้อมูล</button>
                </form>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>

    @foreach($projects_paginate as $index => $project_data)
        <script>
            document.getElementById("toggle-div-{{ $index }}").addEventListener("click", function () {
                $('.display-div-{{ $index }}').toggle("hidden");
            });
            document.getElementById("toggle-div-{{ $index }}-mobile").addEventListener("click", function () {
                $('.display-div-{{ $index }}-mobile').toggle("hidden");
            });
        </script>
    @endforeach

    <script>
        function DefectLists(element) {

            var projectId = $(element).data('id');

            fetch("{{ Route('DefectLists') }}", {
                method: "POST",
                headers: {
                    "Content-Type": "application/json",
                    "Accept": "application/json",
                    "X-CSRF-Token": '{{csrf_token()}}'
                },
                body:JSON.stringify(
                    {
                        id: projectId
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

                _defectRows = data.defects;
                if(_defectRows.length >= 1){

                    $('#newDefectListPasteHere_' + projectId).empty();
                    $('#newDefectListPasteHere_mobile_' + projectId).empty();

                    $.each(_defectRows,function(inx,defInfo){

                        var _newBox = $('#DefectListPt_' + projectId).clone();
                        
                        _newBox.removeClass("hidden");
                        _newBox.attr('id','boxNo'+defInfo.id);

                        var checklistUrl = _newBox.find('#DefectListPt_a').data('url');
                        checklistUrl = checklistUrl.replace('defect', defInfo.count);
                        _newBox.find('#DefectListPt_a').attr('href', checklistUrl);
                        
                        if(defInfo.status == '0') {
                            _newBox.find('#DefectListPt_a').html('<i class="bx bx-check-square text-2xl text-blue-500" ></i> Defect ครั้งที่ '+ defInfo.count + '&nbsp;<i class="bx bxs-hourglass text-red-500"></i> (' + defInfo.checklist.done + '/' + defInfo.checklist.all + ')');
                        } else {
                            _newBox.find('#DefectListPt_a').html('<i class="bx bxs-check-square text-2xl text-green-500"></i> Defect รับประกันผลงาน' + '&nbsp;<i class="bx bxs-hourglass text-red-500"></i> (' + defInfo.checklist.done + '/' + defInfo.checklist.all + ')');
                        }

                        _newBox.find('#btnDeleteDefect').attr('data-id', defInfo.id);
                        _newBox.find('#btnDeleteDefect').attr('data-count', defInfo.count);

                        $("#newDefectListPasteHere_" + projectId).append(_newBox);
                        var _forMobile = _newBox.clone();
                        $('#newDefectListPasteHere_mobile_' + projectId).append(_forMobile);
                    });


                    <?php if(Session::get('role') == '2'){ ?>
                        if(data.proejct_status == '3') {
                            $('#btnAdd_' + projectId).parent().remove();
                            $('#btnAdd_mobile_' + projectId).parent().remove();
                            var btnSuccess = $('#btnSuccessProject').parent().clone();
                            btnSuccess.find('button').data('id', projectId);
                            btnSuccess.find('button').data('status', data.proejct_status);
                            btnSuccess.addClass('hidden');
                            $('#newDefectListPasteHere_' + projectId).append(btnSuccess);
                            var _forMobile = btnSuccess.clone();
                            _forMobile.find('button').data('id', projectId);
                            _forMobile.find('button').data('status', data.proejct_status);
                            _forMobile.addClass('hidden');
                            $("#newDefectListPasteHere_mobile_" +  projectId).append(_forMobile);
                        } else {
                            $('#newDefectListPasteHere_' + projectId).next().remove();
                            $('#newDefectListPasteHere_mobile_' + projectId).next().remove();
                            var btnSuccess = $('#btnSuccessProject').parent().clone();
                            btnSuccess.find('button').data('id', projectId);
                            btnSuccess.find('button').data('status', data.proejct_status);
                            btnSuccess.removeClass('hidden');
                            var parentDiv = $('#newDefectListPasteHere_' + projectId);
                            parentDiv.after(btnSuccess);
                            var _forMobile = btnSuccess.clone();
                            _forMobile.find('button').data('id', projectId);
                            _forMobile.find('button').data('status', data.proejct_status);
                            _forMobile.removeClass('hidden');
                            var parentDiv = $('#newDefectListPasteHere_mobile_' + projectId);
                            parentDiv.after(_forMobile);
                        }
                    <?php } ?>

                } else {
                    $('#newDefectListPasteHere_' + projectId).empty();
                    $('#newDefectListPasteHere_mobile_' + projectId).empty();
                    var _newBox = $('#DefectNone').clone();
                    _newBox.removeClass("hidden");
                    _newBox.attr('id', 'DefectNone_' + projectId);
                    var _newBox_mobile = _newBox.clone();
                    _newBox_mobile.attr('id', 'DefectNone_mobile_'+projectId);
                    $("#newDefectListPasteHere_" + projectId).append(_newBox);
                    $("#newDefectListPasteHere_mobile_" +  + projectId).append(_newBox_mobile);
                }

            })
            .catch((er) => {
                console.log('Error' + er);
            });
        }

        function DefectCount(element){
            fetch("{{ Route('DefectCount') }}", {
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

                Swal.fire({
                    title: 'เพิ่มรายการ Defect',
                    text: "รายการเช็คลิสต์ Defect ครั้งที่ " + (data.length + 1),
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'ใช่, เพิ่ม',
                    cancelButtonText: 'ยกเลิก'
                }).then((result) => {
                    if (result.isConfirmed) {
                        DefectAdd($(element).data('id'));
                    }
                })
            })
            .catch((er) => {
                console.log('Error' + er);
                Swal.fire({
                    position: 'center',
                    icon: 'error',
                    title: 'มีบางอย่างผิดพลาด!'
                })
            });
        }

        function DefectAdd(project_id) {
            fetch("{{ Route('DefectAdd') }}", {
                method: "POST",
                headers: {
                    "Content-Type": "application/json",
                    "Accept": "application/json",
                    "X-CSRF-Token": '{{csrf_token()}}'
                },
                body:JSON.stringify(
                    {
                        id: project_id
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
                    title: 'เพิ่มรายการสำเร็จ',
                    text: 'รายการเช็คลิสต์ Defect ครั้งที่ ' + data[0],
                    icon: 'success',
                    confirmButtonText: 'ตกลง',
                    timer: 1000,
                    timerProgressBar: true
                }).then((result) => {
                    if(data[0] >= 2) {
                        var _newBox = $('#DefectListPt_' + project_id).clone();
                        _newBox.removeClass("hidden");
                        _newBox.attr('id','boxNo'+data[0]);
    
                        var checklistUrl = _newBox.find('#DefectListPt_a').data('url');
                        checklistUrl = checklistUrl.replace('defect', data[0]);
                        _newBox.find('#DefectListPt_a').attr('href', checklistUrl);
                        _newBox.find('#DefectListPt_a').html('<i class="bx bx-check-square text-2xl text-blue-500" ></i> Defect ครั้งที่ '+ data[0] + '&nbsp;<i class="bx bxs-hourglass text-red-500"></i> (0/0)');
                        var _newBoxMobile = _newBox.clone();
    
                        $("#newDefectListPasteHere_" + project_id).append(_newBox);
                        $("#newDefectListPasteHere_mobile_" + project_id).append(_newBoxMobile);
    
                        _newBox.find('#btnDeleteDefect').attr('data-id', data[1]);
                        _newBox.find('#btnDeleteDefect').attr('data-count', data[0]);
                    } else {
                        $('#DefectNone_' + project_id).remove();
                        $('#DefectNone_mobile_' + project_id).remove();
                        var _newBox = $('#DefectListPt_' + project_id).clone();
                        _newBox.removeClass("hidden");
                        _newBox.attr('id','boxNo'+data[0]);
    
                        var checklistUrl = _newBox.find('#DefectListPt_a').data('url');
                        checklistUrl = checklistUrl.replace('defect', data[0]);
                        _newBox.find('#DefectListPt_a').attr('href', checklistUrl);
                        _newBox.find('#DefectListPt_a').html('<i class="bx bx-check-square text-2xl text-blue-500" ></i> Defect ครั้งที่ '+ data[0] + '&nbsp;<i class="bx bxs-hourglass text-red-500"></i> (0/0)');
                        var _newBoxMobile = _newBox.clone();
    
                        $("#newDefectListPasteHere_" + project_id).append(_newBox);
                        $("#newDefectListPasteHere_mobile_" + project_id).append(_newBoxMobile);
    
                        _newBox.find('#btnDeleteDefect').attr('data-id', data[1]);
                        _newBox.find('#btnDeleteDefect').attr('data-count', data[0]);
    
                        var btnSuccess = $('#btnSuccessProject').parent().clone();
                        btnSuccess.find('button').data('id', project_id);
                        btnSuccess.find('button').data('status', data.proejct_status);
                        btnSuccess.removeClass('hidden');
                        var parentDiv = $('#newDefectListPasteHere_' + project_id);
                        parentDiv.after(btnSuccess);
                        var _forMobile = btnSuccess.clone();
                        _forMobile.find('button').data('id', project_id);
                        _forMobile.find('button').data('status', data.proejct_status);
                        _forMobile.removeClass('hidden');
                        var parentDiv = $('#newDefectListPasteHere_mobile_' + project_id);
                        parentDiv.after(_forMobile);
                    }
                })
            })
            .catch((er) => {
                console.log('Error' + er);
                Swal.fire({
                    position: 'center',
                    icon: 'error',
                    title: 'เพิ่มรายการไม่สำเร็จ!'
                })
            });
        }

        async function ProjectSuccess(element) {
            Swal.fire({
                title: 'ส่งมอบโปรเจกต์',
                text: "รายการเช็คลิสต์ Defect ต้องเสร็จสิ้นทั้งหมด",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'ใช่, ส่งมอบ',
                cancelButtonText: 'ยกเลิก'
            }).then((result) => {
                if (result.isConfirmed) {
                    fetch("{{ Route('DefectLists') }}", {
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

                        _defectRows = data.defects;

                        if(_defectRows.length >= 1) {
                            var bool_value = true;

                            $.each(_defectRows,function(inx, defInfo){
                                if(defInfo.checklist.done != defInfo.checklist.all) {
                                    bool_value = false;
                                    return false;
                                } else if(defInfo.checklist.all == '0') {
                                    bool_value = false;
                                    return false;
                                }
                            });

                            if(bool_value == true) {
                                const firstname = '<?php echo Session::get('firstname'); ?>';
                                const lastname = '<?php echo Session::get('lastname'); ?>';
                                fetch("{{ Route('ProjectSuccess') }}", {
                                    method: "POST",
                                    headers: {
                                        "Content-Type": "application/json",
                                        "Accept": "application/json",
                                        "X-CSRF-Token": '{{csrf_token()}}'
                                    },
                                    body:JSON.stringify(
                                        {
                                            id: $(element).data('id'),
                                            reason: 'ส่งมอบโปรเจกต์',
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
                                        html: '<b class="text-rose-800">รายการเช็คลิสต์ Defect</b> ยังไม่เสร็จสิ้นทั้งหมด'
                                    })
                                });
                            } else {
                                Swal.fire({
                                    position: 'center',
                                    icon: 'error',
                                    title: 'แก้ไขข้อมูลไม่สำเร็จ!',
                                    html: '<b class="text-rose-800">รายการเช็คลิสต์ Defect</b> ยังไม่เสร็จสิ้นทั้งหมด'
                                })
                            }
                        }

                    })
                    .catch((er) => {
                        console.log('Error' + er);
                    });
                }
            })
        }
    </script>
@endsection