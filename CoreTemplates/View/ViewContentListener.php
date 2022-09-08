<?php

namespace Newageerp\SfReactTemplates\CoreTemplates\View;

use Newageerp\SfReactTemplates\Event\LoadTemplateEvent;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;

class ViewContentListener implements EventSubscriberInterface
{
    public function onTemplate(LoadTemplateEvent $event)
    {
        if ($event->isTemplateForAnyEntity('PageMainView')) {
            $viewContent = new ViewContent(
                $event->getData()['schema'],
                $event->getData()['type'],
                $event->getData()['id']
            );
            $viewContent->setIsPopup(isset($event->getData()['popup']) && $event->getData()['popup']);
            
            $event->getPlaceholder()->addTemplate($viewContent);
        }
        
    }

    public static function getSubscribedEvents()
    {
        return [
            LoadTemplateEvent::NAME => 'onTemplate'
        ];
    }
}
