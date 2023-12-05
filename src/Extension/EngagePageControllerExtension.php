<?php

namespace BiffBangPow\Theme\BaseTheme\Extension;

use SilverStripe\ORM\DataExtension;
use SilverStripe\View\Requirements;
use SilverStripe\View\ThemeResourceLoader;

/**
 * Class \BiffBangPow\Theme\BaseTheme\Extension\EngagePageControllerExtension
 *
 * @property \BiffBangPow\JobBoard\Control\JobsPageController|\BiffBangPow\Theme\BaseTheme\Extension\EngagePageControllerExtension $owner
 */
class EngagePageControllerExtension extends DataExtension
{
    public function onAfterinit()
    {
        $themeCSS = ThemeResourceLoader::inst()->findThemedCSS('client/dist/css/engage/engage');
        if ($themeCSS) {
            Requirements::css($themeCSS);
        }
    }
}
