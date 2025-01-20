<?php

namespace App\Http\Controllers\Admin;
use ScssPhp\ScssPhp\Compiler;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Log;

class GeneralController extends Controller
{

    public function updateSaas(){
        $theme_pri_color        = setting('_theme.theme_pri_color');
        $theme_sec_color        = setting('_theme.theme_sec_color');
        $theme_footer_bg        = setting('_theme.theme_footer_bg');
        $text_light_color       = setting('_theme.text_light_color');
        $text_white_color       = setting('_theme.text_white_color');
        $heading_color          = setting('_theme.heading_color');

        try{

            $compiler = new Compiler();
            $compiler->setSourceMap(Compiler::SOURCE_MAP_FILE);
            $source_scss    = public_path('scss/main.scss');
            $import_path    = public_path('scss/');
            $scss_content   = file_get_contents($source_scss);
            $target_css     = public_path('css/main.css');
            $compiler->addImportPath($import_path);

            $variables  = array(
                '$theme-color'                  => !empty($theme_pri_color) ? $theme_pri_color              : '#295C51',
                '$secondary-color'              => !empty($theme_sec_color) ? $theme_sec_color              : '#FAF8F5',
                '$text-light'                   => !empty($text_light_color) ? $text_light_color            : '#585858',
                '$heading-font-color'           => !empty($heading_color) ? $heading_color                  : 'rgba(#000,0.7)',
                '$footer-color'                 => !empty($theme_footer_bg) ? $theme_footer_bg              : '#065A46',
                '$clr-white'                    => !empty($text_white_color) ? $text_white_color            : '#fff',
            );

            $compiler->setSourceMapOptions([
                'sourceMapURL'      => 'main.css.map',
                'sourceMapFilename' => $target_css,
            ]);

            $compiler->addVariables($variables);
            $result  =  $compiler->compileString($scss_content);
            if( !empty($result->getCss()) ){
                file_put_contents(public_path('css/main.css.map'), $result->getSourceMap());
                file_put_contents($target_css, $result->getCss());
            }
        }catch (\Exception $e) {
            Log::info($e);
        }
    }
}
