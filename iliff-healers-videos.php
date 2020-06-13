<?php

/**
 * Plugin Name: Iliff+Healers Videos
 * Description: A custom post type and associated support for the Iliff+Healers Initiative videos.
 * Author URI: mailto:dashifen@dashifen.com
 * Author: David Dashifen Kees
 * Version: 1.0.0
 *
 * @noinspection PhpStatementHasEmptyBodyInspection
 * @noinspection PhpIncludeInspection
 */

use Dashifen\IliffHealersVideos\IliffHealersVideos;
use Dashifen\IliffHealersVideos\Agents\FieldGroupAgent;
use Dashifen\WPHandler\Agents\Collection\Factory\AgentCollectionFactory;
use Dashifen\WPHandler\Handlers\HandlerException;

if (file_exists($autoloader = dirname(ABSPATH) . '/deps/vendor/autoload.php'));
elseif ($autoloader = file_exists(dirname(ABSPATH) . '/vendor/autoload.php'));
elseif ($autoloader = file_exists(ABSPATH . 'vendor/autoload.php'));
else $autoloader = 'vendor/autoload.php';
require_once $autoloader;

(function() {
    try {
        $videos = new IliffHealersVideos();
        $agentFactory = new AgentCollectionFactory();
        $agentFactory->registerAgent(FieldGroupAgent::class);
        $videos->setAgentCollection($agentFactory);
        $videos->initialize();
    } catch (HandlerException $e) {
        wp_die($e->getMessage());
    }
})();
