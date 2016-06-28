<?php

namespace Exam;

class ClosedTask extends Task
{
    use Reopen;

    public function __construct($title = null, $description =null, $status = Task::STATUS_CLOSED)
    {
        parent::__construct($title, $description,$status);
    }

    public function reOpen(){
        $this->setStatus(Task::STATUS_OPEN);
    }
}
