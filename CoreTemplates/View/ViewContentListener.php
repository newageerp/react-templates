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
            
            $event->getPlaceholder()->addTemplate($viewContent);
        }
    }

    public static function getSubscribedEvents()
    {
        $key = static::class;

        return [
            LoadTemplateEvent::NAME => 'onTemplate'
        ];
    }
}
