<?php

use App\Livewire\Forms\LoginForm;
use Illuminate\Support\Facades\Session;
use Livewire\Attributes\Layout;
use Livewire\Volt\Component;

new #[Layout('layouts.guest')] class extends Component
{
    public LoginForm $form;

    /**
     * Handle an incoming authentication request.
     */
    public function login(): void
    {
        $this->validate();
        $this->form->authenticate();
        Session::regenerate();
        $this->dispatch('showAlertMessage', type: 'success', title: __('general.success_title') , message: __('general.login_success'));
        usleep(500);
        $this->redirect(auth()->user()->redirect_after_login);
    }
}; ?>

<div>
    <!-- Session Status -->
    <x-auth-session-status class="mb-4" :status="session('status')" />
    @slot('title')
        {{ __('auth.login') }}
    @endslot
    <!-- Search Header Start -->
    <x-auth-card>
        <x-slot name="logo">
            <strong>
                <x-application-logo :variation="'white'" />
            </strong>
        </x-slot>

        <!-- Session Status -->
        <x-auth-session-status class="mb-4" :status="session('status')" />
        <x-slot name="formHeader">
            <strong class="am-mobile-logo">
                <x-application-logo />
            </strong>
            <div class="am-login-right_title">
                <h2>{{ __('auth.login_right_h2') }}</h2>
                <h3>{{ __('auth.login_right_h3') }}</h3>
            </div>
        </x-slot>
        <form wire:submit.prevent="login" class="am-themeform am-login-form" x-data="{form:@entangle('form')}">
            <fieldset>
                <div class="am-themeform__wrap">
                    <div class="form-group-wrap">
                        <div class="form-group {{ $errors->get('form.email') ? 'am-invalid' : '' }}">
                            <x-input-label class="am-important" for="username" :value="__('auth.email_placeholder')" />
                            <x-text-input x-model="form.email" id="username" wire:model="form.email" placeholder="{{ __('auth.email_placeholder') }}" type="text"  autofocus  />
                            <x-input-error field_name="form.email" />
                        </div>
                        <div class="form-group pb-2 {{ $errors->get('form.password') ? 'am-invalid' : '' }}">
                            <x-input-label for="password" class="am-important" :value="__('auth.password_placeholder')" />
                            <div class="am-passwordfield">
                                <x-text-input x-model="form.password" id="password" wire:model="form.password" placeholder="{{ __('auth.password_placeholder') }}" type="password" autofocus />
                                <i class="am-icon-eye-open-01" id="togglePassword"></i>
                            </div>
                            <x-input-error field_name="form.password" />
                        </div>
                        <div class="form-group am-lost-password">
                            <div class="am-checkbox">
                                <input id="remember_me" type="checkbox" name="remember">
                                <label for="remember_me">
                                    <span>{{ __('auth.remember_me') }}</span>
                                </label>
                            </div>
                            <a href="{{ route('password.request') }}">{{ __('auth.lost_password') }}</a>
                        </div>
                        <div class="form-group">
                            <x-primary-button wire:loading.class="am-btn_disable"><span>{{ __('auth.login_btn') }}</span><i class="icon icon-arrow-right"></i></x-primary-button>
                        </div>
                        @if(isDemoSite())
                            <div class="form-group">
                                <div class="am-login-options">
                                    <em>{{ __('auth.login_as') }}</em>
                                    <button type="button" class="am-btn" x-data @click="form.email = 'anthony@amentotech.com'; form.password = 'google'">
                                        {{ __('auth.tutor') }}
                                    </button>

                                    <button type="button" class="am-btn" x-data @click="form.email = 'student@amentotech.com'; form.password = 'google'">
                                        {{ __('auth.student') }}
                                    </button>

                                    <button type="button" class="am-btn" x-data @click="form.email = 'admin@amentotech.com'; form.password = 'google'">
                                        {{ __('auth.admin') }}
                                    </button>
                                    <span class="am-already-account">
                                        {{ __('auth.dont_account_join') }}
                                        <a href="{{ route('register') }}">{{ __('auth.join') }}</a>
                                    </span>
                                </div>
                            </div>
                        @else
                            <span class="am-already-account">
                                {{ __('auth.dont_account_join') }}
                                <a href="{{ route('register') }}">{{ __('auth.join') }}</a>
                            </span>
                        @endif
                    </div>
                </div>
            </fieldset>
        </form>
    </x-auth-card>
</div>
@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function () {
        const togglePassword = document.getElementById('togglePassword');

        const passwordField = document.getElementById('password');

        togglePassword.addEventListener('click', function () {
            const type = passwordField.getAttribute('type') === 'password' ? 'text' : 'password';
            passwordField.setAttribute('type', type);
            if (type === 'password') {
                togglePassword.classList.remove('am-icon-eye-close-01');
                togglePassword.classList.add('am-icon-eye-open-01');
            } else {
                togglePassword.classList.remove('am-icon-eye-open-01');
                togglePassword.classList.add('am-icon-eye-close-01');
            }
        });
    });
</script>
@endpush
