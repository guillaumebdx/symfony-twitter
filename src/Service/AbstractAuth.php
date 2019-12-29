<?php

namespace App\Service;

use Symfony\Component\DependencyInjection\ParameterBag\ParameterBagInterface;
use Abraham\TwitterOAuth\TwitterOAuth;

abstract class AbstractAuth
{

    /**
     * Access token
     * @var string
     */
    private  $accessToken;
    
    /**
     * Access token secret
     * @var string
     */
    private $accessTokenSecret;
    
    /**
     * Consumer key
     * @var string
     */
    private $consumerKey;
    
    /**
     * Consumer secret
     * @var string
     */
    private $consumerSecret;

    /**
     * 
     * @var TwitterOAuth
     */
    protected $client;

    /**
     * class constructor
     * 
     * @param ParameterBagInterface $parameterBag
     */
    public function __construct(ParameterBagInterface $parameterBag)
    {
        $this->accessToken       = $parameterBag->get('access_token');
        $this->accessTokenSecret = $parameterBag->get('access_token_secret');
        $this->consumerKey       = $parameterBag->get('consumer_key');
        $this->consumerSecret    = $parameterBag->get('consumer_secret');
        $this->createClient();
    }
 
    /**
     * Create Twitter oAuth client
     */
    public function createClient():self
    {
        $client = new TwitterOAuth($this->consumerKey, $this->consumerSecret, $this->accessToken, $this->accessTokenSecret);
        $this->client = $client;
        return $this;
    }

    public function handleError(array $errors)
    {
        $message = '';
        foreach ($errors as $error) {
            $message .= 'code ' . $error->code . ' - ' . $error->message . ' ';
        }
        throw new \Exception("Erreur de l'API. " . $message);
    }
}