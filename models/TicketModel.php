<?php

class TicketModel
{
    private $TicketId;
    private $mail;
    private $date;
    private $description;
    private $statusT;
    private $title;
    private $UserId;

    public function getTicketId(): mixed
    {
        return $this->TicketId;
    }

    public function getMail(): mixed
    {
        return $this->mail;
    }

    public function getDate(): mixed
    {
        return $this->date;
    }

    public function getDescription(): mixed
    {
        return $this->description;
    }

    public function getStatusT(): mixed
    {
        return $this->statusT;
    }

    public function getTitle(): mixed
    {
        return $this->title;
    }

    public function getUserId(): mixed
    {
        return $this->UserId;
    }


    public function __construct($UserId)
    {
        $arrayOfValues = (new Ticket)->getValuesByUserId($UserId);
        $this->TicketId = $arrayOfValues['TicketId'];
        $this->mail = $arrayOfValues['mail'];
        $this->date = $arrayOfValues['date'];
        $this->description = $arrayOfValues['description'];
        $this->statusT = $arrayOfValues['statusT'];
        $this->title = $arrayOfValues['title'];
        $this->UserId = $arrayOfValues['UserId'];
    }
}