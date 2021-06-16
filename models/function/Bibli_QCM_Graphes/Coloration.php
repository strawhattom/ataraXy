<?php

	$clef = "ColorationGrapheStandard";
	$liste_AutoQCM[$clef]="Demande le nombre chromatique d'un graphe standard";
	$secte_AutoQCM[$clef]="Graphes";
	function ColorationGrapheStandard(){
		$n=2*mt_rand(50,5000)+1;
		$X=array("de $\\Kk_{".$n."}$, la clique à ".$n." sommets", "de $\Zz_{".$n."}$, le cycle à ".$n." sommets", "de $\\Cc_{".$n."}$, la chaine à ".$n." arêtes");
		$res=array($n,3,2);
		$x=range(0,2);
		shuffle($x);shuffle($x);shuffle($x);
		
		$question="Quel est le nombre chromatique ".$X[$x[0]];
		$rep ="\\reponsejuste ".$res[$x[0]];
		$rep.="\\reponse ".$res[$x[1]];
		$rep.="\\reponse ".$res[$x[2]];
		
		return $question.$rep;
	}
	
	$clef = "AvecBrelaz";
	$liste_AutoQCM[$clef]="Demande d'appliquer l'algo de Brelaz pour déterminer une borne du nombre chromatique";
	$secte_AutoQCM[$clef]="Graphes";
	function AvecBrelaz(){
		$n=mt_rand(7,13);//dimension
		$aff=mt_rand(0,1);//Mode d'affichage
		$AFF=array("la matrice booléenne", "une représentation saggitale");
		$mat=matrice_non_oriente($n);
		
		$question="Soit $\\G$ le graphe non orienté dont ".$AFF[$aff]." est ";
		if($aff==0) $question.="$$".dessine_mat($mat)."$$";
		else $question.="$$".dessinegraphenonoriente($mat)."$$";
		$question.="En appliquant l'algorithme de Brelaz, on trouve que le nombre chromatique $ X(\\G)$ du graphe $\\G$ est majoré par";
		$rep="";
		$X=array(1, -1, 2, -2);
		$x=array_rand($X);
		$b=NbCoulBrelaz($mat);
		$rep.="\\reponsejuste ".$b;
		$rep.="\\reponse ".($b+$X[$x]);
			
		return $question.$rep;
	}
	
	
	$clef = "AlgoDeBrelaz";
	$liste_AutoQCM[$clef]="Fait tourner l'algo de Brelaz";
	$secte_AutoQCM[$clef]="Graphes";
	function AlgoDeBrelaz(){
		$n=mt_rand(7,13);//dimension
		$aff=mt_rand(0,1);//Mode d'affichage
		$aff=0; //trop dure sinon
		$AFF=array("la matrice booléenne", "une représentation saggitale");
		$mat=matrice_non_oriente($n);
		
		$question="Soit $\\G$ le graphe non orienté dont ".$AFF[$aff]." est ";
		if($aff==0) $question.="$$".dessine_mat($mat)."$$";
		else $question.="$$".dessinegraphenonoriente($mat)."$$";
		
		
		$question.="En appliquant l'algorithme de Brelaz comme nous l'avons vu en cours, qu'elle est le tableau résultant ?";
		
		$rep="";
		$rep.="\\reponsejuste $".AffBrelaz(Brelaz($mat))."$";
		$rep.="\\reponse $".AffBrelaz(AlterBrelaz($mat))."$";
		$rep.="\\reponse $".AffBrelaz(Brelaz(AlterMatNon($mat)))."$";
		
		return $question.$rep;
	}
	
	$clef = "GraphePlanaire";
	$liste_AutoQCM[$clef]="Demande de séléctionner des graphes planaires";
	$secte_AutoQCM[$clef]="Graphes";
	function GraphePlanaire(){
	
		$question="Séléctionner les graphes planaires.";
		
		$repoui = array();
		do{
			$mat = matrice_non_oriente(8);
			//On rajoute des 0 sinon c'est rarement planaire
			for($i=0 ; $i<8/2 ; $i++){
				$a=mt_rand(0,7);$b=mt_rand(0,7);
				$mat[$a][$b]=0;
				$mat[$b][$a]=0;
			}
		}while(TrouveCliqueDedansNon($mat)>5);
		$repoui[0] = "\\reponsejuste $".dessine_mat($mat)."$";
		$X=array("\\Kk", "\\Cc", "\Zz");
		$repoui[1] = "\\reponsejuste $".$X[array_rand($X)]."_{".mt_rand(2,4)."}$";
		$X=array("\\Cc", "\Zz");
		$repoui[2] = "\\reponsejuste $".$X[array_rand($X)]."_{".rand(3,7)."}$";
		$rep=$repoui[0].$repoui[1].$repoui[2];
		$rep.="\\reponse $\Kk_{".mt_rand(5,9)."}$";
		$rep.="\\reponse $".dessine_mat(matrice_non_oriente_avec_clique(8, 5))."$";
		return $question.$rep;
	}
?>