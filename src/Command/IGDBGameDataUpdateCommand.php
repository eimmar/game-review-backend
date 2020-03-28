<?php

declare(strict_types=1);

/**
 * @copyright C UAB NFQ Technologies
 *
 * This Software is the property of NFQ Technologies
 * and is protected by copyright law – it is NOT Freeware.
 *
 * Any unauthorized use of this software without a valid license key
 * is a violation of the license agreement and will be prosecuted by
 * civil and criminal law.
 *
 * Contact UAB NFQ Technologies:
 * E-mail: info@nfq.lt
 * http://www.nfq.lt
 *
 */


namespace App\Command;

use App\Service\IGDBGameDataUpdater;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class IGDBGameDataUpdateCommand extends Command
{
    protected static $defaultName = 'app:igdb:update-game-data';

    private IGDBGameDataUpdater $igdbGameDataUpdater;

    /**
     * @param IGDBGameDataUpdater $igdbGameDataUpdater
     */
    public function __construct(IGDBGameDataUpdater $igdbGameDataUpdater)
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
        $this->igdbGameDataUpdater->update();
    }
}
