<?php
/**
 *
 * Copyright © 2015 Magento. All rights reserved.
 * See COPYING.txt for license details.
 */
namespace Macrew\Paguelofacil\Controller\Directpost\Payment;

class Response extends \Macrew\Paguelofacil\Controller\Directpost\Payment
{
    /**
     * Response action.
     * Action for Paguelofacil SIM Relay Request.
     *
     * @return void
     */
    public function execute()
    {
        $this->_responseAction('frontend');
    }
}
