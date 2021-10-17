<?php
namespace Slack\Tests;

use InvalidArgumentException;
use Maknz\Slack\BlockElement;

class BlockElementUnitTest extends TestCase
{
    /**
     * @dataProvider factoryArrayProvider
     */
    public function testFactoryWithArray($type, $class)
    {
        $element = BlockElement::factory([
            'type' => $type,
        ]);

        $this->assertInstanceOf($class, $element);
    }

    public function factoryArrayProvider()
    {
        return [
            ['button',                     BlockElement\Button::class],
            ['checkboxes',                 BlockElement\Checkboxes::class],
            ['datepicker',                 BlockElement\DatePicker::class],
            ['timepicker',                 BlockElement\Timepicker::class],
            ['image',                      BlockElement\Image::class],
            ['multi_static_select',        BlockElement\MultiStaticSelect::class],
            ['multi_external_select',      BlockElement\MultiExternalSelect::class],
            ['multi_users_select',         BlockElement\MultiUsersSelect::class],
            ['multi_conversations_select', BlockElement\MultiConversationsSelect::class],
            ['multi_channels_select',      BlockElement\MultiChannelsSelect::class],
            ['overflow',                   BlockElement\Overflow::class],
            ['plain_text_input',           BlockElement\TextInput::class],
            ['radio_buttons',              BlockElement\RadioButtons::class],
            ['static_select',              BlockElement\StaticSelect::class],
            ['external_select',            BlockElement\ExternalSelect::class],
            ['users_select',               BlockElement\UsersSelect::class],
            ['conversations_select',       BlockElement\ConversationsSelect::class],
            ['channels_select',            BlockElement\ChannelsSelect::class],
        ];
    }

    public function testFactoryMissingType()
    {
        $this->expectException(InvalidArgumentException::class);
        $this->expectExceptionMessage('Cannot create BlockElement without a type attribute');
        $element = BlockElement::factory([]);
    }

    public function testFactoryInvalidType()
    {
        $this->expectException(InvalidArgumentException::class);
        $this->expectExceptionMessage('Invalid Block type "invalid"');
        $element = BlockElement::factory([
            'type' => 'invalid',
        ]);
    }

    public function testFactoryInvalidArgument()
    {
        $this->expectException(InvalidArgumentException::class);
        $this->expectExceptionMessage('The attributes must be a Maknz\\Slack\\BlockElement or keyed array');
        $element = BlockElement::factory('Invalid');
    }

    public function testFactoryPassthrough()
    {
        $element = BlockElement::factory([
            'type' => 'button',
        ]);

        $this->assertSame($element, BlockElement::factory($element));
    }
}
