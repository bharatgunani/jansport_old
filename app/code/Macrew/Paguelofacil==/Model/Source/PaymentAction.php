<?php
/**
 * Copyright © 2015 Magento. All rights reserved.
 * See COPYING.txt for license details.
 */
namespace Macrew\Paguelofacil\Model\Source;

use Magento\Framework\Option\ArrayInterface;

/**
 *
 * Paguelofacil Payment Action Dropdown source
 */
class PaymentAction implements ArrayInterface
{
    /**
     * {@inheritdoc}
     */
    public function toOptionArray()
    {
        return [
            [
                'value' => \Macrew\Paguelofacil\Model\Paguelofacil::ACTION_AUTHORIZE,
                'label' => __('Authorize Only'),
            ],
            [
                'value' => \Macrew\Paguelofacil\Model\Paguelofacil::ACTION_AUTHORIZE_CAPTURE,
                'label' => __('Authorize and Capture')
            ]
        ];
    }
}
