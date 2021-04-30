<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<?php
error_reporting(E_ALL ^ E_NOTICE);

echo '<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="fr" >
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
	<meta name="author" content="eRaSoR" />
	<meta name="description" content="Explorateur FTP" />
	<meta name="generator" content="Notepad++ v4.0.2" />
	<meta name="keywords" content="Explorateur FTP" />
	<link rel="stylesheet" media="screen" type="text/css" title="defaut.css" href="explorateur_ftp/ftp.css" />
	<link rel="shortcut icon" href="images/icones/fillezilla.png" />
	<title>Explorateur FTP</title>
</head>
<body>';

// Fonction récursive permettant l'affichage de l'arborescence
function lister_dossiers ($dossier) {
	if($dossier_ouvert=opendir ($dossier)) {
		while ($entree=readdir ($dossier_ouvert)) {
			$dossier_url=$dossier.$entree.'/';
			if (@is_dir ($dossier_url) AND $entree!='.' AND $entree!='..') {
				if ($entree!='explorateur_ftp') {
					echo '<tr><td>';
					// Gestion de la profondeur des alinéas
					$profondeur=preg_match_all ('!/!i', $dossier_url, $tab)-1;
					for ($i=0 ; $i<4*$profondeur ; $i++) {
						echo '&nbsp;';
					}
					if (!preg_match ("!^${_GET['url']}$!i", $dossier_url))
						echo '<a href="index.php?url='.$dossier_url.'"><span class="dossier">'.$entree.'</span></a></td></tr>';
					else
						echo '<a href="index.php?url='.$dossier_url.'"><span id="dossier_courant">&nbsp;'.$entree.'</span></a></td></tr>';
					if (strpos ($_GET['url'], $dossier_url)!== FALSE)
						lister_dossiers ($dossier_url);
				}
			}
		}
		closedir ($dossier_ouvert);
	}
}

// Fonction Listant les fichiers du répertoire
function lister_fichiers ($fichier) {
	if ($fichier_ouvert=opendir ($fichier)) {
		while ($entree=readdir ($fichier_ouvert)) {
			$fichier_url=$fichier.$entree;
			if (@is_file ($fichier_url)) {
				if ($fichier_url!='./index.php') {
					// Traitement des icones
					if (preg_match ('!.+[.](.+$)!i', $entree, $tableau)) {
						$extension=strtolower ($tableau['1']);
						$url_image='explorateur_ftp/icones_extensions/'.$extension.'.png';
							if (!file_exists ($url_image))
						$url_image='explorateur_ftp/icones_extensions/inconnu.png';
					}
					else {
						$extension='inconnu';
						$url_image='explorateur_ftp/icones_extensions/inconnu.png';
					}
					$icone='<img src="'.$url_image.'" alt="[ico]" border="0" /> ';
					// Traitement de la taille la plus adaptée
					if (!$taille=filesize ($fichier_url))
						$taille='Inconnu';
					else {
						for ($i = 0 ; ($taille / 1024) > 1 && i < 4 ; $i++) {
							$taille /= 1024;
						}
						$type=array(' octets',' Ko',' Mo',' Go',' To');
						// Traitement des décimales
						$tab=explode (".",$taille);
						if ($tab[0]!=$taille)
							$taille=number_format ($taille, 2, ',', ' ');
						$taille=$taille.$type[$i];
					}
					// Traitement de la date de dernière modification
					$date = filemtime ($fichier_url);
					$date = date ('d/m/y - H:i:s', $date);
					// Affichage
					echo '<tr><td class="fichier"><a href="'.$fichier_url.'">'.$icone.$entree.'</a></td><td>'.$taille.'</td><td>'.$date.'</td></tr>';
				}
			}
		}
		closedir ($fichier_ouvert);
	}
}

// Traitement de l'adresse à explorer
if (!isset($_GET['url']) || empty($_GET['url']) || strpos($_GET['url'],'../') !== FALSE || strpos($_GET['url'],'./') === FALSE)
	$_GET['url']='./';
elseif (!preg_match ('!/$!', $_GET['url']))
	$_GET['url']=$_GET['url'].'/';
	
// Affichage de l'arborescence
echo '<h1>Explorateur FTP</h1>
<table id="ftp">
	<tr><th id="adresse_barre" colspan="2">Adresse <img src="explorateur_ftp/icones/repertoire_ouvert.png" ALT="[rep]" /><form id="adresse_formulaire" method="get" action="./index.php"> <input id="adresse_text" type="text" name="url" value="'.$_GET['url'].'" /> <input id="adresse_submit" type="submit" value="OK" /></form></th></tr>
	<tr><td id="arborescence_dossiers" valign="top">
			<table class="fenetre">
				<tr><th class="titre">Arborescence</th></tr>
				<tr><td><a href="index.php?url=."><img src="explorateur_ftp/icones/retour.png" border="0" alt="[ret]" /> Racine</a></td></tr>';
				lister_dossiers ('./');
echo '		</table>
		</td>';

// Affichage des fichiers du dossier exploré
echo '	<td id="arborescence_fichiers" valign="top">
			<table class="fenetre">
				<tr><th class="titre" colspan="3">Fichiers contenus dans le dossier</th></tr>
				<tr><th class="sous_titre">Nom</th><th class="sous_titre">Taille</th><th class="sous_titre">Dernière Modification</th></tr>';
				lister_fichiers ($_GET['url']);
echo '		</table>
		</td></tr>
<tr><td id="credits" colspan="2">Copyright 2007 - Explorateur FTP - <a href="http://www.siteduzero.com/">Le Site Du Zéro</a> & <a href="http://notepad-plus.sourceforge.net/fr/site.htm">Notepad++</a> - Codé intégralement en php par <a href="mailto:erasor@hotmail.fr" title="erasor@hotmail.fr">eRaSoR</a> !!</td></tr>
</table>';

echo '</body></html>';
?>
