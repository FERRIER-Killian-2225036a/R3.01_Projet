<?php

/**
 * la Classe TicketModel du model directement en lien avec l'orm , on a cette classe pour eviter de trop faire
 * de requete de lecture sur les données des tickets.
 *
 * Cette classe principale concerne les données des tickets dans la base de données
 *
 * @see ControllerModo
 * @see ControllerSettings
 * @see Ticket
 *
 * @package models
 * @since 1.0
 * @version 1.0
 * @category support
 * @author Tom Carvajal
 */
class TicketModel
{
    /**
     * @var int L'identifiant du ticket.
     */
    private int $TicketId;

    /**
     * @var string L'adresse mail de l'utilisateur ayant écrit le ticket.
     */
    private string $mail;

    /**
     * @var string La date de création du ticket.
     */
    private string $date;

    /**
     * @var string La description du ticket.
     */
    private string $description;

    /**
     * @var string Le statut du ticket.
     */
    private string $statusT;

    /**
     * @var string Le titre du ticket.
     */
    private string $title;

    /**
     * @var int L'identifiant de l'utilisateur ayant écrit le ticket.
     */
    private int $UserId;

    public function __construct($UserId)
    {
        $tempObj = new Ticket();
        $arrayOfValues = $tempObj->getValuesById($UserId);
        $this->TicketId = $arrayOfValues['TicketId'];
        $this->mail = $arrayOfValues['mail'];
        $this->date = $arrayOfValues['date'];
        $this->description = $arrayOfValues['description'];
        $this->statusT = $arrayOfValues['statusT'];
        $this->title = $arrayOfValues['title'];
        $this->UserId = $arrayOfValues['UserId'];
    }

    /**
     * @return int
     */
    public function getTicketId(): int
    {
        return $this->TicketId;
    }

    /**
     * @return string
     */
    public function getMail(): string
    {
        return $this->mail;
    }

    /**
     * @return string
     */
    public function getDate(): string
    {
        return $this->date;
    }

    /**
     * @return string
     */
    public function getDescription(): string
    {
        return $this->description;
    }

    /**
     * @return string
     */
    public function getStatusT(): string
    {
        return $this->statusT;
    }

    /**
     * @return string
     */
    public function getTitle(): string
    {
        return $this->title;
    }

    /**
     * @return int
     */
    public function getUserId(): int
    {
        return $this->UserId;
    }
}