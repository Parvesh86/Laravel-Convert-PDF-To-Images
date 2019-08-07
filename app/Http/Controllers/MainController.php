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
        if($request->CompanyStatus==0):
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
        else:
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
            $Images=[];
            $BackUpImages = [];
            $merge;
            $UploadedData = UploadPdf::where('id',$UploadPdfId)->with('images')->first();
            $Images = $UploadedData->images; 
            // return $Images[0]->ImageName; 
            for ($i=1; $i <count($Images) ; $i++) { 
                if($i==1){
                    $uid = uniqid();
                    $this->merge($Images[$i-1]->ImageName,$Images[$i]->ImageName , public_path('images/convertImages/Single/'.$uid.'.jpg'),1);
                    $merge = 'images/convertImages/Single/'.$uid.'.jpg';
                    array_push($BackUpImages,$merge);
                }else{
                    $uid = uniqid();
                    $this->merge($merge,$Images[$i]->ImageName , public_path('images/convertImages/Single/'.$uid.'.jpg'),1);
                    $merge = 'images/convertImages/Single/'.$uid.'.jpg';
                    array_push($BackUpImages,$merge); 
                }
            }
            if (($key = array_search($merge, $BackUpImages)) !== false) {
                unset($BackUpImages[$key]);
            }
            if(count($BackUpImages)>0){
            foreach ($BackUpImages as $item) {
                unlink($item);
                }
            }
            UploadPdf::where('id',$UploadPdfId)->update(['SingleImageName' => $merge]);

        endif;        
    endif;
       return redirect()->route('welcome');

    }
    
    
}
