@extends('layouts.public')

@section('content')
<!-- Header Banner -->
<div class="about-header py-5 mb-5" style="background: linear-gradient(rgba(0, 43, 92, 0.8), rgba(0, 43, 92, 0.8)), url('{{ asset('images/about_association.png') }}'); background-size: cover; background-position: center; height: 350px; display: flex; align-items: center;">
    <div class="container text-center text-white">
        <h1 class="display-4 fw-bold mb-3 animate__animated animate__fadeInDown">Educational Ministerial Officers</h1>
        <h2 class="h3 fw-light animate__animated animate__fadeInUp">Association Uttarakhand</h2>
    </div>
</div>

<div class="container mb-5">
    <div class="row g-5">
        <!-- Association Overview -->
        <div class="col-lg-7">
            <div class="pe-lg-4">
                <h3 class="fw-bold mb-4 text-primary border-bottom pb-2">Association Overview</h3>
                <p class="lead mb-4 text-dark fw-bold">एजुकेशनल मिनिस्ट्रीयल ऑफिसर्स एसोसिएशन उत्तराखण्ड</p>
                <p class="mb-4 text-muted" style="font-size: 1.1rem; line-height: 1.8;">
                    एजुकेशनल मिनिस्ट्रीयल ऑफिसर्स एसोसिएशन उत्तराखण्ड राज्य के शिक्षा विभाग के मिनिस्ट्रीयल कर्मचारियों के हितों और कल्याण के लिए समर्पित एक संगठन है। इसका उद्देश्य कर्मचारियों को एक मंच प्रदान करना और आधुनिक तकनीकी सुविधाओं से जोड़ना है।
                </p>
                
                <div class="p-4 bg-light rounded-4 border-start border-5 border-warning mb-5">
                    <h4 class="fw-bold text-dark mb-3"><i class="fas fa-bullseye text-danger me-2"></i>Our Mission / हमारा मिशन</h4>
                    <p class="mb-0 text-muted">
                        मिनिस्ट्रीयल कर्मचारियों को डिजिटल सेवाओं से जोड़कर कार्यप्रणाली को पारदर्शी और कुशल बनाना। यह वेबसाइट एक केंद्रीकृत सूचना केंद्र के रूप में कार्य करती है। उत्तराखण्ड शिक्षा विभाग के मिनिस्ट्रीयल कर्मचारियों के हित और कल्याण के लिए समर्पित संगठन।
                    </p>
                </div>
            </div>
        </div>

        <!-- Association Photo & Sidebar -->
        <div class="col-lg-5">
            <div class="card border-0 shadow-lg rounded-4 overflow-hidden mb-4">
                <img src="{{ asset('images/about_association.png') }}" class="card-img-top" alt="Association Members">
                <div class="card-body bg-white text-center">
                    <p class="small text-muted italic mb-0">Members of the Educational Ministerial Officers Association, Uttarakhand</p>
                </div>
            </div>

            <!-- Core Objectives List -->
            <div class="bg-white p-4 rounded-4 shadow-sm border border-light">
                <h5 class="fw-bold mb-4 text-dark border-bottom pb-2">Core Objectives / मुख्य उद्देश्य</h5>
                <ul class="list-unstyled">
                    <li class="d-flex mb-3">
                        <i class="fas fa-check-circle text-success mt-1 me-3"></i>
                        <span>कर्मचारियों को तकनीकी और डिजिटल सुविधाएं देना</span>
                    </li>
                    <li class="d-flex mb-3">
                        <i class="fas fa-check-circle text-success mt-1 me-3"></i>
                        <span>आवेदन पत्र, आदेश, शासनादेश ऑनलाइन उपलब्ध कराना</span>
                    </li>
                    <li class="d-flex mb-3">
                        <i class="fas fa-check-circle text-success mt-1 me-3"></i>
                        <span>रिक्तियों और संपर्क विवरण पारदर्शी रूप से साझा करना</span>
                    </li>
                    <li class="d-flex mb-3">
                        <i class="fas fa-check-circle text-success mt-1 me-3"></i>
                        <span>वित्तीय और कर सलाह सेवाएं देना</span>
                    </li>
                    <li class="d-flex mb-3">
                        <i class="fas fa-check-circle text-success mt-1 me-3"></i>
                        <span>छात्रवृत्ति और स्कूल/कार्यालय जानकारी उपलब्ध कराना</span>
                    </li>
                </ul>
            </div>
        </div>
    </div>
</div>

<style>
    .about-header {
        position: relative;
        overflow: hidden;
    }
    .rounded-4 {
        border-radius: 1.5rem !important;
    }
    .text-primary {
        color: #1a5c96 !important;
    }
</style>
@endsection
