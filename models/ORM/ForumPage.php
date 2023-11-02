<?php

/**
 * la Classe ForumPage de l'orm pour faire les acces a la base de données et recuperer les valeurs de la table FORUM_Page
 *
 * les attributs de la table FORUM_Page sont :
 * - PageId : int
 * - title : varchar(150)
 * - message : text
 * - dateP : datetime
 * - UserId : int
 * - NumberOfLikes : int
 * - UrlPicture : text
 * - status : enum('active','inactive','hidden)
 *
 * Cette classe est tres semblable a la classe Blog_Page, elle permet de recuperer les données des pages du forum
 *
 * @see ControllerPost
 * @see ControllerMenu
 * @see ControllerSettings
 * @see Blog_Page
 * @see UserSite
 *
 * @package models/ORM
 * @since 1.0
 * @version 1.0
 * @category forum
 * @author Tom Carvajal & Vanessa Guil
 */
class ForumPage
{

}