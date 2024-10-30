<?php
$messageAjoutFutur = "";
$messageAjoutPasser = "";
$listManhwaFutur = "";
$listManhwaPasser = "";

function dataTestAjoutFutur(){

    if(empty($_POST["nom_futur"])){
        return ["nom_manhwa"=>'',"erreur"=>'Il faut remplir le nom du manhwa !'];
    }

    $nom_manhwa = $_POST['nom_futur'];

    return ["nom_manhwa"=>$nom_manhwa,"erreur"=>''];
}

function dataTestAjoutPasser(){

    if(empty($_POST["nom_passer"])){
        return ["nom_manhwa"=>'',"erreur"=>'Il faut remplir le nom du manhwa !'];
    }

    $nom_manhwa = $_POST['nom_passer'];

    return ["nom_manhwa"=>$nom_manhwa,"erreur"=>''];
}

function addManhwaFutur($nom_manhwa,$lien_image_manhwa){
    $bdd = new PDO('mysql:host=localhost;dbname=manhwa','root','',array(PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION));

    try{
        $req=$bdd->prepare(
            "INSERT INTO liste_manhwa_futur (nom_manhwa, lien_image_manhwa) VALUES (?,?)"
            );
    
        $req->bindParam(1,$nom_manhwa,PDO::PARAM_STR);
        $req->bindParam(2,$lien_image_manhwa,PDO::PARAM_STR);
    
        $req->execute();
    
        return "Le manwha $nom_manhwa a bien été ajouté !";
    }catch(EXCEPTION $error){
        return $error->getMessage();
    }
}

function addManhwaPasser($nom_manhwa,$lien_image_manhwa){
    $bdd = new PDO('mysql:host=localhost;dbname=manhwa','root','',array(PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION));

    try{
        $req=$bdd->prepare(
            "INSERT INTO liste_manhwa_passer (nom_manhwa, lien_image_manhwa) VALUES (?,?)"
            );
    
        $req->bindParam(1,$nom_manhwa,PDO::PARAM_STR);
        $req->bindParam(2,$lien_image_manhwa,PDO::PARAM_STR);
    
        $req->execute();
    
        return "Le manwha $nom_manhwa a bien été ajouté !";
    }catch(EXCEPTION $error){
        return $error->getMessage();
    }
}

function readManhwaByNomFutur($nom_manhwa){
    $bdd = new PDO('mysql:host=localhost;dbname=manhwa','root','',array(PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION));

    try{
        $req=$bdd->prepare(
            "SELECT nom_manhwa FROM liste_manhwa_futur WHERE nom_manhwa=(?)"
        );
    
        $req->bindParam(1,$nom_manhwa,PDO::PARAM_STR);
    
        $req->execute();
    
        $data = $req->fetchAll(PDO::FETCH_ASSOC);
    
        return $data;
    }catch(EXCEPTION $error){
        return $error->getMessage();
    }
}

function readManhwaByNomPasser($nom_manhwa){
    $bdd = new PDO('mysql:host=localhost;dbname=manhwa','root','',array(PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION));

    try{
        $req=$bdd->prepare(
            "SELECT nom_manhwa FROM liste_manhwa_passer WHERE nom_manhwa=(?)"
        );
    
        $req->bindParam(1,$nom_manhwa,PDO::PARAM_STR);
    
        $req->execute();
    
        $data = $req->fetchAll(PDO::FETCH_ASSOC);
    
        return $data;
    }catch(EXCEPTION $error){
        return $error->getMessage();
    }
}

function readAllManhwaFutur(){

    $bdd = new PDO('mysql:host=localhost;dbname=manhwa','root','',array(PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION));

    try{

        $req = $bdd->prepare('SELECT nom_manhwa, lien_image_manhwa FROM liste_manhwa_futur');

        $req->execute();

        $data = $req->fetchAll(PDO::FETCH_ASSOC);

        return $data;
    }catch(EXCEPTION $error){
        return $error->getMessage();
    }
}

function readAllManhwaPasser(){

    $bdd = new PDO('mysql:host=localhost;dbname=manhwa','root','',array(PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION));

    try{

        $req = $bdd->prepare('SELECT nom_manhwa, lien_image_manhwa FROM liste_manhwa_passer');

        $req->execute();

        $data = $req->fetchAll(PDO::FETCH_ASSOC);

        return $data;
    }catch(EXCEPTION $error){
        return $error->getMessage();
    }
}

if(isset($_POST["ajouter_futur"])){
    $tab = dataTestAjoutFutur();
    if($tab['erreur'] != ''){
        $message = $tab['erreur'];
        }else{
            if(empty(readManhwaByNomFutur($tab['nom_manhwa']))){
                $messageAjoutFutur = addManhwaFutur($tab['nom_manhwa'],'../image_manhwa/'.$tab['nom_manhwa'].'.jpg');
    
            }else{
                $messageAjoutFutur="Ce Manhwa existe déjà en BDD !";
            }
    }
}

if(isset($_POST["ajouter_passer"])){
    $tab = dataTestAjoutPasser();
    if($tab['erreur'] != ''){
        $message = $tab['erreur'];
        }else{
            if(empty(readManhwaByNomPasser($tab['nom_manhwa']))){
                $messageAjoutPasser = addManhwaPasser($tab['nom_manhwa'],'../image_manhwa/'.$tab['nom_manhwa'].'.jpg');
    
            }else{
                $messageAjoutPasser="Ce Manhwa existe déjà en BDD !";
            }
    }
}

function cardManhwa($manhwa){
    return "<article style='position:relative; left:120px; border:3px solid white; color:white; padding-bottom:10px; width:300px'>
                <img style='width:300px; height:450px;' src='{$manhwa['lien_image_manhwa']}'>
                <h3 style='text-wrap: wrap;'>{$manhwa['nom_manhwa']}</h3>
                <button style='position:absolute; top:0px; left:250px; font-size:50px; background-color:white; border:3px solide black;border-radius:50%; width:50px; height:50px; line-height:0px; text-align:center justify-content:center;'>-</button>
            </article>";
}

$AllManhwaFutur = readAllManhwaFutur();
foreach($AllManhwaFutur as $manhwa){
    $listManhwaFutur .= cardManhwa($manhwa);
}

$AllManhwaPasser = readAllManhwaPasser();
foreach($AllManhwaPasser as $manhwa){
    $listManhwaPasser = $listManhwaPasser.cardManhwa($manhwa);
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
                <input id="nom_recherche_manhwa" type="search" name="recherche" placeholder="Recherche le manhwa via son titre">
                <input id="lancer_recherche_manhwa" type="submit" name="lancer" value="RECHERCHER">
            </form>
        </header>
        <main>
            <section>
                <h2>Liste Manhwa que je veux lire</h2>
                <div class="liste_manhwa">
                    <?php echo $listManhwaFutur ?>
                </div>
                <form action="" method="POST">
                    <div id="ajout_futur">
                        <input type="text" name="nom_futur" placeholder="Nom manhwa">
                        <input type="submit" name="ajouter_futur" value="AJOUTER">
                    </div>
                    <?php echo $messageAjoutFutur ?>
                </form>
            </section>
            <div id="separator"></div>
            <section>
                <h2>Liste Manhwa que j'ai lue</h2>
                <div class="liste_manhwa">
                    <?php echo $listManhwaPasser ?>
                </div>
                <form action="" method="POST">
                    <div id="ajout_passer">
                        <input type="text" name="nom_passer" placeholder="Nom manhwa">
                        <input type="submit" name="ajouter_passer" value="AJOUTER">
                    </div>
                    <?php echo $messageAjoutPasser ?>
                </form>
            </section>
        </main>
        <footer>
        </footer>
    </body>
</html>