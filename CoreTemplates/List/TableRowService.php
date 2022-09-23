<?php

namespace Newageerp\SfReactTemplates\CoreTemplates\List;

use Newageerp\SfControlpanel\Console\EntitiesUtilsV3;
use Newageerp\SfControlpanel\Console\PropertiesUtilsV3;
use Newageerp\SfControlpanel\Console\TabsUtilsV3;
use Newageerp\SfReactTemplates\CoreTemplates\Data\DataString;
use Newageerp\SfReactTemplates\CoreTemplates\List\Columns\AudioColumn;
use Newageerp\SfReactTemplates\CoreTemplates\List\Columns\BoolColumn;
use Newageerp\SfReactTemplates\CoreTemplates\List\Columns\ColorColumn;
use Newageerp\SfReactTemplates\CoreTemplates\List\Columns\DateColumn;
use Newageerp\SfReactTemplates\CoreTemplates\List\Columns\DateTimeColumn;
use Newageerp\SfReactTemplates\CoreTemplates\List\Columns\EnumMultiNumberColumn;
use Newageerp\SfReactTemplates\CoreTemplates\List\Columns\EnumMultiTextColumn;
use Newageerp\SfReactTemplates\CoreTemplates\List\Columns\EnumNumberColumn;
use Newageerp\SfReactTemplates\CoreTemplates\List\Columns\EnumTextColumn;
use Newageerp\SfReactTemplates\CoreTemplates\List\Columns\FileColumn;
use Newageerp\SfReactTemplates\CoreTemplates\List\Columns\FileMultipleColumn;
use Newageerp\SfReactTemplates\CoreTemplates\List\Columns\FloatColumn;
use Newageerp\SfReactTemplates\CoreTemplates\List\Columns\ImageColumn;
use Newageerp\SfReactTemplates\CoreTemplates\List\Columns\LargeTextColumn;
use Newageerp\SfReactTemplates\CoreTemplates\List\Columns\NumberColumn;
use Newageerp\SfReactTemplates\CoreTemplates\List\Columns\ObjectColumn;
use Newageerp\SfReactTemplates\CoreTemplates\List\Columns\StatusColumn;
use Newageerp\SfReactTemplates\CoreTemplates\List\Columns\StringArrayColumn;
use Newageerp\SfReactTemplates\CoreTemplates\List\Columns\StringColumn;
use Newageerp\SfReactTemplates\CoreTemplates\Table\TableTd;
use Newageerp\SfReactTemplates\CoreTemplates\Table\TableTh;
use Newageerp\SfReactTemplates\CoreTemplates\Table\TableTr;
use Newageerp\SfUservice\Service\UService;

class TableRowService
{
    protected EntitiesUtilsV3 $entitiesUtilsV3;

    protected PropertiesUtilsV3 $propertiesUtilsV3;

    protected TabsUtilsV3 $tabsUtilsV3;

    protected UService $uservice;

    public function __construct(
        PropertiesUtilsV3 $propertiesUtilsV3,
        TabsUtilsV3 $tabsUtilsV3,
        UService $uservice,
        EntitiesUtilsV3 $entitiesUtilsV3
    ) {
        $this->propertiesUtilsV3 = $propertiesUtilsV3;
        $this->tabsUtilsV3 = $tabsUtilsV3;
        $this->uservice = $uservice;
        $this->entitiesUtilsV3 = $entitiesUtilsV3;
    }

    public function buildDataRow(string $schema, string $type): TableTr
    {
        // BUILD TR/TH
        $tr = new TableTr();

        $tab = $this->getTabsUtilsV3()->getTabBySchemaAndType($schema, $type);
        if ($tab) {
            foreach ($tab['columns'] as $col) {

                $td = new TableTd();

                if (isset($field['componentName']) && $field['componentName']) {
                } else {
                    $pathArray = explode(".", $col['path']);
                    $level1Path = $pathArray[0] . '.' . $pathArray[1];

                    $prop = $this->getPropertiesUtilsV3()->getPropertyForPath($level1Path);

                    if ($prop) {
                        $alignment = $this->getPropertiesUtilsV3()->getPropertyTableAlignment($prop, $col);
                        if ($alignment !== 'tw3-text-left') {
                            $td->setTextAlignment($alignment);
                        }

                        $naeType = $this->propertiesUtilsV3->getPropertyNaeType($prop, $col);
                            // if ($naeType === 'array') {
                            //     [$tabSchema, $tabType] = explode(':', $field['arrayRelTab']);

                            //     $wideRow->getControlContent()->addTemplate(
                            //         new ArrayRoField(
                            //             $pathArray[1],
                            //             $tabSchema,
                            //             $tabType,
                            //         )
                            //     );
                            // }
                            if ($naeType === 'audio') {
                                $td->getContents()->addTemplate(new AudioColumn($pathArray[1]));
                            }
                            if ($naeType === 'bool') {
                                $td->getContents()->addTemplate(new BoolColumn($pathArray[1]));
                            }
                            if ($naeType === 'color') {
                                $td->getContents()->addTemplate(new ColorColumn($pathArray[1]));
                            }
                            if ($naeType === 'date') {
                                $td->getContents()->addTemplate(new DateColumn($pathArray[1]));
                            }
                            if ($naeType === 'datetime') {
                                $td->getContents()->addTemplate(new DateTimeColumn($pathArray[1]));
                            }
                            if ($naeType === 'enum_multi_number') {
                                $td->getContents()->addTemplate(
                                    new EnumMultiNumberColumn(
                                        $pathArray[1],
                                        $this->propertiesUtilsV3->getPropertyEnumsList($prop),
                                    )
                                );
                            }
                            if ($naeType === 'enum_multi_text') {
                                $td->getContents()->addTemplate(
                                    new EnumMultiTextColumn(
                                        $pathArray[1],
                                        $this->propertiesUtilsV3->getPropertyEnumsList($prop),
                                    )
                                );
                            }
                            if ($naeType === 'enum_number') {
                                $td->getContents()->addTemplate(
                                    new EnumNumberColumn(
                                        $pathArray[1],
                                        $this->propertiesUtilsV3->getPropertyEnumsList($prop),
                                    )
                                );
                            }
                            if ($naeType === 'enum_text') {
                                $td->getContents()->addTemplate(
                                    new EnumTextColumn(
                                        $pathArray[1],
                                        $this->propertiesUtilsV3->getPropertyEnumsList($prop),
                                    )
                                );
                            }
                            if ($naeType === 'file') {
                                $td->getContents()->addTemplate(new FileColumn($pathArray[1]));
                            }
                            if ($naeType === 'fileMultiple') {
                                $td->getContents()->addTemplate(new FileMultipleColumn($pathArray[1]));
                            }
                            if ($naeType === 'float') {
                                $td->getContents()->addTemplate(new FloatColumn($pathArray[1]));
                            }
                            if ($naeType === 'float4') {
                                $td->getContents()->addTemplate(new FloatColumn($pathArray[1], 4));
                            }
                            if ($naeType === 'image') {
                                $td->getContents()->addTemplate(new ImageColumn($pathArray[1]));
                            }
                            if ($naeType === 'text') {
                                $td->getContents()->addTemplate(new LargeTextColumn($pathArray[1], isset($prop['as']) ? $prop['as'] : ''));
                            }
                            if ($naeType === 'number') {
                                $td->getContents()->addTemplate(new NumberColumn($pathArray[1]));
                            }
                            if ($naeType === 'object') {
                                $objectProp = $this->propertiesUtilsV3->getPropertyForPath($col['path']);

                                $objectField = new ObjectColumn(
                                    $pathArray[1],
                                    $prop['entity'],
                                    $pathArray[2],
                                    $objectProp['entity']
                                );
                                $objectField->setAs($prop['as']);

                                $td->getContents()->addTemplate($objectField);
                            }
                            if ($naeType === 'status') {
                                $td->getContents()->addTemplate(new StatusColumn($pathArray[1]));
                            }
                            if ($naeType === 'string_array') {
                                $td->getContents()->addTemplate(new StringArrayColumn($pathArray[1]));
                            }
                            if ($naeType === 'string') {
                                $td->getContents()->addTemplate(new StringColumn($pathArray[1]));
                            }
                    }
                }
                
                $tr->getContents()->addTemplate($td);
            }
        }
        return $tr;
    }

    /**
     * Get the value of propertiesUtilsV3
     *
     * @return PropertiesUtilsV3
     */
    public function getPropertiesUtilsV3(): PropertiesUtilsV3
    {
        return $this->propertiesUtilsV3;
    }

    /**
     * Set the value of propertiesUtilsV3
     *
     * @param PropertiesUtilsV3 $propertiesUtilsV3
     *
     * @return self
     */
    public function setPropertiesUtilsV3(PropertiesUtilsV3 $propertiesUtilsV3): self
    {
        $this->propertiesUtilsV3 = $propertiesUtilsV3;

        return $this;
    }

    /**
     * Get the value of tabsUtilsV3
     *
     * @return TabsUtilsV3
     */
    public function getTabsUtilsV3(): TabsUtilsV3
    {
        return $this->tabsUtilsV3;
    }

    /**
     * Set the value of tabsUtilsV3
     *
     * @param TabsUtilsV3 $tabsUtilsV3
     *
     * @return self
     */
    public function setTabsUtilsV3(TabsUtilsV3 $tabsUtilsV3): self
    {
        $this->tabsUtilsV3 = $tabsUtilsV3;

        return $this;
    }

    /**
     * Get the value of uservice
     */
    public function getUservice()
    {
        return $this->uservice;
    }

    /**
     * Set the value of uservice
     */
    public function setUservice($uservice): self
    {
        $this->uservice = $uservice;

        return $this;
    }

    /**
     * Get the value of entitiesUtilsV3
     *
     * @return EntitiesUtilsV3
     */
    public function getEntitiesUtilsV3(): EntitiesUtilsV3
    {
        return $this->entitiesUtilsV3;
    }

    /**
     * Set the value of entitiesUtilsV3
     *
     * @param EntitiesUtilsV3 $entitiesUtilsV3
     *
     * @return self
     */
    public function setEntitiesUtilsV3(EntitiesUtilsV3 $entitiesUtilsV3): self
    {
        $this->entitiesUtilsV3 = $entitiesUtilsV3;

        return $this;
    }
}
