<?php

namespace Xigen\LogCleaner\Cron;

/**
 * Cleaner cron class
 */
class Cleaner
{
    /**
     * @var \Psr\Log\LoggerInterface
     */
    protected $logger;

    /**
     * @var \Xigen\LogCleaner\Helper\Cleaner
     */
    protected $cleanerHelper;

    /**
     * @var \Magento\Framework\Stdlib\DateTime\DateTime
     */
    protected $dateTime;

    /**
     * Cleaner constructor.
     * @param \Psr\Log\LoggerInterface $logger
     * @param \Xigen\LogCleaner\Helper\Cleaner $cleanerHelper
     * @param \Magento\Framework\Stdlib\DateTime\DateTime $dateTime
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
