<?php
	$clef = "EtatInitFin";
	$liste_AutoQCM[$clef]="Demande l'état initial ou final d'un automate.";
	$secte_AutoQCM[$clef]="Graphes";
	function EtatInitFin(){
		
		global $alphabet;
		
		//Nombre d'état
		$n=mt_rand(5,9);
		//Etat
		$Etat=array();
		for($i=0 ; $i<$n ; $i++) $Etat[]=$alphabet[$i];
		//Deterministe
		$d=mt_rand(0,1);
		$D=array("AEF ", "ADEF ");
		//Initiale ou finale
		$iof=mt_rand(1,2);
		$IOF=array(" initial(initiaux)", " final(finaux)");
		//Alplhabet
		$Sigma=GenAlphabet();
		
		if($d==0) $auto=GenAEF($n, $Sigma);
		else $auto=GenADEF($n, $Sigma);
		$MAT=$auto[0];
		
		$question="Considérons l'".$D[$d]." suivant $$".AffAutomate($auto, $Sigma, $Etat)."$$ Séléctionner l(es)'état(s) ".$IOF[$iof-1].".";
		
		$rep="";
		$rep.="\\reponsejuste $ ".$alphabet[$auto[$iof][0]]." $";
		do{$y=mt_rand(0, $n-1);}while(in_array($y,$auto[$iof]));
		$rep.="\\reponse $ ".$alphabet[$y]." $";
		do{$y=mt_rand(0, $n-1);}while(in_array($y,$auto[$iof]));
		$rep.="\\reponse $ ".$alphabet[$y]." $";
		return $question.$rep;
	}
	
	
	$clef = "AutoDet";
	$liste_AutoQCM[$clef]="Demande le déterminisé de l'automate";
	$secte_AutoQCM[$clef]="Graphes";
	function AutoDet(){
		
		global $alphabet;
		
		//Nombre d'état
		$n=mt_rand(3,4);
		//Etat
		$Etat=array();
		for($i=0 ; $i<$n ; $i++) $Etat[]=$alphabet[$i];
		//Alplhabet
		$Sigma=GenAlphabet();
		//Automate
		$AEF=GenAEF($n, $Sigma, 1);
		$AEF2=GenAEF($n, $Sigma, 1);
		
		$question="Considérons l'AEF suivant $$".AffAutomate($AEF, $Sigma, $Etat)."$$ L'automate déterminste associé est :";
		
		$Adet = AlgoDeter($AEF, $n, $Sigma);
		$Adet2 = AlgoDeter($AEF2, $n, $Sigma);
		$X=$Adet[1];
		$Y=$Adet2[1];
		
		$Etat2=array();
		foreach($X as $x){
			$tmp="\\{";
			$c=count($x);
			for($i=0 ; $i<$c ; $i++){
				$tmp.=$Etat[$x[$i]];
				if($i<$c-1) $tmp.=", ";
			}
			$tmp.="\\}";
			$Etat2[]=$tmp;
		}
		
		$Etat22=array();
		foreach($Y as $x){
			$tmp="\\{";
			$c=count($x);
			for($i=0 ; $i<$c ; $i++){
				$tmp.=$Etat[$x[$i]];
				if($i<$c-1) $tmp.=", ";
			}
			$tmp.="\\}";
			$Etat22[]=$tmp;
		}
		
		$rep="";
		$rep.="\\reponsejuste $ ".AffAutomate($Adet[0], $Sigma, $Etat2)." $";
		$rep.="\\reponse $ ".AffAutomate($Adet2[0], $Sigma, $Etat22)." $";
		return $question.$rep;
	}
	
	$clef = "EstComplet";
	$liste_AutoQCM[$clef]="Demande si l'automate est complet";
	$secte_AutoQCM[$clef]="Graphes";
	function EstComplet(){
	
		global $alphabet;
		
		//Nombre d'état
		$n=mt_rand(5,9);
		//Etat
		$Etat=array();
		for($i=0 ; $i<$n ; $i++) $Etat[]=$alphabet[$i];
		//Deterministe
		$d=mt_rand(0,1);
		$D=array("AEF ", "ADEF ");
		//Initiale ou finale
		$iof=mt_rand(1,2);
		$IOF=array(" initial(initiaux)", " final(finaux)");
		//Alplhabet
		$Sigma=GenAlphabet();
		
		if($d==0) $auto=GenAEF($n, $Sigma, mt_rand(0,1));
		else $auto=GenADEF($n, $Sigma, mt_rand(0,1));
		$MAT=$auto[0];
		
		$question="Considérons l'".$D[$d]." suivant $$".AffAutomate($auto, $Sigma, $Etat)."$$ S'agit-il d'un automate complet ?";
		
		$rep="";
		if(isComplet($auto)) $rep.="\\reponsejuste Oui \\reponse Non";
		else $rep.="\\reponsejuste Non \\reponse Oui";
		return $question.$rep;
	}
		
?>