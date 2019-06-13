# Magento 2 Log Cleaner #

Clean log tables from Magento using either console command or waiting for cron task to run

Tables clear are:
  -  report_event
  -  report_viewed_product_index
  -  report_compared_product_index
  -  customer_visitor

# Install instructions #

`composer require dominicwatts/logcleaner`

`php bin/magento setup:upgrade`

# Usage instructions #

`xigen:log:claner [--] <clean>`

`php bin/magento xigen:log:claner clean`

Or alternatively allow cron task to run