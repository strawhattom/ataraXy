<?php
	
	$clef = "Enigme1";
	$liste_AutoQCM[$clef]="Enigme des formes bilinéaires";
	$secte_AutoQCM[$clef]="Recrutement";
	function Enigme1(){
	
		$n=mt_rand(5,8);
		do{
			$k=mt_rand(1,4);
			$l=mt_rand(2,4);
		}while($k==$l);
		$ou=array("A la ferme, ", "Dans une pièce, ", "En examen, ");
		$qui=array(" poules ", " chats  ", " élèves ");
		$act=array(" pondre ", " manger ", " résoudre ");
		$act2=array(" pondus ", " mangées ", " résolus ");
		$quoi=array(" oeufs ", " souris ", " problèmes ");
		
		$choix = mt_rand(0,2);//les 3 catégories (poules, chats, élèves);
		$question=$ou[$choix].$n.$qui[$choix]." vont ".$act[$choix].$n.$quoi[$choix]." en ".$n." minutes.";
		//Donc 1 'qui' peut 'act' 1 'quoi' en n minutes
		//Donc 1 'qui' peut 'act' k 'quoi' en nk minutes
		//Donc l 'qui' peut 'act' lk 'quoi' en nk minutes				
		
		$reponse="";
		switch(mt_rand(0,2)) {
			case(0) :
				$question.=" Combien faut-il de ".$qui[$choix]." pour ".$act[$choix].($l*$k).$quoi[$choix]." en ".($n*$k)." minutes ?";
				$reponse.="\\reponsejuste ".($l)." ";
				$reponse.="\\reponse ".($n)." ";
				$reponse.="\\reponse ".($k)." ";
				break;
			case(1) :
				$question.=" En combien de minutes ".$l.$qui[$choix]." peuvent ".$act[$choix].($l*$k).$quoi[$choix]." ?";
				
				$reponse.="\\reponsejuste ".($n*$k)." ";
				$reponse.="\\reponse ".($n)." ";
				$reponse.="\\reponse ".($n*$l)." ";
				break;
			case(2) :
				$question.=" Combien de ".$quoi[$choix]." seront ".$act2[$choix]." en ".($n*$k)." minutes par ".$l.$qui[$choix]." ?";
				
				$reponse.="\\reponsejuste  ".($l*$k)." ";
				$reponse.="\\reponse  ".($k)." ";
				$reponse.="\\reponse  ".($l)." ";
				break;
		}	
		return $question.$reponse;
	}
	
	$clef = "Syracuse";
	$liste_AutoQCM[$clef]="Demande un terme de la suite de syracuse";
	$secte_AutoQCM[$clef]="Recrutement";
	function Syracuse(){
		
		$X=array(mt_rand(65,128));
		for($i=1 ; $i<7 ; $i++) {
			if($X[$i-1]%2==0) $X[$i]=(int)($X[$i-1]/2);
			else $X[$i]=3*$X[$i-1]+1;
		}
		$question="Quel terme poursuit cette suite ?$$";
		for($i=0 ; $i<6 ; $i++) $question.=$X[$i]."\\quad";
		$question.="$$";
	
		$reponse="";
		$reponse.="\\reponsejuste ".$X[6];
		$reponse.="\\reponse ".((int)($X[6]/2));
		$reponse.="\\reponse ".(3*$X[6]+1);
		if($X[5]%2==0) $reponse.="\\reponse ".(3*$X[5]+1);
		else $reponse.="\\reponse ".((int)($X[5]/2));
		return $question.$reponse;
	}
	
	
	
?>