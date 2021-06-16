<?php

	$clef = "NombreCouche";
	$liste_AutoQCM[$clef]="Demande le nombre de couche d'un graphe";
	$secte_AutoQCM[$clef]="Graphes";
	function NombreCouche(){
	
		$n=mt_rand(7,11);
		$mat=geneR_ss_circuit($n);
		
		$question="Considérons le graphe $\\G$ dont la matrice booléene est ";
		$question.="$$".dessine_mat($mat)."$$";		
		$question.="Ce graphe est sans circuit et admet donc une décomposition en couche. De combien de couche est-il composé ?";
		
		$X=Filtration_sources($mat);
		$nb_source=count($X[1]);
		
		$X=array(-3, -2, -1, 1, 2, 3);shuffle($X);
		
		if($nb_source>=3) $rep="
			\\reponsejuste ".$nb_source."
			\\reponse ".($nb_source+$X[0])."
			\\reponse ".($nb_source+$X[1])."
			\\reponse ".($nb_source+$X[3])."
			\\reponse ".($nb_source+$X[5])."
			";
		else $rep="
			\\reponsejuste ".$nb_source."
			\\reponse ".($nb_source-1)."
			\\reponse ".($nb_source+1)."
			\\reponse ".($nb_source+2)."
			\\reponse Aucune de ces réponses
			";
		return $question.$rep;
	}
	
	$clef = "QuiDansCouche";
	$liste_AutoQCM[$clef]="Demande les sommets dans une couche";
	$secte_AutoQCM[$clef]="Graphes";
	function QuiDansCouche(){
		
		global $alphabet;
		
		$n=mt_rand(7,11);
		$mode=mt_rand(0, 1); //0=sources, 1=puits
		$MODE=array(" src ", " pts ");
		$MODE2=array(" source ", " puits ");
		$mat=geneR_ss_circuit($n);
		if($mode==0) $X=Filtration_sources($mat);
		else $X=Filtration_puits($mat);

		$src=$X[1];
		$nb_source=count($src);
		$num_source=mt_rand(0,$nb_source-1);
		
		$question="Considérons le graphe $\\G$ dont la matrice booléene est ";
		$question.="$$".dessine_mat($mat)."$$";		
		$question.="Ce graphe est sans circuit et admet donc une décomposition en (".$nb_source.") couches. 
		De quel(s) sommet(s) est composé $ ".$MODE[$mode]."_{".($num_source+1)."}$ 
		le ".($num_source+1);
		if($num_source==0) $question.="<sup>er</sup> niveau de ".$MODE2[$mode]."?";
		elseif($num_source==1) $question.="<sup>nd</sup> niveau de ".$MODE2[$mode]."?";
		else $question.="<sup>ème</sup> niveau de ".$MODE2[$mode]."?";
		$rep="\\reponsejuste $\\{";
		$x=count($src[$num_source]);
		for($i=0 ; $i<$x ; $i++){
			$rep.=$alphabet[$src[$num_source][$i]];
			if($i<$x-1) $rep.=",";
		}
		$rep.="\\}$";
		
		do{$m=mt_rand(0,$nb_source-1);}while($m==$num_source);
		$rep.="\\reponse $\\{";
		$x=count($src[$m]);
		for($i=0 ; $i<$x ; $i++){
			$rep.=$alphabet[$src[$m][$i]];
			if($i<$x-1) $rep.=",";
		}
		$rep.="\\}$";
		
		return $question.$rep;
	}
	
	$clef = "RepresentationMatCouche";
	$liste_AutoQCM[$clef]="Demande la matrice de GN ou N est une bonne numérotation";
	$secte_AutoQCM[$clef]="Graphes";
	function RepresentationMatCouche(){
		
		$n=mt_rand(7,11);
		$mat=geneR_ss_circuit($n);
		$X=Filtration_sources($mat);
		
		$question="Considérons le graphe $\\G$ dont la matrice booléene est ";
		$question.="$$".dessine_mat($mat)."$$";		
		$question.="Ce graphe est sans circuit et admet donc une bonne numérotation $ N$. Quelle est la matrice de $\\G^N$ ?";
		
		//remise en ordre
		$mel=$X[0];
		$mat2=array();
		for($i=0 ; $i<$n ; $i++){
			$mat2[$i]=array();
			for($j=0 ; $j<$n ; $j++) $mat2[$i][$j]=0;
		}
		for($i=0 ; $i<$n ; $i++){
			for($j=0 ; $j<$n ; $j++) $mat2[$mel[$i]][$mel[$j]]=$mat[$i][$j];
		}
		
		
		$rep="\\reponsejuste $".dessine_mat2($mat2)."$";
		$x=mt_rand(0, $n-2);
		$y=mt_rand($x+1, $n-1);
		$mat2[$x][$y]=1-$mat2[$x][$y];
		$rep.="\\reponse $".dessine_mat2($mat2)."$";
		return $question.$rep;
	}
	
	$clef = "ExisteCircuit";
	$liste_AutoQCM[$clef]="Demande si le graphe possède un circuit ou non";
	$secte_AutoQCM[$clef]="Graphes";
	function ExisteCircuit(){
		
		$n=mt_rand(5,11);//dimension
		$aff=mt_rand(0,1);//Mode d'affichage
		$AFF=array("la matrice booléenne", "une représentation saggitale");
		$q=mt_rand(0,1);//Il existe ou il existe pas
		
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
		
		if($q==0){
			$question.="Ce graphe est sans circuit.";
			if(!IsCircuit($mat)) $rep="\\reponsejuste Vrai \\reponse Faux";
			else $rep="\\reponsejuste Faux \\reponse Vrai";
		}
		else{
			$question.="Ce graphe possède un circuit.";
			if(IsCircuit($mat)) $rep="\\reponsejuste Vrai \\reponse Faux";
			else $rep="\\reponsejuste Faux \\reponse Vrai";
		}
		
		return $question.$rep;
	}

?>