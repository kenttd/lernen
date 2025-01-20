<?php

namespace App\Livewire\Pages\Admin\Packages;

use App\Models\Addon;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use Livewire\Attributes\Layout;
use Livewire\Component;
use Livewire\WithFileUploads;

class ManagePackages extends Component
{
    use WithFileUploads;
    public $file;
    
    #[Layout('layouts.admin-app')]
    public function render()
    {
        $activePackages = Addon::where('status', 'active')->pluck('slug')->toArray();
        $packages = $this->getAddonsLists();
        foreach($packages as $package => $detail){
            if(File::isDirectory(base_path('packages/' . $package))) {
                if(File::exists(base_path('packages/' . $package . '/addon.json'))){
                    $addonDetail = json_decode(file_get_contents(base_path('packages/' . $package . '/addon.json')), true);
                    $packages[$package]['version'] = !empty($addonDetail['version']) ? $addonDetail['version'] : 'N/A';
                    $packages[$package]['status'] = !empty($addonDetail['status']) ? $addonDetail['status'] : 'N/A';
                }
            }
        }
        return view('livewire.pages.admin.packages.manage-packages', compact('packages', 'activePackages'));
        
    }
    
    public function addNewPackage()
    {
        $this->dispatch('toggleModel', id: 'addNewPackageModal', action: 'show');
    }
    
    private function getAddonsLists()
    {
       return json_decode(file_get_contents(base_path('addons.json')), true);
    }

    public function uploadAddon()
    {
        ini_set('memory_limit', '1024M');
        ini_set('max_execution_time', 3000);
        ini_set('max_input_time', 3000);
        ini_set('post_max_size', '1024M');
        ini_set('upload_max_filesize', '1024M');
        ini_set('max_input_vars', 10000);
        ini_set('max_file_uploads', 100);
        ini_set('max_execution_time', 3000);
        ini_set('max_input_time', 3000);
        ini_set('max_input_vars', 10000);
        $this->validate([
            'file' => 'required|file|mimes:zip',
        ]);
        $response = isDemoSite();
        if( $response ){
            $this->dispatch('showAlertMessage', type: 'error', title:  __('general.demosite_res_title') , message: __('general.demosite_res_txt'));
            return;
        }

        $packageName = pathinfo($this->file->getClientOriginalName(), PATHINFO_FILENAME);
        $packageInfo = $this->getAddonsLists()[$packageName];
        if(empty($packageInfo)){
            $this->dispatch('showAlertMessage', type: 'error' , message:__('admin/general.add_on_not_found'));
            return; 
        }
        $status = $this->replacePluginFile($this->file);
        $this->reset('file');
        // Convert $status to an array if it's not already
        $logContext = is_array($status) ? $status : ['status' => $status];
        Log::info('Package Status', $logContext);
        if($status){
            $this->dispatch('showAlertMessage', type: 'success' , message:__('admin/general.addon_installed_successfully'));
        } else {
            $this->dispatch('showAlertMessage', type: 'error' , message:__('admin/general.addon_installing_error'));
        }
        $this->dispatch('toggleModel', id: 'addNewPackageModal', action: 'hide');
    }

    private function replacePluginFile($file)
    {
        $packageName = pathinfo($file->getClientOriginalName(), PATHINFO_FILENAME);
        $packageInfo = $this->getAddonsLists()[$packageName];
        try{
        
            $uploadedPackage = Storage::disk('local')->putFile($file);
            $getLatestUpdateFile = storage_path('app/' . $uploadedPackage);

            // Create a backup of the current package
            $backupPath = storage_path('app/package_backups');
            if (!File::isDirectory($backupPath)) {
                File::makeDirectory($backupPath, 0755, true);
            }

            $currentPackagePath = base_path('packages/' . $packageName);
            $backupPackagePath = $backupPath . '/' . $packageName . '_backup';

            // Simple copy of the existing package
            if (File::isDirectory($currentPackagePath)) {
                File::copyDirectory($currentPackagePath, $backupPackagePath);
            }

            $zipArchive = new \ZipArchive();
            $zipArchive->open($getLatestUpdateFile);
            $zipExtracted = $zipArchive->extractTo(base_path('packages/'));
            $addonConfig = [];

            if ($zipExtracted) {
                if (File::isDirectory(base_path('packages/__MACOSX'))) {
                    File::deleteDirectory(base_path('packages/__MACOSX'));
                }

                $zipArchive->close();
                //changing working directory to root
                chdir(base_path());

                // Read and execute scripts from addon.json
                $addonJsonPath = base_path('packages/' . $packageName . '/addon.json');

                if (File::exists($addonJsonPath)) {
                    $addonConfig = json_decode(File::get($addonJsonPath), true);
                }

                // Update composer.json with the new repository
                if (!empty($addonConfig['repository']['name']) && !empty($addonConfig['repository']['url'])) {
                    $repositoryName = $addonConfig['repository']['name'];
                    $repositoryUrl = $addonConfig['repository']['url'];
                    $this->updateComposerJson($repositoryName, $repositoryUrl);
                }

                //removing existing package
                exec("composer remove " . $packageInfo['package'] . ' 2>&1', $output, $returnVar);

                //installing new package
                exec("composer require " . $packageInfo['package'] . ' 2>&1', $output, $returnVar);

                @unlink(storage_path('app/' . $uploadedPackage));
                if (File::isDirectory($backupPackagePath)) {
                    File::deleteDirectory($backupPackagePath);
                }

                if (!empty($addonConfig['scripts']) && is_array($addonConfig['scripts'])) {
                    foreach ($addonConfig['scripts'] as $script) {
                        exec($script.' 2>&1', $output, $returnVar);
                    }
                }
                
                return true;
            }
        }
        catch (\Exception $e) {
            Log::error($e->getMessage());
            if (File::isDirectory($backupPackagePath) && $packageInfo['status'] == 'active') {
                File::deleteDirectory($currentPackagePath);
                File::copyDirectory($backupPackagePath, $currentPackagePath);
            } 
            return false;
        }
    }

    public function updateComposerJson($repositoryName, $repositoryUrl)
    {
        $composerJsonPath = base_path('composer.json');
                    
        if (!file_exists($composerJsonPath)) {
            Log::error('composer.json file not found!');
            return false;
        }

        $composerJsonContent = file_get_contents($composerJsonPath);
        $composerArray = json_decode($composerJsonContent, true);

        if (is_null($composerArray)) {
            Log::error('Failed to decode composer.json');
            return false;
        }

        // Add or update the repositories section
        $composerArray['repositories'][$repositoryName] = [
            "type" => "path",
            "url" => $repositoryUrl,
        ];

        $newComposerJsonContent = json_encode($composerArray, JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES);

        if (file_put_contents($composerJsonPath, $newComposerJsonContent) === false) {
            Log::error('Failed to write to composer.json');
            return false;
        }

        Log::info('composer.json updated successfully!');
    }
}
