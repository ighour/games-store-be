<?php

namespace App\Libs\Emails;

use \App\Libs\Mailer;

class RecoverPassword extends Mailer {
  /**
   * Send Email
   */
  public function sendEmail(array $from, array $to, $token, $callback)
  {
    $subject = "Recover Password in Games Store.";

    $link = "{$callback}?token={$token}";

    $body = "
      <p>To recover your password, access link:</p>
      <a href='{$link}' target='_blank'>{$link}</a>
    ";

    $altBody = "To recover your password, access link: {$link}";

    $this->from($from[0], $from[1]);
    $this->addTo($to[0], $to[1]);
    $this->subject($subject);
    $this->body($body);
    $this->altBody($altBody);

    $this->send();
  }
}

