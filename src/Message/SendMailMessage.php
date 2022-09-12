<?php

namespace App\Message;

final class SendMailMessage
{
  private $from;
  private $to;
  private $subject;
  private $template;
  private $context;

  public function __construct(string $from, string $to, string $subject, string $template, array $context)
  {
    $this->from = $from;
    $this->to = $to;
    $this->subject = $subject;
    $this->template = $template;
    $this->context = $context;
  }

  /**
   * Get the value of from
   */
  public function getFrom(): string
  {
    return $this->from;
  }

  /**
   * Get the value of to
   */
  public function getTo(): string
  {
    return $this->to;
  }

  /**
   * Get the value of subject
   */
  public function getSubject(): string
  {
    return $this->subject;
  }

  /**
   * Get the value of template
   */
  public function getTemplate(): string
  {
    return $this->template;
  }

  /**
   * Get the value of context
   */
  public function getContext(): array
  {
    return $this->context;
  }
}
