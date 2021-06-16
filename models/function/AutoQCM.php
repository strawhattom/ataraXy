<?php
	// بِسْمِ ٱللَّهِ ٱلرَّحْمَٰنِ ٱلرَّحِيمِ
	// Commence par finir ce que tu commences
	
	$liste_AutoQCM=array();
	$secte_AutoQCM=array();
	
	//AutoQCM de graphe
	include("Bibli_QCM_Graphes/Fonctions.php");
	include("Bibli_QCM_Graphes/Representation.php");
	include("Bibli_QCM_Graphes/ChainesChemins.php");
	include("Bibli_QCM_Graphes/Connexit2.php");
	include("Bibli_QCM_Graphes/Degres.php");
	include("Bibli_QCM_Graphes/Coloration.php");
	include("Bibli_QCM_Graphes/Dijkstra.php");
	include("Bibli_QCM_Graphes/Prim.php");
	include("Bibli_QCM_Graphes/Couches.php");
	include("Bibli_QCM_Graphes/Noyau.php");
	include("Bibli_QCM_Graphes/Automates.php");
	
	//AutoQCM pour DAEUB
	include("Bibli_QCM_DAEUB/Calculus.php");
	include("Bibli_QCM_DAEUB/Polynomes.php");
	include("Bibli_QCM_DAEUB/Systemes.php");
	include("Bibli_QCM_DAEUB/Proba.php");
	include("Bibli_QCM_DAEUB/Inequations.php");
	include("Bibli_QCM_DAEUB/Limites.php");
	include("Bibli_QCM_DAEUB/Derives.php");
	include("Bibli_QCM_DAEUB/Trigo.php");
	
	//AutoQCM pour le recrutement APB
	include("Bibli_QCM_APB/Math.php");
	include("Bibli_QCM_APB/Logique.php");
	
	//AutoQCM pour Math discrète
	include("Bibli_QCM_MD/Predicats.php");
	
	//Question à la con pour faire des tests
	$clef = "Age_du_capitaine";
	$liste_AutoQCM[$clef]="Question à la con pour faire des tests";
	function Age_du_capitaine(){
		$question = "Quel est l'age du capitaine ?";
		$age = mt_rand(40, 60); //Tire un nombre au hasard entre 40 et 60
		$rep1 = "\\reponsejuste Exactement ".$age." ans";
		$rep2 = "\\reponse Moins de ".($age-1)." ans";
		$rep3 = "\\reponse Plus de ".($age+10)." ans";		
		return $question.$rep1.$rep2.$rep3;
	}

	
	//Question par défaut en cas d'erreur
	$clef = "Defaut";
	$liste_AutoQCM[$clef]="Fonction par défaut pour gérer les erreurs";
	function Defaut(){
		return "Une erreur est survenue \\reponsejuste Cliquer ici pour gagner \\reponse Cliquer ici pour perdre";
	}
	
	function AutoQCM_question($texte){
	
		//On récupère le nom de la fonction
		$x=strpos($texte, "{",0);
		$y=strpos($texte, "}",0);
		if((bool)$x == false or (bool)$y==false or $y-$x-1<=0) return recup_question(Defaut());
		
		$clef=substr($texte,$x+1,$y-$x-1);
		
		global $liste_AutoQCM;
		if(isset($liste_AutoQCM[$clef])){
			if($_SESSION['AutoQCM'][$clef]['val']==false){
				if(!function_exists($clef)) return recup_question(Defaut());
				$_SESSION['AutoQCM'][$clef]['val']=true;
				$_SESSION['AutoQCM'][$clef]['tex']=$clef();
			}
			return recup_question($_SESSION['AutoQCM'][$clef]['tex']);
		}
		return recup_question(Defaut());
		
	}
	
	function AutoQCM_reponses($texte){
	
		//On récupère le nom de la fonction
		$x=strpos($texte, "{",0);
		$y=strpos($texte, "}",0);
		if((bool)$x == false or (bool)$y==false or $y-$x-1<=0) return recup_reponses(Defaut());
		
		$clef=substr($texte,$x+1,$y-$x-1);
		
		global $liste_AutoQCM;
		if(isset($liste_AutoQCM[$clef])){
			if($_SESSION['AutoQCM'][$clef]['val']==false){
				if(!function_exists($clef)) return recup_reponses(Defaut());
				$_SESSION['AutoQCM'][$clef]['val']=true;
				$_SESSION['AutoQCM'][$clef]['tex']=$clef();
			}
			return recup_reponses($_SESSION['AutoQCM'][$clef]['tex']);
		}
		return recup_reponses(Defaut());
		
	}
	
?>