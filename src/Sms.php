<?php
namespace NotificationChannels\Sms;

use GuzzleHttp\Client;
use GuzzleHttp\Exception\RequestException;
use NotificationChannels\Sms\Exceptions\CouldNotSendNotification;

class Sms
{
    /**
     * @var SmsConfig
     */
    private $config;

    /**
     * Sms constructor.
     *
     * @param SmsConfig   $config
     */
    public function __construct(SmsConfig $config)
    {
        $this->config = $config;
    }

    /**
     * Send an sms message using the Sms Service.
     *
     * @param SmsMenssage $message
     * @param string           $to
     * @return \Sms\SmsMenssage
     */
    public function sendMessage(SmsMessage $message, $to)
    {
        $method = "sendMessage";
        if ($message->method) {
            $method = $message->method;
        }
        if ($message->url) {
            $url   = $message->url;
            $token = $message->token;
        } else {
            if (!$url = $this->config->getURL()) {
                throw CouldNotSendNotification::missingURL();
            }
            $token = $this->config->getToken();
        }

        $url    = trim($url);
        $token  = trim($token);
        $client = new Client;

        try {
            switch ($method) {
                case 'sendMessage':
                    $form_params = [
                        'msisdn'  => $to,
                        'message' => $message->content,
                        'id'      => $message->idCode,
                        'api_key' => $token,
                    ];

                    $response = $client->request('POST', $url, [
                        'form_params' => $form_params,
                    ]);

                    break;
            }
            $html = (string) $response->getBody();
        } catch (RequestException $e) {
            throw CouldNotSendNotification::errorSending($e->getMessage());
        }

        return $response;
    }
}
