<?php

namespace OstEmotion\Subscriber;

use OstEmotion\Services\EmotionService;

/**
 * subscriber for checkout related hooks and events
 *
 */
class Forms extends AbstractSubscriber
{
    protected $emotionService;

    public function __construct(EmotionService $emotionService)
    {
        $this->emotionService = $emotionService;
    }

    /**
     * return array with all subsribed events
     *
     * @return array
     */
    public static function getSubscribedEvents()
    {
        return array(
            'Enlight_Controller_Action_PostDispatchSecure_Frontend_Forms' => 'onPostDispatchFrontendForms',
        );
    }

    /**
     * apply status message/description to view on confirm action
     *
     * @param \Enlight_Event_EventArgs $args
     * @return mixed
     */
    public function onPostDispatchFrontendForms(\Enlight_Event_EventArgs $args)
    {
        $controller = $args->get("subject");
        $view = $controller->View();

        $emotions = $this->emotionService->get('forms', 'sFid');
        var_dump($emotions);die;
        $view->assign("ostEmotions", $emotions);
    }
}
