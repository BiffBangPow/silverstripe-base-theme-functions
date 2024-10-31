<?php

namespace BiffBangPow\Theme\BaseTheme\Extension;

use SilverStripe\ORM\DataExtension;
use SilverStripe\View\Requirements;
use SilverStripe\View\ThemeResourceLoader;

class BlogPostControllerExtension extends DataExtension
{
    public function onAfterInit()
    {
        $blogCSS = ThemeResourceLoader::inst()->findThemedCSS('client/dist/css/blog/post.css');
        if ($blogCSS) {
            Requirements::css($blogCSS);
        }
    }
}
