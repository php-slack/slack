<?php
namespace Slack\Tests\BlockElement;

use InvalidArgumentException;
use Maknz\Slack\BlockElement\ChannelsSelect;
use Maknz\Slack\BlockElement\Text;
use Slack\Tests\TestCase;

class ChannelsSelectUnitTest extends TestCase
{
    public function testChannelsSelectFromArray()
    {
        $s = new ChannelsSelect([
            'placeholder' => 'Placeholder text',
            'action_id'   => 'Select action',
        ]);

        $this->assertSame(Text::TYPE_PLAIN, $s->getPlaceholder()->getType());
        $this->assertNull($s->getInitialChannel());
    }

    public function testSetInvalidChannel()
    {
        $s = new ChannelsSelect([]);

        $this->expectException(InvalidArgumentException::class);
        $this->expectExceptionMessage('The initial channel ID must be a string');

        $s->setInitialChannel(0);
    }

    public function testSetChannel()
    {
        $s = new ChannelsSelect([]);

        $this->assertNull($s->getInitialChannel());
        $s->setInitialChannel('C123456');
        $this->assertSame('C123456', $s->getInitialChannel());
    }

    public function testToArray()
    {
        $s = new ChannelsSelect([
            'placeholder'          => 'Placeholder text',
            'action_id'            => 'Select action',
            'initial_channel'      => 'C123456',
            'response_url_enabled' => true,
            'confirm'         => [
                'title'   => 'Confirmation title',
                'text'    => 'Confirmation text',
                'confirm' => 'Confirm',
                'deny'    => 'Deny',
            ],
        ]);

        $out = [
            'type'            => 'channels_select',
            'placeholder'     => [
                'type' => Text::TYPE_PLAIN,
                'text' => 'Placeholder text',
                'emoji' => false,
            ],
            'action_id'       => 'Select action',
            'initial_channel' => 'C123456',
            'confirm'         => [
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
            'response_url_enabled' => true,
        ];

        $this->assertEquals($out, $s->toArray());
    }
}
