<?php

namespace App\Http\Controllers;
use Redirect;
use Imagick;
use ImagickDraw;
use App\UploadPdf;
use App\pdfimage;
use Spatie\PdfToImage\Pdf;
use Illuminate\Http\Request;
use LynX39\LaraPdfMerger\PdfManage;

class MainController extends Controller
{
    public function index(){
        $UploadedData = UploadPdf::where('status',1)->with('images')->get();
        return view('welcome',compact('UploadedData'));
    }
    public function store(Request $request)
    {
        $request->validate([
            'Upload' => 'required|mimes:pdf|max:10000',
        ]);
    if($request->has('Upload')):
        $UploadPdfDB = new UploadPdf;
        $files = $this->fileuploadProjectsActivity($request->Upload);
        $UploadPdfDB->PdfName = $files;
        $UploadPdfDB->save();
        $UploadPdfId = $UploadPdfDB->id;
        $pdf = new Pdf(public_path($files));
        $numberOfPages = $pdf->getNumberOfPages();
        for ($i=1; $i <=$numberOfPages ; $i++) { 
            $ImagesFromPdf = new pdfimage;
            $ImagesFromPdf->upload_pdf_id = $UploadPdfId;
            $uid = uniqid();
            $pdf->setPage($i)->saveImage(public_path('images/convertImages/'.$uid.'.jpg'));
            $ImagesFromPdf->ImageName = 'images/convertImages/'.$uid.'.jpg';
            $ImagesFromPdf->save();
        }
    endif;
       echo 'Saved';

    }

    
}
