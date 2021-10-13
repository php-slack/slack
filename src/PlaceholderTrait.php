<?php
namespace Maknz\Slack;

use Maknz\Slack\BlockElement\Text;

trait PlaceholderTrait
{
    /**
     * Select placeholder.
     *
     * @var \Maknz\Slack\BlockElement\Text
     */
    protected $placeholder;

    /**
     * Get the placeholder.
     *
     * @return \Maknz\Slack\BlockElement\Text
     */
    public function getPlaceholder()
    {
        return $this->placeholder;
    }

    /**
     * Set the placeholder.
     *
     * @param mixed $placeholder
     *
     * @return $this
     *
     * @throws \InvalidArgumentException
     */
    public function setPlaceholder($placeholder)
    {
        $this->placeholder = Text::create($placeholder, Text::TYPE_PLAIN);

        return $this;
    }
}
