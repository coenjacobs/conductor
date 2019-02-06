<?php

namespace CoenJacobs\Conductor\Contracts;

use CoenJacobs\Conductor\Handler;

interface Check
{
    public function setup($arguments = []);
    public function check(Handler $handler);
    public function getNoticeClass();
    public function getMessage();
}
