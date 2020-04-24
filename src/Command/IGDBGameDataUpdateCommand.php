<?php

declare(strict_types=1);

namespace App\Command;

use App\Eimmar\IGDBBundle\DTO\Request\RequestBody;
use App\Service\API\IGDBGameAdapter;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class IGDBGameDataUpdateCommand extends Command
{
    protected static $defaultName = 'app:igdb:update-game-data';

    private IGDBGameAdapter $igdbGameDataUpdater;

    /**
     * @param IGDBGameAdapter $igdbGameDataUpdater
     */
    public function __construct(IGDBGameAdapter $igdbGameDataUpdater)
    {
        parent::__construct();
        $this->igdbGameDataUpdater = $igdbGameDataUpdater;
    }

    protected function configure()
    {
        $this->setDescription('Command for game data update from IGDB.');
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $request = new RequestBody();

        $this->igdbGameDataUpdater->update($request);
    }
}
