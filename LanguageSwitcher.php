<?php
/**
 * @copyright Copyright (c) Klaus Mergen
 * @license http://opensource.org/licenses/BSD-3-Clause
 */

namespace kmergen;

use Yii;
use yii\base\Widget;
use yii\helpers\Url;

/**
 * Simple Language Switcher Widget
 *
 * To use this widget you may use and configure yii2-localeurls to get the active languages
 * @see https://github.com/codemix/yii2-localeurls
 *
 * @author Klaus Mergen <kmergenweb@gmail.com>
 */
class LanguageSwitcher extends Widget
{

    /**
     * @var string The structure of the parent template.
     * Possible placeholders:
     *  - ativeItem,
     *  - items
     */
    public $parentTemplate = '<ul>{activeItem}{items}</ul>';

    /**
     * @var string The structure of one entry in the list of language elements.
     * Possible placeholders:
     *  - url
     *  - label
     *  - language
     */
    public $itemTemplate = '<li><a href="{url}" title="{label}"><i class="{language}"></i> {label}</a></li>';

    /**
     * @var string The structure of the active language element.
     * Possible placeholders:
     *  - url,
     *  - label
     *  - language
     */
    public $activeItemTemplate = '<li><a href="{url}" title="{label}"><i class="{language}"></i> {label}</a></li>';


    private static $_labels;
    private $_isError;
    private $_items = [];

    public function init()
    {
        $this->registerTranslations();

        $route = Yii::$app->controller->route;
        $appLanguage = Yii::$app->language;
        $params = $_GET;
        $this->_isError = $route === Yii::$app->errorHandler->errorAction;

        array_unshift($params, '/' . $route);

        foreach (Yii::$app->urlManager->languages as $language) {
            $isWildcard = substr($language, -2) === '-*';
            if (
                $language === $appLanguage ||
                // Also check for wildcard language
                $isWildcard && substr($appLanguage, 0, 2) === substr($language, 0, 2)
            ) {
                continue;   // Exclude the current language
            }
            if ($isWildcard) {
                $language = substr($language, 0, 2);
            }
            $params['language'] = $language;
            $this->_items[] = [
                'label' => self::label($language),
                'code' => $language,
                'url' => $params,
            ];
        }
    }

    public function run()
    {
        // Only show this widget if we're not on the error page
        if ($this->_isError) {
            return '';
        } else {
            return $this->renderTemplate();
        }
    }

    public function registerTranslations()
    {
        $i18n = Yii::$app->i18n;
        $i18n->translations['langswitch'] = [
            'class' => 'yii\i18n\PhpMessageSource',
            'basePath' => '@vendor/kmergen/yii2-language-switcher/messages',
            'sourceLanguage' => 'en',
        ];
    }

    /**
     * Rendering the language item template.
     * @return string
     */
    protected function renderTemplate()
    {
        $currentLanguage = [
            'code' => Yii::$app->language,
            'label' => self::label(Yii::$app->language),
            'url' => '#'
        ];
        $activeItem = $this->renderItem($currentLanguage, $this->activeItemTemplate);

        $items = '';
        foreach ($this->_items as $language) {
            $items .= $this->renderItem($language, $this->itemTemplate);
        }

        return strtr($this->parentTemplate, ['{activeItem}' => $activeItem, '{items}' => $items]);
    }

    /**
     * Rendering languege element.
     * @param string $language The unique identifier of a given language (de, en, etc.).
     * @param string $label The label of a language.
     * @param string $template The basic structure of a language element of the displayed language picker
     * Elements to replace: "{link}" URL to call when changing language.url
     *  "{label}" label corresponding to a language element, e.g.: English
     *  "{language}" unique identifier of the language element. e.g.: en, en-US
     * @return string the rendered result
     */
    protected function renderItem($language, $template)
    {
        return strtr($template, [
            '{url}' => Url::to($language['url']),
            '{label}' => $language['label'],
            '{language}' => $language['code'],
        ]);
    }

    public static function label($code)
    {
        if (self::$_labels === null) {
            self::$_labels = [
            'en' => Yii::t('langswitch', 'English'),
            'us' => Yii::t('langswitch', 'English'),
            'es' => Yii::t('langswitch', 'Spanish'),
            'de' => Yii::t('langswitch', 'German'),
            'fr' => Yii::t('langswitch', 'French'),
            'it' => Yii::t('langswitch', 'Italian'),
            'pt' => Yii::t('langswitch', 'Portuguese'),
            'pl' => Yii::t('langswitch', 'Polish'),
            'nl' => Yii::t('langswitch', 'Dutch'),
            'ru' => Yii::t('langswitch', 'Russian'),
            'hi' => Yii::t('langswitch', 'Hindi'),
            'ar' => Yii::t('langswitch', 'Arabic'),
            'fa' => Yii::t('langswitch', 'Persian'),
            'ja' => Yii::t('langswitch', 'Japanese'),
            'ko' => Yii::t('langswitch', 'Korean'),
            'vi' => Yii::t('langswitch', 'Vietnamese'),
            'zh-CN' => Yii::t('langswitch', 'Chinese'),
            'cs' => Yii::t('langswitch','Czech'),
            'el' => Yii::t('langswitch','Greek'),
            'sv' => Yii::t('langswitch','Swedish'),
            'id' => Yii::t('langswitch','Indonesian'),
            'th' => Yii::t('langswitch','Thai'),
            ];
        }

        return isset(self::$_labels[$code]) ? self::$_labels[$code] : null;
    }

}
