<?php

	//Calcul du discriminant pour les polynomes de deg 2
	function CalculDelta($Poly){
		
		if(degPoly($Poly)!=2) return zeroFrac();
		
		//b^2-4*a*c
		return sousFrac(puissFrac($Poly[1], 2), prodFrac(4, prodFrac($Poly[2],$Poly[0])));
	}
	
	//Calcul Solutions - Renvoie le code Latex
	function CalculSolutions($Poly){
		
		if(degPoly($Poly)!=2) return zeroFrac();
		
		$a=$Poly[2];
		$b=$Poly[1];
		$c=$Poly[0];
		
		$Delta=CalculDelta($Poly);
		
		$res="";
		if($Delta['SGN']==-1) $res.="\\varnothing";
		elseif($Delta['SGN']==0 or $Delta['NUM']==0) $res.="\\left\\{".latexFracSGN2(divFrac(chSGNFrac($b), prodFrac(2, $a)))."\\right\\}";
		else{
			$alpha=$Delta['NUM'];
			$beta =$Delta['DEN'];
			
			$x=$alpha*$beta;
			$y=PlusGrandCarre($x);
			$z=(int)($x/$y);
			$y=(int)sqrt($y);
			
			$res.="\\left\\{";
			$AA=divFrac(prodFrac(chSGNFrac($b),$beta), prodFrac(prodFrac(2, $a), $beta));
			$BB=divFrac($y, prodFrac(prodFrac(2, $a), $beta));
			$DD=PGCD($AA['DEN'],PGCD($AA['NUM'], $BB['NUM']));
			$AA['NUM']=(int)($AA['NUM']/$DD);
			$BB['NUM']=(int)($BB['NUM']/$DD);
			$AA['DEN']=(int)($AA['DEN']/$DD);
			$BB['DEN']=(int)($BB['DEN']/$DD);
			if($z==1) $res.=latexFracSGN2(addFrac($AA, $BB))." ; ".latexFracSGN2(sousFrac($AA, $BB));
			else{
				if($AA['SGN']==0 or $AA['NUM']==0){
					if($BB['SGN']==-1) $res.="-";
					if(cmpFrac($BB, unFrac())!=0 and cmpFrac($BB, chSGNFrac(unFrac()))!=0) $res.=latexFrac($BB);
					$res.="\\sqrt{".$z."}";
				
					$res.=' ; ';
				
					$BB=chSGNFrac($BB);
					if($BB['SGN']==-1) $res.="-";
					if(cmpFrac($BB, unFrac())!=0 and cmpFrac($BB, chSGNFrac(unFrac()))!=0) $res.=latexFrac($BB);
					$res.="\\sqrt{".$z."}";
				}
				else{
					$res.=latexFracSGN2($AA);
					if($BB['SGN']==-1) $res.="-";
					else $res.='+';
					if(cmpFrac($BB, unFrac())!=0 and cmpFrac($BB, chSGNFrac(unFrac()))!=0) $res.=latexFrac($BB);
					$res.="\\sqrt{".$z."}";
				
					$res.=' ; ';
				
					$BB=chSGNFrac($BB);
					$res.=latexFracSGN2($AA);
					if($BB['SGN']==-1) $res.="-";
					else $res.='+';
					if(cmpFrac($BB, unFrac())!=0 and cmpFrac($BB, chSGNFrac(unFrac()))!=0) $res.=latexFrac($BB);
					$res.="\\sqrt{".$z."}";
				}
				
			}
			$res.="\\right\\}";
		}
		return $res;
	}
	
	$clef = "DetermineDegrePoly";
	$liste_AutoQCM[$clef]="Demande le degré d'un polynome";
	$secte_AutoQCM[$clef]="DAEUB";
	function DetermineDegrePoly(){
		
		$deg=mt_rand(3,9);
		do{$deg1=mt_rand(3,9);}while($deg==$deg1);
		do{$deg2=mt_rand(3,9);}while($deg==$deg2 or $deg1==$deg2);
		
		$Poly=GenRPoly($deg);
		
		$mel=range(0, $deg);shuffle($mel);shuffle($mel);shuffle($mel);
		$question="Quel est le degré du polynôme $".AffPoly($Poly, $mel)."$ ?";
		$rep1="\\reponsejuste $".$deg."$";
		$rep2="\\reponse $".$deg1."$";
		$rep3="\\reponse $".$deg2."$";
		
		return $question.$rep1.$rep2.$rep3;
	}
	
	$clef = "DetermineCoefPoly";
	$liste_AutoQCM[$clef]="Demande le coef dominant ou terme constant d'un polynome";
	$secte_AutoQCM[$clef]="DAEUB";
	function DetermineCoefPoly(){
		
		$deg=mt_rand(1,7);
		
		$mel=range(0, $deg);shuffle($mel);shuffle($mel);shuffle($mel);
		$Poly=GenRPoly($deg);
		
		$coef=array("coeficient dominant", "terme constant");
		$r_coef=mt_rand(0,1);
		
		$question="Quel est le ".$coef[$r_coef]." du polynôme $".AffPoly($Poly, $mel)."$ ?";
		if($r_coef==0){
			$X=$Poly[$deg];
			$rep1="\\reponsejuste $".latexFracSGN2($X)."$ ";
			
			$Y=$Poly[0];
			if(cmpFrac($X,$Y)==0) $Y=addFrac($Y,1);
			$rep2="\\reponse $".latexFracSGN2($Y)."$ ";
		}
		else{
			$X=$Poly[0];
			$rep1="\\reponsejuste $".latexFracSGN2($X)."$ ";
			
			$Y=$Poly[$deg];
			if(cmpFrac($X,$Y)==0) $Y=addFrac($Y,1);
			$rep2="\\reponse $".latexFracSGN2($Y)."$ ";
		}
		
		return $question.$rep1.$rep2;
	}
	
	$clef = "CalculDiscriminant";
	$liste_AutoQCM[$clef]="Demande un un calcul de discriminant";
	$secte_AutoQCM[$clef]="DAEUB";
	function CalculDiscriminant(){
		
		$deg=2;
		$mel=range(0, $deg);shuffle($mel);shuffle($mel);shuffle($mel);
		$Poly=GenRPoly($deg);
		
		$question="Quel est le discriminant de $ P(x)=".AffPoly($Poly, $mel)."$ ?";
		
		//Bonne réponse
		$D=CalculDelta($Poly);
		$rep1="\\reponsejuste $".latexFracSGN2($D)."$";
	
		//Séléction d'un autre polynome 
		do{
			$Poly2=GenRPoly($deg);
			$D2=CalculDelta($Poly2);
		}while(cmpFrac($D,$D2)==0);
		$rep2="\\reponse $".latexFracSGN2($D2)."$";
		
		//Séléction d'un autre polynome 
		do{
			$Poly3=GenRPoly($deg);
			$D3=CalculDelta($Poly3);
		}while(cmpFrac($D,$D3)==0);
		$rep3="\\reponse $".latexFracSGN2($D3)."$";
	
		return $question.$rep1.$rep2.$rep3;
	}
	
	$clef = "CalculNbSolPoly2";
	$liste_AutoQCM[$clef]="Demande le nombre de solution d'un polynome de degrés 2";
	$secte_AutoQCM[$clef]="DAEUB";
	function CalculNbSolPoly2(){
		
		$deg=2;
		$Poly=GenRPoly($deg);
		
		$mel=range(0, $deg);shuffle($mel);shuffle($mel);shuffle($mel);
		$question="Combien l'équation suivante admet-elle de solution réelle ? $$".AffPoly($Poly, $mel)."=0$$";
		
		$D=CalculDelta($Poly);
		if($D['SGN']==-1) $sol=array(0, 1, 2);
		elseif($D['NUM']==0) $sol=array(1, 2, 0);
		else $sol=array(2, 0, 1);
		
		$rep="";
		for($i=0 ; $i<3 ; $i++){
			if($i==0) $rep.="\\reponsejuste ";
			else $rep.="\\reponse ";
			
			$rep.=" $ ".$sol[$i]." $ ";
		}
		
		return $question.$rep;
	}
	
	$clef = "CalculSolPoly1";
	$liste_AutoQCM[$clef]="Demande de résoudre une équation à une inconnue de degrés 1";
	$secte_AutoQCM[$clef]="DAEUB";
	function CalculSolPoly1(){
		
		$mel1=range(0, 1);shuffle($mel1);shuffle($mel1);shuffle($mel1);
		$Poly1=GenRPoly(1);
		$mel2=range(0, 1);shuffle($mel2);shuffle($mel2);shuffle($mel2);
		$Poly2=GenRPoly(1);
		
		
		//De temps en temps on fout la merde
		//if(mt_rand(0,1)) $Poly1[array_search(1, $mel1)]=$Poly2[array_search(1, $mel2)];
		
		$a1=$Poly1[1];
		$b1=$Poly1[0];
		$a2=$Poly2[1];
		$b2=$Poly2[0];
	
		$question="Quelle est l'ensemble solution de l'équation $".AffPoly($Poly1, $mel1)."=".AffPoly($Poly2, $mel2)."$ ?";
		
		//a1x+b1=a2x+b2
		//Calcul de (a1-a2)x=b2-b1
		$A=sousFrac($a1, $a2);
		$B=sousFrac($b2, $b1);
		
		if(cmpFrac($A,0)==0){
			if(cmpFrac($B,0)==0){
				$rep1="\\reponsejuste $\\R$";
				$rep2="\\reponse $\\varnothing$";
				$rep3="\\reponse $\\{0\\}$";
			}
			else{
				$rep1="\\reponsejuste $\\varnothing$";
				$rep2="\\reponse $\\R$";
				$rep3="\\reponse $\\{0\\}$";
			}
		}
		else{
			$X=divFrac($B, $A);
			$rep1="\\reponsejuste $\\left\\{".latexFracSGN2($X)."\\right\\}$";
			if(mt_rand(0,1)) $rep2="\\reponse $\\R$";
			else $rep2="\\reponse $\\varnothing$";
			$Y=invFrac($X);
			$Z=chSGNFrac($X);
			if(mt_rand(0,1) and cmpFrac($X,$Y)!=0) $rep3="\\reponse $\\left\\{".latexFracSGN2($Y)."\\right\\}$";
			elseif(cmpFrac($X,$Z)!=0) $rep3="\\reponse $\\left\\{".latexFracSGN2($Z)."\\right\\}$";
			else $rep3="\\reponse $\\left\\{".latexFracSGN2(addFrac($X, mt_rand(1, 3)))."\\right\\}$";
		}
		
		return $question.$rep1.$rep2.$rep3;
	}
	
	$clef = "CalculSolPoly2";
	$liste_AutoQCM[$clef]="Demande les solutions d'un polynome de degrés 2";
	$secte_AutoQCM[$clef]="DAEUB";
	function CalculSolPoly2(){
		
		$deg=2;
		do{
			$Poly=GenRPoly($deg);
			$D=CalculDelta($Poly);
		}while($D['SGN']<=0);
		$mel=range(0, $deg);shuffle($mel);shuffle($mel);shuffle($mel);
		$question="Quel est l'ensemble solution de l'équation suivante ? $$".AffPoly($Poly, $mel)."=0$$";
		$rep1="\\reponsejuste $".CalculSolutions($Poly)."$";
		
		
		do{
			$Poly=GenRPoly($deg);
			$D2=CalculDelta($Poly);
		}while(cmpFrac($D,$D2)==0);
		$rep2="\\reponse $".CalculSolutions($Poly)."$";
		
		return $question.$rep1.$rep2;
	}

	
?>