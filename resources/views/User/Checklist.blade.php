<title>Checklist | Kingsmen CMTI</title>

@extends('User/LayoutUser')

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
            <div class="relative overflow-x-auto bg-white rounded-3xl drop-shadow-md">
                <p class="p-2 bg-gray-100 font-medium text-gray-700 text-[18px] text-center">กรุณาเลือกรายการเช็คลิสต์ Defect</p>
                <div class="px-4 py-3 truncate grid grid-cols-3 gap-2 max-lg:grid-cols-1">
                    @php
                        $project_code = \Session::get('project_code');
                    @endphp
                    @if(sizeof($defects))
                        @foreach($defects as $defect)
                            @php
                                $icon = '<i class="bx bx-check-square text-2xl text-blue-500" ></i>';
                                $DefectName = 'Defect ครั้งที่ ' . $loop->iteration;
                                $countAll = 0;
                                $countDone = 0;
                            @endphp

                            @if($defect->status == '1')
                                @php
                                    $icon = '<i class="bx bxs-check-square text-2xl text-green-500"></i>';
                                    $DefectName = 'Defect รับประกันผลงาน';
                                @endphp
                            @endif

                            @foreach($checklists as $checklist)
                                @if($checklist->defect_id == $defect->id)
                                    @php
                                        $countAll++;
                                    @endphp
                                    @if($checklist->status == '3')
                                        @php
                                            $countDone++;
                                        @endphp
                                    @endif
                                @endif

                            @endforeach
                            <a href="{{ Route('ChecklistSelectedUser', [$projects->project_code, $loop->iteration]) }}">
                                <div class="relative h-fit bg-white rounded-full hover:bg-gray-200 duration-300 border border-gray-300 max-sm:rounded-full overflow-auto">
                                    <div class="px-4 m-2 flex items-center justify-center">
                                        {!! $icon !!}
                                        <p class="font-light text-gray-500 hover:text-gray-700">{{ $DefectName }} 
                                            <span class="font-light"><i class='bx bxs-hourglass text-red-500'></i>({{ $countDone . '/' . $countAll }})</span>
                                        </p>
                                    </div>
                                </div>
                            </a>
                        @endforeach
                    @else
                        <div class="col-start-2 max-lg:col-start-1 flex justify-center items-center text-gray-500 font-light">ไม่พบข้อมูลรายการ</div>
                    @endif
                </div>
            </div>
        </div>
    </section>
@endsection