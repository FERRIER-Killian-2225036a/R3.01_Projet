<?php

class ControllerPost
{
    public function BlogEditAction(array $A_parametres = null, array $A_postParams = null): void
    {

        // $A_parametres[0] contient l'identifiant du post a édité
        // si $A_parametres[0] est null alors on est dans le cas de la création d'un nouveau post
        // $A_postParams; contient les données pour la modif/ création de page
        // $A_postParams["Title"] contient le titre
        // $A_postParams["Content"] contient le contenu
        // $A_postParams["Tags"] contient la liste des tags séparé par des ,


        // si la methode de requete est post
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $post = new Blog_Page;

            if (SessionManager::isUserConnected()) {

                if ($A_parametres[0] !== null) {
                    $idPost = filter_var($A_parametres[0], FILTER_VALIDATE_INT);
                    if ($idPost === false) {
                        error_log("valeur $idPost du post n'existe pas/ n'est pas valide");
                        header("Location: /");
                        die();
                    } else {
                        if ($post->doesPageIdExist($idPost)) {
                            // si l'id de post appartient au user id
                            if ($post->doesPageIdBelongToUser($idPost, $_SESSION['UserId'])) {
                                // on est dans le cas de la modification d'un post
                                $existingPost = new BlogPageModel($idPost);


                                $newTitle = null;
                                $newContent = null;
                                $newTags = null;

                                // phase de sécurisation des inputs, on va verifier que c'est pas des inputs pas net

                                if (isset($A_postParams["Title"])) {
                                    $title = filter_input(INPUT_POST, 'Title', FILTER_SANITIZE_STRING);
                                    if ($title !== $existingPost->getTitle() && $title != "" && $title !== null) {
                                        $newTitle = $title;
                                    }
                                }
                                if (isset($A_postParams["Content"])) {
                                    $content = filter_input(INPUT_POST, 'Content', FILTER_SANITIZE_STRING);
                                    $escapedContent = htmlspecialchars($content);

                                    if ($escapedContent !== $existingPost->getContent() && $escapedContent != "" && $escapedContent !== null) {
                                        $newContent = $escapedContent;
                                    }
                                }
                                if (isset($A_postParams["Tags"])) {
                                    $tags = filter_input(INPUT_POST, 'Tags', FILTER_SANITIZE_STRING);
                                    $realTagsId = $existingPost->getTags();
                                    $realTags[] = null;
                                    foreach ($realTagsId as $id) {
                                        $realTags[] = (new Blog_Category())->getCategoryById($id);
                                    }
                                    if ($tags !== $realTags && $tags != "" && $tags !== null) {
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


                                try {
                                    $result = PictureVerificator::VerifyImg($_FILES['BlogPicture'], $uploadDirectory,
                                        $allowedExtensions, $minFileSize, $maxFileSize);
                                    if ($result[0] != "success") {
                                        // TODO appel script js pour modifier la page avec un message d'erreur
                                        // $temp ='<script type="text/javascript">ShowLoginErrorMessage("'.$result[0].'")</script>';
                                        // echo $result;
                                        throw new ExceptionsUpload($result);
                                    } else {
                                        $newImg = Constants::mediaDirectoryBlogs() . $idPost . "/" . $result[1];
                                        //$post->update_img($idPost,$newImg);

                                    }

                                } catch (ExceptionsUpload $e) {
                                    //TODO on pensera a afficher un message d'erreur sur le site
                                    error_log($e->getMessage());
                                }


                                if (!is_dir($uploadDirectory)) {
                                    if (mkdir($uploadDirectory)) { // création dossier
                                        error_log("Le dossier a été créé avec succès.");
                                    } else {
                                        error_log("Une erreur est survenue lors de la création du dossier.");
                                    }
                                }


                                if ($existingPost->getUrlPicture() !== null && $newImg !== null) {
                                    // on supprime l'ancienne image
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
                                    $newContent = $tempArray['Content'];
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

                                if ($newTags != null && empty($newTags)) { // on apporte une modifs aux tags en suppression
                                    $idTags = (new Blog_categoryPage())->getCategoryByPageId($idPost);
                                    foreach ($idTags as $idtag) {
                                        (new Blog_categoryPage())->removeLinkBetweenCategoryAndPage($idtag, $idPost);
                                    }
                                } else if (!empty($newTags)) { // on a de potentiels modifications dans les tags
                                    foreach ($newTags as $tag) { //TODO faut remove si y'en a qui ont changé
                                        if ((new Blog_Category())->doesCategoryExist($tag) == false) {
                                            $id = (new Blog_Category())->createCategory($tag);
                                            // on link la page au nouvel id.
                                            (new Blog_categoryPage())->createLinkBetweenCategoryAndPage($id, $idPost);
                                        } else {
                                            $id = (new Blog_Category())->getCategoryByLabel($tag);
                                            if ((new Blog_categoryPage())->linkBetweenCategoryAndPageExist($id, $idPost) == false) {
                                                (new Blog_categoryPage())->createLinkBetweenCategoryAndPage($id, $idPost);
                                            }
                                        }
                                    }
                                }

                            } else {
                                (new UserSite())->incrementAlertLevelUser($_SESSION['UserId']);
                                header ("Location: /Post/Blog/".$idPost);
                                die();
                            }
                        }
                    }
                } else {
                    $newTitle = null;
                    $newContent = null;
                    $newTags = null;

                    if (isset($A_postParams["Title"])) {
                        $title = filter_input(INPUT_POST, 'Title', FILTER_SANITIZE_STRING);
                        if ($title != "" && $title !== null) {
                            $newTitle = $title;
                        }
                    }
                    if (isset($A_postParams["Content"])) {
                        $content = filter_input(INPUT_POST, 'Content', FILTER_SANITIZE_STRING);
                        $escapedContent = htmlspecialchars($content);

                        if ($escapedContent != "" && $escapedContent !== null) {
                            $newContent = $escapedContent;
                        }
                    }
                    if (isset($A_postParams["Tags"])) {
                        $tags = filter_input(INPUT_POST, 'Tags', FILTER_SANITIZE_STRING);
                        if ($tags != "" && $tags !== null) {
                            $arrayOfTags = explode(",", $tags);
                            $newTags = $arrayOfTags;
                        }
                    }


                    try {
                        // cas de création
                        $idNewPost = (new Blog_Page())->createPage(
                            $newTitle,
                            $newContent,
                            $_SESSION['Username'],
                            $_SESSION['UserId']);


                        // et la on va update l'image

                        // on doit recuperer l'id du post pour pouvoir creer le dossier

                        $allowedExtensions = ['jpg', 'jpeg', 'png', 'gif'];
                        $minFileSize = 1000; // Taille minimale en octets
                        $maxFileSize = 5000000; // Taille maximale en octets (ici, 5 Mo)
                        $uploadDirectory = Constants::mediaDirectoryBlogs() . $idNewPost . "/";


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


                        if (!is_dir($uploadDirectory)) {
                            if (mkdir($uploadDirectory)) { // création dossier
                                error_log("Le dossier a été créé avec succès.");
                            } else {
                                error_log("Une erreur est survenue lors de la création du dossier.");
                            }
                        }

                        if (!empty($newTags)) { // on a des potentiels ajout de nouveaux tags
                            foreach ($newTags as $tag) {
                                if ((new Blog_Category())->doesCategoryExist($tag) == false) {
                                    $id = (new Blog_Category())->createCategory($tag);
                                    // on link la page au nouvel id.
                                    (new Blog_categoryPage())->createLinkBetweenCategoryAndPage($id, $idNewPost);
                                } else {
                                    $id = (new Blog_Category())->getCategoryByLabel($tag);
                                    (new Blog_categoryPage())->createLinkBetweenCategoryAndPage($id, $idNewPost);
                                }
                            }
                        }


                    }
            catch
                (ExceptionsBlog $e) {
                    //TODO on pensera a afficher un message d'erreur sur le site
                    error_log($e->getMessage());
                }

                }
        } else {
            // (new UserSite())->incrementAlertLevelUser($_SESSION['UserId']); //TODO changer systeme suspission sur couple ip / id  voir plus
            header("Location: /");
        }

        //MotorView::show('post/viewBlogEdit');
        // si la requete est, post/blogEdit sans rien derriere on a a faire a la création d'un nouveau post


        // si la requete contient un identifiant on verifie qu'il est valide et cohérent,
        // on passe a la modification
        // on va donc update model blogPage, categoryPage, Category
        // sinon ca veut dire que c'est pas cohérent donc report
    }
}

}