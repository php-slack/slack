<?php
namespace Maknz\Slack;

use InvalidArgumentException;

abstract class BlockElement extends Payload
{
    /**
     * Element type.
     *
     * @var string
     */
    protected $type;

    /**
     * List of blocks each element is valid for.
     *
     * @var array
     */
    protected static $validFor = [
        'button'                     => ['Button',                   ['section', 'actions']],
        'checkboxes'                 => ['Checkboxes',               ['section', 'actions', 'input']],
        'datepicker'                 => ['DatePicker',               ['section', 'actions', 'input']],
        'timepicker'                 => ['Timepicker',               ['section', 'actions', 'input']],
        'image'                      => ['Image',                    ['section', 'context']],
        'multi_static_select'        => ['MultiStaticSelect',        ['section', 'input']],
        'multi_external_select'      => ['MultiExternalSelect',      ['section', 'input']],
        'multi_users_select'         => ['MultiUsersSelect',         ['section', 'input']],
        'multi_conversations_select' => ['MultiConversationsSelect', ['section', 'input']],
        'multi_channels_select'      => ['MultiChannelsSelect',      ['section', 'input']],
        'overflow'                   => ['Overflow',                 ['section', 'actions']],
        'plain_text_input'           => ['TextInput',                ['input']],
        'radio_buttons'              => ['RadioButtons',             ['section', 'actions', 'input']],
        'static_select'              => ['StaticSelect',             ['section', 'actions', 'input']],
        'external_select'            => ['ExternalSelect',           ['section', 'actions', 'input']],
        'users_select'               => ['UsersSelect',              ['section', 'actions', 'input']],
        'conversations_select'       => ['ConversationsSelect',      ['section', 'actions', 'input']],
        'channels_select'            => ['ChannelsSelect',           ['section', 'actions', 'input']],

        // Context Block allows a Text object to be used directly, so need to map types here
        'plain_text' => ['Text', ['context']],
        'mrkdwn'     => ['Text', ['context']],
    ];

    /**
     * Create a Block element from a keyed array of attributes.
     *
     * @param mixed $attributes
     *
     * @return BlockElement
     *
     * @throws \InvalidArgumentException
     */
    public static function factory($attributes)
    {
        if ($attributes instanceof static) {
            return $attributes;
        }

        if ( ! is_array($attributes)) {
            throw new InvalidArgumentException('The attributes must be a '.static::class.' or keyed array');
        }

        if ( ! isset($attributes['type'])) {
            throw new InvalidArgumentException('Cannot create BlockElement without a type attribute');
        }

        $validElements = array_keys(static::$validFor);

        if ( ! in_array($attributes['type'], $validElements)) {
            throw new InvalidArgumentException('Invalid Block type "'.$attributes['type'].'". Must be one of: '.implode(', ', $validElements).'.');
        }

        $className = __NAMESPACE__.'\\BlockElement\\'.static::$validFor[$attributes['type']][0];

        return new $className($attributes);
    }

    /**
     * Check if an element is valid for a Block.
     *
     * @param Block $block
     *
     * @return bool
     */
    public function isValidFor(Block $block)
    {
        $blockType = $block->getType();
        $validBlocks = static::$validFor[$this->getType()][1];

        return in_array($blockType, $validBlocks);
    }

    /**
     * Get the block type.
     *
     * @return string
     */
    public function getType()
    {
        return $this->type;
    }
}
