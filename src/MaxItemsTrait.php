<?php
namespace Maknz\Slack;

use InvalidArgumentException;

trait MaxItemsTrait
{
    /**
     * Maximum number of selected items.
     *
     * @var int
     */
    protected $max_selected_items;

    /**
     * Get the maximum number of selected items.
     *
     * @return int
     */
    public function getMaxSelectedItems()
    {
        return $this->max_selected_items;
    }

    /**
     * Set the maximum number of selected items.
     *
     * @param int $maxSelectedItems
     *
     * @return $this
     *
     * @throws \InvalidArgumentException
     */
    public function setMaxSelectedItems($maxSelectedItems)
    {
        if (is_int($maxSelectedItems) && $maxSelectedItems >= 1) {
            $this->max_selected_items = $maxSelectedItems;

            return $this;
        }

        throw new InvalidArgumentException('The max selected items must be a positive integer');
    }
}
