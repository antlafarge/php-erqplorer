<?php
error_reporting(E_ALL ^ E_NOTICE);

// Commande de s�curit�
define ("INC", 1);

require_once ('./explorateur_ftp/fonctions.php');

// CHANGEMENT DU STYLE
if (isset($_GET['style']) AND !empty ($_GET['style'])) { // Si un changement de style doit etre effectu�
	setcookie ('style', $_GET['style'], time()+365*3600);
	$style = $_GET['style'];
}
elseif (isset($_COOKIE['style']) AND !empty ($_COOKIE['style'])) // Si un cookie de changement de style est trouv�
	$style = $_COOKIE['style'];
else // Style par d�faut
	$style = 'bleu';

// Traitement de l'adresse � explorer
if (!isset($_GET['url']) || empty($_GET['url']) || strpos($_GET['url'],'../') !== FALSE || strpos($_GET['url'],'./') === FALSE)
	$_GET['url'] = './';
elseif (!preg_match ('!/$!', $_GET['url']))
	$_GET['url'] = $_GET['url'].'/';

echo '<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="fr" >
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
	<meta name="author" content="erasor" />
	<meta name="description" content="Explorateur FTP" />
	<meta name="generator" content="Notepad++ v4.0.2" />
	<meta name="keywords" content="Explorateur, FTP, '.$_SERVER["HTTP_HOST"].'" />
	<link rel="stylesheet" media="screen" type="text/css" title="Actuel" href="./explorateur_ftp/styles/'.$style.'.css" />
	<link rel="shortcut icon" href="./explorateur_ftp/icones/icone.png" />
	<title>'.$_SERVER["HTTP_HOST"].'</title>
</head>
<body>';

// Titre du site
echo '<div id="banniere">'.$_SERVER["HTTP_HOST"].'</div>';

// Affichage de la barre d'adresse
echo '
<table id="ftp">
	<tr>
		<td id="adresse" colspan="2">
			<form method="get" action="./index.php">
				<table>
					<tr>
						<td id="adresse_text">Adresse <img src="./explorateur_ftp/icones/repertoire_ouvert.png" alt="[rep]" /></td>
						<td><p><input id="adresse_barre" type="text" name="url" value="'.$_GET['url'].'" /></p></td>
						<td id="adresse_submit"><p><input type="submit" value="OK" /></p></td>
					</tr>
				</table>
			</form>
		</td>
	</tr>
	
	<tr>
		<td id="dossiers_cadre" valign="top">
			<table>
				<tr><td class="titre">Arborescence</td></tr>
				<tr><td><a href="index.php?url=./" class="dossier_courant"><img src="./explorateur_ftp/icones/retour.png" alt="[ret]" /> Racine</a></td></tr>';
				lister_dossiers ('./');
echo '		</table>
		</td>
		<td id="fichiers_cadre" valign="top">
			<table>
				<tr><td class="titre" colspan="5">Fichiers contenus dans le dossier</td></tr>
				<tr><td class="sous_titre" colspan="2">Nom</td><td class="sous_titre" colspan="2">Taille</td><td class="sous_titre">Modification</td></tr>';
				lister_fichiers ($_GET['url']);
echo '		</table>
		</td>
	</tr>
	
	<tr>
		<td id="credits" colspan="2">
			PHP-ErqPlorer v0.4 - Copyright 2oo7-2oo8
			<form id="design" method="get" action="./index.php?url='.$_GET['url'].'">
				<p><input type="hidden" name="url" value="'.$_GET['url'].'" /></p>';
				list_select ('css', './explorateur_ftp/styles/', 'style');
echo '			<p><input type="submit" id="design_submit" value="ok" /></p>
			</form>
			W3C <a href="http://validator.w3.org/check?uri=referer">XHTML</a>, <a href="http://jigsaw.w3.org/css-validator/">CSS</a> Validated -
			Webmaster : <a href="mailto:erasor@hotmail.fr" title="erasor@hotmail.fr">erasor</a>
		</td>
	</tr>
</table>

</body>
</html>';
?>
