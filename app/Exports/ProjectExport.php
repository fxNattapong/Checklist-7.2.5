<?php

namespace App\Exports;

use DB;
use App\Models\Projects;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Events\AfterSheet;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Style\Color;

use Maatwebsite\Excel\Concerns\WithDrawings;
use PhpOffice\PhpSpreadsheet\Worksheet\Drawing;


class ProjectExport implements ShouldAutoSize, FromView, WithEvents
{

    protected $project_id;
    protected $index;

    function __construct($project_id, $index) {
        $this->project_id = $project_id;
        $this->index = $index;

        $project = DB::table('projects')
                        ->where('id', '=', $this->project_id)
                        ->first();

        $checklist = DB::table('checklist')
                        ->where('project_id', '=', $this->project_id)
                        ->where('defect_id', '=', $this->index)
                        ->get();

        $this->getdata = (object)[
            'project_info' => $project,
            'data' => []
        ];

        foreach ($checklist as $row) {
            $checklist_data = $row;
            $checklist_data->comments = [];
            $checklist_comment = DB::table('checklist_comment')->where('checklist_id','=',$row->id)->get();
            foreach($checklist_comment as $comment) {
                array_push($checklist_data->comments, $comment);
            }
            array_push($this->getdata->data, $checklist_data);
        }
    }

    public function view(): View {        
        // echo '<pre>';
        // print_r($this->getdata);
        // echo '</pre>';
        
        return view('Admin.Export', [
            'projects' => $this->getdata
        ]);
    }

    public function registerEvents(): array {
        return [
            AfterSheet::class => function(AfterSheet $event) {
                $alphabet       = $event->sheet->getHighestDataColumn();
                $totalRow       = $event->sheet->getHighestDataRow();
                $cellRange      = 'A1:'.$alphabet.$totalRow;

                $event->sheet->getDelegate()->getStyle($cellRange)->getFont()->setName('Calibri');
                $event->sheet->getStyle($cellRange)->applyFromArray([
                    'borders' => [
                        'allBorders' => [
                            'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN,
                            'color' => ['argb' => '000000'],
                        ],
                    ],
                ]);
                $event->sheet->getStyle($cellRange)->getAlignment()->setHorizontal('center');
                $event->sheet->getStyle($cellRange)->getAlignment()->setVertical('center');

                $event->sheet->mergeCells('A1:K1');
                $event->sheet->getStyle('A1')->getFont()->getColor()->setRGB('d70024');
                $event->sheet->mergeCells('A2:K2');
                $event->sheet->getDelegate()->getStyle('A1:A2')->getFont()->setSize(16);
                $event->sheet->getDelegate()->getStyle('A1:K3')->getFont()->setBold(true);

                $event->sheet->getStyle('E3:E'.$totalRow)->applyFromArray([
                    'borders' => [
                        'right' => [
                            'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THICK,
                        ]
                    ],
                ]);

                $event->sheet->getStyle('A3:E3')->getFill()->applyFromArray(['fillType' => 'solid','rotation' => 0, 'color' => ['rgb' => 'd70024'],]);
                $fontColor = new Color(Color::COLOR_WHITE);
                $event->sheet->getStyle('A3:E3')->getFont()->setColor($fontColor);
                $event->sheet->getStyle('F3:K4')->getFill()->applyFromArray(['fillType' => 'solid','rotation' => 0, 'color' => ['rgb' => '505050'],]);
                $fontColor = new Color(Color::COLOR_WHITE);
                $event->sheet->getStyle('F3:K4')->getFont()->setColor($fontColor);
            },
        ];
    }

    // public function drawings() {
    //     $return = [];
    //     $_rows = $this->getdata;
    //     if(!empty($_rows->data)){
    //         $cellcount = 5;
    //         foreach($_rows->data as $key => $value){
    //             $imgs = json_decode($value->image);
    //             if(!empty($imgs->urls) && sizeof($imgs->urls)){
    //                 $imgvalue = (!empty($imgs->urls[0])) ? $imgs->urls[0] : '';
    //                 if($imgvalue){
    //                     $drawing = new Drawing();
    //                     $drawing->setName('Logo');
    //                     $drawing->setDescription('This is my logo');
    //                     $drawing->setPath(public_path('/uploads').'/'.$imgvalue);
    //                     $drawing->setHeight(90);
    //                     $drawing->setHeight(90);
    //                     $drawing->setCoordinates('D'.$cellcount);
    //                     array_push($return,$drawing);                        
    //                 }
    //             }
    //             $cellcount++;
    //         }
    //     }
        
    //     return $return;
    // }
}
