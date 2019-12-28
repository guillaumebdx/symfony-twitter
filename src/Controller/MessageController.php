<?php

namespace App\Controller;

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
     */
    public function search(MessageService $message)
    {
        $message->search();
    }
}
