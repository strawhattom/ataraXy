<?php

	//Genère une expression factorisé//
	/*  (ax+b)
		$res['FACT'][]['a']=a
		$res['FACT'][]['b']=b
		$res['FACT'][]['p']="NUM" ou "DEN"
		
		$res['NAT']='>', '<', '<=', '>='
		
		$p proba de fraction
	*/
	function GeneRIneq($factMin, $factMax, $p, $valMAX){
		if($factMin>$factMax) return GeneRIneq($factMax, $factMin, $p, $valMAX);
		$nbFact=mt_rand($factMin, $factMax);
		
		$res=array();
		
		$X=array('>', '<', '>=', '<=', '>=', '<=', '>=', '<='); shuffle($X); shuffle($X); shuffle($X);
		$res['NAT']=$X[0];
		
		$res['FACT']=array();
		$X=array('NUM', 'DEN');
		for($i=0 ; $i<$nbFact ; $i++){
			$res['FACT'][$i]=array();
			do{
				$res['FACT'][$i]['a']=genRratio($p, $valMAX);
			}while(cmpFrac($res['FACT'][$i]['a'], zeroFrac())==0);
			$res['FACT'][$i]['b']=genRratio($p, $valMAX);
			$res['FACT'][$i]['p']=$X[mt_rand(0, 1)];
		}
		
		return $res;
	}
	
	//renvoie le tableau des valeur interdite (les cases sont des fractions)
	function calculVIIneq($INEQ){
		$nb_fact=count($INEQ['FACT']);
		
		$vi=array();
		for($i=0 ; $i<$nb_fact ; $i++){
			if($INEQ['FACT'][$i]['p']=="DEN") $vi[$i]=chSGNFrac(divFrac($INEQ['FACT'][$i]['b'], $INEQ['FACT'][$i]['a']));//-$b/$a
		}
		return $vi;
		
	}
	
	//Renvoie le tableau des racine rangé dans l'ordre croissant
	function classRacineINeq($INEQ){
		$nb_fact=count($INEQ['FACT']);
		
		$rac=array();
		for($i=0 ; $i<$nb_fact ; $i++) $rac[$i]=chSGNFrac(divFrac($INEQ['FACT'][$i]['b'], $INEQ['FACT'][$i]['a']));//-$b/$a
		
		//Trie
		for($i=0 ; $i<$nb_fact ; $i++){
			for($j=$i+1 ; $j<$nb_fact ; $j++){
				if(cmpFrac($rac[$i], $rac[$j])>0){
					$tmp=$rac[$i];
					$rac[$i]=$rac[$j];
					$rac[$j]=$tmp;
				}
			}
		}
		
		return $rac;
	}
	
	//renvoie le domaine solutions
	function calculSolIneq($INEQ){
		
		$nb_fact=count($INEQ['FACT']);
		$X=classRacineINeq($INEQ);
		
		$plusinfini=array('SGN'=>1, 'NUM'=>1, 'DEN'=>0);
		$moinsinfini=array('SGN'=>-1, 'NUM'=>1, 'DEN'=>0);
		
		$vi=calculVIIneq($INEQ);
		//On rajoute plus et moins l'infini en VI
		$vi[]=$plusinfini;
		$vi[]=$moinsinfini;

		if($INEQ['NAT']=='>=' or $INEQ['NAT']=='>') $SGN=1;
		else $SGN=-1;
		
		//Cas des fusions évenutelles
		$large=false;
		if($INEQ['NAT']=='>=' or $INEQ['NAT']=='<=') $large=true;
		
		//On y va
		$res=array();
		
		//Pour chaque colonne $j du tableau de signe
		for($j=0 ; $j<$nb_fact+1 ; $j++){
			//L'intervalle solution est $x ; $y
			if($j>0) $x=$X[$j-1];
			else $x=$moinsinfini;
			if($j<$nb_fact) $y=$X[$j];
			else $y=$plusinfini;
			
			//Calcul du signe//Parcours des lignes
			$sgn=1;
			for($i=0 ; $i<$nb_fact ; $i++){
				$z=chSGNFrac(divFrac($INEQ['FACT'][$i]['b'], $INEQ['FACT'][$i]['a']));//-$b/$a
				if(cmpfrac($z,$y)>=0) $sgn*=-$INEQ['FACT'][$i]['a']['SGN'];
				else $sgn*=$INEQ['FACT'][$i]['a']['SGN'];
			}
			
			//Si c'est pas de bon signe on passe
			if($SGN!=$sgn) continue;
			
			//intervalle ouvert ]x, y[
			$inter=interVide();
			$inter['m']['val']=$x;
			$inter['M']['val']=$y;
		
			//Cas d'une inégalité large
			if($large and !in_array($x, $vi)) $inter['m']['oof']='f';
			if($large and !in_array($y, $vi)) $inter['M']['oof']='f';
			
			$res[]=$inter;
			
			
		}
		return simplifDomaine($res);
	}
		
	//Affiche l'inéquation
	function affIneq($INEQ){
		
		$AAA=array();
		$AAA['NUM']="";
		$AAA['DEN']="";
		$nb=array();
		$nb['NUM']=0;
		$nb['DEN']=0;
		
		foreach($INEQ['FACT'] as $X){
			if(cmpFrac($X['a'], unFrac())==0) $temp="";
			elseif(cmpFrac($X['a'], chSGNFrac(unFrac()))==0) $temp="-";
			else $temp=latexFracSGN2($X['a']);
			$temp.=' x ';
			if($X['b']['SGN']!=0 and $X['b']['NUM']!=0) $temp.=latexFracSGN($X['b']);
			
			if($nb[$X['p']]==0) $AAA[$X['p']]=$temp;
			if($nb[$X['p']]==1) $AAA[$X['p']]="\\left(".$AAA[$X['p']]."\\right)";
			if($nb[$X['p']]>0) $AAA[$X['p']].="\\left(".$temp."\\right)";
			$nb[$X['p']]++;
		}
		
		$aff="";
		if($nb['NUM']==0 and $nb['DEN']==0) $aff.="0";
		elseif($nb['NUM']==0) $aff.= "\\dfrac{1}{".$AAA['DEN']."}";
		elseif($nb['DEN']==0) $aff.= $AAA['NUM'];
		else $aff.= "\\dfrac{".$AAA['NUM']."}{".$AAA['DEN']."}";
		
		switch($INEQ['NAT']){
			case('>') : $aff.=" > ";break;
			case('<') : $aff.=" < ";break;
			case('>=') : $aff.="\\geqslant";break;
			case('<=') : $aff.="\\leqslant";break;
			default : $aff.=" = ";
		}
		$aff.="0";
		
		return $aff;
	}

	/*
	//Cas de test
	$X=GeneRIneq(2, 5, 0, 2);
	$X=array();
	$x=0;
	$X['FACT'][$x]['a']=plongeFrac(1);
	$X['FACT'][$x]['b']=plongeFrac(1);
	$X['FACT'][$x]['p']="NUM";
	$x++;
	$X['FACT'][$x]['a']=plongeFrac(1);
	$X['FACT'][$x]['b']=plongeFrac(1);
	$X['FACT'][$x]['p']="NUM";
	$x++;
	$X['FACT'][$x]['a']=plongeFrac(1);
	$X['FACT'][$x]['b']=plongeFrac(0);
	$X['FACT'][$x]['p']="DEN";
	$x++;
	$X['FACT'][$x]['a']=plongeFrac(1);
	$X['FACT'][$x]['b']=plongeFrac(1);
	$X['FACT'][$x]['p']="NUM";
	$x++;
	$X['FACT'][$x]['a']=plongeFrac(2);
	$X['FACT'][$x]['b']=plongeFrac(1);
	$X['FACT'][$x]['p']="NUM";
	$x++;
	$X['FACT'][$x]['a']=plongeFrac(2);
	$X['FACT'][$x]['b']=plongeFrac(1);
	$X['FACT'][$x]['p']="NUM";
	$x++;
	$X['NAT']=">=";
	echo "$".affIneq($X)."$";
	echo "$$".latexDomaine(calculSolIneq($X))."$$";
	/**/
	
	function questionIneq($niv){
		switch($niv){
			case(1) : $factMin=1; $factMax=2; $p=0.19; $valMax=9; break;
			case(2) : $factMin=2; $factMax=5; $p=0.19; $valMax=9; break;
			case(3) : $factMin=3; $factMax=5; $p=0.41; $valMax=9; break;
			case(4) : $factMin=3; $factMax=5; $p=0.41; $valMax=99; break;
			case(5) : $factMin=5; $factMax=9; $p=0.71; $valMax=99; break;
			default : $factMin=1; $factMax=2; $p=0; $valMax=3;
		}
		$INEQ=GeneRIneq($factMin, $factMax, $p, $valMax);
		$question="Quel est l'intervalle solution de l'inéquation suivante ?$$".affIneq($INEQ)."$$";
		
		$rep1="\\reponsejuste $".latexDomaine(calculSolIneq($INEQ))."$";
		switch($INEQ['NAT']){
			case('>') : $INEQ['NAT']='<';break;
			case('>=') : $INEQ['NAT']='<=';break;
			case('<') : $INEQ['NAT']='>';break;
			case('<=') : $INEQ['NAT']='>=';break;
		}
		$rep2="\\reponse $".latexDomaine(calculSolIneq($INEQ))."$";
		
		return $question.$rep1.$rep2;
	}
	
	$clef = "Ineq0";
	$liste_AutoQCM[$clef]="Résoudre une inéquation très facile";
	$secte_AutoQCM[$clef]="DAEUB";
	function Ineq0(){
		return questionIneq(0);
	}
	
	$clef = "Ineq1";
	$liste_AutoQCM[$clef]="Résoudre une inéquation facile";
	$secte_AutoQCM[$clef]="DAEUB";
	function Ineq1(){
		return questionIneq(1);
	}
	
	$clef = "Ineq2";
	$liste_AutoQCM[$clef]="Résoudre une inéquation moyen";
	$secte_AutoQCM[$clef]="DAEUB";
	function Ineq2(){
		return questionIneq(2);
	}
	
	$clef = "Ineq3";
	$liste_AutoQCM[$clef]="Résoudre une inéquation difficile";
	$secte_AutoQCM[$clef]="DAEUB";
	function Ineq3(){
		return questionIneq(3);
	}
	
	$clef = "Ineq4";
	$liste_AutoQCM[$clef]="Résoudre une inéquation très difficile";
	$secte_AutoQCM[$clef]="DAEUB";
	function Ineq4(){
		return questionIneq(4);
	}
	
	$clef = "Ineq5";
	$liste_AutoQCM[$clef]="Résoudre une inéquation diabolique";
	$secte_AutoQCM[$clef]="DAEUB";
	function Ineq5(){
		return questionIneq(5);
	}
?>