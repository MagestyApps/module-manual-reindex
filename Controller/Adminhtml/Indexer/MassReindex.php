<?php
/**
 * Copyright © MagestyApps. All rights reserved.
 * See LICENSE.txt for license details.
 */

namespace MagestyApps\ManualReindex\Controller\Adminhtml\Indexer;

use Magento\Backend\App\Action;
use Magento\Framework\Indexer\IndexerRegistry;

class MassReindex extends Action
{
    const ADMIN_RESOURCE = 'Magento_Indexer::changeMode';

    /**
     * @var IndexerRegistry
     */
    private $indexerRegistry;

    /**
     * MassReindex constructor.
     * @param IndexerRegistry $indexerRegistry
     * @param Action\Context $context
     */
    public function __construct(
        IndexerRegistry $indexerRegistry,
        Action\Context $context
    ) {
        parent::__construct($context);
        $this->indexerRegistry = $indexerRegistry;
    }

    /**
     * Run manual reindex
     *
     * @return \Magento\Framework\App\ResponseInterface|\Magento\Framework\Controller\ResultInterface|void
     */
    public function execute()
    {
        $indexerIds = $this->getRequest()->getParam('indexer_ids');

        if (!is_array($indexerIds)) {
            $this->messageManager->addError(__('Please select indexers to be refreshed.'));
        } else {
            try {
                foreach ($indexerIds as $indexerId) {
                    /** @var \Magento\Framework\Indexer\IndexerInterface $model */
                    $indexer = $this->indexerRegistry->get($indexerId);
                    $indexer->reindexAll();
                }
                $this->messageManager->addSuccess(
                    __('%1 indexer(s) were refreshed.', count($indexerIds))
                );
            } catch (\Magento\Framework\Exception\LocalizedException $e) {
                $this->messageManager->addError($e->getMessage());
            } catch (\Exception $e) {
                $this->messageManager->addException(
                    $e,
                    __("We could not refresh the indexer(s).")
                );
            }
        }

        return $this->_redirect('*/*/list');
    }
}
