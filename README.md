# Modern ACF Options

![Latest Stable Version](https://img.shields.io/packagist/v/log1x/modern-acf-options?style=flat-square)
![Total Downloads](https://img.shields.io/packagist/dt/log1x/modern-acf-options?style=flat-square)

Here lives a simple `mu-plugin` to modernize and brand theme options created with ACF. No admin panels, no bloat – just a simple filter to optionally customize the CSS properties with your color palette.

![Screenshot](https://i.imgur.com/2ULki9H.png)

## Requirements

- [PHP](https://secure.php.net/manual/en/install.php) >= 7.1.3
- [Composer](https://getcomposer.org/download/)

## Installation

### Bedrock

Install via Composer:

```bash
$ composer require log1x/modern-acf-options
```

### Manual

Download the release `.zip` and install into `wp-content/plugins`.

## Usage

The styling for Modern ACF Options requires the usage of `seamless` mode and tabs with their placement set to `left`.

### Example using ACF Builder

```php
use StoutLogic\AcfBuilder\FieldsBuilder;

acf_add_options_page([
    'page_title' => get_bloginfo('name'),
    'menu_title' => 'Theme Options',
    'menu_slug' => 'theme-options',
    'update_button' => 'Update Options',
    'capability' => 'edit_theme_options',
    'position' => '999',
    'autoload' => true,
]);

$options = new FieldsBuilder('theme_options', [
    'style' => 'seamless',
]);

$options
    ->setLocation('options_page', '==', 'theme-options');

$options
    ->addTab('general')
        ->setConfig('placement', 'left')

        ->addAccordion('customization')
          ->addImage('logo')

        ->addAccordion('tracking')
            ->addText('gtm')
                ->setConfig('label', 'Google Tag Manager')
        ->addAccordion('tracking_end')->endpoint()

    ->addTab('advanced')
        ->setConfig('placement', 'left')

        ->addTrueFalse('debug')
          ->setConfig('ui', '1');

acf_add_local_field_group($options->build());
```

## Customization

To customize the color palette, simply pass an array containing one or more of the colors you would like to change to the `acf_color_palette` filter:

```php
add_filter('acf_color_palette', function () {
    return [
        'brand' => '#0073aa',
        'trim' => '#181818',
    ];
});
```

### Disabling Screen Options Tab

```php
use Illuminate\Support\Str;

/**
 * Disable Screen Options on the theme options page.
 *
 * @param  bool       $show
 * @param  \WP_Screen $screen
 * @return bool
 */
add_filter('screen_options_show_screen', function ($show, $screen) {
    if (is_a($screen, 'WP_Screen') && Str::contains($screen->base, 'theme-options')) {
        return false;
    }
}, 1, 2);
```

### Remove Admin Footer Text

```php
/**
 * Remove admin footer text.
 *
 * @return bool
 */
add_filter('admin_footer_text', '__return_false', 100);
```

## Development

Modern ACF Options is built using TailwindCSS and compiled with Laravel Mix.

```bash
$ yarn install
$ yarn run start
```

### Todo

- Continue optimizing/cleaning up existing styles.
- Add styles for ACF switches, input fields (focus, hover), buttons, etc.

## Bug Reports

If you discover a bug in Modern ACF Options, please [open an issue](https://github.com/log1x/modern-acf-options/issues).

## Contributing

Contributing whether it be through PRs, reporting an issue, or suggesting an idea is encouraged and appreciated.

## License

Modern ACF Options is provided under the [MIT License](https://github.com/log1x/modern-acf-options/blob/master/LICENSE.md).
