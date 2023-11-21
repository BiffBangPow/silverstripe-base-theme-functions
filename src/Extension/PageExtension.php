<?php

namespace BiffBangPow\Theme\BaseTheme\Extension;

use Page;
use SilverStripe\Forms\CheckboxField;
use SilverStripe\Forms\FieldList;
use SilverStripe\ORM\DataExtension;
use SilverStripe\ORM\DataList;

/**
 * Class \BiffBangPow\Theme\BaseTheme\Extension\PageExtension
 *
 * @property \Page|\BiffBangPow\Theme\BaseTheme\Extension\PageExtension $owner
 * @property bool $ShowInMainMenu
 * @property bool $ShowInFooterMenu
 */
class PageExtension extends DataExtension
{
    private static $db = [
        'ShowInMainMenu' => 'Boolean',
        'ShowInFooterMenu' => 'Boolean'
    ];

    /**
     * @param int $parentId
     * @return DataList
     */
    public function getMainMenu($parentId = 0)
    {
        return Page::get()
            ->filter([
                'ShowInMainMenu' => true,
                'ParentID' => $parentId
            ]);
    }

    /**
     * Get the children of the current page with the main menu option selected
     * @return mixed
     */
    public function getMenuChildren()
    {
        return $this->owner->Children()->filter([
            'ShowInMainMenu' => true
        ]);
    }


    /**
     * Get pages in the bottom footer
     * @return DataList
     */
    public function getFooterMenu()
    {
        return Page::get()->filter([
            'ShowInFooterMenu' => true
        ]);
    }

    public function updateCMSFields(FieldList $fields)
    {
        parent::updateCMSFields($fields);
        $fields->addFieldsToTab('Root.Menus', [
            CheckboxField::create('ShowInMainMenu'),
            CheckboxField::create('ShowInFooterMenu'),
        ]);
    }

    public function updateSettingsFields(FieldList $fields)
    {
        $fields->removeFieldFromTab('Root.Settings', 'ShowInMenus');
    }

}
