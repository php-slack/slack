<?php
namespace Maknz\Slack;

use InvalidArgumentException;

trait FieldsTrait
{
    /**
     * The fields of the block/attachment.
     *
     * @var array
     */
    protected $fields = [];

    /**
     * Get the class name of valid fields.
     *
     * @return string
     */
    abstract protected function getFieldClass();

    /**
     * Get the fields for the block/attachment.
     *
     * @return \Maknz\Slack\Field[]|array
     */
    public function getFields()
    {
        return $this->fields;
    }

    /**
     * Set the fields for the block/attachment.
     *
     * @param array $fields
     *
     * @return $this
     *
     * @throws \InvalidArgumentException
     */
    public function setFields(array $fields)
    {
        $this->clearFields();

        foreach ($fields as $field) {
            $this->addField($field);
        }

        return $this;
    }

    /**
     * Add a field to the block/attachment.
     *
     * @param Field|array $field
     *
     * @return $this
     *
     * @throws \InvalidArgumentException
     */
    public function addField($field)
    {
        $fieldClass = $this->getFieldClass();

        if ($field instanceof $fieldClass) {
            $this->fields[] = $field;

            return $this;
        } elseif (is_array($field)) {
            $this->fields[] = new $fieldClass($field);

            return $this;
        }

        throw new InvalidArgumentException('The field must be an instance of '.$fieldClass.' or a keyed array');
    }

    /**
     * Clear the fields for the block/attachment.
     *
     * @return $this
     */
    public function clearFields()
    {
        $this->fields = [];

        return $this;
    }

    /**
     * Iterates over all fields in this block/attachment and returns
     * them in their array form.
     *
     * @return array
     */
    protected function getFieldsAsArrays()
    {
        $fields = [];

        foreach ($this->getFields() as $field) {
            $fields[] = $field->toArray();
        }

        return $fields;
    }
}
