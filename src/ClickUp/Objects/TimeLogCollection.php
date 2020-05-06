<?php

namespace ClickUp\Objects;

/**
 * @method TimeLog   getByKey(int $listId)
 * @method TimeLog   getByName(string $listName)
 * @method TimeLog[] objects()
 * @method TimeLog[] getIterator()
 */
class TimeLogCollection extends AbstractObjectCollection {

  /**
   *
   */
  public function __construct(Task $task, $array) {
    $formattedArray = [];

    if (is_array($array)) {
      foreach ($array as $item) {
        if (isset($item['user']['id']) && isset($item['intervals']) && is_array($item['intervals'])) {
          foreach ($item['intervals'] as $interval) {
            $formattedArray[] = [
              'id' => $interval['id'],
              'user_id' => $item['user']['id'],
              'time' => $interval['time'],
              'date_added' => $interval['date_added'],
            ];
          }
        }
      }
    }

    parent::__construct($task->client(), $formattedArray);
    foreach ($this as $timeLog) {
      $timeLog->setTask($task);
    }
  }

  /**
   * @return string
   */
  protected function objectClass() {
    return TimeLog::class;
  }

}
