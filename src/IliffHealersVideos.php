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
            $this->addAction('init', 'registerPostType');
        }
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
            'supports'            => ['title', 'editor', 'thumbnail', 'revisions'],
            'menu_icon'           => 'dashicons-format-' . $singular,
            'has_archive'         => $singular . 's',
            'capability_type'     => 'page',
            'exclude_from_search' => false,
            'hierarchical'        => false,
            'public'              => true,
            'show_ui'             => true,
            'show_in_menu'        => true,
            'show_in_admin_bar'   => true,
            'show_in_nav_menus'   => true,
            'can_export'          => true,
            'publicly_queryable'  => true,
            'show_in_rest'        => true,
            'menu_position'       => 5,
        ];
        
        register_post_type($singular, $args);
    }
}
