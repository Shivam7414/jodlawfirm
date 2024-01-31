<footer class="footer bg-primary">
    <a aria-label="Chat on WhatsApp" href="https://wa.me/91{{ $siteSettings->get('whatsapp_number') }}" target="_blank" class="position-fixed bottom-0 end-0">
        <img src="{{ asset('img/icons/whatsapp.png') }}" alt="whatsapp_img" height="50px">
    </a>
    <div class="container-fluid p-md-5 p-3">
        <div class="row">
            <div class="col-md-8">
                <h2 class="fw-bold text-white mb-3">Sign up to our newsletter</h2>
                <p class="fw-bold text-white">Stay up to date with the latest news, announcements, and articals.</p>
            </div>
            <div class="col-md-4">
                <form action="">
                    <div class="d-flex">
                        <input type="email" class="form-control" placeholder="Enter your mail">
                        <button class="btn btn-primary ms-3 my-1 px-3">Subscribe</button>
                    </div>
                </form>
            </div>
        </div>
        <div class="row mt-5">
            <div class="col-md-5">
                <span class="fs-3 text-white fw-600">{{ config('app.name') ?? 'laravel' }}</span><br><br>
                <div class="mb-2">
                    <i class="fa-solid fa-location-dot text-white me-3"></i>
                    <span class="text-white">{{ $siteSettings->get('company_address') }}</span>
                </div>
                <div class="mb-2">
                    <i class="fa-solid fa-phone text-white me-3"></i>
                    <span class="text-white">Office: 
                        <a href="tel(+91{{ $siteSettings->get('support_phone_no') }} )" class="text-white">{{ $siteSettings->get('support_phone_no') }}</a>
                    </span>
                </div>
                <div class="mb-2">
                    <i class="fa-solid fa-envelope text-white me-3"></i>
                    <span class="text-white">Support: 
                        <a href="mail:to({{ $siteSettings->get('support_email') }})" class="text-white">{{ $siteSettings->get('support_email') }}</a>
                    </span>
                </div>
            </div>
            @if($socialLinks)
                <div class="col-md-2 col-sm-3 my-md-0 my-3">
                    <span class="fs-5 fw-600 text-white">Social</span>
                    <ul class="list-unstyled mt-3">
                        @foreach ($socialLinks as $socialLink)
                        <li class="footer-item">
                            <a href="{{ $socialLink->link }}" class="footer-link">{{ ucfirst($socialLink->name) }}</a>
                        </li>
                        @endforeach
                    </ul>
                </div>
            @endif
            @if($pageCategories)
                @foreach ($pageCategories as $categoryId => $pageCategory)
                    @if($pageCategory->pages->count() > 0)
                        <div class="col-md-2 col-sm-3 mb-md-0 mb-3">
                            <span class="fs-5 fw-600 text-white">{{ ucfirst($pageCategory->name) }}</span>
                            <ul class="list-unstyled mt-3">
                                @foreach ($pageCategory->pages as $page)
                                    <li class="footer-item">
                                        <a href="{{ url('page/'.$page->slug) }}" class="footer-link">{{ $page->name }}</a>
                                    </li>
                                @endforeach
                            </ul>
                        </div>  
                    @endif
                @endforeach
            @endif
            <hr class="mx-auto" style="border-color: #e0e0e0;">
            <div class="row justify-content-between my-3">
                <span class="col-md text-white fw-600 pe-0"><i class="fa-regular fa-copyright"></i> 2023 {{ config('app.name') ?? 'laravel' }}. All rights reserved.</span>
                <div class="col-md social text-start text-md-end mt-3 mt-md-0">
                    @if($socialLinks)
                        @foreach ($socialLinks as $socialLink)
                        <a href="{{ $socialLink->link }}" target="_blank">
                            <i class="fa-brands fa-{{ $socialLink->name }}"></i>
                        </a>
                        @endforeach
                    @endif
                </div>
            </div>
        </div>
    </div>
</footer>