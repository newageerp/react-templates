<?php

namespace Newageerp\SfReactTemplates\CoreTemplates\View;

use Newageerp\SfControlpanel\Console\EntitiesUtilsV3;
use Newageerp\SfReactTemplates\CoreTemplates\Popup\PopupWindow;
use Newageerp\SfReactTemplates\CoreTemplates\Toolbar\ToolbarTitle;
use Newageerp\SfReactTemplates\Event\LoadTemplateEvent;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Newageerp\SfUservice\Service\UService;

class ViewContentListener implements EventSubscriberInterface
{
    protected UService $uservice;

    protected EntitiesUtilsV3 $entitiesUtilsV3;

    public function __construct(UService $uservice, EntitiesUtilsV3 $entitiesUtilsV3)
    {
        $this->uservice = $uservice;
        $this->entitiesUtilsV3 = $entitiesUtilsV3;
    }

    public function onTemplate(LoadTemplateEvent $event)
    {
        if ($event->isTemplateForAnyEntity('PageMainView')) {
            $entity = $this->uservice->getEntityFromSchemaAndId(
                $event->getData()['schema'],
                $event->getData()['id']
            );
            $viewContent = new ViewContent(
                $event->getData()['schema'],
                $event->getData()['type'],
                $event->getData()['id'],
                $entity
            );
            $isPopup = isset($event->getData()['isPopup']) && $event->getData()['isPopup'];

            if ($isPopup) {
                $popupWindow = new PopupWindow();
                $popupWindow->getChildren()->addTemplate($viewContent);
                $event->getPlaceholder()->addTemplate($popupWindow);
            } else {
                $event->getPlaceholder()->addTemplate($viewContent);

                $toolbarTitle = new ToolbarTitle($this->entitiesUtilsV3->getTitleBySlug($event->getData()['schema']));
                $event->getPlaceholder()->addTemplate($toolbarTitle);
            }
        }
    }

    public static function getSubscribedEvents()
    {
        return [
            LoadTemplateEvent::NAME => 'onTemplate'
        ];
    }
}
