<?php

/*
* This file is part of the Sylius package.
*
* (c) Paweł Jędrzejewski
*
* For the full copyright and license information, please view the LICENSE
* file that was distributed with this source code.
*/

namespace spec\Sylius\Bundle\SubscriptionBundle\Processor;

use PhpSpec\ObjectBehavior;
use Prophecy\Argument;
use Sylius\Component\Subscription\Event\SubscriptionEvents;

class SubscriptionProcessorSpec extends ObjectBehavior
{
    /**
     * @param Sylius\Component\Subscription\Repository\SubscriptionRepositoryInterface $repository
     * @param Doctrine\Common\Persistence\ObjectManager $manager
     * @param Symfony\Component\EventDispatcher\EventDispatcher $dispatcher
     */
    function let($repository, $manager, $dispatcher)
    {
        $this->beConstructedWith($repository, $manager, $dispatcher);
    }

    function it_is_initializable()
    {
        $this->shouldHaveType('Sylius\Component\Subscription\Processor\SubscriptionProcessor');
    }

    function it_implements_Sylius_recurring_scheduler_interface()
    {
        $this->shouldImplement('Sylius\Component\Subscription\Processor\SubscriptionProcessorInterface');
    }

    /**
     * @param Sylius\Component\Subscription\Repository\SubscriptionRepositoryInterface $repository
     * @param Symfony\Component\EventDispatcher\EventDispatcher $dispatcher
     * @param Sylius\Component\Subscription\Model\SubscriptionInterface $subscription
     */
    function it_should_dispatch_events($repository, $dispatcher, $subscription)
    {
        $repository->findScheduled()->willReturn(array(
            $subscription
        ));

        $dispatcher
            ->dispatch(SubscriptionEvents::SUBSCRIPTION_PROCESS_BATCH_START, Argument::type('Symfony\Component\EventDispatcher\GenericEvent'))
            ->shouldBeCalled();
        $dispatcher
            ->dispatch(SubscriptionEvents::SUBSCRIPTION_PROCESS_BATCH_END, Argument::type('Symfony\Component\EventDispatcher\GenericEvent'))
            ->shouldBeCalled();

        $dispatcher
            ->dispatch(SubscriptionEvents::SUBSCRIPTION_PROCESS_INITIALIZE, Argument::type('Sylius\Component\Subscription\Event\SubscriptionEvent'))
            ->shouldBeCalled();
        $dispatcher
            ->dispatch(SubscriptionEvents::SUBSCRIPTION_PROCESS_SUCCESS, Argument::type('Sylius\Component\Subscription\Event\SubscriptionEvent'))
            ->shouldBeCalled();
        $dispatcher
            ->dispatch(SubscriptionEvents::SUBSCRIPTION_PROCESS_COMPLETED, Argument::type('Sylius\Component\Subscription\Event\SubscriptionEvent'))
            ->shouldBeCalled();

        $this->process();
    }

    /**
     * @param Sylius\Component\Subscription\Repository\SubscriptionRepositoryInterface $repository
     * @param Sylius\Component\Subscription\Model\SubscriptionInterface $subscription
     */
    function it_should_set_processed_date($repository, $subscription)
    {
        $repository->findScheduled()->willReturn(array(
            $subscription
        ));

        $subscription->setProcessedDate(Argument::any())->shouldBeCalled();

        $this->process();
    }

    /**
     * @param Sylius\Component\Subscription\Repository\SubscriptionRepositoryInterface $repository
     * @param Doctrine\Common\Persistence\ObjectManager $manager
     * @param Sylius\Component\Subscription\Model\SubscriptionInterface $subscription
     */
    function it_should_persist_entity($repository, $manager, $subscription)
    {
        $repository->findScheduled()->willReturn(array(
            $subscription
        ));

        $manager->flush()->shouldBeCalled();

        $this->process();
    }
}
