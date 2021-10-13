<?php
namespace Slack\Tests\BlockElement;

use InvalidArgumentException;
use Maknz\Slack\BlockElement\MultiExternalSelect;
use Maknz\Slack\BlockElement\Text;
use Slack\Tests\TestCase;

class MultiExternalSelectUnitTest extends TestCase
{
    public function testMultiExternalSelectFromArray()
    {
        $s = new MultiExternalSelect([
            'placeholder' => 'Placeholder text',
            'action_id'   => 'Select action',
        ]);

        $this->assertSame(Text::TYPE_PLAIN, $s->getPlaceholder()->getType());
    }

    public function testAddInvalidOption()
    {
        $s = new MultiExternalSelect([]);

        $this->expectException(InvalidArgumentException::class);
        $this->expectExceptionMessage('The initial option must be an instance of Maknz\\Slack\\Object\\Option or a keyed array');

        $s->setInitialOptions(['Invalid']);
    }

    public function testNothingInitiallySelected()
    {
        $s = new MultiExternalSelect([]);

        $this->assertNull($s->getInitialOptions());
    }

    public function testSetInitialOptionClearsPrevious()
    {
        $s = new MultiExternalSelect([
            'initial_options' => [[
                'text'  => 'Option 1',
                'value' => 'option_1',
            ]],
        ]);

        $opts = $s->getInitialOptions();
        $this->assertSame(1, count($opts));
        $this->assertSame('option_1', $opts[0]->getValue());

        $s->setInitialOptions([[
            'text'  => 'Option 2',
            'value' => 'option_2',
        ]]);

        $opts = $s->getInitialOptions();
        $this->assertSame(1, count($opts));
        $this->assertSame('option_2', $opts[0]->getValue());
    }

    public function testAddInitialOptionAppends()
    {
        $s = new MultiExternalSelect([
            'initial_options' => [[
                'text'  => 'Option 1',
                'value' => 'option_1',
            ]],
        ]);

        $opts = $s->getInitialOptions();
        $this->assertSame(1, count($opts));
        $this->assertSame('option_1', $opts[0]->getValue());

        $s->addInitialOption([
            'text'  => 'Option 2',
            'value' => 'option_2',
        ]);

        $opts = $s->getInitialOptions();
        $this->assertSame(2, count($opts));
        $this->assertSame('option_2', $opts[1]->getValue());
    }

    public function testInvalidMinQueryLength()
    {
        $s = new MultiExternalSelect([]);

        $this->expectException(InvalidArgumentException::class);
        $this->expectExceptionMessage('The minimum query length must be an integer');
        $s->setMinQueryLength('Invalid');
    }

    public function testToArray()
    {
        $s = new MultiExternalSelect([
            'placeholder'     => 'Placeholder text',
            'action_id'       => 'Select action',
            'initial_options' => [[
                'text'  => 'Option 1',
                'value' => 'option_1',
            ], [
                'text'  => 'Option 2',
                'value' => 'option_2',
            ]],
            'min_query_length' => 3,
            'max_selected_items' => 5,
            'confirm'   => [
                'title'   => 'Confirmation title',
                'text'    => 'Confirmation text',
                'confirm' => 'Confirm',
                'deny'    => 'Deny',
            ],
        ]);

        $out = [
            'type'        => 'multi_external_select',
            'placeholder' => [
                'type' => Text::TYPE_PLAIN,
                'text' => 'Placeholder text',
                'emoji' => false,
            ],
            'action_id'   => 'Select action',
            'initial_options' => [[
                'text'  => [
                    'type' => 'plain_text',
                    'text' => 'Option 1',
                    'emoji' => false,
                ],
                'value' => 'option_1',
            ], [
                'text'  => [
                    'type' => 'plain_text',
                    'text' => 'Option 2',
                    'emoji' => false,
                ],
                'value' => 'option_2',
            ]],
            'min_query_length' => 3,
            'confirm'   => [
                'title'   => [
                    'type' => Text::TYPE_PLAIN,
                    'text' => 'Confirmation title',
                    'emoji' => false,
                ],
                'text'    => [
                    'type' => Text::TYPE_PLAIN,
                    'text' => 'Confirmation text',
                    'emoji' => false,
                ],
                'confirm' => [
                    'type' => Text::TYPE_PLAIN,
                    'text' => 'Confirm',
                    'emoji' => false,
                ],
                'deny'    => [
                    'type' => Text::TYPE_PLAIN,
                    'text' => 'Deny',
                    'emoji' => false,
                ],
            ],
            'max_selected_items' => 5,
        ];

        $this->assertEquals($out, $s->toArray());
    }

    public function testClearInitialOptions()
    {
        $s = new MultiExternalSelect([
            'placeholder'    => 'Placeholder text',
            'action_id'      => 'Select action',
            'initial_options' => [[
                'text'  => 'Option 1',
                'value' => 'option_1',
            ]],
        ]);

        $this->assertArrayHasKey('initial_options', $s->toArray());
        $s->clearInitialOptions();
        $this->assertArrayNotHasKey('initial_options', $s->toArray());
    }
}
