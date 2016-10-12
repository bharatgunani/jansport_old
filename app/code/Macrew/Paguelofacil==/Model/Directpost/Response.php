<?php
/**
 * Copyright © 2015 Magento. All rights reserved.
 * See COPYING.txt for license details.
 */
namespace Macrew\Paguelofacil\Model\Directpost;

use Macrew\Paguelofacil\Model\Response as PaguelofacilResponse;
use Magento\Framework\Encryption\Helper\Security;

/**
 * Paguelofacil response model for DirectPost model
 */
class Response extends PaguelofacilResponse
{
    /**
     * Generates an Md5 hash to compare against AuthNet's.
     *
     * @param string $merchantMd5
     * @param string $merchantApiLogin
     * @param string $amount
     * @param string $transactionId
     * @return string
     */
    public function generateHash($merchantMd5, $merchantApiLogin, $amount, $transactionId)
    {
        if (!$amount) {
            $amount = '0.00';
        }

        return strtoupper(md5($merchantMd5 . $merchantApiLogin . $transactionId . $amount));
    }

    /**
     * Return if is valid order id.
     *
     * @param string $merchantMd5
     * @param string $merchantApiLogin
     * @return bool
     */
    public function isValidHash($merchantMd5, $merchantApiLogin)
    {
        $hash = $this->generateHash($merchantMd5, $merchantApiLogin, $this->getXAmount(), $this->getXTransId());

        return Security::compareStrings($hash, $this->getData('x_MD5_Hash'));
    }

    /**
     * Return if this is approved response from Paguelofacil auth request.
     *
     * @return bool
     */
    public function isApproved()
    {
        return $this->getXResponseCode() == \Macrew\Paguelofacil\Model\Directpost::RESPONSE_CODE_APPROVED;
    }
}
