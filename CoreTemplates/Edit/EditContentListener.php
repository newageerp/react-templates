<?php

namespace Newageerp\SfReactTemplates\CoreTemplates\Edit;

use Newageerp\SfControlpanel\Console\EditFormsUtilsV3;
use Newageerp\SfControlpanel\Console\EntitiesUtilsV3;
use Newageerp\SfControlpanel\Console\PropertiesUtilsV3;
use Newageerp\SfReactTemplates\CoreTemplates\Form\EditableFields\StringEditableField;
use Newageerp\SfReactTemplates\CoreTemplates\Form\EditableForm;
use Newageerp\SfReactTemplates\CoreTemplates\MainToolbar\MainToolbarTitle;
use Newageerp\SfReactTemplates\CoreTemplates\Popup\PopupWindow;
use Newageerp\SfReactTemplates\Event\LoadTemplateEvent;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Newageerp\SfUservice\Service\UService;
use Newageerp\SfReactTemplates\CoreTemplates\Form\Rows\WideRow;
use Newageerp\SfReactTemplates\CoreTemplates\Form\FormFieldLabel;
use Newageerp\SfReactTemplates\CoreTemplates\Form\FormFieldSeparator;
use Newageerp\SfReactTemplates\CoreTemplates\Form\FormFieldTagCloud;
use Newageerp\SfReactTemplates\CoreTemplates\Form\FormHint;
use Newageerp\SfReactTemplates\CoreTemplates\Form\FormLabel;

class EditContentListener implements EventSubscriberInterface
{
    protected UService $uservice;

    protected EntitiesUtilsV3 $entitiesUtilsV3;

    protected EditFormsUtilsV3 $editFormsUtilsV3;

    protected PropertiesUtilsV3 $propertiesUtilsV3;

    public function __construct(
        UService $uservice,
        EntitiesUtilsV3 $entitiesUtilsV3,
        EditFormsUtilsV3 $editFormsUtilsV3,
        PropertiesUtilsV3 $propertiesUtilsV3
    ) {
        $this->uservice = $uservice;
        $this->entitiesUtilsV3 = $entitiesUtilsV3;
        $this->editFormsUtilsV3 = $editFormsUtilsV3;
        $this->propertiesUtilsV3 = $propertiesUtilsV3;
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

            $this->fillFormContent(
                $event->getData()['schema'],
                $event->getData()['type'],
                $editContent,
            );

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

    protected function fillFormContent(string $schema, string $type, EditContent $editContent)
    {
        $editableForm = new EditableForm();

        $editForm = $this->editFormsUtilsV3->getEditFormBySchemaAndType($schema, $type);

        foreach ($editForm['fields'] as $field) {
            if ($field['type'] === 'tagCloud') {
                $editableForm->getChildren()->addTemplate(new FormFieldTagCloud($field['tagCloudField'], $field['tagCloudAction']));
            } else if ($field['type'] === 'label') {
                $editableForm->getChildren()->addTemplate(new FormLabel($field['text']));
            } else if ($field['type'] === 'hint') {
                $editableForm->getChildren()->addTemplate(new FormHint($field['text']));
            } else if ($field['type'] === 'separator') {
                $editableForm->getChildren()->addTemplate(new FormFieldSeparator());
            } else {
                $hideLabel = false;
                if (isset($field['hideLabel'])) {
                    $hideLabel = $field['hideLabel'];
                }

                $title = '';
                if (isset($field['customTitle']) && $field['customTitle']) {
                    $title = $field['customTitle'];
                } else if (isset($field['titlePath']) && $field['titlePath']) {
                    $prop = $this->propertiesUtilsV3->getPropertyForPath($field['titlePath']);
                    if ($prop) {
                        $title = $prop['title'];
                    }
                } else {
                    $prop = $this->propertiesUtilsV3->getPropertyForPath($field['path']);
                    if ($prop) {
                        $title = $prop['title'];
                    }
                }

                $wideRow = new WideRow();
                $wideRow->setLabelClassName(isset($field['labelClassName']) ? $field['labelClassName'] : '');
                $wideRow->setControlClassName(isset($field['inputClassName']) ? $field['inputClassName'] : '');
                if (!$hideLabel) {
                    $label = new FormFieldLabel($title);
                    $wideRow->getLabelContent()->addTemplate($label);
                }

                $pathArray = explode(".", $field['path']);

                $prop = $this->propertiesUtilsV3->getPropertyForPath($field['path']);
                if ($prop) {
                    $naeType = $this->propertiesUtilsV3->getPropertyNaeType($prop, $field);
                    if ($naeType === 'string') {
                        $wideRow->getControlContent()->addTemplate(new StringEditableField($pathArray[1]));
                    }
                }

                $editContent->getFormContent()->addTemplate($wideRow);
            }
        }

        $editContent->getFormContent()->addTemplate($editableForm);
    }
}
