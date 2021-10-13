<?php
namespace Maknz\Slack\BlockElement;

use InvalidArgumentException;
use Maknz\Slack\FilterTrait;

class ConversationsSelect extends RespondableSelect
{
    use FilterTrait;

    /**
     * Block type.
     *
     * @var string
     */
    protected $type = 'conversations_select';

    /**
     * The initially selected conversation.
     *
     * @var string
     */
    protected $initial_conversation;

    /**
     * Whether to initially select the current conversation.
     *
     * @var bool
     */
    protected $default_to_current_conversation = false;

    /**
     * Internal attribute to property map.
     *
     * @var array
     */
    protected static $availableAttributes = [
        'placeholder'                     => 'placeholder',
        'action_id'                       => 'action_id',
        'initial_conversation'            => 'initial_conversation',
        'default_to_current_conversation' => 'default_to_current_conversation',
        'confirm'                         => 'confirm',
        'response_url_enabled'            => 'response_url_enabled',
        'filter'                          => 'filter',
    ];

    /**
     * Get the initially selected conversation.
     *
     * @return string
     */
    public function getInitialConversation()
    {
        return $this->initial_conversation;
    }

    /**
     * Set the initially selected conversation.
     *
     * @param string $initialConversation
     *
     * @return $this
     *
     * @throws InvalidArgumentException
     */
    public function setInitialConversation($initialConversation)
    {
        if (is_string($initialConversation)) {
            $this->initial_conversation = $initialConversation;

            return $this;
        }

        throw new InvalidArgumentException('The initial conversation ID must be a string');
    }

    /**
     * Get whether to default to the current conversation.
     *
     * @return bool
     */
    public function getDefaultToCurrentConversation()
    {
        return $this->default_to_current_conversation;
    }

    /**
     * Set whether to default to the current conversation.
     *
     * @param string $defaultToCurrentConversation
     *
     * @return $this
     */
    public function setDefaultToCurrentConversation($defaultToCurrentConversation)
    {
        $this->default_to_current_conversation = (bool)$defaultToCurrentConversation;

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

        if ($this->getInitialConversation()) {
            $data['initial_conversation'] = $this->getInitialConversation();
        } elseif ($this->getDefaultToCurrentConversation()) {
            $data['default_to_current_conversation'] = true;
        }

        if ($this->getConfirm()) {
            $data['confirm'] = $this->getConfirm()->toArray();
        }

        if ($this->isResponseUrlEnabled()) {
            $data['response_url_enabled'] = true;
        }

        if ($this->getFilter()) {
            $data['filter'] = $this->getFilter()->toArray();
        }

        return $data;
    }
}
