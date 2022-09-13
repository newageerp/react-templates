<?php

namespace Newageerp\SfReactTemplates\CoreTemplates\View\FilesWidget;

class FilesWidgetItem
{
    protected string $title = '';

    protected string $folder = '';

    protected string $entity = '';

    protected string $hint = '';

    protected bool $allowUpload = true;

    public function __construct(string $title, string $entity, string $folder)
    {
        $this->title = $title;
        $this->entity = $entity;
        $this->folder = $folder;
    }

    public function toArray()
    {
        return [
            'title' => $this->getTitle(),
            'folder' => $this->getFolder(),
            'entity' => $this->getEntity(),
            'hint' => $this->getHint(),
            'allowUpload' => $this->getAllowUpload(),
        ];
    }

    /**
     * Get the value of title
     *
     * @return string
     */
    public function getTitle(): string
    {
        return $this->title;
    }

    /**
     * Set the value of title
     *
     * @param string $title
     *
     * @return self
     */
    public function setTitle(string $title): self
    {
        $this->title = $title;

        return $this;
    }

    /**
     * Get the value of folder
     *
     * @return string
     */
    public function getFolder(): string
    {
        return $this->folder;
    }

    /**
     * Set the value of folder
     *
     * @param string $folder
     *
     * @return self
     */
    public function setFolder(string $folder): self
    {
        $this->folder = $folder;

        return $this;
    }

    /**
     * Get the value of entity
     *
     * @return string
     */
    public function getEntity(): string
    {
        return $this->entity;
    }

    /**
     * Set the value of entity
     *
     * @param string $entity
     *
     * @return self
     */
    public function setEntity(string $entity): self
    {
        $this->entity = $entity;

        return $this;
    }

    /**
     * Get the value of hint
     *
     * @return string
     */
    public function getHint(): string
    {
        return $this->hint;
    }

    /**
     * Set the value of hint
     *
     * @param string $hint
     *
     * @return self
     */
    public function setHint(string $hint): self
    {
        $this->hint = $hint;

        return $this;
    }

    /**
     * Get the value of allowUpload
     *
     * @return bool
     */
    public function getAllowUpload(): bool
    {
        return $this->allowUpload;
    }

    /**
     * Set the value of allowUpload
     *
     * @param bool $allowUpload
     *
     * @return self
     */
    public function setAllowUpload(bool $allowUpload): self
    {
        $this->allowUpload = $allowUpload;

        return $this;
    }
}
