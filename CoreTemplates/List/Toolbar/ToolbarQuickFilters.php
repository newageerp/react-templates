<?php

namespace Newageerp\SfReactTemplates\CoreTemplates\List\Toolbar;

use Newageerp\SfReactTemplates\Template\Template;

class ToolbarQuickFilters extends Template
{
    protected array $filters;

    public function __construct(array $filters)
    {
        $quickFilters = array_map(
            function ($item) use (&$hasStatusFilter) {
                $item['property'] = $this->propertiesUtils->getPropertyForPath($item['path']);
                $item['type'] = $this->propertiesUtils->getPropertyNaeType($item['property'], []);

                $pathA = explode(".", $item['path']);
                $pathA[0] = 'i';
                $item['path'] = implode(".", $pathA);

                if ($item['type'] === 'status') {
                    $hasStatusFilter = true;
                }

                if ($item['type'] === 'object') {
                    $item['sort'] = $this->defaultsService->getSortForSchema($item['property']['format']);
                    $item['sortStr'] = json_encode($item['sort']);
                }
                if (!isset($item['sortStr']) || !$item['sortStr']) {
                    $item['sortStr'] = json_encode([]);
                }

                return $item;
            },
            $filters
        );
        $this->filters = $filters;
    }

    public function getTemplateName(): string
    {
        return 'list.toolbar.filters';
    }

    public function getProps(): array
    {
        return [
            'filters' => $this->getFilters(),
        ];
    }

    /**
     * Get the value of filters
     *
     * @return array
     */
    public function getFilters(): array
    {
        return $this->filters;
    }

    /**
     * Set the value of filters
     *
     * @param array $filters
     *
     * @return self
     */
    public function setFilters(array $filters): self
    {
        $this->filters = $filters;

        return $this;
    }
}

