<?php

namespace App\Livewire\Pages\Common\ProfileSettings;

use App\Livewire\Forms\Common\ProfileSettings\PersonalDetailsForm;
use App\Models\Country;
use App\Models\Language;
use App\Services\ProfileService;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Session;
use Livewire\Attributes\Layout;
use Livewire\Component;
use Livewire\WithFileUploads;

class PersonalDetails extends Component
{
    use WithFileUploads;

    public PersonalDetailsForm $form;

    public $allowImgFileExt = [];
    public $allowVideoFileExt = [];
    public $allowImageSize  = '';
    public $googleApiKey = '';
    public $fileExt = '';
    public $isLoading = true;
    public $imageFileSize = '';
    public $videoFileSize = '';
    public $vedioExt = '';
    public $languages = [];
    public $countries = null;
    public $hasStates = false;
    public $introVideo;
    private ?ProfileService $profileService = null;
    public $MAX_PROFILE_CHAR = 500;
    public $activeRoute = false;

    #[Layout('layouts.app')]
    public function render()
    {
        $enableGooglePlaces = setting('_api.enable_google_places') ?? '0';
        $states = null;
        if(!empty($this->form->country)){
            $states = $this->profileService->countryStates($this->form->country);
            if($states->isNotEmpty()){
                $this->hasStates = true;
                $this->dispatch('initSelect2', target: '#country_state' ,timeOut:0 );
            } else {
                $this->hasStates = false;
            }
        }
        return view('livewire.pages.common.profile-settings.personal-details', compact('enableGooglePlaces','states'));
    }

    public function boot() {
        $this->profileService = new ProfileService(Auth::user()->id);
    }

    public function loadData()
    {
        $this->isLoading            = false;
        $this->dispatch('loadPageJs');
    }

    public function mount(): void
    {
        $this->languages = Language::get(['id', 'name'])?->pluck('name','id')?->toArray();
        $this->countries = Country::get(['id','name']);
        $profile = $this->profileService->getUserProfile();
        $address = $this->profileService->getUserAddress();
        $languages = $this->profileService->getUserLanguages();
        $this->activeRoute = Route::currentRouteName();
        $this->form->getInfo($profile);
        $this->form->setUserAddress($address);
        $this->form->setUserLanguages($languages);
        $image_file_ext          = setting('_general.allowed_image_extensions');
        $image_file_size         = setting('_general.max_image_size');
        $video_file_size         = setting('_general.max_video_size');
        $video_file_ext          = setting('_general.allowed_video_extensions');
        $this->fileExt           =  $image_file_ext;
        $this->vedioExt          =  $video_file_ext;
        $this->imageFileSize     =  $image_file_size;
        $this->videoFileSize     =  $video_file_size;
        $this->googleApiKey      = setting('_api.google_places_api_key');
        $this->allowImageSize    = !empty( $image_file_size ) ? $image_file_size : '3';
        $this->allowImageSize    = !empty( $image_file_size ) ? $image_file_size : '3';
        $this->allowImgFileExt   = !empty( $image_file_ext ) ?  explode(',', $image_file_ext) : ['jpg','png'];
        $this->allowVideoFileExt = !empty( $video_file_ext ) ?  explode(',', $video_file_ext) : [];
        if (Session::get('error')) {
            $this->dispatch('showAlertMessage', type: 'error', message: Session::get('error'));
        }
    }

    public function updateInfo()
    {
        $form = $this->form;
        if (!empty($this->introVideo)) {
            $this->form->setVideo($this->introVideo);
        }
        $form->validateForm($this->hasStates);
        $response = isDemoSite();
        if( $response ){
            $this->dispatch('showAlertMessage', type: 'error', title:  __('general.demosite_res_title') , message: __('general.demosite_res_txt'));
            return;
        }
        $this->introVideo = null;
        $data = $form->updateProfileInfo();
        $address = $form->userAddress();
        $this->profileService->setUserProfile($data);
        $this->profileService->storeUserLanguages($form->user_languages);
        $this->profileService->setUserAddress($address);
        $this->dispatch('profile-img-updated', image: resizedImage($form->image, 36, 36));
        $this->dispatch('showAlertMessage', type: 'success', title: __('general.success_title') , message: __('general.success_message'));
    }

    public function updatingForm($value, $key)
    {
        if( $key == 'country' ) {
            $this->form->state = null;
        }
    }

    public function updatedIntroVideo()
    {
        $this->validate(['introVideo' => 'required|mimes:' . (setting('_general.allowed_video_extensions') ?? 'mp4')  . '|max:' . (setting('_general.max_video_size') ?? 20) * 1024]);
    }

    public function removeMedia($type)
    {
        if ($type == 'video') {
            $this->introVideo = null;
            $this->form->removeVideo();
        } else {
            $this->form->removePhoto();
        }
    }
}
