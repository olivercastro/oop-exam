<?php

require_once __DIR__ . '/autoload.php';

use Exam\ClosedTask;
use Exam\CompletedTask;
use Exam\StartedTask;
use Exam\StatusException;
use Exam\Task;

class MainTest extends PHPUnit_Framework_TestCase
{
    
    public function testTaskTitleOnly()
    {
        $task = new Task('testing');
        $this->assertEquals('testing (open)', (string) $task);
        $this->assertTrue($task->isOpen());
        $this->assertFalse($task->isStarted() || $task->isCompleted() || $task->isClosed());
    }

    public function testTaskTitleAndDescription()
    {
        $task = new Task('testing', 'testing');
        $this->assertEquals('testing - testing (open)', (string) $task);
        $this->assertTrue($task->isOpen());
        $this->assertFalse($task->isStarted() || $task->isCompleted() || $task->isClosed());
    }

    public static function allStatus()
    {
        return array(
            Task::STATUS_OPEN,
            Task::STATUS_CLOSED,
            Task::STATUS_COMPLETED,
            Task::STATUS_IN_PROGRESS,
        );
    }

    /**
     * @dataProvider allStatus
     */
    public function testTaskTitleAndDescriptionAndStatus($status)
    {
        $task = new Task('testing', 'testing', $status);
        $this->assertEquals(sprintf('testing - testing (%s)', $status), (string) $task);
    }
    
    public function testFluidTask()
    {
        $task = new Task('testing');
        $task->setTitle('tested')
                ->setDescription('testing')
                ->close();
        $this->assertEquals('tested - testing (closed)', (string) $task);
        $this->assertTrue($task->isClosed());
        $this->assertFalse($task->isOpen() || $task->isStarted() || $task->isCompleted());
    }

    public function testTaskWithInvalidStatus()
    {
        $failMessage = 'Task should throw exception if given invalid status.';
        try {
            new Task('testing', 'testing', 'testing');
            $this->fail($failMessage);
        } catch (StatusException $e) {
            $this->assertEquals('Invalid status provided: testing', $e->getMessage());
        }
        
        $task = new Task('testing');
        try {
            $task->setStatus('testing');
            $this->fail($failMessage);
        } catch (StatusException $e) {
            $this->assertEquals('Invalid status provided: testing', $e->getMessage());
        }
    }
    
    public function testTaskSameStatus()
    {
        $task = new Task('testing');
        try {
            $task->setStatus(Task::STATUS_OPEN);
            $this->fail('Task should throw exception if given the same status.');
        } catch (StatusException $e) {
            $this->assertEquals('"testing" is already "open"', $e->getMessage());
        }
    }
    
    public function testCloseOpenTask()
    {
        $task = new Task('testing');
        $task->close();
        $this->assertEquals('testing (closed)', (string) $task);
        $this->assertTrue($task->isClosed());
        $this->assertFalse($task->isOpen() || $task->isStarted() || $task->isCompleted());
    }
    
    public function testStartCompleteCloseTask()
    {
        $task = new Task('testing');
        $task->start();
        $this->assertEquals('testing (in progress)', (string) $task);
        $task->complete();
        $this->assertEquals('testing (completed)', (string) $task);
        $task->close();
        $this->assertEquals('testing (closed)', (string) $task);
    }
    
    public function testCompleteOpenTask()
    {
        $task = new Task('testing');
        try {
            $task->complete();
        } catch (StatusException $e) {
            $this->assertEquals('Incorrect workflow detected: open to completed', $e->getMessage());
        }
    }
    
    public function testCompleteCloseStartedTask()
    {
        $task = new StartedTask('testing');
        $task->complete();
        $this->assertEquals('testing (completed)', (string) $task);
        $task->close();
        $this->assertEquals('testing (closed)', (string) $task);
    }
    
    public function testStartStartedTask()
    {
        $task = new StartedTask('testing');
        try {
            $task->start();
        } catch (StatusException $e) {
            $this->assertEquals('"testing" is already "in progress"', $e->getMessage());
        }
    }
    
    public function testReopenCompletedTask()
    {
        $task = new CompletedTask('testing');
        $task->reOpen();
        $this->assertEquals('testing (open)', (string) $task);
    }
    
    public function testCloseCompletedTask()
    {
        $task = new CompletedTask('testing');
        $task->close();
        $this->assertEquals('testing (closed)', (string) $task);
    }
    
    public function testStartCompletedTask()
    {
        $task = new CompletedTask('testing');
        try {
            $task->start();
        } catch (StatusException $e) {
            $this->assertEquals('Incorrect workflow detected: completed to in progress', $e->getMessage());
        }
    }
    
    public function testCompleteCompletedTask()
    {
        $task = new CompletedTask('testing');
        try {
            $task->complete();
        } catch (StatusException $e) {
            $this->assertEquals('"testing" is already "completed"', $e->getMessage());
        }
    }
    
    public function testReopenClosedTask()
    {
        $task = new ClosedTask('testing');
        $task->reOpen();
        $this->assertEquals('testing (open)', (string) $task);
    }
    
    public function testStartClosedTask()
    {
        $task = new ClosedTask('testing');
        try {
            $task->start();
        } catch (StatusException $e) {
            $this->assertEquals('Incorrect workflow detected: closed to in progress', $e->getMessage());
        }
    }
    
    public function testCompleteClosedTask()
    {
        $task = new ClosedTask('testing');
        try {
            $task->complete();
        } catch (StatusException $e) {
            $this->assertEquals('Incorrect workflow detected: closed to completed', $e->getMessage());
        }
    }
    
    public function testCloseClosedTask()
    {
        $task = new ClosedTask('testing');
        try {
            $task->close();
        } catch (StatusException $e) {
            $this->assertEquals('"testing" is already "closed"', $e->getMessage());
        }
    }

    public static function tasks()
    {
        return array(
            array(new Task('test'), 'test (open)'),
            array(new Task('test', 'test'), 'test - test (open)'),
            array(new Task('test', null, Task::STATUS_CLOSED), 'test (closed)'),
            array(new StartedTask('test'), 'test (in progress)'),
            array(new CompletedTask('test'), 'test (completed)'),
            array(new ClosedTask('test'), 'test (closed)'),
            array(new DummyTask(), 'Exam\Dummy\Task: dummy title - dummy description (dummy status)'),
        );
    }

    /**
     * @dataProvider tasks
     */
    public function testPrintTask($task, $expected)
    {
        $this->assertEquals($expected, (string) $task);
    }
    
    public function testCloseReopenCompletedTask()
    {
        $task = new CompletedTask('testing');
        $task->close()->reOpen();
        $this->assertEquals('testing (open)', (string) $task);
    }

    public function testDummyTask()
    {
        $task = new DummyTask();
        $expected = 'Exam\Dummy\Task: dummy title - dummy description (dummy status)';
        $this->assertEquals($expected, (string) $task);
    }
    
}
