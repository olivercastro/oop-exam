<?php

namespace Exam;

class CompletedTask extends Task
{

    use Reopen;

    public function __construct($title = null, $description = null, $status = Task::STATUS_COMPLETED)
    {
        parent::__construct($title, $description, $status);
    }

    public function reOpen(){
        $this->setStatus(Task::STATUS_OPEN);
    }
}
