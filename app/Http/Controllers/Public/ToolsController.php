<?php

namespace App\Http\Controllers\Public;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class ToolsController extends Controller
{
    public function index()
    {
        return view('public.tools.index');
    }

    // Redirects to External Professional Utilities
    public function compressPdf() { return redirect()->away('https://bigpdf.11zon.com/en/compress-pdf'); }
    public function hindiConverter() { return redirect()->away('https://updes.up.nic.in/esd/font_converter/index.html'); }
    public function imageResizer() { return redirect()->away('https://bigimage.11zon.com/en/image-resize/'); }
    public function addPageNumbers() { return redirect()->away('https://bigpdf.11zon.com/en/add-numbers-pdf/'); }
    public function wordToPdf() { return redirect()->away('https://bigpdf.11zon.com/en/word-to-pdf/'); }
    public function jpgToPdf() { return redirect()->away('https://bigpdf.11zon.com/en/images-to-pdf/combine-jpg-to-pdf.php'); }
}
