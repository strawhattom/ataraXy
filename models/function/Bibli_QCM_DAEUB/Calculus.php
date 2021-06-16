<?php

	//Fois 11
	$clef = "Fois11";
	$liste_AutoQCM[$clef]="Demande une multiplication par 11 rapide";
	$secte_AutoQCM[$clef]="DAEUB";
	function Fois11(){
		$a=mt_rand(1,9);
		do{$b=mt_rand(1,9);}while($a==$b);
		do{$c=rand(0,9);}while($c==$a+$b);
		$n=$a+10*$b;
		$m=$b+10*$a;
		$question="Que fait $11\\times".$n."$ ?";
		
		$rep1="\\reponsejuste $".($n*11)."$";
		$rep2="\\reponse $".($m*11)."$";
		$rep3="\\reponse $".($a+10*$c+100*$b)."$";
	
		return $question.$rep1.$rep2.$rep3;
	}
	
	//Carré de 5
	$clef = "Carre_de_5";
	$liste_AutoQCM[$clef]="Demande le carré d'un multiple de 5";
	$secte_AutoQCM[$clef]="DAEUB";
	function Carre_de_5(){
		$a=mt_rand(1,9);
		$n=5+10*$a;
		$question="Que fait $".$n."^2$ ?";
		
		$rep1="\\reponsejuste $".($n*$n)."$";
		$rep2="\\reponse $".(100*($a*$a)+25)."$";
		$rep3="\\reponse $".(100*($a*$a+2*$a)+25)."$";
	
		return $question.$rep1.$rep2.$rep3;
	}
	
	//Addition de fraction
	$clef = "add2Frac";
	$liste_AutoQCM[$clef]="Faire la somme de deux fractions";
	$secte_AutoQCM[$clef]="DAEUB";
	function add2Frac(){
		
		$valMax=9; 
		do{
			$X=genRratio(0.5, $valMax);
			$Y=genRratio(1, $valMax);
			$a=addFrac($X, $Y);
			$b=sousFrac($X, $Y);
		}while($a['NUM']==0 or $a['SGN']==0 or $b['NUM']==0 or $b['SGN']==0 or $Y['NUM']==0 or $Y['SGN']==0);
	
		$question="";
		$question.="$".latexFracSGN2($X).latexFracSGN($Y)." = $";
		
		$rep1="\\reponsejuste $".latexFracSGN2($a)."$";
		$rep2="\\reponse $".latexFracSGN2(chSGNFrac($a))."$";
		$rep3="\\reponse $".latexFracSGN2($b)."$";
		$rep4="\\reponse $".latexFracSGN2(chSGNFrac($b))."$";
		
		return $question.$rep1.$rep2.$rep3.$rep4;
	}
	
	//Produit de fraction
	$clef = "prod2Frac";
	$liste_AutoQCM[$clef]="Faire le produit de deux fractions";
	$secte_AutoQCM[$clef]="DAEUB";
	function prod2Frac(){
		$valMax=9; 
		do{
			$X=genRratio(0.5, $valMax);
			$Y=genRratio(1, $valMax);
			$a=prodFrac($X, $Y);
		}while($a['NUM']==0 or $a['SGN']==0);
	
		$question="";
		$question.="$\\left(".latexFracSGN2($X)."\\right)\\times\\left(".latexFracSGN2($Y)."\\right) = $";
		
		$rep1="\\reponsejuste $".latexFracSGN2($a)."$";
		$rep2="\\reponse $".latexFracSGN2(chSGNFrac($a))."$";
		$rep3="\\reponse $".latexFracSGN2(invFrac($a))."$";
		
		return $question.$rep1.$rep2.$rep3;
	}
	
	//Quotient de fraction
	$clef = "frac2Frac";
	$liste_AutoQCM[$clef]="Faire le quotient de deux fractions";
	$secte_AutoQCM[$clef]="DAEUB";
	function frac2Frac(){
		$valMax=9; 
		do{
			$X=genRratio(0.5, $valMax);
			$Y=genRratio(1, $valMax);
			$a=divFrac($X, $Y);
		}while($a['NUM']==0 or $a['SGN']==0);
	
		$question="";
		$question.="$\\dfrac{".latexFracSGN2($X)."}{".latexFracSGN2($Y)."} = $";
		
		$rep1="\\reponsejuste $".latexFracSGN2($a)."$";
		if(mt_rand(0, 1)==0) $rep2="\\reponse $".latexFracSGN2(chSGNFrac($a))."$";
		else $rep2="\\reponse $".latexFracSGN2(chSGNFrac(invFrac($a)))."$";
		$rep3="\\reponse $".latexFracSGN2(invFrac($a))."$";
		
		return $question.$rep1.$rep2.$rep3;
	}


	//calcul complexe
	function calculus2mort($niv){
		
		switch($niv){
			case 5 : //Très très dure
				$noeud=array('+', '-', '*', '*', '/', '/');
				$feuille=genRratioTab(0.9, 999, 999);
				$Nivmax=3;
				$d_n = 0.99;
				$Bmin=2;
				$Bmax=3;
				break;
			case 4 : //très dure
				$noeud=array('+', '-', '*', '/');
				$feuille=genRratioTab(0.8, 99, 999);
				$Nivmax=2;
				$d_n = 0.89;
				$Bmin=2;
				$Bmax=3;
				break;
			case 3 : //dure
				$noeud=array('+', '-', '*', '/');
				$feuille=genRratioTab(0.7, 19, 999);
				$Nivmax=2;
				$d_n = 0.79;
				$Bmin=2;
				$Bmax=3;
				break;
			case 2 : //digeste
				$noeud=array('+', '+', '-', '-', '*', '/');
				$feuille=genRratioTab(0.6, 9, 999);
				$Nivmax=2;
				$d_n = 0.75;
				$Bmin=2;
				$Bmax=2;
				break;
			default : //ca va
				$noeud=array('+', '+', '-', '-', '*', '/');
				$feuille=genRratioTab(0.5, 5, 999);
				$Nivmax=2;
				$d_n = 0.75;
				$Bmin=2;
				$Bmax=2;
		}
		
		do{
			$X=geneRArbre($noeud, $feuille, $Nivmax, $d_n, $Bmin, $Bmax);
			$x=CalculArbreFrac($X);
		}while($x['DEN']==0);//On esquive les infinis
		
		$question="$".affArbreFrac($X)." = $";
		
		$rep1="\\reponsejuste $ ".latexFracSGN2($x)."$";
		
		do{
			$Y=geneRArbre($noeud, $feuille, $Nivmax, $d_n, $Bmin, $Bmax);
			$y=CalculArbreFrac($Y);
		}while(cmpFrac($x, $y)==0);
		$rep2="\\reponse $ ".latexFracSGN2($y)."$";
		
		do{
			$Y=geneRArbre($noeud, $feuille, $Nivmax, $d_n, $Bmin, $Bmax);
			$y=CalculArbreFrac($Y);
		}while(cmpFrac($x, $y)==0);
		$rep3="\\reponse $ ".latexFracSGN2($y)."$";
		
		do{
			$Y=geneRArbre($noeud, $feuille, $Nivmax, $d_n, $Bmin, $Bmax);
			$y=CalculArbreFrac($Y);
		}while(cmpFrac($x, $y)==0);
		$rep4="\\reponse $ ".latexFracSGN2($y)."$";
		
		do{
			$Y=geneRArbre($noeud, $feuille, $Nivmax, $d_n, $Bmin, $Bmax);
			$y=CalculArbreFrac($Y);
		}while(cmpFrac($x, $y)==0);
		$rep5="\\reponse $ ".latexFracSGN2($y)."$";
		
		return $question.$rep1.$rep2.$rep3.$rep4.$rep5;
	}

	
	//Calcul d'une expression algèbrique
	$clef = "calculus2mort1";
	$liste_AutoQCM[$clef]="Expression algèbrique (facile)";
	$secte_AutoQCM[$clef]="DAEUB";
	function calculus2mort1(){
		return calculus2mort(1);
	}
	$clef = "calculus2mort2";
	$liste_AutoQCM[$clef]="Expression algèbrique (moyen)";
	$secte_AutoQCM[$clef]="DAEUB";
	function calculus2mort2(){
		return calculus2mort(2);
	}
	$clef = "calculus2mort3";
	$liste_AutoQCM[$clef]="Expression algèbrique (difficile)";
	$secte_AutoQCM[$clef]="DAEUB";
	function calculus2mort3(){
		return calculus2mort(3);
	}
	$clef = "calculus2mort4";
	$liste_AutoQCM[$clef]="Expression algèbrique (très difficile)";
	$secte_AutoQCM[$clef]="DAEUB";
	function calculus2mort4(){
		return calculus2mort(4);
	}
	$clef = "calculus2mort5";
	$liste_AutoQCM[$clef]="Expression algèbrique (diabolique)";
	$secte_AutoQCM[$clef]="DAEUB";
	function calculus2mort5(){
		return calculus2mort(5);
	}

?>