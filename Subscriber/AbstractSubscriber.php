<?php

namespace OstEmotion\Subscriber;

use Enlight\Event\SubscriberInterface;

/**
 * Description of AbstractSubscriber
 *
 */
abstract class AbstractSubscriber implements SubscriberInterface
{
    /**
     * ingenico plugin bootstrap class
     *
     * @var \Shopware_Plugins_Core_MoptIngenico_Bootstrap
     */
    protected $bootstrap;

    /**
     * set dependency
     *
     * @param \Shopware_Plugins_Core_MoptIngenico_Bootstrap $bootstrap
     */
    public function __construct($bootstrap)
    {
        $this->bootstrap = $bootstrap;
    }

    /**
     * return array with all subsribed events
     */
    public static function getSubscribedEvents()
    {
        return array();
    }

    /**
     * bootstrap getter
     *
     * @return \Shopware_Plugins_Core_MoptIngenico_Bootstrap
     */
    public function getBootstrap()
    {
        return $this->bootstrap;
    }
}
