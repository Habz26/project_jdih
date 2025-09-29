<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class OnlyOfficeController extends Controller
{
    public function edit($filename)
    {
    $onlyOfficeServer = 'http://172.20.0.59:8080'; // ✅ IP OnlyOffice kamu
    $laravelHost = 'http://172.20.0.59:8000';     // ✅ IP Laravel kamu (jika satu server)

        $fileUrl = $hostUrl . '/storage/documents/' . $filename;
        $documentKey = md5($filename . time()); // kunci unik, bisa pakai uuid juga

        return view('onlyoffice.editor', compact('fileUrl', 'serverUrl', 'filename', 'documentKey'));
    }
}
