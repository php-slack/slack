<?php
namespace Maknz\Slack\BlockElement;

use InvalidArgumentException;

class MultiChannelsSelect extends MultiDynamicSelect
{
    /**
     * Block type.
     *
     * @var string
     */
    protected $type = 'multi_channels_select';

    /**
     * Initially selected channels.
     *
     * @var string[]
     */
    protected $initial_channels = [];

    /**
     * Internal attribute to property map.
     *
     * @var array
     */
    protected static $availableAttributes = [
        'placeholder'        => 'placeholder',
        'action_id'          => 'action_id',
        'initial_channels'   => 'initial_channels',
        'confirm'            => 'confirm',
        'max_selected_items' => 'max_selected_items',
    ];

    /**
     * Get the initially selected channels.
     *
     * @return string[]
     */
    public function getInitialChannels()
    {
        return $this->initial_channels;
    }

    /**
     * Set the initially selected channels.
     *
     * @param string[] $initialChannels
     *
     * @return $this
     *
     * @throws InvalidArgumentException
     */
    public function setInitialChannels(array $initialChannels)
    {
        $this->clearInitialChannels();

        foreach ($initialChannels as $initialChannel) {
            $this->addInitialChannel($initialChannel);
        }

        return $this;
    }

    /**
     * Clear the initially selected channels.
     *
     * @return $this
     */
    public function clearInitialChannels()
    {
        $this->initial_channels = [];

        return $this;
    }

    /**
     * Add an initially selected channel.
     *
     * @param string $initialChannels
     *
     * @return $this
     *
     * @throws InvalidArgumentException
     */
    public function addInitialChannel($initialChannel)
    {
        if (is_string($initialChannel)) {
            $this->initial_channels[] = $initialChannel;

            return $this;
        }

        throw new InvalidArgumentException('The initial channel ID must be a string');
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

        $initialChannels = $this->getInitialChannels();

        if (count($initialChannels)) {
            $data['initial_channels'] = $initialChannels;
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
