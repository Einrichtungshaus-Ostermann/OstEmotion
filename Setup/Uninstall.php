<?php

namespace OstEmotion\Setup;

use Shopware\Components\Plugin;
use Shopware\Components\Plugin\Context\UninstallContext;
use Shopware\Components\Model\ModelManager;
use Shopware\Bundle\AttributeBundle\Service\CrudService;


class Uninstall
{
    protected $plugin;
    protected $context;
    protected $modelManager;
    protected $crudService;

    public function __construct( Plugin $plugin, UninstallContext $context, ModelManager $modelManager, CrudService $crudService )
    {
        $this->plugin       = $plugin;
        $this->context      = $context;
        $this->modelManager = $modelManager;
        $this->crudService  = $crudService;
    }

    public function uninstall()
    {
        $this->uninstallAttributes();
    }

    private function uninstallAttributes()
    {
        $this->crudService->delete( "s_emotion_attributes", "ost_emotion_forms" );
        $this->crudService->delete( "s_emotion_attributes", "ost_emotion_forms_id" );

        $this->modelManager->generateAttributeModels( array( "s_emotion_attributes" ) );
    }

}
