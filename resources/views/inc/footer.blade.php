@php
    use App\Model\SiteCustomization;

$S_Customize = new SiteCustomization();
     $Infodata = $S_Customize->getListAdm();
@endphp
<!-- Footer Section Start -->
<footer>
    <div class="row">
        <!-- Top Report Start -->
        <div class=" col-sm-12 ">
            <div class="footer-sec">
                <img src="/public/web_assets/images/footer/background.png" style="height: 100%; width: 100%;">
                <div class="footer-content pt-35">
                    <div class="col-sm-12">
                        <div class="col-sm-12">
                            <div class="row f-items">
                                <div class="col-md-4 col-sm-10 mb-20 pr-20">
                                    <div class="f-item">
                                        <p>{{ $Infodata->name }}
                                        </p>
                                        <br>
                                        <a href="{{ url('/contacts') }}" >@lang('lang.feedback')</a>
                                    </div>
                                </div>
                                <div class="col-md-4 col-sm-10 mb-20 pr-100">
                                    <div class="f-item">
                                        <span>@lang('lang.contacts'):</span>
                                        <p style="padding-top: 10px;">{{ $Infodata->adress }}</p>
                                        <p class=" mb-10">
                                            <a href="tel:{{ $Infodata->phone_no }}">{{ $Infodata->phone_no }}</a><br>
                                            <a href="mailto:{{ $Infodata->email }}">{{ $Infodata->email }}</a>
                                        </p>
                                    </div>
                                </div>

                                <div class="col-md-4 col-sm-10 mb-20 ">
                                    <div class="f-item">
                                        <div class="d-flex justify-content-center">
                                            <div>
                                                <span>@lang('lang.we_are_in_the_socials')</span>
                                                <p class="mt-20 social-item" style="font-size: 20px;">
                                                    <a href="{{ $Infodata->facebook_link }}" class="ml-1 mr-1"><i class="fab fa-facebook-square"></i></a>
                                                    <a href="{{ $Infodata->instagram_link }}" class="ml-1 mr-1"><i class="fab fa-instagram"></i></a>
                                                    <a href="{{ $Infodata->youtube_link }}" class="ml-1 mr-1"><i class="fab fa-youtube"></i></a>
                                                    <br>
                                                    <br>
                                                    <div>
                                                        <span style="font-size: 15px; "> @lang('lang.designed_by')</span>
                                                        <a style="font-size: 16px;" href="https://gravity.studio/">Gravity Studio</a>
                                                    </div>
                                                </p>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</footer>
<!-- Footer Section End -->
