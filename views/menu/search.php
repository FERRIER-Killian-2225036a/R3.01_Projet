<link rel="stylesheet" href="/common_styles/menu.css">
<main id="searchContainer">
<?php
//array("result" => $result, "input" => $input)

echo "<h1>Resultat de la recherche pour : " . $mapView["input"] . "</h1><hr>";
if (isset($mapView["result"]["IT_Articles"])) {
    echo "<h3>Articles :</h3>";
    foreach ($mapView["result"]["IT_Articles"] as $url) {
        echo "<a href='" . $url . "'>" . $url . "</a><hr>";
    }
}
?>

<?php
if (isset($mapView["result"]["USERSite"])) {
    echo "<h3>Utilisateurs :</h3>";
    foreach ($mapView["result"]["USERSite"] as $url) {
        echo "<a href='" . $url . "'>" . $url . "</a><hr>";
    }
}
?>

<?php
if (isset($mapView["result"]["BLOG_Page"])) {
    echo "<h3>Posts de blog :</h3>";
    foreach ($mapView["result"]["BLOG_Page"] as $url) {
        echo "<a href='" . $url . "'>" . $url . "</a><hr>";
    }
}
?>

<?php
if (isset($mapView["result"]["BLOG_Comment"])) {
    echo "<h3>Commentaires :</h3>";
    foreach ($mapView["result"]["BLOG_Comment"] as $url) {
        echo "<a href='" . $url . "'>" . $url . "</a><hr>";
    }
}

/*
if (isset($mapView["result"]["FORUM_Page"])) {
    echo "<h3>Posts de forum :</h3>";
    foreach ($mapView["result"]["FORUM_Page"] as $url) {
        echo "<a href='" . $url . "'>" . $url . "</a><hr>";
    }
}
if (isset($mapView["result"]["FORUM_Comment"])) {
    echo "<h3>Commentaires :</h3>";
    foreach ($mapView["result"]["FORUM_Comment"] as $url) {
        echo "<a href='" . $url . "'>" . $url . "</a><hr>";
    }
}
if (isset($mapView["result"]["FORUM_Category"])) {
    echo "<h3>Categories :</h3>";
    foreach ($mapView["result"]["FORUM_Category"] as $url) {
        echo "<a href='" . $url . "'>" . $url . "</a><hr>";
    }
}
*/?>

<?php
if (isset($mapView["result"]["BLOG_Category"])) {
    echo "<h3>blogs avec la catégorie : ". $mapView["input"]."  :</h3>";
    foreach ($mapView["result"]["BLOG_Category"] as $url) {
        echo "<a href='" . $url . "'>" . $url . "</a><hr>";
    }
}
?>

<?php
if (isset($mapView["result"]["BLACKLIST"])) {
    echo "<h3>BlackList :</h3>";
    foreach ($mapView["result"]["BLACKLIST"] as $url) {
        echo "<a href='" . $url . "'>" . $url . "</a><hr>";
    }
}
?>

<?php
if (isset($mapView["result"]["MUTE"])) {
    echo "<h3>Muted User :</h3>";
    foreach ($mapView["result"]["MUTE"] as $url) {
        echo "<a href='" . $url . "'>" . $url . "</a><hr>";
    }
}?>
</main>