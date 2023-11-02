<?php

/**
 * Classe de l'orm pour faire les acces a la base de données et recuperer les valeurs de la table MUTE
 *
 * les attributs de la table MUTE sont :
 * - idMute : int
 * - UserID : int
 * - DateM : datetime
 * - Reason : varchar(100)
 * - Duration : datetime
 *
 * Cette classe permet de récuperer les données des utilisateurs mutés afin de bloquer leur accès aux fonctionnalités
 * du site (temporairement ou non). On cible ici l'impossibilité pour un utilisateur de poster des commentaires/du contenu.
 * il est spectateur seulement.
 *
 * La gestion des mutes se fait par les modérateurs et administrateurs.
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
class MutedUser
{

}