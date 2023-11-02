<?php

/**
 * la Classe BlacklistUser de l'orm pour faire les acces a la base de données et recuperer les valeurs de la table BLACKLIST
 *
 * les attributs de la table BLACKLIST sont :
 * - idBlacklist : int
 * - UserID : int
 * - DateB : datetime
 * - Reason : varchar(100)
 * - Duration : datetime
 *
 * Cette classe permet de récuperer les données des utilisateurs banni afin de bloquer leur accès aux fonctionnalités
 * du site (temporairement ou non).
 *
 * La gestion des bans se fait par les modérateurs et administrateurs.
 *
 * @see ControllerModo
 * @see UserSite
 *
 * @package models/ORM
 * @since 1.0
 * @version 1.0
 * @category modération
 * @author Tom Carvajal & Vanessa Guil
 */
class BlacklistUser
{

}