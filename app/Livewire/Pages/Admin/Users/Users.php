<?php

namespace App\Livewire\Pages\Admin\Users;

use App\Livewire\Forms\Admin\User\UserForm;
use App\Models\Profile;
use App\Models\Role;
use App\Models\User;
use App\Notifications\EmailNotification;
use App\Services\NotificationService;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Livewire\Component;
use Livewire\WithPagination;
use Illuminate\Support\Facades\Hash;
use Livewire\Attributes\Layout;
use Livewire\Attributes\On;

class Users extends Component
{
    use WithPagination;

    public      UserForm $form;
    public      $editMode           = false;
    public      $search             = '';
    public      $sortby             = 'desc';
    public      $selectedUsers      = [];
    public      $roles_list         = [];
    public      $per_page_opt       = [];
    public      $identityInfo;
    public      $roles;
    public      $role;
    public      $isEdit             = '';
    public      $user_id            = '';
    public      $date_format                     = '';
    public      $currency_symbol                 = '';
    public      $per_page                        = '';
    public      $filterUser                      = '';
    public      $verification                    = '';



    #[Layout('layouts.admin-app')]
    public function render()
    {
        $this->role =  request()->role;
        $users = User::select('id', 'email', 'created_at', 'status', 'email_verified_at',)
            ->with(
                [
                    'roles',
                    'profile' => function ($query) {
                        $query->select('id', 'user_id', 'first_name', 'last_name', 'slug', 'image', 'recommend_tutor', 'verified_at');
                    },
                    'identityVerification' => function ($query) {
                        $query->select('id', 'user_id', 'parent_verified_at');
                    }
                ]
            )
            ->whereHas('roles', function ($query) {
                $query->where('name', '!=', 'admin')
                    ->when($this->role, function ($query, $role) {
                        $query->where('name', $role);
                    });
            });

        if (!empty($this->roles)) {
            $users = $users->whereHas('roles', function ($query) {
                $query->where('name', $this->roles);
            });
        }

        if (!empty($this->role)) {
            $users = $users->whereHas('roles', function ($query) {
                $query->where('name', $this->role);
            });
        }

        if (!empty($this->filterUser)) {
            $users = $this->filterUser === 'active' ? $users->active() : $users->inactive();
        }

        if (!empty($this->verification)) {
            if ($this->verification === 'verified') {
                $users = $users->whereNotNull('email_verified_at');
            } elseif ($this->verification === 'unverified') {
                $users = $users->whereNull('email_verified_at');
            }
        }

        if (!empty($this->search)) {
            $users = $users->whereHas('profile', function ($query) {
                $query->where(function ($sub_query) {
                    $sub_query->whereFullText('first_name', $this->search);
                    $sub_query->orWhereFullText('last_name', $this->search);
                });
            });
        }
        $users = $users->orderBy('id', $this->sortby)->paginate(setting('_general.per_page_opt') ?? 10);
        return view('livewire.pages.admin.users.users', compact('users'));
    }

    public function mount()
    {
        $date_format            = setting('_general.date_format');
        $this->date_format      = !empty($date_format)  ? $date_format : 'm d, Y';
        $currency               = setting('_general.currency');
        $currency_detail        = !empty($currency)  ? currencyList($currency) : array();
        $per_page_record        = setting('_general.per_page_record');
        $this->per_page         = !empty($per_page_record) ? $per_page_record : 10;
        if (!empty($currency_detail['symbol'])) {
            $this->currency_symbol = $currency_detail['symbol'];
        }
        $this->roles_list = Role::whereNot('name', 'admin')->get();
        $this->dispatch('initSelect2', target: '.am-select2');
    }

    public function updated($propertyName)
    {
        if (in_array($propertyName, ['search', 'filterUser', 'verification', 'sortby', 'roles'])) {
            $this->resetPage();
        }
    }

    private function resetInputfields()
    {

        $this->form->first_name       = '';
        $this->form->last_name        = '';
        $this->form->email            = '';
        $this->form->userRole         = '';
        $this->form->password         = '';
        $this->form->confirm_password = '';
    }

    public function verifyUserEmail($params)
    {

        $user_account   = User::select('id', 'email')->where('id', $params['id'])->first();
        $role           = $user_account->roles->pluck('name')->first();
        $notifyService  = new NotificationService;
        if (!empty($user_account)) {
            if ($params['status'] == 'reject') {
                $user_account->update(['email_verified_at' => Null]);
            } elseif ($params['status'] == 'approve') {
                $user_account->update(['email_verified_at' => date("Y-m-d H:i:s")]);
                $template = $notifyService->parseEmailTemplate('account_approved', $role, ['user_name' => $user_account->profile->full_name]);
                if (!empty($template))
                    $user_account->notify(new EmailNotification($template));
            }
        }
    }

    #[On('update-status')]
    public function updateStatus($params = [])
    {
        $response = isDemoSite();
        if ($response) {
            $this->dispatch('showAlertMessage', type: 'error', title: __('general.demosite_res_title'), message: __('general.demosite_res_txt'));
            return;
        }
        if (!empty($params['id'])) {
            $adminExists = User::whereHas('roles', function ($query) {
                $query->where('name', 'admin');
            })->where('id', $params['id'])->exists();

            if ($adminExists) {
                $this->dispatch('showAlertMessage', type: 'error', title: __('admin/general.error_title'), message: __('admin/general.not_allowed'));
                return;
            } else {
                $status = $params['type'] == 'active' ? 'inactive' : 'active';
                $user = User::find($params['id']);
                $user->status = $status;
                $user->save();
                $this->dispatch('showAlertMessage', type: 'success', title: __('general.success_title'), message: __('settings.status_updated_record'));
            }
        }
    }

    #[On('delete-user')]
    public function deleteUser($params = [])
    {
        $response = isDemoSite();
        if ($response) {
            $this->dispatch('showAlertMessage', type: 'error', title: __('general.demosite_res_title'), message: __('general.demosite_res_txt'));
            return;
        }
        if (!empty($params['id'])) {
            $adminExists = User::whereHas('roles', function ($query) {
                $query->where('name', 'admin');
            })->where('id', $params['id'])->exists();

            if ($adminExists) {
                $this->dispatch(
                    'showAlertMessage',
                    type: 'error',
                    message: __('admin/general.not_allowed')
                );
                return;
            } else {
                $user = User::find($params['id']);

                if (empty($user)) {
                    $this->dispatch(
                        'showAlertMessage',
                        type: 'error',
                        message: __('admin/general.no_record_exists')
                    );
                    return;
                }

                if ($user->role == 'tutor') {
                    $deletableUser = $user->whereDoesntHave('bookingSlots')->exists();
                } else {
                    $deletableUser = $user->whereDoesntHave('bookingOrders')->exists();
                }
                if ($deletableUser) {
                    DB::beginTransaction();
                    try {
                        $user->groups()->each(function ($group) {
                            $group->userSubjects()->each(function ($userSubject) {
                                $userSubject->slots()->delete();
                            });
                            $group->userSubjects()->delete();
                        });
                        $user->groups()->delete();
                        $user->accountSetting()->delete();
                        $user->identityVerification()->delete();
                        $user->reviews()->delete();
                        $user->address()->delete();
                        $user->educations()->delete();
                        $user->experiences()->delete();
                        $user->certificates()->delete();
                        $user->languages()->detach();
                        $user->withdrawals()->delete();
                        $user->userPayouts()->forceDelete();
                        $wallet = $user->wallet;
                        $profile = $user->profile;
                        $wallet?->walletDetail()->delete();
                        $wallet?->delete();
                        $user->favouriteUsers()->detach();
                        $user->favouriteByUsers()->detach();
                        $profile->forceDelete();
                        $user->delete();
                        DB::commit();
                        $this->dispatch(
                            'showAlertMessage',
                            type: 'success',
                            message: __('admin/general.delete_record')
                        );
                        return;
                    } catch (\Exception $e) {
                        DB::rollBack();
                        dd($e);
                        $this->dispatch(
                            'showAlertMessage',
                            type: 'error',
                            message: __('admin/general.processing_error_msg')
                        );
                        return;
                    }
                }
                $this->dispatch(
                    'showAlertMessage',
                    type: 'error',
                    message: __('admin/general.unable_to_delete_user')
                );
            }
        }
    }

    #[On('tutor-template')]
    public function tutorTemplate($params = [])
    {
        $response = isDemoSite();
        if ($response) {
            $this->dispatch('showAlertMessage', type: 'error', title: __('general.demosite_res_title'), message: __('general.demosite_res_txt'));
            return;
        }
    }

    #[On('verified-at-template')]
    public function verifiedAtTemplate($params = [])
    {
        $response = isDemoSite();
        if ($response) {
            $this->dispatch('showAlertMessage', type: 'error', title: __('general.demosite_res_title'), message: __('general.demosite_res_txt'));
            return;
        }

        $date = $params['type'] == 'verified' ? null : now();
        $userId = $params['id'] ?? null;
        if ($userId) {
            $user = User::find($userId);

            if ($user) {
                $user->update(['email_verified_at' => $date]);
                $this->dispatch('showAlertMessage', type: 'success', title: __('general.success_title'), message: __('settings.updated_record_success'));
            } else {
                throw new \Exception("User not found.");
            }
        } else {
            throw new \Exception("User ID is required.");
        }
    }



    public function addUser()
    {
        $this->form->updateInfo();
        $response = isDemoSite();
        if ($response) {
            $this->dispatch('showAlertMessage', type: 'error', title: __('general.demosite_res_title'), message: __('general.demosite_res_txt'));
            return;
        }
        $date = now();
        $user = User::create([
            'email'             => sanitizeTextField($this->form->email),
            'password'          => Hash::make($this->form->password),
            'email_verified_at' => $date,
        ]);
        $user->assignRole($this->form->userRole);

        $first_name    = $this->form->first_name;
        $last_name     = $this->form->last_name;
        $slug          = $first_name . ' ' . $last_name;

        $profile = Profile::create([
            'first_name'    => sanitizeTextField($first_name),
            'last_name'     => sanitizeTextField($last_name),
            'slug'          => sanitizeTextField($slug),
            'user_id'       => $user->id,
        ]);

        if ($user && $profile) {
            $notifyService = new NotificationService;
            $emailData = [
                'user_name'     => $user->profile->full_name,
                'user_email'    => $user->email,
                'user_password' => $this->form->password,
                'admin_name'    => Auth::user()->profile->full_name
            ];
            $template = $notifyService->parseEmailTemplate('user_created', $this->form->userRole, $emailData);
            if (!empty($template))
                $user->notify(new EmailNotification($template));
        }
        $this->dispatch('showAlertMessage', type: 'success', title: __('general.success_title'), message: __('settings.updated_record'));
        $this->dispatch('toggleModel', id: 'tb-add-user', action: 'hide');
        $this->resetInputfields();
    }
}
