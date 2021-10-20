<?php
namespace Slack\Tests\BlockElement;

use InvalidArgumentException;
use Maknz\Slack\BlockElement\MultiChannelsSelect;
use Maknz\Slack\BlockElement\Text;
use Slack\Tests\TestCase;

class MultiChannelsSelectUnitTest extends TestCase
{
    public function testMultiChannelsSelectFromArray()
    {
        $s = new MultiChannelsSelect([
            'placeholder' => 'Placeholder text',
            'action_id'   => 'Select action',
        ]);

        $this->assertSame(Text::TYPE_PLAIN, $s->getPlaceholder()->getType());
        $this->assertEmpty($s->getInitialChannels());
    }

    public function testSetInvalidChannels()
    {
        $s = new MultiChannelsSelect([]);

        $this->expectException(InvalidArgumentException::class);
        $this->expectExceptionMessage('The initial channel ID must be a string');

        $s->setInitialChannels([0]);
    }

    public function testSetChannelClearsPrevious()
    {
        $s = new MultiChannelsSelect([
            'initial_channels' => ['C123456'],
        ]);

        $c = $s->getInitialChannels();
        $this->assertEquals(['C123456'], $c);

        $s->setInitialChannels(['C987654']);

        $c = $s->getInitialChannels();
        $this->assertEquals(['C987654'], $c);
    }

    public function testAddChannelAppends()
    {
        $s = new MultiChannelsSelect([
            'initial_channels' => ['C123456'],
        ]);

        $c = $s->getInitialChannels();
        $this->assertEquals(['C123456'], $c);

        $s->addInitialChannel('C987654');
        $c = $s->getInitialChannels();
        $this->assertEquals(['C123456', 'C987654'], $c);
    }

    public function testMaxSelectedItemsString()
    {
        $s = new MultiChannelsSelect([]);

        $this->expectException(InvalidArgumentException::class);
        $this->expectExceptionMessage('The max selected items must be a positive integer');
        $s->setMaxSelectedItems('Invalid');
    }

    public function testMaxSelectedItemsNegative()
    {
        $s = new MultiChannelsSelect([]);

        $this->expectException(InvalidArgumentException::class);
        $this->expectExceptionMessage('The max selected items must be a positive integer');
        $s->setMaxSelectedItems(-5);
    }

    public function testToArray()
    {
        $s = new MultiChannelsSelect([
            'placeholder'        => 'Placeholder text',
            'action_id'          => 'Select action',
            'initial_channels'   => ['C123456'],
            'max_selected_items' => 2,
            'confirm'          => [
                'title'   => 'Confirmation title',
                'text'    => 'Confirmation text',
                'confirm' => 'Confirm',
                'deny'    => 'Deny',
            ],
        ]);

        $out = [
            'type'             => 'multi_channels_select',
            'placeholder'      => [
                'type'  => Text::TYPE_PLAIN,
                'text'  => 'Placeholder text',
                'emoji' => false,
            ],
            'action_id'        => 'Select action',
            'initial_channels' => ['C123456'],
            'confirm'          => [
                'title'   => [
                    'type'  => Text::TYPE_PLAIN,
                    'text'  => 'Confirmation title',
                    'emoji' => false,
                ],
                'text'    => [
                    'type'  => Text::TYPE_PLAIN,
                    'text'  => 'Confirmation text',
                    'emoji' => false,
                ],
                'confirm' => [
                    'type'  => Text::TYPE_PLAIN,
                    'text'  => 'Confirm',
                    'emoji' => false,
                ],
                'deny'    => [
                    'type'  => Text::TYPE_PLAIN,
                    'text'  => 'Deny',
                    'emoji' => false,
                ],
            ],
            'max_selected_items' => 2,
        ];

        $this->assertEquals($out, $s->toArray());
    }

    public function testToArrayNoInitialChannels()
    {
        $s = new MultiChannelsSelect([
            'placeholder' => 'Placeholder text',
            'action_id'   => 'Select action',
        ]);

        $out = [
            'type'        => 'multi_channels_select',
            'placeholder' => [
                'type'  => Text::TYPE_PLAIN,
                'text'  => 'Placeholder text',
                'emoji' => false,
            ],
            'action_id'   => 'Select action',
        ];

        $this->assertEquals($out, $s->toArray());
    }
}
