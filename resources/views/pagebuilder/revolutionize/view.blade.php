<div class="am-revolutionize">
    <div class="container">
        <div class="row">
            <div class="col-12">
                <div class="am-revolutionize_wrap">
                    @if(!empty(pagesetting('video')))
                        <div class="am-revolutionize_video">
                            @if(!empty(pagesetting('video')[0]['path']))
                                <video class="video-js" data-setup='{}' preload="auto" id="vision-video" width="940" height="737" controls >
                                    <source src="{{ asset('storage/'.pagesetting('video')[0]['path']) }}#t=0.1" wire:key="auth-video-src" type="video/mp4" >
                                </video>
                            @endif
                        </div>
                    @endif
                    <div class="am-revolutionize_content">
                        @if(!empty(pagesetting('pre_heading')) || !empty(pagesetting('heading')) || !empty(pagesetting('paragraph')))
                            <div class="am-section_title">
                                @if(!empty(pagesetting('pre_heading')))<span>{{ pagesetting('pre_heading') }}</span>@endif
                                @if(!empty(pagesetting('heading')))<h2>{!! pagesetting('heading') !!}</h2>@endif
                                @if(!empty(pagesetting('paragraph'))){!! pagesetting('paragraph') !!}@endif
                            </div>
                        @endif
                        @if(!empty(pagesetting('revolutionize_repeater')))
                            <div class="am-revolutionize_achivments">
                                @foreach(pagesetting('revolutionize_repeater') as $option)
                                    <div class="am-revolutionize_achivments_content">
                                        @if(!empty($option['revolu_image'][0]['path']))
                                            <figure><img src="{{asset('storage/'.$option['revolu_image'][0]['path'])}}" alt="signup img"></figure>
                                        @endif
                                        @if(!empty($option['revolu_heading']))<h4>{!! $option['revolu_heading'] !!}</h4>@endif
                                        @if(!empty($option['revolu_paragraph']))<p>{!! $option['revolu_paragraph'] !!}</p>@endif
                                    </div>
                                @endforeach
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
    @if(!empty(pagesetting('bg_image')))
        @if(!empty(pagesetting('bg_image')[0]['path']))
            <img src="{{asset('storage/'.pagesetting('bg_image')[0]['path'])}}" alt="bg image">
        @endif
    @endif
</div>
@pushOnce('styles')
@vite(['public/css/videojs.css'])
@endpushOnce
@pushOnce('scripts')
    <script src="{{ asset('js/video.min.js') }}"></script>
    <script>
        document.addEventListener('DOMContentLoaded', (event) => {
                setTimeout(() => {
                    jQuery('.video-js').each((index, item) => {
                        item.onloadeddata =  function(){
                            videojs(item);
                        }
                    })
                }, 500);
            });
    </script>
@endpushOnce