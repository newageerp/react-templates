<?php

namespace Newageerp\SfReactTemplates\CoreTemplates\List;

use Newageerp\SfControlpanel\Console\EntitiesUtilsV3;
use Newageerp\SfControlpanel\Console\PropertiesUtilsV3;
use Newageerp\SfControlpanel\Console\TabsUtilsV3;
use Newageerp\SfReactTemplates\CoreTemplates\Data\DataString;
use Newageerp\SfReactTemplates\CoreTemplates\Popup\PopupWindow;
use Newageerp\SfReactTemplates\CoreTemplates\Table\TableTr;
use Newageerp\SfReactTemplates\CoreTemplates\Table\TableTh;
use Newageerp\SfReactTemplates\CoreTemplates\Toolbar\ToolbarTitle;
use Newageerp\SfReactTemplates\Event\LoadTemplateEvent;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Newageerp\SfUservice\Service\UService;

class ListContentListener implements EventSubscriberInterface
{
    protected UService $uservice;

    protected EntitiesUtilsV3 $entitiesUtilsV3;

    protected PropertiesUtilsV3 $propertiesUtilsV3;

    protected TabsUtilsV3 $tabsUtilsV3;

    public function __construct(
        UService $uservice,
        EntitiesUtilsV3 $entitiesUtilsV3,
        TabsUtilsV3 $tabsUtilsV3,
        PropertiesUtilsV3 $propertiesUtilsV3,
    ) {
        $this->uservice = $uservice;
        $this->entitiesUtilsV3 = $entitiesUtilsV3;
        $this->tabsUtilsV3 = $tabsUtilsV3;
        $this->propertiesUtilsV3 = $propertiesUtilsV3;
    }

    public function onTemplate(LoadTemplateEvent $event)
    {
        if ($event->isTemplateForAnyEntity('PageMainList')) {
            $listContent = new ListContent(
                $event->getData()['schema'],
                $event->getData()['type']
            );
            $isPopup = isset($event->getData()['isPopup']) && $event->getData()['isPopup'];

            // BUILD TR/TH
            $tr = new TableTr();

            $tab = $this->tabsUtilsV3->getTabBySchemaAndType($event->getData()['schema'], $event->getData()['type']);
            if ($tab) {
                foreach ($tab['columns'] as $col) {
                    $title = '';
                    if (isset($col['customTitle']) && $col['customTitle']) {
                        $title = $col['customTitle'];
                    } else {
                        $titlePath = isset($col['titlePath']) && $col['titlePath'] ? $col['titlePath'] : $col['path'];
                        $propTitle = $this->propertiesUtilsV3->getPropertyForPath($titlePath);
                        if ($propTitle) {
                            $title = $propTitle['title'];
                        }
                    }
                    $str = new DataString($title);
                    $th = new TableTh();

                    $filterPath = isset($col['filterPath']) && $col['filterPath'] ? $col['filterPath'] : $col['path'];
                    $prop = $this->propertiesUtilsV3->getPropertyForPath($filterPath);

                    if ($prop) {
                        $alignment = $this->propertiesUtilsV3->getPropertyTableAlignment($prop, $col);
                        if ($alignment !== 'tw3-text-left') {
                            $th->setTextAlignment($alignment);
                        }

                        if ($prop['isDb'] && $title) {
                            $enums = $this->propertiesUtilsV3->getPropertyEnumsList($prop);

                            $propNaeType = $this->propertiesUtilsV3->getPropertyNaeType($prop, $col);
                            if ($propNaeType === 'object') {
                                $schema = $prop['typeFormat'];
                                $data = $this->uservice->getListDataForSchema(
                                    $schema,
                                    1,
                                    100,
                                    ['id', '_viewTitle'],
                                    [],
                                    [],
                                    $this->entitiesUtilsV3->getDefaultSortForSchema($schema),
                                    [],
                                    false
                                );
                                $enums = array_map(
                                    function ($item) {
                                        return [
                                            'value' => $item->getId(),
                                            'label' => $item->get_ViewTitle(),
                                        ];
                                    },
                                    $data['data'],
                                );
                            }
                            $th->setFilter([
                                'id' => PropertiesUtilsV3::swapSchemaToI($filterPath),
                                'title' => $title,
                                'type' => $this->propertiesUtilsV3->getDefaultPropertySearchComparison($prop, $col),
                                'options' => $this->propertiesUtilsV3->getPropertyEnumsList($prop),
                            ]);
                        }
                    }

                    $th->getContents()->addTemplate($str);

                    $tr->getContents()->addTemplate($th);
                }
            }

            $listContent->getTableHeader()->addTemplate($tr);

            if ($isPopup) {
                $popupWindow = new PopupWindow();
                $popupWindow->getChildren()->addTemplate($listContent);
                $event->getPlaceholder()->addTemplate($popupWindow);
            } else {
                $event->getPlaceholder()->addTemplate($listContent);

                $toolbarTitle = new ToolbarTitle($this->entitiesUtilsV3->getTitlePluralBySlug($event->getData()['schema']));
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
