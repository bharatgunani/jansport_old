<?php
/**
 *
 * Copyright © 2015 Magento. All rights reserved.
 * See COPYING.txt for license details.
 */
namespace Macrew\Paguelofacil\Controller\Directpost\Payment;

class ReturnQuote extends \Macrew\Paguelofacil\Controller\Directpost\Payment
{
    /**
     * Return customer quote by ajax
     *
     * @return void
     */
    public function execute()
    {
        $this->_returnCustomerQuote();
        $this->getResponse()->representJson(
            $this->_objectManager->get('Magento\Framework\Json\Helper\Data')->jsonEncode(['success' => 1])
        );
    }
}
