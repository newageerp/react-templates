<?php

namespace Newageerp\SfReactTemplates\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Newageerp\SfBaseEntity\Controller\OaBaseController;
use Newageerp\SfReactTemplates\Event\LoadTemplateEvent;
use Newageerp\SfReactTemplates\Template\Placeholder;

/**
 * @Route(path="/app/nae-core/react-templates/")
 */
class ReactTemplatesController extends OaBaseController
{

    /**
     * @Route(path="get/{templateName}", methods={"POST"})
     */
    public function getTemplates(Request $request): Response
    {
        $request = $this->transformJsonBody($request);
        
        $templatesData = $request->get('data');
        $templateName = $request->get('templateName');

        $placeholder = new Placeholder();

        $event = new LoadTemplateEvent($placeholder, $templateName, $templatesData);
        $this->getEventDispatcher()->dispatch($event, LoadTemplateEvent::NAME);

        return $this->json(['data' => $placeholder->toArray(), 'success' => 1]);
    }
}
