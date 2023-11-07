<p>{{ $projects->project_info->project_name }} |  ผู้รับผิดชอบ: {{ $projects->project_info->manager_name }}</p>
<p>รายการเช็คลิสต์ {{ Session::get('defect') }}</p>

<table border="1">
    <tr style="font-weight: bold;">
        <th rowspan="2">หัวข้อเช็คลิสต์</th>
        <th rowspan="2">รายละเอียด</th>
        <th rowspan="2">สถานะ</th>
        <th rowspan="2">รูปภาพ</th>
        <th rowspan="2">เพิ่มเติม</th>
        <th colspan="6">ความคิดเห็น</th>
    </tr>
    <tr>
        <th>วันที่</th>
        <th>เวลา</th>
        <th>รายละเอียด</th>
        <th>สถานะ</th>
        <th>โดย</th>
        <th>รูปภาพ</th>
    </tr>

    @foreach($projects->data as $project)
        @if(sizeof($project->comments))
            @php 
                $commentNumber = 1;
                $commentCount = count($project->comments);
            @endphp
            @foreach($project->comments as $comment)
                <tr>
                    @if($commentNumber === 1)
                        <td rowspan="{{ $commentCount }}">{{ $project->title }}</td>
                        <td rowspan="{{ $commentCount }}">
                            @if(is_null($project->detail)) 
                                -
                            @else
                                {{ $project->detail }}
                            @endif
                        </td>
                        <td rowspan="{{ $commentCount }}">
                            @if($project->status == '1')
                                รอดำเนินการ
                            @elseif($project->status == '2')
                                กำลังดำเนินการ
                            @else
                                เสร็จสิ้น
                            @endif
                        </td>
                        <td rowspan="{{ count($project->comments) }}">
                            @php
                                $images = json_decode($project->image, true);
                            @endphp
                            <img src="{{ config('pathImage.uploads_path') . $images['urls'][0] }}" width="100">
                        </td>
                        <td rowspan="{{ count($project->comments) }}">
                            @php
                                $images = json_decode($project->image, true);
                            @endphp
                            @foreach($images['urls'] as $image)
                                @if($loop->iteration >= 2)
                                    <a href="{{ URL('/uploads/'.$image) }}" target="blank">รูปที่ {{ $loop->iteration }} คลิกเพื่อเปิด</a>
                                    <br>
                                @endif
                            @endforeach
                        </td>
                    @endif

                    @php 
                        $cellHeight = 23;
                        if($commentCount < 5){
                            $cellHeight = (90/$commentCount);
                        }

                        $created_at_date = date("d-m-Y", strtotime($comment->updated_at));
                        $created_at_date_parts = explode('-', $created_at_date);
                        $month_names = [
                            '01' => 'มกราคม',
                            '02' => 'กุมภาพันธ์',
                            '03' => 'มีนาคม',
                            '04' => 'เมษายน',
                            '05' => 'พฤษภาคม',
                            '06' => 'มิถุนายน',
                            '07' => 'กรกฎาคม',
                            '08' => 'สิงหาคม',
                            '09' => 'กันยายน',
                            '10' => 'ตุลาคม',
                            '11' => 'พฤศจิกายน',
                            '12' => 'ธันวาคม',
                        ];
                        $month_number = $created_at_date_parts[1];
                        $month_name = $month_names[$month_number];
                        $created_at_date_with_monthName = $created_at_date_parts[0] . '-' . $month_name . '-' . $created_at_date_parts[2];
                        $created_at_time = date("H:i:s A", strtotime($comment->updated_at));
                    @endphp
                    <td height="{{$cellHeight}}">{{ $created_at_date_with_monthName }}</td>
                    <td>{{ $created_at_time }}</td>
                    <td>{{ $comment->comment }}</td>
                    <td style="color: {{ $comment->status == '0' ? '#0033ff' : ($comment->status == '1' ? '#a68602' : ($comment->status == '2' ? '#378b00' : 'red')) }}">
                        @if($comment->status == '0')
                            กำลังดำเนินการ
                        @elseif($comment->status == '1')
                            ยังไม่เสร็จสิ้น
                        @elseif($comment->status == '2')
                            เสร็จสิ้น
                        @else
                            ความคิดเห็นถูกลบ
                        @endif
                    </td>
                    <td>{{ $comment->username }}</td>
                    <td>
                        @if(empty($comment->image))
                            -
                        @else
                            <a href="{{ URL('/uploads/'.$comment->image) }}" target="blank">คลิกเพื่อเปิด</a>
                        @endif
                    </td>
                </tr>
                @php $commentNumber++; @endphp
            @endforeach
        @else
            <tr>
                <td>{{ $project->title }}</td>
                <td>
                    @if(is_null($project->detail)) 
                        -
                    @else
                        {{ $project->detail }}
                    @endif
                </td>
                <td>
                    @if($project->status == '1')
                        รอดำเนินการ
                    @elseif($project->status == '2')
                        กำลังดำเนินการ
                    @else
                        เสร็จสิ้น
                    @endif
                </td>
                <td>
                    @php
                        $images = json_decode($project->image, true);
                    @endphp
                    <img src="{{ config('pathImage.uploads_path') . $images['urls'][0] }}" width="100">
                </td>
                <td>
                    @php
                        $images = json_decode($project->image, true);
                    @endphp
                    @foreach($images['urls'] as $image)
                        @if($loop->iteration >= 2)
                            <a href="{{ URL('/uploads/'.$image) }}" target="blank">รูปที่ {{ $loop->iteration }} คลิกเพื่อเปิด</a>
                            <br>
                        @endif
                    @endforeach
                </td>
                <td colspan="6">-</td>
            </tr>
        @endif
    @endforeach
</table>
