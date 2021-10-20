<?php
namespace Maknz\Slack\BlockElement;

use InvalidArgumentException;

class MultiUsersSelect extends MultiDynamicSelect
{
    /**
     * Block type.
     *
     * @var string
     */
    protected $type = 'multi_users_select';

    /**
     * Initially selected users.
     *
     * @var string[]
     */
    protected $initial_users = [];

    /**
     * Internal attribute to property map.
     *
     * @var array
     */
    protected static $availableAttributes = [
        'placeholder'        => 'placeholder',
        'action_id'          => 'action_id',
        'initial_users'      => 'initial_users',
        'confirm'            => 'confirm',
        'max_selected_items' => 'max_selected_items',
    ];

    /**
     * Get the initially selected users.
     *
     * @return string[]
     */
    public function getInitialUsers()
    {
        return $this->initial_users;
    }

    /**
     * Set the initially selected users.
     *
     * @param string[] $initialUsers
     *
     * @return $this
     *
     * @throws InvalidArgumentException
     */
    public function setInitialUsers(array $initialUsers)
    {
        $this->clearInitialUsers();

        foreach ($initialUsers as $initialUser) {
            $this->addInitialUser($initialUser);
        }

        return $this;
    }

    /**
     * Clear the initially selected users.
     *
     * @return $this
     */
    public function clearInitialUsers()
    {
        $this->initial_users = [];

        return $this;
    }

    /**
     * Add an initially selected user.
     *
     * @param string $initialUsers
     *
     * @return $this
     *
     * @throws InvalidArgumentException
     */
    public function addInitialUser($initialUser)
    {
        if (is_string($initialUser)) {
            $this->initial_users[] = $initialUser;

            return $this;
        }

        throw new InvalidArgumentException('The initial user ID must be a string');
    }

    /**
     * Convert the block to its array representation.
     *
     * @return array
     */
    public function toArray()
    {
        $data = [
            'type'        => $this->getType(),
            'placeholder' => $this->getPlaceholder()->toArray(),
            'action_id'   => $this->getActionId(),
        ];

        $initialUsers = $this->getInitialUsers();

        if (count($initialUsers)) {
            $data['initial_users'] = $initialUsers;
        }

        if ($this->getConfirm()) {
            $data['confirm'] = $this->getConfirm()->toArray();
        }

        if ($this->getMaxSelectedItems()) {
            $data['max_selected_items'] = $this->getMaxSelectedItems();
        }

        return $data;
    }
}
