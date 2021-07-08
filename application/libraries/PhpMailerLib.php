<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class PhpMailerLib 
{
	function __construct($config = array())
	{
		
	}

	public function load()
    {
        require_once(APPPATH."third_party/phpmailer/vendor/phpmailer/phpmailer/src/Exception.php");
        require_once(APPPATH."third_party/phpmailer/vendor/phpmailer/phpmailer/src/PHPMailer.php");
        require_once(APPPATH."third_party/phpmailer/vendor/phpmailer/phpmailer/src/SMTP.php");
        $objMail = new \PHPMailer\PHPMailer\PHPMailer;
        return $objMail;
    }
}

