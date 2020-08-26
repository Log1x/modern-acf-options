<?php

/**
 * Plugin Name: Modern ACF Options
 * Plugin URI:  https://github.com/log1x/modern-acf-options
 * Description: Modern styling for ACF Theme Options.
 * Version:     1.0.3
 * Author:      Brandon Nifong
 * Author URI:  https://github.com/log1x
 * Licence:     MIT
 */

add_action('init', new class
{
    /**
     * The plugin URI.
     *
     * @var string
     */
    protected $uri;

    /**
     * The plugin path.
     *
     * @var string
     */
    protected $path;

    /**
     * The ACF Options color palette.
     *
     * @var array
     */
    protected $colors = [
        'brand' => '#0073aa',
        'trim' => '#181818',
    ];

    /**
     * Invoke the plugin.
     *
     * @return void
     */
    public function __invoke()
    {
        $this->uri = plugin_dir_url(__FILE__) . 'public';
        $this->path = plugin_dir_path(__FILE__) . 'public';

        $this->colors = array_merge(
            $this->colors,
            apply_filters('acf_color_palette', $this->colors)
        );

        if (! function_exists('acf')) {
            return;
        }

        $this->injectColors();
        $this->enqueue();
    }

    /**
     * Enqueue the admin scripts.
     *
     * @return void
     */
    public function enqueue()
    {
        add_action('admin_enqueue_scripts', function () {
            wp_enqueue_style('modern-acf/acf.css', $this->asset('/css/acf.css'), false, null);
        }, 100);
    }

    /**
     * Resolve the URI for an asset using the manifest.
     *
     * @param  string $asset
     * @param  string $manifest
     * @return string
     */
    public function asset($asset = '', $manifest = 'mix-manifest.json')
    {
        if (! file_exists($manifest = $this->path . $manifest)) {
            return $this->uri . $asset;
        }

        $manifest = json_decode(file_get_contents($manifest), true);

        return $this->uri . ($manifest[$asset] ?? $asset);
    }

    /**
     * Inject the color properties into the admin head.
     *
     * @param  array $colors
     * @return void
     */
    public function injectColors($colors = [])
    {
        if (! is_array($this->colors)) {
            return;
        }

        foreach ($this->colors as $label => $value) {
            $colors[] = "--acf-{$label}: {$value};";
        }

        $this->colors = implode(' ', $colors);

        add_filter('admin_head', function () {
            echo "<style>:root { {$this->colors} }</style>", PHP_EOL;
        });
    }
});
