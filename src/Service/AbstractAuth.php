<?php

namespace App\Service;

use Symfony\Component\DependencyInjection\ParameterBag\ParameterBagInterface;
use Symfony\Contracts\HttpClient\HttpClientInterface;

abstract class AbstractAuth
{
    /**
     * Client interface
     * @var HttpClientInterface
     */
    protected $client;

    /**
     * Access token
     * @var string
     */
    protected  $accessToken;
    
    /**
     * Access token secret
     * @var string
     */
    protected $accessTokenSecret;
    
    /**
     * Consumer key
     * @var string
     */
    protected $consumerKey;
    
    /**
     * Consumer secret
     * @var string
     */
    protected $consumerSecret;

    /**
     * class constructor
     * 
     * @param HttpClientInterface $client
     * @param ParameterBagInterface $parameterBag
     */
    public function __construct(HttpClientInterface $client, ParameterBagInterface $parameterBag)
    {
        $this->client            = $client;
        $this->accessToken       = $parameterBag->get('access_token');
        $this->accessTokenSecret = $parameterBag->get('access_token_secret');
        $this->consumerKey       = $parameterBag->get('consumer_key');
        $this->consumerSecret    = $parameterBag->get('consumer_secret');
    }
}