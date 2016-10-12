<?php
/**
 * Copyright © 2015 Magento. All rights reserved.
 * See COPYING.txt for license details.
 */

namespace Magento\Sales\Test\Constraint;

use Magento\Sales\Test\Fixture\OrderInjectable;
use Magento\Sales\Test\Page\InvoiceView;
use Magento\Sales\Test\Page\OrderHistory;
use Magento\Sales\Test\Page\CustomerOrderView;

/**
 * Class AssertInvoicedAmountOnFrontend
 * Assert that invoiced Grand Total amount is equal to placed order Grand total amount on invoice page (frontend)
 */
class AssertInvoicedAmountOnFrontend extends AbstractAssertOrderOnFrontend
{
    /**
     * Assert that invoiced Grand Total amount is equal to placed order Grand total amount on invoice page (frontend)
     *
     * @param OrderHistory $orderHistory
     * @param OrderInjectable $order
     * @param CustomerOrderView $customerOrderView
     * @param InvoiceView $invoiceView
     * @param array $ids
     * @return void
     */
    public function processAssert(
        OrderHistory $orderHistory,
        OrderInjectable $order,
        CustomerOrderView $customerOrderView,
        InvoiceView $invoiceView,
        array $ids
    ) {
        $this->loginCustomerAndOpenOrderPage($order->getDataFieldConfig('customer_id')['source']->getCustomer());
        $orderHistory->getOrderHistoryBlock()->openOrderById($order->getId());
        $customerOrderView->getOrderViewBlock()->openLinkByName('Invoices');
        foreach ($ids['invoiceIds'] as $key => $invoiceId) {
            \PHPUnit_Framework_Assert::assertEquals(
                number_format($order->getPrice()[$key]['grand_invoice_total'], 2),
                $invoiceView->getInvoiceBlock()->getItemBlock($invoiceId)->getGrandTotal()
            );
        }
    }

    /**
     * Returns a string representation of the object
     *
     * @return string
     */
    public function toString()
    {
        return 'Invoiced Grand Total amount is equal to placed order Grand Total amount on invoice page.';
    }
}
