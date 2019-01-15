<?php

namespace App\Libs\Emails;

use \App\Libs\Mailer;

class ConfirmEmail extends Mailer {
  /**
   * Send Email
   */
  public function sendEmail(array $from, array $to, $token, $callback)
  {
    $subject = "Confirm Email in Games Store.";

    $link = "{$callback}?token={$token}";

    $body = "
      <p>To confirm your email, access link:</p>
      <a href='{$link}' target='_blank'>{$link}</a>
    ";

    $altBody = "To confirm your email, access link: {$link}";

    $this->from($from[0], $from[1]);
    $this->addTo($to[0], $to[1]);
    $this->subject($subject);
    $this->body($body);
    $this->altBody($altBody);

    $this->send();
  }
}

