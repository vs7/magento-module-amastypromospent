<?php

class VS7_AmastyPromoSpent_Block_Banner extends Amasty_Promo_Block_Banner
{
    protected function _getRulesCollection()
    {
        if (!$this->_rulesCollection) {
            /** @var Mage_Checkout_Model_Cart $quote */
            $quote = Mage::getModel('checkout/cart')->getQuote();
            $store = Mage::app()->getStore($quote->getStoreId());

            $this->_rulesCollection = Mage::getModel('salesrule/rule')
                ->getCollection()
                ->setValidationFilter($store->getWebsiteId(), $quote->getCustomerGroupId(), $quote->getCouponCode());

            $this->_rulesCollection->getSelect()->where("simple_action in ('ampromo_items', 'ampromo_product', 'ampromo_spent') and is_active = 1");

            if (!Mage::app()->isSingleStoreMode()) {
                /**
                 * check stores filter
                 * if rule don't have selected stores, they should be available too
                 * current store matched, stores filter not initialized or all stores options selected (0 value)
                 */
                $this->_rulesCollection->getSelect()->where("FIND_IN_SET ('{$store->getId()}', amstore_ids) or amstore_ids = '' or FIND_IN_SET (0, amstore_ids)");
            }
        }

        return $this->_rulesCollection;
    }
}