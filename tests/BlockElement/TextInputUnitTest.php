<?php
namespace Slack\Tests\BlockElement;

use InvalidArgumentException;
use Maknz\Slack\BlockElement\Text;
use Maknz\Slack\BlockElement\TextInput;
use Slack\Tests\TestCase;

class TextInputUnitTest extends TestCase
{
    public function testTextInputFromArray()
    {
        $t = new TextInput([
            'action_id' => 'input_action',
            'placeholder' => 'Placeholder text',
        ]);

        $this->assertSame('input_action', $t->getActionId());

        $this->assertSame(Text::TYPE_PLAIN, $t->getPlaceholder()->getType());

        $this->assertSame('Placeholder text', $t->getPlaceholder()->getText());
    }

    public function testDispatchConfig()
    {
        $t = new TextInput([
            'action_id' => 'input_action',
            'placeholder' => 'Placeholder text',
        ]);

        $t->setDispatchConfig(['on_enter_pressed']);
        $out = $t->toArray();
        $this->assertArrayHasKey('dispatch_action_config', $out);
        $this->assertSame(['trigger_actions_on' => ['on_enter_pressed']], $out['dispatch_action_config']);
    }

    public function testInvalidDispatchConfig()
    {
        $t = new TextInput([]);

        $this->expectException(InvalidArgumentException::class);
        $this->expectExceptionMessage("Invalid dispatch config 'Invalid'; must be one of: on_enter_pressed,on_character_entered");

        $t->setDispatchConfig(['Invalid']);
    }

    public function testToArray()
    {
        $t = new TextInput([
            'action_id' => 'input_action',
            'placeholder' => 'Placeholder text',
            'initial_value' => 'Initial value',
            'min_length' => 5,
            'max_length' => 20,
        ]);

        $out = [
            'type' => 'plain_text_input',
            'action_id' => 'input_action',
            'placeholder' => [
                'type' => Text::TYPE_PLAIN,
                'text' => 'Placeholder text',
                'emoji' => false,
            ],
            'initial_value' => 'Initial value',
            'min_length' => 5,
            'max_length' => 20,
        ];

        $this->assertEquals($out, $t->toArray());
    }

    public function testToArrayWithMultiline()
    {
        $t = new TextInput([
            'action_id' => 'input_action',
            'placeholder' => 'Placeholder text',
            'initial_value' => 'Initial value',
            'min_length' => 5,
            'max_length' => 20,
            'multiline' => true,
        ]);

        $out = [
            'type' => 'plain_text_input',
            'action_id' => 'input_action',
            'placeholder' => [
                'type' => Text::TYPE_PLAIN,
                'text' => 'Placeholder text',
                'emoji' => false,
            ],
            'initial_value' => 'Initial value',
            'min_length' => 5,
            'max_length' => 20,
            'multiline' => true,
        ];

        $this->assertEquals($out, $t->toArray());
    }
}
