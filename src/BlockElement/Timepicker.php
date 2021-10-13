<?php
namespace Maknz\Slack\BlockElement;

use DateTime;

class Timepicker extends Temporalpicker
{
    /**
     * Block type.
     *
     * @var string
     */
    protected $type = 'timepicker';

    /**
     * Internal attribute to property map.
     *
     * @var array
     */
    protected static $availableAttributes = [
        'action_id'    => 'action_id',
        'placeholder'  => 'placeholder',
        'initial_time' => 'initial_value',
        'confirm'      => 'confirm',
    ];

    /**
     * Get the name of the initial value field.
     *
     * @return string
     */
    public function getInitialValueField()
    {
        return 'initial_time';
    }

    /**
     * Get the initial value format.
     *
     * @return string
     */
    public function getInitialValueFormat()
    {
        return 'H:i';
    }

    /**
     * Get the initial time.
     *
     * @return \DateTime
     */
    public function getInitialTime()
    {
        return $this->getInitialValue();
    }

    /**
     * Set the initial time.
     *
     * @param \DateTime $initialTime
     *
     * @return $this
     */
    public function setInitialTime(DateTime $initialTime)
    {
        return $this->setInitialValue($initialTime);
    }
}
