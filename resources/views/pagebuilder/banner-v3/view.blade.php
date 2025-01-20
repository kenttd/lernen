<div class="am-banner-potential am-banner-content-three">
    <div class="container">
        <div class="row">
            <div class="col-12">
                @if(!empty(pagesetting('pre_heading')) 
                    || !empty(pagesetting('heading')) 
                    || !empty(pagesetting('paragraph')) 
                    || !empty(pagesetting('all_tutor_btn_url')) 
                    || !empty(pagesetting('all_tutor_btn_txt')) 
                    || !empty(pagesetting('see_demo_btn_url')) 
                    || !empty(pagesetting('see_demo_btn_txt')) 
                    || !empty(pagesetting('left_image'))
                    || !empty(pagesetting('video'))
                    || !empty(pagesetting('wright_image'))
                    || !empty(pagesetting('allen_image')))
                    <div class="am-banner-main">
                        <div class="am-banner-content">
                            <div class="am-banner-tutor">
                                @if(!empty(pagesetting('pre_heading')))<span class="am-enhance" data-aos="fade-up" data-aos-easing="ease" data-aos-delay="200">{{ pagesetting('pre_heading') }}</span>@endif
                                @if(!empty(pagesetting('heading')))<h2 data-aos="fade-up" data-aos-easing="ease" data-aos-delay="300" >{!! pagesetting('heading') !!}</h2>@endif
                                @if(!empty(pagesetting('paragraph')))<span data-aos="fade-up" data-aos-easing="ease" data-aos-delay="400">{!! pagesetting('paragraph') !!}</span>@endif
                                @if(!empty(pagesetting('all_tutor_btn_txt')) 
                                    || !empty(pagesetting('all_tutor_btn_url'))
                                    || !empty(pagesetting('see_demo_btn_txt')) 
                                    || !empty(pagesetting('see_demo_btn_url')))
                                    <div class="am-explore-banner-button" data-aos="fade-up" data-aos-easing="ease" data-aos-delay="500">
                                        @if(!empty(pagesetting('all_tutor_btn_txt'))) 
                                            <a href="@if(!empty(pagesetting('all_tutor_btn_url'))) {{ pagesetting('all_tutor_btn_url') }} @endif" class="am-btn am-explore-btn"> 
                                                {{ pagesetting('all_tutor_btn_txt') }}
                                            </a>
                                        @endif
                                        @if(!empty(pagesetting('see_demo_btn_txt'))) 
                                            <a href="@if(!empty(pagesetting('see_demo_btn_url'))) {{ pagesetting('see_demo_btn_url') }} @endif" class="am-btn am-explore-btn am-demo-btn tu-themegallery tu-thumbnails_content"  data-autoplay="true" data-vbtype="video"><i class="am-icon-play-filled"></i> 
                                                {{ pagesetting('see_demo_btn_txt') }}
                                            </a>
                                        @endif
                                    </div>
                                @endif
                            </div>
                        </div>
                        @if(!empty(pagesetting('banner_repeater')))
                            <ul class="am-banner_companies am-banner-image" data-aos="fade-up" data-aos-easing="ease" data-aos-delay="600">
                                @foreach(pagesetting('banner_repeater') as $option)
                                    @if(!empty($option['banner_image']))
                                        @if(!empty($option['banner_image'][0]['path']))
                                            <li><figure><img src="{{asset('storage/'.$option['banner_image'][0]['path'])}}" alt="company logo"></figure></li>
                                        @endif
                                    @endif
                                @endforeach
                            </ul>
                        @endif
                        @if(!empty(pagesetting('left_image'))
                            || !empty(pagesetting('video'))
                            || !empty(pagesetting('wright_image')))
                            <div class="am-banner-slide-img" data-aos="fade-up" data-aos-easing="linear" data-aos-delay="1200">
                                <figure>
                                    @if(!empty(pagesetting('video')))
                                        <div class="am-revolutionize_video am-shimmer">
                                            @if(!empty(pagesetting('video')[0]['path']))
                                                <video class="  video-js" data-setup='{}' preload="auto" id="vision-video" width="940" height="737" controls >
                                                    <source src="{{ asset('storage/'.pagesetting('video')[0]['path']) }}#t=0.1" wire:key="auth-video-src" type="video/mp4" >
                                                </video>
                                            @endif
                                        </div>
                                    @endif
                                    @if(!empty(pagesetting('left_image')) || !empty(pagesetting('wright_image')) || !empty(pagesetting('allen_image')))
                                        <figcaption>
                                            @if(!empty(pagesetting('left_image')))<img class="am-banner-img-one" src="{{asset('storage/'.pagesetting('left_image')[0]['path'])}}" alt="image" /> @endif
                                            @if(!empty(pagesetting('wright_image')))<img class="am-banner-img-two" data-aos="fade-up" src="{{asset('storage/'.pagesetting('wright_image')[0]['path'])}}" alt="image" /> @endif
                                            @if(!empty(pagesetting('allen_image')))<img class="am-banner-img-three"  data-aos="fade-up" src="{{asset('storage/'.pagesetting('allen_image')[0]['path'])}}" alt="image" /> @endif
                                        </figcaption>
                                    @endif
                                </figure>
                            </div>
                        @endif
                    </div>
                @endif
            </div>
        </div>
    </div>
</div>

@pushOnce('styles')
<?php 
$isEdit = str_contains(request()->path(), 'pages') && str_contains(request()->path(), 'iframe');
?>
@if(!$isEdit)
    @vite(['public/css/aos.min.css'])
@endif
@vite(['public/css/venobox.min.css'])
@endpushOnce
@pushOnce('scripts')
@if(!$isEdit)
    <script src="{{ asset('js/aos.min.js') }}"></script>
    @endif
    <script src="{{ asset('js/venobox.min.js')}}"></script>
    <script section='banner-v3'>

        if (typeof AOS !== 'undefined') {
            AOS.init();
        }

        const runOnDomChange = () => {
            if (typeof initJs !== 'undefined') {
                initJs();
            }
        };

        const observer = new MutationObserver(runOnDomChange);

        const targetNode = document.querySelector('.am-banner-content-three');
        if (targetNode) {
            observer.observe(targetNode, {
                childList: true, 
                subtree: true
            });
        }
    </script>
@endpushOnce
