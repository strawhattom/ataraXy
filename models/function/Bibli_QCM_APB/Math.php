<?php
	
	$clef = "Multiplication";
	$liste_AutoQCM[$clef]="Multiplication élémentaire";
	$secte_AutoQCM[$clef]="Recrutement";
	function Multiplication(){
		do{
			$x=mt_rand(-9,9);
			$y=mt_rand(-9,9);
		}while($x*$y==0);
		
		$question="$(".$x.")\\times(".$y.") = $";
		
		$rep="";
		$rep.="\\reponsejuste $".($x*$y)."$";
		$rep.="\\reponse $".(-1*$x*$y)."$";
		$rep.="\\reponse $".(($x+1)*$y)."$";
		$rep.="\\reponse $".(-1*($x+1)*$y)."$";
		$rep.="\\reponse $".(($x-1)*$y)."$";
		$rep.="\\reponse $".(-1*($x-1)*$y)."$";
		return $question.$rep;
	}
	
	$clef = "Addition";
	$liste_AutoQCM[$clef]="Addition élémentaire";
	$secte_AutoQCM[$clef]="Recrutement";
	function Addition(){

		$x=mt_rand(100,999);
		$y=mt_rand(100,999);
		
		$question="$".$x."+".$y." = $";
		$rep="";
		$rep.="\\reponsejuste $".($x+$y)."$";
		$rep.="\\reponse $".($x+$y+1)."$";
		$rep.="\\reponse $".($x+$y+10)."$";
		$rep.="\\reponse $".($x+$y+100)."$";
		$rep.="\\reponse $".($x+$y-1)."$";
		return $question.$rep;
	}
	
	$clef = "Soustraction";
	$liste_AutoQCM[$clef]="Soustraction pas trop difficile";
	$secte_AutoQCM[$clef]="Recrutement";
	function Soustraction(){
		do{
			$x=mt_rand(10,99);
			$y=mt_rand(10,99);
		}while($x==$y);

		$question="$".$x."-".$y." = $";
		$rep="";
		$rep.="\\reponsejuste $".($x-$y)."$";
		$rep.="\\reponse $".($y-$x)."$";
		$rep.="\\reponse $".($x-$y+1)."$";
		$rep.="\\reponse $".($x-$y-1)."$";
		$rep.="\\reponse $".(-$x+$y-1)."$";
		return $question.$rep;
	}
	
	$clef = "Pourcentage";
	$liste_AutoQCM[$clef]="Calcul de pourcentage";
	$secte_AutoQCM[$clef]="Recrutement";
	function Pourcentage(){

		$X=array(25,50,75,100,150,200,300);
		$x=4*mt_rand(1,10);
		shuffle($X);shuffle($X);shuffle($X);
		$question="Que fait ".$X[0]."% de ".$x;
		$rep="";
		$rep.="\\reponsejuste ".($x*$X[0]/100);
		$rep.="\\reponse ".($x*$X[1]/100);
		$rep.="\\reponse ".($x*$X[2]/100);
		return $question.$rep;
	}
	
	$clef = "Pythagore";
	$liste_AutoQCM[$clef]="Enoncé du théorème de Pythagore ou de sa réciproque";
	$secte_AutoQCM[$clef]="Recrutement";
	function Pythagore(){

		$X=array(
			"en $ A$", 
			"en $ B$", 
			"en $ C$"
			);
		$Y=array(
			"$ AB^2+AC^2=BC^2$",
			"$ AB^2+BC^2=AC^2$",
			"$ AC^2+BC^2=AB^2$",
		);
		$mel=range(0,2);
		shuffle($mel);shuffle($mel);shuffle($mel);
		
		switch(mt_rand(0,1)){
			case(0) : //THM
				$question="Si $ ABC$ est un triangle rectangle ".$X[$mel[0]].". Alors : ";
				$rep="";
				$rep.="\\reponsejuste ".$Y[$mel[0]];
				$rep.="\\reponse ".$Y[$mel[1]];
				$rep.="\\reponse ".$Y[$mel[2]];
			break;
			case(1) : //Reciproque
				$question="Si $ ABC$ est un triangle tel que ".$Y[$mel[0]].". Alors : ";
				$rep="";
				$rep.="\\reponsejuste Le triangle est rectangle ".$X[$mel[0]];
				$rep.="\\reponse Le triangle est rectangle".$X[$mel[1]];
				$rep.="\\reponse Le triangle est rectangle".$X[$mel[2]];
			break;
		}
		
		return $question.$rep;
	}	
	
	$clef = "LogarithmeNeperien";
	$liste_AutoQCM[$clef]="Un calcul sur les ln";
	$secte_AutoQCM[$clef]="Recrutement";
	function LogarithmeNeperien(){

		$x1=mt_rand(2,19);
		$x2=mt_rand($x1+1,29);
		$k=mt_rand(2,9);
		
		switch(mt_rand(0,1)){
			case(0) :
				$question="On note $ ln$ la fonction logarithme népérien. Soit $\\dpl{X=ln\\left(\\dfrac{".$x1."^".$k."}{".$x2."}\\right)}$.";
				$rep="";
				$rep.="\\reponsejuste $ X=".$k."\\times ln(".$x1.")-ln(".$x2.")$";
				$rep.="\\reponse $ X=".$k."\\times ln(".$x2.")-ln(".$x1.")$";
				$rep.="\\reponse $ X=ln(".$x1.")-".$k."\\times ln(".$x2.")$";
			break;
			case(1) :
				$question="On note $ ln$ la fonction logarithme népérien. Soit $\\dpl{X=ln\\left(\\dfrac{".$x1."}{".$x2."^".$k."}\\right)}$.";
				$rep="";
				$rep.="\\reponsejuste $ X=ln(".$x1.")-".$k."\\times ln(".$x2.")$";
				$rep.="\\reponse $ X=".$k."\\times ln(".$x1.")-ln(".$x2.")$";
				$rep.="\\reponse $ X=".$k."\\times ln(".$x2.")-ln(".$x1.")$";
			break;
		}
		
		return $question.$rep;
	}
	
	$clef = "Puissances";
	$liste_AutoQCM[$clef]="Simplification de puissance";
	$secte_AutoQCM[$clef]="Recrutement";
	function Puissances(){

		$nb_p=array(2,3,5,7,11);
		shuffle($nb_p);shuffle($nb_p);shuffle($nb_p);
		$a=$nb_p[0];
		$b=$nb_p[1];
		$c=$nb_p[2];
		
		$x=$a*$b;
		$y=$a*$c;
		$z=$b*$c;
		
		$n=mt_rand(2,5);
		$m=mt_rand(6,9);
		
		$question="Soit $ X=\\dfrac{".$x."^".$n."\\times ".$y."}{".$z."^".$m."}$. Alors";//X=a^nb^nac/b^mc^m=a^(n+1)b^(n-m)c^(1-m)
		$rep="";
		$rep.="\\reponsejuste $ X=\\dfrac{".$a."^".($n+1)."\\times".$b."^{".($n-$m)."}}{".$c."^".($m-1)."}$";
		$rep.="\\reponse $ X=\\dfrac{".$a."^".($n+1)."\\times".$b."^".($m-$n)."}{".$c."^".($n-1)."}$";
		$rep.="\\reponse $ X = ".$a."^".($n+1)."\\times".$b."^".($n)."\\times".$c."^".($m-1)."$";
		$rep.="\\reponse $ X = ".$a."^".($n+1)."\\times".$b."^{".(-$m)."}\\times".$c."^".($m-1)."$";
		
		return $question.$rep;
	}
	
	$clef = "LimitesSuites";
	$liste_AutoQCM[$clef]="Calcul de limite d'une suite";
	$secte_AutoQCM[$clef]="Recrutement";
	function LimitesSuites(){

		$U=array(
			"\\dfrac{n^2}{n^2+1}",
			"\\dfrac{2n^2}{n^2+1}",
			"\\dfrac{n^2}{2n^2-1}",
			"\\dfrac{n^{123456}}{e^{\\frac{n}{999999}}}",
			"\\dfrac{\\sqrt{n}}{(ln(n))^{987654}}",
			"n^2-n^3"
		);
		$L=array(
			"1",
			"2",
			"\\dfrac{1}{2}",
			"0",
			"+\\infty",
			"-\\infty"
		);
		
		$mel=range(0, count($U)-1);
		shuffle($mel);shuffle($mel);shuffle($mel);
		
		$question="$\\lim{n\\rightarrow+\\infty} ".$U[$mel[0]]." = $";
		$rep="";
		$rep.="\\reponsejuste $".$L[$mel[0]]."$";
		$rep.="\\reponse $".$L[$mel[1]]."$";
		$rep.="\\reponse $".$L[$mel[2]]."$";
		
		return $question.$rep;
	}
	
	$clef = "LimiteSuitesGeo";
	$liste_AutoQCM[$clef]="Demande la limite d'une suite géométrique.";
	$secte_AutoQCM[$clef]="Recrutement";
	function LimiteSuitesGeo(){
	
		$q1=mt_rand(-5,5);
		$q2=mt_rand(1,5);
		
		$question="Soit $(U_n)_n$ une suite géométrique de raison $\\dfrac{".$q1."}{".$q2."}$. Alors $\\lim{n\\rightarrow+\\infty} U_n =$";
		$q=$q1/$q2;
		$res="";
		if($q>-1 and $q<1){
			$res.="\\reponsejuste $0$";
			$res.="\\reponse $1$";
			$res.="\\reponse $+\\infty$";
			$res.="\\reponse La limite n'existe pas";
		}
		if($q==1){
			$res.="\\reponsejuste $1$";
			$res.="\\reponse $0$";
			$res.="\\reponse $+\\infty$";
			$res.="\\reponse La limite n'existe pas";
		}
		if($q>1){
			$res.="\\reponsejuste $+\\infty$";
			$res.="\\reponse $1$";
			$res.="\\reponse $0$";
			$res.="\\reponse La limite n'existe pas";
		}
		if($q<=-1){
			$res.="\\reponsejuste La limite n'existe pas";
			$res.="\\reponse $+\\infty$";
			$res.="\\reponse $1$";
			$res.="\\reponse $0$";
		}
		
		return $question.$res;
	}
	
	
	
	
?>