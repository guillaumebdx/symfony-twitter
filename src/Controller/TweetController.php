<?php

namespace App\Controller;

use App\Entity\City;
use App\Form\CityType;
use App\Repository\CityRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/tweet", name="tweet_")
 */
class TweetController extends AbstractController
{
    const WAIT_DURATION = 300;
    /**
     * @Route("/new", name="new")
     */
    public function index(Request $request, EntityManagerInterface $entityManager, CityRepository $cityRepository)
    {
        $customCity = $cityRepository->findLastCustomCity();
        if ($customCity) {
            $now = new \DateTime();
            $diff = $now->getTimestamp() - $customCity->getCreatedAt()->getTimestamp();
            if ($diff < self::WAIT_DURATION) {
                return $this->redirectToRoute('tweet_wait');
            }
        }

        $city = new City();
        $city->setIsDone(false);
        $city->setIsCustom(true);
        $form = $this->createForm(CityType::class, $city);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($city);
            $entityManager->flush();
            return $this->redirectToRoute('tweet_done');
        }
        return $this->render('tweet/index.html.twig', [
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/wait", name="wait")
     */
    public function wait()
    {
        return $this->render('tweet/wait.html.twig');
    }

    /**
     * @Route("/done", name="done")
     */
    public function done()
    {
        return $this->render('tweet/done.html.twig');
    }
}
