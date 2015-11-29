<?php
/*
 * WellCommerce Open-Source E-Commerce Platform
 * 
 * This file is part of the WellCommerce package.
 *
 * (c) Adam Piotrowski <adam@wellcommerce.org>
 * 
 * For the full copyright and license information,
 * please view the LICENSE file that was distributed with this source code.
 */

namespace WellCommerce\Bundle\AppBundle\Service\Shop\Context;

use WellCommerce\Bundle\AppBundle\Entity\ShopInterface;

/**
 * Class AbstractShopContext
 *
 * @author Adam Piotrowski <adam@wellcommerce.org>
 */
abstract class AbstractShopContext
{
    /**
     * @var ShopInterface
     */
    protected $currentShop;

    /**
     * {@inheritdoc}
     */
    public function setCurrentShop(ShopInterface $shop)
    {
        $this->currentShop = $shop;
    }

    /**
     * {@inheritdoc}
     */
    public function getCurrentShop()
    {
        return $this->currentShop;
    }

    /**
     * {@inheritdoc}
     */
    public function hasCurrentShop()
    {
        return $this->currentShop instanceof ShopInterface;
    }

    /**
     * {@inheritdoc}
     */
    public function getCurrentShopIdentifier()
    {
        if ($this->hasCurrentShop()) {
            return $this->currentShop->getId();
        }

        return null;
    }
}
