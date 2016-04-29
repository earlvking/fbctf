<?hh

require_once($_SERVER['DOCUMENT_ROOT'] . '/../vendor/autoload.php');

SessionUtils::sessionStart();
SessionUtils::enforceLogin();

class AnnouncementsModuleController {
  public function render(): :xhp {
    $announcements = Announcement::allAnnouncements();
    $announcements_ul = <ul class="activity-stream announcements-list"></ul>;
    if ($announcements) {
      foreach ($announcements as $announcement) {
        $announcements_ul->appendChild(
          <li>
            <span class="announcement-highlight"></span>{$announcement->getAnnouncement()}
          </li>
        );
      }
    }

    return
      <div>
        <header class="module-header">
          <h6>Announcements</h6>
        </header>
        <div class="module-content">
          <div class="fb-section-border">
            <div class="module-top">
            </div>
            <div class="module-scrollable">
              {$announcements_ul}
            </div>
          </div>
        </div>
      </div>;
  }
}

$announcements_generated = new AnnouncementsModuleController();
echo $announcements_generated->render();