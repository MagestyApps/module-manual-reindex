# Manual Reindex for Magento 2
This simple Magento 2 extension adds the possibility to refresh indexers manually via admin panel.

## Installation
Run the following command from your Mangento root folder in order to download the extension files via Composer:
```
composer require magestyapps/module-manual-reindex;
```
And then run installation scripts:
```
php bin/magento setup:upgrade;
```
## How to Use
After installting the module, navigate to System > Tools > Index Management in Magento 2 admin panel. Choose the indexers you would like to be refreshed and then select 'Run Reindex' option in mass actions dropdown and press 'Submit'.
