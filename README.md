# Yii 2 Language Switcher
Yii2 extension for simple and flexible language switching via a given template

The preferred way to install this extension is through [composer](https://getcomposer.org/).

Either run

```bash
composer require "kmergen/yii2-language-switcher": "*"
```

or add

```
"kmergen/yii2-language-switcher": "*",
```

to the `require` section of your `composer.json` file.

## Usage


### Simple list
```php
echo \kmergen\LanguageSwitcher::widget([

]);
```
### Bootstrap dropdown Menu
```php
echo \kmergen\LanguageSwitcher::widget([
                   'parentTemplate' => '<nav class="navbar-nav nav">
                    <li class="dropdown">{activeItem}
                        <ul class="dropdown-menu">{items}</ul>
                     </li>   
                 </nav>',
                 'activeItemTemplate' => '<a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">{label} <span class="caret"></span></a>',
                 'itemTemplate' => '<li><a href="{url}">{label}</a></li>'
            ]);
```


### Bootstrap dropdown Menu with flags
```php
echo \kmergen\LanguageSwitcher::widget([
                   'parentTemplate' => '<nav class="navbar-nav nav">
                    <li class="dropdown">{activeItem}
                        <ul class="dropdown-menu">{items}</ul>
                     </li>   
                 </nav>',
                 'activeItemTemplate' => '<a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false"><i class="flag flag-{language}"></i> {label} <span class="caret"></span></a>',
                 'itemTemplate' => '<li><a href="{url}"><i class="flag flag-{language}"></i> {label}</a></li>'
            ]);
```
> In the assets folder of this extension are a flags.png and a flags.css file which you can implement in your project template. We do not register these assets directly with the extension to keep it as flexible as possible. 

> Note: This widget get the languages from the extension [Yii2 LocaleUrls](https://github.com/codemix/yii2-localeurls/). Therefore you may configure localeUrls first before
you run the widget.
 

