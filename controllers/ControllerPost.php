<?php

class ControllerPost
{
    public function BlogEditAction(array $A_parametres = null, array $A_postParams = null): void
    {
        error_log("DEBUGING ============================");
        //TODO on poura potentiellement ameliorer le filtre / modération input
        // en plus de cela il faudra avoir un max de catégories pour les tags

        // TODO fix date, Fix affichage posts sur page settings, bouton changement de visibilité dans post

        // $A_parametres[0] contient l'identifiant du post a édité
        // si $A_parametres[0] est null alors on est dans le cas de la création d'un nouveau post
        // $A_postParams; contient les données pour la modif/ création de page
        // $A_postParams["Title"] contient le titre
        // $A_postParams["Content"] contient le contenu
        // $A_postParams["Tags"] contient la liste des tags séparé par des ,


        print_r($A_parametres);
        //error_log("DEBUG : url résiduel : " . print_r($A_parametres, true));
        print_r($A_postParams);
        //error_log("DEBUG : params posts : " . print_r($A_postParams, true));

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
                        error_log("cas d'affichage pour modification");
                        // la page appartient bien au user, on va donc pouvoir l'afficher, en complétant
                        // les différents champs d'input avec les informations déjà présente dans la bdd.
                        $existingPost = new BlogPageModel($idPost); // on crée un nouvelle objet qui contient les

                        $title = $existingPost->getTITLE();
                        $content = $existingPost->getContent();
                        $img = $existingPost->getUrlPicture();
                        $TempTags = $existingPost->getTags();
                        // transformation de la liste d'identifiant de tag, en un string sous forme de label1,label2,label3
                        error_log("tempTags : ".print_r($TempTags,true));

                        $tagsStringForInput = "";
                        foreach ($TempTags as $tags) {
                            $tagsStringForInput .= $tags . ",";
                        }
                        $tagsStringForInput = substr($tagsStringForInput, 0, strlen($tagsStringForInput) - 1);
                        error_log("DEBUG taginput : $tagsStringForInput");
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
                error_log("cas d'affichage pour création");

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
                                // on est dans le cas de la modification d'un post
                                error_log("debug : on est dans le cas de modification d'un post");
                                $existingPost = new BlogPageModel($idPost); // on crée un nouvelle objet qui contient les
                                // valeurs d'une blogPage de la bdd pour un identifiant unique donnée

                                $newTitle = null;
                                $newContent = null;
                                $newTags = null;

                                // phase de sécurisation des inputs, on va verifier que c'est pas des inputs pas net

                                if (isset($A_postParams["Title"])) {
                                    $title = filter_input(INPUT_POST, 'Title', FILTER_SANITIZE_SPECIAL_CHARS);
                                    if ($title !== $existingPost->getTitle() && $title != "" && $title !== null) {
                                        $newTitle = $title;
                                    }
                                }
                                if (isset($A_postParams["Content"])) {
                                    $content = filter_input(INPUT_POST, 'Content', FILTER_SANITIZE_SPECIAL_CHARS);
                                    $escapedContent = htmlspecialchars($content);

                                    if ($escapedContent !== $existingPost->getContent() && $escapedContent != "") {
                                        $newContent = $escapedContent;
                                    }
                                }
                                if (isset($A_postParams["Tags"])) {
                                    $tags = filter_input(INPUT_POST, 'Tags', FILTER_SANITIZE_SPECIAL_CHARS);
                                    $realTagsId = $existingPost->getTags();
                                    $realTags[] = null;
                                    foreach ($realTagsId as $id) {
                                        $realTags[] = (new Blog_Category())->getCategoryById($id);
                                    }
                                    if ($tags !== $realTags && $tags != "" && $tags !== null) {
                                        $arrayOfTags = explode(",", $tags);
                                        $newTags = $arrayOfTags;
                                        error_log("les tags ont bien recu changement");
                                    }
                                    error_log("Les nouveaux tags a inserer sont :".print_r($newTags),true);
                                }


                                $newImg = null;

                                // si il y a une image, on va la traiter avec la méthode de PictureVerificator
                                $allowedExtensions = ['jpg', 'jpeg', 'png', 'gif'];
                                $minFileSize = 1000; // Taille minimale en octets
                                $maxFileSize = 5000000; // Taille maximale en octets (ici, 5 Mo)
                                $uploadDirectory = Constants::mediaDirectoryblogs() . $idPost;
                                error_log("dir d'upload : " . $uploadDirectory);
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
                                        error_log("DEBUG : on est sensé rentré ici car l'image est success");
                                        $newImg = Constants::mediaDirectoryBlogs() . $idPost . "/" . $result[1];
                                        error_log("dir + files name : " . $newImg);

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
                                    $tempArray['dateP'],
                                    $tempArray['NumberOfLikes'],
                                    $tempArray['statusP']);

                                // ensuite on traite les categories
                                $CategoryPageFormOrm = new Blog_categoryPage();
                                error_log("DEBUG BEFORE INSERT TAG" );
                                error_log("new tag potentielement null ou array :". print_r($newTags,true));
                                if (empty($newTags)) { // on apporte une modifs aux tags en suppression
                                    $idTags = $CategoryPageFormOrm->getCategoryByPageId($idPost);
                                    foreach ($idTags as $idtag) {
                                        $CategoryPageFormOrm->removeLinkBetweenCategoryAndPage($idtag, $idPost);
                                    }
                                }
                                else { // on a de potentiels modifications dans les tags
                                    foreach ($newTags as $tag) { //TODO faut remove si y'en a qui ont changé
                                        $id = (new Blog_Category())->createCategory($tag); // renvoi l'id de la nouvelle/existante page
                                        error_log("label of id $id " .(new Blog_Category())->getCategoryById($id));
                                        error_log("est ce que id == false ? :". $id == false);
                                        error_log("DEBUG Crash  idCat :" . $id ." label ". $tag ." idPost". $idPost);
                                        $CategoryPageFormOrm->createLinkBetweenCategoryAndPage($id, $idPost);// on link la page au nouvel id.
                                    }
                                }

                            } else {
                                (new UserSite())->incrementAlertLevelUser($_SESSION['UserId']);
                                header("Location: /Post/Blog/" . $idPost);
                                die();
                            }
                        }
                    }
                } else {
                    error_log("debug : on est dans le cas de création d'un post");

                    $newTitle = null;
                    $newContent = null;
                    $newTags = null;

                    if (isset($A_postParams["Title"])) {
                        $title = filter_input(INPUT_POST, 'Title', FILTER_SANITIZE_SPECIAL_CHARS);
                        if ($title != "" && $title !== null) {
                            $newTitle = $title;
                        }
                    }
                    if (isset($A_postParams["Content"])) {
                        $content = filter_input(INPUT_POST, 'Content', FILTER_SANITIZE_SPECIAL_CHARS);
                        $escapedContent = htmlspecialchars($content);

                        if ($escapedContent != "" && $escapedContent !== null) {
                            $newContent = $escapedContent;
                        }
                    }
                    if (isset($A_postParams["Tags"])) {
                        $tags = filter_input(INPUT_POST, 'Tags', FILTER_SANITIZE_SPECIAL_CHARS);
                        if ($tags != "" && $tags !== null) {
                            $arrayOfTags = explode(",", $tags);
                            $newTags = $arrayOfTags;
                        }
                    }


                    try {
                        // cas de création
                        error_log("DEBUG : cas de création ");
                        $idNewPost = (new Blog_Page())->createPage( // on va creer une page et recuper son identifiant si ca reussi
                            $newTitle,
                            $newContent,
                            $_SESSION['Username'],
                            $_SESSION['UserId']);
                        if (!$idNewPost instanceof Exception && $idNewPost !== false) //todo mettre le bon type de class

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
                            $newImg = Constants::mediaDirectoryBlogs() . $idNewPost . "/" . $result[1];
                            if ($idNewPost instanceof ExceptionsBlog) {
                                throw new ExceptionsBlog($idNewPost); // erreur survenue lors de la création
                            }
                            $post->update_img($idNewPost, $newImg);
                        }

                        $CategoryPageFormOrm = new Blog_categoryPage();
                        if (!empty($newTags)) { // on a de potentiels modifications dans les tags
                            foreach ($newTags as $tag) {
                                $id = (new Blog_Category())->createCategory($tag); // renvoi l'id de la nouvelle/existante page
                                //error_log("DEBUG Crash  :" . $id . $tag . $idPost);
                                $CategoryPageFormOrm->createLinkBetweenCategoryAndPage($id, $idNewPost);// on link la page au nouvel id.
                            }
                        }
                        //MotorView::show('post/viewBlogEdit');


                    } catch
                    (ExceptionsBlog $e) {
                        //TODO on pensera a afficher un message d'erreur sur le site
                        error_log($e->getMessage());
                    }

                }
            } else {
                // (new UserSite())->incrementAlertLevelUser($_SESSION['UserId']); //TODO changer systeme suspission sur couple ip / id  voir plus
                header("Location: /");
            }

            // si la requete est, post/blogEdit sans rien derriere on a a faire a la création d'un nouveau post


            // si la requete contient un identifiant on verifie qu'il est valide et cohérent,
            // on passe a la modification
            // on va donc update model blogPage, categoryPage, Category
            // sinon ca veut dire que c'est pas cohérent donc report
        }

    }
}