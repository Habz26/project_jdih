<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class OnlyOfficeController extends Controller
{
    public function edit($filename)
{
    $onlyOfficeServer = 'http://172.20.0.59:8080'; // OnlyOffice IP
    $laravelHost = 'http://172.20.0.59/project_jdih'; // Laravel base path di subfolder

    $fileUrl = $laravelHost . '/storage/documents/' . $filename; // 🔁 perhatikan path storage
    $documentKey = md5($filename . time());

    return view('onlyoffice.editor', compact('onlyOfficeServer', 'fileUrl', 'filename', 'documentKey'));
}

}
