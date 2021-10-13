<?php
namespace Maknz\Slack\BlockElement;

use InvalidArgumentException;
use Maknz\Slack\Object\Option;

class ExternalSelect extends AbstractDynamicSelect
{
    /**
     * Block type.
     *
     * @var string
     */
    protected $type = 'external_select';

    /**
     * Fewest number of characters before query is dispatched.
     *
     * @var int
     */
    protected $min_query_length;

    /**
     * Initially selected option.
     *
     * @var \Maknz\Slack\Object\Option
     */
    protected $initial_option;

    /**
     * Internal attribute to property map.
     *
     * @var array
     */
    protected static $availableAttributes = [
        'placeholder'      => 'placeholder',
        'action_id'        => 'action_id',
        'initial_option'   => 'initial_option',
        'min_query_length' => 'min_query_length',
        'confirm'          => 'confirm',
    ];

    /**
     * Get the number of characters before query is dispatched.
     *
     * @return int
     */
    public function getMinQueryLength()
    {
        return $this->min_query_length;
    }

    /**
     * Set the number of characters before query is dispatched.
     *
     * @param int $minQueryLength
     *
     * @return $this
     *
     * @throws InvalidArgumentException
     */
    public function setMinQueryLength($minQueryLength)
    {
        if (is_int($minQueryLength)) {
            $this->min_query_length = $minQueryLength;

            return $this;
        }

        throw new InvalidArgumentException('The minimum query length must be an integer');
    }

    /**
     * Get the initially selected option.
     *
     * @return \Maknz\Slack\Object\Option
     */
    public function getInitialOption()
    {
        return $this->initial_option;
    }

    /**
     * Set the initially selected option.
     *
     * @param mixed $initialOption
     *
     * @return $this
     *
     * @throws InvalidArgumentException
     */
    public function setInitialOption($initialOption)
    {
        if (is_array($initialOption)) {
            $initialOption = new Option($initialOption);
        }

        if ($initialOption instanceof Option) {
            $this->initial_option = $initialOption;

            return $this;
        }

        throw new InvalidArgumentException('The initial option must be an instance of '.Option::class.' or a keyed array');
    }

    /**
     * Clear the initially selected option.
     *
     * @return $this
     */
    public function clearInitialOption()
    {
        $this->initial_option = null;

        return $this;
    }

    /**
     * Convert the block to its array representation.
     *
     * @return array
     */
    public function toArray()
    {
        $data = [
            'type'        => $this->getType(),
            'placeholder' => $this->getPlaceholder()->toArray(),
            'action_id'   => $this->getActionId(),
        ];

        if ($this->getInitialOption()) {
            $data['initial_option'] = $this->getInitialOption()->toArray();
        }

        if ($this->getMinQueryLength()) {
            $data['min_query_length'] = $this->getMinQueryLength();
        }

        if ($this->getConfirm()) {
            $data['confirm'] = $this->getConfirm()->toArray();
        }

        return $data;
    }
}
