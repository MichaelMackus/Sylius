<?php

/*
 * This file is part of the Sylius package.
 *
 * (c) Paweł Jędrzejewski
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Sylius\Bundle\CoreBundle\DataFixtures\ORM;

use Doctrine\Common\Persistence\ObjectManager;

/**
 * Sample subscription data
 *
 * @author Daniel Richter <nexyz9@gmail.com>
 */
class LoadSubscriptionsData extends DataFixture
{
    /**
     * Load data fixtures with the passed EntityManager
     *
     * @param ObjectManager $manager
     */
    function load(ObjectManager $manager)
    {
        $numUsers = 15;

        for ($i = 0;$i <= $numUsers;$i++) {

            $user = $this->getReference(($i == 0) ? 'User-Administrator' : 'Sylius.User-'.$i);

            $numSubscriptions = rand(1, 5);

            for ($s = 0;$s < $numSubscriptions;$s++) {
                $subscription = $this->createSubscription($user);
                $manager->persist($subscription);
            }
        }

        $manager->flush();
    }

    public function createSubscription($user)
    {
        $subscription = $this->getSubscriptionRepository()->createNew();
        $itemRepository = $this->getSubscriptionItemRepository();

        $subscription
            ->setUser($user)
            ->setScheduledDate($this->faker->dateTimeBetween('now', '+1 month'))
            ->setProcessedDate($this->faker->dateTimeBetween('now', '+1 month'))
            ->setIntervalUnit('days')
            ->setIntervalFrequency($this->faker->randomElement(array(15, 30, 60, 90)))
            ->setMaxCycles($this->faker->randomElement(array(null, rand(1, 12))))
        ;

        for ($j = 1;$j < rand(1, 5);$j++) {
            $item = $itemRepository->createNew();
            $variant = $this->getReference('Sylius.Variant-'.rand(1, SYLIUS_FIXTURES_TOTAL_VARIANTS));

            $item
                ->setVariant($variant)
                ->setQuantity(rand(1, 5))
            ;

            $subscription->addItem($item);
        }

        return $subscription;
    }

    /**
     * Get the order of this fixture
     *
     * @return integer
     */
    function getOrder()
    {
        return 7;
    }
}