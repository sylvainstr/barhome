<?php

namespace App\MessageHandler;

use App\Message\SendMailMessage;
use App\Service\SendMailService;
use Symfony\Component\Messenger\Handler\MessageHandlerInterface;

final class SendMailMessageHandler implements MessageHandlerInterface
{
  private SendMailService $mail;

  public function __construct(SendMailService $mail)
  {
    $this->mail = $mail;
  }

  public function __invoke(SendMailMessage $message)
  {
    $from = $message->getFrom;
    $to = $message->getTo;
    $subject = $message->getSubject;
    $template = $message->getTemplate;
    $context = $message->getContext;

    $this->mail->send($from, $to, $subject, $template, $context);
  }
}
