<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace Tkuska\DashboardBundle;

/**
 * Description of WidgetProvider.
 *
 * @author Tomasz Kuśka <tomasz.kuska@gmail.com>
 */
class WidgetProvider
{
    /**
     * @var \Doctrine\ORM\EntityManager
     */
    protected $em;

    /**
     * @var \Symfony\Component\Security\Core\Authentication\Token\Storage\TokenStorage
     */
    protected $security;

    /**
     *
     * @var \Doctrine\Common\Collections\ArrayCollection
     */
    protected $widgetTypes;
    
    /**
     * 
     * @param \Doctrine\ORM\EntityManager $em
     * @param \Symfony\Component\Security\Core\Authentication\Token\Storage\TokenStorage $security
     */
    public function __construct(\Doctrine\ORM\EntityManager $em, \Symfony\Component\Security\Core\Authentication\Token\Storage\TokenStorage $security)
    {
        $this->em = $em;
        $this->security = $security;
        $this->widgetTypes = new \Doctrine\Common\Collections\ArrayCollection();
    }

    /**
     * 
     * @param Widget\WidgetTypeInterface $widget
     * @param string $alias
     * @return \Tkuska\DashboardBundle\WidgetProvider
     */
    public function addWidgetType(Widget\WidgetTypeInterface $widget, $alias)
    {
        $this->widgetTypes->set($alias, $widget);

        return $this;
    }

    /**
     * 
     * @return \Doctrine\Common\Collections\ArrayCollection
     */
    public function getWidgetTypes()
    {
        return $this->widgetTypes;
    }

    /**
     * 
     * @param string $alias
     * @return Widget\WidgetTypeInterface
     */
    public function getWidgetType($alias)
    {
        return $this->widgetTypes->get($alias);
    }

    /**
     * Returns collection of logged user widgets
     */
    public function getMyWidgets()
    {
        $myWidgets = $this->em->getRepository('TkuskaDashboardBundle:Widget')
                ->getMyWidgets($this->security->getToken()->getUser())
                ->getQuery()
                ->getResult();
        $return = array();
        foreach ($myWidgets as $widget) {
            $widgetType = $this->getWidgetType($widget->getType());
            $widgetType->setParams($widget);
            $return[] = $widgetType;
        }
        return $return;
    }
}
