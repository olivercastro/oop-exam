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

        if(is_null($status)){
            $this->status = Task::STATUS_OPEN;
        }else{
            if(!in_array($status, array(Task::STATUS_CLOSED, Task::STATUS_COMPLETED, Task::STATUS_OPEN, Task::STATUS_IN_PROGRESS))){
                throw new \Exception(StatusException::ERR_INVALID_STATUS);
            }
            $this->status = $status;
        }

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
    public function setStatus($status){
        if($status == $this->status)
            throw new \Exception(StatusException::ERR_SAME_STATUS);
        $this->status = $status;
        return $this;
    }
    public function close(){
        if($this->isCompleted() || $this->isOpen()){
            $this->status = Task::STATUS_CLOSED;
        }
        if($this->isClosed()){
            throw new \Exception($this->title . ' is already closed');
        }
    }

    public function start(){
        if($this->status == Task::STATUS_IN_PROGRESS){
            throw new \Exception('"' . $this->title . '" is already "in progress"');
        }
        if($this->status == Task::STATUS_COMPLETED){
            throw new \Exception(StatusException::ERR_INVALID_WORKFLOW);
        }
        if($this->status == Task::STATUS_CLOSED){
            throw new \Exception(StatusException::ERR_INVALID_WORKFLOW);
        }
        $this->status = Task::STATUS_IN_PROGRESS;
    }

    public function complete(){
        if($this->status == Task::STATUS_OPEN){
            throw new \Exception(StatusException::ERR_INVALID_WORKFLOW);
        }
        if($this->status == Task::STATUS_CLOSED){
            throw new \Exception(StatusException::ERR_INVALID_WORKFLOW);
        }
        if($this->status == Task::STATUS_COMPLETED){
            throw new \Exception($this->title . ' is already completed');
        }
        $this->status = Task::STATUS_COMPLETED;
    }
}
