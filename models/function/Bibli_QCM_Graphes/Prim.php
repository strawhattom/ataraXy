<?php

	$clef = "LecturedePrim";
	$liste_AutoQCM[$clef]="Demande de lire un tableau de Prim";
	$secte_AutoQCM[$clef]="Graphes";
	function LecturedePrim(){
	
		global $alphabet;
		$n=mt_rand(5,9);//dimension
		$M=mt_rand(5,11);//Borne max de la valuation
		$mat=matrice_non_oriente_val($n, $M);
		$a=mt_rand(0, $n-1);
		
		$question="Dans un graphe non orienté valué on a appliqué l'algorithme de Prim et on a obtenu le tableau suivant.";
		$X=DJP(1,$mat, $a);
		$question.="$$".AffDJP($X)."$$";
		
		$rep="";
		$A=ArbreCouvrant($X);
		shuffle($A);
		if(mt_rand(0,1)==0){
			if(count($A)==0) $rep.="\\reponsejuste Il n'existe pas d'arbre couvrant de poids minimal.";
			else $rep.="\\reponsejuste Il existe un arbre couvrant de poids minimal.";
		}
		else{
			if(count($A)==0) $rep.="\\reponsejuste Il n'existe pas d'arbre couvrant de poids minimal.";
			else $rep.="\\reponsejuste L'arête $ ".$A[0]."$ est une arête appartenant à l'arbre couvrant de poids minimal obtenu à l'aide de cet algorithme.";
		}
		$B=ArbreCouvrantComplementaire($X);
		for($k=0 ; $k<4 ; $k++){
			if(mt_rand(0,2)==0){
				if(count($A)==0) $rep.="\\reponse Il existe un arbre couvrant de poids minimal.";
				else $rep.="\\reponse Il n'existe pas d'arbre couvrant de poids minimal.";
			}
			else{
				shuffle($B);
				$rep.="\\reponse L'arête $ ".$B[0]."$ est une arête appartenant à l'arbre couvrant de poids minimal obtenu à l'aide de cet algorithme.";
			}
		}
		return $question.$rep;
	}
	
	$clef = "ExisteArbre";
	$liste_AutoQCM[$clef]="Demande S'il existe un arbre couvrant de poids minimal.";
	$secte_AutoQCM[$clef]="Graphes";
	function ExisteArbre(){
	
		global $alphabet;
		$n=mt_rand(11,17);//dimension
		$M=mt_rand(50,99);//Borne max de la valuation
		$mat=matrice_non_oriente_val($n, $M);
		
		//On rajoute des 0
		for($i=0 ; $i<$n*$n/2 ; $i++){
			$a=mt_rand(0,$n-1);
			$b=mt_rand(0,$n-1);
			$mat[$a][$b]=0;
			$mat[$b][$a]=0;
		}
		
		$a=mt_rand(0, $n-1);//Point de départ
		
		$question="Soit $\\G$ le graphe non orienté valué dont la matrice booléene augmentée (par la valuation) est";
		$question.="$$".dessine_mat($mat)."$$";		
	
		$rep="";
		if(count(ComposanteCnx($mat,0))==$n){
			$rep.="\\reponsejuste Il existe un arbre couvrant de poids minimal";
			$rep.="\\reponse Il n'existe pas d'arbre couvrant de poids minimal";
		}
		else{
			$rep.="\\reponsejuste Il n'existe pas d'arbre couvrant de poids minimal";
			$rep.="\\reponse Il existe un arbre couvrant de poids minimal";
		}
		
		
		return $question.$rep;
	}
	
	$clef = "TrouvePrim";
	$liste_AutoQCM[$clef]="Demande de trouver un tableau de Prim";
	$secte_AutoQCM[$clef]="Graphes";
	function TrouvePrim(){
	
		global $alphabet;
		$n=mt_rand(5,9);//dimension
		$M=mt_rand(5,11);//Borne max de la valuation
		$mat=matrice_non_oriente_val($n, $M);
		
		$a=mt_rand(0, $n-1);//Sommet de départ
		
		$question="Soit $\\G$ le graphe non-orienté valué dont la matrice booléene augmentée (par la valuation) est";
		$question.="$$".dessine_mat($mat)."$$";		
		$question.="Quel tableau correspond au tableau résultant de l'application de l'algorithme de Prim (partant du sommet $ ".$alphabet[$a]."$) ?";
		$rep="";
		$rep.="\\reponsejuste $".AffDJP(DJP(1, $mat, $a))."$";
		$mat=matrice_non_oriente_val($n, $M);
		$rep.="\\reponse $".AffDJP(AlterDJP(1, $mat, $a))."$";
		$rep.="\\reponse $".AffDJP(AlterDJP(0, $mat, $a))."$";
		
		return $question.$rep;
	}
	
	$clef = "PoidsMinArbre";
	$liste_AutoQCM[$clef]="Demande de trouver le poids minimal de l'arbre couvrant";
	$secte_AutoQCM[$clef]="Graphes";
	function PoidsMinArbre(){
	
		global $alphabet;
		$n=mt_rand(5,9);//dimension
		$M=mt_rand(5,11);//Borne max de la valuation
		$mat=matrice_non_oriente_val($n, $M);
		
		$a=mt_rand(0, $n-1);//Sommet de départ
		
		$question="Soit $\\G$ le graphe non-orienté valué dont la matrice booléene augmentée (par la valuation) est";
		$question.="$$".dessine_mat($mat)."$$";		
		$question.="Quel est le poids de l'arbre couvrant de poids minimal ?";
		$rep="";
		$x=CalculPoids(DJP(1, $mat, $a));
		if($x===""){
			$rep.="\\reponsejuste Il n'existe pas d'arbre couvrant";
			$rep.="\\reponse $".mt_rand(($n-1),$M*($n-1))."$";
			$rep.="\\reponse $".mt_rand(($n-1),$M*($n-1))."$";
		}
		else{
			$rep.="\\reponsejuste $".$x."$";
			do{
				$y=mt_rand(($n-1),$M*($n-1));
			}while($y==$x);
			$rep.="\\reponse $".$y."$";
			$rep.="\\reponse Il n'existe pas d'arbre couvrant";
		}
		
		return $question.$rep;
	}
	
?>