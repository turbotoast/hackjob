<?php

class HackJob_Utile_Date
{
	public $timestamp;
	
	public function __construct($param = null)
	{
		if(is_int($param))
		{
			return self::fromTimestamp($param);
		}
		elseif(is_string($param))
		{
			return self::fromString($param);
		}
	}
	
	public static function fromTimestamp($timestamp)
	{
		$instance = new self();
		$instance->timestamp = $timestamp;
		return $instance;
	}
	
	public static function fromNow()
	{
		return self::fromTimestamp(time());
	}
	
	public static function fromString($string)
	{
		$instance = new self();
		$instance->timestamp = strtotime($string);
		if(!$instance->timestamp)
		{
			throw new HackJob_Utile_DateException(sprintf(
				'Could not parse date string: %s', $string
			));
		}
		return $instance;
	}
	
	public function toMySQLDate($withTime = false)
	{
		$format = $withTime ? 'Y-m-d H:i:s' : 'Y-m-d';
		return $this->toFormat($format);
	}
	
	public function toGermanDate($withTime = false)
	{
		$format = $withTime ? 'd.m.Y H:i:s' : 'd.m.Y';
		return $this->toFormat($format);
	}
	
	public function toFormat($dateFormat)
	{
		return date($dateFormat, $this->timestamp);
	}
}

?>