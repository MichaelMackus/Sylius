<?php

/*
* This file is part of the Sylius package.
*
* (c) Paweł Jędrzejewski
*
* For the full copyright and license information, please view the LICENSE
* file that was distributed with this source code.
*/

namespace spec\Sylius\Bundle\SubscriptionBundle\Scheduler;

use PhpSpec\ObjectBehavior;
use Prophecy\Argument;

class RecurringSchedulerSpec extends ObjectBehavior
{
    function it_is_initializable()
    {
        $this->shouldHaveType('Sylius\Component\Subscription\Scheduler\RecurringScheduler');
    }

    function it_implements_Sylius_recurring_scheduler_interface()
    {
        $this->shouldImplement('Sylius\Component\Subscription\Scheduler\RecurringSchedulerInterface');
    }

    /**
     * @param Sylius\Component\Subscription\Model\SchedulableInterface $schedulable
     * @param Sylius\Component\Subscription\Model\RecurringInterface $recurring
     */
    function it_should_schedule_properly($schedulable, $recurring)
    {
        $recurring->getIntervalUnit()->willReturn('days');
        $recurring->getIntervalFrequency()->willReturn(5);

        $date = new \DateTime('+5 days');

        $schedulable->setScheduledDate($date)->shouldBeCalled();

        $this->schedule($schedulable, $recurring);
    }
}
