<?php

namespace App\Exceptions;

use Exception;

class MyException extends Exception
{
    public function context(){
		return ['exceptionInfo' => 'инфа о исключении'];
	 }

    public function render(){
		return 'My exception fron file "MyException" - исключение сработало';
	 }
}
