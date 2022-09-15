<?php

namespace Newageerp\SfReactTemplates\CoreTemplates\Edit;

use Newageerp\SfControlpanel\Console\EntitiesUtilsV3;
use Newageerp\SfReactTemplates\CoreTemplates\MainToolbar\MainToolbarTitle;
use Newageerp\SfReactTemplates\CoreTemplates\Popup\PopupWindow;
use Newageerp\SfReactTemplates\Event\LoadTemplateEvent;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Newageerp\SfUservice\Service\UService;

class EditContentListener implements EventSubscriberInterface
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
        if ($event->isTemplateForAnyEntity('PageMainEdit')) {
            $entity = $this->uservice->getEntityFromSchemaAndId(
                $event->getData()['schema'],
                $event->getData()['id']
            );
            $editContent = new EditContent(
                $event->getData()['schema'],
                $event->getData()['type'],
                $event->getData()['id'],
                $entity
            );
            $isPopup = isset($event->getData()['isPopup']) && $event->getData()['isPopup'];

            if ($isPopup) {
                $popupWindow = new PopupWindow();
                $popupWindow->getChildren()->addTemplate($editContent);
                $event->getPlaceholder()->addTemplate($popupWindow);
            } else {
                $event->getPlaceholder()->addTemplate($editContent);

                $toolbarTitle = new MainToolbarTitle($this->entitiesUtilsV3->getTitleBySlug($event->getData()['schema']));
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
