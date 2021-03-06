<?php

namespace NotificationChannels\PanaceaMobile;

use Illuminate\Contracts\Support\Arrayable;

class PanaceaMobileMessage implements Arrayable
{
    /**
     * The phone number the message should be sent from.
     *
     * @var string
     */
    public $from;

    /**
     * The message content.
     *
     * @var string
     */
    public $content;

    /**
     * Create a new message instance.
     *
     * @param  string $content
     * @return static
     */
    public static function create($content = '')
    {
        return new static($content);
    }

    /**
     * @param  string  $content
     */
    public function __construct($content = '')
    {
        $this->content = $content;
    }

    /**
     * Set the message content.
     *
     * @param  string  $content
     *
     * @return $this
     */
    public function content($content)
    {
        $this->content = $content;

        return $this;
    }

    /**
     * Set the phone number or from name the message should be sent from.
     *
     * @param  string  $from
     *
     * @return $this
     */
    public function from($from)
    {
        $this->from = $from;

        return $this;
    }
	
    /**
     * Set the phone number or from name the message should be sent from.
     *
     * @param  string  $from
     *
     * @return $this
     */
    public function recipient($to)
    {
        $this->to = $to;

        return $this;
    }

    /**
     * @return array
     */
    public function toArray()
    {
        $params = [
            'text' => $this->content,
            'charset' => 'utf-8',
        ];

        if (! empty($this->from)) {
            $params = array_merge($params, ['from' => $this->from]);
        }

        return $params;
    }
}
