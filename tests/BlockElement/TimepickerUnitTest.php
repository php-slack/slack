<?php
namespace Slack\Tests\BlockElement;

use DateTime;
use Maknz\Slack\BlockElement\Text;
use Maknz\Slack\BlockElement\Timepicker;
use Slack\Tests\TestCase;

class TimepickerUnitTest extends TestCase
{
    public function testTimepickerFromArray()
    {
        $time = new DateTime('12:28');

        $t = new Timepicker([
            'action_id'    => 'Time action',
            'placeholder'  => 'Time placeholder',
            'initial_time' => $time,
        ]);

        $this->assertSame(Text::TYPE_PLAIN, $t->getPlaceholder()->getType());

        $this->assertSame('Time placeholder', $t->getPlaceholder()->getText());

        $this->assertSame($time, $t->getInitialTime());
    }

    public function testSetInitialTime()
    {
        $time = new DateTime('12:28');

        $t = new Timepicker([]);
        $t->setInitialTime($time);
        $this->assertSame($time, $t->getInitialTime());
    }

    public function testToArray()
    {
        $time = new DateTime('12:28');

        $t = new Timepicker([
            'action_id'    => 'Time action',
            'placeholder'  => 'Time placeholder',
            'initial_time' => $time,
            'confirm'   => [
                'title'   => 'Confirmation title',
                'text'    => 'Confirmation text',
                'confirm' => 'Confirm',
                'deny'    => 'Deny',
            ],
        ]);

        $out = [
            'type' => 'timepicker',
            'action_id' => 'Time action',
            'initial_time' => '12:28',
            'placeholder' => [
                'type' => Text::TYPE_PLAIN,
                'text' => 'Time placeholder',
                'emoji' => false,
            ],
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

        $this->assertEquals($out, $t->toArray());
    }
}
