<?php

namespace Nta\AuthOtp\app\Messages;

class SMSMessage
{
    /**
     * @var string
     */
    public $to;

    /**
     * @var string
     */
    public $from;

    /**
     * @var string
     */
    public $body;

    /**
     * Set to number
     * @param $to
     * 
     * @return $this
     */
    public function to($to)
    {
        $this->to = $to;
        return $this;
    }

    /**
     * Set from number
     * @param $from
     * 
     * @return $this
     */
    public function from($from)
    {
        $this->from = $from;
        return $this;
    }

    /**
     * Set content sms
     * @param $body
     * 
     * @return string
     */
    public function body($body)
    {
        $this->body = $body;
        return $this;
    }
}