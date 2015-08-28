<?php

use Herbie\DI;
use Herbie\Hook;
use michelf\Smartypants;

include_once (__DIR__ . '/vendor/Michelf/SmartyPants.php');

class SmartypantsPlugin
{

    /** @var array */
    protected static $config;

    public static function install()
    {
        // default config
        $defaults = DI::get('Config')->get('plugins.config.smartypants', []);
        static::$config = array_merge([
            'twig_filter' => 1,
            'process_title' => 1,
            'process_content' => true,
            'options' => 'qDew'
        ], $defaults);

        if (!empty(static::$config['twig_filter'])) {
            Hook::attach('twigInitialized', ['SmartypantsPlugin', 'addTwigFilter']);
        }
        if (!empty(static::$config['process_title'])) {
            Hook::attach('pageLoaded', ['SmartypantsPlugin', 'filterPageTitle']);
        }
        if (!empty(static::$config['process_content'])) {
            Hook::attach('renderContent', ['SmartypantsPlugin', 'renderContent']);
        }
    }

    public static function addTwigFilter($twig)
    {
        $filter = new Twig_SimpleFilter('smartypants', ['SmartypantsPlugin', 'smartypantsFilter'], ['is_safe' => ['html']]);
        $twig->addFilter($filter);
    }

    public static function filterPageTitle($page)
    {
        // overwrite config with page config
        if (!empty($page->smartypants) && is_array($page->smartypants)) {
            static::$config = array_merge(static::$config, $page->smartypants);
        }
        // check again because page config
        if (!empty(static::$config['process_title'])) {
            $page->title = SmartyPants::defaultTransform($page->title, static::$config['options']);
        }
    }

    public static function smartypantsFilter($content, $options = null)
    {
        $options = empty(static::$config['options']) ? : $options;
        return SmartyPants::defaultTransform($content, $options);
    }

    public static function renderContent($content)
    {
        // check again because page config
        if (!empty(static::$config['process_content'])) {
            return SmartyPants::defaultTransform($content, static::$config['options']);
        }
        return $content;
    }

}

SmartypantsPlugin::install();
