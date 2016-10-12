<?php  
namespace Macrew\Paguelofacil\Model;
use Magento\Checkout\Model\ConfigProviderInterface;
use Magento\Payment\Model\CcConfig as CcConfig;
use Magento\Framework\App\Config\ScopeConfigInterface as scopeConfig;

class configProvider implements ConfigProviderInterface
{
	const CODE = 'paguelofacil_directpost';
    
	public function __construct(
         CcConfig $ccConfig,
		 scopeConfig $scopeConfig
    ) {
        $this->ccConfig = $ccConfig;
		$this->_scopeConfig = $scopeConfig;
    }
	
	
    public function getConfig()
    {
        return [
            'payment' => [
                'ccform' => [
                    'months' => [
						self::CODE => $this->getCcMonths()
					],
					'years' => [
						self::CODE => $this->getCcYears()
					],
					'hasVerification' => [
						self::CODE => $this->hasVerification(self::CODE)
					],
					'hasSsCardType' => [
						self::CODE => $this->hasSsCardType(self::CODE)
					],
					'availableTypes' => [
						self::CODE => $this->getCcAvailableTypes(self::CODE)
					],
					'ssStartYears' => [
						self::CODE => $this->getSsStartYears()
					],
                    'cvvImageUrl' => 
					[
						self::CODE => $this->getCvvImageUrl()
					]
                ]
            ]
        ];
    }
	
	 protected function getSsStartYears()
    {
        return $this->ccConfig->getSsStartYears();
    }

    /**
     * Retrieve credit card expire months
     *
     * @return array
     */
    protected function getCcMonths()
    {
        return $this->ccConfig->getCcMonths();
    }
	/**
     * Retrieve credit card expire years
     *
     * @return array
     */
    protected function getCcYears()
    {
        return $this->ccConfig->getCcYears();
    }

    /**
     * Retrieve CVV tooltip image url
     *
     * @return string
     */
    protected function getCvvImageUrl()
    {
        return $this->ccConfig->getCvvImageUrl();
    }

    /**
     * Retrieve availables credit card types
     *
     * @param string $methodCode
     * @return array
     */
    protected function getCcAvailableTypes($methodCode)
    {
        $types = $this->ccConfig->getCcAvailableTypes();
        $availableTypes = $this->_scopeConfig->getValue('payment/paguelofacil_directpost/cctypes', \Magento\Store\Model\ScopeInterface::SCOPE_STORE);
        if ($availableTypes) {
            $availableTypes = explode(',', $availableTypes);
            foreach (array_keys($types) as $code) {
                if (!in_array($code, $availableTypes)) {
                    unset($types[$code]);
                }
            }
        }
        return $types;
    }
	
	protected function hasVerification($methodCode)
    {
        $result = $this->ccConfig->hasVerification();
        $configData = $this->_scopeConfig->getValue('payment/paguelofacil_directpost/useccv', \Magento\Store\Model\ScopeInterface::SCOPE_STORE);
        if ($configData !== null) {
            $result = (bool)$configData;
        }
        return $result;
    }

    /**
     * Whether switch/solo card type available
     *
     * @param string $methodCode
     * @return bool
     */
    protected function hasSsCardType($methodCode)
    {
        $result = false;
        $availableTypes = explode(',', $this->_scopeConfig->getValue('payment/paguelofacil_directpost/cctypes', \Magento\Store\Model\ScopeInterface::SCOPE_STORE));
        $ssPresentations = array_intersect(['SS', 'SM', 'SO'], $availableTypes);
        if ($availableTypes && count($ssPresentations) > 0) {
            $result = true;
        }
        return $result;
    }
}
?>