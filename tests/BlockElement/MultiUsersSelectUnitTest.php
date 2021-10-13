<?php
namespace Slack\Tests\BlockElement;

use InvalidArgumentException;
use Maknz\Slack\BlockElement\MultiUsersSelect;
use Maknz\Slack\BlockElement\Text;
use Slack\Tests\TestCase;

class MultiUsersSelectUnitTest extends TestCase
{
    public function testMultiUsersSelectFromArray()
    {
        $s = new MultiUsersSelect([
            'placeholder' => 'Placeholder text',
            'action_id'   => 'Select action',
        ]);

        $this->assertSame(Text::TYPE_PLAIN, $s->getPlaceholder()->getType());
        $this->assertNull($s->getInitialUsers());
    }

    public function testSetInvalidUsers()
    {
        $s = new MultiUsersSelect([]);

        $this->expectException(InvalidArgumentException::class);
        $this->expectExceptionMessage('The initial user ID must be a string');

        $s->setInitialUsers([0]);
    }

    public function testSetUserClearsPrevious()
    {
        $s = new MultiUsersSelect([
            'initial_users' => ['U123456'],
        ]);

        $c = $s->getInitialUsers();
        $this->assertEquals(['U123456'], $c);

        $s->setInitialUsers(['U987654']);

        $c = $s->getInitialUsers();
        $this->assertEquals(['U987654'], $c);
    }

    public function testAddUserAppends()
    {
        $s = new MultiUsersSelect([
            'initial_users' => ['U123456'],
        ]);

        $c = $s->getInitialUsers();
        $this->assertEquals(['U123456'], $c);

        $s->addInitialUser('U987654');
        $c = $s->getInitialUsers();
        $this->assertEquals(['U123456', 'U987654'], $c);
    }

    public function testMaxSelectedItemsString()
    {
        $s = new MultiUsersSelect([]);

        $this->expectException(InvalidArgumentException::class);
        $this->expectExceptionMessage('The max selected items must be a positive integer');
        $s->setMaxSelectedItems('Invalid');
    }

    public function testMaxSelectedItemsNegative()
    {
        $s = new MultiUsersSelect([]);

        $this->expectException(InvalidArgumentException::class);
        $this->expectExceptionMessage('The max selected items must be a positive integer');
        $s->setMaxSelectedItems(-5);
    }

    public function testToArray()
    {
        $s = new MultiUsersSelect([
            'placeholder'        => 'Placeholder text',
            'action_id'          => 'Select action',
            'initial_users'   => ['U123456'],
            'max_selected_items' => 2,
            'confirm'          => [
                'title'   => 'Confirmation title',
                'text'    => 'Confirmation text',
                'confirm' => 'Confirm',
                'deny'    => 'Deny',
            ],
        ]);

        $out = [
            'type'             => 'multi_users_select',
            'placeholder'      => [
                'type'  => Text::TYPE_PLAIN,
                'text'  => 'Placeholder text',
                'emoji' => false,
            ],
            'action_id'        => 'Select action',
            'initial_users' => ['U123456'],
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
}
