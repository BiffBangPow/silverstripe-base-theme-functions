<?php

namespace BiffBangPow\Theme\BaseTheme\Extension;

use SilverStripe\Core\Extension;
use SilverStripe\View\Requirements;
use SilverStripe\View\ThemeResourceLoader;

class BlogPostControllerExtension extends Extension
{
    public function onAfterInit()
    {
        $blogCSS = ThemeResourceLoader::inst()->findThemedCSS('client/dist/css/blog/post.css');
        if ($blogCSS) {
            Requirements::css($blogCSS);
        }
    }
}
