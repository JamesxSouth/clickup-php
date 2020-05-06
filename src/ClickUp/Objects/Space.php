<?php

namespace ClickUp\Objects;

/**
 *
 */
class Space extends AbstractObject {
  use TaskFinderTrait;

  /**
   * @var int
   */

  private $id;

  /**
   * @var string
   */

  private $name;

  /**
   * @var bool
   */

  private $isPrivate;

  /**
   * @var StatusCollection
   */

  private $statuses;

  /**
   * @var array
   */

  private $clickApps;

  /**
   * @var int|null
   */

  private $teamId;

  /**
   * @var Team
   */

  private $team;

  /**
   * @var ProjectCollection|null
   */

  private $projects = NULL;

  /**
   * @return int
   */
  public function id() {
    return $this->id;
  }

  /**
   * @return string
   */
  public function name() {
    return $this->name;
  }

  /**
   * @return bool
   */
  public function isPrivate() {
    return $this->isPrivate;
  }

  /**
   * @return StatusCollection
   */
  public function statuses() {
    return $this->statuses;
  }

  /**
   * @return array
   */
  public function clickApps() {
    return $this->clickApps;
  }

  /**
   * @return ProjectCollection
   */
  public function projects() {
    if (is_null($this->projects)) {
      $this->projects = new ProjectCollection(
      $this,
      $this->client()->get("space/{$this->id()}/folder")['folders']
      );
    }
    return $this->projects;
  }

  /**
   * @param $projectId
   * @return Project
   */
  public function project($projectId) {
    return $this->projects()->getByKey($projectId);
  }

  /**
   * Access parent class.
   *
   * @return Team
   */
  public function team() {
    return $this->team;
  }

  /**
   * @param Team $team
   */
  public function setTeam(Team $team) {
    $this->team = $team;
  }

  /**
   * @return int
   */
  public function teamId() {
    return $this->team()->id();
  }

  /**
   * @return array
   */
  protected function taskFindParams() {
    return ['space_ids' => [$this->id()]];
  }

  /**
   * @param array $array
   */
  protected function fromArray($array) {
    $this->id = $array['id'];
    $this->name = $array['name'];
    $this->isPrivate = $array['private'];
    $this->statuses = new StatusCollection(
    $this->client(),
    $array['statuses']
    );
    $this->clickApps = [
      'multiple_assignees' => isset($array['multiple_assignees']) ? $array['multiple_assignees'] : FALSE,
      'due_dates' => isset($array['features']['due_dates']['enabled']) ? $array['features']['due_dates']['enabled'] : FALSE,
      'time_tracking' => isset($array['features']['time_tracking']['enabled']) ? $array['features']['time_tracking']['enabled'] : FALSE,
      'priorities' => isset($array['features']['priorities']['enabled']) ? $array['features']['priorities']['enabled'] : FALSE,
      'tags' => isset($array['features']['tags']['enabled']) ? $array['features']['tags']['enabled'] : FALSE,
      'time_estimates' => isset($array['features']['time_estimates']['enabled']) ? $array['features']['time_estimates']['enabled'] : FALSE,
      'check_unresolved' => isset($array['features']['check_unresolved']['enabled']) ? $array['features']['check_unresolved']['enabled'] : FALSE,
      'custom_fields' => isset($array['features']['custom_fields']['enabled']) ? $array['features']['custom_fields']['enabled'] : FALSE,
      'remap_dependencies' => isset($array['features']['remap_dependencies']['enabled']) ? $array['features']['remap_dependencies']['enabled'] : FALSE,
      'dependency_warning' => isset($array['features']['dependency_warning']['enabled']) ? $array['features']['dependency_warning']['enabled'] : FALSE,
    ];
  }

}
