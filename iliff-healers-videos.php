<?php

/**
 * Plugin Name: Iliff+Healers Videos
 * Description: A custom post type and associated support for the Iliff+Healers Initiative videos.
 * Author URI: mailto:dashifen@dashifen.com
 * Author: David Dashifen Kees
 * Version: 2.0.0
 */

use Dashifen\IliffHealersVideos\IliffHealersVideos;
use Dashifen\WPHandler\Handlers\HandlerException;

if (!class_exists('Dashifen\IliffHealersVideos\IliffHealersVideos')) {
  require_once 'vendor/autoload.php';
}

(function() {
    try {
        $videos = new IliffHealersVideos();
        $videos->initialize();
    } catch (HandlerException $e) {
        wp_die($e->getMessage());
    }
})();
