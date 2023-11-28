<?php

namespace BiffBangPow\Theme\BaseTheme\Extension;

use SilverStripe\AssetAdmin\Forms\UploadField;
use SilverStripe\Assets\Image;
use SilverStripe\Forms\DropdownField;
use SilverStripe\Forms\EmailField;
use SilverStripe\Forms\FieldList;
use SilverStripe\Forms\HeaderField;
use SilverStripe\Forms\LiteralField;
use SilverStripe\Forms\NumericField;
use SilverStripe\Forms\TextareaField;
use SilverStripe\Forms\TextField;
use SilverStripe\ORM\DataExtension;
use SilverStripe\View\HTML;

/**
 * Class \BiffBangPow\Extension\SiteConfigExtension
 *
 * @property \SilverStripe\SiteConfig\SiteConfig|\BiffBangPow\Theme\BaseTheme\Extension\SiteConfigExtension $owner
 * @property string $SocialLinkedIn
 * @property string $SocialFacebook
 * @property string $SocialYoutube
 * @property string $SocialX
 * @property string $SocialInstagram
 * @property string $BrandColour
 * @property string $BrandLightColour
 * @property string $BrandTint
 * @property string $CompanyEmail
 * @property string $CompanyPhone
 * @property string $CompanyAddress
 * @property string $BodyFont
 * @property string $TitleFont
 * @property int $BaseFontSize
 * @property string $H1Size
 * @property string $H2Size
 * @property string $H3Size
 * @property string $H4Size
 * @property string $H5Size
 * @property string $H6Size
 * @property string $NavbarBackground
 * @property string $NavbarBackgroundScrolled
 * @property string $BurgerColour
 * @property string $BodyColour
 * @property string $BodyBackground
 * @property int $SocialIconSize
 * @property int $NavLogoID
 * @property int $FooterLogoID
 * @property int $HeroLogoID
 * @method \SilverStripe\Assets\Image NavLogo()
 * @method \SilverStripe\Assets\Image FooterLogo()
 * @method \SilverStripe\Assets\Image HeroLogo()
 */
class SiteConfigExtension extends DataExtension
{
    /**
     * @const array COLOURS
     * Contains the data columns we need to output in CSS colour vars
     */
    const CSS_VARS = [
        'BrandColour',
        'BrandLightColour',
        'BrandTint',
        'NavbarBackground',
        'NavbarBackgroundScrolled',
        'BurgerColour',
        'BodyColour',
        'BodyBackground'
    ];

    private static $db = [
        'SocialLinkedIn' => 'Varchar',
        'SocialFacebook' => 'Varchar',
        'SocialYoutube' => 'Varchar',
        'SocialX' => 'Varchar',
        'SocialInstagram' => 'Varchar',
        'BrandColour' => 'Varchar(8)',
        'BrandLightColour' => 'Varchar(8)',
        'BrandTint' => 'Varchar(30)',
        'CompanyEmail' => 'Varchar',
        'CompanyPhone' => 'Varchar',
        'CompanyAddress' => 'Text',
        'BodyFont' => 'Varchar',
        'TitleFont' => 'Varchar',
        'BaseFontSize' => 'Int',
        'H1Size' => 'Varchar(15)',
        'H2Size' => 'Varchar(15)',
        'H3Size' => 'Varchar(15)',
        'H4Size' => 'Varchar(15)',
        'H5Size' => 'Varchar(15)',
        'H6Size' => 'Varchar(15)',
        'NavbarBackground' => 'Varchar(30)',
        'NavbarBackgroundScrolled' => 'Varchar(30)',
        'BurgerColour' => 'Varchar(8)',
        'BodyColour' => 'Varchar(8)',
        'BodyBackground' => 'Varchar(8)',
        'SocialIconSize' => 'Int'
    ];
    private static $has_one = [
        'NavLogo' => Image::class,
        'FooterLogo' => Image::class,
        'HeroLogo' => Image::class
    ];
    private static $owns = [
        'NavLogo',
        'FooterLogo',
        'HeroLogo'
    ];
    private static $defaults = [
        'BaseFontSize' => 16,
        'H1Size' => '2.5rem',
        'H2Size' => '2rem',
        'H3Size' => '1.75rem',
        'H4Size' => '1.5rem',
        'H5Size' => '1.25rem',
        'H6Size' => '1rem',
        'BodyBackground' => '#ffffff',
        'BodyColour' => '#333333',
        'SocialIconSize' => 40
    ];
    private $fontDefs = [
        'alegreya' => 'Alegreya',
        'barlow' => 'Barlow',
        'cinzel' => 'Cinzel',
        'lexend' => 'Lexend',
        'libre-baskerville' => 'Libre Baskerville',
        'montserrat' => 'Montserrat',
        'nunito' => 'Nunito',
        'poppins' => 'Poppins',
        'ptsans' => 'PT Sans'
    ];

    public function updateCMSFields(FieldList $fields)
    {
        parent::updateCMSFields($fields);
        $fields->addFieldsToTab('Root.Social', [
            TextField::create('SocialLinkedIn', 'LinkedIn'),
            TextField::create('SocialFacebook', 'Facebook'),
            TextField::create('SocialYoutube', 'YouTube'),
            TextField::create('SocialX', 'X'),
            TextField::create('SocialInstagram', 'Instagram')
        ]);
        $fields->addFieldsToTab('Root.Contact', [
            HeaderField::create('Company contact info'),
            EmailField::create('CompanyEmail', 'Email'),
            TextField::create('CompanyPhone', 'Phone'),
            TextareaField::create('CompanyAddress', 'Address')
                ->setDescription('Used in the website footer')
        ]);
        $fields->addFieldsToTab('Root.Branding', [
            LiteralField::create('brandwarning',
                HTML::createTag(
                    'p',
                    ['class' => 'alert alert-warning'],
                    'Do not make changes to these settings without authorisation.  Incorrect values entered on this page can prevent the website from functioning!'
                )
            ),


            HeaderField::create('Logos'),
            UploadField::create('NavLogo', 'Main navbar logo')
                ->setAllowedFileCategories('image/supported')
                ->setFolderName('SiteAssets'),
            UploadField::create('FooterLogo', 'Footer logo')
                ->setAllowedFileCategories('image/supported')
                ->setFolderName('SiteAssets'),
            UploadField::create('HeroLogo', 'Hero logo')
                ->setAllowedFileCategories('image/supported')
                ->setFolderName('SiteAssets')
                ->setDescription('Used in hero elements where required'),
            NumericField::create('SocialIconSize', 'Size of social icons (px)')
                ->setHTML5(true),


            HeaderField::create('Fonts'),
            DropdownField::create('BodyFont', 'Body Font', $this->fontDefs),
            DropdownField::create('TitleFont', 'Title Font', $this->fontDefs),
            NumericField::create('BaseFontSize', 'Base Font Size')
                ->setDescription('This is normally 16 or greater')
                ->setHTML5(true),
            TextField::create('H1Size', 'H1 Font Size')
                ->setDescription('Specify in a standard CSS declaration (eg. 2.5rem)'),
            TextField::create('H2Size', 'H2 Font Size')
                ->setDescription('Specify in a standard CSS declaration (eg. 2rem)'),
            TextField::create('H3Size', 'H3 Font Size')
                ->setDescription('Specify in a standard CSS declaration (eg. 1.75rem)'),
            TextField::create('H4Size', 'H4 Font Size')
                ->setDescription('Specify in a standard CSS declaration (eg. 1.5rem)'),
            TextField::create('H5Size', 'H5 Font Size')
                ->setDescription('Specify in a standard CSS declaration (eg. 1.25rem)'),
            TextField::create('H6Size', 'H6 Font Size')
                ->setDescription('Specify in a standard CSS declaration (eg. 1rem)'),

            HeaderField::create('Site Colours'),
            TextField::create('BrandColour', 'Brand Colour')
                ->setDescription('Hex colour code for branding.'),
            TextField::create('BrandLightColour', 'Brand Light Colour')
                ->setDescription('Hex colour code for secondary branding'),
            TextField::create('BrandTint', 'Brand Tint Colour')
                ->setDescription('Enter the value as a full CSS declaration, eg. rgba(128,250,80,0.8)'),
            TextField::create('NavbarBackground', 'Navbar background colour')
                ->setDescription('Leave blank or enter "transparent" for transparent'),
            TextField::create('NavbarBackgroundScrolled', 'Navbar scrolled background colour')
                ->setDescription('Leave blank or enter "transparent" for transparent'),
            TextField::create('BurgerColour', 'Burger colour')
                ->setDescription('Colour of the burger nav (background will be set to the main brand colour)'),
            TextField::create('BodyBackground', 'Body background colour'),
            TextField::create('BodyColour', 'Body text colour'),
        ]);
    }

    /**
     * Get the branding colours for the site
     * @return array
     */
    public function getBrandCSSVars(): array
    {
        $colours = [];
        foreach (self::CSS_VARS as $columnName) {
            $key = strtolower($columnName);
            $value = $this->owner->{$columnName};
            $colours[$key] = $value;
        }

        //Annoying extras which don't fit the automation
        $colours['socialiconsize'] = $this->owner->SocialIconSize . 'px';

        return $colours;
    }

    /**
     * Get the font information for the site
     * @return array
     */
    public function getBrandFonts()
    {
        return [
            'basesize' => $this->owner->BaseFontSize . "px",
            'bodyfamily' => $this->owner->BodyFont,
            'bodyfamilyname' => $this->fontDefs[$this->owner->BodyFont] ?? '',
            'titlefamily' => $this->owner->TitleFont,
            'titlefamilyname' => $this->fontDefs[$this->owner->TitleFont] ?? '',
            'h1size' => $this->owner->H1Size,
            'h2size' => $this->owner->H2Size,
            'h3size' => $this->owner->H3Size,
            'h4size' => $this->owner->H1Size,
            'h5size' => $this->owner->H2Size,
            'h6size' => $this->owner->H3Size
        ];
    }

    /**
     * Get an arbitrary size for the social icon in the template to work with the CSS
     * @return float
     */
    public function getSocialIconImgSize() {
        return $this->owner->SocialIconSize * 0.6;
    }
}
