<?php

namespace NotificationChannels\IonicPushNotifications;

class IonicPushMessage
{
    /** @var string */
    protected $sendTo = 'tokens';

    /** @var string */
    protected $profile;

    /** @var string */
    protected $title = '';

    /** @var string */
    protected $message = '';

    /** @var string */
    protected $sound = '';

    /** @var array */
    protected $payload = [];

    /** @var array */
    protected $iosData = [];

    /** @var array */
    protected $androidData = [];

    /**
     * @param array $data
     *
     * @return static
     */
    public static function create($title, $message)
    {
        return new static($title, $message);
    }

    /**
     * @param string $title
     * @param string $message
     */
    public function __construct($title, $message)
    {
        $this->title = $title;
        $this->message = $message;
    }

    /**
     * Set the security profile to use.
     *
     * @param  string  $profile
     *
     * @return $this
     */
    public function profile($profile)
    {
        $this->profile = $profile;

        return $this;
    }

    /**
     * Set the method of targeting users - tokens (default), user_ids, or emails.
     *
     * @param  string  $profile
     *
     * @return $this
     */
    public function sendTo($sendTo)
    {
        $this->sendTo = $sendTo;

        return $this;
    }

    /**
     * Set the security sound to use.
     *
     * @param  string  $sound
     *
     * @return $this
     */
    public function sound($sound)
    {
        $this->sound = $sound;

        return $this;
    }

    /**
     * Send custom key/value data with your notifications.
     *
     * @param  array  $payload
     *
     * @return $this
     */
    public function payload($payload)
    {
        $this->payload = $payload;

        return $this;
    }

    /**
     * Dynamically add device specific data.
     *
     * @param string $method
     * @param array  $args
     *
     * @return object
     */
    public function __call($method, $args)
    {
        if (substr($method, 0, 3) == 'ios') {
            $key = snake_case(substr($method, 3));

            $this->iosData[$key] = $args[0];
        } elseif (substr($method, 0, 7) == 'android') {
            $key = snake_case(substr($method, 7));

            $this->androidData[$key] = $args[0];
        }

        return $this;
    }

    /**
     * @return array
     */
    public function toArray()
    {
        return $this->data;
    }
}
