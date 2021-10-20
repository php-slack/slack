<?php
namespace Maknz\Slack\BlockElement;

use InvalidArgumentException;
use Maknz\Slack\FilterTrait;

class MultiConversationsSelect extends MultiDynamicSelect
{
    use FilterTrait;

    /**
     * Block type.
     *
     * @var string
     */
    protected $type = 'multi_conversations_select';

    /**
     * Initially selected conversations.
     *
     * @var string[]
     */
    protected $initial_conversations = [];

    /**
     * Whether to default to the current conversation.
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
        'initial_conversations'           => 'initial_conversations',
        'default_to_current_conversation' => 'default_to_current_conversation',
        'confirm'                         => 'confirm',
        'max_selected_items'              => 'max_selected_items',
        'filter'                          => 'filter',
    ];

    /**
     * Get the initially selected conversations.
     *
     * @return string[]
     */
    public function getInitialConversations()
    {
        return $this->initial_conversations;
    }

    /**
     * Set the initially selected conversations.
     *
     * @param string[] $initialConversations
     *
     * @return $this
     *
     * @throws InvalidArgumentException
     */
    public function setInitialConversations(array $initialConversations)
    {
        $this->clearInitialConversations();

        foreach ($initialConversations as $initialConversation) {
            $this->addInitialConversation($initialConversation);
        }

        return $this;
    }

    /**
     * Clear the initially selected conversations.
     *
     * @return $this
     */
    public function clearInitialConversations()
    {
        $this->initial_conversations = [];

        return $this;
    }

    /**
     * Add an initially selected conversation.
     *
     * @param string $initialConversation
     *
     * @return $this
     *
     * @throws InvalidArgumentException
     */
    public function addInitialConversation($initialConversation)
    {
        if (is_string($initialConversation)) {
            $this->initial_conversations[] = $initialConversation;

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
     * @param bool $defaultToCurrentConversation
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

        $initialConversations = $this->getInitialConversations();

        if ($this->getDefaultToCurrentConversation()) {
            $data['default_to_current_conversation'] = true;
        } elseif (count($initialConversations)) {
            $data['initial_conversations'] = $initialConversations;
        }

        if ($this->getConfirm()) {
            $data['confirm'] = $this->getConfirm()->toArray();
        }

        if ($this->getMaxSelectedItems()) {
            $data['max_selected_items'] = $this->getMaxSelectedItems();
        }

        if ($this->getFilter()) {
            $data['filter'] = $this->getFilter()->toArray();
        }

        return $data;
    }
}
