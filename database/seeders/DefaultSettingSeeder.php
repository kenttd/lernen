<?php

namespace Database\Seeders;

use App\Models\{Menu, MenuItem};
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Cache;
use Larabuild\Optionbuilder\Facades\Settings;

class DefaultSettingSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run($section = null, $key = null)
    {
        $this->defualtMenu();

        if ($section != 'menu') {
            $this->defaultSetting($section = null, $key = null);
        }
    }

    public function defaultSetting()
    {
        $def_setting = [
            '_api' => [
                'enable_google_places' => '0',
                'google_places_api_key' => '',
                'google_client_id' => '',
                'google_client_secret' => '',
                'zoom_account_id' => '',
                'zoom_client_id' => '',
                'zoom_client_secret' => '',
            ],
            '_email' => [
                'email_logo'          => [
                    'file_name' => 'email-logo.png',
                ],
                'sender_name'         => env('APP_NAME', 'Lernen'),
                'sender_email'        => 'abc@somedomain.com',
                'sender_signature'     => 'Happy learning! <br /> <br /> Best regards, <br /> The Lernen Team',
                'footer_text'         => '&copy; ' . date('Y') . ' The Lernen. All rights reserved.'
            ],
            '_front_page_settings' => [
                'per_page'                     => 9,                
                'blog_title'                   => 'Blog',
                'blog_pre_heading'             => 'Blogs',
                'blog_heading'                 => 'Expert Insights & Tips for Lifelong Learners',
                'blog_description'             => 'Access valuable insights, expert advice, and tips from our active tutoring community.',
                'search_button_text'           => 'Search',
                'search_placeholder'           => 'Search by keyword',
                'all_blogs_heading'            => 'All Blogs',

                'footer_heading'               => 'Join our esteemed community & start your journey with us <span>today!</span>',
                'footer3_paragraph'            => 'Join our community to either share your expertise as an tutor or enhance your skills as a student. Connect, learn, and grow with us today. ',
                'primary_button_text'          => 'Get Started Now',
                'primary_button_url'           => 'login',
                'secondary_button_text'        => 'Learn About Lernen',
                'secondary_button_url'         => 'about-us',
                'tutor_link_heading'           => 'Are you a Tutor?',
                'join_lernen_link'             => 'Join Lernen',
                'join_lernen_link_url'         => 'register',

                'footer_paragraph'              => 'Lernen is the top online tutoring platform for children, dedicated to connecting each student with their perfect tutor. With a network of over 1 million qualified tutors, we provide exceptional tutoring in every school subject.',
                'footer_contact'                => '(316) 555-0116',
                'footer_email'                  => 'hello@gmail.com',
                'footer_address'                => '4517 Washington Ave. Manchester, Kentucky 39495',
                'footer_button_text'            => 'Join us for free',
                'footer_button_url'             => 'register',
                'quick_links_heading'           => 'Our Company',
                'tutors_by_country_heading'     => 'Tutors near you',
                'app_section_heading'           => 'Get mobile apps',
                'app_section_description'       => 'Take education on the go. Get our mobile app for FREE! on your Apple and Android devices',
                'android_app_url'               => '#',
                'ios_app_url'                   => '#',
                'our_services_heading'          => 'Our services',
                'one_on_one_sessions_heading'   => 'One-on One sessions',
                'group_sessions_heading'        => 'Group sessions',
                'app_ios_link'                  => '#',
                'app_android_link'              => '#',
                'header_variation_for_pages' => [
                    [ 'page_id' => 1,  'header_variation'  => 'am-header_two'],
                    [ 'page_id' => 2,  'header_variation'  => 'am-header_three'],
                    [ 'page_id' => 3,  'header_variation'  => 'am-header_five'],
                    [ 'page_id' => 4,  'header_variation'  => 'am-header_four'],
                    [ 'page_id' => 5,  'header_variation'  => 'am-header_six'],
                ],
                'footer_variation_for_pages' => [
                    [ 'page_id' => 1,  'footer_variation'  => 'am-footer'],
                    [ 'page_id' => 2,  'footer_variation'  => 'am-footer_two'],
                    [ 'page_id' => 3,  'footer_variation'  => 'am-footer_three'],
                    [ 'page_id' => 4,  'footer_variation'  => 'am-footer_three'],
                    [ 'page_id' => 5,  'footer_variation'  => 'am-footer_three'],
                ]
            ],
            '_general' => [
                //general
                'enable_rtl'                    => '0',
                'site_name'                     => 'Lernen',
                'site_email'                    => 'hellow@yourdomain.com',
                'date_format'                   => 'F j, Y',
                'address_format'                => 'city_country',
                'currency'                      => 'USD',
                'per_page_record'               => 10,
                //upload_settings
                'allowed_file_extensions'       => 'pdf,doc,docx,xls,xlsx,ppt,pptx,csv,jpg,jpeg,gif,png,mp4,mp3,3gp,flv,ogg,wmv,avi,txt',
                'max_file_size'                 => 20, // in MB
                'allowed_image_extensions'      => 'jpg,jpeg,gif,png',
                'max_image_size'                => 5, // in MB
                'allowed_video_extensions'      => 'mp4,mov,avi,m4a,m4v',
                'max_video_size'                => 20, // in MB
                //media
                'favicon'                       => ['file_name' => 'favicon.png'],
                'logo_default'                  => ['file_name' => 'logo-default.svg'],
                'logo_white'                    => ['file_name' => 'logo-white.svg'],
                'auth_pages_video'              => ['file_name' => 'home-page/banner-video.mp4'],
                'auth_pages_image_1'            => ['file_name' => 'tutor-rating.png'],
                'auth_pages_image_2'            => ['file_name' => 'tutor-card.png'],
                'android_app_logo'              => ['file_name' => 'android.webp'],
                'ios_app_logo'                  => ['file_name' => 'ios.webp',],
                //social links
                'fb_link'                       => '#',
                'insta_link'                    => '#',
                'x_link'                        => '#',
                'linkedin_link'                 => '#',
                'yt_link'                       => '#',
                'tiktok_link'                   => '#',
                //footer <settings></settings>
                // 'footer_paragraph'              => 'Lernen is the top online tutoring platform for children, dedicated to connecting each student with their perfect tutor. With a network of over 1 million qualified tutors, we provide exceptional tutoring in every school subject.',
                // 'footer_contact'                => '(316) 555-0116',
                // 'footer_email'                  => 'hello@gmail.com',
                // 'footer_address'                => '4517 Washington Ave. Manchester, Kentucky 39495',
                // 'footer_button_text'            => 'Join us for free',
                // 'footer_button_url'             => 'register',
                // 'quick_links_heading'           => 'Our Company',
                // 'tutors_by_country_heading'     => 'Tutors near you',
                // 'app_section_heading'           => 'Get mobile apps',
                // 'app_section_description'       => 'Take education on the go. Get our mobile app for FREE! on your Apple and Android devices',
                // 'android_app_url'               => '#',
                // 'ios_app_url'                   => '#',
                // 'our_services_heading'          => 'Our services',
                // 'one_on_one_sessions_heading'   => 'One-on One sessions',
                // 'group_sessions_heading'        => 'Group sessions',
                // 'app_ios_link'                  => '#',
                // 'app_android_link'              => '#',
                // 'header_variation_for_pages' => [
                //     [ 'page_id' => 1,  'header_variation'  => 'am-header_two'],
                //     [ 'page_id' => 2,  'header_variation'  => 'am-header_three'],
                // ],
                // 'footer_variation_for_pages' => [
                //     [ 'page_id' => 1,  'footer_variation'  => 'am-footer'],
                //     [ 'page_id' => 2,  'footer_variation'  => 'am-footer_two'],
                // ]
            ],
            '_lernen' => [
                //general
                'identity_verification_for_role'    => 'both',
                'tutor_display_name'                => 'Tutor',
                'student_display_name'              => 'Student',
                'booking_reserved_time'             => '30',
                'complete_booking_after_days'        => '3',
                'start_of_week'                     => 'sunday',
                'withdraw_amount_limit'             => '100',
                'title'                             => 'Discover a Skilled Online Tutor &amp; Experience the difference',
                'description'                       => 'Discover the expertise of a seasoned online tutor who offers personalized guidance tailored to your needs. Now you can experience transformative learning with impactful results that enhance your skills.',
                'cta_text'                          => 'Join Our Community',
                'cta_url'                           => 'register',
                'enable_help'                       => false,
                'help_section_media'                => [uploadObMedia('demo-content/home-page/banner-video.mp4')],
                'help_section_title'                => 'Tips to find the best Tutor',
                'help_section_description'          => 'Choosing the right tutor online requires careful consideration. Here are tips to help you make an informed decision.',
                'help_section_bullets'              => [
                    ['help_section' => 'Filter your requirements'],
                    ['help_section' => 'Check qualifications and experience'],
                    ['help_section' => 'Read reviews and ratings'],
                    ['help_section' => 'Evaluate communication skills'],
                    ['help_section' => 'Check availability and flexibility'],
                ],
                'or_section_title'                  => 'Need help in finding the tutor?',
                'or_section_description'            => 'We\'ll help you find the perfect tutor to meet your educational needs.',
                'help_section_cta'                  => 'Contact Now',
                'repeater_with_fields'              => [
                    [
                        'icon_class'        => 'am-icon-swatchbook',
                        'title'             => 'Personalized Tutor Matching Online',
                        'description'       => 'Algorithms match students with tutors based on specific needs, learning styles, and subject requirements.',
                    ],
                    [
                        'icon_class'        => 'am-icon-modules-04',
                        'title'             => 'Crafted Easy Interactive Learning Tools',
                        'description'       => 'Virtual classrooms, video conferencing, and interactive whiteboards provide an engaging and effective learning experience.',
                    ],
                    [
                        'icon_class'        => 'am-icon-user-check',
                        'title'             => 'All Critically Verified Tutor Profiles',
                        'description'       => 'Profiles with credentials, reviews, and ratings help users select qualified and trusted tutors.',
                    ],
                    [
                        'icon_class'        => 'am-icon-calender-duration',
                        'title'             => 'Flexible Scheduling to Book Online Session',
                        'description'       => 'Easy booking and rescheduling options to accommodate different time zones & busy schedules, ensuring convenient & flexible learning sessions.',
                    ],
                ],
                'enable_tips'                => true,
                'tip_section_title'             => 'Tips for Writing a Bias-Free Review For Tutor',
                'tip_section_description'       => 'When crafting a review for a tutor, it\'s crucial to maintain fairness and objectivity. Here are ten tips to help you write a balanced and bias-free review',
                'tip_bullets_repeater'          => [
                    ['tip_bullets'       => 'Be Specific and Objective'],
                    ['tip_bullets'       => 'Use Neutral Language'],
                    ['tip_bullets'       => 'Avoid Personal Attacks'],
                    ['tip_bullets'       => 'Balance Positive and Negative Feedback'],
                    ['tip_bullets'       => 'Seek Multiple Perspectives'],
                    ['tip_bullets'       => 'Be Constructive'],
                ],
                'well_wishing_text'             => 'Happy Learning, Happy Growing 🤗',

                'enable_booking_tips'    => true,
                'tips_for_booking_image'        => [uploadObMedia('demo-content/developer-at-desk.png')],
                'tips_for_booking_heading'      => 'Book your session now',

                'tips_for_booking_bullets'      => [
                    ['tips_for_booking_bullet' => 'Choose an <b>available time</b> slot for your tutor'],
                    ['tips_for_booking_bullet' => 'Choose one-on-one or Group Sessions'],
                    ['tips_for_booking_bullet' => 'Choose a time slot and click "<b>Book session</b>"'],
                    ['tips_for_booking_bullet' => 'Proceed order, confirm, and start learning!'],
                ],
                'tips_for_booking_sub_heading'  => 'Tips for a Smooth Booking Experience',
                'tips_for_booking_sub_bullets'  => [
                    ['tips_for_booking_sub_bullet' => 'Before booking, read our <a href="/terms-condition"><i>Terms and Conditions</i></a>'],
                    ['tips_for_booking_sub_bullet' => 'Need help? Visit <a href="/how-it-works"><i>How booking works</i></a>'],
                    ['tips_for_booking_sub_bullet' => 'View our <a href="/privacy-policy"><i>Privacy Guidelines</i></a> for information'],
                    ['tips_for_booking_sub_bullet' => 'Have questions? Check our <a href="/faq"><i>FAQ section</i></a>.'],
                    ['tips_for_booking_sub_bullet' => 'For session costs, review our <a href="#"><i>Pricing guidelines</i></a>.'],
                    ['tips_for_booking_sub_bullet' => 'Read our <a href="/terms-condition#cancellation_policy"><i>Cancellation policies</i></a> for cancellation procedures'],
                ],
            ],
            '_social' => [
                'facebook'                  => '#',
                'twitter'                   => '#',
                'linkedin'                  => '#',
                'instagaram'                => '#',
                'youtube'                   => '#',
                'tiktok'                    => '#',
            ],
            'admin_settings' => [
                'payment_method' =>  [
                    'stripe' => [
                        'currency' => 'USD',
                        'stripe_key' => '',
                        'stripe_secret' => '',
                        'status' => 'on',
                        'exchange_rate' => ''
                    ],
                ],
                'commission_setting' => [
                    'percentage' => ['value' => 5]
                ]
            ]
        ];

        if (!empty($def_setting)) {
            foreach ($def_setting as $section_key => $setting) {
                foreach ($setting as $field => $value) {
                    if (!empty($value['file_name'])) {
                        $value = [json_encode(uploadObMedia('demo-content/' . $value['file_name']))];
                    }
                    if (isset($value) && !is_null($value)) {
                        Settings::set($section_key, $field, $value);
                    }
                }
            }
            Cache::forget('optionbuilder__settings');
        }
    }



    /**
     * Add defualt menues.
     */
    public function defualtMenu()
    {
        Menu::truncate();
        MenuItem::truncate();
        $menus = [
            [
                'name'          => 'Header menu',
                'location'      => 'header',
                'menu_items'    => [
                    [
                        'menu_id'   => '',
                        'parent_id' => null,
                        'label'     => 'Home',
                        'route'     => url('/'),
                        'type'      => 'page',
                        'sort'      => '1',
                        'class'     => '',
                    ],
                    [
                        'menu_id'   => '',
                        'parent_id' => '1',
                        'label'     => 'Home Page 01',
                        'route'     => url('/'),
                        'type'      => 'custom',
                        'sort'      => '1',
                        'class'     => '',
                    ],
                    [
                        'menu_id'   => '',
                        'parent_id' => '1',
                        'label'     => 'Home Page 02',
                        'route'     => url('home-two'),
                        'type'      => 'custom',
                        'sort'      => '1',
                        'class'     => '',
                    ],
                    [
                        'menu_id'   => '',
                        'parent_id' => '1',
                        'label'     => 'Home Page 03',
                        'route'     => url('home-three'),
                        'type'      => 'custom',
                        'sort'      => '1',
                        'class'     => '',
                    ],
                    [
                        'menu_id'   => '',
                        'parent_id' => '1',
                        'label'     => 'Home Page 04',
                        'route'     => url('home-four'),
                        'type'      => 'custom',
                        'sort'      => '1',
                        'class'     => '',
                    ],
                    [
                        'menu_id'   => '',
                        'parent_id' => '1',
                        'label'     => 'Home Page 05',
                        'route'     => url('home-five'),
                        'type'      => 'custom',
                        'sort'      => '1',
                        'class'     => '',
                    ],
                    [
                        'menu_id'   => '',
                        'parent_id' => null,
                        'label'     => 'Find Tutors',
                        'route'     => url('find-tutors'),
                        'type'      => 'page',
                        'sort'      => '2',
                        'class'     => '',
                    ],
                    [
                        'menu_id'   => '',
                        'parent_id' => null,
                        'label'     => 'About',
                        'route'     => url('about-us'),
                        'type'      => 'page',
                        'sort'      => '3',
                        'class'     => '',
                    ],
                    [
                        'menu_id'   => '',
                        'parent_id' => null,
                        'label'     => 'Common FAQs',
                        'route'     => url('faq'),
                        'type'      => 'page',
                        'sort'      => '4',
                        'class'     => '',
                    ],
                    [
                        'menu_id'   => '',
                        'parent_id' => null,
                        'label'     => 'How it Works',
                        'route'     => url('how-it-works'),
                        'type'      => 'page',
                        'sort'      => '5',
                        'class'     => '',
                    ],
                    [
                        'menu_id'   => '',
                        'parent_id' => null,
                        'label'     => 'Blogs',
                        'route'     => url('blogs'),
                        'type'      => 'page',
                        'sort'      => '6',
                        'class'     => '',
                    ],
                ]
            ],
            [
                'name'          => 'Footer menu 1',
                'location'      => 'footer',
                'menu_items'    => [
                    [
                        'menu_id'   => '',
                        'parent_id' => null,
                        'label'     => 'About',
                        'route'     => url('about-us'),
                        'type'      => 'page',
                        'sort'      => '1',
                        'class'     => '',
                    ],
                    [
                        'menu_id'   => '',
                        'parent_id' => null,
                        'label'     => 'Terms and Condition',
                        'route'     => url('terms-condition'),
                        'type'      => 'page',
                        'sort'      => '3',
                        'class'     => '',
                    ],
                    [
                        'menu_id'   => '',
                        'parent_id' => null,
                        'label'     => 'Find tutor',
                        'route'     => url('find-tutors'),
                        'type'      => 'page',
                        'sort'      => '4',
                        'class'     => '',
                    ],
                    [
                        'menu_id'   => '',
                        'parent_id' => null,
                        'label'     => 'Common FAQs',
                        'route'     => url('faq'),
                        'type'      => 'page',
                        'sort'      => '5',
                        'class'     => '',
                    ],
                    [
                        'menu_id'   => '',
                        'parent_id' => null,
                        'label'     => 'How it Works',
                        'route'     => url('how-it-works'),
                        'type'      => 'page',
                        'sort'      => '6',
                        'class'     => '',
                    ],
                    [
                        'menu_id'   => '',
                        'parent_id' => null,
                        'label'     => 'Blogs',
                        'route'     => url('blogs'),
                        'type'      => 'page',
                        'sort'      => '7',
                        'class'     => '',
                    ],
                ]
            ],
            [
                'name'          => 'Footer menu 2',
                'location'      => 'footer',
                'menu_items'    => [
                    [
                        'menu_id'   => '',
                        'parent_id' => null,
                        'label'     => 'Tutors in Afghanistan',
                        'route'     => url('find-tutors?country=1'),
                        'type'      => 'page',
                        'sort'      => '1',
                        'class'     => '',
                    ],
                    [
                        'menu_id'   => '',
                        'parent_id' => null,
                        'label'     => 'Tutors in Albania',
                        'route'     => url('find-tutors?country=2'),
                        'type'      => 'page',
                        'sort'      => '2',
                        'class'     => '',
                    ],
                    [
                        'menu_id'   => '',
                        'parent_id' => null,
                        'label'     => 'Tutors in Algeria',
                        'route'     => url('find-tutors?country=3'),
                        'type'      => 'page',
                        'sort'      => '3',
                        'class'     => '',
                    ],
                    [
                        'menu_id'   => '',
                        'parent_id' => null,
                        'label'     => 'Tutors in American Samoa',
                        'route'     => url('find-tutors?country=4'),
                        'type'      => 'page',
                        'sort'      => '4',
                        'class'     => '',
                    ],
                    [
                        'menu_id'   => '',
                        'parent_id' => null,
                        'label'     => 'Tutors in Andorra',
                        'route'     => url('find-tutors?country=5'),
                        'type'      => 'page',
                        'sort'      => '4',
                        'class'     => '',
                    ],
                    [
                        'menu_id'   => '',
                        'parent_id' => null,
                        'label'     => 'Tutors in Angola',
                        'route'     => url('find-tutors?country=6'),
                        'type'      => 'page',
                        'sort'      => '6',
                        'class'     => '',
                    ],

                ]
            ],
            [
                'name'          => 'Footer menu 3',
                'location'      => 'footer',
                'menu_items'    => [
                    [
                        'menu_id'   => '',
                        'parent_id' => null,
                        'label'     => 'Online English classes',
                        'route'     => url('find-tutors?subject_id=6'),
                        'type'      => 'page',
                        'sort'      => '1',
                        'class'     => '',
                    ],
                    [
                        'menu_id'   => '',
                        'parent_id' => null,
                        'label'     => 'Online Maths classes',
                        'route'     => url('find-tutors?subject_id=7'),
                        'type'      => 'page',
                        'sort'      => '2',
                        'class'     => '',
                    ],
                    [
                        'menu_id'   => '',
                        'parent_id' => null,
                        'label'     => 'Online Physics classes',
                        'route'     => url('find-tutors?subject_id=12'),
                        'type'      => 'page',
                        'sort'      => '3',
                        'class'     => '',
                    ],
                    [
                        'menu_id'   => '',
                        'parent_id' => null,
                        'label'     => 'Online Chemistry classes',
                        'route'     => url('find-tutors?subject_id=14'),
                        'type'      => 'page',
                        'sort'      => '4',
                        'class'     => '',
                    ],
                    [
                        'menu_id'   => '',
                        'parent_id' => null,
                        'label'     => 'Online Science classes',
                        'route'     => 'find-tutors?subject_id=10',
                        'type'      => 'page',
                        'sort'      => '5',
                        'class'     => '',
                    ],
                    [
                        'menu_id'   => '',
                        'parent_id' => null,
                        'label'     => 'Online Computer classes',
                        'route'     => url('find-tutors?subject_id=11'),
                        'type'      => 'page',
                        'sort'      => '6',
                        'class'     => '',
                    ],

                ]
            ],
            [
                'name'          => 'Footer menu 4',
                'location'      => 'footer',
                'menu_items'    => [
                    [
                        'menu_id'   => '',
                        'parent_id' => null,
                        'label'     => 'Online English classes',
                        'route'     => url('find-tutors?subject_id=6&session_type=one'),
                        'type'      => 'page',
                        'sort'      => '1',
                        'class'     => '',
                    ],
                    [
                        'menu_id'   => '',
                        'parent_id' => null,
                        'label'     => 'Online Maths classes',
                        'route'     => url('find-tutors?subject_id=7&session_type=one'),
                        'type'      => 'page',
                        'sort'      => '2',
                        'class'     => '',
                    ],
                    [
                        'menu_id'   => '',
                        'parent_id' => null,
                        'label'     => 'Online Physics classes',
                        'route'     => url('find-tutors?subject_id=12&session_type=one'),
                        'type'      => 'page',
                        'sort'      => '3',
                        'class'     => '',
                    ],
                    [
                        'menu_id'   => '',
                        'parent_id' => null,
                        'label'     => 'Online Chemistry classes',
                        'route'     => url('find-tutors?subject_id=14&session_type=one'),
                        'type'      => 'page',
                        'sort'      => '4',
                        'class'     => '',
                    ],
                    [
                        'menu_id'   => '',
                        'parent_id' => null,
                        'label'     => 'Online Science classes',
                        'route'     => url('find-tutors?subject_id=10&session_type=one'),
                        'type'      => 'page',
                        'sort'      => '5',
                        'class'     => '',
                    ],
                    [
                        'menu_id'   => '',
                        'parent_id' => null,
                        'label'     => 'Online Computer classes',
                        'route'     => url('find-tutors?subject_id=11&session_type=one'),
                        'type'      => 'page',
                        'sort'      => '6',
                        'class'     => '',
                    ],

                ]
            ],
            [
                'name'          => 'Footer menu 5',
                'location'      => 'footer',
                'menu_items'    => [
                    [
                        'menu_id'   => '',
                        'parent_id' => null,
                        'label'     => 'Online English classes',
                        'route'     => url('find-tutors?subject_id=6&session_type=group'),
                        'type'      => 'page',
                        'sort'      => '1',
                        'class'     => '',
                    ],
                    [
                        'menu_id'   => '',
                        'parent_id' => null,
                        'label'     => 'Online Maths classes',
                        'route'     => url('find-tutors?subject_id=7&session_type=group'),
                        'type'      => 'page',
                        'sort'      => '2',
                        'class'     => '',
                    ],
                    [
                        'menu_id'   => '',
                        'parent_id' => null,
                        'label'     => 'Online Physics classes',
                        'route'     => url('find-tutors?subject_id=12&session_type=group'),
                        'type'      => 'page',
                        'sort'      => '3',
                        'class'     => '',
                    ],
                    [
                        'menu_id'   => '',
                        'parent_id' => null,
                        'label'     => 'Online Chemistry classes',
                        'route'     => url('find-tutors?subject_id=14&session_type=group'),
                        'type'      => 'page',
                        'sort'      => '4',
                        'class'     => '',
                    ],
                    [
                        'menu_id'   => '',
                        'parent_id' => null,
                        'label'     => 'Online Science classes',
                        'route'     => url('find-tutors?subject_id=10&session_type=group'),
                        'type'      => 'page',
                        'sort'      => '5',
                        'class'     => '',
                    ],
                    [
                        'menu_id'   => '',
                        'parent_id' => null,
                        'label'     => 'Online Computer classes',
                        'route'     => url('find-tutors?subject_id=11&session_type=group'),
                        'type'      => 'page',
                        'sort'      => '6',
                        'class'     => '',
                    ],

                ]
            ],

        ];

        foreach ($menus as $key => $menu) {
            $check = Menu::where('name', $menu['name'])->exists();
            if (!$check) {
                $menue = Menu::create([
                    'name'      => $menu['name'],
                    'location'  => $menu['location'],
                ]);

                foreach ($menu['menu_items'] as $items) {
                    MenuItem::create([
                        'menu_id'   => $menue->id,
                        'parent_id' => $items['parent_id'],
                        'label'     => $items['label'],
                        'route'     => $items['route'],
                        'type'      => $items['type'],
                        'sort'      => $items['sort'],
                        'class'     => '',
                    ]);
                }
            }
        }
        Artisan::call('optimize:clear');
    }
}
