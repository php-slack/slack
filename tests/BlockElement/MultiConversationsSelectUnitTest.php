<?php
namespace Slack\Tests\BlockElement;

use InvalidArgumentException;
use Maknz\Slack\BlockElement\MultiConversationsSelect;
use Maknz\Slack\BlockElement\Text;
use Slack\Tests\TestCase;

class MultiConversationsSelectUnitTest extends TestCase
{
    public function testMultiConversationsSelectFromArray()
    {
        $s = new MultiConversationsSelect([
            'placeholder' => 'Placeholder text',
            'action_id'   => 'Select action',
        ]);

        $this->assertSame(Text::TYPE_PLAIN, $s->getPlaceholder()->getType());
        $this->assertNull($s->getInitialConversations());
    }

    public function testSetInvalidConversations()
    {
        $s = new MultiConversationsSelect([]);

        $this->expectException(InvalidArgumentException::class);
        $this->expectExceptionMessage('The initial conversation ID must be a string');

        $s->setInitialConversations([0]);
    }

    public function testSetConversationClearsPrevious()
    {
        $s = new MultiConversationsSelect([
            'initial_conversations' => ['C123456'],
        ]);

        $c = $s->getInitialConversations();
        $this->assertEquals(['C123456'], $c);

        $s->setInitialConversations(['C987654']);

        $c = $s->getInitialConversations();
        $this->assertEquals(['C987654'], $c);
    }

    public function testAddConversationAppends()
    {
        $s = new MultiConversationsSelect([
            'initial_conversations' => ['C123456'],
        ]);

        $c = $s->getInitialConversations();
        $this->assertEquals(['C123456'], $c);

        $s->addInitialConversation('C987654');
        $c = $s->getInitialConversations();
        $this->assertEquals(['C123456', 'C987654'], $c);
    }

    public function testDefaultToCurrentConversationTakesPrecedence()
    {
        $s = new MultiConversationsSelect([
            'placeholder'           => 'Placeholder text',
            'action_id'             => 'Select action',
            'initial_conversations' => ['C123456'],
        ]);

        $this->assertArrayHasKey('initial_conversations', $s->toArray());
        $s->setDefaultToCurrentConversation(true);
        $this->assertArrayNotHasKey('initial_conversation', $s->toArray());
        $this->assertArrayHasKey('default_to_current_conversation', $s->toArray());
    }

    public function testToArray()
    {
        $s = new MultiConversationsSelect([
            'placeholder'           => 'Placeholder text',
            'action_id'             => 'Select action',
            'initial_conversations' => ['C123456'],
            'response_url_enabled'  => true,
            'max_selected_items'    => 5,
            'filter'                => ['include' => ['public']],
            'confirm'               => [
                'title'   => 'Confirmation title',
                'text'    => 'Confirmation text',
                'confirm' => 'Confirm',
                'deny'    => 'Deny',
            ],
        ]);

        $out = [
            'type'                  => 'multi_conversations_select',
            'placeholder'           => [
                'type'  => Text::TYPE_PLAIN,
                'text'  => 'Placeholder text',
                'emoji' => false,
            ],
            'action_id'             => 'Select action',
            'initial_conversations' => ['C123456'],
            'confirm'               => [
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
            'max_selected_items' => 5,
            'filter' => [
                'include'                          => ['public'],
                'exclude_external_shared_channels' => false,
                'exclude_bot_users'                => false,
            ],
        ];

        $this->assertEquals($out, $s->toArray());
    }
}
