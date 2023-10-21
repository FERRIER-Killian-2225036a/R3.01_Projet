<?php

class mailSender
{
    private $to;
    private $subject;
    private $message;
    private $headers;
    private $status;

    public function __construct($to, $subject, $message)
    {
        $this->to = $to;
        $this->subject = $subject;
        $this->message = $message;
        $this->message.= "\n\nPour retourner sur le site direction : https://cyphub.tech";
        $this->headers = "From: ".Constants::MAIL_FROM_EMAIL."\r\n";
        $this->headers .= "MIME-Version: 1.0\r\n";
        $this->headers .= "Content-Type: text/html; charset=utf-8\r\n";
        $this->status = mail($this->to, $this->subject, $this->message, $this->headers);

    }

    public function getStatus()
    {
        return $this->status;
    }
}