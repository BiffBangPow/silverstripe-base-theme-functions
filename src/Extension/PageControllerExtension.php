<?php

namespace BiffBangPow\Theme\BaseTheme\Extension;

use SilverStripe\Core\Manifest\ModuleResourceLoader;
use SilverStripe\ORM\DataExtension;
use SilverStripe\ORM\FieldType\DBHTMLText;
use SilverStripe\View\ArrayData;
use SilverStripe\View\Requirements;
use SilverStripe\View\SSViewer;
use SilverStripe\View\ThemeResourceLoader;

/**
 * Class \BiffBangPow\Theme\BaseTheme\Extension\PageControllerExtension
 *
 * @property \PageController|\BiffBangPow\Theme\BaseTheme\Extension\PageControllerExtension $owner
 */
class PageControllerExtension extends DataExtension
{
    public function onBeforeInit()
    {
        $this->addBrandCSS();
        $this->addFontCSSDefs();
        $this->addBaseRequirements();
    }

    /**
     * Add the base CSS and JS for the theme
     * @return void
     */
    private function addBaseRequirements()
    {
        Requirements::css(
            ThemeResourceLoader::inst()->findThemedCSS('client/dist/css/core'),
            '',
            ['inline' => true]
        );
        Requirements::css(
            ThemeResourceLoader::inst()->findThemedCSS('client/dist/css/common'),
            '',
            ['push' => true]
        );


        $llJS = ThemeResourceLoader::inst()->findThemedJavascript('client/dist/javascript/lazyload_config');
        if ($llJS) {
            Requirements::javascript(
                $llJS,
                ['inline' => true, 'type' => false]
            );
        }

        $coreJS = ThemeResourceLoader::inst()->findThemedJavascript('client/dist/javascript/core.js');
        if ($coreJS) {
            Requirements::javascript(
                $coreJS,
                ['inline' => true, 'type' => false]
            );
        }

        $commonJS = ThemeResourceLoader::inst()->findThemedJavascript('client/dist/javascript/common.js');
        if ($commonJS) {
            Requirements::javascript(
                $commonJS,
                ['type' => false, 'async' => true, 'defer' => true]
            );
        }
    }

    /**
     * Add the font CSS files to the stack
     * @return void
     */
    private function addFontCSSDefs()
    {
        $siteConfig = $this->owner->getSiteConfig();
        $fonts = $siteConfig->getBrandFonts();

        $bodyFont = $fonts['bodyfamily'] ?? false;
        $titleFont = $fonts['titlefamily'] ?? false;

        if ($bodyFont) {
            $bodyFontDef = ThemeResourceLoader::inst()->findThemedCSS('client/dist/css/fonts/' . $bodyFont);
            if ($bodyFontDef) {
                Requirements::css($bodyFontDef);
            }
        }
        if ($titleFont && ($titleFont !== $bodyFont)) {
            $titleFontDef = ThemeResourceLoader::inst()->findThemedCSS('client/dist/css/fonts/' . $titleFont);
            if ($titleFontDef) {
                Requirements::css($titleFontDef);
            }
        }
    }

    /**
     * Set up and add the inline CSS variables
     * @return void
     */
    private function addBrandCSS()
    {
        $siteConfig = $this->owner->getSiteConfig();
        $cssVars = $siteConfig->getBrandCSSVars();
        $fonts = $siteConfig->getBrandFonts();
        $brandCSS = ':root { ';

        $cssTemplate = '--brand-%s: %s; ';

        foreach ($fonts as $varName => $varValue) {
            $brandCSS .= sprintf($cssTemplate, $varName, $varValue);
        }


        foreach ($cssVars as $varName => $varValue) {
            $brandCSS .= sprintf($cssTemplate, $varName, $varValue);
        }

        $brandCSS .= ' }';

        Requirements::customCSS($brandCSS, 'branding');
    }

    /**
     * See if any social links are present
     * @return bool
     */
    public function getHasSocial()
    {
        $conf = $this->owner->getSiteConfig();
        return ($conf->SocialLinkedIn || $conf->SocialFacebook || $conf->SocialYouTube || $conf->SocialX || $conf->SocialInstagram);
    }

    /**
     * @param $resource
     * @return string|null
     */
    public function FindThemedResource($resource): ?string
    {
        $path = ThemeResourceLoader::inst()->findThemedResource($resource, SSViewer::get_themes());
        return ($path) ? ModuleResourceLoader::singleton()->resolveURL($path) : null;
    }

    /**
     * @return DBHTMLText|null
     */
    public function getFaviconMarkup(): ?\SilverStripe\ORM\FieldType\DBHTMLText
    {
        $output = null;

        $siteConfig = $this->owner->SiteConfig();
        $favicon = $siteConfig->hasMethod('FavIconImage') && $siteConfig->FavIconImage()->exists() ? $siteConfig->FavIconImage() : false;

        if ($favicon) {
            $output = ArrayData::create([
                'Favicon' => $favicon
            ])->renderWith('Includes/Favicon');
        }

        return $output;
    }

}
