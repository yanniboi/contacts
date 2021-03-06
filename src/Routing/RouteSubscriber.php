<?php

namespace Drupal\contacts\Routing;

use Drupal\Core\Routing\RouteSubscriberBase;
use Drupal\Core\Routing\RoutingEvents;
use Symfony\Component\Routing\RouteCollection;

/**
 * Listens to the dynamic route events.
 */
class RouteSubscriber extends RouteSubscriberBase {

  /**
   * {@inheritdoc}
   */
  protected function alterRoutes(RouteCollection $collection) {
    if ($route = $collection->get('page_manager.page_view_contacts_dashboard_contact')) {
      $route->setDefault('subpage', 'summary');
    }
  }

  /**
   * {@inheritdoc}
   */
  public static function getSubscribedEvents() {
    // Run after PageManagerRoutes.
    $events[RoutingEvents::ALTER][] = ['onAlterRoutes', -170];
    return $events;
  }

}
