<?php

	function question_derives($niv){
		
		switch($niv){
			case 1 : //P
				$deg=mt_rand(2, 3);
				$f=plongeFct(genRPoly($deg, 0, 5));
				
				$fp=fctDer($f);
				$f1=simplifFct(prodFct(plongeFct(invFrac($deg-1)), prodFct(plongeFct(genRPoly(1, 0, 1)),fctDer(fctDer($f)))));
				$f2=simplifFct(prodFct(plongeFct(invFrac($deg-1)), prodFct(plongeFct(genRPoly(1, 0, 1)),fctDer(fctDer($f)))));
				break;
				
			case 2 : //P
				$deg=mt_rand(3, 5);
				$f=plongeFct(genRPoly($deg, 0.75, 4));
				
				$fp=fctDer($f);
				$f1=simplifFct(prodFct(plongeFct(invFrac(($deg-1)*($deg-2))), prodFct(plongeFct(genRPoly(2, 0, 1)),fctDer(fctDer(fctDer($f))))));
				$f2=simplifFct(prodFct(plongeFct(invFrac($deg-1)), prodFct(plongeFct(genRPoly(1, 0, 1)),fctDer(fctDer($f)))));
				break;
				
			case 3 : //sqrt(P)
				$deg=mt_rand(1, 2);
				$P=genRPoly($deg, 0, 4);
				$f=inserFct('sqrt', $P);
				
				$fp=simplifFct(fctDer($f));
				$f1=divFct($P, prodFct(2, $f));
				$f2=simplifFct(divFct(fctDer(plongeFct($P)), $f));
				break;
				
			case 4 : //1/P
				$deg=2;
				$P=genRPoly($deg, 0, 4);
				$f=divFct(1, $P);
				
				$fp=simplifFct(fctDer($f));
				$f1=divFct(-1, puissFct($P, 2));
				$f2=simplifFct(prodFct($f1, $P));
				break;
			case 5 : //P^n
				$deg=2;
				$P=genRPoly($deg, 0, 4);
				$n=mt_rand(3,5);
				$f=puissFct($P, $n);
				
				$fp=simplifFct(fctDer($f));
				$f1=prodFct($n, puissFct($P, $n-1));
				$f2=prodFct(fctDer(plongeFct($P)), puissFct($P, $n-1));
				break;
			case 6 : //P/Q
				$P=genRPoly(mt_rand(2,3), 0, 4);
				$Q=genRPoly(mt_rand(2,3), 0, 4);
				$f=divFct($P, $Q);
				
				$fp=simplifFct(fctDer($f));
				$f1=fctDer(divFct($Q, $P));
				$f2=simplifFct(chSGNFct($fp));
				break;
			default : $f=zeroFct();$fp=zeroFct(); $f1=unFct() ; $f2=unFct();
		}
		
		$question="Si $ f(x)=".affARBreFct($f, true)."$ alors : ";
		$rep1="\\reponsejuste $ f'(x)=".affARBreFct($fp, true)."$";
		$rep2="\\reponse $ f'(x)=".affARBreFct($f1, true)."$";
		$rep3="\\reponse $ f'(x)=".affARBreFct($f2, true)."$";
		
		return $question.$rep1.$rep2.$rep3;
		
	}

	$clef = "CalculDerive1";
	$liste_AutoQCM[$clef]="Calcul d'une dérivé";
	$secte_AutoQCM[$clef]="DAEUB";
	function CalculDerive1(){
		return question_derives(1);
	}

	$clef = "CalculDerive2";
	$liste_AutoQCM[$clef]="Calcul d'une dérivé";
	$secte_AutoQCM[$clef]="DAEUB";
	function CalculDerive2(){
		return question_derives(2);
	}

	$clef = "CalculDerive3";
	$liste_AutoQCM[$clef]="Calcul d'une dérivé";
	$secte_AutoQCM[$clef]="DAEUB";
	function CalculDerive3(){
		return question_derives(3);
	}

	$clef = "CalculDerive4";
	$liste_AutoQCM[$clef]="Calcul d'une dérivé";
	$secte_AutoQCM[$clef]="DAEUB";
	function CalculDerive4(){
		return question_derives(4);
	}

	$clef = "CalculDerive5";
	$liste_AutoQCM[$clef]="Calcul d'une dérivé";
	$secte_AutoQCM[$clef]="DAEUB";
	function CalculDerive5(){
		return question_derives(5);
	}

	$clef = "CalculDerive6";
	$liste_AutoQCM[$clef]="Calcul d'une dérivé";
	$secte_AutoQCM[$clef]="DAEUB";
	function CalculDerive6(){
		return question_derives(6);
	}
	
	function question_derives2($niv){
		
		switch($niv){
			case 1 : //ln(P)
				$deg=mt_rand(2, 3);
				$P=plongeFct(genRPoly($deg, 0, 5));
				$f=inserFct('ln', $P);
				
				$fp=simplifFct(fctDer($f));
				$f1=simplifFct(divFct($P, puissFct($P, 2)));
				$f2=simplifFct(divFct(1, $P));
				break;
			case 2: //ln(P)
				$deg=mt_rand(3, 5);
				$P=plongeFct(genRPoly($deg, 0, 5));
				$f=inserFct('ln', $P);
				
				$fp=simplifFct(fctDer($f));
				$f1=simplifFct(divFct($P, puissFct($P, 2)));
				$f2=simplifFct(divFct(1, $P));
				break;
				
			case 3 : //sqrt(ln(P))
				$deg=mt_rand(1, 2);
				$P=genRPoly($deg, 0, 4);
				$f=inserFct('sqrt', inserFct('ln',$P));
				
				$fp=simplifFct(fctDer($f));
				$f1=simplifFct(divFct(inserFct('ln',$P), prodFct(2, $f)));
				$f2=simplifFct(divFct(fctDer(plongeFct($P)), prodFct(2, $f)));
				break;
				
			case 4 : //ln(sqrt(P))
				$deg=2;
				$P=genRPoly($deg, 0, 4);
				$Pp=fctDer(plongeFct($P));
				$f=inserFct('ln', inserFct('sqrt',$P));
				
				$fp=simplifFct(divFct($Pp, prodFct(2, $P)));
				$f1=divFct($Pp,inserFct('sqrt',$P));
				$f2=divFct($Pp,inserFct('ln',$P));
				break;
			case 5 : //ln(P)^n
				$deg=2;
				$P=genRPoly($deg, 0, 4);
				$Pp=fctDer(plongeFct($P));
				$n=mt_rand(3,5);
				$f=puissFct(inserFct('ln',$P), $n);
				
				$fp=simplifFct(fctDer($f));
				$f1=prodFct($n, puissFct(inserFct('ln',$P), $n-1));
				$f2=prodFct(fctDer(plongeFct($P)), puissFct(inserFct('ln',$P), $n-1));
				break;
			default : $f=zeroFct();$fp=zeroFct(); $f1=unFct() ; $f2=unFct();
		}
		
		$question="Si $ f(x)=".affARBreFct($f, true)."$ alors : ";
		$rep1="\\reponsejuste $ f'(x)=".affARBreFct($fp, true)."$";
		$rep2="\\reponse $ f'(x)=".affARBreFct($f1, true)."$";
		$rep3="\\reponse $ f'(x)=".affARBreFct($f2, true)."$";
		
		return $question.$rep1.$rep2.$rep3;
		
	}
	
	$clef = "CalculDeriveDeux1";
	$liste_AutoQCM[$clef]="Logarithme - Calcul d'une dérivé";
	$secte_AutoQCM[$clef]="DAEUB";
	function CalculDeriveDeux1(){
		return question_derives2(1);
	}
	
	$clef = "CalculDeriveDeux2";
	$liste_AutoQCM[$clef]="Logarithme - Calcul d'une dérivé";
	$secte_AutoQCM[$clef]="DAEUB";
	function CalculDeriveDeux2(){
		return question_derives2(2);
	}
	
	$clef = "CalculDeriveDeux3";
	$liste_AutoQCM[$clef]="Logarithme - Calcul d'une dérivé";
	$secte_AutoQCM[$clef]="DAEUB";
	function CalculDeriveDeux3(){
		return question_derives2(3);
	}
	
	$clef = "CalculDeriveDeux4";
	$liste_AutoQCM[$clef]="Logarithme - Calcul d'une dérivé";
	$secte_AutoQCM[$clef]="DAEUB";
	function CalculDeriveDeux4(){
		return question_derives2(4);
	}
	
	$clef = "CalculDeriveDeux5";
	$liste_AutoQCM[$clef]="Logarithme - Calcul d'une dérivé";
	$secte_AutoQCM[$clef]="DAEUB";
	function CalculDeriveDeux5(){
		return question_derives2(5);
	}

	function question_derives3($niv){
		
		switch($niv){
			case 1 : //exp(P)
				$deg=mt_rand(2, 3);
				$P=plongeFct(genRPoly($deg, 0, 5));
				$f=inserFct('exp', $P);
				
				$fp=simplifFct(fctDer($f));
				$f1=prodFct($P,$f);
				$f2=inserFct('exp', fctDer($P));
				break;
			case 2 : //exp(P)
				$deg=mt_rand(2, 3);
				$P=plongeFct(genRPoly($deg, 0, 5));
				$f=inserFct('exp', $P);
				
				$fp=simplifFct(fctDer($f));
				$f1=prodFct($P,$f);
				$f2=inserFct('exp', fctDer($P));
				break;
				
			case 3 : //sqrt(exp(P))
				$deg=2;
				$P=genRPoly($deg, 0, 4);
				$f=inserFct('sqrt', inserFct('exp',$P));
				
				$fp=simplifFct(fctDer($f));
				$f1=simplifFct(divFct(inserFct('exp',$P), prodFct(2, $f)));
				$f2=simplifFct(divFct(inserFct('exp',fctDer(plongeFct($P))), prodFct(2, $f)));
				break;
				
			case 4 : //exp(sqrt(P))
				$deg=2;
				$P=genRPoly($deg, 0, 4);
				$Pp=fctDer(plongeFct($P));
				$f=inserFct('exp', inserFct('sqrt',$P));
				
				$fp=simplifFct(fctDer($f));
				$f1=simplifFct(divFct($f, prodFct(2, inserFct('sqrt', $P) ) ) );
				$f2=simplifFct(divFct($f, prodFct(1, inserFct('sqrt', $P))));
				break;
			case 5 : //exp(P)^n
				$deg=2;
				$P=genRPoly($deg, 0, 4);
				$Pp=fctDer(plongeFct($P));
				$n=mt_rand(3,5);
				$f=puissFct(inserFct('exp',$P), $n);
				
				$fp=simplifFct(fctDer($f));
				$f1=prodFct($n, prodFct($Pp,puissFct(inserFct('exp',$P), $n-1)));
				$f2=simplifFct(prodFct(fctDer(puissFct($P, $n)), inserFct('exp',$P) ));
				break;
			default : $f=zeroFct();$fp=zeroFct(); $f1=unFct() ; $f2=unFct();
		}
		
		$question="Si $ f(x)=".affARBreFct($f, true)."$ alors : ";
		$rep1="\\reponsejuste $ f'(x)=".affARBreFct($fp, true)."$";
		$rep2="\\reponse $ f'(x)=".affARBreFct($f1, true)."$";
		$rep3="\\reponse $ f'(x)=".affARBreFct($f2, true)."$";
		
		return $question.$rep1.$rep2.$rep3;
		
	}
	
	$clef = "CalculDeriveTrois1";
	$liste_AutoQCM[$clef]="Exponentiel - Calcul d'une dérivé";
	$secte_AutoQCM[$clef]="DAEUB";
	function CalculDeriveTrois1(){
		return question_derives3(1);
	}
	
	$clef = "CalculDeriveTrois2";
	$liste_AutoQCM[$clef]="Exponentiel - Calcul d'une dérivé";
	$secte_AutoQCM[$clef]="DAEUB";
	function CalculDeriveTrois2(){
		return question_derives3(2);
	}
	
	$clef = "CalculDeriveTrois3";
	$liste_AutoQCM[$clef]="Exponentiel - Calcul d'une dérivé";
	$secte_AutoQCM[$clef]="DAEUB";
	function CalculDeriveTrois3(){
		return question_derives3(3);
	}
	
	$clef = "CalculDeriveTrois4";
	$liste_AutoQCM[$clef]="Exponentiel - Calcul d'une dérivé";
	$secte_AutoQCM[$clef]="DAEUB";
	function CalculDeriveTrois4(){
		return question_derives3(4);
	}
	
	$clef = "CalculDeriveTrois5";
	$liste_AutoQCM[$clef]="Exponentiel - Calcul d'une dérivé";
	$secte_AutoQCM[$clef]="DAEUB";
	function CalculDeriveTrois5(){
		return question_derives3(5);
	}
	

	?>