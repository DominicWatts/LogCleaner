<?php

namespace Xigen\LogCleaner\Cron;

/**
 * Cleaner cron class
 */
class Cleaner
{
    protected $logger;
    protected $cleanerHelper;
    protected $dateTime;

    /**
     * Constructor
     * @param \Psr\Log\LoggerInterface $logger
     */
    public function __construct(
        \Psr\Log\LoggerInterface $logger,
        \Xigen\LogCleaner\Helper\Cleaner $cleanerHelper,
        \Magento\Framework\Stdlib\DateTime\DateTime $dateTime
    ) {
        $this->logger = $logger;
        $this->cleanerHelper = $cleanerHelper;
        $this->dateTime = $dateTime;
    }

    /**
     * Execute the cron
     * @return void
     */
    public function execute()
    {
        if ($this->cleanerHelper->getCron()) {
            $this->logger->addInfo((string) __('[%1] Cleaner Cronjob Start', $this->dateTime->gmtDate()));
            $this->cleanerHelper->truncate();
            $this->logger->addInfo((string) __('[%1] Cleaner Cronjob Finish', $this->dateTime->gmtDate()));
        }
    }
}
