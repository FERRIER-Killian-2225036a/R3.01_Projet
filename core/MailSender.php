<?php

/**
 * la classe MailSender a pour but de gérer l'envoi de mail, lors de la création de compte par exemple
 *
 * on pourrait penser dans le futur qu'on crée des methodes ou on envoie des mails a des utilisateurs
 * directement dans cette classe afin d'améliorer la maintenabilité de l'application
 * ainsi le moteur de mail concentrera tout les messages dans cette classe afin de pouvoir envoyer des mails
 * de facon simplifier, pour l'oublie de mail par exemple, ou dans le cas de newsletter et notifications.
 *
 * @package core
 * @since 1.0
 * @version 1.0
 * @category mailSender
 * @author Tom Carvajal
 */
class mailSender
{
    /**
     * @var string
     */
    private string $to;

    /**
     * @var string
     */
    private string $subject;

    /**
     * @var string
     */
    private string $message;

    /**
     * @var string
     */
    private string $headers;

    /**
     * @var string
     */
    private string $status;


    /**
     * Class mailSender constructor.
     *
     * @param $to
     * @param $subject
     * @param $message
     */
    public function __construct($to, $subject, $message)
    {
        $this->to = $to;
        $this->subject = $subject;
        $this->message = $message;
        $this->message.= "\n\n Pour retourner sur le site direction : https://cyphub.tech";
        $this->headers = "From: ".Constants::MAIL_FROM_EMAIL."\r\n";
        $this->headers .= "MIME-Version: 1.0\r\n";
        $this->headers .= "Content-Type: text/html; charset=utf-8\r\n";
        $this->status = mail($this->to, $this->subject, $this->message, $this->headers);

    }

    /**
     * getter du status de l'envoi du mail (success ou non)
     * @return string
     */
    public function getStatus()
    {
        return $this->status;
    }
}