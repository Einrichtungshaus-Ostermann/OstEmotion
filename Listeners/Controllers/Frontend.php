<?php

namespace OstEmotion\Listeners\Controllers;

use Enlight_Event_EventArgs as EventArgs;
use OstEmotion\Services\EmotionService;

class Frontend
{
    protected $emotionService;
	protected $viewDir;

	public function __construct(EmotionService $emotionService, $viewDir)
	{
        $this->emotionService = $emotionService;
		$this->viewDir        = $viewDir;
	}

    public function onPreDispatch(EventArgs $arguments)
    {
        $controller = $arguments->get('subject');
        $view = $controller->View();
        $view->addTemplateDir($this->viewDir);
    }

    public function onPostDispatch(EventArgs $args )
    {
        $controller = $args->get( "subject" );
        $request    = $controller->Request();
        $view       = $controller->View();
        if ($request->getControllerName() !== 'forms') {
            return;
        }
        $formId = $request->getParam('sFid');
        $emotions = $this->emotionService->get($formId);

        $view->assign("ostEmotions", $emotions);
    }
}
