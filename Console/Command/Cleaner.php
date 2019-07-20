<?php

namespace Xigen\LogCleaner\Console\Command;

use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Helper\ProgressBar;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

/**
 * Clean console class
 */
class Cleaner extends Command
{
    const CLEAN_ARGUMENT = 'clean';
    const LIMIT_OPTION = 'limit';

    /**
     * @var \Psr\Log\LoggerInterface
     */
    private $logger;

    /**
     * @var \Magento\Framework\App\State
     */
    private $state;

    /**
     * @var \Magento\Framework\Stdlib\DateTime\DateTime
     */
    private $dateTime;

    /**
     * @var \Xigen\LogCleaner\Helper\Cleaner
     */
    private $cleanerHelper;

    /**
     * @var InputInterface
     */
    private $input;

    /**
     * @var OutputInterface
     */
    private $output;

    /**
     * Cleaner constructor.
     * @param \Psr\Log\LoggerInterface $logger
     * @param \Magento\Framework\App\State $state
     * @param \Magento\Framework\Stdlib\DateTime\DateTime $dateTime
     * @param \Xigen\LogCleaner\Helper\Cleaner $cleanerHelper
     */
    public function __construct(
        \Psr\Log\LoggerInterface $logger,
        \Magento\Framework\App\State $state,
        \Magento\Framework\Stdlib\DateTime\DateTime $dateTime,
        \Xigen\LogCleaner\Helper\Cleaner $cleanerHelper
    ) {
        $this->logger = $logger;
        $this->state = $state;
        $this->dateTime = $dateTime;
        $this->cleanerHelper = $cleanerHelper;
        parent::__construct();
    }

    /**
     * {@inheritdoc}
     */
    protected function execute(
        InputInterface $input,
        OutputInterface $output
    ) {
        $this->input = $input;
        $this->output = $output;

        $this->state->setAreaCode(\Magento\Framework\App\Area::AREA_GLOBAL);

        $clean = $input->getArgument(self::CLEAN_ARGUMENT) ?: false;

        if ($clean) {
            $this->output->writeln((string) __('[%1] Start', $this->dateTime->gmtDate()));
            $this->cleanerHelper->truncate();
            $this->output->writeln((string) __('[%1] Finish', $this->dateTime->gmtDate()));
        }
    }

    /**
     * {@inheritdoc}
     * xigen:log:cleaner <clean>.
     */
    protected function configure()
    {
        $this->setName('xigen:log:cleaner');
        $this->setDescription('Clean log entries from Magento');
        $this->setDefinition([
            new InputArgument(self::CLEAN_ARGUMENT, InputArgument::REQUIRED, 'Clean'),
        ]);
        parent::configure();
    }
}
