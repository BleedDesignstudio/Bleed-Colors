<?php
namespace Craft;

class BleedColorsPlugin extends BasePlugin
{
    public function getName()
    {
         return Craft::t('Bleed Colors');
    }

    public function getVersion()
    {
        return '0.9';
    }

    public function getDescription()
    {
        return 'A WIP plugin for misc. color treatment';
    }

    public function getDeveloper()
    {
        return 'Bleed Designstudio';
    }

    public function getDeveloperUrl()
    {
        return 'http://bleed.com/';
    }

    public function getDocumentationUrl()
    {
        return 'https://github.com/BleedDesignstudio/Bleed-Colors/blob/master/readme.md';
    }

    public function hasCpSection()
    {
        return false;
    }

    public function addTwigExtension()
    {
        Craft::import('plugins.bleedcolors.twigextensions.BleedColorsTwigExtension');

        return new BleedColorsTwigExtension();
    }
}
