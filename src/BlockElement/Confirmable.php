<?php
namespace Maknz\Slack\BlockElement;

use InvalidArgumentException;
use Maknz\Slack\BlockElement;
use Maknz\Slack\Object\Confirmation;

abstract class Confirmable extends BlockElement
{
    /**
     * Action triggered when the element is interacted with.
     *
     * @var string
     */
    protected $action_id;

    /**
     * Confirmation object.
     *
     * @var \Maknz\Slack\Object\Confirmation
     */
    protected $confirm;

    /**
     * Get the element's action identifier.
     *
     * @return string
     */
    public function getActionId()
    {
        return $this->action_id;
    }

    /**
     * Set the element's action identifier.
     *
     * @param string $actionId
     *
     * @return $this
     */
    public function setActionId($actionId)
    {
        $this->action_id = $actionId;

        return $this;
    }

    /**
     * Get the confirmation object.
     *
     * @return \Maknz\Slack\Object\Confirmation
     */
    public function getConfirm()
    {
        return $this->confirm;
    }

    /**
     * Set the confirmation object.
     *
     * @param mixed $confirm
     *
     * @return $this
     *
     * @throws \InvalidArgumentException
     */
    public function setConfirm($confirm)
    {
        if (is_array($confirm)) {
            $confirm = new Confirmation($confirm);
        }

        if ($confirm instanceof Confirmation) {
            $this->confirm = $confirm;

            return $this;
        }

        throw new InvalidArgumentException('Confirm must be a keyed array or '.Confirmation::class.' object');
    }
}
