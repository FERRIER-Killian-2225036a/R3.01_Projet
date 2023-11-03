<link rel="stylesheet" href="/common_styles/menu.css">
<main id="searchContainer">
<?php
//array("result" => $result, "input" => $input)

echo "<h1>Resultat de la recherche pour : " . $mapView["input"] . "</h1>";
if (isset($mapView["result"]["IT_Articles"])) {
    echo "<h2>Articles</h2>";
    foreach ($mapView["result"]["IT_Articles"] as $url) {
        echo "<a href='" . $url . "'>" . $url . "</a><br>";
    }
}
?>
<hr>
<?php
if (isset($mapView["result"]["USERSite"])) {
    echo "<h2>Utilisateurs</h2>";
    foreach ($mapView["result"]["USERSite"] as $url) {
        echo "<a href='" . $url . "'>" . $url . "</a><br>";
    }
}
?>
<hr>
<?php
if (isset($mapView["result"]["BLOG_Page"])) {
    echo "<h2>Posts de blog</h2>";
    foreach ($mapView["result"]["BLOG_Page"] as $url) {
        echo "<a href='" . $url . "'>" . $url . "</a><br>";
    }
}
?>
<hr>
<?php
if (isset($mapView["result"]["BLOG_Comment"])) {
    echo "<h2>Commentaires</h2>";
    foreach ($mapView["result"]["BLOG_Comment"] as $url) {
        echo "<a href='" . $url . "'>" . $url . "</a><br>";
    }
}

/*
if (isset($mapView["result"]["FORUM_Page"])) {
    echo "<h2>Posts de forum</h2>";
    foreach ($mapView["result"]["FORUM_Page"] as $url) {
        echo "<a href='" . $url . "'>" . $url . "</a><br>";
    }
}
if (isset($mapView["result"]["FORUM_Comment"])) {
    echo "<h2>Commentaires</h2>";
    foreach ($mapView["result"]["FORUM_Comment"] as $url) {
        echo "<a href='" . $url . "'>" . $url . "</a><br>";
    }
}
if (isset($mapView["result"]["FORUM_Category"])) {
    echo "<h2>Categories</h2>";
    foreach ($mapView["result"]["FORUM_Category"] as $url) {
        echo "<a href='" . $url . "'>" . $url . "</a><br>";
    }
}
*/?>
<hr>
<?php
if (isset($mapView["result"]["BLOG_Category"])) {
    echo "<h2>blogs avec la catégorie : ". $mapView["input"]." </h2>";
    foreach ($mapView["result"]["BLOG_Category"] as $url) {
        echo "<a href='" . $url . "'>" . $url . "</a><br>";
    }
}
?>
<hr>
<?php
if (isset($mapView["result"]["BLACKLIST"])) {
    echo "<h2>BlackList</h2>";
    foreach ($mapView["result"]["BLACKLIST"] as $url) {
        echo "<a href='" . $url . "'>" . $url . "</a><br>";
    }
}
?>
<hr>
<?php
if (isset($mapView["result"]["MUTE"])) {
    echo "<h2>Muted User</h2>";
    foreach ($mapView["result"]["MUTE"] as $url) {
        echo "<a href='" . $url . "'>" . $url . "</a><br>";
    }
}?>
</main>