<?php

namespace ClickUp\Objects;

/**
 *
 */
class TimeLog extends AbstractObject {
  use TaskFinderTrait;

  /**
   * @var string
   */

  private $id;

  /**
   * @var string
   */

  private $time;

  /**
   * @var string
   */

  private $dateAdded;

  /**
   * @var string
   */

  private $userId;

  /**
   * @var int
   */

  private $teamId;

  /**
   * @var Task
   */

  private $task;

  /**
   * @return int
   */
  public function id() {
    return $this->id;
  }

  /**
   * @return string
   */
  public function time() {
    return $this->time;
  }

  /**
   * @return string
   */
  public function dateAdded() {
    return $this->dateAdded;
  }

  /**
   * @return string
   */
  public function userId() {
    return $this->userId;
  }

  /**
   * @param Task $task
   */
  public function setTask(Task $task) {
    $this->task = $task;
  }

  /**
   * @return Task
   */
  public function task() {
    return $this->task;
  }

  /**
   *
   */
  public function teamId() {
    return $this->teamId;
  }

  /**
   *
   */
  public function setTeamId($teamId) {
    $this->teamId = $teamId;
  }

  /**
   * @return Team
   */
  public function team() {
    if (is_null($this->team)) {
      $this->team = $this->client()->team($this->teamId());
    }
    return $this->team;
  }

  /**
   * @param $array
   * @throws \Exception
   */
  protected function fromArray($array) {
    $this->id = $array['id'];
    $this->userId = $array['user_id'];
    $this->time = $array['time'];
    $this->dateAdded = $array['date_added'];
  }

}
