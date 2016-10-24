<?php

class Thrive_Model_URLContent
{
	public $url;
	public $headers;
	/** @var Thrive_Model_URLInfo */
	public $info;
	public $content;
}

class Thrive_Model_URLInfo
{
	public $httpCode;
	public $effectiveURL;
	public $contentType;
	public $size;
	public $transferTime;
}
