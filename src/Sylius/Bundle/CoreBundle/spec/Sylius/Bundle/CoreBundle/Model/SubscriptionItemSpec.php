<?php

/*
 * This file is part of the Sylius package.
 *
 * (c) Paweł Jędrzejewski
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace spec\Sylius\Component\Core\Model;

use PhpSpec\ObjectBehavior;


class SubscriptionItemSpec extends ObjectBehavior
{
    function it_is_initializable()
    {
        $this->shouldHaveType('Sylius\Component\Core\Model\SubscriptionItem');
    }

    function it_implements_Sylius_core_subscription_item_interface()
    {
        $this->shouldImplement('Sylius\Component\Core\Model\SubscriptionItemInterface');
    }

    function it_extends_Sylius_subscription_bundle_subscription_item()
    {
        $this->shouldHaveType('Sylius\Component\Subscription\Model\SubscriptionItem');
    }

    function it_has_no_variant_by_default()
    {
        $this->getVariant()->shouldReturn(null);
    }

    /**
     * @param Sylius\Component\Product\Model\VariantInterface $variant
     */
    function its_variant_is_mutable($variant)
    {
        $this->setVariant($variant);
        $this->getVariant()->shouldReturn($variant);
    }

    /**
     * @param Sylius\Component\Product\Model\VariantInterface $variant
     * @param Sylius\Component\Core\Model\ProductInterface $product
     */
    function it_should_return_product_from_variant($variant, $product)
    {
        $variant->getProduct()->willReturn($product);
        $this->setVariant($variant);

        $this->getProduct()->shouldReturn($product);
    }

    function it_returns_no_product_by_default()
    {
        $this->getProduct()->shouldReturn(null);
    }
}
