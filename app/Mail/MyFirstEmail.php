<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class MyFirstEmail extends Mailable
{
    use Queueable, SerializesModels;

    protected $project;
    protected $defect;
    protected $checklist;
    protected $checklist_comment;
    protected $DefectText;
    protected $send_by;

    public function __construct($project, $checklist, $defect, $checklist_comment, $DefectText, $send_by)
    {
        $this->project = $project;
        $this->defect = $defect;
        $this->checklist = $checklist;
        $this->checklist_comment = $checklist_comment;
        $this->DefectText = $DefectText;
        $this->send_by = $send_by;
    }

    public function build()
    {
        if($this->send_by == "customer") {
            $fromEmail = $this->project->email_customer;
        } else if($this->send_by == "company") {
            $fromEmail = $this->project->email_company;
        }

        return $this->view('emails.my_first_email')
                        ->with(['project' => $this->project,
                                'defect' => $this->defect,
                                'checklist' => $this->checklist,
                                'checklist_comment' => $this->checklist_comment,
                                'DefectText' => $this->DefectText])
                        ->subject('Checklist System')
                        ->from('nattapong.bsn@gmail.com', 'Sender Name');
    }
}
