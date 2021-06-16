<?php

	$clef = "LecturedeDjikstra";
	$liste_AutoQCM[$clef]="Demande de lire un tableau de Djikstra";
	$secte_AutoQCM[$clef]="Graphes";
	function LecturedeDjikstra(){
	
		global $alphabet;
		$n=mt_rand(6,9);//dimension
		$o=mt_rand(0,1);//Orientation
		$O=array(" non orienté ", " orienté ");
		$M=mt_rand(5,11);//Borne max de la valuation
		if($o==0) $mat=matrice_non_oriente_val($n, $M);
		else $mat=matrice_oriente_val($n, $M);
		
		$a=mt_rand(0, $n-1);
		$question="Dans un graphe ".$O[$o]." valué on a appliqué l'algorithme de Dijkstra et on a obtenu le tableau suivant.";
		$question.="$$".AffDJP(DJP(0,$mat, $a))."$$";
		
		$rep="";
		do{$b=mt_rand(0, $n-1);}while($a==$b);
		$X=PlusCourtChemin($mat, $a, $b);
		$rep.="\\reponsejuste Le plus court chemin partant de $ ".$alphabet[$a]."$ pour arriver à $ ".$alphabet[$b]."$ est de longueur $".$X[1]."$";
		
		if(mt_rand(0,1)==0 and is_int($X[1])){
			if(is_int($X[1])) $rep.="\\reponse Le plus court chemin partant de $ ".$alphabet[$a]."$ pour arriver à $ ".$alphabet[$b]."$ est de longueur $+\\infty$";
			else $rep.="\\reponse Le plus court chemin partant de $ ".$alphabet[$a]."$ pour arriver à $ ".$alphabet[$b]."$ est de longueur $".mt_rand(7,13)."$";
		} 
		else {
			if(is_int($X[1])){
				do{$x=mt_rand(7,13);}while($x==$X[1]);
			}
			else $x=mt_rand(7,13);
			$rep.="\\reponse Le plus court chemin partant de $ ".$alphabet[$a]."$ pour arriver à $ ".$alphabet[$b]."$ est de longueur $".$x."$";
		}
		
		do{$b=mt_rand(0, $n-1);}while($a==$b);
		$X=PlusCourtChemin($mat, $a, $b);
		if($X[0]==""){
			$rep.="\\reponsejuste Il n'y a aucun chemin partant de $ ".$alphabet[$a]."$ pour arriver à $ ".$alphabet[$b]."$";
			$rep.="\\reponse Le plus court chemin partant de $ ".$alphabet[$a]."$ pour arriver à $ ".$alphabet[$b]."$ est $".$alphabet[$a].$alphabet[$b]."$";	
		}
		else{
			$rep.="\\reponsejuste Le plus court chemin partant de $ ".$alphabet[$a]."$ pour arriver à $ ".$alphabet[$b]."$ est $".$X[0]."$";
			if(strlen($X[0])>2){
				//On supprime une valeur dans $X[0]
				$tmp=str_split($X[0]);
				
				$tmp2=array();
				$t=count($tmp);
				
				$c=mt_rand(1, $t-2);//On va supprimer une valeur sauf la première et la dernières
				for($k=0 ; $k<$t ; $k++){
					if($k==$c) continue;
					$tmp2[]=$tmp[$k];
				}
				$tmp=implode($tmp2);
				$rep.="\\reponse Le plus court chemin partant de  $ ".$alphabet[$a]."$ pour arriver à $ ".$alphabet[$b]."$ est $ ".$tmp." $";
			}
			else $rep.="\\reponse Le plus court chemin partant de  $ ".$alphabet[$a]."$ pour arriver à $ ".$alphabet[$b]."$ est $".$alphabet[$b].$alphabet[$a]."$";
		}
		
		return $question.$rep;
	}
	
	
	$clef = "FaireDjikstra";
	$liste_AutoQCM[$clef]="Demande de faire un tableau de Djikstra";
	$secte_AutoQCM[$clef]="Graphes";
	function FaireDjikstra(){
	
		global $alphabet;
		$n=mt_rand(5,9);//dimension
		$o=mt_rand(0,1);//Orientation
		$O=array(" orienté ", " non orienté ");
		$M=mt_rand(5,11);//Borne max de la valuation
		if($o==0) $mat=matrice_non_oriente_val($n, $M);
		else $mat=matrice_oriente_val($n, $M);
		
		$question="Soit $\\G$ le graphe ".$O[$o]." valué dont la matrice booléene augmentée (par la valuation) est";
		$question.="$$".dessine_mat($mat)."$$";		
		
		$a=mt_rand(0, $n-1);
		
		$rep="";
		$b=mt_rand(0, $n-1);
		$X=PlusCourtChemin($mat, $a, $b);
		$rep.="\\reponsejuste Le plus court chemin partant de $ ".$alphabet[$a]."$ pour arriver à $ ".$alphabet[$b]."$ est de longueur $".$X[1]."$";
		if(mt_rand(0,1)==0 and is_int($X[1])) $rep.="\\reponse Le plus court chemin partant de $ ".$alphabet[$a]."$ pour arriver à $ ".$alphabet[$b]."$ est de longueur $+\\infty$";
		else $rep.="\\reponse Le plus court chemin partant de $ ".$alphabet[$a]."$ pour arriver à $ ".$alphabet[$b]."$ est de longueur $".mt_rand(7,13)."$";
		$b=mt_rand(0, $n-1);
		$X=PlusCourtChemin($mat, $a, $b);
		if($X[0]==""){
			$rep.="\\reponsejuste Il n'y a aucun chemin partant de $ ".$alphabet[$a]."$ pour arriver à $ ".$alphabet[$b]."$";
			$rep.="\\reponse Le plus court chemin partant de $ ".$alphabet[$a]."$ pour arriver à $ ".$alphabet[$b]."$ est $".$alphabet[$a].$alphabet[$b]."$";	
		}
		else{
			$rep.="\\reponsejuste Le plus court chemin partant de $ ".$alphabet[$a]."$ pour arriver à $ ".$alphabet[$b]."$ est $".$X[0]."$";
			if(strlen($X[0])>2) $rep.="\\reponse Le plus court chemin partant de  $ ".$alphabet[$a]."$ pour arriver à $ ".$alphabet[$b]."$ est $".$alphabet[$a].$alphabet[$b]."$";
			else $rep.="\\reponse Le plus court chemin partant de  $ ".$alphabet[$a]."$ pour arriver à $ ".$alphabet[$b]."$ est $".$alphabet[$b].$alphabet[$a]."$";
		}
		
		return $question.$rep;
	}
	
	$clef = "TrouveDjikstra";
	$liste_AutoQCM[$clef]="Demande de trouver un tableau de Djikstra";
	$secte_AutoQCM[$clef]="Graphes";
	function TrouveDjikstra(){
	
		global $alphabet;
		$n=mt_rand(5,9);//dimension
		$o=mt_rand(0,1);//Orientation
		$O=array(" orienté ", " non orienté ");
		$M=mt_rand(5,11);//Borne max de la valuation
		if($o==0) $mat=matrice_non_oriente_val($n, $M);
		else $mat=matrice_oriente_val($n, $M);
		$a=mt_rand(0, $n-1);//Sommet de départ
		
		$question="Soit $\\G$ le graphe ".$O[$o]." valué dont la matrice booléene augmentée (par la valuation) est";
		$question.="$$".dessine_mat($mat)."$$";		
		$question.="Quel tableau correspond au tableau résultant de l'application de l'algorithme de Dijkstra partant du sommet $ ".$alphabet[$a]."$ ?";
		$rep="";
		$rep.="\\reponsejuste $".AffDJP(DJP(0, $mat, $a))."$";
		if($o==0) $mat=matrice_non_oriente_val($n, $M);
		else $mat=matrice_oriente_val($n, $M);
		$rep.="\\reponse $".AffDJP(AlterDJP(1, $mat, $a))."$";
		$rep.="\\reponse $".AffDJP(AlterDJP(0, $mat, $a))."$";
		
		return $question.$rep;
	}

?>