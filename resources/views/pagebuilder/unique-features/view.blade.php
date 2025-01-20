<!-- Unique Features Section Start -->
<div class="am-unique-features {{ pagesetting('select_verient') }}">
    <div class="container">
        @if(!empty(pagesetting('pre_heading')) || !empty(pagesetting('heading')) || !empty(pagesetting('paragraph')))
            <div class="row">
                <div class="col-12">
                    <div class="am-section_title am-section_title_center">
                        @if(!empty(pagesetting('pre_heading')))
                            <span>
                                {{ pagesetting('pre_heading') }}
                            </span>
                        @endif
                        @if(!empty(pagesetting('heading')))<h2>{!! pagesetting('heading') !!}</h2>@endif
                        @if(!empty(pagesetting('paragraph')))<p>{!! pagesetting('paragraph') !!}</p>@endif
                    </div>
                </div>
            </div>
        @endif
        @if(!empty(pagesetting('section1_heading')) || !empty(pagesetting('section1_image')) || !empty(pagesetting('section1_2nd_image'))
            || !empty(pagesetting('section2_heading')) || !empty(pagesetting('section2_image')) || !empty(pagesetting('section2_2nd_image')) 
            || !empty(pagesetting('section2_3rd_image')) || !empty(pagesetting('section2_4th_image')) || !empty(pagesetting('section3_heading')) 
            || !empty(pagesetting('section3_image')) || !empty(pagesetting('section3_2nd_image')) || !empty(pagesetting('section3_3rd_image'))
            || !empty(pagesetting('section4_heading')) || !empty(pagesetting('section4_image')) || !empty(pagesetting('section4_2nd_image')))
            <div class="am-features-grid">
                @if(!empty(pagesetting('section1_heading')) || !empty(pagesetting('section1_image')) 
                    || !empty(pagesetting('section1_2nd_image')) || !empty(pagesetting('section2_heading')) 
                    || !empty(pagesetting('section2_image')) || !empty(pagesetting('section2_2nd_image')) 
                    || !empty(pagesetting('section2_3rd_image')) || !empty(pagesetting('section2_4th_image')))
                    <div class="am-features-row">
                        @if(!empty(pagesetting('section1_heading')) || !empty(pagesetting('section1_image')) || !empty(pagesetting('section1_2nd_image')))
                            <div class="am-feature-card" data-aos="fade-up" data-aos-easing="ease" data-aos-delay="200">
                                @if(!empty(pagesetting('section1_heading')))<h3>{{ pagesetting('section1_heading') }}</h3>@endif
                                @if (!empty(pagesetting('section1_image')))
                                    @if(!empty(pagesetting('section1_image')[0]['path']))
                                        <img src="{{asset('storage/'.pagesetting('section1_image')[0]['path'])}}" class="am-feature-image" alt="featur image" />
                                    @endif
                                @endif
                                @if (!empty(pagesetting('section1_2nd_image')))
                                    @if(!empty(pagesetting('section1_2nd_image')[0]['path']))
                                        <img src="{{asset('storage/'.pagesetting('section1_2nd_image')[0]['path'])}}" class="am-feature-icon" alt="icon image" />
                                    @endif
                                @endif
                            </div>
                        @endif
                        @if(!empty(pagesetting('section2_heading')) || !empty(pagesetting('section2_image')) 
                            || !empty(pagesetting('section2_2nd_image')) || !empty(pagesetting('section2_3rd_image')) 
                            || !empty(pagesetting('section2_4th_image')))
                            <div class="am-progress-card" data-aos="fade-up" data-aos-easing="ease" data-aos-delay="600">
                                @if(!empty(pagesetting('section2_image')) || !empty(pagesetting('section2_2nd_image')) || !empty(pagesetting('section2_3rd_image')))
                                    <div class="am-images-group">
                                        @if (!empty(pagesetting('section2_image')))
                                            @if(!empty(pagesetting('section2_image')[0]['path']))
                                                <img src="{{asset('storage/'.pagesetting('section2_image')[0]['path'])}}" class="am-progress-image1" alt="image description" />
                                            @endif
                                        @endif
                                        @if (!empty(pagesetting('section2_2nd_image')))
                                            @if(!empty(pagesetting('section2_2nd_image')[0]['path']))
                                                <img src="{{asset('storage/'.pagesetting('section2_2nd_image')[0]['path'])}}" class="am-progress-image2" alt="image description" />
                                            @endif
                                        @endif
                                        @if (!empty(pagesetting('section2_3rd_image')))
                                            @if(!empty(pagesetting('section2_3rd_image')[0]['path']))
                                                <img src="{{asset('storage/'.pagesetting('section2_3rd_image')[0]['path'])}}" class="am-progress-image3" alt="image description" />
                                            @endif
                                        @endif
                                    </div>
                                @endif
                                @if(!empty(pagesetting('section2_heading')) || !empty(pagesetting('section2_4th_image')))
                                    @if(!empty(pagesetting('section2_heading')))<h3>{{ pagesetting('section2_heading') }}</h3>@endif
                                    @if (!empty(pagesetting('section2_4th_image')))
                                        @if(!empty(pagesetting('section2_4th_image')[0]['path']))
                                            <img src="{{asset('storage/'.pagesetting('section2_4th_image')[0]['path'])}}" class="am-progress-image4" alt="image description" />
                                        @endif
                                    @endif
                                @endif
                            </div>
                        @endif
                    </div>
                @endif
                @if(!empty(pagesetting('section3_heading')) || !empty(pagesetting('section3_image')) 
                    || !empty(pagesetting('section3_2nd_image')) || !empty(pagesetting('section3_3rd_image')) 
                    || !empty(pagesetting('section4_heading')) || !empty(pagesetting('section4_image')) 
                    || !empty(pagesetting('section4_2nd_image')))
                    <div class="am-features-row">
                        @if(!empty(pagesetting('section3_heading')) || !empty(pagesetting('section3_image')) 
                            || !empty(pagesetting('section3_2nd_image')) || !empty(pagesetting('section3_3rd_image')))
                            <div class="am-tutors-card" data-aos="fade-up" data-aos-easing="ease" data-aos-delay="200">
                                @if(!empty(pagesetting('section3_heading')))<h3>{{ pagesetting('section3_heading') }}</h3>@endif
                                @if(!empty(pagesetting('section3_image')) || !empty(pagesetting('section3_2nd_image')))
                                    <div class="am-tutor-img">
                                        @if (!empty(pagesetting('section3_image')))
                                            @if(!empty(pagesetting('section3_image')[0]['path']))
                                                <img src="{{asset('storage/'.pagesetting('section3_image')[0]['path'])}}" class="am-tutor-img-three" alt="image description" />
                                            @endif
                                        @endif
                                        @if (!empty(pagesetting('section3_2nd_image')))
                                            @if(!empty(pagesetting('section3_2nd_image')[0]['path']))
                                                <img src="{{asset('storage/'.pagesetting('section3_2nd_image')[0]['path'])}}" class="am-tutor-img-four" alt="image description" />
                                            @endif
                                        @endif
                                    </div>
                                @endif
                                @if (!empty(pagesetting('section3_3rd_image')))
                                    @if(!empty(pagesetting('section3_3rd_image')[0]['path']))
                                        <img src="{{asset('storage/'.pagesetting('section3_3rd_image')[0]['path'])}}" class="am-tutor-img-five" alt="image description" />
                                    @endif
                                @endif
                            </div>
                        @endif
                        @if(!empty(pagesetting('section4_heading')) || !empty(pagesetting('section4_image')) || !empty(pagesetting('section4_2nd_image')))
                            <div class="am-personalize-card" data-aos="fade-up" data-aos-easing="ease" data-aos-delay="600">
                                @if(!empty(pagesetting('section4_heading')))<h3>{{ pagesetting('section4_heading') }}</h3>@endif
                                @if(!empty(pagesetting('section4_image')) || !empty(pagesetting('section4_2nd_image')))
                                    <div class="am-personalize-img">
                                        @if (!empty(pagesetting('section4_image')))
                                            @if(!empty(pagesetting('section4_image')[0]['path']))
                                                <img src="{{asset('storage/'.pagesetting('section4_image')[0]['path'])}}" class="am-feature-image-two" alt="featur image" />
                                            @endif
                                        @endif
                                        @if (!empty(pagesetting('section4_2nd_image')))
                                            @if(!empty(pagesetting('section4_2nd_image')[0]['path']))
                                                <img src="{{asset('storage/'.pagesetting('section4_2nd_image')[0]['path'])}}" class="am-feature-image-one" alt="featur image" />
                                            @endif
                                        @endif
                                    </div>
                                @endif
                            </div>
                        @endif
                    </div>
                @endif
            </div>
        @endif
    </div>
</div>
<!-- Unique Features Section End -->