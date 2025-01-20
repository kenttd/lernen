<?php

use App\Livewire\Actions\Logout;
use Livewire\Volt\Component;
use Illuminate\Support\Facades\Route;
use App\Services\OrderService;
new class extends Component
{
    public $menuItems = [];
    public $activeRoute = [];
    public $totalCommission = 0;

    public function mount()
    {
        $this->totalCommission = (new OrderService())->getTotalCommission();
        $this->activeRoute = Route::currentRouteName();
        $this->menuItems = [
            [
                'title' =>  __('sidebar.insights'),
                'icon'  => 'icon-layers',
                'routes' => [
                    'admin.insights' => __('sidebar.insights'),
                ],
            ],
            [
                'title' =>  __('sidebar.site_management'),
                'icon'  => 'icon-layout',
                'links' => [
                    'manage-menu' => [
                        'link'  => '',
                        'title' => __('sidebar.menu')
                    ]
                ],
                'routes' => [
                    'admin.manage-menus' => __('sidebar.menu'),
                    'optionbuilder' => __('sidebar.settings'),
                    'pagebuilder' => __('sidebar.sitepages'),
                    'admin.email-settings' => __('sidebar.email_settings'),
                ],
            ],
            [
                'title' =>  __('sidebar.taxonomies'),
                'icon'  => 'icon-database',
                'routes' => [
                    'admin.taxonomy.languages' => __('sidebar.languages'),
                    'admin.taxonomy.subjects' => __('sidebar.subjects'),
                    'admin.taxonomy.subject-groups' => __('sidebar.subject_groups'),
                ],
            ],
            [
                'title' =>  __('sidebar.translation_settings'),
                'icon'  => 'icon-globe',
                'routes' => [
                    'ltu.translation.index' => __('sidebar.languages')
                ],
            ],
            [
                'title' =>  __('sidebar.manage_packages'),
                'icon'  => 'icon-folder-plus',
                'routes' => [
                    'admin.packages' => __('sidebar.manage_packages')
                ],
            ],
            [
                'title' =>  __('Users'),
                'icon'  => 'icon-users',
                'routes' => [
                    'admin.users' => __('admin.users')
                ],
            ],
            [
                'title' =>  __('Identity verification'),
                'icon'  => 'icon-user-check',
                'routes' => [
                    'admin.identity-verification' => __('identity-verification')
                ],
            ],
            [
                'title' =>  __('Bookings'),
                'icon'  => 'icon-file-text',
                'routes' => [
                    'admin.bookings' => __('bookings')
                ],
            ],
            [
                'title' =>  __('sidebar.transaction_payment'),
                'icon'  => 'icon-credit-card',
                'routes' => [
                    'admin.withdraw-requests' => __('sidebar.withdraw_requests'),
                    'admin.commission-settings' => __('sidebar.commission_settings'),
                    'admin.payment-methods' => __('sidebar.payment_methods'),
                ],
            ],
            [
                'title' =>  __('blogs.manage_blogs'),
                'icon'  => 'icon-bold',
                'routes' => [
                    'admin.create-blog'             => __('blogs.create_blog'),
                    'admin.blog-listing'            => __('blogs.blog_listing'),
                    'admin.blog-categories'         => __('blogs.blog_categories'),
                ],
            ],
            
        ];

        //Additional menues
        if (!empty(config('courses.admin_menu')) && is_array(config('courses.admin_menu'))) {
            $this->menuItems = array_merge($this->menuItems, config('courses.admin_menu'));
        }
    }




    /**
     * Log the current user out of the application.
     */
    public function logout(Logout $logout): void
    {
        $logout();

        $this->redirect('/login', navigate: false);
    }
}; ?>
@php
    $info       = Auth::user();
@endphp
<div class="tb-sidebarwrapperholder">
    <aside id="tb-sidebarwrapper" class="tb-sidebarwrapper">
        <div id="tb-btnmenutoggle" class="tb-btnmenutoggle">
            <a href="javascript:void(0);"><i class="ti-pin2"></i></a>
        </div>
        <div class="tb-sidebartop">
            <a class="tb-icongray" href="javascript:void(0)"><i class="icon-layout"></i></a>
            <div class="tb-dropdoenwrap">
                <div class="tb-logowrapper tb-icontoggler">
                    @if(!empty($info) )
                        <div class="tb-adminheadwrap">
                            <strong class="tb-adminhead__img" id="adminImage">
                                @if (!empty($info->profile?->image) && Storage::disk('public')->exists($info->profile?->image))
                                <img src="{{ resizedImage($info->profile?->image,34,34) }}" alt="{{ $info->profile?->image}}" />
                                @else
                                    <img src="{{ resizedImage('placeholder.png',34,34) }}" alt="{{ $info->profile?->image }}" />
                                @endif
                            </strong>
                            <div class="tb-adminuserinfo">
                                <h6>{{ $info->profile?->full_name }}</h6>
                                <span >{{ __('general.active_status') }}</span>
                            </div>
                        </div>

                    @endif
                    <a href="javascript:void(0)"><i class="icon-chevron-down"></i></a>
                    <ul class="tb-dropdownlist">
                        <li class="">
                            <a href="{{ route('admin.profile') }}">
                                <i class="icon-user"></i> {{ __('sidebar.profile') }}
                            </a>
                        </li>
                        <li>
                            <a href="{{ url('/') }}" target="_blank">
                                <i class="ti-new-window"></i> {{ __('general.view_site') }}
                            </a>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
        <nav id="tb-navdashboard" class="tb-navdashboard">
            <ul class="tb-siderbar-nav ">
                @foreach ($menuItems as $item)
                    <li @class([ 'menu-has-children' => count($item['routes']) > 1, 'active' => array_key_exists($activeRoute, $item['routes']), 'tb-openmenu' => array_key_exists($activeRoute, $item['routes']) && count($item['routes']) > 1 ])>
                        <a href="{{ count($item['routes']) > 1 ? 'javascript:void(0);' : route( array_key_first($item['routes'])) }}" class="tb-menuitm">
                            <i class="{{ $item['icon'] }}"></i><span class="tb-navdashboard__title">{{ $item['title']}}</span>
                        </a>
                        @if(count($item['routes']) > 1)
                            <ul class="sidebar-sub-menu" style="display:{{array_key_exists($activeRoute, $item['routes']) ? 'block': ''}}">
                                @foreach ( $item['routes'] as $route => $label)
                                    <li class="{{ request()->routeIs($route) ? 'active' : '' }}">
                                        <a href="{{route($route)}}">
                                            <span class="tb-navdashboard__title">{{ $label }}</span>
                                        </a>
                                    </li>
                                @endforeach
                            </ul>
                        @endif
                    </li>
                @endforeach
            </ul>
            <div class="admin-sidebar-footer">
                <div class="am-wallet">
                    <div class="am-wallet_title">
                        <span class="am-wallet_title_icon">
                            <i class="icon-dollar-sign"></i>
                        </span>
                        <div class="am-wallet_balance">
                            <strong><sup>{!! getCurrencySymbol() !!}</sup>{{ number_format($totalCommission,2)}}<span>{{ __('general.total_commission') }}</span></strong>
                        </div>
                    </div>
                </div>
                <div class="am-signout">
                    <a href="javascript:void(0)" wire:click="logout" class="tb-haslogout tb-menuitm">
                        <i class="ti-power-off"></i><span class="tb-navdashboard__title"> {{ __('sidebar.logout') }}</span>
                    </a>
                </div>
            </div>
        </nav>
    </aside>
</div>
@push('scripts')
<script>
    document.addEventListener('livewire:initialized', function() {
        document.addEventListener('update_image', (event) => {
            $('#adminImage img').attr('src', event.detail.image);
        });
     })
</script>
@endpush
