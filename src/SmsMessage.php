<?php
namespace NotificationChannels\Sms;

class SmsMessage
{
    /**
     * The message content.
     *
     * @var string
     */
    public $content;

    /**
     * The phone number the message should be sent from.
     *
     * @var string
     */
    public $from;

    /**
     * The sms url. (optional)
     *
     * @var string
     */
    public $url;

    /**
     * The sms token. (optional)
     *
     * @var string
     */
    public $token;

    /**
     * The phone number id the account. (optional)
     *
     * @var string
     */
    public $phoneNumberId;

    /**
     * The sms method. (optional)
     *
     * @var string
     */
    public $method;

    /**
     * The sms correlative id. (required)
     *
     * @var string
     */
    public $idCode;

    /**
     * Create a message object.
     * @param string $content
     * @return static
     */
    public static function create($content = '')
    {
        return new static($content);
    }

    /**
     * Create a new message instance.
     *
     * @param  string $content
     */
    public function __construct($content = '')
    {
        $this->content = $content;
    }

    /**
     * Set the message content.
     *
     * @param  string $content
     * @return $this
     */
    public function content($content)
    {
        $this->content = $content;

        return $this;
    }

    /**
     * Set the sms url.
     *
     * @param  string $url
     */
    public function url($url)
    {
        $this->url = $url;
    }

    /**
     * Set the sms token.
     *
     * @param  string $token
     */
    public function token($token)
    {
        $this->token = $token;
    }

    /**
     * Set the sms phoneNumberId.
     *
     * @param  string $phoneNumberId
     */
    public function phoneNumberId($phoneNumberId)
    {
        $this->phoneNumberId = $phoneNumberId;
    }

    /**
     * Set the sms method.
     *
     * @param  string $method
     */
    public function method($method)
    {
        $this->method = $method;
    }

    /**
     * Set the sms correlative id.
     *
     * @param  integer $idCode
     */
    public function idCode($idCode)
    {
        $this->idCode = $idCode;
    }
}
