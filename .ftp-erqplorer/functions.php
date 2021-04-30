<?php

//Commande de securite
defined("INC") OR DIE("403 ACCES REFUSE");

// Fonction recursive permettant l'affichage de l'arborescence
function lister_dossiers($dossier)
{
	if ($dossier_ouvert = @opendir($dossier))
	{
		// Creation du tableau contenant la liste des dossiers
		$liste_dossiers = array();
		while (false !==($entree = readdir($dossier_ouvert)))
		{
			$liste_dossiers[] = $entree;
		}
		closedir($dossier_ouvert);
		sort($liste_dossiers);
		$count = count($liste_dossiers);
		// Affichage du tableau contenant la liste des dossiers
		for ($nb = 0; $nb <= $count ; $nb++)
		{
			$dossier_url = $dossier.$liste_dossiers[$nb].'/';
			if (@is_dir($dossier_url) AND $liste_dossiers[$nb] != '.' AND $liste_dossiers[$nb] != '..' AND $liste_dossiers[$nb] != '.ftp-erqplorer' AND $liste_dossiers[$nb] != NULL)
			{
				echo '<tr><td>';
				// Gestion de la profondeur des alineas
				$profondeur = preg_match_all('#/#', $dossier_url, $tab) - 1;
				for ($i = 0 ; $i < 4*$profondeur ; $i++)
				{
					echo '&nbsp;';
				}

				if (!preg_match("#^$dossier_url#i", $_GET['url']))
				{
					echo '<a href="./index.php?url='.$dossier_url.'"><img src="./.ftp-erqplorer/icones/repertoire.png" alt="[rep]" /> '.$liste_dossiers[$nb].'</a></td></tr>';
				}
				else
				{
					echo '<a href="./index.php?url='.$dossier_url.'" class="dossier_courant"><img src="./.ftp-erqplorer/icones/repertoire_ouvert.png" alt="[rep]" />&nbsp;'.$liste_dossiers[$nb].'</a></td></tr>';
					lister_dossiers($dossier_url);
				}
			}
		}
	}
	else
	{
		die("Inaccessible directory");
	}
}

// Fonction Listant les fichiers du repertoire
function lister_fichiers($dossier)
{
	// Initialisation des variables
	$type = array(' B',' KB',' MB',' GB',' TB');
	$total_taille = 0;
	$total_fichiers = 0;
	if ($dossier_ouvert = @opendir($dossier))
	{
		// Creation du tableau contenant la liste des dossiers
		$liste_fichiers = array();
		while (false !== ($entree = readdir($dossier_ouvert)))
		{
			$liste_fichiers[] = $entree;
		}
		closedir($dossier_ouvert);
		sort($liste_fichiers);
		$count = count($liste_fichiers);
		// Affichage du tableau contenant la liste des fichiers
		for ($nb = 0; $nb <= $count ; $nb++)
		{
			$fichier_url = $dossier.$liste_fichiers[$nb];
			if (@is_file($fichier_url) AND !preg_match("#^./.ftp-erqplorer#i", $fichier_url) AND $fichier_url != './index.php' AND $fichier_url != './.htaccess')
			{
				$total_fichiers++;
				// Traitement des icones
				if (preg_match('#^.+[.](.+)$#i', $liste_fichiers[$nb], $tableau))
				{
					$extension = strtolower($tableau['1']);
					$url_image = './.ftp-erqplorer/icones_extensions/'.$extension.'.png';
					if (!file_exists($url_image))
					{
						$url_image = './.ftp-erqplorer/icones_extensions/unknow.png';
					}
				}
				$icone = '<img src="'.$url_image.'" alt="['.$extension.']" /> ';
				// Traitement de la taille la plus adaptee
				if (!$taille = filesize($fichier_url))
				{
					$taille = 'Unknow';
				}
				else
				{
					$total_taille = $total_taille + $taille;
					for ($i=0 ;($taille/1024)>1 AND i<4 ; $i++)
					{
						$taille /= 1024;
					}
					// Traitement des decimales
					$tab = explode(".", $taille);
					if ($tab[0] != $taille)
					{
						$taille = number_format($taille, 2, '.', ' ');
					}
				}
				// Traitement de la date de derniere modification
				$date = filemtime($fichier_url);
				$date = date('d/m/y - H:i:s', $date);
				// Affichage
				echo '	<tr class="fichier">
							<td class="fichiers_icone">'.$icone.'</td>
							<td><a href="'.$fichier_url.'">'.$liste_fichiers[$nb].'</a></td>
							<td class="fichiers_taille">'.$taille.'</td>
							<td class="fichiers_taille_2">'.$type[$i].'</td>
							<td class="fichiers_modification">'.$date.'</td>
						</tr>';
			}
		}
		// Affichage de la derniere ligne du tableau(taille totale et nombre de fichiers)
		for ($i=0; ($total_taille / 1024) > 1 AND i < 4; $i++)
		{
			$total_taille /= 1024;
		}
		// Traitement des decimales
		$tab = explode(".", $total_taille);
		if ($tab[0] != $total_taille)
		{
			$total_taille = number_format($total_taille, 2, '.', ' ');
		}
		echo '	<tr>
					<td colspan="2" class="sous_titre">'.$total_fichiers.' files</td>
					<td class="fichiers_total_taille">'.$total_taille.'</td>
					<td class="fichiers_total_taille_2">'.$type[$i].'</td>
					<td class="sous_titre"></td>
				</tr>';
	}
	else // Si l'utilisateur entre une adresse incorrecte
	{
		echo '<div class="erreur">Error : Inaccessible directory</div>';
	}
}

// fonction enregistrant dans un "select" un certain nombre de fichiers
function list_select($extension, $chemin, $nom_liste)
{
	echo '<p><select name="'.$nom_liste.'">';
	if ($dossier_ouvert = opendir($chemin))
	{
		while (false !== ($entree = readdir($dossier_ouvert)))
		{
			if (preg_match("#^(.+)[.]$extension$#i", $entree, $tab))
			{
				echo '<option value="'.$tab[1].'">'.$tab[1].'</option>';
			}
		}
		closedir($dossier_ouvert);
	}
	echo '</select></p>';
}

?>
