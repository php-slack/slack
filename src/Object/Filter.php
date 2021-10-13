<?php
namespace Maknz\Slack\Object;

use InvalidArgumentException;

class Filter extends CompositionObject
{
    /**
     * Types of conversations to include in the list.
     *
     * @var string[]
     */
    protected $types;

    /**
     * Whether to exclude shared channels from other organisations.
     *
     * @var bool
     */
    protected $exclude_shared_channels = false;

    /**
     * Whether to exclude bot users.
     *
     * @var bool
     */
    protected $exclude_bots = false;

    /**
     * Internal attribute to property map.
     *
     * @var array
     */
    protected static $availableAttributes = [
        'include'                          => 'types',
        'exclude_external_shared_channels' => 'exclude_shared_channels',
        'exclude_bot_users'                => 'exclude_bots',
    ];

    /**
     * Get the types of conversations to be included.
     *
     * @return string[]
     */
    public function getTypes()
    {
        return $this->types;
    }

    /**
     * Set the types of conversations to be included.
     *
     * @param string[] $text
     *
     * @return $this
     *
     * @throws \InvalidArgumentException
     */
    public function setTypes(array $types)
    {
        $validTypes = ['im', 'mpim', 'private', 'public'];

        foreach ($types as $type) {
            if ( ! in_array($type, $validTypes)) {
                throw new InvalidArgumentException("Invalid filter include type '$type'; must be one of: ".implode(',', $validTypes));
            }
        }

        $this->types = $types;

        return $this;
    }

    /**
     * Get whether shared channels from other organisations are excluded.
     *
     * @return bool
     */
    public function areSharedChannelsExcluded()
    {
        return $this->exclude_shared_channels;
    }

    /**
     * Set whether shared channels from other organisations are excluded.
     *
     * @param bool $excludeSharedChannels
     *
     * @return $this
     */
    public function setExcludeSharedChannels($excludeSharedChannels = true)
    {
        $this->exclude_shared_channels = (bool)$excludeSharedChannels;

        return $this;
    }

    /**
     * Get whether bots are excluded.
     *
     * @return bool
     */
    public function areBotsExcluded()
    {
        return $this->exclude_bots;
    }

    /**
     * Set whether bots are excluded.
     *
     * @param bool $excludeBots
     *
     * @return $this
     */
    public function setExcludeBots($excludeBots = true)
    {
        $this->exclude_bots = (bool)$excludeBots;

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
            'include'                          => $this->getTypes(),
            'exclude_external_shared_channels' => $this->areSharedChannelsExcluded(),
            'exclude_bot_users'                => $this->areBotsExcluded(),
        ];

        return $data;
    }
}
