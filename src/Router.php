<?hh // strict

class Router {
  public static function route(): string {
    $page = idx(Utils::getGET(), 'p');
    if (!is_string($page)) {
      $page = 'index';
    }
    $ajax = Utils::getGET()->get('ajax') === 'true';

    if ($ajax) {
      return self::routeAjax($page);
    } else {
      return strval(self::routeNormal($page));
    }
  }

  private static function routeAjax(string $page): string {
    switch ($page) {
    case 'index':
      return (new IndexAjaxController())->handleRequest();
    case 'admin':
      return (new AdminAjaxController())->handleRequest();
    case 'game':
      return (new GameAjaxController())->handleRequest();
    default:
      throw new NotFoundRedirectException();
    }
  }

  private static function routeNormal(string $page): :xhp {
    switch ($page) {
    case 'admin':
      return (new AdminController())->render();
    case 'index':
      return (new IndexController())->render();
    case 'game':
      return (new GameboardController())->render();
    case 'view':
      return (new ViewModeController())->render();
    case 'logout':
      // TODO: Make a confirmation modal?
      SessionUtils::sessionStart();
      SessionUtils::sessionLogout();
      invariant(false, 'should not reach here');
    default:
      throw new NotFoundRedirectException();
    }
  }
}
