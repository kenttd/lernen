<section class="am-feature-tutors {{ pagesetting('select_verient') }} {{ pagesetting('style_verient') }}">
    @if(!empty(pagesetting('1st_shape_image')))
        <img class="am-shap-img" src="{{asset('storage/'.pagesetting('1st_shape_image')[0]['path'])}}" alt="bg image"> 
    @endif
    @if(!empty(pagesetting('2nd_shape_image')))
        <img class="am-shap-img-1" src="{{asset('storage/'.pagesetting('2nd_shape_image')[0]['path'])}}" alt="bg image">
    @endif
    <div class="container">
        <div class="row">
            <div class="col-12">
                @if(!empty(pagesetting('pre_heading')) || !empty(pagesetting('heading')) || !empty(pagesetting('paragraph')))
                    <div class="am-tutor-experience">
                        @if(!empty(pagesetting('pre_heading')) || !empty(pagesetting('heading')) || !empty(pagesetting('paragraph')))
                            <div class="am-section_title am-section_title_center">
                                @if(!empty(pagesetting('pre_heading'))) <span>{{ pagesetting('pre_heading') }}</span> @endif 
                                @if(!empty(pagesetting('heading'))) <h2>{!! pagesetting('heading') !!}</h2> @endif
                                @if(!empty(pagesetting('paragraph'))) <p>{{ pagesetting('paragraph') }}</p> @endif
                            </div>
                        @endif
                    </div>
                @endif
                @php
                    $sectionVerient     = !empty(pagesetting('select_verient')) ? pagesetting('select_verient') : 'am-tutors-varient-two';
                    $viewProfileBtn     = !empty(pagesetting('view_tutor_btn_text')) ? pagesetting('view_tutor_btn_text') : 'View Profile';
                    $viewProfileBtnUrl  = !empty(pagesetting('view_tutor_btn_url')) ? pagesetting('view_tutor_btn_url') : '#';
                    $selectTutor        = !empty(pagesetting('select_tutor')) ? pagesetting('select_tutor') : 8;
                @endphp
                <livewire:experienced-tutors :sectionVerient="$sectionVerient" :viewProfileBtn="$viewProfileBtn" :viewProfileBtnUrl="$viewProfileBtnUrl" :selectTutor="$selectTutor">
            </div>
        </div>
    </div>
</section>
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