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

    private $showUrl = 'statuses/show';

    private $retweetUrl = 'statuses/retweets';

    private $statusUrl = 'statuses/update';

    /**
     * Search tweets
     * @param array $keywords
     * @param array $options
     */
    public function search(array $keywords = [], array $options = [])
    {
        try {

            $options = array_merge($this->generateDefaultOption(), $options);
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
     *
     * @param int $id
     * @param array $options
     */
    public function getOneById(int $id, array $options = [])
    {
        try {
            $options['id']         = $id;
            $options['tweet_mode'] = 'extended';
            $result = $this->client->get($this->showUrl, $options);
            if (!empty($result->errors)) {
                $this->handleError($result->errors);
            }
            dd($result);
        } catch (\Exception $e) {
            echo 'Un problème est survenu : ' . $e->getMessage();
        }
    }

    public function getRetweetsById(int $id, array $options = [])
    {
        try {
            $options['id']         = $id;
            $options['tweet_mode'] = 'extended';
            $result = $this->client->get($this->retweetUrl, $options);
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
            'tweet_mode'     => 'extended',
            'include_rts'    => false,
            ];
    }

    public function write($message)
    {
        try {

            $options = [
              'status' => $message,
            ];
            $this->client->post($this->statusUrl, $options);
        } catch (\Exception $e) {
            echo $e->getMessage();
        }
    }
}
