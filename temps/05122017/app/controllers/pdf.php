<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Pdf extends MY_Controller
{

    function __construct()
    {
        parent::__construct();


       // $this->load->library('pdf');
        include APPPATH . 'third_party/fpdf/fpdf.php';

    }

    function index(){


        $pdf = new FPDF();
        $pdf->AddPage();
        $pdf->SetFont('Arial','B',16);
        $pdf->Cell(40,10,'Hello World!');
        $pdf->Output();
    }
}