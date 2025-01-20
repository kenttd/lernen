<main class="tb-main tb-mainbg">
    <div class="row">
        <div class="col-lg-12 col-md-12">
            <div class="tb-dhb-mainheading">
                <h4> {{ __('general.all_users') .' ('. $users->total() .')'}}</h4>
                <div class="tb-sortby">
                    <form class="tb-themeform tb-displistform">
                        <fieldset>
                            <div class="tb-themeform__wrap">
                                <div class="tb-actionselect">
                                    <a href="javascript:void(0)" id="add_user_click" class="tb-btn add-new"
                                        data-bs-toggle="modal" data-bs-target="#tb-add-user">{{__('general.add_new_user')}}
                                        <i class="icon-plus"></i></a>
                                </div>
                                <div class="tb-actionselect" wire:ignore>
                                    <div class="tb-select">
                                        <select data-componentid="@this" class="am-select2 form-control"
                                            data-searchable="false" data-live='true' id="verification"
                                            data-wiremodel="verification">
                                            <option value="" {{ $verification=='' ? 'selected' : '' }}>{{ __('All users') }}
                                            </option>
                                            <option value="verified" {{ $verification=='verified' ? 'selected' : '' }}>{{
                                                __('Verified users') }}</option>
                                            <option value="unverified" {{ $verification=='non_verified' ? 'selected' : ''
                                                }}>{{ __('Non verified users') }}</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="tb-actionselect" wire:ignore>
                                    <div class="tb-select">
                                        <select data-componentid="@this" class="am-select2 form-control"
                                            data-searchable="false" data-live='true' id="filter_user"
                                            data-wiremodel="filterUser">
                                            <option value="" {{ $filterUser=='' ? 'selected' : '' }}>{{ __('All users') }}
                                            </option>
                                            <option value="active" {{ $filterUser=='active' ? 'selected' : '' }}>{{
                                                __('Active') }}</option>
                                            <option value="inactive" {{ $filterUser=='inactive' ? 'selected' : '' }}>{{
                                                __('Inactive') }}</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="tb-actionselect" wire:ignore>
                                    <div class="tb-select">
                                        <select data-componentid="@this" class="am-select2 form-control"
                                            data-searchable="false" data-live='true' id="roles" data-wiremodel="roles">
                                            <option value="" {{ $roles=='' ? 'selected' : '' }}>{{ __('All users') }}
                                            </option>
                                            <option value="student" {{ $roles=='student' || $role=='student' ? 'selected' : '' }}>{{
                                                __('general.student') }}</option>
                                            <option value="tutor" {{ $roles=='tutor' || $role=='tutor' ? 'selected' : '' }}>{{
                                                __('general.tutor') }}</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="tb-actionselect" wire:ignore>
                                    <div class="tb-select">
                                        <select data-componentid="@this" class="am-select2 form-control"
                                            data-searchable="false" data-live='true' id="sort_by" data-wiremodel="sortby">
                                            <option value="asc" {{ $sortby=='asc' ? 'selected' : '' }}>{{ __('general.asc')
                                                }}</option>
                                            <option value="desc" {{ $sortby=='desc' ? 'selected' : '' }}>{{
                                                __('general.desc') }}</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="form-group tb-inputicon tb-inputheight">
                                    <i class="icon-search"></i>
                                    <input type="text" class="form-control" wire:model.live.debounce.500ms="search"
                                        autocomplete="off" placeholder="{{ __('general.search') }}">
                                </div>
                            </div>
                        </fieldset>
                    </form>
                </div>
            </div>
            <div class="tb-disputetable">
                @if( !$users->isEmpty() )
                <table class="table tb-table tb-dbholder @if(setting('_general.table_responsive') == 'yes') tb-table-responsive @endif">
                    <thead>
                        <tr>
                            <th>{{ __('#' )}}</th>
                            <th>{{ __('Name' )}}</th>
                            <th>{{ __('general.email' )}}</th>
                            <th>{{ __('general.created_date' )}}</th>
                            <th>{{__('admin/general.role')}}</th>
                            <th>{{ __('general.verification' )}}</th>
                            <th>{{__('general.status')}}</th>
                            <th>{{__('general.actions')}}</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($users as $single)
                        <tr>
                            <td data-label="{{ __('#' )}}"><span>{{ $single->id }}</span></td>
                            <td data-label="{{ __('Name' )}}">
                                <div class="tb-varification_userinfo">
                                    <strong class="tb-adminhead__img">
                                        @if (!empty($single->profile->image) &&
                                        Storage::disk('public')->exists($single->profile->image))
                                        <img src="{{ resizedImage($single->profile->image,34,34) }}"
                                            alt="{{$single->profile->image}}" />
                                        @else
                                        <img src="{{ resizedImage('placeholder.png',34,34) }}"
                                            alt="{{ $single->profile->image }}" />
                                        @endif
                                    </strong>
                                    <span>{{ $single->profile->full_name }}</span>
                                    @if($single->roles()->first()->name == 'tutor')
                                        <a href="{{ route('tutor-detail',['slug' => $single->profile->slug]) }}" class="am-custom-tooltip">
                                            <span class="am-tooltip-text">
                                                <span>{{ __('general.visit_profile') }}</span>
                                            </span>
                                            <i class="icon-external-link"></i>
                                        </a>
                                    @endif
                                </div>
                            </td>
                            <td data-label="{{ __('general.email' )}}"><span>{{ $single->email }}</span></td>
                            <td data-label="{{ __('general.created_date' )}}"><span>{{ $single->created_at->format('F d,
                                    Y')}}</span></td>
                            <td data-label="{{ __('admin/general.role') }}">
                                {{ ucfirst( $single->roles()->first()->name ) }}
                            </td>
                            @php
                                $verified_at = $single->email_verified_at ? "verified" : "non_verified";
                                $content = $single->email_verified_at ? __('general.reject_account') : __('general.approve_this_account');
                            @endphp
                            <td @click="$wire.dispatch('showConfirm', { id : {{ $single->id }}, content: '{{ $content }}', type: '{{ $verified_at }}', action : 'verified-at-template' })" data-label="{{ __('general.verification') }}">
                                <a href="javascript:;"
                                   class="tb-email-verifiedbtn tk-project-tag"
                                   @if (!$single->email_verified_at)
                                       disabled
                                   @endif>
                                    <i class="icon-mail"></i>
                                    {{ $single->email_verified_at ? "Verified" : "Non verified" }}
                                </a>
                            </td>
                            <td @click="$wire.dispatch('showConfirm', { id : {{ $single->id }}, content: `{{ $single->status == 'active' ? __('general.disable_user') : __('general.enable_user') }}`, type: '{{ $single->status }}', action : 'update-status' })"
                                data-label="{{__('general.status')}}">
                                <em class="tk-project-tag {{  $single->status == 'active' ? 'tk-hourly-tag' : 'tk-fixed-tag' }}">{{
                                    $single->status}}</em>
                            </td>
                            <td  data-label="{{__('general.actions')}}">
                                <div class="am-custom-tooltip">
                                    <span class="am-tooltip-text">
                                        <span>{{__('general.remove_user')}}</span>
                                    </span>
                                    <i @click="$wire.dispatch('showConfirm', { id : {{ $single->id }}, content: '{{ __('general.delete_user') }}', action : 'delete-user' })" class="icon-trash-2"></i>
                                </div> 
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
                {{ $users->links('pagination.custom') }}
                @else
                    <x-no-record :image="asset('images/empty.png')"  :title="__('general.no_record_title')"/>
                @endif
            </div>
        </div>
        <div wire:ignore.self class="modal fade tb-addonpopup" id="tb-add-user" aria-labelledby="tb_user_info_label"
            role="dialog" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered modal-lg tb-modaldialog" role="document">
                <div class="modal-content">
                    <div class="tb-popuptitle">
                        <h5 id="tb_user_info_label">{{__('general.user_information')}}</h5>
                        <a href="javascript:void(0);" class="close"><i class="icon-x" data-bs-dismiss="modal"></i></a>
                    </div>
                    <div class="modal-body">
                        <form class="tb-themeform" wire:submit.prevent="addUser" id="add_user_form">
                            <fieldset>
                                <div class="form-group-wrap">
                                    <div class="form-group">
                                        <label class="tb-label">{{__('general.first_name')}}</label>
                                        <input type="text"
                                            class="form-control @error('form.first_name') tk-invalid @enderror"
                                            wire:model="form.first_name" placeholder="{{__('general.name_placeholder')}}">
                                        @error('form.first_name')
                                        <div class="tk-errormsg">
                                            <span>{{$message}}</span>
                                        </div>
                                        @enderror
                                    </div>
                                    <div class="form-group">
                                        <label class="tb-label">{{__('general.last_name')}}</label>
                                        <input type="text"
                                            class="form-control @error('form.last_name') tk-invalid @enderror"
                                            wire:model="form.last_name"
                                            placeholder="{{__('general.lastname_placeholder')}}">
                                        @error('form.last_name')
                                        <div class="tk-errormsg">
                                            <span>{{$message}}</span>
                                        </div>
                                        @enderror
                                    </div>
                                    <div class="form-group">
                                        <label class="tb-label">{{__('general.email')}}</label>
                                        <input type="text" class="form-control @error('form.email') tk-invalid @enderror"
                                            wire:model="form.email" placeholder="{{__('general.email_placeholder')}}">
                                        @error('form.email')
                                        <div class="tk-errormsg">
                                            <span>{{$message}}</span>
                                        </div>
                                        @enderror
                                    </div>
                                    <div class="form-group">
                                        <label class="tb-label">{{__('User role')}}</label>
                                        <div class="tk-error @error('form.userRole') tk-invalid @enderror">
                                            <div class="tb-select" wire:ignore>
                                                <select data-componentid="@this" class="am-select2 form-control"
                                                    data-searchable="false" data-parent="#tb-add-user" data-live='true'
                                                    id="user_role" data-wiremodel="form.userRole">
                                                    <option value="tutor">{{__('general.tutor')}}</option>
                                                    <option value="student">{{__('general.student')}}</option>
                                                </select>
                                            </div>
                                        </div>
                                        @error('form.userRole')
                                        <div class="tk-errormsg">
                                            <span>{{$message}}</span>
                                        </div>
                                        @enderror
                                    </div>
                                    <div class="form-group">
                                        <label class="tb-label">{{__('general.password')}}</label>
                                        <input type="password" wire:model="form.password"
                                            class="form-control @error('form.password') tk-invalid @enderror"
                                            placeholder="{{__('general.password_placeholder')}}">
                                        @error('form.password')
                                        <div class="tk-errormsg">
                                            <span>{{$message}}</span>
                                        </div>
                                        @enderror
                                    </div>
                                    <div class="form-group">
                                        <label class="tb-label">{{__('general.confirm_password')}}</label>
                                        <input type="password" wire:model="form.confirm_password"
                                            class="form-control @error('form.confirm_password') tk-invalid @enderror"
                                            placeholder="{{__('general.password_placeholder')}}">
                                        @error('form.confirm_password')
                                        <div class="tk-errormsg">
                                            <span>{{$message}}</span>
                                        </div>
                                        @enderror
                                    </div>
                                    <div class="form-group tb-formbtn">
                                        <button class="tb-btn" type="submit" wire:target="addUser"
                                            wire:loading.class="am-btn_disable">{{__('general.save_user')}}</button>
                                    </div>
                                </div>
                            </fieldset>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</main>
