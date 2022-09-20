<?php

namespace Newageerp\SfReactTemplates\CoreTemplates\Edit;

use Newageerp\SfControlpanel\Console\EditFormsUtilsV3;
use Newageerp\SfControlpanel\Console\EntitiesUtilsV3;
use Newageerp\SfControlpanel\Console\PropertiesUtilsV3;
use Newageerp\SfReactTemplates\CoreTemplates\Form\EditableFields\ArrayEditableField;
use Newageerp\SfReactTemplates\CoreTemplates\Form\EditableFields\AudioEditableField;
use Newageerp\SfReactTemplates\CoreTemplates\Form\EditableFields\BoolEditableField;
use Newageerp\SfReactTemplates\CoreTemplates\Form\EditableFields\ColorEditableField;
use Newageerp\SfReactTemplates\CoreTemplates\Form\EditableFields\CustomField;
use Newageerp\SfReactTemplates\CoreTemplates\Form\EditableFields\DateEditableField;
use Newageerp\SfReactTemplates\CoreTemplates\Form\EditableFields\DateTimeEditableField;
use Newageerp\SfReactTemplates\CoreTemplates\Form\EditableFields\EnumMultiNumberEditableField;
use Newageerp\SfReactTemplates\CoreTemplates\Form\EditableFields\EnumMultiTextEditableField;
use Newageerp\SfReactTemplates\CoreTemplates\Form\EditableFields\EnumNumberEditableField;
use Newageerp\SfReactTemplates\CoreTemplates\Form\EditableFields\EnumTextEditableField;
use Newageerp\SfReactTemplates\CoreTemplates\Form\EditableFields\FileEditableField;
use Newageerp\SfReactTemplates\CoreTemplates\Form\EditableFields\FileMultipleEditableField;
use Newageerp\SfReactTemplates\CoreTemplates\Form\EditableFields\FloatEditableField;
use Newageerp\SfReactTemplates\CoreTemplates\Form\EditableFields\ImageEditableField;
use Newageerp\SfReactTemplates\CoreTemplates\Form\EditableFields\LargeTextEditableField;
use Newageerp\SfReactTemplates\CoreTemplates\Form\EditableFields\NumberEditableField;
use Newageerp\SfReactTemplates\CoreTemplates\Form\EditableFields\ObjectEditableField;
use Newageerp\SfReactTemplates\CoreTemplates\Form\EditableFields\StatusEditableField;
use Newageerp\SfReactTemplates\CoreTemplates\Form\EditableFields\StringArrayEditableField;
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
use Newageerp\SfReactTemplates\CoreTemplates\Form\Rows\CompactRow;
use Newageerp\SfReactTemplates\CoreTemplates\Layout\FlexRow;

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
            $id = $event->getData()['id'] === 'new' ? 0 : $event->getData()['id'];

            $entity = $this->uservice->getEntityFromSchemaAndId(
                $event->getData()['schema'],
                $id
            );
            $editContent = new EditContent(
                $event->getData()['schema'],
                $event->getData()['type'],
                $event->getData()['id'],
                $entity
            );
            $isPopup = isset($event->getData()['isPopup']) && $event->getData()['isPopup'];
            $isCompact = isset($event->getData()['isCompact']) && $event->getData()['isCompact'];

            $editContent->setIsCompact($isCompact);

            $this->fillFormContent(
                $event->getData()['schema'],
                $event->getData()['type'],
                $editContent,
                $isCompact
            );

            if ($isPopup) {
                $popupWindow = new PopupWindow();
                $popupWindow->getChildren()->addTemplate($editContent);
                $event->getPlaceholder()->addTemplate($popupWindow);
            } else {
                $event->getPlaceholder()->addTemplate($editContent);

                if (!$isCompact) {
                    $toolbarTitle = new MainToolbarTitle($this->entitiesUtilsV3->getTitleBySlug($event->getData()['schema']));
                    $event->getPlaceholder()->addTemplate($toolbarTitle);
                }
            }
        }
    }

    public static function getSubscribedEvents()
    {
        return [
            LoadTemplateEvent::NAME => 'onTemplate'
        ];
    }

    protected function fillFormContent(string $schema, string $type, EditContent $editContent, bool $isCompact = false)
    {
        $editableForm = new EditableForm(null, $isCompact);

        $editForm = $this->editFormsUtilsV3->getEditFormBySchemaAndType($schema, $type);

        $groupedFields = [];
        foreach ($editForm['fields'] as $key => $field) {
            $lineGroup = isset($field['lineGroup']) && $field['lineGroup'] ? $field['lineGroup'] : 'no_line_group_' . $key;
            if (!isset($groupedFields[$lineGroup])) {
                $groupedFields[$lineGroup] = [];
            }
            $groupedFields[$lineGroup][] = $field;
        }

        foreach ($groupedFields as $fields) {
            $flexRow = null;
            if (count($fields) > 1) {
                $flexRow = new FlexRow();
            }

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
                        $pathArray = explode(".", $field['path']);
                        $level1Path = $pathArray[0] . '.' . $pathArray[1];
                        $prop = $this->propertiesUtilsV3->getPropertyForPath($level1Path);
                        if ($prop) {
                            $title = $prop['title'];
                        }
                    }

                    $wideRow = $isCompact ? new CompactRow() : new WideRow();
                    $wideRow->setLabelClassName(isset($field['labelClassName']) ? $field['labelClassName'] : '');
                    $wideRow->setControlClassName(isset($field['inputClassName']) ? $field['inputClassName'] : '');
                    if (!$hideLabel) {
                        $label = new FormFieldLabel($title);
                        $wideRow->getLabelContent()->addTemplate($label);
                    }

                    $pathArray = explode(".", $field['path']);
                    $level1Path = $pathArray[0] . '.' . $pathArray[1];

                    if (isset($field['componentName']) && $field['componentName']) {
                        $wideRow->getControlContent()->addTemplate(
                            new CustomField(
                                $pathArray[1],
                                $field['componentName']
                            )
                        );
                    } else {

                        $prop = $this->propertiesUtilsV3->getPropertyForPath($level1Path);
                        if ($prop) {
                            $naeType = $this->propertiesUtilsV3->getPropertyNaeType($prop, $field);
                            if ($naeType === 'array') {
                                [$tabSchema, $tabType] = explode(':', $field['arrayRelTab']);

                                $wideRow->getControlContent()->addTemplate(
                                    new ArrayEditableField(
                                        $pathArray[1],
                                        $tabSchema,
                                        $tabType,
                                    )
                                );
                            }
                            if ($naeType === 'audio') {
                                $wideRow->getControlContent()->addTemplate(new AudioEditableField($pathArray[1]));
                            }
                            if ($naeType === 'bool') {
                                $wideRow->getControlContent()->addTemplate(new BoolEditableField($pathArray[1]));
                            }
                            if ($naeType === 'color') {
                                $wideRow->getControlContent()->addTemplate(new ColorEditableField($pathArray[1]));
                            }
                            if ($naeType === 'date') {
                                $wideRow->getControlContent()->addTemplate(new DateEditableField($pathArray[1]));
                            }
                            if ($naeType === 'datetime') {
                                $wideRow->getControlContent()->addTemplate(new DateTimeEditableField($pathArray[1]));
                            }
                            if ($naeType === 'enum_multi_number') {
                                $wideRow->getControlContent()->addTemplate(new EnumMultiNumberEditableField($pathArray[1]));
                            }
                            if ($naeType === 'enum_multi_text') {
                                $wideRow->getControlContent()->addTemplate(new EnumMultiTextEditableField($pathArray[1]));
                            }
                            if ($naeType === 'enum_number') {
                                $wideRow->getControlContent()->addTemplate(
                                    new EnumNumberEditableField(
                                        $pathArray[1],
                                        $this->propertiesUtilsV3->getPropertyEnumsList($prop),
                                    )
                                );
                            }
                            if ($naeType === 'enum_text') {
                                $wideRow->getControlContent()->addTemplate(
                                    new EnumTextEditableField(
                                        $pathArray[1],
                                        $this->propertiesUtilsV3->getPropertyEnumsList($prop),
                                    )
                                );
                            }
                            if ($naeType === 'file') {
                                $wideRow->getControlContent()->addTemplate(new FileEditableField($pathArray[1]));
                            }
                            if ($naeType === 'fileMultiple') {
                                $wideRow->getControlContent()->addTemplate(new FileMultipleEditableField($pathArray[1]));
                            }
                            if ($naeType === 'float') {
                                $wideRow->getControlContent()->addTemplate(new FloatEditableField($pathArray[1]));
                            }
                            if ($naeType === 'float4') {
                                $wideRow->getControlContent()->addTemplate(new FloatEditableField($pathArray[1], 4));
                            }
                            if ($naeType === 'image') {
                                $wideRow->getControlContent()->addTemplate(new ImageEditableField($pathArray[1]));
                            }
                            if ($naeType === 'text') {
                                $wideRow->getControlContent()->addTemplate(new LargeTextEditableField($pathArray[1], isset($prop['as']) ? $prop['as'] : ''));
                            }
                            if ($naeType === 'number') {
                                $wideRow->getControlContent()->addTemplate(new NumberEditableField($pathArray[1]));
                            }
                            if ($naeType === 'object') {
                                $objectProp = $this->propertiesUtilsV3->getPropertyForPath($field['path']);

                                $objectField = new ObjectEditableField(
                                    $pathArray[1],
                                    $prop['entity'],
                                    $pathArray[2],
                                    $objectProp['entity']
                                );
                                $objectField->setAs($prop['as']);
                                if (isset($field['fieldDependency']) && $field['fieldDependency']) {
                                    $objectField->setFieldDependency($field['fieldDependency']);
                                }
                                if (isset($field['relKeyExtraSelect']) && $field['relKeyExtraSelect']) {
                                    $objectField->setFieldExtraSelect(json_decode($field['relKeyExtraSelect'], true));
                                }

                                $wideRow->getControlContent()->addTemplate($objectField);
                            }
                            if ($naeType === 'status') {
                                $wideRow->getControlContent()->addTemplate(new StatusEditableField($pathArray[1]));
                            }
                            if ($naeType === 'string_array') {
                                $wideRow->getControlContent()->addTemplate(new StringArrayEditableField($pathArray[1]));
                            }
                            if ($naeType === 'string') {
                                $wideRow->getControlContent()->addTemplate(new StringEditableField($pathArray[1]));
                            }

                            $wideRow->setFieldVisibilityData([
                                'fieldKey' => $pathArray[1],
                                'fieldSchema' => $prop['entity'],
                            ]);
                        }
                    }

                    if ($flexRow !== null) {
                        $flexRow->getChildren()->addTemplate($wideRow);
                    } else {
                        $editableForm->getChildren()->addTemplate($wideRow);
                    }
                }
            }
            if ($flexRow !== null) {
                $editableForm->getChildren()->addTemplate($flexRow);
            }
        }
        $editContent->getFormContent()->addTemplate($editableForm);
    }
}
