<?php
namespace Maknz\Slack\BlockElement;

use DateTime;

abstract class Temporalpicker extends Confirmable
{
    /**
     * Action triggered when the date is selected.
     *
     * @var string
     */
    protected $action_id;

    /**
     * Placeholder shown on the date picker.
     *
     * @var \Maknz\Slack\BlockElement\Text
     */
    protected $placeholder;

    /**
     * Initial date to be selected.
     *
     * @var \DateTime
     */
    protected $initial_value;

    /**
     * Get the action.
     *
     * @return string
     */
    public function getActionId()
    {
        return $this->action_id;
    }

    /**
     * Set the action.
     *
     * @param string $actionId
     *
     * @return $this
     */
    public function setActionId($actionId)
    {
        $this->action_id = $actionId;

        return $this;
    }

    /**
     * Get the placeholder.
     *
     * @return \Maknz\Slack\BlockElement\Text
     */
    public function getPlaceholder()
    {
        return $this->placeholder;
    }

    /**
     * Set the placeholder.
     *
     * @param mixed $placeholder
     *
     * @return $this
     *
     * @throws \InvalidArgumentException
     */
    public function setPlaceholder($placeholder)
    {
        $this->placeholder = Text::create($placeholder, Text::TYPE_PLAIN);

        return $this;
    }

    /**
     * Get the initial date.
     *
     * @return \DateTime
     */
    protected function getInitialValue()
    {
        return $this->initial_value;
    }

    /**
     * Set the initial date.
     *
     * @param \DateTime $initialValue
     *
     * @return $this
     */
    protected function setInitialValue(DateTime $initialValue)
    {
        $this->initial_value = $initialValue;

        return $this;
    }

    /**
     * Get the name of the initial value field.
     *
     * @return string
     */
    abstract protected function getInitialValueField();

    /**
     * Get the initial value format.
     *
     * @return string
     */
    abstract protected function getInitialValueFormat();

    /**
     * Convert the block to its array representation.
     *
     * @return array
     */
    public function toArray()
    {
        $data = [
            'type'      => $this->getType(),
            'action_id' => $this->getActionId(),
        ];

        if ($this->getPlaceholder()) {
            $data['placeholder'] = $this->getPlaceholder()->toArray();
        }

        if ($this->getInitialValue()) {
            $data[$this->getInitialValueField()] = $this->getInitialValue()->format($this->getInitialValueFormat());
        }

        if ($this->getConfirm()) {
            $data['confirm'] = $this->getConfirm()->toArray();
        }

        return $data;
    }
}
