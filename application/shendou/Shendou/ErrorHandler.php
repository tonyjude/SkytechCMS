<?php
class Shendou_ErrorHandler implements Lamb_App_ErrorHandler_Interface
{
	public function handle(Exception $e)
	{
		echo $e->getMessage();
	}
}