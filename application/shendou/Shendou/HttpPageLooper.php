<?php
class Shendou_HttpPageLooper extends Lamb_Looper_SqlPageStep
{
	const TASK_BEGIN = 1;
	
	const TASK_END = 2;
	
	const PER_TASK_BEGIN = 4;
	
	const PER_TASK_END = 8;
	
	/**
	 * @var int
	 */
	protected $mSleepSecond = 1;
	
	/**
	 * @var string
	 */
	protected $mUrlPrefix = '';
	
	/** 
	 * @var PHP callback
	 */
	protected $mMsgHandler = null;
	
	/**
	 * @param int $pagesize
	 */
	public function __construct($pagesize)
	{
		parent::__construct($pagesize);
	}
	
	/**
	 * @param int $time
	 * @return int | Ttkvod_HttpPageLooper
	 */
	public function setOrGetSleepSecond($time = null)
	{
		if (null === $time) {
			return $this->mSleepSecond;
		}
		$this->mSleepSecond = (int)$time;
		return $this;
	}
	
	/**
	 * @param string $prefix 
	 * @return string | Ttkvod_HttpPageLooper
	 */
	public function setOrGetUrlPrefix($prefix = null)
	{
		if (null === $prefix) {
			return $this->mUrlPrefix;
		}
		$this->mUrlPrefix = (string)$prefix;
		return $this;
	}
	
	/** 
	 * @param PHP callback $handler 0 - default
	 * @Ttkvod_HttpPageLooper
	 */
	public function setMsgHandler($handler = 0)
	{
		if (0 === $handler) {
			$handler = __CLASS__ . '::defaultHandler';
		}
		if (null !== $handler && is_callable($handler)) {
			$this->mMsgHandler = $handler;
		}
		return $this;
	}
	
	/**
	 * @return PHP callback
	 */
	public function getMsgHandler()
	{
		return $this->mMsgHandler;
	}
	
	/**
	 * @override
	 */
	public function run()
	{
		$pages = $this->getCount();
		$page = $this->setOrGetCurrentPage();
		if ($page > $pages) {
			return false;
		}
		$handler = $this->getMsgHandler();
		if ($handler) {
			call_user_func($handler, self::PER_TASK_BEGIN, $this);
		}
		
		$this->setOrGetCurrentPage($page);
		parent::run();
		
		if ($handler) {
			if ($page >= $pages) {
				call_user_func($handler, self::TASK_END, $this);
			} else {
				call_user_func($handler, self::PER_TASK_END, $this);
			}
		}
	}
	
	public static function defaultHandler($taskFlag, Ttkvod_HttpPageLooper $looper)
	{

	}
}