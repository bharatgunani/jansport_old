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
 * @package     Magestore_OneStepCheckout
 * @copyright   Copyright (c) 2012 Magestore (http://www.magestore.com/)
 * @license     http://www.magestore.com/license-agreement.html
 */

namespace Magestore\OneStepCheckout\Helper;

use Magento\Sales\Model\Order;
use Magento\Sales\Model\Order\Address\Renderer;

/**
 * Class Data
 *
 * @category Magestore
 * @package  Magestore_OneStepCheckout
 * @module   OneStepCheckout
 * @author   Magestore Developer
 */
class Data extends \Magento\Framework\App\Helper\AbstractHelper
{
    const XML_PATH_TRANS_EMAIL_GENERAL_EMAIL = 'trans_email/ident_general/email';

    const XML_PATH_TRANS_EMAIL_GENERAL_NAME = 'trans_email/ident_general/name';

    /**
     * Store manager
     *
     * @var \Magento\Store\Model\StoreManagerInterface
     */
    protected $_storeManager;

    /**
     * @var \Magento\Newsletter\Model\SubscriberFactory
     */
    protected $_subscriberFactory;

    /**
     * @var \Magestore\OneStepCheckout\Model\SystemConfig
     */
    protected $_systemConfig;

    /**
     * @var \Magento\Framework\ObjectManagerInterface
     */
    protected $_objectManager;

    /**
     * @var \Magento\GiftMessage\Model\MessageFactory
     */
    protected $_giftMessageFactory;

    /**
     * @var \Magento\Framework\Mail\Template\TransportBuilder
     */
    protected $_transportBuilder;

    /**
     * @var Renderer
     */
    protected $_addressRenderer;

    /**
     * @var \Magento\Payment\Helper\Data
     */
    protected $_paymentHelperData;

    /**
     * @var \Magento\Framework\Translate\Inline\StateInterface
     */
    protected $inlineTranslation;

    /**
     * @var \Magento\Checkout\Model\Session
     */
    protected $_checkoutSession;

    /**
     * @var \Magento\Framework\Pricing\PriceCurrencyInterface
     */
    protected $_priceCurrency;

    /**
     * Data constructor.
     *
     * @param \Magento\Framework\App\Helper\Context              $context
     * @param \Magento\Store\Model\StoreManagerInterface         $storeManager
     * @param \Magento\Framework\Mail\Template\TransportBuilder  $transportBuilder
     * @param Renderer                                           $addressRenderer
     * @param \Magento\Payment\Helper\Data                       $paymentHelperData
     * @param \Magento\Framework\App\Config\ScopeConfigInterface $scopeConfig
     * @param \Magestore\OneStepCheckout\Model\SystemConfig      $systemConfig
     * @param \Magento\Framework\ObjectManagerInterface          $objectManager
     * @param \Magento\Framework\Translate\Inline\StateInterface $inlineTranslation
     * @param \Magento\GiftMessage\Model\MessageFactory          $giftMessageFactory
     * @param \Magento\Checkout\Model\Session                    $checkoutSession
     * @param \Magento\Framework\Pricing\PriceCurrencyInterface  $priceCurrency
     * @param \Magento\Newsletter\Model\SubscriberFactory        $subscriberFactory
     */
    public function __construct(
        \Magento\Framework\App\Helper\Context $context,
        \Magento\Store\Model\StoreManagerInterface $storeManager,
        \Magento\Framework\Mail\Template\TransportBuilder $transportBuilder,
        Renderer $addressRenderer,
        \Magento\Payment\Helper\Data $paymentHelperData,
        \Magestore\OneStepCheckout\Model\SystemConfig $systemConfig,
        \Magento\Framework\ObjectManagerInterface $objectManager,
        \Magento\Framework\Translate\Inline\StateInterface $inlineTranslation,
        \Magento\GiftMessage\Model\MessageFactory $giftMessageFactory,
        \Magento\Checkout\Model\Session $checkoutSession,
        \Magento\Framework\Pricing\PriceCurrencyInterface $priceCurrency,
        \Magento\Newsletter\Model\SubscriberFactory $subscriberFactory
    )
    {
        parent::__construct($context);
        $this->_storeManager = $storeManager;
        $this->_subscriberFactory = $subscriberFactory;
        $this->_transportBuilder = $transportBuilder;
        $this->_paymentHelperData = $paymentHelperData;
        $this->_addressRenderer = $addressRenderer;
        $this->_systemConfig = $systemConfig;
        $this->_objectManager = $objectManager;
        $this->_giftMessageFactory = $giftMessageFactory;
        $this->inlineTranslation = $inlineTranslation;
        $this->_checkoutSession = $checkoutSession;
        $this->_priceCurrency = $priceCurrency;
    }

    /**
     * Generate url by route and parameters for ajax request
     *
     * @param   string $route
     * @param   array  $params
     *
     * @return  string
     */
    public function getAjaxUrl($route = '', $params = [])
    {
        if (!array_key_exists('_secure', $params)) {
            $params['_secure'] = $this->_storeManager->getStore()->isCurrentlySecure();
        }

        return $this->_getUrl($route, $params);
    }

    /**
     * @param $email
     */
    public function addSubscriber($email)
    {
        if ($email) {
            $subscriberModel = $this->_subscriberFactory->create()->loadByEmail($email);
            if ($subscriberModel->getId() === NULL) {
                try {
                    $this->_subscriberFactory->create()->subscribe($email);
                } catch (\Magento\Framework\Exception\LocalizedException $e) {

                } catch (\Exception $e) {

                }

            } elseif ($subscriberModel->getData('subscriber_status') != 1) {
                $subscriberModel->setData('subscriber_status', 1);
                try {
                    $subscriberModel->save();
                } catch (\Exception $e) {

                }
            }
        }
    }

    /**
     * Get payment info block as html
     *
     * @param Order $order
     *
     * @return string
     */
    protected function getPaymentHtml(Order $order, $storeId)
    {
        return $this->_paymentHelperData->getInfoBlockHtml(
            $order->getPayment(),
            $storeId
        );
    }

    /**
     * @return \Magento\Checkout\Model\Type\Onepage
     */
    public function getOnePage()
    {
        return $this->_objectManager->get('Magento\Checkout\Model\Type\Onepage');
    }

    /**
     * @param Order $order
     *
     * @return string|null
     */
    protected function getFormattedShippingAddress($order)
    {
        return $order->getIsVirtual()
            ? NULL
            : $this->_addressRenderer->format($order->getShippingAddress(), 'html');
    }

    /**
     * @param Order $order
     *
     * @return string|null
     */
    protected function getFormattedBillingAddress($order)
    {
        return $this->_addressRenderer->format($order->getBillingAddress(), 'html');
    }

    /**
     * @param \Magento\Sales\Model\Order $order
     */
    public function sendNewOrderEmail(\Magento\Sales\Model\Order $order)
    {
        $storeId = $order->getStore()->getId();
        if ($this->_systemConfig->isEnableSendEmailAdmin()) {
            $emailArray = explode(',', $this->_systemConfig->notifyToEmail());
            $sendTo = [];
            if (!empty($emailArray)) {
                foreach ($emailArray as $email) {
                    $sendTo[] = ['email' => trim($email), 'name' => ''];
                }
            }
            $this->inlineTranslation->suspend();
            foreach ($sendTo as $recipient) {
                try {
                    $transport = $this->_transportBuilder->setTemplateIdentifier(
                        $this->_systemConfig->getEmailTemplate()
                    )->setTemplateOptions(
                        ['area' => \Magento\Framework\App\Area::AREA_FRONTEND, 'store' => $storeId]
                    )->setTemplateVars(
                        [
                            'order'                    => $order,
                            'billing'                  => $order->getBillingAddress(),
                            'payment_html'             => $this->getPaymentHtml($order, $storeId),
                            'store'                    => $order->getStore(),
                            'formattedShippingAddress' => $this->getFormattedShippingAddress($order),
                            'formattedBillingAddress'  => $this->getFormattedBillingAddress($order),
                        ]
                    )->setFrom(
                        [
                            'email' => $this->scopeConfig->getValue(
                                self::XML_PATH_TRANS_EMAIL_GENERAL_EMAIL,
                                \Magento\Store\Model\ScopeInterface::SCOPE_STORE,
                                $storeId
                            ),
                            'name'  => $this->scopeConfig->getValue(
                                self::XML_PATH_TRANS_EMAIL_GENERAL_NAME,
                                \Magento\Store\Model\ScopeInterface::SCOPE_STORE,
                                $storeId
                            ),
                        ]
                    )->addTo(
                        $recipient['email'],
                        $recipient['name']
                    )->getTransport();
                    $transport->sendMessage();
                } catch (\Magento\Framework\Exception\MailException $ex) {

                }
            }
            $this->inlineTranslation->resume();
        }
    }

    /**
     * @return bool
     */
    public function isContainDownloadableProduct()
    {
        if ($this->scopeConfig->isSetFlag('catalog/downloadable/disable_guest_checkout')) {
            $quote = $this->getOnepage()->getQuote();
            foreach ($quote->getAllItems() as $item) {
                if (($product = $item->getProduct())
                    && $product->getTypeId() == \Magento\Downloadable\Model\Product\Type::TYPE_DOWNLOADABLE
                ) {
                    return TRUE;
                }
            }
        }

        return FALSE;
    }

    /**
     * @param null $customerId
     * @param      $sender
     * @param      $recipient
     * @param      $message
     *
     * @return $this
     */
    public function saveGiftMessage($customerId = NULL, $sender = NULL, $recipient = NULL, $message)
    {
        $data['customer_id'] = $customerId;
        $data['sender'] = $sender;
        $data['recipient'] = $recipient;
        $data['message'] = $message;
        $giftObject = $this->_giftMessageFactory->create()->setData($data)->save();

        return $giftObject;
    }

    /**
     * @return mixed
     */
    public function isEnabledProductImage()
    {
        return $this->_systemConfig->isEnabledProductImage();
    }

    /**
     * @return mixed
     */
    public function getGiftWrapAmount()
    {
        return $this->_systemConfig->getGiftWrapAmount();
    }


    /**
     * @return float|int|mixed
     */
    public function getOrderGiftWrapAmount()
    {
        $amount = $this->getGiftWrapAmount();
        $giftWrapAmount = 0;
        $items = $this->getQuote()->getAllVisibleItems();
        if ($this->getGiftwrapType() == 1) {
            foreach ($items as $item) {
                if ($item->getProduct()->isVirtual() || $item->getParentItem()) {
                    continue;
                }
                $giftWrapAmount += $amount * ($item->getQty());
            }

        } else {
            $giftWrapAmount = $amount;
        }
        $giftWrapAmount = $this->_priceCurrency->convert($giftWrapAmount);

        return $giftWrapAmount;
    }


    /**
     * @return mixed
     */
    public function getGiftWrapType()
    {
        return $this->_systemConfig->getGiftWrapType();
    }

    /**
     * @return \Magento\Quote\Model\Quote
     */
    public function getQuote()
    {
        if (empty($this->_quote)) {
            $this->_quote = $this->_checkoutSession->getQuote();
        }

        return $this->_quote;
    }

    public function getStreetLine()
    {
        return $this->scopeConfig->getValue('customer/address/street_lines',\Magento\Store\Model\ScopeInterface::SCOPE_STORE);
    }


}