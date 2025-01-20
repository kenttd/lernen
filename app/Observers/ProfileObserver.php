<?php

namespace App\Observers;

use App\Models\Profile;
use Illuminate\Support\Str;

class ProfileObserver {
    /**
     * Handle the Profile "creating" event.
     *
     * @param  \App\Models\Profile  $profile
     * @return void
     */
    public function creating(Profile $profile) {
        $slug = Str::lower($profile->first_name . '-' . $profile->last_name);
        $profile->slug = $this->uniqueSlug($slug);
    }
    protected function uniqueSlug($slug, $i = 0) {
        if (Profile::whereSlug($slug)->exists()) {
            $slug = Str::of($slug)->rtrim('-' . $i) . '-' . ++$i;
            return $this->uniqueSlug($slug, $i);
        }
        return $slug;
    }
}
