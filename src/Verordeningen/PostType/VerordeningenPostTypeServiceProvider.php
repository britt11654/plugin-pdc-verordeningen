<?php
/**
 * Provider which handles registration of posttype.
 */

namespace OWC\PDC\Verordeningen\PostType;

use OWC\PDC\Base\Foundation\ServiceProvider;
use OWC\PDC\Verordeningen\Shortcode\ShortcodeServiceProvider;

/**
 * Provider which handles registration of posttype.
 */
class VerordeningenPostTypeServiceProvider extends ServiceProvider
{

    /**
     * Prefix of the posttype.
     *
     * @var string $prefix
     */
    protected $prefix = '_pdc-verordening';

    /**
     * Name of posttype.
     *
     * @var string $postType
     */
    protected $postType = 'pdc-verordeningen';

    /**
     * Register the service provider.
     *
     * @return void
     */
    public function register()
    {
        $this->plugin->loader->addAction('init', $this, 'registerPostType');
    }

    /**
     * Register the Verordeningen posttype.
     *
     * @return void
     */
    public function registerPostType()
    {

        if (! function_exists('register_extended_post_type')) {
            require_once($this->plugin->getRootPath() . '/src/Verordeningen/vendor/johnbillion/extended-cpts/extended-cpts.php');
        }

        $labels = [
            'name'               => _x('Verordeningen', 'post type general name', 'pdc-verordeningen'),
            'singular_name'      => _x('Verordening', 'post type singular name', 'pdc-verordeningen'),
            'menu_name'          => _x('Verordeningen', 'admin menu', 'pdc-verordeningen'),
            'name_admin_bar'     => _x('Verordeningen', 'add new on admin bar', 'pdc-verordeningen'),
            'add_new'            => _x('Add new Verordening', 'Verordening', 'pdc-verordeningen'),
            'add_new_item'       => __('Add new Verordening', 'pdc-verordeningen'),
            'new_item'           => __('New Verordening', 'pdc-verordeningen'),
            'edit_item'          => __('Edit Verordening', 'pdc-verordeningen'),
            'view_item'          => __('View Verordening', 'pdc-verordeningen'),
            'all_items'          => __('All Verordeningen', 'pdc-verordeningen'),
            'search_items'       => __('Search Verordeningen', 'pdc-verordeningen'),
            'parent_item_colon'  => __('Parent Verordeningen:', 'pdc-verordeningen'),
            'not_found'          => __('No Verordeningen found.', 'pdc-verordeningen'),
            'not_found_in_trash' => __('No Verordeningen found in Trash.', 'pdc-verordeningen')
        ];

        $args = [
            'labels'             => $labels,
            'description'        => __('PDC Verordeningen', 'pdc-verordeningen'),
            'public'             => false,
            'publicly_queryable' => false,
            'show_ui'            => true,
            'show_in_menu'       => true,
            'query_var'          => true,
            'capability_type'    => 'post',
            'has_archive'        => false,
            'hierarchical'       => false,
            'menu_position'      => 5,
            'supports'           => ['title'],
            'show_in_feed'       => false,
            'archive'            => false,
            'admin_cols'         => [
                'link'        => [
                    'title'    => __('Verordening link', 'pdc-verordeningen'),
                    'meta_key' => "{$this->prefix}-link",
                ],
                'new-link'    => [
                    'title'    => __('Verordening new link', 'pdc-verordeningen'),
                    'meta_key' => "{$this->prefix}-new-link",
                ],
                'active-date'  => [
                    'title'       => __('Date new Verordening active', 'pdc-verordeningen'),
                    'meta_key'    => "{$this->prefix}-active-date",
                    'date_format' => 'd/m/Y'
                ],
                'code-preview' => [
                    'title'    => __('Verordening shortcode', 'pdc-verordeningen'),
                    'function' => function () {
                        echo ShortcodeServiceProvider::generateShortcode(get_the_ID());
                    }
                ],
                'published'    => [
                    'title'       => __('Published', 'pdc-verordeningen'),
                    'post_field'  => 'post_date',
                    'date_format' => 'd M Y'
                ]
            ],
        ];

        return register_extended_post_type($this->postType, $args, $labels);
    }
}
