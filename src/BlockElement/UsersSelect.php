<?php
namespace Maknz\Slack\BlockElement;

use InvalidArgumentException;

class UsersSelect extends AbstractDynamicSelect
{
    /**
     * Block type.
     *
     * @var string
     */
    protected $type = 'users_select';

    /**
     * The initially selected user.
     *
     * @var string
     */
    protected $initial_user;

    /**
     * Internal attribute to property map.
     *
     * @var array
     */
    protected static $availableAttributes = [
        'placeholder'  => 'placeholder',
        'action_id'    => 'action_id',
        'initial_user' => 'initial_user',
        'confirm'      => 'confirm',
    ];

    /**
     * Get the initially selected user.
     *
     * @return string
     */
    public function getInitialUser()
    {
        return $this->initial_user;
    }

    /**
     * Set the initially selected user.
     *
     * @param string $initialUser
     *
     * @return $this
     *
     * @throws InvalidArgumentException
     */
    public function setInitialUser($initialUser)
    {
        if (is_string($initialUser)) {
            $this->initial_user = $initialUser;

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

        if ($this->getInitialUser()) {
            $data['initial_user'] = $this->getInitialUser();
        }

        if ($this->getConfirm()) {
            $data['confirm'] = $this->getConfirm()->toArray();
        }

        return $data;
    }
}
