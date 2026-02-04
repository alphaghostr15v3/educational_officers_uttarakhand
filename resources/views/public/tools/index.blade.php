@extends('layouts.public')

@section('content')
<div class="py-5 bg-light min-vh-100">
    <div class="container">
        <div class="row g-4 justify-content-center">
            <!-- Compress PDF -->
            <div class="col-lg-4 col-md-6">
                <div class="card h-100 border-0 shadow-sm rounded-4 text-center p-4 py-5 tool-card">
                    <div class="mb-4 d-flex justify-content-center">
                        <img src="https://cdn-icons-png.flaticon.com/128/337/337946.png" alt="PDF Icon" style="width: 48px;">
                    </div>
                    <h4 class="fw-bold mb-3">Compress PDF</h4>
                    <p class="text-muted small mb-4">Reduce PDF file size while maintaining quality. Perfect for sharing and storage optimization.</p>
                    <div class="mt-auto">
                        <a href="{{ route('tools.compress-pdf') }}" class="btn btn-tool shadow-sm">Use Tool</a>
                    </div>
                </div>
            </div>

            <!-- Hindi Font Converter -->
            <div class="col-lg-4 col-md-6">
                <div class="card h-100 border-0 shadow-sm rounded-4 text-center p-4 py-5 tool-card">
                    <div class="mb-4 d-flex justify-content-center">
                        <img src="https://cdn-icons-png.flaticon.com/128/9561/9561686.png" alt="Font Icon" style="width: 48px;">
                    </div>
                    <h4 class="fw-bold mb-3">Hindi Font Converter</h4>
                    <p class="text-muted small mb-4">Convert Kruti Dev to Unicode Hindi fonts seamlessly. Essential for Hindi document processing.</p>
                    <div class="mt-auto">
                        <a href="{{ route('tools.hindi-converter') }}" class="btn btn-tool shadow-sm">Use Tool</a>
                    </div>
                </div>
            </div>

            <!-- Image Resizer -->
            <div class="col-lg-4 col-md-6">
                <div class="card h-100 border-0 shadow-sm rounded-4 text-center p-4 py-5 tool-card">
                    <div class="mb-4 d-flex justify-content-center">
                        <img src="https://cdn-icons-png.flaticon.com/128/1375/1375106.png" alt="Image Icon" style="width: 48px;">
                    </div>
                    <h4 class="fw-bold mb-3">Image Resizer</h4>
                    <p class="text-muted small mb-4">Resize images online with precision. Maintain aspect ratio and quality for any dimension.</p>
                    <div class="mt-auto">
                        <a href="{{ route('tools.image-resizer') }}" class="btn btn-tool shadow-sm">Use Tool</a>
                    </div>
                </div>
            </div>

            <!-- Add Page Numbers -->
            <div class="col-lg-4 col-md-6">
                <div class="card h-100 border-0 shadow-sm rounded-4 text-center p-4 py-5 tool-card">
                    <div class="mb-4 d-flex justify-content-center">
                        <img src="https://cdn-icons-png.flaticon.com/128/2991/2991108.png" alt="Page Numbers Icon" style="width: 48px;">
                    </div>
                    <h4 class="fw-bold mb-3">Add Page Numbers</h4>
                    <p class="text-muted small mb-4">Add professional page numbers to your PDF documents. Customize position and format.</p>
                    <div class="mt-auto">
                        <a href="{{ route('tools.add-page-numbers') }}" class="btn btn-tool shadow-sm">Use Tool</a>
                    </div>
                </div>
            </div>

            <!-- Word to PDF -->
            <div class="col-lg-4 col-md-6">
                <div class="card h-100 border-0 shadow-sm rounded-4 text-center p-4 py-5 tool-card">
                    <div class="mb-4 d-flex justify-content-center">
                        <img src="https://cdn-icons-png.flaticon.com/128/337/337953.png" alt="Word Icon" style="width: 48px;">
                    </div>
                    <h4 class="fw-bold mb-3">Word to PDF</h4>
                    <p class="text-muted small mb-4">Convert Word documents to PDF format instantly. Preserve formatting and layout perfectly.</p>
                    <div class="mt-auto">
                        <a href="{{ route('tools.word-to-pdf') }}" class="btn btn-tool shadow-sm">Use Tool</a>
                    </div>
                </div>
            </div>

            <!-- JPG to PDF Combiner -->
            <div class="col-lg-4 col-md-6">
                <div class="card h-100 border-0 shadow-sm rounded-4 text-center p-4 py-5 tool-card">
                    <div class="mb-4 d-flex justify-content-center">
                        <img src="https://cdn-icons-png.flaticon.com/128/337/337948.png" alt="Combine Icon" style="width: 48px;">
                    </div>
                    <h4 class="fw-bold mb-3">JPG to PDF Combiner</h4>
                    <p class="text-muted small mb-4">Combine multiple JPG images into a single PDF file. Perfect for creating photo albums.</p>
                    <div class="mt-auto">
                        <a href="{{ route('tools.jpg-to-pdf') }}" class="btn btn-tool shadow-sm">Use Tool</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
    .rounded-4 { border-radius: 12px !important; }
    .tool-card {
        background: #ffffff;
        transition: all 0.3s ease;
        border: 1px solid rgba(0,0,0,0.05) !important;
    }
    .tool-card:hover {
        transform: translateY(-8px);
        box-shadow: 0 15px 30px rgba(0,0,0,0.1) !important;
    }
    .btn-tool {
        background-color: #6366f1;
        color: white;
        padding: 8px 25px;
        font-weight: 600;
        border-radius: 8px;
        transition: all 0.2s;
    }
    .btn-tool:hover {
        background-color: #4f46e5;
        color: white;
        transform: scale(1.05);
    }
    .text-muted.small {
        font-size: 0.85rem;
        line-height: 1.6;
    }
</style>
@endsection
