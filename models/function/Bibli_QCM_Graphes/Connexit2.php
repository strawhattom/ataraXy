<?php

	$clef = "CompoCnx";
	$liste_AutoQCM[$clef]="Calcul de composante connexe";
	$secte_AutoQCM[$clef]="Graphes";
	function CompoCnx(){
		
		global $alphabet;
		
		$n=mt_rand(4,7);//dimension
		$o=mt_rand(0,1);//Orientation
		$O=array("orienté", "non orienté");
		$aff=mt_rand(0,1);//Mode d'affichage
		$AFF=array("la matrice booléenne", "une représentation saggitale");
		
		//Matrice
		if($o==0) $mat=matrice_oriente($n);
		else $mat=matrice_non_oriente($n);
		
		//On rajoute des 0 parce que sinon le graphe est connexe
		$tmp=2*$n+1;
		for($i=0 ; $i<$tmp ; $i++){
			$a=mt_rand(0,$n-1);
			$b=mt_rand(0,$n-1);
			$mat[$a][$b]=0;
			if($o==1) $mat[$b][$a]=0;
		}
		
		
		$question="Soit $\\G$ le graphe ".$O[$o]." dont ".$AFF[$aff]." est ";
		if($aff==0) $question.="$$".dessine_mat($mat)."$$";
		else{
			if($o==0) $question.="$$".dessinegrapheoriente($mat)."$$";
			else $question.="$$".dessinegraphenonoriente($mat)."$$";
		}
		
		$rep="";
		$x=mt_rand(0,$n-1);
		$tmp = ComposanteCnx($mat,$x);
		$rep.="\\reponsejuste $ CC(".$alphabet[$x].", \\G)$ est le sous-graphe engendré par $\\{".implode(',',$tmp)."\\}$";
		$rep.="\\reponse $ CC(".$alphabet[$x].", \\G)$ est le sous-graphe engendré par $\\{".implode(',',alter_gamma($tmp, $n))."\\}$";
		
		return $question.$rep;
	}	
	
	$clef = "IsCnx";
	$liste_AutoQCM[$clef]="demande si le graphe est connexe";
	$secte_AutoQCM[$clef]="Graphes";
	function IsCnx(){
		
		global $alphabet;
		
		$n=mt_rand(4,7);//dimension
		$o=mt_rand(0,1);//Orientation
		$O=array("orienté", "non orienté");
		$aff=mt_rand(0,1);//Mode d'affichage
		$AFF=array("la matrice booléenne", "une représentation saggitale");
		
		//Matrice
		if($o==0) $mat=matrice_oriente($n);
		else $mat=matrice_non_oriente($n);
		
		//On rajoute des 0 parce que sinon le graphe est trop souvent connexe
		$tmp=2*$n+1;
		for($i=0 ; $i<$tmp ; $i++){
			$a=mt_rand(0,$n-1);
			$b=mt_rand(0,$n-1);
			$mat[$a][$b]=0;
			if($o==1) $mat[$b][$a]=0;
		}
		
		
		$question="Soit $\\G$ le graphe ".$O[$o]." dont ".$AFF[$aff]." est ";
		if($aff==0) $question.="$$".dessine_mat($mat)."$$";
		else{
			if($o==0) $question.="$$".dessinegrapheoriente($mat)."$$";
			else $question.="$$".dessinegraphenonoriente($mat)."$$";
		}
		
		$rep="";
		$tmp = ComposanteCnx($mat,0);
		if(count($tmp)==$n){
			$rep.="\\reponsejuste Le graphe est connexe";
			$rep.="\\reponse Le graphe n'est pas connexe";
		}
		else{
			$rep.="\\reponsejuste Le graphe n'est pas connexe";
			$rep.="\\reponse Le graphe est connexe";
		}
		
		return $question.$rep;
	}	
	
	
	$clef = "CompoCnxForte";
	$liste_AutoQCM[$clef]="Calcul de composante connexe forte";
	$secte_AutoQCM[$clef]="Graphes";
	function CompoCnxForte(){
		
		global $alphabet;
		
		$n=mt_rand(4,7);//dimension
		$aff=mt_rand(0,1);//Mode d'affichage
		$AFF=array("la matrice booléenne", "une représentation saggitale");
		
		//Matrice
		$mat=matrice_oriente($n);
		
		$tmp=2*$n+1;
		for($i=0 ; $i<$tmp ; $i++){
			$a=mt_rand(0,$n-1);
			$b=mt_rand(0,$n-1);
			$mat[$a][$b]=0;
		}
		
		
		$question="Soit $\\G$ le graphe orienté dont ".$AFF[$aff]." est ";
		if($aff==0) $question.="$$".dessine_mat($mat)."$$";
		else $question.="$$".dessinegrapheoriente($mat)."$$";
		
		$rep="";
		$x=mt_rand(0,$n-1);
		$tmp = CalculCCF($mat, $x);
		$rep.="\\reponsejuste $ CCF(".$alphabet[$x].", \\G)$ est le sous-graphe engendré par $\\{".implode(',',$tmp)."\\}$";
		$rep.="\\reponse $ CCF(".$alphabet[$x].", \\G)$ est le sous-graphe engendré par $\\{".implode(',',alter_gamma($tmp, $n))."\\}$";
		
		return $question.$rep;
	}	
	
	$clef = "NbCompoCnxForte";
	$liste_AutoQCM[$clef]="Calcul du nombre de composante connexe forte";
	$secte_AutoQCM[$clef]="Graphes";
	function NbCompoCnxForte(){
		
		global $alphabet;
		
		$n=mt_rand(4,7);//dimension
		$aff=mt_rand(0,1);//Mode d'affichage
		$AFF=array("la matrice booléenne", "une représentation saggitale");
		
		//Matrice
		$mat=matrice_oriente($n);
		
		$tmp=2*$n+1;
		for($i=0 ; $i<$tmp ; $i++){
			$a=mt_rand(0,$n-1);
			$b=mt_rand(0,$n-1);
			$mat[$a][$b]=0;
		}
		
		
		$question="Soit $\\G$ le graphe orienté dont ".$AFF[$aff]." est ";
		if($aff==0) $question.="$$".dessine_mat($mat)."$$";
		else $question.="$$".dessinegrapheoriente($mat)."$$";
		$question.="Quel est le nombre de sommet du graphe réduit ?";
		
		$x=count(CalculGRed($mat));
		$rep="";
		$rep.="\\reponsejuste ".$x;
		if($x<$n) {
			$rep.="\\reponse ".($x+mt_rand(1,$n-$x));
			if($x>1) $rep.="\\reponse ".($x-mt_rand(1,$x-1));
			else $rep.="\\reponse ".$n;
		}
		else {
			$rep.="\\reponse ".($x-1);
			$rep.="\\reponse ".($x-2);
		}
		return $question.$rep;
	}	
	
	$clef = "DessinGRed";
	$liste_AutoQCM[$clef]="Demande de faire le calcul de du graphe réduit.";
	$secte_AutoQCM[$clef]="Graphes";
	function DessinGRed(){
		
		global $alphabet;
		
		$n=mt_rand(4,7);//dimension
		$aff=mt_rand(0,1);//Mode d'affichage
		$AFF=array("la matrice booléenne", "une représentation saggitale");
		
		//Matrice
		$mat=matrice_oriente($n);
		
		$tmp=2*$n+1;
		for($i=0 ; $i<$tmp ; $i++){
			$a=mt_rand(0,$n-1);
			$b=mt_rand(0,$n-1);
			$mat[$a][$b]=0;
		}
		
		$liste_somm=array();
		$CCF=array();
		while(count($liste_somm)<$n){
			//Recherche d'un somment
			$i=0;
			while($i<$n){
				if(!in_array($alphabet[$i],$liste_somm)) {
					$x=$i;
					break;
				}
				$i++;
			}
			$X = CalculCCF($mat, $x);
			$CCF[]=$X;
			$liste_somm=array_merge($liste_somm, $X);
		}
		
		//Calcul de la matrice 
		$N=count($CCF);
		$matRed=array();
		for($i=0 ; $i<$N ; $i++){
			$matRed[$i]=array();
			for($j=0 ; $j<$N ; $j++){
				$matRed[$i][$j]=0;
				for($a=0 ; $a<$n and $matRed[$i][$j]==0 ; $a++){
					for($b=0 ; $b<$n and $matRed[$i][$j]==0; $b++){
						if(in_array($alphabet[$a], $CCF[$i]) and in_array($alphabet[$b], $CCF[$j]) and $mat[$a][$b]==1) $matRed[$i][$j]=1;
					}
				}
			}
		}
		
		$question="Soit $\\G$ le graphe orienté dont ".$AFF[$aff]." est ";
		if($aff==0) $question.="$$".dessine_mat($mat)."$$";
		else $question.="$$".dessinegrapheoriente($mat)."$$";
		
		$question.="Le graphe réduit est composé de ".$N." sommets. On note ";
		for($i=0 ; $i<$N ; $i++) $question.=" $ ".$alphabet[$i]."=CCF(".$CCF[$i][0].",\\G)=\{".implode(',', $CCF[$i])."\}$, ";
		$question.=" avec ces notations, quelle est la représentation matricielle de $\\G_{red}$, le graphe réduit de $\\G$ ?".
		
		$rep="";
		$rep.="\\reponsejuste $".dessine_mat($matRed)."$";
		$a=mt_rand(0,$N-1);
		$b=mt_rand(0,$N-1);
		$matRed[$a][$b]=1-$matRed[$a][$b];
		$rep.="\\reponse $".dessine_mat($matRed)."$";
		
		return $question.$rep;
	}	
	
?>