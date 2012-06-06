<?php
// This file is a part of the Thrive Framework, a PHPExperts.pro Project.
//
// Copyright (c) 2012 Theodore R.Smith (theodore@phpexperts.pro)
// DSA-1024 Fingerprint: 10A0 6372 9092 85A2 BB7F  907B CB8B 654B E33B F1ED
// Provided by the PHP University (www.phpu.cc) and PHPExperts.pro (www.phpexperts.pro)
//
// This file is dually licensed under the terms of the following licenses:
// * Primary License: OSSAL v1.0 - Open Source Software Alliance License
//   * Key points:
//       5.Redistributions of source code in any non-textual form (i.e.
//          binary or object form, etc.) must not be linked to software that is
//          released with a license that requires disclosure of source code
//          (ex: the GPL).
//       6.Redistributions of source code must be licensed under more than one
//          license and must not have the terms of the OSSAL removed.
//   * See LICENSE.ossal for complete details.
//
// * Secondary License: Creative Commons Attribution License v3.0
//   * Key Points:
//       * You are free:
//           * to copy, distribute, display, and perform the work
//           * to make non-commercial or commercial use of the work in its original form
//       * Under the following conditions:
//           * Attribution. You must give the original author credit. You must retain all
//             Copyright notices and you must include the sentence, "Based upon work from
//             PHPExperts.pro (www.phpexperts.pro).", wherever you list contributors.
//   * See LICENSE.cc_by for complete details.

class Thrive_URL_Downloader
{
	private $headers;

	public function __construct()
	{
		if (!in_array('curl', get_loaded_extensions()))
		{
			throw new Thrive_URL_Exception(Thrive_URL_Exception::MISSING_CURL);
		}
	}

	/**
	 * Determine if a URL is valid.
	 *
	 * @param string $url
	 * @return bool if the URL is a string and is a valid URL. False, otherwise.
	 */
    public static function isURLValid($url)
    {
        return (is_string($url) &&
		    filter_var($url, FILTER_VALIDATE_URL) !== false);
	}

	public static function ensureValidURL($url)
	{
		if (!self::isURLValid($url))
		{
			throw new Thrive_URL_Exception(Thrive_URL_Exception::INVALID_URL, array($url));
		}
	}

	// captureHeader() donated by bendavis78@gmail.com,
	// via http://us.php.net/curl_setopt_array
	private function captureHeader($ch, $header)
	{
		$this->headers[] = $header;
		return strlen($header);
	}

	/**
	 * @param $url string
	 * @throws Thrive_URL_Exception
	 * @return Thrive_Model_URLContent
	 */
	public function fetch($url)
	{
		// Make sure the URL is valid.
		self::ensureValidURL($url);

		$ch = curl_init();
		curl_setopt_array($ch, array(CURLOPT_URL => $url,
				CURLOPT_RETURNTRANSFER => 1,
				CURLOPT_HEADERFUNCTION => array($this, 'captureHeader'),
				CURLOPT_TIMEOUT => 30,
			)
		);

		$data = curl_exec($ch);
		curl_close($ch);

		if ($data === false || is_null($data) || $data == '')
		{
			throw new Thrive_URL_Exception(Thrive_URL_Exception::BLANK_URL, array($url));
		}

		// TODO: Need to handle HTTP error messages, such as 404 and 502.

		$urlContent = new Thrive_Model_URLContent;
		$urlContent->url = $url;
		$urlContent->headers = $this->headers;
		$urlContent->content = $data;

		return $urlContent;
	}
}
