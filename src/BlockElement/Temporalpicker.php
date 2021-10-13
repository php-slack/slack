<?php
namespace Maknz\Slack\BlockElement;

use DateTime;
use Maknz\Slack\PlaceholderTrait;

abstract class Temporalpicker extends Confirmable
{
    use PlaceholderTrait;

    /**
     * Initial date to be selected.
     *
     * @var \DateTime
     */
    protected $initial_value;

    /**
     * Get the initial value.
     *
     * @return \DateTime
     */
    protected function getInitialValue()
    {
        return $this->initial_value;
    }

    /**
     * Set the initial value.
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
