<?php
namespace Slack\Tests\BlockElement;

use InvalidArgumentException;
use Maknz\Slack\BlockElement\ConversationsSelect;
use Maknz\Slack\BlockElement\Text;
use Slack\Tests\TestCase;

class ConversationsSelectUnitTest extends TestCase
{
    public function testConversationsSelectFromArray()
    {
        $s = new ConversationsSelect([
            'placeholder' => 'Placeholder text',
            'action_id'   => 'Select action',
        ]);

        $this->assertSame(Text::TYPE_PLAIN, $s->getPlaceholder()->getType());
        $this->assertNull($s->getInitialConversation());
    }

    public function testSetInvalidConversation()
    {
        $s = new ConversationsSelect([]);

        $this->expectException(InvalidArgumentException::class);
        $this->expectExceptionMessage('The initial conversation ID must be a string');

        $s->setInitialConversation(0);
    }

    public function testSetConversation()
    {
        $s = new ConversationsSelect([]);

        $this->assertNull($s->getInitialConversation());
        $s->setInitialConversation('C123456');
        $this->assertSame('C123456', $s->getInitialConversation());
    }

    public function testInitialConversationTakesPrecedence()
    {
        $s = new ConversationsSelect([
            'placeholder'                     => 'Placeholder text',
            'action_id'                       => 'Select action',
            'default_to_current_conversation' => true,
        ]);

        $this->assertArrayHasKey('default_to_current_conversation', $s->toArray());
        $s->setInitialConversation('C123456');
        $this->assertArrayNotHasKey('default_to_current_conversation', $s->toArray());
        $this->assertArrayHasKey('initial_conversation', $s->toArray());
    }

    public function testSetInvalidFilter()
    {
        $s = new ConversationsSelect([]);

        $this->expectException(InvalidArgumentException::class);
        $this->expectExceptionMessage('The filter must be an instance of Maknz\\Slack\\CompositionObject\\Filter or a keyed array');

        $s->setFilter('Invalid');
    }

    public function testSetInvalidFilterType()
    {
        $s = new ConversationsSelect([]);

        $this->expectException(InvalidArgumentException::class);
        $this->expectExceptionMessage("Invalid filter include type 'Invalid'; must be one of: im,mpim,private,public");

        $s->setFilter(['include' => ['Invalid']]);
    }

    public function testSetFilterFromArray()
    {
        $s = new ConversationsSelect([
            'filter' => [
                'include' => ['public'],
                'exclude_external_shared_channels' => true,
                'exclude_bot_users' => true,
            ],
        ]);

        $this->assertTrue($s->getFilter()->areSharedChannelsExcluded());
        $this->assertTrue($s->getFilter()->areBotsExcluded());
    }

    public function testSetFilterExcludes()
    {
        $s = new ConversationsSelect([
            'filter' => [
                'include' => ['public'],
            ],
        ]);

        $this->assertSame(['public'], $s->getFilter()->getTypes());
        $this->assertFalse($s->getFilter()->areSharedChannelsExcluded());
        $this->assertFalse($s->getFilter()->areBotsExcluded());

        $s->getFilter()->setExcludeSharedChannels();
        $this->assertTrue($s->getFilter()->areSharedChannelsExcluded());

        $s->getFilter()->setExcludeBots();
        $this->assertTrue($s->getFilter()->areBotsExcluded());

        $s->getFilter()->setExcludeSharedChannels(false);
        $this->assertFalse($s->getFilter()->areSharedChannelsExcluded());

        $s->getFilter()->setExcludeBots(false);
        $this->assertFalse($s->getFilter()->areBotsExcluded());
    }

    public function testToArray()
    {
        $s = new ConversationsSelect([
            'placeholder'          => 'Placeholder text',
            'action_id'            => 'Select action',
            'initial_conversation' => 'C123456',
            'response_url_enabled' => true,
            'filter'               => ['include' => ['public']],
            'confirm'              => [
                'title'   => 'Confirmation title',
                'text'    => 'Confirmation text',
                'confirm' => 'Confirm',
                'deny'    => 'Deny',
            ],
        ]);

        $out = [
            'type'                 => 'conversations_select',
            'placeholder'          => [
                'type'  => Text::TYPE_PLAIN,
                'text'  => 'Placeholder text',
                'emoji' => false,
            ],
            'action_id'            => 'Select action',
            'initial_conversation' => 'C123456',
            'confirm'              => [
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
            'response_url_enabled' => true,
            'filter' => [
                'include'                          => ['public'],
                'exclude_external_shared_channels' => false,
                'exclude_bot_users'                => false,
            ],
        ];

        $this->assertEquals($out, $s->toArray());
    }
}
