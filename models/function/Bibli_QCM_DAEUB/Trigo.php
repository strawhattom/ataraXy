<?php

	function affFracPi($f){
		$f=plongeFrac($f);
		$num=$f['NUM'];
		$den=$f['DEN'];
		if($den<0){
			$den=-$den;
			$num=-$num;
		}
		if($den==0) return "\\infty";
		if($f['SGN']<0) $num=-$num;
		
		
		if($den==1){
			if($num==1) return "\\pi";
			if($num==-1) return "-\\pi";
			if($num==0) return "0";
			return $num."\\pi";
		}
		if($num==1) return "\\dfrac{\\pi}{".$den."}";
		if($num==-1) return "-\\dfrac{\\pi}{".$den."}";
		if($num==0) return "0";
		
		return "\\dfrac{".$num."\\pi}{".$den."}";	
	}
	
	#Donne la valeur de fpi sur [a, b[
	function mod2pi($f, $a=0, $b=2){
		if($b-$a!=2) return mod2pi($f, 0, 2);
		
		$f=plongeFrac($f);
		$num=$f['NUM'];
		$den=$f['DEN'];
		if($den<0){
			$den=-$den;
			$num=-$num;
		}
		if($den==0) return "\\infty";
		if($f['SGN']<0) $num=-$num;
		
		#f=num/den=ent+dec/den
		$ent=(int)($num/$den);
		$dec=($num-$ent*$den);
		
		#mod 2 pi
		$ent=($ent%2);
		$num=$ent*$den+$dec;
		
		while($num/$den<$a) $num=$num+2*$den;
		while($num/$den>=$b) $num=$num-2*$den;
		
		return plongeFrac($num."/".$den);
		
		
	}
	
	
	$clef = "Modulo2pi";
	$liste_AutoQCM[$clef]="Simplification modulo 2 $\\pi$";
	$secte_AutoQCM[$clef]="DAEUB";
	function Modulo2pi(){
		
		$DEN=array(2, 3, 4, 6, 8);
		$den=$DEN[array_rand($DEN)];
		$num=mt_rand(10, 50);
		$f=plongeFrac($num."/".$den);
		
		$question="Quelles sont les deux angles qui valent $ ".affFracPi($f)." $ modulo $2\\pi$ ?";
		$rep1="\\reponsejuste $ ".affFracPi(addFrac($f, 2*mt_rand(1, 10)))." $";
		$rep2="\\reponsejuste $ ".affFracPi(addFrac($f, -2*mt_rand(1, 10)))." $";
		$rep3="\\reponse $ ".affFracPi(addFrac($f, (2*mt_rand(1, 10)+1)))." $";
		$rep4="\\reponse $ ".affFracPi(addFrac($f, (-2*mt_rand(1, 10)+1)))." $";
		
		return $question.$rep1.$rep2.$rep3.$rep4;
	}
	
	$clef = "DegEnRad1";
	$liste_AutoQCM[$clef]="Conversion de degrés en radian - I";
	$secte_AutoQCM[$clef]="DAEUB";
	function DegEnRad1(){
		
		$deg=360;
		$rad=2;
		
		$DEG=array(0, 30, 45, 60, 90, 120, 135, 150, 180);
		$RAD=array(plongeFrac("0"), plongeFrac("1/6"), plongeFrac("1/4"), plongeFrac("1/3"), plongeFrac("1/2"), plongeFrac("2/3"), plongeFrac("3/4"), plongeFrac("5/6"), plongeFrac("1"));
		$x=array_rand($DEG);
		do{
			$a=array_rand($DEG);
			$b=array_rand($DEG);
		}while($a==$x or $b==$x);
		
		$question="Que vaut $ ".$DEG[$x]."$ degrés en radian ?";
		$rep1="\\reponsejuste $ ".affFracPi($RAD[$x])." $";
		$rep2="\\reponse $ ".affFracPi($RAD[$a])." $";
		$rep3="\\reponse $ ".affFracPi($RAD[$b])." $";
		
		return $question.$rep1.$rep2.$rep3;
	}
	
	$clef = "DegEnRad2";
	$liste_AutoQCM[$clef]="Conversion de degrés en radian - II";
	$secte_AutoQCM[$clef]="DAEUB";
	function DegEnRad2(){
		
		
		$DEG=array(-150, -135, -120, -90, -60, -45, -30, 0, 30, 45, 60, 90, 120, 135, 150, 180);
		$deg=$DEG[array_rand($DEG)];
		$rad=plongeFrac($deg.'/180');
		
		$question="Que vaut $ ".$deg."$ degrés en radian ?";
		$rep1="\\reponsejuste $ ".affFracPi(addFrac($rad, 2*mt_rand(0, 5)))." $";
		$rep2="\\reponse $ ".affFracPi(addFrac($rad, 2*mt_rand(0, 5)+1))." $";
		$rep3="\\reponse $ ".affFracPi(addFrac($rad, 2*mt_rand(0, 5)-1))." $";
		
		return $question.$rep1.$rep2.$rep3;
	}
	
	$clef = "CalculCosSin";
	$liste_AutoQCM[$clef]="Calcul de cosinus et sinus";
	$secte_AutoQCM[$clef]="DAEUB";
	function CalculCosSin(){
		
		$cos=array(
			0 =>"1", 
			30=>"\\dfrac{\sqrt{3}}{2}", 
			45=>"\\dfrac{\sqrt{2}}{2}", 
			60=>"\\dfrac{1}{2}", 
			90=>"0"
		);
		$sin=array(
			0 =>"0", 
			30=>"\\dfrac{1}{2}", 
			45=>"\\dfrac{\sqrt{2}}{2}", 
			60=>"\\dfrac{\sqrt{3}}{2}", 
			90=>"1"
		);
		$DEG=array(0, 30, 45, 60, 90);
		shuffle($DEG);shuffle($DEG);shuffle($DEG);
		
		$val=array();
		if(mt_rand(0, 1)==1){
			$fct='cos';
			for($i=0 ; $i< 3 ; $i++) $val[$i]=$cos[$DEG[$i]];
			
		}
		else{
			$fct='sin';
			for($i=0 ; $i< 3 ; $i++) $val[$i]=$sin[$DEG[$i]];
		}
		
		switch(mt_rand(0, 3)){
			case 0:
				for($i=0 ; $i< 3 ; $i++) $DEG[$i]=-$DEG[$i];
				if($fct=='sin'){
					for($i=0 ; $i< 3 ; $i++) $val[$i]="-".$val[$i];
				}
				break;
			case 1:
				for($i=0 ; $i< 3 ; $i++) $DEG[$i]=180-$DEG[$i];
				if($fct=='cos'){
					for($i=0 ; $i< 3 ; $i++) $val[$i]="-".$val[$i];
				}
				break;
			case 2:
				for($i=0 ; $i< 3 ; $i++) $DEG[$i]=180+$DEG[$i];
				for($i=0 ; $i< 3 ; $i++) $val[$i]="-".$val[$i];
				break;
		}
		
		$rad=plongeFrac($DEG[0].'/180');
		$question="Que vaut $ ".$fct."\\left(".affFracPi(addFrac($rad, 2*mt_rand(0, 5)))."\\right)$ ?";
		$rep1="\\reponsejuste $ ".$val[0]." $";
		$rep2="\\reponse $ ".$val[1]." $";
		$rep3="\\reponse $ ".$val[2]." $";
		
		return $question.$rep1.$rep2.$rep3;
	}
	
	function question_derives_trigo($niv){
		switch($niv){
			case 1 : //cos ou sin de (ax+b)
				do{$P=genRPoly(1, 0, 9);}while(cmpFrac($P[1], 1)==0 or cmpFrac($P[1], -1)==0);
				$trigo='cos';
				$ogirt='sin';
				if(mt_rand(0, 1)==0) {
					$trigo='sin';
					$ogirt='cos';
				}
				$f=inserFct($trigo, $P);
				
				$fp=simplifFct(fctDer($f));
				$f1=simplifFct(prodFct(-1, $fp));
				$f2=simplifFct(inserFct($ogirt, $P));
				break;
				
			case 2 : //cos ou sin de (polynome de degrés 2)
				$P=genRPoly(2, 0, 9);
				$trigo='cos';
				$ogirt='sin';
				if(mt_rand(0, 1)==0) {
					$trigo='sin';
					$ogirt='cos';
				}
				$f=inserFct($trigo, $P);
				
				$fp=simplifFct(fctDer($f));
				$f1=simplifFct(prodFct(-1, $fp));
				$f2=simplifFct(inserFct($ogirt, $P));
				break;
				
				
			case 3 : //cos ou sin de sqrt
				$P=genRPoly(1, 0, 9);
				$P[1]=1;
				$trigo='cos';
				$ogirt='sin';
				if(mt_rand(0, 1)==0) {
					$trigo='sin';
					$ogirt='cos';
				}
				$f=inserFct($trigo, inserFct('sqrt', $P));
				
				$fp=simplifFct(fctDer($f));
				$f1=simplifFct(prodFct($fp, -1));
				$f2=simplifFct(inserFct($ogirt, inserFct('sqrt', $P)));
				break;
				
			case 4 : //sqrt de cos ou sin
				$P=genRPoly(1, 0, 9);
				$P[1]=1;
				$trigo='cos';
				$ogirt='sin';
				if(mt_rand(0, 1)==0) {
					$trigo='sin';
					$ogirt='cos';
				}
				$f=inserFct('sqrt', inserFct($trigo, $P));
				
				$fp=simplifFct(fctDer($f));
				$f1=simplifFct(prodFct($fp, -1));
				$f2=simplifFct(inserFct('sqrt', inserFct($ogirt, $P)));
				break;
				
			default : $f=zeroFct();$fp=zeroFct(); $f1=unFct() ; $f2=unFct() ;
		}
		
		$question="Si $ f(x)=".affARBreFct($f, true)."$ alors : ";
		$rep1="\\reponsejuste $ f'(x)=".affARBreFct($fp, true)."$";
		$rep2="\\reponse $ f'(x)=".affARBreFct($f1, true)."$";
		$rep3="\\reponse $ f'(x)=".affARBreFct($f2, true)."$";
		
		return $question.$rep1.$rep2.$rep3;
		
	}

	$clef = "CalculDeriveTrigo1";
	$liste_AutoQCM[$clef]="Calcul d'une dérivé avec de la trigo (facile)";
	$secte_AutoQCM[$clef]="DAEUB";
	function CalculDeriveTrigo1(){
		return question_derives_trigo(1);
	}

	$clef = "CalculDeriveTrigo2";
	$liste_AutoQCM[$clef]="Calcul d'une dérivé avec de la trigo (moyen)";
	$secte_AutoQCM[$clef]="DAEUB";
	function CalculDeriveTrigo2(){
		return question_derives_trigo(2);
	}

	$clef = "CalculDeriveTrigo3";
	$liste_AutoQCM[$clef]="Calcul d'une dérivé avec de la trigo (difficile)";
	$secte_AutoQCM[$clef]="DAEUB";
	function CalculDeriveTrigo3(){
		return question_derives_trigo(3);
	}

	$clef = "CalculDeriveTrigo4";
	$liste_AutoQCM[$clef]="Calcul d'une dérivé avec de la trigo (difficile)";
	$secte_AutoQCM[$clef]="DAEUB";
	function CalculDeriveTrigo4(){ 
		return question_derives_trigo(4);
	}

	?>