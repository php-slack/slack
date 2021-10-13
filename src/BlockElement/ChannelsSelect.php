<?php
namespace Maknz\Slack\BlockElement;

use InvalidArgumentException;

class ChannelsSelect extends RespondableSelect
{
    /**
     * Block type.
     *
     * @var string
     */
    protected $type = 'channels_select';

    /**
     * The initially selected channel.
     *
     * @var string
     */
    protected $initial_channel;

    /**
     * Internal attribute to property map.
     *
     * @var array
     */
    protected static $availableAttributes = [
        'placeholder'          => 'placeholder',
        'action_id'            => 'action_id',
        'initial_channel'      => 'initial_channel',
        'confirm'              => 'confirm',
        'response_url_enabled' => 'response_url_enabled',
    ];

    /**
     * Get the initially selected channel.
     *
     * @return string
     */
    public function getInitialChannel()
    {
        return $this->initial_channel;
    }

    /**
     * Set the initially selected channel.
     *
     * @param string $initialChannel
     *
     * @return $this
     *
     * @throws InvalidArgumentException
     */
    public function setInitialChannel($initialChannel)
    {
        if (is_string($initialChannel)) {
            $this->initial_channel = $initialChannel;

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

        if ($this->getInitialChannel()) {
            $data['initial_channel'] = $this->getInitialChannel();
        }

        if ($this->getConfirm()) {
            $data['confirm'] = $this->getConfirm()->toArray();
        }

        if ($this->isResponseUrlEnabled()) {
            $data['response_url_enabled'] = true;
        }

        return $data;
    }
}
