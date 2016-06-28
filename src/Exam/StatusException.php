<?php

namespace Exam;

class StatusException extends \Exception
{

    const ERR_INVALID_STATUS = 'invalid_status',
            ERR_SAME_STATUS = 'same_status',
            ERR_INVALID_WORKFLOW = 'invalid_workflow';

}
