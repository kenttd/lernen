<div class="am-faqs-three">
    <div class="container">
        <div class="row">
            <div class="col-12">
                @if(!empty(pagesetting('sub-heading')) 
                    || !empty(pagesetting('heading')) 
                    || !empty(pagesetting('paragraph'))
                    || !empty(pagesetting('btn_txt')) 
                    || !empty(pagesetting('faqs_data')))
                    <div class="am-faqs-three_content">
                        @if(!empty(pagesetting('sub-heading')) 
                            || !empty(pagesetting('heading')) 
                            || !empty(pagesetting('paragraph'))
                            || !empty(pagesetting('btn_txt')))
                            <div class="am-faqs-three_title">
                                <div class="am-section_title">
                                    @if(!empty(pagesetting('sub-heading')))<span>{{ pagesetting('sub-heading') }}</span>@endif
                                    @if(!empty(pagesetting('heading')))<h2>{{ pagesetting('heading') }}</h2></h2>@endif
                                    @if(!empty(pagesetting('paragraph')))<p>{{ pagesetting('paragraph') }}</p>@endif
                                    @if(!empty(pagesetting('btn_txt'))) <a href="#" class="am-btn">{{ pagesetting('btn_txt') }}</a>@endif
                                </div>
                            </div>
                        @endif
                        @if(!empty(pagesetting('faqs_data')))
                            <div class="am-faqs-three_accordions" >
                                <div class="accordion accordion-flush" id="accordionFlushExample">
                                    @foreach(pagesetting('faqs_data') as $key => $faq)
                                        <div class="accordion-item"  data-aos="fade-up" data-aos-easing="ease" data-aos-delay="400">
                                            @if(!empty($faq['question']))
                                                <h2 class="accordion-header" id="am-faqs{{ $key }}">
                                                    <button class="accordion-button collapsed {{ $loop->first ? 'show' : '' }}" type="button" data-bs-toggle="collapse" data-bs-target="#am-faq-target{{ $key }}" aria-expanded="{{ $loop->first ? 'true' : 'false' }}" aria-controls="am-faq-target{{ $key }}">
                                                        {!! $faq['question'] !!}
                                                        <i class="am-icon-minus-02 minus"></i>
                                                        <i class="am-icon-plus-02 plus"></i>
                                                    </button>
                                                </h2>
                                            @endif
                                            @if(!empty($faq['answer']))
                                                <div id="am-faq-target{{ $key }}" class="accordion-collapse collapse {{ $loop->first ? 'show' : '' }} " aria-labelledby="am-faqs{{ $key }}" data-bs-parent="#accordionFlushExample">
                                                    <div class="accordion-body">
                                                        {!! $faq['answer'] !!}
                                                    </div>
                                                </div>
                                            @endif
                                        </div>
                                    @endforeach
                                </div>
                            </div>
                        @endif
                    </div>
                @endif
            </div>
        </div>
    </div>
 </div> 