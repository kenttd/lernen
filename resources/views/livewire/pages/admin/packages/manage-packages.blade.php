<div class="container">
    <div class="row">
        <div class="col-12">
            <div class="cards">
                <div class="cards_header">
                    <div class="cards_header_heading">
                        <h4>{{ __('admin/general.lernen_addons') }}</h4>
                        <p>{{ __('admin/general.lernen_addons_desc') }}</p>
                    </div>
                    <div class="cards_header_btns">
                        <button class="tb-btn" wire:click="addNewPackage">{{ __('admin/general.add_new') }}</button>
                    </div>
                </div>
                <div class="cards_wrap">
                    <ul>
                        @foreach ($packages as $package)
                        <li>
                            <div class="cards_item {{ $package['type'] == 'pro' ? 'cards_item-purchase' : '' }}">
                                <figure>
                                    <img src="{{ asset('addons/'.$package['image']) }}" alt="{{ $package['name'] }}">
                                </figure>
                                <div class="cards_item_content">
                                    <h5>
                                        {{ $package['name'] }} 
                                        <span>{{ ucfirst($package['type']) }}</span>
                                        @if($package['type'] == 'pro' && $package['status'] != 'coming soon' && !empty($package['demo_url']))
                                            <em>{{ $package['price'] }}</em>
                                        @endif
                                    </h5>
                                    <p>{{ $package['description'] }}</p>
                                    <div class="cards_item_btns">
                                        @if($package['type'] == 'pro' && $package['status'] == 'active' && $package['version'] == 'lite')
                                            <a class="tb-btnvtwo" href="{{ $package['demo_url'] }}" target="_blank">{{ __('admin/general.upgrade') }}</a>
                                        @elseif($package['type'] == 'pro' && $package['status'] == 'inactive')
                                            <a class="tb-btnvtwo" href="{{ $package['demo_url'] }}" target="_blank">{{ __('admin/general.buy_now') }}</a>
                                        @elseif($package['status'] == 'active' && !empty($package['demo_url']))
                                            <a class="tb-btnvtwo" href="{{ $package['demo_url'] }}" target="_blank">{{ __('admin/general.preview') }}</a>
                                        @elseif($package['status'] == 'coming soon' || empty($package['demo_url']))
                                            <button class="tb-btnvtwo btn-coming-soon" disabled>{{ __('admin/general.coming_soon') }}</button>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        </li>
                        @endforeach
                    </ul>
                </div>
            </div>
        </div>
    </div>
    <div class="modal fade tb-fileupload-modal" data-bs-backdrop="static" id="addNewPackageModal" tabindex="-1" aria-labelledby="fileUploadModalLabel" aria-hidden="true" wire:ignore.self>
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="tb-popuptitle">
                    <h5 class="modal-title" id="fileUploadModalLabel">{{ __('admin/general.upload_package_file') }}</h5>
                    <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close"><i class="icon-x"></i></button>
                </div>
                <div class="modal-body">
                    <form wire:submit.prevent="uploadAddon">
                        <div class="mb-3">
                            <label for="file" class="tb-label">{{ __('admin/general.choose_file') }}</label>
                            <input type="file" class="form-control" id="file" wire:model="file" accept=".zip">
                            @error('file') <span class="text-danger">{{ $message }}</span> @enderror
                        </div>
                        <li wire:loading wire:target="file" style="display: none" class="tb-uploading">
                            <span>{{ __('settings.uploading') }}</span>
                        </li>
                        <div class="modal-footer">
                            <button type="submit" class="tb-btn" wire:loading.class="am-btn_disable" wire:target="uploadAddon">{{ __('admin/general.install') }}</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
