<?php

	//Boules dans les urnes
	$clef = "Boules_urne";
	$liste_AutoQCM[$clef]="Demande de calculer des probas de boule dans une urne";
	$secte_AutoQCM[$clef]="DAEUB";
	function Boules_urne(){
		$nb_n = mt_rand(3,10);
		do{
			$nb_b = mt_rand(5,7);
		}while($nb_n==$nb_b);	
		$nb_t = $nb_n+$nb_b;
		$x=mt_rand(0,1);
		$question = "Une urne contient ".$nb_n." boules noires et ".$nb_b." boules blanches. On tire au hasard une boule dans l'urne. Quelle est la probabilité de tirer une boule ";
		if($x==0) $question.="noire ? ";
		else $question.="blanche ? ";
		
		if($x==0){
			$rep1="\\reponsejuste $\\dfrac{".$nb_n."}{".$nb_t."}$";
			$rep2="\\reponse $\\dfrac{".$nb_b."}{".$nb_t."}$";
			$rep3="\\reponse $\\dfrac{".$nb_n."}{".$nb_b."}$";
		}
		else{
			$rep2="\\reponse $\\dfrac{".$nb_n."}{".$nb_t."}$";
			$rep1="\\reponsejuste $\\dfrac{".$nb_b."}{".$nb_t."}$";
			$rep3="\\reponse $\\dfrac{".$nb_n."}{".$nb_b."}$";
		}
		
		return $question.$rep1.$rep2.$rep3;
	}
	
	//Tableau combinatoire
	function fact($n){//n!
		if($n<=1) return 1;
		return $n*fact($n-1);
	}
	
	function binom($n, $p){//n!/p!(n-p)!
		if($p==$n or $p==0 or $n<=1) return 1;
		if($p<$n and $p>0) return (binom($n-1, $p-1)+binom($n-1,$p));
		return 0;
	}
	
	function arr($n,$p){//n!/(n-p)!
		return fact($p)*binom($n,$p);
	}
	
	$clef = "PB_combi";
	$liste_AutoQCM[$clef]="Problème combiantoire";
	$secte_AutoQCM[$clef]="DAEUB";
	function PB_combi(){
		$n=mt_rand(5,15);
		$p=mt_rand(2,$n);
		$X=array("avec remise", "sans remise (avec l'ordre)", "simultané");
		$Y=$X;
		shuffle($X);shuffle($X);shuffle($X);
		$question="On tire ".$p." boules dans une urne qui en contient ".$n.". Combien y a-t'il de tirage ".$X[0]." ?";
		$ac_remise=pow($n,$p);
		$ss_remise_ac_ordre =  arr($n,$p);
		$ss_remise_ss_ordre =  binom($n,$p);
		switch($X[0]){
			case $Y[0] : $reponse="\\reponsejuste ".$ac_remise." \\reponse ".$ss_remise_ac_ordre." \\reponse ".$ss_remise_ss_ordre; break;
			case $Y[1] : $reponse="\\reponsejuste ".$ss_remise_ac_ordre." \\reponse ".$ac_remise." \\reponse ".$ss_remise_ss_ordre; break;
			case $Y[2] : $reponse="\\reponsejuste ".$ss_remise_ss_ordre." \\reponse ".$ac_remise." \\reponse ".$ss_remise_ac_ordre; break;
		}
		
		return $question.$reponse;
	}
	
	$clef = "Lancer_2_d";
	$liste_AutoQCM[$clef]="Sort une question sur le lancer de dé";
	$secte_AutoQCM[$clef]="DAEUB";
	function Lancer_2_d(){
		$X=array("nombre paire", "nombre impaire", "multiple de 3", mt_rand(1,6));
		$Y=$X;
		shuffle($X);shuffle($X);shuffle($X);
		$question="On lance un dé bien équilibré. Quel est la probabilité d'obtenir un ".$X[0]." ?";
		switch($X[0]){
			case $Y[0] : 
			case $Y[1] : $reponse="\\reponsejuste $\\dfrac{1}{2}$ \\reponse $\\dfrac{1}{3}$ \\reponse $\\dfrac{1}{6}$"; break;
			case $Y[2] : $reponse="\\reponsejuste $\\dfrac{1}{3}$ \\reponse $\\dfrac{1}{2}$ \\reponse $\\dfrac{1}{6}$"; break;
			case $Y[3] : $reponse="\\reponsejuste $\\dfrac{1}{6}$ \\reponse $\\dfrac{1}{2}$ \\reponse $\\dfrac{1}{3}$"; break;
		}
		
		return $question.$reponse;
	}
	
		
	$clef = "Porte";
	$liste_AutoQCM[$clef]="Problème combinatoire sur le code d'entrée d'une porte";
	$secte_AutoQCM[$clef]="DAEUB";
	function Porte(){
		$X=array(
			"Il n'y a pas deux fois le même chiffre et que l'ordre ne compte pas", 
			"Il n'y a pas deux fois le même chiffre mais l'ordre compte", 
			"Il peut y avoir des répétitions"
		);
		$Y=$X;
		$chi = mt_rand(3,5);
		$cla = mt_rand(6,9);
		$le2="";
		for($i=0 ; $i<$chi-1 ; $i++) $le2.=($cla-$i)."\\times ";
		$le2.=($cla-$i);
		shuffle($X);shuffle($X);shuffle($X);
		$question="La porte de chez moi s'ouvre avec un code à $ ".$chi."$ chiffres. Les chiffres sont entre $0$ et $".($cla-1)."$. ".$X[0].". Combien de combinaison sont possibles ?";
		switch($X[0]){
			case $Y[0] : $reponse="\\reponsejuste $ C_{".$cla."}^{".$chi."}$ \\reponse $".$le2."$ \\reponse $ {".$cla."}^{".$chi."}$"; break;
			case $Y[1] : $reponse="\\reponsejuste $".$le2."$ \\reponse $ C_{".$cla."}^{".$chi."}$ \\reponse $ {".$cla."}^{".$chi."}$"; break;
			case $Y[2] : $reponse="\\reponsejuste $ {".$cla."}^{".$chi."}$ \\reponse $ C_{".$cla."}^{".$chi."}$ \\reponse $".$le2."$"; break;
		}
		
		return $question.$reponse;
	}
	
	$clef = "Boules_urne2";
	$liste_AutoQCM[$clef]="Calcul de proba de au moins une boule dans une urne";
	$secte_AutoQCM[$clef]="DAEUB";
	function Boules_urne2(){
		
		$ordre=array("avec remise", "sans remise (avec ordre)", "simultané");
		$ordree=$ordre;
		shuffle($ordre);shuffle($ordre);shuffle($ordre);
		$couleur=array("blanche", "noire");
		$couleurr=$couleur;
		shuffle($couleur);shuffle($couleur);shuffle($couleur);
		
		$p=mt_rand(3,7);
		do{
			$x=mt_rand($p+1, 2*$p);
			$y=mt_rand($p+1, 2*$p);
		}while($x==$y);//Un peu dangeureux
		$n=$x+$y;
		
		$question="Une urne contient $".$n."$ boules : $".$x."$ blanches et $".$y."$ noires. On effectue un tirage ".$ordre[0]." de $".$p."$ boules dans l'urne.
		Quelle est la probabilité d'obtenir au moins une boule ".$couleur[0]." ?";
		
		$c=$n;
		switch($couleur[0]){
			case($couleurr[0]) : $c=$y; break;
			case($couleurr[1]) : $c=$x; break;
		}
		
		switch($ordre[0]){
			case($ordree[0]) : 
				$ok="$1-\\dfrac{".$c."^{".$p."}}{".$n."^{".$p."}}$"; 
				$no1="$1-\\dfrac{A_{".$c."}^{".$p."}}{A_{".$n."}^{".$p."}}$";
				$no2="$1-\\dfrac{C_{".$c."}^{".$p."}}{C_{".$n."}^{".$p."}}$";
				break;
			case($ordree[1]) : 
				$no1="$1-\\dfrac{".$c."^{".$p."}}{".$n."^{".$p."}}$"; 
				$ok="$1-\\dfrac{A_{".$c."}^{".$p."}}{A_{".$n."}^{".$p."}}$";
				$no2="$1-\\dfrac{C_{".$c."}^{".$p."}}{C_{".$n."}^{".$p."}}$";
				break;
			case($ordree[2]) : 
				$no2="$1-\\dfrac{".$c."^{".$p."}}{".$n."^{".$p."}}$"; 
				$no1="$1-\\dfrac{A_{".$c."}^{".$p."}}{A_{".$n."}^{".$p."}}$";
				$ok="$1-\\dfrac{C_{".$c."}^{".$p."}}{C_{".$n."}^{".$p."}}$";
				break;
		}
		$no3="$1-\\dfrac{".($n-$c)."^{".$p."}}{".$n."^{".$p."}}$"; 
		$no4="$1-\\dfrac{A_{".($n-$c)."}^{".$p."}}{A_{".$n."}^{".$p."}}$";
		$no5="$1-\\dfrac{C_{".($n-$c)."}^{".$p."}}{C_{".$n."}^{".$p."}}$";
		$reponse = " \\reponsejuste ".$ok;
		$reponse.= " \\reponse ".$no1;
		$reponse.= " \\reponse ".$no2;
		$reponse.= " \\reponse ".$no3;
		$reponse.= " \\reponse ".$no4;
		$reponse.= " \\reponse ".$no5;
		
		return $question.$reponse;
	}
	
	$clef = "ColoriageDisque";
	$liste_AutoQCM[$clef]="Nombre de coloriage différent d'un disque découpé.";
	$secte_AutoQCM[$clef]="DAEUB";
	function ColoriageDisque(){
		do{
			$nb_morceau=mt_rand(4,9);
			$nb_couleur=mt_rand(3,7);
		}while($nb_morceau==$nb_couleur);
		
		$question="On découpe un disque en ".$nb_morceau." parts, comme une pizza, et on colorie chaque part avec ".$nb_couleur." couleurs différentes. Combien y a-t-il de coloriage différent possible ?";
		$reponse="\\reponsejuste $".$nb_morceau."^{".$nb_couleur."}$";
		$reponse.="\\reponse $".$nb_morceau."\\times".$nb_couleur."$";
		$reponse.="\\reponse $".$nb_couleur."^{".$nb_morceau."}$";
		
		return $question.$reponse;
	}
	
	$clef = "Lancer2piece";
	$liste_AutoQCM[$clef]="Lancer de pièce et calcul de proba.";
	$secte_AutoQCM[$clef]="DAEUB";
	function Lancer2piece(){
		$X=array("exactement", "au moins", "au plus");
		$Y=$X;
		shuffle($X);shuffle($X);shuffle($X);
		$question="Quelle est la probabilté d'obtenir ".$X[0]." un face en lancer une pièce de monaie parfaitement équilibrée trois fois de suite ?";
		$reponse="";
		switch($X[0]){
			case($Y[0]) : 
				$reponse.="\\reponsejuste $\\dfrac{3}{8}$";
				$reponse.="\\reponse $\\dfrac{7}{8}$";
				$reponse.="\\reponse $\\dfrac{4}{8}$";
			break;
			case($Y[1]) : 
				$reponse.="\\reponsejuste $\\dfrac{7}{8}$";
				$reponse.="\\reponse $\\dfrac{3}{8}$";
				$reponse.="\\reponse $\\dfrac{4}{8}$";
			break;
			case($Y[2]) : 
				$reponse.="\\reponsejuste $\\dfrac{4}{8}$";
				$reponse.="\\reponse $\\dfrac{3}{8}$";
				$reponse.="\\reponse $\\dfrac{7}{8}$";
			break;
		}
		return $question.$reponse;
	}
	
?>