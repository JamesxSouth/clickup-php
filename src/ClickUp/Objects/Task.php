<?php

namespace ClickUp\Objects;

/**
 *
 */
class Task extends AbstractObject {
  use TaskFinderTrait;

  /**
   * @var string
   */

  private $id;

  /**
   * @var string
   */

  private $name;

  /**
   * @var string
   */

  private $description;

  /**
   * @var Status
   */

  private $status;

  /**
   * @var string
   */

  private $orderindex;

  /**
   * @var \DateTimeImmutable
   */

  private $dateCreated;

  /**
   * @var \DateTimeImmutable
   */

  private $dateUpdated;

  /**
   * @var TeamMember
   */

  private $creator;

  /**
   * @var TeamMemberCollection
   */

  private $assignees;

  /**
   * @var array
   */

  private $tags;

  /**
   * @var string|null
   */

  private $parentTaskId;

  /**
   * @var Task|null
   */

  private $parentTask = NULL;

  /**
   * @var int
   */

  private $priority;

  /**
   * @var \DateTimeImmutable
   */

  private $dueDate;

  /**
   * @var \DateTimeImmutable
   */

  private $startDate;

  /**
   * @var int
   */

  private $points;

  /**
   * @var string
   */

  private $timeEstimate;

  /**
   * @var int
   */

  private $taskListId;

  /**
   * @var TaskList|null
   */

  private $taskList = NULL;

  /**
   * @var int
   */

  private $projectId;

  /**
   * @var Project|null
   */

  private $project = NULL;

  /**
   * @var int
   */

  private $spaceId;

  /**
   * @var Space|null
   */

  private $space = NULL;

  /**
   * @var int
   */

  private $teamId;

  /**
   * @var Team|null
   */

  private $team = NULL;

  /**
   * @var string
   */

  private $url;

  /**
   * @var TimeLogCollection
   */

  private $timeLogs;

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
   *
   */
  public function description() {
    return $this->description;
  }

  /**
   *
   */
  public function status() {
    return $this->status;
  }

  /**
   *
   */
  public function orderindex() {
    return $this->orderindex;
  }

  /**
   *
   */
  public function dateCreated() {
    return $this->dateCreated;
  }

  /**
   *
   */
  public function dateUpdated() {
    return $this->dateUpdated;
  }

  /**
   *
   */
  public function creator() {
    return $this->creator;
  }

  /**
   *
   */
  public function assignees() {
    return $this->assignees;
  }

  /**
   *
   */
  public function tags() {
    return $this->tags;
  }

  /**
   *
   */
  public function parentTaskId() {
    return $this->parentTaskId;
  }

  /**
   *
   */
  public function isSubTask() {
    return !is_null($this->parentTaskId());
  }

  /**
   * @return Task|null
   */
  public function parentTask() {
    if (is_null($this->parentTaskId())) {
      return NULL;
    }
    if (is_null($this->parentTask)) {
      $this->parentTask = $this
        ->tasks()
        ->getByTaskId($this->parentTaskId());
    }
    return $this->parentTask;
  }

  /**
   *
   */
  public function priority() {
    return $this->priority;
  }

  /**
   *
   */
  public function dueDate() {
    return $this->dueDate;
  }

  /**
   *
   */
  public function startDate() {
    return $this->startDate;
  }

  /**
   *
   */
  public function points() {
    return $this->points;
  }

  /**
   *
   */
  public function timeEstimate() {
    return $this->timeEstimate;
  }

  /**
   *
   */
  public function taskListId() {
    return $this->taskListId;
  }

  /**
   * @return TaskList
   */
  public function taskList() {
    if (is_null($this->taskList)) {
      $this->taskList = $this->project()->taskList($this->taskListId());
    }
    return $this->taskList;
  }

  /**
   *
   */
  public function projectId() {
    return $this->projectId;
  }

  /**
   * @return Project
   */
  public function project() {
    if (is_null($this->project)) {
      $this->project = $this->space()->project($this->projectId());
    }
    return $this->project;
  }

  /**
   * @return int
   */
  public function spaceId() {
    return $this->spaceId;
  }

  /**
   * @return Space
   */
  public function space() {
    if (is_null($this->space)) {
      $this->space = $this->team()->space($this->spaceId());
    }
    return $this->space;
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
   * @see https://jsapi.apiary.io/apis/clickup/reference/0/task/edit-task.html
   * @param array $body
   * @return array
   */
  public function edit($body) {
    return $this->client()->put(
    "task/{$this->id()}",
    $body
    );
  }

  /**
   * @return TimeLogCollection
   */
  public function timeLogs() {
    if (is_null($this->timeLogs)) {
      $this->timeLogs = new TimeLogCollection(
      $this,
      $this->client()->get("task/{$this->id()}/time")['data']
      );
    }
    return $this->timeLogs;
  }

  /**
   * @param $array
   * @throws \Exception
   */
  protected function fromArray($array) {
    $this->id = $array['id'];
    $this->name = $array['name'];
    $this->description = (string) $array['text_content'];
    $this->status = new Status(
    $this->client(),
    $array['status']
    );
    $this->orderindex = $array['orderindex'];
    $this->dateCreated = $this->getDate($array, 'date_created');
    $this->dateUpdated = $this->getDate($array, 'date_updated');
    $this->creator = new User(
    $this->client(),
    $array['creator']
    );
    $this->assignees = new UserCollection(
    $this->client(),
    $array['assignees']
    );

    // TODO TagCollection.
    $this->tags = $array['tags'];
    $this->parentTaskId = $array['parent'];
    $this->priority = $array['priority'];
    $this->dueDate = $this->getDate($array, 'due_date');
    $this->startDate = $this->getDate($array, 'start_date');
    $this->points = isset($array['point']) ? $array['point'] : NULL;
    $this->timeEstimate = isset($array['time_estimate']) ? $array['time_estimate'] : NULL;
    $this->taskListId = $array['list']['id'];
    $this->projectId = $array['project']['id'];
    $this->spaceId = $array['space']['id'];
    $this->url = $array['url'];
  }

  /**
   * @param $array
   * @param $key
   * @return \DateTimeImmutable|null
   * @throws \Exception
   */
  private function getDate($array, $key) {
    if (!isset($array[$key])) {
      return NULL;
    }
    $unixTime = substr($array[$key], 0, 10);
    return new \DateTimeImmutable("@$unixTime");
  }

}
