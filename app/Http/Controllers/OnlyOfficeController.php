<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class OnlyOfficeController extends Controller
{
    public function edit($filename)
    {
        $serverUrl = 'http://172.20.0.59:8080'; // IP OnlyOffice server kamu
        $hostUrl = 'http://172.20.0.58:8000';   // IP Laravel host (bukan 127.0.0.1)

        $fileUrl = $hostUrl . '/storage/documents/' . $filename;
        $documentKey = md5($filename . time()); // kunci unik, bisa pakai uuid juga

        return view('onlyoffice.editor', compact('fileUrl', 'serverUrl', 'filename', 'documentKey'));
    }
}
