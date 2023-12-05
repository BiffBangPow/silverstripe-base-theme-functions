<?php

namespace BiffBangPow\Theme\BaseTheme\Control;

use DNADesign\Elemental\Controllers\ElementController;
use SilverStripe\View\Requirements;
use SilverStripe\View\ThemeResourceLoader;

/**
 * Class \BiffBangPow\Theme\BaseTheme\Control\TextAndVideoElementController
 *
 */
class TextAndVideoElementController extends ElementController
{
    public function init()
    {
        parent::init();
        $themeCSS = ThemeResourceLoader::inst()->findThemedCSS('client/dist/css/elements/textandvideo');
        if ($themeCSS) {
            Requirements::css($themeCSS, '', ['defer' => true]);
        }

        if ($this->element->VideoType === 'youtube') {
            $themeJS = ThemeResourceLoader::inst()->findThemedResource('node_modules/@justinribeiro/lite-youtube/lite-youtube.js');
            Requirements::javascript($themeJS, [
                'type' => 'module',
                'async' => true,
                'defer' => true
            ]);
        }
    }
}
