<?php

namespace Exam;

class Task implements TaskInterface
{

    private $title;
    private $description;
    private $status;
    
    public  function __construct($title = null, $description = null, $status= null)
    {
        $this->title = $title;
        $this->description = $description;
        if()
        $this->status = $status;
    }

    public function getDescription()
    {
        return $this->description;
    }

    public function getStatus()
    {
        return $this->status;
    }

    public function getTitle()
    {
        return $this->title;
    }

    public function isClosed()
    {
        return $this->status == Task::STATUS_CLOSED;
    }

    public function isCompleted()
    {
        return $this->status == Task::STATUS_COMPLETED;
    }

    public function isOpen()
    {
        return $this->status == Task::STATUS_OPEN;
    }

    public function isStarted()
    {
        return $this->status == Task::STATUS_IN_PROGRESS;
    }

    public function setTitle($title){
        $this->title = $title;
        return $this;
    }
    public function setDescription($desc){
        $this->description = $desc;
        return $this;
    }

    public function close(){
        if($this->isCompleted()){
            $this->status = Task::STATUS_CLOSED;
        }
    }
}
