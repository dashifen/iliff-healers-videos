<?php

namespace Dashifen\IliffHealersVideos;

use Dashifen\WPHandler\Handlers\HandlerException;
use Dashifen\WPHandler\Handlers\Plugins\AbstractPluginHandler;

class IliffHealersVideos extends AbstractPluginHandler
{
    /**
     * initialize
     *
     * Uses addAction and addFilter to connect WordPress to the protected
     * methods of this object
     *
     * @return void
     * @throws HandlerException
     */
    public function initialize(): void
    {
        if (!$this->isInitialized()) {
            $this->registerActivationHook('activate');
            $this->addAction('init', 'registerPostType', 8);
            $this->addAction('init', 'registerTaxonomy', 9);
            
            if (self::isDebug()) {
                flush_rewrite_rules();
            }
            
        }
    }
    
    /**
     * activate
     *
     * Fired when the plugin is activated.
     *
     * @return void
     */
    protected function activate(): void
    {
        $this->registerPostType();
        $this->registerTaxonomy();
        flush_rewrite_rules();
    }
    
    
    /**
     * registerPostType
     *
     * Registers the video post type.
     *
     * @return void
     */
    protected function registerPostType(): void
    {
        $plural = 'Videos';
        $singular = 'Video';
        
        $labels = [
            'singular_name'         => $singular,
            'name'                  => $plural,
            'menu_name'             => $singular . 's',
            'name_admin_bar'        => $singular,
            'archives'              => $singular . ' Archives',
            'attributes'            => $singular . ' Attributes',
            'parent_item_colon'     => 'Parent ' . $singular . ':',
            'all_items'             => 'All ' . $plural,
            'add_new_item'          => 'Add New ' . $singular,
            'add_new'               => 'Add New',
            'new_item'              => 'New ' . $singular,
            'edit_item'             => 'Edit ' . $singular,
            'update_item'           => 'Update ' . $singular,
            'view_item'             => 'View ' . $singular,
            'view_items'            => 'Vide ' . $plural,
            'search_items'          => 'Search ' . $singular,
            'not_found'             => 'Not found',
            'not_found_in_trash'    => 'Not found in Trash',
            'featured_image'        => 'Feature Image',
            'set_featured_image'    => 'Set featured image',
            'remove_featured_image' => 'Remove featured image',
            'use_featured_image'    => 'Use as featured image',
            'insert_into_item'      => 'Add to this ' . $singular,
            'uploaded_to_this_item' => 'Uploaded to this ' . $singular,
            'items_list'            => $plural . ' list',
            'items_list_navigation' => $plural . ' list navigation',
            'filter_items_list'     => 'Filter ' . $plural . ' list',
        ];
        $args = [
            'label'               => $singular,
            'labels'              => $labels,
            'description'         => $singular . 's within the Iliff+Healers Initiative',
            'supports'            => ['title', 'editor', 'excerpt', 'thumbnail', 'revisions'],
            'menu_icon'           => 'dashicons-video-alt',
            'capability_type'     => 'page',
            'exclude_from_search' => false,
            'hierarchical'        => false,
            'has_archive'         => true,
            'public'              => true,
            'show_ui'             => true,
            'show_in_menu'        => true,
            'show_in_admin_bar'   => true,
            'show_in_nav_menus'   => true,
            'can_export'          => true,
            'publicly_queryable'  => true,
            'show_in_rest'        => true,
            'menu_position'       => 5,
            'rewrite'             => [
                'slug' => 'videos',
            ],
        ];
        
        register_post_type('iliff-video', $args);
    }
    
    /**
     * registerTaxonomy
     *
     * Registers the topic taxonomy.
     *
     * @return void
     */
    protected function registerTaxonomy(): void
    {
        $plural = 'Topics';
        $singular = 'Topic';
        
        $labels = [
            'name'                       => $plural,
            'singular_name'              => $singular,
            'menu_name'                  => $plural,
            'all_items'                  => 'All ' . $plural,
            'parent_item'                => 'Parent ' . $singular,
            'parent_item_colon'          => 'Parent ' . $singular . ':',
            'new_item_name'              => 'New ' . $singular . ' Name',
            'add_new_item'               => 'Add New ' . $singular,
            'edit_item'                  => 'Edit ' . $singular,
            'update_item'                => 'Update ' . $singular,
            'view_item'                  => 'View ' . $singular,
            'separate_items_with_commas' => 'Separate ' . $plural . ' with commas',
            'add_or_remove_items'        => 'Add or remove ' . $plural . '',
            'choose_from_most_used'      => 'Choose from the most used ' . $plural,
            'popular_items'              => 'Popular ' . $plural,
            'search_items'               => 'Search ' . $plural,
            'not_found'                  => 'Not Found',
            'no_terms'                   => 'No ' . $plural,
            'items_list'                 => $plural . ' list',
            'items_list_navigation'      => $plural . ' list navigation',
        ];
        
        $args = [
            'labels'            => $labels,
            'show_tagcloud'     => false,
            'hierarchical'      => false,
            'public'            => true,
            'show_ui'           => true,
            'show_admin_column' => true,
            'show_in_nav_menus' => true,
            'show_in_rest'      => true,
        ];
        
        register_taxonomy('iliff-video-topic', ['iliff-video'], $args);
    }
    
    /**
     * locateVideoTemplate
     *
     * When WP core identifies that we need to load up a template for the
     * post type or taxonomy in this plugin, this method takes over and returns
     * the correct file.
     *
     * @param string $template
     *
     * @return string
     */
    protected function locateVideoTemplate(string $template): string
    {
        // first, we'll identify the three situations in which we want to mess
        // with our template.  in each of these (tiny) blocks, we define the
        // $filename variable.  if none of these cases are true, then we return
        // the original template and we're done.
        
        if (is_post_type_archive('iliff-video')) {
            $filename = 'archive-iliff-video.php';
        } elseif (is_singular('iliff-video')) {
            $filename = 'single-iliff-video.php';
        } elseif (is_tax('iliff-video-topix')) {
            $filename = 'taxonomy-iliff-video-topic.php';
        } else {
            return $template;
        }
        
        // if we didn't return in the else-block, then we must be have a file
        // to locate.  if locate_template can find us a template file of the
        // appropriate name in our theme (it probably won't) then we use it.
        // but, since it probably won't, we'll return a path to the deafult
        // plugin file thereafter.
        
        $template = locate_template($filename);
        
        if ($template === '') {
            $template = trailingslashit($this->getPluginDir()) . 'templates/' . $filename;
        }
        
        return $template;
    }
}
