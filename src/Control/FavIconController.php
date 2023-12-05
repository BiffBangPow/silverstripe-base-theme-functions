<?php

namespace BiffBangPow\Theme\BaseTheme\Control;

use SilverStripe\Control\Controller;
use SilverStripe\SiteConfig\SiteConfig;


class FavIconController extends Controller
{
    public function index()
    {
        $siteConfig = SiteConfig::current_site_config();
        $favicon = $siteConfig->hasMethod('FavIconImage') && $siteConfig->FavIconImage()->exists() ? $siteConfig->FavIconImage() : false;

        if ($favicon) {
            $this->getResponse()->addHeader('Content-Type', 'image/x-icon');
            return $favicon->Fit(16,16)->getString();
        }
    }
}
