<?php
namespace Maknz\Slack;

use InvalidArgumentException;
use Maknz\Slack\Object\Filter;

trait FilterTrait
{
    /**
     * A filter for the list of options.
     *
     * @var \Maknz\Slack\Object\Filter
     */
    protected $filter;

    /**
     * Get the filter for the list of options.
     *
     * @var \Maknz\Slack\Object\Filter
     */
    public function getFilter()
    {
        return $this->filter;
    }

    /**
     * Set the filter for the list of options.
     *
     * @param mixed $filter
     *
     * @return $this
     *
     * @throws \InvalidArgumentException
     */
    public function setFilter($filter)
    {
        if (is_array($filter)) {
            $filter = new Filter($filter);
        }

        if ($filter instanceof Filter) {
            $this->filter = $filter;

            return $this;
        }

        throw new InvalidArgumentException('The filter must be an instance of '.Filter::class.' or a keyed array');
    }
}
