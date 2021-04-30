<?php
error_reporting(E_ALL ^ E_NOTICE);

// CHANGEMENT DU STYLE
if (isset($_GET['style']) AND $_GET['style'] != NULL) { // Si un changement de style doit etre effectué
	setcookie ('style', $_GET['style'], time()+365*3600);
	$style = $_GET['style'];
}
elseif (isset($_COOKIE['style']) AND $_COOKIE['style'] != NULL) // Si un cookie de changement de style est trouvé
	$style = $_COOKIE['style'];
else // Style par défaut
	$style = 'bleu';

echo '<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="fr" >
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
	<meta name="author" content="erasor" />
	<meta name="description" content="Explorateur FTP" />
	<meta name="generator" content="Notepad++ v4.0.2" />
	<meta name="keywords" content="Explorateur, FTP, '.$_SERVER["HTTP_HOST"].'" />
	<link rel="stylesheet" media="screen" type="text/css" title="Actuel" href="explorateur_ftp/styles/ftp_'.$style.'.css" />
	<link rel="shortcut icon" href="explorateur_ftp/icones/ftp_'.$style.'.png" />
	<title>'.$_SERVER["HTTP_HOST"].'</title>
</head>
<body>';

// Fonction récursive permettant l'affichage de l'arborescence
function lister_dossiers ($dossier) {
	if ($dossier_ouvert = opendir ($dossier)) {
		// Création du tableau contenant la liste des dossiers
		$liste_dossiers = array ();
		while (false !== ($entree = readdir ($dossier_ouvert)))
			$liste_dossiers[] = $entree;
		closedir ($dossier_ouvert);
		sort ($liste_dossiers);
		$count = count ($liste_dossiers);
		// Affichage du tableau contenant la liste des dossiers
		for ($nb = 0; $nb <= $count ; $nb++) {
			$dossier_url = $dossier.$liste_dossiers[$nb].'/';
			if (@is_dir ($dossier_url) AND $liste_dossiers[$nb] != '.' AND $liste_dossiers[$nb] != '..' AND $liste_dossiers[$nb] != 'explorateur_ftp' AND $liste_dossiers[$nb] != NULL) {
				echo '<tr><td>';
				// Gestion de la profondeur des alinéas
				$profondeur = preg_match_all ('!/!', $dossier_url, $tab) - 1;
				for ($i = 0 ; $i < 4*$profondeur ; $i++) {
					echo '&nbsp;';
				}
				if (!preg_match ("!^$dossier_url!i", $_GET['url']))
					echo '<a href="./index.php?url='.$dossier_url.'"><img src="../explorateur_ftp/icones/repertoire.png" /> '.$liste_dossiers[$nb].'</a></td></tr>';
				else {
					echo '<a href="./index.php?url='.$dossier_url.'" class="dossier_courant"><img src="../explorateur_ftp/icones/repertoire_ouvert.png" />&nbsp;'.$liste_dossiers[$nb].'</a></td></tr>';
					lister_dossiers ($dossier_url);
				}
			}
		}
	}
	else
		die ("Dossier innaccessible");
}

// Fonction Listant les fichiers du répertoire
function lister_fichiers ($dossier) {
	if ($dossier_ouvert = opendir ($dossier)) {
		// Création du tableau contenant la liste des dossiers
		$liste_fichiers = array ();
		while (false !== ($entree = readdir ($dossier_ouvert)))
			$liste_fichiers[] = $entree;
		closedir ($dossier_ouvert);
		sort ($liste_fichiers);
		$count = count ($liste_fichiers);
		// Affichage du tableau contenant la liste des dossiers
		for ($nb = 0; $nb <= $count ; $nb++) {
			$fichier_url = $dossier.$liste_fichiers[$nb];
			if (@is_file ($fichier_url) AND !preg_match ("!^./explorateur_ftp!i", $fichier_url) AND $fichier_url != './index.php' AND $fichier_url != './phpinfo.php') {
				// Traitement des icones
				if (preg_match ('!.+[.](.+$)!i', $liste_fichiers[$nb], $tableau)) {
					$extension = strtolower ($tableau['1']);
					$url_image = './explorateur_ftp/icones_extensions/'.$extension.'.png';
					if (!file_exists ($url_image))
						$url_image = './explorateur_ftp/icones_extensions/inconnu.png';
				}
				$icone = '<img src="'.$url_image.'" /> ';
				// Traitement de la taille la plus adaptée
				if (!$taille = filesize ($fichier_url))
					$taille = 'Inconnu';
				else {
					for ($i=0 ; ($taille/1024)>1 AND i<4 ; $i++) {
						$taille /= 1024;
					}
					$type = array(' octets',' Ko',' Mo',' Go',' To');
					// Traitement des décimales
					$tab = explode (".",$taille);
					if ($tab[0] != $taille)
						$taille = number_format ($taille, 2, ',', ' ');
					$taille = $taille.$type[$i];
				}
				// Traitement de la date de dernière modification
				$date = filemtime ($fichier_url);
				$date = date ('d/m/y - H:i:s', $date);
				// Affichage
				echo '<tr class="fichier"><td><a href="'.$fichier_url.'">'.$icone.$liste_fichiers[$nb].'</a></td><td>'.$taille.'</td><td>'.$date.'</td></tr>';
			}
		}
	}
	else // Si l'utilisateur entre une adresse incorrecte
		echo '<div class="erreur">Erreur : Dossier innaccessible</div>';
}


// Traitement de l'adresse à explorer
if (!isset($_GET['url']) || empty($_GET['url']) || strpos($_GET['url'],'../') !== FALSE || strpos($_GET['url'],'./') === FALSE)
	$_GET['url'] = './';
elseif (!preg_match ('!/$!', $_GET['url']))
	$_GET['url'] = $_GET['url'].'/';
	
// Titre du site
echo '<h1>'.$_SERVER["HTTP_HOST"].'</h1>';
// Affichage de l'arborescence
echo '<table id="ftp">
	<tr><th id="adresse_barre" colspan="2">Adresse <img src="explorateur_ftp/icones/repertoire_ouvert.png" /> <form id="adresse_formulaire" method="get" action="./index.php"><input id="adresse_text" type="text" name="url" value="'.$_GET['url'].'" /> <input id="adresse_submit" type="submit" value="OK" /></form></th></tr>
	<tr><td id="arborescence_dossiers" valign="top">
		<table class="fenetre">
			<tr><th class="titre">Arborescence</th></tr>
			<tr><td><a href="index.php?url=./" class="dossier_courant"> <img src="explorateur_ftp/icones/retour.png" border="0" /> Racine</a></td></tr>';
			lister_dossiers ('./');
echo '	</table>
	</td>';

// Affichage des fichiers du dossier exploré
echo '<td id="arborescence_fichiers" valign="top">
		<table class="fenetre">
			<tr><th class="titre" colspan="3">Fichiers contenus dans le dossier</th></tr>
			<tr><th class="sous_titre">Nom</th><th class="sous_titre">Taille</th>
			<th class="sous_titre">Dernière Modification</th></tr>';
			lister_fichiers ($_GET['url']);
echo '	</table>
	</td></tr>
<tr><td id="credits" colspan="2"><> Copyright 2007 <>
	<form method="get">
		<input type="hidden" name="url" value="'.$_GET['url'].'">
		<select id="design_liste_deroulante" name="style">
			<option value="bleu" selected="selected">Design</option>
			<option value="bleu">Bleu</option>
			<option value="rouge">Rouge</option>
			<option value="orange">Orange</option>
			<option value="vert">Vert</option>
			<option value="rose">Rose</option>
		</select>
		<input type="submit" id="design_submit" value="ok">
	</form>
<> Code : <a href="mailto:erasor@hotmail.fr" title="erasor@hotmail.fr">eRaSoR</a> !! <></td></tr>
</table>';

echo '</body></html>';
?>
