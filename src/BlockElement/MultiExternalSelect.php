<?php
namespace Maknz\Slack\BlockElement;

use InvalidArgumentException;
use Maknz\Slack\Object\Option;

class MultiExternalSelect extends MultiDynamicSelect
{
    /**
     * Block type.
     *
     * @var string
     */
    protected $type = 'multi_external_select';

    /**
     * Fewest number of characters before query is dispatched.
     *
     * @var int
     */
    protected $min_query_length;

    /**
     * Initially selected options.
     *
     * @var \Maknz\Slack\Object\Option[]
     */
    protected $initial_options = [];

    /**
     * Internal attribute to property map.
     *
     * @var array
     */
    protected static $availableAttributes = [
        'placeholder'        => 'placeholder',
        'action_id'          => 'action_id',
        'min_query_length'   => 'min_query_length',
        'initial_options'    => 'initial_options',
        'confirm'            => 'confirm',
        'max_selected_items' => 'max_selected_items',
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
     * Get the initially selected options.
     *
     * @return \Maknz\Slack\Object\Option[]
     */
    public function getInitialOptions()
    {
        return $this->initial_options;
    }

    /**
     * Set the initially selected options.
     *
     * @param array $initialOption
     *
     * @return $this
     *
     * @throws InvalidArgumentException
     */
    public function setInitialOptions(array $initialOptions)
    {
        $this->clearInitialOptions();

        foreach ($initialOptions as $initialOption) {
            $this->addInitialOption($initialOption);
        }

        return $this;
    }

    /**
     * Clear the initially selected options.
     *
     * @return $this
     */
    public function clearInitialOptions()
    {
        $this->initial_options = [];

        return $this;
    }

    /**
     * Add an initially selected option.
     *
     * @param mixed $initialOption
     *
     * @return $this
     *
     * @throws InvalidArgumentException
     */
    public function addInitialOption($initialOption)
    {
        if (is_array($initialOption)) {
            $initialOption = new Option($initialOption);
        }

        if ($initialOption instanceof Option) {
            $this->initial_options[] = $initialOption;

            return $this;
        }

        throw new InvalidArgumentException('The initial option must be an instance of '.Option::class.' or a keyed array');
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

        if ($this->getMinQueryLength()) {
            $data['min_query_length'] = $this->getMinQueryLength();
        }

        $initialOptions = $this->getInitialOptions();

        if (count($initialOptions)) {
            $data['initial_options'] = array_map(function (Option $o) {
                return $o->toArray();
            }, $initialOptions);
        }

        if ($this->getConfirm()) {
            $data['confirm'] = $this->getConfirm()->toArray();
        }

        if ($this->getMaxSelectedItems()) {
            $data['max_selected_items'] = $this->getMaxSelectedItems();
        }

        return $data;
    }
}
