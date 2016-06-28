<?php

namespace Exam;

interface TaskInterface
{

    const STATUS_OPEN = 'open',
            STATUS_IN_PROGRESS = 'in progress',
            STATUS_COMPLETED = 'completed',
            STATUS_CLOSED = 'closed';

    public function getTitle();

    public function getDescription();

    public function getStatus();

    public function isOpen();

    public function isStarted();

    public function isCompleted();

    public function isClosed();
}
