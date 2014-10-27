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


class SubscriptionSpec extends ObjectBehavior
{
    function it_is_initializable()
    {
        $this->shouldHaveType('Sylius\Component\Core\Model\Subscription');
    }

    function it_implements_Sylius_core_subscription_interface()
    {
        $this->shouldImplement('Sylius\Component\Core\Model\SubscriptionInterface');
    }

    function it_extends_Sylius_subscription_bundle_subscription()
    {
        $this->shouldHaveType('Sylius\Component\Subscription\Model\Subscription');
    }

    function it_has_no_user_by_default()
    {
        $this->getUser()->shouldReturn(null);
    }

    /**
     * @param Sylius\Component\Core\Model\UserInterface $user
     */
    function its_user_is_mutable($user)
    {
        $this->setUser($user);
        $this->getUser()->shouldReturn($user);
    }

    function is_has_no_shipping_address_by_default()
    {
        $this->getShippingAddress()->shouldReturn(null);
    }

    /**
     * @param Sylius\Component\Core\Model\AddressInterface $address
     */
    function its_shipping_address_is_mutable($address)
    {
        $this->setShippingAddress($address);
        $this->getShippingAddress()->shouldReturn($address);
    }
}
