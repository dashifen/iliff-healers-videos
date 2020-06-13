<?php

namespace Dashifen\IliffHealersVideos\Agents;

use Dashifen\WPHandler\Handlers\Plugins\PluginHandlerInterface;
use Dashifen\ACFAgent\FieldGroupAgent as BaselineFieldGroupAgent;

class FieldGroupAgent extends BaselineFieldGroupAgent
{
    /**
     * FieldGroupAgent constructor.
     *
     * @param PluginHandlerInterface $handler
     */
    public function __construct(PluginHandlerInterface $handler)
    {
        $folder = trailingslashit($handler->getPluginDir()) . 'assets/acf';
        parent::__construct($handler, $folder);
    }
}
