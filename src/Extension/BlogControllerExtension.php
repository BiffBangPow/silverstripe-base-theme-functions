<?php

namespace BiffBangPow\Theme\BaseTheme\Extension;

use SilverStripe\Core\Extension;
use DNADesign\Elemental\TopPage\DataExtension;
use SilverStripe\View\Requirements;
use SilverStripe\View\ThemeResourceLoader;

class BlogControllerExtension extends Extension
{
    public function onAfterInit()
    {
        $blogCSS = ThemeResourceLoader::inst()->findThemedCSS('client/dist/css/blog/main.css');
        if ($blogCSS) {
            Requirements::css($blogCSS);
        }
    }
}
