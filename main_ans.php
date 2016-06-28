<?php
/**
 * Created by PhpStorm.
 * User: olivercastro
 * Date: 28/06/2016
 * Time: 3:37 PM
 */
require_once __DIR__ . '/autoload.php';

use Exam\Task;
use Exam\Dummy\Task as DTask;
use Exam\TaskInterface;

$_dummyTask = new DTask();


echo 'Dummy Task' ."\n";
var_dump($_dummyTask);
echo "\n";

$taskWithTitle = new Task('hello');

var_dump($taskWithTitle);

$taskWithTitleDesc = new Task('hello','description');

var_dump($taskWithTitleDesc);

$taskWithTitleDesStatus = new Task('hello','description',Task::STATUS_OPEN);

//var_dump($taskWithTitleDesStatus);

//$task4 = new Task('testing','testing','testing');

$task5 = new Task('testing');
var_dump($task5);
$task5->close();
var_dump($task5);