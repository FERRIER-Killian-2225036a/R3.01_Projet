<?php

/**
 * la Classe ControllerPost gere la gestion des blogs / forums et leurs éditions
 *
 * la gestion se fait au niveau de la logique de l'interaction utilisateurs dans 4 tâches principales
 * Blog → recuperation du model pour afficher un blog (entier pas sous forme de feed) en tant que spéctateur
 * BlogEdit → création ou modification d'un blog par l'auteur, par rapport a la requete en liaison a la bdd
 * Forum → comme blog pour les forums
 * ForumEdit → comme blog edit pour les forums
 *
 * @see /views/post/viewBlog.php
 * @see /views/post/viewBlogEdit.php
 * @see /views/post/viewForum.php
 * @see /views/post/viewForumEdit.php
 * @see BlogPageModel
 * @see Blog_Page
 * @see Blog_Category
 * @see Blog_categoryPage
 *
 * @since 1.0
 * @package controller
 * @version 1.0
 * @category Post
 * @author Tom Carvajal & killian ferrier
 */
class ControllerPost
{
    /**
     * Méthode pour éditer un blog
     *
     * on procède d'abord à l'affichage (GET) de la page selon les droits utilisateurs ou a la redirection
     * sur les critères de la connexion, et l'appartenance du blog a l'utilisateur (ou son existence)
     * on analyse si la demande sera donc plutot de la création ou de la modification, auquel cas on affichera
     * les données deja présente dans la bdd dans les champs d'input
     *
     * ensuite, on va traiter les requetes de mise a jour de la base (POST) en verifiant de la meme maniere
     * les droits utilisateurs et l'appartenance du blog a l'utilisateur (ou son existence)
     * on va ensuite traiter les données d'input et traiter les images,
     * en les sécurisant et en les mettant a jour dans la bdd
     *
     * on s'occupe aussi de rediriger / logger si des comportements sont inattendus
     * (ex : tentative de modification sans droits)
     *
     * @return void
     * @var array|null $A_postParams
     * @var array|null $A_parametres
     */
    public function BlogEditAction(array $A_parametres = null, array $A_postParams = null): void
    {
        // TODO on poura potentiellement ameliorer le filtre / modération input
        // TODO bouton changement de visibilité dans post

        // $A_parametres[0] contient l'identifiant du post a édité
        // si $A_parametres[0] est null alors on est dans le cas de la création d'un nouveau post
        // $A_postParams; contient les données pour la modif/ création de page
        // $A_postParams["Title"] contient le titre
        // $A_postParams["Content"] contient le contenu
        // $A_postParams["Tags"] contient la liste des tags séparé par des ,


        if ($_SERVER['REQUEST_METHOD'] === 'GET') {
            // on va devoir determiner si on a faire a une modification ou une création
            // on va devoir determiner si l'utilisateur a les droits de voir la page de modification

            if (!SessionManager::isUserConnected()) {
                header("Location: /Auth/Login");
                die();
            }
            if (!empty($A_parametres) && $A_parametres[0] !== null) {
                $idPost = filter_var($A_parametres[0], FILTER_VALIDATE_INT); // on recupere l'identifiant dans l'url
                if ($idPost === false) {
                    error_log("valeur $idPost du post n'existe pas/ n'est pas valide");
                    header("Location: /");
                    die();
                }
                // l'identifiant est valide, on va verifier qu'il existe et qu'il appartient au user,
                // afin de lui afficher la page de modification
                $post = new Blog_Page;
                if ($post->doesPageIdExist($idPost)) { // on procede donc a la verification de si l'identifiant est attribué
                    if ($post->doesPageIdBelongToUser($idPost, $_SESSION['UserId'])) {
                        // la page appartient bien au user, on va donc pouvoir l'afficher, en complétant
                        // les différents champs d'input avec les informations déjà présente dans la bdd.
                        $existingPost = new BlogPageModel($idPost); // on crée un nouvelle objet qui contient les

                        $title = $existingPost->getTITLE();
                        $content = $existingPost->getContent();
                        $img = $existingPost->getUrlPicture();
                        $TempTags = $existingPost->getTags();
                        // transformation de la liste d'identifiant de tag, en un string sous forme de label1,label2,label3

                        $tagsStringForInput = "";
                        foreach ($TempTags as $tags) {
                            $tagsStringForInput .= "'" . $tags . "'" . ", ";
                        }
                        $tagsStringForInput = substr($tagsStringForInput, 0, strlen($tagsStringForInput) - 1);
                        // $tagsStringForInput sera fourni dans l'input dans l'input de la vue,
                        MotorView::show('post/viewBlogEdit', array("Title" => $title,
                            "Content" => $content,
                            "Tags" => $tagsStringForInput,
                            "Img" => $img,
                            "UrlForm" => $idPost));
                    }
                }

            } else {
                // cas d'affichage création d'un nouveau blog
                MotorView::show('post/viewBlogEdit');
            }


        } // si la methode de requete est post
        elseif ($_SERVER['REQUEST_METHOD'] === 'POST') { //TODO l'hypothese d'hier sur le type de methode etait correct,
            //get sert a l'affichage ? a t'ont le droit de voir la page, post sert a la modification/création via le
            //formulaire de la page qui submit
            $post = new Blog_Page;

            if (SessionManager::isUserConnected()) { //verification que le client est connecté

                if (!empty($A_parametres) && $A_parametres[0] !== null) { // si l'url a un identifiant ex : /post/blogEdit/1
                    $idPost = filter_var($A_parametres[0], FILTER_VALIDATE_INT); // on recupere l'identifiant dans l'url
                    if ($idPost === false) {
                        error_log("valeur $idPost du post n'existe pas/ n'est pas valide");
                        header("Location: /");
                        die();
                    } else { // l'identifiant dans l'url est valide
                        if ($post->doesPageIdExist($idPost)) { // on procede donc a la verification de si l'identifiant est attribué
                            // si l'id de post appartient au user id de la session en cours
                            if ($post->doesPageIdBelongToUser($idPost, $_SESSION['UserId'])) {

                                // le cas des appels des petits boutons de la page de settings
                                if (isset($A_postParams["DeleteBlog"])) {
                                    $post->deletePage($idPost);
                                    header("Location: /Settings/MyPost");
                                    die();
                                } elseif (isset($A_postParams["ChangeVisibilityBlog"])) {
                                    $status = (new BlogPageModel($idPost))->getStatusP($idPost);
                                    if ($status == "hidden") {
                                        $status = "active";
                                    } elseif ($status == "active") {
                                        $status = "hidden";
                                    }
                                    $post->changeVisibility($idPost, $status);
                                    header("Location: /Settings/MyPost");
                                    die();
                                } else {


                                    // on est dans le cas de la modification d'un post
                                    $existingPost = new BlogPageModel($idPost); // on crée un nouvelle objet qui contient les
                                    // valeurs d'une blogPage de la bdd pour un identifiant unique donnée

                                    $newTitle = null;
                                    $newContent = null;
                                    $newTags = null;

                                    // phase de sécurisation des inputs, on va verifier que c'est pas des inputs pas net

                                    if (isset($A_postParams["Title"])) {
                                        $title = $A_postParams["Title"];
                                        $title = htmlspecialchars($title);
                                        if ($title !== $existingPost->getTitle() && $title != "" && $title != null) {
                                            $newTitle = $title;
                                        }
                                    }
                                    if (isset($A_postParams["Content"])) {
                                        $content = $A_postParams["Content"];
                                        $escapedContent = htmlspecialchars($content); // j'enleve le nettoyage d'input
                                        // car PDO est déjà en train d'empecher les injections sql.
                                        // deplus il détruit les symboles spéciaux, type ' é à ...
                                        // on pourra penser dans le futur faire un moteur de blog ou on peut comme sur
                                        // notion ajouté des blogs de code, des images , des liens ...

                                        if ($escapedContent !== $existingPost->getContent() && $escapedContent != "") {
                                            $newContent = $escapedContent;
                                        }
                                    }
                                    if (isset($A_postParams["Tags"])) {
                                        $tags = $A_postParams["Tags"];
                                        $tags = htmlspecialchars($tags);

                                        $realTagsId = $existingPost->getTags();
                                        $realTags[] = null;
                                        foreach ($realTagsId as $id) {
                                            $realTags[] = (new Blog_Category())->getCategoryById(intval($id));
                                        }
                                        if ($tags != $realTags && $tags != "" && $tags != null) {
                                            $arrayOfTags = explode(",", $tags);
                                            $newTags = $arrayOfTags;
                                        }
                                    }


                                    $newImg = null;

                                    // si il y a une image, on va la traiter avec la méthode de PictureVerificator
                                    $allowedExtensions = ['jpg', 'jpeg', 'png', 'gif'];
                                    $minFileSize = 1000; // Taille minimale en octets
                                    $maxFileSize = 5000000; // Taille maximale en octets (ici, 5 Mo)
                                    $uploadDirectory = Constants::mediaDirectoryblogs() . $idPost;
                                    //TODO verifier une dimension HxV ? format paysage

                                    if (!is_dir($uploadDirectory)) {
                                        if (mkdir($uploadDirectory)) { // création dossier
                                            error_log("Le dossier a été créé avec succès.");
                                        } else {
                                            error_log("Une erreur est survenue lors de la création du dossier.");
                                        }
                                    }

                                    try {
                                        $result = PictureVerificator::VerifyImg($_FILES['BlogPicture'], $uploadDirectory,
                                            $allowedExtensions, $minFileSize, $maxFileSize);
                                        if ($result[0] != "success") {
                                            // TODO appel script js pour modifier la page avec un message d'erreur
                                            // $temp ='<script type="text/javascript">ShowLoginErrorMessage("'.$result[0].'")</script>';
                                            // echo $result;
                                            throw new ExceptionsUpload($result);
                                        } else {
                                            $newImg = Constants::MEDIA_DIRECTORY_BLOGS . $idPost . "/" . $result[1];

                                            //$post->update_img($idPost,$newImg);

                                        }

                                    } catch (ExceptionsUpload $e) {
                                        //TODO on pensera a afficher un message d'erreur sur le site
                                        error_log($e->getMessage());
                                    }


                                    if ($existingPost->getUrlPicture() !== null && $newImg !== null) { // si une nouvelle image a été fournis et qu'il y en avait deja une,
                                        // on supprime l'ancienne image en conservant la nouvelle afin de faire de la place
                                        $uploadDirectory = $uploadDirectory . "/" . $existingPost->getUrlPicture();
                                        $files = glob($uploadDirectory . '/*'); // recup tout les noms des fichiers
                                        foreach ($files as $file) { // parcours fichiers
                                            if (is_file($file) && $file !== $existingPost->getUrlPicture())
                                                unlink($file); // suppression
                                        }
                                    }

                                    // phase de logique, on va regarder d'ou viens les modifications. on pourra donc modifier
                                    // les champs qui ont été modifié seulement, et laissé telquel les autres, normalement
                                    // cela se fait tout seul car on modifiera la page blogEdit de base
                                    // qui viendra fournir en input les valeurs apres avoir verifier que la page était okay a
                                    // affiché au mec
                                    if ($newImg !== null) {
                                        $post->update_img($idPost, $newImg);
                                    }

                                    $tempArray = $post->getValuesById($idPost);

                                    if ($newTitle == null) {
                                        $newTitle = $tempArray['TITLE'];
                                    }
                                    if ($newContent == null) {
                                        $newContent = $tempArray['content'];
                                    }

                                    $post->updatePage($idPost,
                                        $newTitle,
                                        $newContent,
                                        $_SESSION['Username'],
                                        $_SESSION['UserId'],
                                        $tempArray['UrlPicture'], // la photo est changé que si newImg est pas null
                                        intval($tempArray['NumberOfLikes']),
                                        $tempArray['statusP']);


                                    // ensuite on traite les categories
                                    $CategoryPageFormOrm = new Blog_categoryPage();
                                    if (empty($newTags)) { // on apporte une modifs aux tags en suppression
                                        $CategoryPageFormOrm->removeAllLinkBetweenCategoryAndPage($idPost);
                                    } else { // on a de potentiels modifications dans les tags
                                        $CategoryPageFormOrm->removeAllLinkBetweenCategoryAndPage($idPost);
                                        foreach ($newTags as $tag) { //TODO faut remove si y'en a qui ont changé
                                            $id = (new Blog_Category())->createCategory($tag); // renvoi l'id de la nouvelle/existante page
                                            $CategoryPageFormOrm->createLinkBetweenCategoryAndPage($id, $idPost);// on link la page au nouvel id.
                                        }
                                    }
                                    header("Location: /Settings/MyPost");
                                    die();
                                }
                            } else {
                                (new UserSite())->incrementAlertLevelUser($_SESSION['UserId']);
                                header("Location: /Post/Blog/" . $idPost);
                                die();
                            }
                        }
                    }
                } else {
                    $newTitle = null;
                    $newContent = null;
                    $newTags = null;

                    if (isset($A_postParams["Title"])) {
                        $title = $A_postParams["Title"];
                        $title = htmlspecialchars($title);
                        if ($title != "" && $title != null) {
                            $newTitle = $title;
                        }
                    }
                    if (isset($A_postParams["Content"])) {
                        $content = $A_postParams["Content"];
                        $content = htmlspecialchars($content);

                        if ($content != "") {
                            $newContent = $content;
                        }
                    }
                    if (isset($A_postParams["Tags"])) {
                        $tags = $A_postParams["Tags"];
                        $tags = htmlspecialchars($tags);
                        if ($tags != "" && $tags != null) {
                            $arrayOfTags = explode(",", $tags);
                            $newTags = $arrayOfTags;
                        }
                    }


                    try {
                        // cas de création
                        if ($newTitle == null || $newContent == null) {
                            throw new ExceptionsBlog("Le titre ou le contenu est vide");
                        }
                        $idNewPost = (new Blog_Page())->createPage( // on va creer une page et recuper son identifiant si ca reussi
                            $newTitle,
                            $newContent,
                            $_SESSION['Username'],
                            $_SESSION['UserId']);
                        if (!$idNewPost instanceof Exception && $idNewPost !== false) //todo mettre le bon type de class
                        {
                            throw new ExceptionsBlog($idNewPost); // erreur survenue lors de la création
                        }
                        // et la on va update l'image

                        // on doit recuperer l'id du post pour pouvoir creer le dossier

                        $allowedExtensions = ['jpg', 'jpeg', 'png', 'gif'];
                        $minFileSize = 1000; // Taille minimale en octets
                        $maxFileSize = 5000000; // Taille maximale en octets (ici, 5 Mo)
                        $uploadDirectory = Constants::mediaDirectoryBlogs() . $idNewPost . "/";


                        if (!is_dir($uploadDirectory)) {
                            if (mkdir($uploadDirectory)) { // création dossier
                                error_log("Le dossier a été créé avec succès.");
                            } else {
                                error_log("Une erreur est survenue lors de la création du dossier.");
                            }
                        }

                        $result = PictureVerificator::VerifyImg($_FILES['BlogPicture'], $uploadDirectory,
                            $allowedExtensions, $minFileSize, $maxFileSize);
                        if ($result[0] != "success") {
                            // TODO appel script js pour modifier la page avec un message d'erreur
                            // $temp ='<script type="text/javascript">ShowLoginErrorMessage("'.$result[0].'")</script>';
                            // echo $result;
                            throw new ExceptionsBlog($idNewPost);
                        } else {
                            $newImg = Constants::MEDIA_DIRECTORY_BLOGS . $idNewPost . "/" . $result[1];
                            if ($idNewPost instanceof ExceptionsBlog) {
                                throw new ExceptionsBlog($idNewPost); // erreur survenue lors de la création
                            }
                            $post->update_img($idNewPost, $newImg);
                        }

                        $CategoryPageFormOrm = new Blog_categoryPage();
                        if (!empty($newTags)) { // on a de potentiels modifications dans les tags
                            foreach ($newTags as $tag) {
                                $id = (new Blog_Category())->createCategory($tag); // renvoi l'id de la nouvelle/existante page
                                $CategoryPageFormOrm->createLinkBetweenCategoryAndPage($id, $idNewPost);// on link la page au nouvel id.
                            }
                        }
                        header("Location: /Settings/MyPost");
                        die();

                    } catch
                    (ExceptionsBlog $e) {
                        error_log($e->getMessage());
                        // TODO on pensera a afficher un message d'erreur sur le site
                        // TODO fonction javascript pour empecher submit coté client si titre null
                        header("Location: /Settings/MyPost");
                        die();
                    }
                }
            } else {
                // (new UserSite())->incrementAlertLevelUser($_SESSION['UserId']); //TODO changer systeme suspission sur couple ip / id  voir plus
                header("Location: /");
            }
        }
    }

    /**
     * Méthode pour afficher un blog en tant que spéctateur
     *
     * Si /Post/Blog/ nombre alors on affiche le blog lorsque l'utilisateur est connecter
     *
     * @return void
     * @var array|null $A_postParams
     * @var array|null $A_parametres
     */
    public function BlogAction(array $A_parametres = null, array $A_postParams = null): void
    {
        // $A_parametres[0] contient l'identifiant du post a édité
        // si $A_parametres[0] est null alors on est dans le cas de la création d'un nouveau post
        // $A_postParams; contient les données pour la modif/ création de page
        // $A_postParams["Title"] contient le titre
        // $A_postParams["Content"] contient le contenu
        // $A_postParams["Tags"] contient la liste des tags séparé par des ,

        if (SessionManager::isUserConnected()) {
            if ($A_postParams === null || empty($A_parametres)) {
                header("Location: /Menu/BlogFeed");
                die();
            } else {
                $idPost = filter_var($A_parametres[0], FILTER_VALIDATE_INT); // on recupere l'identifiant dans l'url
                if ($idPost === false) {
                    error_log("valeur $idPost du post n'existe pas/ n'est pas valide");
                    header("Location: /Menu/BlogFeed");
                    die();
                }
                $post = new Blog_Page;
                if ($post->doesPageIdExist($idPost)) { // on procede donc a la verification de si l'identifiant est attribué

                    $existingPost = new BlogPageModel($idPost); // on crée un nouvelle objet qui contient les

                    $title = $existingPost->getTITLE();
                    $content = $existingPost->getContent();
                    $img = $existingPost->getUrlPicture();
                    $TempTags = $existingPost->getTags();
                    $author = $existingPost->getAuthor();

                    $userId = $existingPost->getUserId();

                    $userModel = (new USERSiteModel($userId));
                    $numberOfFollower = $userModel->getNumberOfFollower();
                    $imgProfil = $userModel->getUrlPicture();
                    $urlBookmark = "/Post/Blog/" . $idPost; // TODO on regardera les parametres POST



                    // transformation de la liste d'identifiant de tag, en un string sous forme de label1,label2,label3

                    $tagsStringForInput = "";
                    foreach ($TempTags as $tags) {
                        $tagsStringForInput .= "'" . $tags . "'" . ", ";
                    }
                    $tagsStringForInput = substr($tagsStringForInput, 0, strlen($tagsStringForInput) - 1);
                    // $tagsStringForInput sera fourni dans l'input dans l'input de la vue,
                    MotorView::show('post/viewBlog', array("Title" => $title, //KILLIAN
                                                                    "Content" => $content,
                                                                    "Tags" => $tagsStringForInput,
                                                                    "Img" => $img,
                                                                    "Author" => $author,
                                                                    "NumberOfFollower" => $numberOfFollower,
                                                                    "ImgProfil" => $imgProfil,
                    ));
                }
            }

        }

    }
}