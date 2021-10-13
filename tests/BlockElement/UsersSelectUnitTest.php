<?php
namespace Slack\Tests\BlockElement;

use InvalidArgumentException;
use Maknz\Slack\BlockElement\Text;
use Maknz\Slack\BlockElement\UsersSelect;
use Slack\Tests\TestCase;

class UsersSelectUnitTest extends TestCase
{
    public function testUsersSelectFromArray()
    {
        $s = new UsersSelect([
            'placeholder' => 'Placeholder text',
            'action_id'   => 'Select action',
        ]);

        $this->assertSame(Text::TYPE_PLAIN, $s->getPlaceholder()->getType());
        $this->assertNull($s->getInitialUser());
    }

    public function testSetInvalidUser()
    {
        $s = new UsersSelect([]);

        $this->expectException(InvalidArgumentException::class);
        $this->expectExceptionMessage('The initial user ID must be a string');

        $s->setInitialUser(0);
    }

    public function testSetUser()
    {
        $s = new UsersSelect([]);

        $this->assertNull($s->getInitialUser());
        $s->setInitialUser('user_1');
        $this->assertSame('user_1', $s->getInitialUser());
    }

    public function testToArray()
    {
        $s = new UsersSelect([
            'placeholder'    => 'Placeholder text',
            'action_id'      => 'Select action',
            'initial_user'   => 'user_1',
            'confirm'        => [
                'title'   => 'Confirmation title',
                'text'    => 'Confirmation text',
                'confirm' => 'Confirm',
                'deny'    => 'Deny',
            ],
        ]);

        $out = [
            'type'         => 'users_select',
            'placeholder'  => [
                'type' => Text::TYPE_PLAIN,
                'text' => 'Placeholder text',
                'emoji' => false,
            ],
            'action_id'    => 'Select action',
            'initial_user' => 'user_1',
            'confirm'      => [
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
}
