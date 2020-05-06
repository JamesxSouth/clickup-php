<?php

namespace ClickUp\Objects;

/**
 * @method TaskList   getByKey(int $listId)
 * @method TaskList   getByName(string $listName)
 * @method TaskList[] objects()
 * @method TaskList[] getIterator()
 */
class FolderlessListCollection extends AbstractObjectCollection {

  /**
   *
   */
  public function __construct(Space $space, $array) {
    parent::__construct($space->client(), $array);
    foreach ($this as $taskList) {
      $taskList->setSpace($space);
    }
  }

  /**
   * @return string
   */
  protected function objectClass() {
    return TaskList::class;
  }

}
