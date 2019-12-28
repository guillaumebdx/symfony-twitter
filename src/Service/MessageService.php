<?php

namespace App\Service;

class MessageService extends AbstractAuth
{
    
    public function search(array $keywords = [], array $options = [])
    {
       dd($this->accessTokenSecret);
    }
}