<?php

class VS7_AmastyPromoSpent_Model_Observer
{
    public function replaceJs($observer)
    {
        $block = $observer->getBlock();
        if ($block->getNameInLayout() == 'head') {
            $items = $block->getItems();
            if (isset($items['js/amasty/ampromo/admin.js'])) {
                $block->removeItem('js', 'amasty/ampromo/admin.js');
                $block->addItem('skin_js', 'vs7_amastypromospent/admin.js');
            }
        }
    }
}