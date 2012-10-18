<?php
class SignatureHMACSHA1 extends SignatureMethod
{
	public function getName()
	{
		return 'HMAC-SHA1';
	}

	public function sign($tcMethod, $tcURL, $toParameters, $tcSecret, $tcTokenSecret = '')
	{
		$lcBase = strtoupper($tcMethod).'&'.urlencode($tcURL).'&';
		$lcParameter = '';
		$loParameters = array();

		foreach ($toParameters as $lcKey => $lcValue) 
		{
			$loParameters[$this->urlencode($lcKey)] = $this->urlencode($lcValue);
		}
		ksort($loParameters);

		foreach ($loParameters as $lcKey => $lcValue) 
		{
			$lcParameter.=$lcKey.'='.$lcValue.'&';
		}
		$lcParameter = urlencode(substr($lcParameter, 0, strlen($lcParameter)-1));

		$loParameters['oauth_signature']=urlencode(base64_encode(hash_hmac('sha1', $lcBase.$lcParameter, $tcSecret.'&'.$tcTokenSecret, true)));

		ksort($loParameters);
		return $loParameters;
	}
}
?>