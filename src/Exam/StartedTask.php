<?php

namespace Exam;

class StartedTask extends Task
{
    public function __construct($title = null, $description = null, $status = Task::STATUS_IN_PROGRESS)
    {
        parent::__construct($title,$description,$status);
    }
}
