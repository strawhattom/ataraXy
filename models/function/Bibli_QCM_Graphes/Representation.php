<?php

	
	/****************************************
				Graphes standards
	****************************************/
	
	$clef = "Identifie_graphe_standard";
	$liste_AutoQCM[$clef]="Demande d'identifier un graphe standard";
	$secte_AutoQCM[$clef]="Graphes";
	function Identifie_graphe_standard(){
		$type=array('cycle', 'chaine', 'clique');
		$orie=array('', 'non');
		shuffle($type);shuffle($type);shuffle($type);
		shuffle($orie);shuffle($orie);shuffle($orie);
		$n=mt_rand(4,7);
		$question="";
		$reponses="";
		switch($type[0]){
			case 'clique':
				$question.="Déterminer la matrice booléenne de $\Kk_{".$n."}$ la clique ".$orie[0]." orienté à $".$n."$ sommets.";
			break;
			case 'cycle':
				$question.="Déterminer la matrice booléenne de $\Zz_{".$n."}$ le cycle ".$orie[0]." orienté à $".$n."$ sommets.";
			break;
			case 'chaine':
				$question.="Déterminer la matrice booléenne de $\Cc_{".$n."}$ la chaine ".$orie[0]." orienté à $".($n-1)."$ arêtes.";
			break;
		}
		foreach($type as $t){
			foreach($orie as $o){
				$nom=$t.$o;
				if($nom==$type[0].$orie[0]) $reponses.="\\reponsejuste ";
				else $reponses.="\\reponse ";
				$reponses.= "$$".dessine_mat($nom($n))."$$\n";
			}
		}
		return $question.$reponses;
	}
	
	/****************************************
					Cas Orienté
	****************************************/
	
	$clef = "Trouve_representation_sag_oriente_facile";
	$liste_AutoQCM[$clef]="Demande d'identifier la représentation saggitale à partir de la matrice d'un graphe orienté - 3 sommets";
	$secte_AutoQCM[$clef]="Graphes";
	function Trouve_representation_sag_oriente_facile(){
		return Trouve_representation_sag_oriente(3);
	}
	$clef = "Trouve_representation_sag_oriente_moyen";
	$liste_AutoQCM[$clef]="Demande d'identifier la représentation saggitale à partir de la matrice d'un graphe orienté - 4 sommets";
	$secte_AutoQCM[$clef]="Graphes";
	function Trouve_representation_sag_oriente_moyen(){
		return Trouve_representation_sag_oriente(4);
	}
	$clef = "Trouve_representation_sag_oriente_difficile";
	$liste_AutoQCM[$clef]="Demande d'identifier la représentation saggitale à partir de la matrice d'un graphe orienté - 5 sommets";
	$secte_AutoQCM[$clef]="Graphes";
	function Trouve_representation_sag_oriente_difficile(){
		return Trouve_representation_sag_oriente(5);
	}
	
	$clef = "Trouve_representation_mat_oriente_facile";
	$liste_AutoQCM[$clef]="Demande d'identifier la représentation matricielle à partir du graphe - 3 sommets";
	$secte_AutoQCM[$clef]="Graphes";
	function Trouve_representation_mat_oriente_facile(){
		return Trouve_representation_mat_oriente(3);
	}
	$clef = "Trouve_representation_mat_oriente_moyen";
	$liste_AutoQCM[$clef]="Demande d'identifier la représentation matricielle à partir du graphe - 4 sommets";
	$secte_AutoQCM[$clef]="Graphes";
	function Trouve_representation_mat_oriente_moyen(){
		return Trouve_representation_mat_oriente(4);
	}
	$clef = "Trouve_representation_mat_oriente_difficile";
	$liste_AutoQCM[$clef]="Demande d'identifier la représentation matricielle à partir du graphe - 5 sommets";
	$secte_AutoQCM[$clef]="Graphes";
	function Trouve_representation_mat_oriente_difficile(){
		return Trouve_representation_mat_oriente(5);
	}
	
	/****************************************
				Cas Non Orienté
	****************************************/
	
	$clef = "Trouve_representation_sag_non_oriente_facile";
	$liste_AutoQCM[$clef]="Demande d'identifier la représentation saggitale à partir de la matrice d'un graphe non orienté - 3 sommets";
	$secte_AutoQCM[$clef]="Graphes";
	function Trouve_representation_sag_non_oriente_facile(){
		return Trouve_representation_sag_non_oriente(3);
	}
	$clef = "Trouve_representation_sag_non_oriente_moyen";
	$liste_AutoQCM[$clef]="Demande d'identifier la représentation saggitale à partir de la matrice d'un graphe non orienté - 4 sommets";
	$secte_AutoQCM[$clef]="Graphes";
	function Trouve_representation_sag_non_oriente_moyen(){
		return Trouve_representation_sag_non_oriente(4);
	}
	$clef = "Trouve_representation_sag_non_oriente_difficile";
	$liste_AutoQCM[$clef]="Demande d'identifier la représentation saggitale à partir de la matrice d'un graphe non orienté - 5 sommets";
	$secte_AutoQCM[$clef]="Graphes";
	function Trouve_representation_sag_non_oriente_difficile(){
		return Trouve_representation_sag_non_oriente(5);
	}
	
	$clef = "Trouve_representation_mat_non_oriente_facile";
	$liste_AutoQCM[$clef]="Demande d'identifier la représentation matricielle à partir du graphe - 3 sommets";
	$secte_AutoQCM[$clef]="Graphes";
	function Trouve_representation_mat_non_oriente_facile(){
		return Trouve_representation_mat_non_oriente(3);
	}
	$clef = "Trouve_representation_mat_non_oriente_moyen";
	$liste_AutoQCM[$clef]="Demande d'identifier la représentation matricielle à partir du graphe - 4 sommets";
	$secte_AutoQCM[$clef]="Graphes";
	function Trouve_representation_mat_non_oriente_moyen(){
		return Trouve_representation_mat_non_oriente(4);
	}
	$clef = "Trouve_representation_mat_non_oriente_difficile";
	$liste_AutoQCM[$clef]="Demande d'identifier la représentation matricielle à partir du graphe - 5 sommets";
	$secte_AutoQCM[$clef]="Graphes";
	function Trouve_representation_mat_non_oriente_difficile(){
		return Trouve_representation_mat_non_oriente(5);
	}
	
	/****************************************
				Désorientation
	****************************************/
	
	$clef = "Identifie_desorientation";
	$liste_AutoQCM[$clef]="Demande d'identifier le graphe désorienté d'un graphe orienté";
	$secte_AutoQCM[$clef]="Graphes";
	function Identifie_desorientation(){
		$n=mt_rand(5,8);
		$mat=matrice_oriente($n);
		$question="Considérons le graphe orienté $\G$ de matrice booléenne $$".dessine_mat($mat)."$$";
		$question.="Alors $|\G|=$";
		
		$rep=array();
		$matd1=desorientation($mat);
		$rep[]="\\reponsejuste $".dessine_mat($matd1)."$";
		$rep[]="\\reponsejuste $".dessinegraphenonoriente($matd1)."$";
		
		$matd2=$matd1;
		do{
			$x=mt_rand(0, $n-1); $y=mt_rand(0, $n-1);
		}while($x==$y);//Un peu dangeureux
		$matd2[$x][$y]=1-$matd2[$x][$y];
		$matd2[$y][$x]=1-$matd2[$y][$x];
		$rep[]="\\reponse $".dessine_mat($matd2)."$";
		$rep[]="\\reponse $".dessinegraphenonoriente($matd2)."$";
		
		$matd3=$matd2;
		do{
			$x=mt_rand(0, $n-1); $y=mt_rand(0, $n-1);
		}while($x==$y);//Un peu dangeureux
		$matd3[$x][$y]=1-$matd3[$x][$y];
		$matd3[$y][$x]=1-$matd3[$y][$x];
		do{
			$x=mt_rand(0, $n-1); $y=mt_rand(0, $n-1);
		}while($x==$y);//Un peu dangeureux
		$matd3[$x][$y]=1-$matd3[$x][$y];
		$matd3[$y][$x]=1-$matd3[$y][$x];
		
		$rep[]="\\reponse $".dessine_mat($matd3)."$";
		$rep[]="\\reponse $".dessinegraphenonoriente($matd3)."$";
		$reponses="";
		for($i=0 ; $i<6 ; $i++) $reponses.=$rep[$i];
		
		return $question.$reponses;
	}
?>