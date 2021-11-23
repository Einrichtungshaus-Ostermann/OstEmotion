<?php

namespace OstEmotion\Setup;

use Shopware\Components\Plugin;
use Shopware\Components\Plugin\Context\InstallContext;
use Shopware\Components\Model\ModelManager;
use Shopware\Bundle\AttributeBundle\Service\CrudService;


class Install
{
    protected $plugin;
    protected $context;
    protected $modelManager;
    protected $crudService;

    public function __construct( Plugin $plugin, InstallContext $context, ModelManager $modelManager, CrudService $crudService )
    {
        $this->plugin       = $plugin;
        $this->context      = $context;
        $this->modelManager = $modelManager;
        $this->crudService  = $crudService;
    }

    public function install()
    {
        $this->installAttributes();
    }

    private function installAttributes()
    {
        $this->crudService->update(
            "s_emotion_attributes",
            "ost_emotion_forms",
            "combobox",
            [
                'label'            => "In Formularen anzeigen",
                'helpText'         => "Wo soll diese Einkaufswelt auf Formularen angezeigt werden?",
                'translatable'     => false,
                'position'         => 260,
                'arrayStore'       => [
                    ['key' => '0', 'value' => 'Nicht anzeigen'],
                    ['key' => '1', 'value' => 'Über dem Formular'],
                    ['key' => '2', 'value' => 'Unter dem Formular']
                ],
                'displayInBackend' => true,
                'custom'           => false
            ]
        );

        $this->crudService->update(
            "s_emotion_attributes",
            "ost_emotion_forms_id",
            "string",
            [
                'label'            => "Formular ID",
                'helpText'         => "Auf welcherm Formular soll diese Einkaufswelt angezeigt werden? Sollte keine ID angegeben werden, dann wird diese Einkaufswelt auf jedem Formular angezeigt.",
                'translatable'     => false,
                'position'         => 265,
                'displayInBackend' => true,
                'custom'           => false
            ]
        );

        $this->modelManager->generateAttributeModels(array( "s_emotion_attributes"));
    }
}
