<?php

namespace App\Controller;

use App\Repository\CityRepository;
use App\Service\EmojiService;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use App\Service\MessageService;

/**
 *
 * @author guillaume
 * @Route("/message", name="message_")
 *
 */
class MessageController extends AbstractController
{
    /**
     * @Route("/search", name="search")
     * @param MessageService $message
     */
    public function search(MessageService $message)
    {
        $message->search(
            [
                'macron',
                'oui'
            ],
            [
                'exclude_replies' => true,
            ]
            );
    }

    /**
     * @Route("/show/{id}", name="show")
     * @param MessageService $message
     */
    public function showById(MessageService $message, $id)
    {
        $message->getOneById($id);
    }

    /**
     * @Route("/retweets/{id}", name="retweets")
     * @param MessageService $message
     */
    public function showRetweets(MessageService $message, $id)
    {
        $message->getRetweetsById($id);
    }

    /**
     * @Route("/write", name="write")
     * @param MessageService $message
     */
    public function write(EmojiService $emoji, MessageService $message, CityRepository $cityRepository, EntityManagerInterface $entityManager)
    {
        $city = $cityRepository->findOneBy(['isDone' => false]);
        $message->write('Allez ' . $city->getName() . ' !!! ' . $emoji->getRandomEmoji());
        $city->setIsDone(true);
        $entityManager->persist($city);
        $entityManager->flush();
        dd($city);


    }
}
