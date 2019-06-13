<?php


namespace Xigen\LogCleaner\Helper;

use Magento\Framework\App\Helper\AbstractHelper;

/**
 * Cleaner helper class
 */
class Cleaner extends AbstractHelper
{
    const CONFIG_XML_CRON = 'log_cleaner/log_cleaner/cron';

    /**
     * @param \Magento\Framework\App\Helper\Context $context
     */
    public function __construct(
        \Magento\Framework\App\Helper\Context $context,
        \Psr\Log\LoggerInterface $logger,
        \Magento\Framework\App\ResourceConnection $resource
    ) {
        $this->logger = $logger;
        $this->connection = $resource->getConnection();
        $this->resource = $resource;
        parent::__construct($context);
    }

    /**
     * Get cron
     * @return string
     */
    public function getCron()
    {
        return $this->scopeConfig->getValue(self::CONFIG_XML_CRON, ScopeInterface::SCOPE_STORE);
    }

    /**
     * Get tables to truncate
     * @return array
     */
    public function getTablesToTruncate()
    {
        return [
            'report_event',
            'report_viewed_product_index',
            'report_compared_product_index',
            'customer_visitor'
        ];
    }

    /**
     * Truncate tables
     * @return void
     */
    public function truncate()
    {
        $tables = $this->getTablesToTruncate();
        foreach ($tables as $table) {
            try {
                $this->logger->info((string)__('Attempt to truncate %1', $table));
                $this->connection->truncateTable($table);
                $this->logger->info((string)__('%1 table has been truncated', $table));
            } catch (\Exception $e) {
                $this->logger->info((string)__('Failure to truncate %1 : %2 ', $table, $e->getMessage()));
                $this->logger->critical($e);
            }
        }
    }
}
