<?php

namespace App\Livewire\Forms\Common\ProfileSettings;

use App\Http\Requests\Common\PersonalDetail\PersonalDetailRequest;
use App\Traits\PrepareForValidation;
use Illuminate\Support\Facades\Auth;
use Livewire\Form;

class PersonalDetailsForm extends Form
{
    use PrepareForValidation;

    public string $first_name   = '';
    public string $last_name    = '';
    public string $gender       = 'male';
    public string $tagline      = '';
    public $lat                 = '';
    public $long                = '';
    public string $country      = '';
    public string $city         = '';
    public string $zipcode      = '';
    public $state               = null;
    public string $address      = '';
    public $user_languages      = [];
    public string $description  = '';
    public $image;
    public $intro_video;
    public string $email        = '';
    public string $thumbnail    = '';
    public $profile;
    public $cropImageUrl        = '';
    public $isBase64            = false;
    public $imageName           = false;
    public $native_language     = '';
    public $countryName         = '';

    private ?PersonalDetailRequest $request = null;

    public function boot() {
        $this->request       = new PersonalDetailRequest();
    }

    public function getInfo($profile)
    {
        $this->first_name       = $profile?->first_name ?? '';
        $this->last_name        = $profile?->last_name ?? '';
        $this->native_language  = $profile?->native_language ?? '';
        $this->gender           = $profile?->gender ?? 'male';
        $this->tagline          = $profile?->tagline ?? '';
        $this->description      = $profile?->description ?? '';
        $this->image            = $profile?->image ?? '';
        $this->intro_video      = $profile?->intro_video ?? '';
        $this->email            = Auth::user()?->email;
    }

    public function rules(): array
    {
        return $this->request->rules();
    }

    public function messages(): array
    {
        return $this->request->messages();
    }

    public function validateForm($hasStates)
    {
        $rules = $this->rules();
        $messages = $this->messages();
        if($hasStates){
            $rules['state'] = 'required';
        }
        $this->beforeValidation(['user_languages']);
        $this->validate($rules, $messages);

    }

    public function updateProfileInfo()
    {


        if(!empty($this->image) && !empty($this->isBase64)){

            $bse64 = explode(',', $this->image);
            $bse64 = trim($bse64[1]);
            if( base64_encode( base64_decode( $bse64, true ) ) === $bse64 ) {
                $this->image = uploadImage('profile_images', $this->image);
            }
            $this->isBase64 = false;
        }
        $intro_video = $this->intro_video;
        if(method_exists($this->intro_video,'temporaryUrl')){

            $fileName    = uniqueFileName('public/profile_videos', $this->intro_video->getClientOriginalName());
            $intro_video = $this->intro_video->storeAs('profile_videos', $fileName, 'public');
        }
        $this->intro_video = $intro_video;

        $data = [
            'first_name'      => sanitizeTextField($this->first_name),
            'last_name'       => sanitizeTextField($this->last_name),
            'native_language' => sanitizeTextField($this->native_language),
            'gender'          => sanitizeTextField($this->gender),
            'image'           => $this->image,
            'intro_video'     => str_replace('public/', '', $intro_video),
            'tagline'         => sanitizeTextField($this->tagline),
            'description'     => sanitizeTextField(html_entity_decode($this->description), keep_linebreak:true),
        ];

        return $data;
    }

    public function validateMedia($type)
    {
        $type == 'image'
        ?
        $this->validate(['image' => 'image|mimes:' . (setting('_general.allowed_image_extensions') ?? 'jpg,png') . '|max:' . (setting('_general.max_image_size') ?? 5) * 1024])
        :
        $this->validate(['intro_video' => 'required|mimes:' . (setting('_general.allowed_video_extensions') ?? 'mp4')  . '|max:' . (setting('_general.max_video_size') ?? 20) * 1024]);
    }

    public function userAddress()
    {
        $data = [
            'country_id'    => !empty($this->country) ? $this->country : null,
            'state_id'      => !empty($this->state) ? $this->state : null,
            'city'          => sanitizeTextField($this->city)  ?? null ,
            'address'       => sanitizeTextField($this->address) ?? null ,
            'zipcode'       => sanitizeTextField($this->zipcode) ?? null ,
        ];

        if(!empty($this->lat)){

            $data['lat'] = sanitizeTextField($this->lat);
        }

        if(!empty($this->long)){

            $data['long'] = sanitizeTextField($this->long);
        }

        return $data;
    }

    public function setUserLanguages($languages)
    {
        $this->user_languages = $languages ?? [];
    }

    public function setUserAddress($address)
    {
        $this->country  = $address?->country_id ?? '';
        $this->city     = $address?->city ?? '';
        $this->zipcode  = $address?->zipcode ?? '';
        $this->state    = $address?->state_id ?? '';
        $this->address  = $address?->address ?? '';
        $this->lat      = $address?->lat ?? '';
        $this->long     = $address?->long ?? '';
    }

    public function setVideo($video)
    {
        $this->intro_video = $video;
    }

    public function removePhoto()
    {
        $this->image = null;
    }

    public function removeVideo()
    {
        $this->intro_video = null;
    }
}
