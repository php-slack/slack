<?php
namespace Maknz\Slack\BlockElement;

abstract class RespondableSelect extends AbstractDynamicSelect
{
    /**
     * Whether to include a response URL in submission payload.
     *
     * @var bool
     */
    protected $response_url_enabled = false;

    /**
     * Get whether to include a response URL in submission payload.
     *
     * @return bool
     */
    public function isResponseUrlEnabled()
    {
        return $this->response_url_enabled;
    }

    /**
     * Set whether to include a response URL in submission payload.
     *
     * @param bool $enabled
     *
     * @return $this
     */
    public function setResponseUrlEnabled($enabled = true)
    {
        $this->response_url_enabled = (bool)$enabled;

        return $this;
    }
}
