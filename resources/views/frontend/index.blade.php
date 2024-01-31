@extends('frontend.layouts.app')

@section('content')
<link href="https://unpkg.com/aos@2.3.1/dist/aos.css" rel="stylesheet">
<style>
    .shadow {
        box-shadow: rgba(17, 17, 26, 0.1) 0px 0px 16px !important;
    }
    @media (min-width: 768px) {
        .w-md-50 {
            width: 50% !important;
        }
    }
    .intro{
        background: url("{{ asset('img/gradient/wepik-export-202401260828237TF4.jpeg') }}");
        background-size: cover;
        background-repeat: no-repeat;
        background-position: center;
    }
    .our-services {
        background: url("{{ asset('img/gradient/white.jpg') }}");
        background-size: cover;
        background-repeat: no-repeat;
        background-position: center;
    }
</style>
<div class="row intro">
    <div class="col-md-7">
        <img src="{{ asset('frontend/images/trademark.png') }}" class="mt-lg-0 mt-5 w-100" alt="trademark services">
    </div>
    <div class="col-md-5">
        <div class="p-md-5 p-2">
            <div class="card-body">
                <form action="{{ route('contact.store') }}" method="POST">
                    @csrf
                    <h3 class="mb-4 mt-4 mt-md-0">Have queries? Talk to an expert</h3>
                    <div class="mb-3">
                        <label for="name" class="form-label">Name</label>
                        <input type="text" id="name" name="name" class="form-control @error('name') is-invalid @enderror" placeholder="Enter your name" value="{{ old('name') }}" required>
                        @error('name')
                            <span class="text-danger">{{ $message }}</span>
                        @enderror
                    </div>
                    <div class="mb-3">
                        <label for="phone" class="form-label">Phone number</label>
                        <input type="text" id="phone_no" name="phone_no" class="form-control @error('phone_no') is-invalid @enderror" placeholder="Enter your phone number" value="{{ old('phone_no') }}" required>
                        @error('phone_no')
                            <span class="text-danger">{{ $message }}</span>
                        @enderror
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Select topic</label>
                        <select name="subject" class="form-control @error('subject') is-invalid @enderror" required>
                            <option value="">--Select Topic--</option>
                            <option value="Trademark Registration" {{ old('subject') == 'Trademark Registration' ? 'selected' : '' }}>Trademark Registration</option>
                            <option value="Trademark Opposition" {{ old('subject') == 'Trademark Opposition' ? 'selected' : '' }}>Trademark Opposition</option>
                            <option value="Trademark Renewal" {{ old('subject') == 'Trademark Renewal' ? 'selected' : '' }}>Trademark Renewal</option>
                            <option value="Trademark Objection" {{ old('subject') == 'Trademark Objection' ? 'selected' : '' }}>Trademark Objection</option>
                        </select>
                        @error('subject')
                            <span class="text-danger">{{ $message }}</span>
                        @enderror
                    </div>
                    <button type="submit" class="btn btn-primary btn-lg fw-700 w-100 mt-4">
                        <i class="fa-solid fa-phone"></i>&nbsp;&nbsp;Request a Callback
                    </button>
                </form>
            </div>
        </div>
    </div>
</div>
<div class="our-services" data-aos="fade-up">
    <div class="row">
        <div class="col-md-8 mx-auto my-5">
            <h2 class="text-center">Our Services</h2>
            <p class="text-center">We offer a wide range of trademark services to help you protect your brand's unique identity.</p>
        </div>
    </div>
    <div class="container">
        <div class="row g-4">
            <div class="col-md-4 mb-4" data-aos="zoom-in">
                <div class="d-flex flex-column rounded-3 bg-white shadow mx-3 p-4 h-100">
                    <h4 class="mb-3">Trademark
                        <span class="text-primary">Registration</span>
                    </h4>
                    <p class="fs-7 fw-500 text-muted justified-text mb-4 fst-italic"><i class="fa-solid fa-quote-left text-dark fs-6"></i> At Jod Law Firm, we streamline the complex process of trademark registration, ensuring your brand's unique identity is legally protected. Our expert team navigates the intricacies of registration requirements, providing comprehensive guidance from application submission to successful registration. <i class="fa-solid fa-quote-right text-dark fs-6"></i></p>
                    <div class="text-center mt-auto">
                        <a href="{{ url('trademark/index?type=registration') }}" class="btn btn-primary fw-700 px-3">Learn More</a>
                    </div>
                </div>
            </div>
            <div class="col-md-4 mb-4" data-aos="zoom-in">
                <div class="d-flex flex-column rounded-3 bg-white shadow mx-3 p-4 h-100">
                    <h4 class="mb-3">Trademark 
                        <span class="text-primary">Objection</span>
                    </h4>
                    <p class="fs-7 fw-500 text-muted justified-text mb-4 fst-italic"><i class="fa-solid fa-quote-left text-dark fs-6"></i> Facing trademark objections can be challenging, but with Jod Law Firm, you're in capable hands. We specialize in addressing objections effectively, employing strategic solutions to overcome challenges and secure approval for your trademark. Trust us to navigate the objection resolution process with precision. <i class="fa-solid fa-quote-right text-dark fs-6"></i></p>
                    <div class="text-center mt-auto">
                        <a href="{{ url('trademark/index?type=objection') }}" class="btn btn-primary fw-700 px-3">Learn More</a>
                    </div>
                </div>
            </div>
            <div class="col-md-4 mb-4" data-aos="zoom-in">
                <div class="d-flex flex-column rounded-3 bg-white shadow mx-3 p-4 h-100">
                    <h4 class="mb-3">Trademark 
                        <span class="text-primary">Opposition</span>
                    </h4>
                    <p class="fs-7 fw-500 text-muted justified-text mb-4 fst-italic"><i class="fa-solid fa-quote-left text-dark fs-6"></i> Trademark oppositions can be a major setback for your business, but with Jod Law Firm, you can rest easy. Our team of experts is well-versed in the opposition process, providing comprehensive guidance and support to help you overcome challenges and secure approval for your trademark. <i class="fa-solid fa-quote-right text-dark fs-6"></i></p>
                    <div class="text-center mt-auto">
                        <a href="{{ url('trademark/index?type=opposition') }}" class="btn btn-primary fw-700 px-3">Learn More</a>
                    </div>
                </div>
            </div>
            <div class="col-md-4 mb-5" data-aos="zoom-in">
                <div class="d-flex flex-column rounded-3 bg-white shadow mx-3 p-4 h-100">
                    <h4 class="mb-3">Trademark 
                        <span class="text-primary">Renewal</span>
                    </h4>
                    <p class="fs-7 fw-500 text-muted justified-text mb-4 fst-italic"><i class="fa-solid fa-quote-left text-dark fs-6"></i> Trademark renewals can be a hassle, but with Jod Law Firm, you can rest easy. We specialize in trademark renewals, providing comprehensive guidance and support to help you navigate the process with ease. Trust us to handle your trademark renewal, so you can focus on what matters most. <i class="fa-solid fa-quote-right text-dark fs-6"></i></p>
                    <div class="text-center mt-auto">
                        <a href="{{ url('trademark/index?type=renewal') }}" class="btn btn-primary fw-700 px-3">Learn More</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<div class="mb-5 bg-white">
    <div class="p-md-5 px-0" data-aos="fade-up">
        <div class="my-5 text-center">
            <h2>Why Choose Jod Law Firm?</h2>
            <p class="w-md-50 mx-md-auto">Partner with Jod Law Firm for trademark solutions that go beyond expectations. Your brand's success is our mission, and we're here to safeguard your intellectual property every step of the way.</p>
        </div>
        <div class="row align-items-center">
            <div class="col-md-7">
                <div class="mb-4" data-aos="fade-right">
                    <h5 class="brand-text-color">Expertise You Can Trust</h5>
                    <span>Our team brings extensive knowledge and experience to the table.</span>
                </div>
                <div class="mb-4" data-aos="fade-right">
                    <h5 class="brand-text-color">Comprehensive Trademark Services</h5>
                    <span>From registration to opposition, we cover it all.</span>
                </div>
                <div class="mb-4" data-aos="fade-right">
                    <h5 class="brand-text-color">Client-Centric Approach</h5>
                    <span>Your satisfaction is our priority.</span>
                </div>
                <div class="mb-4" data-aos="fade-right">
                    <h5 class="brand-text-color">Efficiency and Timeliness</h5>
                    <span>We deliver timely services to meet your business needs.</span>
                </div>
                <div class="mb-4" data-aos="fade-right">
                    <h5 class="brand-text-color">Transparent Communication</h5>
                    <span>Clear and open communication throughout the process.</span>
                </div>
            </div>
            <div class="col-md-5" style="overflow-y: hidden">
                <img src="{{ asset('img/illustrations/lawfirm.jpg') }}" alt="law_firm" class="img-fluid" data-aos="fade-left">
            </div>
        </div>
    </div>
</div>

@endsection

@push('scripts')
    <script src="https://unpkg.com/aos@2.3.1/dist/aos.js"></script>
    <script>
        AOS.init();
    </script>
@endpush