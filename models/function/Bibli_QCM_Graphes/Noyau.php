<?php

	$clef = "ExisteNoyau";
	$liste_AutoQCM[$clef]="Demande si le graphe possède un noyau ou non";
	$secte_AutoQCM[$clef]="Graphes";
	function ExisteNoyau(){
		
		$n=mt_rand(5,11);//dimension
		$aff=mt_rand(0,1);//Mode d'affichage
		$AFF=array("la matrice booléenne", "une représentation saggitale");
		
		$mat=array();
		for($i=0 ; $i<$n ; $i++){
			$mat[$i]=array();
			for($j=0 ; $j<=$i ; $j++) $mat[$i][$j]=0;
			for($j=$i+1 ; $j<$n ; $j++) $mat[$i][$j]=mt_rand(0,1);
		}	
		for($k=0 ; $k<1 ; $k++) $mat[mt_rand(0,$n-1)][mt_rand(0,$n-1)]=1;
		
		$mel=range(0, $n-1);
		shuffle($mel);shuffle($mel);shuffle($mel);
		$_mat=$mat;
		for($i=0 ; $i<$n ; $i++){
			for($j=0 ; $j<$n ; $j++) $mat[$i][$j]=$_mat[$mel[$i]][$mel[$j]];
		}
		
		
		$question="Soit $\\G$ le graphe orienté dont ".$AFF[$aff]." est ";
		if($aff==0) $question.="$$".dessine_mat($mat)."$$";
		else $question.="$$".dessinegrapheoriente($mat)."$$";
				
		$question.="Il existe un noyau dans ce graphe.";
		if(IsCircuit($mat)) $rep="\\reponsejuste Faux \\reponse Vrai";
		else $rep="\\reponsejuste Vrai \\reponse Faux";
	
		return $question.$rep;
	}
	
	$clef = "TrouveNoyau";
	$liste_AutoQCM[$clef]="Demande de déterminer le noyau.";
	$secte_AutoQCM[$clef]="Graphes";
	function TrouveNoyau(){
		
		global $alphabet;
		
		$n=mt_rand(5,9);//dimension
		$aff=mt_rand(0,1);//Mode d'affichage
		$AFF=array("la matrice booléenne", "une représentation saggitale");
		$mat=array();
		for($i=0 ; $i<$n ; $i++){
			$mat[$i]=array();
			for($j=0 ; $j<=$i ; $j++) $mat[$i][$j]=0;
			for($j=$i+1 ; $j<$n ; $j++) $mat[$i][$j]=mt_rand(0,1);
		}
		
		$mel=range(0, $n-1);
		shuffle($mel);shuffle($mel);shuffle($mel);
		$_mat=$mat;
		for($i=0 ; $i<$n ; $i++){
			for($j=0 ; $j<$n ; $j++) $mat[$i][$j]=$_mat[$mel[$i]][$mel[$j]];
		}
		
		
		$question="Soit $\\G$ le graphe orienté dont ".$AFF[$aff]." est ";
		if($aff==0) $question.="$$".dessine_mat($mat)."$$";
		else $question.="$$".dessinegrapheoriente($mat)."$$";
				
		$question.="Quel est son noyau ?";		
		$rep="";
		
		$rep.="\\reponsejuste $\\{";
		$X=Noyau($mat);
		$n=count($X);
		for($x=0 ; $x<$n ; $x++){
			$rep.=$alphabet[$X[$x]];
			if($x<$n-1) $rep.=",";
		}
		$rep.="\\}$";
		
		$rep.="\\reponse $\\{";
		$X=AlterNoyau($mat);
		$n=count($X);
		for($x=0 ; $x<$n ; $x++){
			$rep.=$alphabet[$X[$x]];
			if($x<$n-1) $rep.=",";
		}
		$rep.="\\}$";
		$rep.="\\reponse $\\{";
		$X=AlterNoyau($mat);
		$n=count($X);
		for($x=0 ; $x<$n ; $x++){
			$rep.=$alphabet[$X[$x]];
			if($x<$n-1) $rep.=",";
		}
		$rep.="\\}$";
	
		return $question.$rep;
	}
	
?>