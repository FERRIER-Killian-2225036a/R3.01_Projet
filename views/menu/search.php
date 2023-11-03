<link rel="stylesheet" href="/common_styles/menu.css">
<main id="searchContainer">
<?php
//array("result" => $result, "input" => $input)

echo "<h1>Resultat de la recherche pour : " . $mapView["input"] . "</h1>";
if (isset($mapView["result"]["IT_Articles"])) {
    echo "<hr><h3>Articles :</h3>";
    foreach ($mapView["result"]["IT_Articles"] as $url) {
        echo "<a href='" . $url . "'>" . $url . "</a>";
    }
}
?>

<?php
if (isset($mapView["result"]["USERSite"])) {
    echo "<hr><h3>Utilisateurs :</h3>";
    foreach ($mapView["result"]["USERSite"] as $url) {
        echo "<a href='" . $url . "'>" . $url . "</a>";
    }
}
?>

<?php
if (isset($mapView["result"]["BLOG_Page"])) {
    echo "<hr><h3>Posts de blog :</h3>";
    foreach ($mapView["result"]["BLOG_Page"] as $url) {
        echo "<a href='" . $url . "'>" . $url . "</a>";
    }
}
?>

<?php
if (isset($mapView["result"]["BLOG_Comment"])) {
    echo "<hr><h3>Commentaires :</h3>";
    foreach ($mapView["result"]["BLOG_Comment"] as $url) {
        echo "<a href='" . $url . "'>" . $url . "</a>";
    }
}

/*
if (isset($mapView["result"]["FORUM_Page"])) {
    echo "<hr><h3>Posts de forum :</h3>";
    foreach ($mapView["result"]["FORUM_Page"] as $url) {
        echo "<a href='" . $url . "'>" . $url . "</a>";
    }
}
if (isset($mapView["result"]["FORUM_Comment"])) {
    echo "<hr><h3>Commentaires :</h3>";
    foreach ($mapView["result"]["FORUM_Comment"] as $url) {
        echo "<a href='" . $url . "'>" . $url . "</a>";
    }
}
if (isset($mapView["result"]["FORUM_Category"])) {
    echo "<hr><h3>Categories :</h3>";
    foreach ($mapView["result"]["FORUM_Category"] as $url) {
        echo "<a href='" . $url . "'>" . $url . "</a>";
    }
}
*/?>

<?php
if (isset($mapView["result"]["BLOG_Category"])) {
    echo "<hr><h3>blogs avec la catégorie : ". $mapView["input"]."  :</h3>";
    foreach ($mapView["result"]["BLOG_Category"] as $url) {
        echo "<a href='" . $url . "'>" . $url . "</a>";
    }
}
?>

<?php
if (isset($mapView["result"]["BLACKLIST"])) {
    echo "<hr><h3>BlackList :</h3>";
    foreach ($mapView["result"]["BLACKLIST"] as $url) {
        echo "<a href='" . $url . "'>" . $url . "</a>";
    }
}
?>

<?php
if (isset($mapView["result"]["MUTE"])) {
    echo "<hr><h3>Muted User :</h3>";
    foreach ($mapView["result"]["MUTE"] as $url) {
        echo "<a href='" . $url . "'>" . $url . "</a>";
    }
}?>
</main>