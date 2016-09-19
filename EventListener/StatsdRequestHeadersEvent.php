<?php
namespace M6Web\Bundle\StatsdRequestHeadersBundle\EventListener;

use Symfony\Component\EventDispatcher\Event;

/**
 * Class StatsdRequestHeadersEvent
 * @package M6Web\Bundle\StatsdRequestHeadersBundle\EventListener
 */
class StatsdRequestHeadersEvent extends Event
{
    /**
     * @var string
     */
    protected $value;

    /**
     * StatsdRequestHeadersEvent constructor.
     * @param string $value
     */
    public function __construct($value)
    {
        $this->value = $value;
    }

    /**
     * @return string
     */
    public function getValue()
    {
        return $this->value;
    }
}
