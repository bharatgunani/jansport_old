<?php
/**
 * Magestore
 *
 * NOTICE OF LICENSE
 *
 * This source file is subject to the Magestore.com license that is
 * available through the world-wide-web at this URL:
 * http://www.magestore.com/license-agreement.html
 *
 * DISCLAIMER
 *
 * Do not edit or add to this file if you wish to upgrade this extension to newer
 * version in the future.
 *
 * @category    Magestore
 * @package     Magestore_Onestepcheckout
 * @copyright   Copyright (c) 2012 Magestore (http://www.magestore.com/)
 * @license     http://www.magestore.com/license-agreement.html
 */

namespace Magestore\OneStepCheckout\Block\System\Config;

/**
 * class Separator
 *
 * @category Magestore
 * @package  Magestore_OneStepCheckout
 * @module   OneStepCheckout
 * @author   Magestore Developer
 */
class Separator extends \Magento\Config\Block\System\Config\Form\Field
{
    /**
     * @param \Magento\Framework\Data\Form\Element\AbstractElement $element
     *
     * @return string
     */
    public function render(\Magento\Framework\Data\Form\Element\AbstractElement $element)
    {
        $htmlId = $element->getHtmlId();
        $html = '<tr id="row_' . $htmlId . '">'
            . '<td class="label" colspan="3">';

        $marginTop = '30px';
        $customStyle = 'text-align:left;';

        $html .= '<div style="margin-top: ' . $marginTop
            . '; font-weight: bold; border-bottom: 1px solid #dfdfdf;'
            . $customStyle . '">';
        $html .= $element->getLabel();
        $html .= '</div></td></tr>';

        return $html;
    }
}

