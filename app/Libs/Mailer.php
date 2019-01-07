<?php

namespace App\Libs;

use PHPMailer\PHPMailer\PHPMailer;

class Mailer {
  /**
   * PHPMAiler instance
   */
  private $mailer;

  /**
   * Constructor
   */
  public function __construct()
  {
    //Instantiates PHPMailer
    $this->mailer = new PHPMailer(true);                          // Passing `true` enables exceptions

    //Server settings
    $this->mailer->SMTPDebug = 0;                                 // Enable verbose debug output
    $this->mailer->isSMTP();                                      // Set mailer to use SMTP
    $this->mailer->Host = getenv('MAILER_HOST');                  // Specify main and backup SMTP servers
    $this->mailer->SMTPAuth = true;                               // Enable SMTP authentication
    $this->mailer->Username = getenv('MAILER_USERNAME');          // SMTP username
    $this->mailer->Password = getenv('MAILER_PASSWORD');              // SMTP password
    $this->mailer->SMTPSecure = getenv('MAILER_SECURE');          // Enable TLS encryption, `ssl` also accepted
    $this->mailer->Port = getenv('MAILER_PORT');                  // TCP port to connect to

    //Content
    $this->mailer->isHTML(true);                                  // Set email format to HTML
  }

  /**
   * Set FROM
   */
  public function from($email, $name)
  {
    $this->mailer->setFrom($email, $name);
  }

  /**
   * Add TO
   */
  public function addTo($email, $name=null)
  {
    $this->mailer->addAddress($email, $name);
  }

  /**
   * Set SUBJECT
   */
  public function subject($subject)
  {
    $this->mailer->Subject = $subject;
  }

  /**
   * Set HTML BODY
   */
  public function body($body)
  {
    $this->mailer->Body = $body;
  }

  /**
   * Set Non-HTML BODY
   */
  public function altBody($altBody)
  {
    $this->mailer->altBody = $altBody;
  }

  /**
   * Send Emaiil
   */
  public function send()
  {
    $this->mailer->send();
  }

  /**
   * Get Error
   */
  public function getError()
  {
    return $this->mailer->ErrorInfo;
  }
}

