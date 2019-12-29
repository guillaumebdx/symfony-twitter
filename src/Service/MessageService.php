<?php

namespace App\Service;

class MessageService extends AbstractAuth
{
    /**
     * Max tweet on result
     * @var integer
     */
    const MAX_TWEET = 20;
    
    /**
     * Search url
     * @var string
     */
    private $searchUrl = 'search/tweets';

    /**
     * Search tweets
     * @param array $keywords
     * @param array $options
     */
    public function search(array $keywords = [], array $options = [])
    {
        try {
            if (empty($options)) {
                $options = $this->generateDefaultOption();
            }
            $options['q'] = implode(' ', $keywords);
            $result = $this->client->get($this->searchUrl, $options);
            if (!empty($result->errors)) {
                $this->handleError($result->errors);
            }
            dd($result);
        } catch (\Exception $e) {
            echo 'Un problème est survenu : ' . $e->getMessage();
        }
        
    }

    /**
     * Generate Default Option
     * @return array
     */
    private function generateDefaultOption():array
    {
        return [
            'result_type'    => 'recent',
            'count'          => self::MAX_TWEET,
            'extended_tweet' => 'full_text',
            'lang'           => 'fr',
            ];
    }
}