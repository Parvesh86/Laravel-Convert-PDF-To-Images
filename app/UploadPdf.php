<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class UploadPdf extends Model
{
    public function images()
    {
        return $this->hasMany('App\pdfimage');
    }
}
