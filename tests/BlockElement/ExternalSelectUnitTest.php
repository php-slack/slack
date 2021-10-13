<?php
namespace Slack\Tests\BlockElement;

use InvalidArgumentException;
use Maknz\Slack\BlockElement\ExternalSelect;
use Maknz\Slack\BlockElement\Text;
use Slack\Tests\TestCase;

class ExternalSelectUnitTest extends TestCase
{
    public function testExternalSelectFromArray()
    {
        $s = new ExternalSelect([
            'placeholder' => 'Placeholder text',
            'action_id'   => 'Select action',
        ]);

        $this->assertSame(Text::TYPE_PLAIN, $s->getPlaceholder()->getType());
    }

    public function testAddInvalidOption()
    {
        $s = new ExternalSelect([]);

        $this->expectException(InvalidArgumentException::class);
        $this->expectExceptionMessage('The initial option must be an instance of Maknz\\Slack\\Object\\Option or a keyed array');

        $s->setInitialOption('Invalid');
    }

    public function testNothingInitiallySelected()
    {
        $s = new ExternalSelect([]);

        $this->assertNull($s->getInitialOption());
    }

    public function testInvalidMinQueryLength()
    {
        $s = new ExternalSelect([]);

        $this->expectException(InvalidArgumentException::class);
        $this->expectExceptionMessage('The minimum query length must be an integer');
        $s->setMinQueryLength('Invalid');
    }

    public function testToArray()
    {
        $s = new ExternalSelect([
            'placeholder'     => 'Placeholder text',
            'action_id'       => 'Select action',
            'initial_option'  => [
                'text'  => 'Option 1',
                'value' => 'option_1',
            ],
            'min_query_length' => 3,
            'confirm'   => [
                'title'   => 'Confirmation title',
                'text'    => 'Confirmation text',
                'confirm' => 'Confirm',
                'deny'    => 'Deny',
            ],
        ]);

        $out = [
            'type'        => 'external_select',
            'placeholder' => [
                'type' => Text::TYPE_PLAIN,
                'text' => 'Placeholder text',
                'emoji' => false,
            ],
            'action_id'   => 'Select action',
            'initial_option' => [
                'text'  => [
                    'type' => 'plain_text',
                    'text' => 'Option 1',
                    'emoji' => false,
                ],
                'value' => 'option_1',
            ],
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
        ];

        $this->assertEquals($out, $s->toArray());
    }

    public function testClearInitialOption()
    {
        $s = new ExternalSelect([
            'placeholder'    => 'Placeholder text',
            'action_id'      => 'Select action',
            'initial_option' => [
                'text'  => 'Option 1',
                'value' => 'option_1',
            ],
        ]);

        $this->assertArrayHasKey('initial_option', $s->toArray());
        $s->clearInitialOption();
        $this->assertArrayNotHasKey('initial_option', $s->toArray());
    }
}
