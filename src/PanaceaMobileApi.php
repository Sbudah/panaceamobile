<?php

namespace NotificationChannels\PanaceaMobile;

use DomainException;
use GuzzleHttp\Client as HttpClient;
use NotificationChannels\PanaceaMobile\Exceptions\CouldNotSendNotification;

class PanaceaMobileApi
{
    const FORMAT_JSON = 3;

    /** @var string */
    protected $apiUrl = 'https://api.panaceamobile.com/json/3';

    /** @var HttpClient */
    protected $httpClient;

    /** @var string */
    protected $login;

    /** @var string */
    protected $secret;

    /** @var string */
    protected $sender;

    public function __construct($login, $secret, $sender)
    {
        $this->login = $login;
        $this->secret = $secret;
        $this->sender = $sender;

        $this->httpClient = new HttpClient([
            'timeout' => 5,
            'connect_timeout' => 5,
        ]);
    }

    /**
     * @param  string  $recipient
     * @param  array   $params
     *
     * @return array
     *
     * @throws CouldNotSendNotification
     */
    public function send($recipient, $params)
    {
        $params = array_merge([
			'action' 	=> 'message_send',
            'username'  => $this->login,
            'password'  => $this->secret,
            'from' 		=> $this->sender,
            'to' 		=> $recipient,
        ], $params);

        try {
            $response = $this->httpClient->get(
			$this->apiUrl, 
				[
					'query' => $params
				]
			);

            $response = json_decode((string) $response->getBody(), true);

            if (isset($response['error'])) {
                throw new DomainException($response['error'], $response['error_code']);
            }

            return $response;
        } catch (DomainException $exception) {
            throw CouldNotSendNotification::serviceRespondedWithAnError($exception);
        }
    }
}
