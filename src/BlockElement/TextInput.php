<?php
namespace Maknz\Slack\BlockElement;

use InvalidArgumentException;
use Maknz\Slack\BlockElement;
use Maknz\Slack\PlaceholderTrait;

class TextInput extends BlockElement
{
    use PlaceholderTrait;

    /**
     * Block type.
     *
     * @var string
     */
    protected $type = 'plain_text_input';

    /**
     * Input action.
     *
     * @var string
     */
    protected $action_id;

    /**
     * Input initial value.
     *
     * @var string
     */
    protected $initial_value;

    /**
     * Whether the input spans multiple lines.
     *
     * @var bool
     */
    protected $multiline = false;

    /**
     * Minimum length of the input.
     *
     * @var int
     */
    protected $min_length;

    /**
     * Maximum length of the input.
     *
     * @var int
     */
    protected $max_length;

    /**
     * When the element should return its payload.
     *
     * @var string[]
     */
    protected $dispatch_config;

    /**
     * Internal attribute to property map.
     *
     * @var array
     */
    protected static $availableAttributes = [
        'action_id'              => 'action_id',
        'placeholder'            => 'placeholder',
        'initial_value'          => 'initial_value',
        'multiline'              => 'multiline',
        'min_length'             => 'min_length',
        'max_length'             => 'max_length',
        'dispatch_action_config' => 'dispatch_config',
    ];

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
     * Get the initial value.
     *
     * @return string
     */
    public function getInitialValue()
    {
        return $this->initial_value;
    }

    /**
     * Set the initial value.
     *
     * @param string $initialValue
     *
     * @return $this
     */
    public function setInitialValue($initialValue)
    {
        $this->initial_value = $initialValue;

        return $this;
    }

    /**
     * Get whether the input spans multiple lines.
     *
     * @return bool
     */
    public function getMultiline()
    {
        return $this->multiline;
    }

    /**
     * Set whether the input spans multiple lines.
     *
     * @param bool $multiline
     *
     * @return $this
     */
    public function setMultiline($multiline)
    {
        $this->multiline = (bool)$multiline;

        return $this;
    }

    /**
     * Get the input minimum length.
     *
     * @return int
     */
    public function getMinLength()
    {
        return $this->min_length;
    }

    /**
     * Set the input minimum length.
     *
     * @param int $minLength
     *
     * @return $this
     */
    public function setMinLength($minLength)
    {
        $this->min_length = $minLength;

        return $this;
    }

    /**
     * Get the input maximum length.
     *
     * @return int
     */
    public function getMaxLength()
    {
        return $this->max_length;
    }

    /**
     * Set the input maximum length.
     *
     * @param int $maxLength
     *
     * @return $this
     */
    public function setMaxLength($maxLength)
    {
        $this->max_length = $maxLength;

        return $this;
    }

    /**
     * Get the input dispatch config.
     *
     * @return string[]
     */
    public function getDispatchConfig()
    {
        return $this->dispatch_config;
    }

    /**
     * Set the input dispatch config.
     *
     * @param string[] $dispatchConfig
     *
     * @return $this
     *
     * @throws InvalidArgumentException
     */
    public function setDispatchConfig(array $dispatchConfig)
    {
        $validConfig = ['on_enter_pressed', 'on_character_entered'];

        foreach ($dispatchConfig as $config) {
            if ( ! in_array($config, $validConfig)) {
                throw new InvalidArgumentException("Invalid dispatch config '$config'; must be one of: ".implode(',', $validConfig));
            }
        }

        $this->dispatch_config = $dispatchConfig;

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
            'type' => $this->getType(),
            'action_id' => $this->getActionId(),
        ];

        if ($this->getPlaceholder()) {
            $data['placeholder'] = $this->getPlaceholder()->toArray();
        }

        if ($this->getInitialValue()) {
            $data['initial_value'] = $this->getInitialValue();
        }

        if ($this->getMultiline() != null) {
            $data['multiline'] = $this->getMultiline();
        }

        if ($this->getMinLength()) {
            $data['min_length'] = $this->getMinLength();
        }

        if ($this->getMaxLength()) {
            $data['max_length'] = $this->getMaxLength();
        }

        if ($this->getDispatchConfig()) {
            $data['dispatch_action_config'] = [
                'trigger_actions_on' => $this->getDispatchConfig(),
            ];
        }

        return $data;
    }
}
