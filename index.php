<?php
function addManhwa(){
    $bdd = new PDO('mysql:host=localhost;dbname=manhwa','root','',array(PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION));

    $nom_manhwa = $_POST['nom_future'];
    $lien_image_manhwa = '../image_manhwa/'.$_POST["nom_future"];

    $req=$bdd->prepare(
        "INSERT INTO liste_manhwa (nom_manhwa, lien_image_manhwa) VALUES (?,?)"
        );

    $req->bindParam(1,$nom_manhwa,PDO::PARAM_STR);
    $req->bindParam(2,$lien_image_manhwa,PDO::PARAM_STR);

    $req->execute();

    return "Ajout réussi";
};

function readManhwaByNom(){
    $bdd = new PDO('mysql:host=localhost;dbname=manhwa','root','',array(PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION));

    $nom_manhwa = $_POST['nom_future'];
    
    $req=$bdd->prepare(
        "SELECT nom_manhwa FROM liste_manhwa WHERE nom_manhwa=?"
    );

    $req->bindParam(1,$nom_manhwa,PDO::PARAM_STR);

    $req->execute();

    $data = $req->fetchAll(PDO::FETCH_ASSOC);

    return $data;
}

if(isset($_POST["ajouter_future"])){
    print_r('jsp');
    if(isset($_POST["nom_future"])){
        print_r('jsp');
        if(empty(readManhwaByNom())){
            print_r('jsp');
            return "<p>Ce manhwa est déjà dans cette liste</p>";
        }else{
            print_r('jsp');
            addManhwa();
        }
    }else{
        return "<p>Veuiller remplir tout les chamsp</p>";
    }
}
?>

<!DOCTYPE html>
<html lang="fr">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>MANHWA</title>
        <link rel="stylesheet" href="./style.css">
    </head>

    <body>
        <header>
            <h1>SITE PERSONNEL MANHWA</h1>
            <form>
                <input id="recherche_manhwa" type="texte" name="recherche" placeholder="Recherche le manhwa via son titre">
                <input type="submit" name="lancer" value="RECHERCHER">
            </form>
        </header>
        <main>
            <section>
                <h2>Liste Manhwa que je veux lire</h2>
                <form action="" method="POST">
                    <div id="liste_1"></div>
                    <article id="ajout_futur">
                        <input type="text" name="nom_future" placeholder="Nom manhwa">
                        <input type="submit" name="ajouter_future">
                    </article>
                </form>
            </section>
            <div id="separator"></div>
            <section>
                <h2>Liste Manhwa que j'ai lue</h2>
                <form action="" method="POST">
                    <div id="liste_2"></div>
                    <article id="ajout_passer">
                        <input type="text" name="nom_passer" placeholder="Nom manhwa">
                        <input type="submit" name="ajouter_passer">
                    </article>
                </form>
            </section>
        </main>
        <footer>
        </footer>
    </body>
</html>