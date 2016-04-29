<?hh

require_once($_SERVER['DOCUMENT_ROOT'] . '/../vendor/autoload.php');

SessionUtils::sessionStart();
SessionUtils::enforceLogin();

class TeamModuleController {
  public function render(): :xhp {
    $leaderboard = Team::leaderboard();
    $rank = 1;

    $list = <ul class="grid-list"></ul>;

    if (Configuration::get('gameboard')->getValue() === '1') {
      foreach ($leaderboard as $leader) {
        $iconbadge = '#icon--badge-' . $leader->getLogo();
        $list->appendChild(
          <li>
            <a href="#" data-team={$leader->getName()}>
              <svg class="icon--badge">
                <use href={$iconbadge}/>

              </svg>
            </a>
          </li>
        );
      }
    }

    return
      <div>
        <header class="module-header">
          <h6>Teams</h6>
        </header>
        <div class="module-content">
          <div class="fb-section-border">
            <!-- Removing the option for people to select their own team for now -->
            <!-- <div class="module-top">
              <div class="radio-tabs">
                <input type="radio" name="fb--module--teams" id="fb--module--teams--all" checked={true}/>
                <label for="fb--module--teams--all" class="click-effect"><span>Everyone</span></label>
                <input type="radio" name="fb--module--teams" id="fb--module--teams--your-team"/>
                <label for="fb--module--teams--your-team" class="click-effect"><span>Your Team</span></label>
              </div>
            </div> -->
            <div class="module-scrollable">
              {$list}
            </div>
          </div>
        </div>
      </div>;
  }
}

$teams_generated = new TeamModuleController();
echo $teams_generated->render();
