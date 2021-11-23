<?php

namespace OstEmotion;

use Shopware\Components\Plugin;
use Shopware\Components\Plugin\Context;
use Symfony\Component\DependencyInjection\ContainerBuilder;



class OstEmotion extends Plugin
{
    public function build( ContainerBuilder $container )
    {
        $container->setParameter( "ost_emotion.plugin_dir", $this->getPath() . "/" );
        $container->setParameter( "ost_emotion.view_dir", $this->getPath() . "/Resources/views/" );

        parent::build( $container );
    }

    public function activate( Context\ActivateContext $context )
    {
        $context->scheduleClearCache( $context::CACHE_LIST_ALL );
    }

    public function install( Context\InstallContext $context )
    {
        $installer = new Setup\Install(
            $this,
            $context,
            $this->container->get( "models" ),
            $this->container->get( "shopware_attribute.crud_service" )
        );
        $installer->install();

        parent::install( $context );
    }

    public function uninstall( Context\UninstallContext $context )
    {
        $uninstaller = new Setup\Uninstall(
            $this,
            $context,
            $this->container->get( "models" ),
            $this->container->get( "shopware_attribute.crud_service" )
        );
        $uninstaller->uninstall();

        $context->scheduleClearCache( $context::CACHE_LIST_ALL );

        parent::uninstall( $context );
    }



}
