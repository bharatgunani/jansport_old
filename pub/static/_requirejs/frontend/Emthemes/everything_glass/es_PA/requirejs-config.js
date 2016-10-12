(function(require){
require.config({"baseUrl":"http://45.33.122.66/jansport_old/static/frontend/Emthemes/everything_glass/es_PA"});
(function() {
/**
 * @author    Amasty Team
 * @copyright Copyright (c) Amasty Ltd. ( http://www.amasty.com/ )
 * @package   Amasty_Shopby
 */

var config = {
    map: {
        '*': {
            amShopbyFilterAbstract: 'Amasty_Shopby/js/amShopby',
            amShopbyFilterItemDefault: 'Amasty_Shopby/js/amShopby',
            amShopbyFilterDropdown: 'Amasty_Shopby/js/amShopby',
            amShopbyFilterSlider: 'Amasty_Shopby/js/amShopby',
            amShopbyAjax: 'Amasty_Shopby/js/amShopbyAjax'
        }
    }
};

require.config(config);
})();
(function() {
/**
 * Copyright © 2015 Magento. All rights reserved.
 * See COPYING.txt for license details.
 */

var config = {
    map: {
        '*': {
			quickShop: 'Emthemes_QuickShop/js/quickshop'
        }
    }
};

require.config(config);
})();
(function() {
/**
 * Copyright © 2015 Magento. All rights reserved.
 * See COPYING.txt for license details.
 */

var config = {
    "waitSeconds": 0,
    "map": {
        "*": {
            "mageUtils": "mage/utils/main",
            "ko": "knockoutjs/knockout",
            "knockout": "knockoutjs/knockout"
        }
    },
    "shim": {
        "jquery/jquery-migrate": ["jquery"],
        "jquery/jquery.hashchange": ["jquery", "jquery/jquery-migrate"],
        "jquery/jstree/jquery.hotkeys": ["jquery"],
        "jquery/hover-intent": ["jquery"],
        "mage/adminhtml/backup": ["prototype"],
        "mage/captcha": ["prototype"],
        "mage/common": ["jquery"],
        "mage/new-gallery": ["jquery"],
        "mage/webapi": ["jquery"],
        "jquery/ui": ["jquery"],
        "MutationObserver": ["es6-collections"],
        "tinymce": {
            "exports": "tinymce"
        },
        "moment": {
            "exports": "moment"
        },
        "matchMedia": {
            "exports": "mediaCheck"
        },
        "jquery/jquery-storageapi": {
            "deps": ["jquery/jquery.cookie"]
        }
    },
    "paths": {
        "jquery/validate": "jquery/jquery.validate",
        "jquery/hover-intent": "jquery/jquery.hoverIntent",
        "jquery/file-uploader": "jquery/fileUploader/jquery.fileupload-fp",
        "jquery/jquery.hashchange": "jquery/jquery.ba-hashchange.min",
        "prototype": "legacy-build.min",
        "jquery/jquery-storageapi": "jquery/jquery.storageapi.min",
        "text": "mage/requirejs/text",
        "domReady": "requirejs/domReady",
        "tinymce": "tiny_mce/tiny_mce_src"
    },
    "deps": [
        "jquery/jquery-migrate"
    ]
};

require(['jquery'], function ($) {
    $.noConflict();
});

require.config(config);
})();
(function() {
/**
 * Copyright © 2015 Magento. All rights reserved.
 * See COPYING.txt for license details.
 */

var config = {
    map: {
        "*": {
            "rowBuilder":             "Magento_Theme/js/row-builder",
            "toggleAdvanced":         "mage/toggle",
            "translateInline":        "mage/translate-inline",
            "sticky":                 "mage/sticky",
            "tabs":                   "mage/tabs",
            "zoom":                   "mage/zoom",
            "collapsible":            "mage/collapsible",
            "dropdownDialog":         "mage/dropdown",
            "dropdown":               "mage/dropdowns",
            "accordion":              "mage/accordion",
            "loader":                 "mage/loader",
            "tooltip":                "mage/tooltip",
            "deletableItem":          "mage/deletable-item",
            "itemTable":              "mage/item-table",
            "fieldsetControls":       "mage/fieldset-controls",
            "fieldsetResetControl":   "mage/fieldset-controls",
            "redirectUrl":            "mage/redirect-url",
            "loaderAjax":             "mage/loader",
            "menu":                   "mage/menu",
            "popupWindow":            "mage/popup-window",
            "validation":             "mage/validation/validation",
            "welcome":                "Magento_Theme/js/view/welcome"
        }
    },
    paths: {
        "jquery/ui": "jquery/jquery-ui"
    },
    deps: [
        "jquery/jquery.mobile.custom",
        "js/responsive",
        "mage/common",
        "mage/dataPost",
        "js/theme",
        "mage/bootstrap"
    ]
};

require.config(config);
})();
(function() {
/**
 * Copyright © 2015 Magento. All rights reserved.
 * See COPYING.txt for license details.
 */

var config = {
    map: {
        '*': {
            checkoutBalance:    'Magento_Customer/js/checkout-balance',
            address:            'Magento_Customer/address',
            setPassword:        'Magento_Customer/set-password'
        }
    }
};

require.config(config);
})();
(function() {
/**
 * Copyright © 2015 Magento. All rights reserved.
 * See COPYING.txt for license details.
 */

var config = {
    map: {
        '*': {
            compareItems:           'Magento_Catalog/js/compare',
            compareList:            'Magento_Catalog/js/list',
            relatedProducts:        'Magento_Catalog/js/related-products',
            upsellProducts:         'Magento_Catalog/js/upsell-products',
            productListToolbarForm: 'Magento_Catalog/js/product/list/toolbar',
            catalogGallery:         'Magento_Catalog/js/gallery',
            priceBox:               'Magento_Catalog/js/price-box',
            priceOptionDate:        'Magento_Catalog/js/price-option-date',
            priceOptionFile:        'Magento_Catalog/js/price-option-file',
            priceOptions:           'Magento_Catalog/js/price-options',
            priceUtils:             'Magento_Catalog/js/price-utils',
            catalogAddToCart:       'Magento_Catalog/js/catalog-add-to-cart'
        }
    }
};

require.config(config);
})();
(function() {
/**
 * Copyright © 2015 Magento. All rights reserved.
 * See COPYING.txt for license details.
 */

var config = {
    map: {
        '*': {
            bundleOption:   'Magento_Bundle/bundle',
            priceBundle:    'Magento_Bundle/js/price-bundle',
            slide:          'Magento_Bundle/js/slide',
            productSummary: 'Magento_Bundle/js/product-summary'
        }
    }
};
require.config(config);
})();
(function() {
/**
 * Copyright © 2015 Magento. All rights reserved.
 * See COPYING.txt for license details.
 */

var config = {
    map: {
        '*': {
            quickSearch: 'Magento_Search/form-mini'
        }
    }
};
require.config(config);
})();
(function() {
/**
 * Copyright © 2015 Magento. All rights reserved.
 * See COPYING.txt for license details.
 */

var config = {
    map: {
        '*': {
            addToCart: 'Magento_Msrp/js/msrp'
        }
    }
};
require.config(config);
})();
(function() {
/**
 * Copyright © 2015 Magento. All rights reserved.
 * See COPYING.txt for license details.
 */

var config = {
    map: {
        '*': {
            creditCardType: 'Magento_Payment/cc-type'
        }
    }
};
require.config(config);
})();
(function() {
/**
 * Copyright © 2015 Magento. All rights reserved.
 * See COPYING.txt for license details.
 */

var config = {
    map: {
        '*': {
            downloadable: 'Magento_Downloadable/downloadable'
        }
    }
};
require.config(config);
})();
(function() {
/**
 * Copyright © 2015 Magento. All rights reserved.
 * See COPYING.txt for license details.
 */
/*jshint browser:true jquery:true*/
/*global alert*/
var config = {
    config: {
        mixins: {
            'Magento_Checkout/js/action/place-order': {
                'Magento_CheckoutAgreements/js/model/place-order-mixin': true
            }
        }
    }
};

require.config(config);
})();
(function() {
// /**
 // * Copyright © 2015 Magento. All rights reserved.
 // * See COPYING.txt for license details.
 // */

var config = {
    map: {
        '*': {
			slideshow:				'Emthemes_Slideshow/js/slideshow',
			easingmin:				'Emthemes_Slideshow/js/jquery.easing.min',
			masterslidermin: 		'Emthemes_Slideshow/js/masterslider.min'
        }
    }
};

require.config(config);
})();
(function() {
/**
 * Copyright © 2015 Magento. All rights reserved.
 * See COPYING.txt for license details.
 */

var config = {
    map: {
        '*': {
            catalogSearch: 'Magento_CatalogSearch/form-mini'
        }
    }
};
require.config(config);
})();
(function() {
/**
 * Copyright © 2015 Magento. All rights reserved.
 * See COPYING.txt for license details.
 */

var config = {
    map: {
        '*': {
            giftMessage:    'Magento_Sales/gift-message',
            ordersReturns:  'Magento_Sales/orders-returns'
        }
    }
};
require.config(config);
})();
(function() {
/**
 * Copyright © 2015 Magento. All rights reserved.
 * See COPYING.txt for license details.
 */

var config = {
    map: {
        '*': {
            requireCookie: 'Magento_Cookie/js/require-cookie',
            cookieNotices: 'Magento_Cookie/js/notices'
        }
    }
};
require.config(config);
})();
(function() {
/**
 * Copyright © 2015 Magento. All rights reserved.
 * See COPYING.txt for license details.
 */

var config = {
    map: {
        '*': {
            discountCode:           'Magento_Checkout/js/discount-codes',
            shoppingCart:           'Magento_Checkout/js/shopping-cart',
            regionUpdater:          'Magento_Checkout/js/region-updater',
            sidebar:                'Magento_Checkout/js/sidebar',
            checkoutLoader:         'Magento_Checkout/js/checkout-loader',
            checkoutData:           'Magento_Checkout/js/checkout-data',
            proceedToCheckout:      'Magento_Checkout/js/proceed-to-checkout'
        }
    },
    deps: [
        "Magento_Checkout/js/checkout-loader"
    ]
};

require.config(config);
})();
(function() {
/**
 * Copyright © 2015 Magento. All rights reserved.
 * See COPYING.txt for license details.
 */

var config = {
    map: {
        "*": {
            "taxToggle": "Magento_Weee/tax-toggle"
        }
    }
};

require.config(config);
})();
(function() {
/**
 * Copyright © 2015 Magento. All rights reserved.
 * See COPYING.txt for license details.
 */

var config = {
    map: {
        '*': {
            giftOptions:    'Magento_GiftMessage/gift-options',
            extraOptions:   'Magento_GiftMessage/extra-options'
        }
    }
};
require.config(config);
})();
(function() {
/**
 * Copyright © 2015 Magento. All rights reserved.
 * See COPYING.txt for license details.
 */

var config = {
    map: {
        '*': {
            configurable: 'Magento_ConfigurableProduct/js/configurable'
        }
    }
};
require.config(config);
})();
(function() {
/**
 * Copyright © 2015 Magento. All rights reserved.
 * See COPYING.txt for license details.
 */

var config = {
    map: {
        '*': {
            multiShipping: 'Magento_Multishipping/js/multi-shipping',
            orderOverview: 'Magento_Multishipping/js/overview',
            payment: 'Magento_Multishipping/js/payment'
        }
    }
};
require.config(config);
})();
(function() {
/**
 * Copyright © 2015 Magento. All rights reserved.
 * See COPYING.txt for license details.
 */

var config = {
    map: {
        '*': {
            pageCache:  'Magento_PageCache/js/page-cache'
        }
    }
};

require.config(config);
})();
(function() {
/**
 * Copyright © 2015 Magento. All rights reserved.
 * See COPYING.txt for license details.
 */

var config = {
    map: {
        '*': {
            captcha: 'Magento_Captcha/captcha'
        }
    }
};
require.config(config);
})();
(function() {
/**
 * Copyright © 2015 Magento. All rights reserved.
 * See COPYING.txt for license details.
 */

var config = {
    map: {
        '*': {
            orderReview:            'Magento_Paypal/order-review',
            paypalCheckout:         'Magento_Paypal/js/paypal-checkout'
        }
    }
};
require.config(config);
})();
(function() {
/**
 * Copyright © 2015 Magento. All rights reserved.
 * See COPYING.txt for license details.
 */

var config = {
    map: {
        '*': {
            transparent:            'Magento_Payment/transparent'
        }
    }
};
require.config(config);
})();
(function() {
/**
 * Copyright © 2015 Magento. All rights reserved.
 * See COPYING.txt for license details.
 */
/*eslint no-unused-vars: 0*/
var config = {
    map: {
        '*': {
            loadPlayer: 'Magento_ProductVideo/js/load-player',
            fotoramaVideoEvents: 'Magento_ProductVideo/js/fotorama-add-video-events'
        }
    }
};

require.config(config);
})();
(function() {
/**
 * Copyright © 2015 Magento. All rights reserved.
 * See COPYING.txt for license details.
 */

var config = {
    map: {
        '*': {
            recentlyViewedProducts: 'Magento_Reports/js/recently-viewed'
        }
    }
};
require.config(config);
})();
(function() {
/**
 * Copyright © 2015 Magento. All rights reserved.
 * See COPYING.txt for license details.
 */

var config = {
    map: {
        '*': {
            transparent: 'Magento_Payment/transparent'
        }
    }
};

require.config(config);
})();
(function() {
/**
 * Copyright © 2015 Magento. All rights reserved.
 * See COPYING.txt for license details.
 */

var config = {
    paths: {
        'ui/template': 'Magento_Ui/templates'
    },
    map: {
        '*': {
            uiElement:      'Magento_Ui/js/lib/core/element/element',
            uiCollection:   'Magento_Ui/js/lib/core/collection',
            uiComponent:    'Magento_Ui/js/lib/core/collection',
            uiClass:        'Magento_Ui/js/lib/core/class',
            uiEvents:       'Magento_Ui/js/lib/core/events',
            uiRegistry:     'Magento_Ui/js/lib/registry/registry',
            uiLayout:       'Magento_Ui/js/core/renderer/layout'
        }
    }
};

require.config(config);
})();
(function() {
/**
 * Copyright © 2015 Magento. All rights reserved.
 * See COPYING.txt for license details.
 */

var config = {
    map: {
        '*': {
            swatchRenderer: 'Magento_Swatches/js/SwatchRenderer'
        }
    }
};
require.config(config);
})();
(function() {
/**
 * Copyright © 2015 Magento. All rights reserved.
 * See COPYING.txt for license details.
 */

var config = {
    map: {
        '*': {
            braintree:                  'https://js.braintreegateway.com/v2/braintree.js',
            braintreeDataJs:            'Magento_Braintree/js/cc-data',
            braintreeForm:              'Magento_Braintree/js/cc-form',
            braintreeEditForm:          'Magento_Braintree/js/cc-edit-form',
            braintreePayPalMinicart:    'Magento_Braintree/js/button/braintree-paypal-minicart',
            transparent:                'Magento_Payment/transparent'
        }
    }
};

require.config(config);
})();
(function() {
/**
 * Copyright © 2015 Magento. All rights reserved.
 * See COPYING.txt for license details.
 */

var config = {
    map: {
        '*': {
            editTrigger:   'mage/edit-trigger',
            addClass:      'Magento_Translation/add-class'
        }
    },
    deps: [
        'mage/translate-inline'
    ]
};

require.config(config);
})();
(function() {
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

var config = {
    map: {
        '*': {
            customerLogin: 'Magestore_OneStepCheckout/js/customer-login',
            'magestore/oneStepCheckout': 'Magestore_OneStepCheckout/js/onestepcheckout',
            'magestore/billingAddress': 'Magestore_OneStepCheckout/js/billing-address',
            'magestore/paymentMethod': 'Magestore_OneStepCheckout/js/payment-method',
            'magestore/shippingAddress': 'Magestore_OneStepCheckout/js/shipping-address',
            'magestore/shippingMethod': 'Magestore_OneStepCheckout/js/shipping-method',
            'magestore/orderReview': 'Magestore_OneStepCheckout/js/order-review',
            'magestore/applyCoupon': 'Magestore_OneStepCheckout/js/apply-coupon',
            'magestore/validation': 'Magestore_OneStepCheckout/js/validation',
        }
    },
    paths: {
    }
};

require.config(config);
})();
(function() {
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
var config = {
    map: {
       '*': {
           'magestore/regionUpdater' : 'Magestore_OneStepCheckout/js/region-updater',
           'magestore/googleApiLoader' : 'Magestore_OneStepCheckout/js/google-api-loader',
       }
    },
    paths: {
    },
};

require.config(config);
})();
(function() {
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
 * @package     Magestore_Storelocator
 * @copyright   Copyright (c) 2012 Magestore (http://www.magestore.com/)
 * @license     http://www.magestore.com/license-agreement.html
 */
var config = {
    map: {
        '*': {
            'magestore/googlemap' : 'Magestore_Storelocator/js/googlemap',
            'magestore/pagination' : 'Magestore_Storelocator/js/pagination',
            'magestore/tag' : 'Magestore_Storelocator/js/tag',
            'magestore/liststore' : 'Magestore_Storelocator/js/liststore',
            'magestore/direction' : 'Magestore_Storelocator/js/direction',
            'magestore/searchbox' : 'Magestore_Storelocator/js/searchbox',
            'magestore/viewpage/map' : 'Magestore_Storelocator/js/viewpage/map'
        }
    },
    paths: {
    }
};

require.config(config);
})();
(function() {
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
 * @package     Magestore_Storelocator
 * @copyright   Copyright (c) 2012 Magestore (http://www.magestore.com/)
 * @license     http://www.magestore.com/license-agreement.html
 */
var config = {
    map: {
       '*': {
           'magestore/map-loader' : 'Magestore_Storelocator/js/store/map/map-loader',
           'magestore/region-updater' : 'Magestore_Storelocator/js/store/region-updater',
       }
    },
    paths: {
    },
};

require.config(config);
})();
(function() {

var config = {
    map: {
        '*': {
            magicToolboxThumbSwitcher: 'MagicToolbox_MagicZoomPlus/js/thumb-switcher',
            configurable:              'MagicToolbox_MagicZoomPlus/js/configurable',
            swatchRenderer:            'MagicToolbox_MagicZoomPlus/js/SwatchRenderer'
        }
    }
};

require.config(config);
})();
(function() {
var config = {
    map: {
        '*' : {
            'Navin_Bestseller/js/owl.carousel' : 'Navin_Bestseller/js/owl.carousel',
            'Navin_Bestseller/js/owl.carousel.min' : 'Navin_Bestseller/js/owl.carousel.min'
        }
    }
};
require.config(config);
})();
(function() {
var config = {
    map: {
        '*': {
          'Magento_Payment/template/payment/cc-form.html': 
              'Paguelofacil_Gateway/template/payment/cc-form-paguelofacil.html'
        }
  }
};
require.config(config);
})();
(function() {
/**
 * Plumrocket Inc.
 *
 * NOTICE OF LICENSE
 *
 * This source file is subject to the End-user License Agreement
 * that is available through the world-wide-web at this URL:
 * http://wiki.plumrocket.net/wiki/EULA
 * If you are unable to obtain it through the world-wide-web, please
 * send an email to support@plumrocket.com so we can send you a copy immediately.
 *
 * @package     Plumrocket_SocialLoginFree
 * @copyright   Copyright (c) 2016 Plumrocket Inc. (http://www.plumrocket.com)
 * @license     http://wiki.plumrocket.net/wiki/EULA  End-user License Agreement
 */

var config = {
    map: {
        '*': {
        	'pslogin': 'Plumrocket_SocialLoginFree/js/pslogin'
        }
    }
};
require.config(config);
})();
(function() {
/**
 * Copyright © 2015 Magento. All rights reserved.
 * See COPYING.txt for license details.
 */

var config = {
    map: {
        '*': {
            quickSearch: 'Magento_Search/form-mini',			
        }
    }
};
require.config(config);
})();
(function() {
var config = {
  map: {
        "*": {
            'emslider': 'js/owlcarousel/owlslider',
            'modal' : 'Magento_Ui/js/modal/modal',
            'emmenu': 'js/menu/menu',
            'equalElement' : 'js/equalElement',
            'emCollapsible': 'js/emCollapsible'        
        }
    },
    paths:  {
        "owlslider" : "js/owlcarousel/owl.carousel.min",
        "detectmobile": "js/detectmobilebrowser"
    },
    "shim": {
      "js/owlcarousel/owl.carousel.min": ["jquery"],
      "js/detectmobilebrowser": ["jquery"]                
      },
  deps: [    
        "js/em0144",
        "js/emMegaMenu"
    ]
  
};
 

require.config(config);
})();
(function() {
/**
 * Copyright © 2015 Magento. All rights reserved.
 * See COPYING.txt for license details.
 */

var config = {
    map: {
        '*': {
            quickSearch: 'Magento_Search/form-mini',			
        }
    }
};
require.config(config);
})();
(function() {
/**
 * Copyright © 2015 Magento. All rights reserved.
 * See COPYING.txt for license details.
 */

var config = {
    map: {
        '*': {
            sidr: 'Magento_Checkout/js/sidr',	
        }
    }
};
require.config(config);
})();
(function() {
var config = {
  map: {
        "*": {
            'emslider': 'js/owlcarousel/owlslider',
            'modal' : 'Magento_Ui/js/modal/modal',
            'emmenu': 'js/menu/menu',
            'equalElement' : 'js/equalElement',
            'emCollapsible': 'js/emCollapsible'        
        }
    },
    paths:  {
        "owlslider" : "js/owlcarousel/owl.carousel.min",
        "detectmobile": "js/detectmobilebrowser"
    },
    "shim": {
      "js/owlcarousel/owl.carousel.min": ["jquery"],
      "js/detectmobilebrowser": ["jquery"]                
      },
  deps: [    
        "js/em0144",
        "js/emMegaMenu"
    ]
  
};
 

require.config(config);
})();



})(require);