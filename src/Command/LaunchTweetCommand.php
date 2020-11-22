<?php

namespace App\Command;

use App\Repository\CityRepository;
use App\Service\EmojiService;
use App\Service\MessageService;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;

class LaunchTweetCommand extends Command
{
    protected static $defaultName = 'launch-tweet';

    private $message;

    private $emoji;

    private $cityRepository;

    private $entityManager;

    public function __construct(        MessageService $message,
                                        EmojiService $emoji,
                                        CityRepository $cityRepository,
                                        EntityManagerInterface $entityManager,
                                        string $name = null)
    {
        parent::__construct($name);
        $this->message = $message;
        $this->emoji = $emoji;
        $this->cityRepository = $cityRepository;
        $this->entityManager = $entityManager;

    }

    protected function configure()
    {
        $this
            ->setDescription('Add a short description for your command')
            ->addArgument('arg1', InputArgument::OPTIONAL, 'Argument description')
            ->addOption('option1', null, InputOption::VALUE_NONE, 'Option description')
        ;
    }

    protected function execute(
        InputInterface $input,
        OutputInterface $output): int
    {
        $io = new SymfonyStyle($input, $output);

        $city = $this->cityRepository->findOneBy(['isDone' => false]);
        $this->message->write('Allez ' . $city->getName() . ' !!! ' . $this->emoji->getRandomEmoji());
        $city->setIsDone(true);
        $this->entityManager->persist($city);
        $this->entityManager->flush();

        $io->success('You have a new command! Now make it your own! Pass --help to see your options.');

        return 0;
    }
}
