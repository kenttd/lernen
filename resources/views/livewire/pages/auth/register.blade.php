<?php

use App\Http\Requests\Auth\RegisterUserRequest;
use App\Models\User;
use Illuminate\Auth\Events\Registered;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rules;
use Livewire\Attributes\Layout;
use Livewire\Volt\Component;
use App\Services\RegisterService;
use App\Livewire\Forms\Auth\RegisterUserForm;

new #[Layout('layouts.guest')] class extends Component
{
    public string $first_name = '';
    public string $last_name = '';
    public string $email = '';
    public string $password = '';
    public string $password_confirmation = '';
    public string $user_role    = 'tutor';
    public string $terms        = '';
    /**
     * Handle an incoming registration request.
     */
    public function register(): void
    {
        $validated = $this->validate((new RegisterUserRequest())->rules());
        $user = (new RegisterService)->registerUser($validated);
        Auth::login($user);
        $this->redirect(route('tutor.profile.personal-details', absolute: false), navigate: true);
    }
}; ?>

<div>
    @slot('title')
        {{ __('auth.join') }}
    @endslot
    <x-auth-card>
        <x-slot name="logo">
            <strong>
                <x-application-logo :variation="'white'" />
            </strong>
        </x-slot>
        <x-slot name="formHeader">
            <strong class="am-mobile-logo">
                <x-application-logo />
            </strong>
            <div class="am-login-right_title">
                <h2>{{ __('auth.register_right_h2') }}</h2>
                <h3>{{ __('auth.register_right_h3') }}</h3>
            </div>
        </x-slot>
        <form wire:submit="register" class="am-themeform am-login-form am-signup-form">
            <fieldset>
                <div class="am-themeform__wrap">
                    <div class="form-group-wrap">
                        <div class="am-form-group-row">
                            <div class="form-group-half {{ $errors->get('first_name') ? 'am-invalid' : '' }}">
                                <x-input-label for="first_name" :value="__('auth.first_name')" />
                                <x-text-input id="first_name" wire:model="first_name" placeholder="{{ __('auth.first_name') }}" type="text"  autofocus autocomplete="name" />
                                <x-input-error field_name="first_name" />
                            </div>
                            <div class="form-group-half {{ $errors->get('last_name') ? 'am-invalid' : '' }}">
                                <x-input-label for="last_name" :value="__('auth.last_name')" />
                                <x-text-input id="last_name" wire:model="last_name" placeholder="{{ __('auth.last_name') }}" type="text"  autofocus  />
                                <x-input-error field_name="last_name" />
                            </div>
                        </div>
                        <div class="form-group {{ $errors->get('email') ? 'am-invalid' : '' }}">
                            <x-input-label for="email" :value="__('auth.email_placeholder')" />
                            <x-text-input id="email" wire:model="email" placeholder="{{ __('auth.email_placeholder') }}" type="email"  autofocus  />
                            <x-input-error field_name="email" />
                        </div>
                        <div class="form-group {{ $errors->get('password') ? 'am-invalid' : '' }}">
                            <x-input-label for="password" :value="__('auth.password_placeholder')" />
                            <div class="am-passwordfield">
                                <x-text-input id="password" wire:model="password" placeholder="{{ __('auth.password_placeholder') }}" type="password"  autofocus  />
                                <i class="am-icon-eye-open-01" id="togglePassword"></i>
                            </div>
                        </div>
                        <div class="form-group {{ $errors->get('password') ? 'am-invalid' : '' }}">
                            <x-input-label for="password_confirmation" :value="__('auth.confirm_password_placeholder')" />
                            <div class="am-passwordfield">
                                <x-text-input id="password_confirmation" wire:model="password_confirmation" placeholder="{{ __('auth.confirm_password_placeholder') }}" type="password"  autofocus  />
                                <i class="am-icon-eye-open-01" id="toggleConfirmPassword"></i>
                            </div>
                            <x-input-error field_name="password" />
                        </div>
                        <div class="form-group am-form-groupradio">
                            <x-input-label :value="__('auth.role')" />
                            <div class="am-selectrole">
                                <div class="am-radio">
                                    <input wire:model="user_role" id="tutor" value="tutor" type="radio" autofocus name="user_role">
                                    <x-input-label for="tutor" :value="__('auth.tutor')" />
                                </div>
                                <div class="am-radio">
                                    <input wire:model="user_role" id="student" value="student" type="radio" autofocus name="user_role">
                                    <x-input-label for="student" :value="__('auth.student')" />
                                </div>
                            </div>
                        </div>
                        <div class="form-group @error('terms') am-invalid @enderror am-terms-check">
                            <div class="am-checkbox am-signup-check">
                                <input wire:model="terms" type="checkbox" id="terms" name="terms">
                                <label for="terms"><span>{!! __('auth.register_terms') !!}</label>
                            </div>
                            <x-input-error :field_name="'terms'"></x-input-error>
                        </div>
                        <div class="form-group">
                            <x-primary-button wire:loading.class="am-btn_disable"><span>{{ __('auth.register') }}</span><i class="icon icon-arrow-right"></i></x-primary-button>
                             <span class="am-already-account"> {{ __('auth.already_have_account') }} <a href="{{ route('login') }}">{{ __('auth.login') }}</a></span>
                        </div>
                    </div>
                </div>
        </form>
    </x-auth-card>
</div>
@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function () {
        function togglePasswordVisibility(toggleButton, passwordField) {
            const type = passwordField.getAttribute('type') === 'password' ? 'text' : 'password';
            passwordField.setAttribute('type', type);
            toggleButton.classList.toggle('am-icon-eye-open-01', type === 'password');
            toggleButton.classList.toggle('am-icon-eye-close-01', type !== 'password');
        }
        const togglePassword = document.getElementById('togglePassword');
        const passwordField = document.getElementById('password');

        const toggleConfirmPassword = document.getElementById('toggleConfirmPassword');
        const confirmPasswordField = document.getElementById('password_confirmation');

        togglePassword.addEventListener('click', function () {
            togglePasswordVisibility(togglePassword, passwordField);
        });

        toggleConfirmPassword.addEventListener('click', function () {
            togglePasswordVisibility(toggleConfirmPassword, confirmPasswordField);
        });
    });
</script>
@endpush
