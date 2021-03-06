<?php

namespace Tkuska\DashboardBundle\Entity\Repository;

use Doctrine\ORM\EntityRepository;

/**
 * WidgetRepository.
 *
 * This class was generated by the Doctrine ORM. Add your own custom
 * repository methods below.
 */
class WidgetRepository extends EntityRepository
{
    /**
     * Gets all widgets connected with user user account
     * @param \Symfony\Component\Security\Core\User\UserInterface $user
     * @return \Doctrine\ORM\QueryBuilder
     */
    public function getMyWidgets(\Symfony\Component\Security\Core\User\UserInterface $user)
    {
        $userId = method_exists($user, 'getId') ? $user->getId() : 0;
        return $this->getEntityManager()
            ->createQueryBuilder()
            ->select('w')
            ->from('TkuskaDashboardBundle:Widget', 'w')
            ->where('w.user_id = :user_id')
            ->setParameter('user_id', $userId);
    }
    
    /**
     * Gets specific user widget
     * @param \Symfony\Component\Security\Core\User\UserInterface $user
     * @param string $alias widget alias
     * @return \Doctrine\ORM\QueryBuilder
     */
    public function getUserWidget(\Symfony\Component\Security\Core\User\UserInterface $user, $alias)
    {
        $userId = method_exists($user, 'getId') ? $user->getId() : 0;
        return $this->getEntityManager()
            ->createQueryBuilder()
            ->select('w')
            ->from('TkuskaDashboardBundle:Widget', 'w')
            ->where('w.user_id = :user_id')
            ->andWhere('w.type = :alias')
            ->setParameter('alias', $alias)
            ->setParameter('user_id', $userId);
    }
}
