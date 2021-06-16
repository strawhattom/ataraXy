<?php

	//$val_max = valeur max dans la matrice [-val_max, val_max]
	//$inv=true = la matrice doit être inversible
	//$inv=false = On s'en fout
	function GenRSys2($val_max, $inv=true){
		if($val_max<0) $val_max=-$val_max;
		if($val_max==0) $val_max=9;
		do{
			$A=array();
			for($i=0 ; $i<2 ; $i++){
				$A[$i]=array();
				for($j=0 ; $j<2 ; $j++) $A[$i][$j]=mt_rand(-$val_max, $val_max);
			}
			if(!$inv) return $A;
		}while(($A[0][0]*$A[1][1] - $A[0][1]*$A[1][0])==0);
		return $A;
	}
	
	//Renvoie la chaine de caractère correspondant au code LaTex de l'unique solution lorsqu'elle existe, chaine vide sinon.
	function CalcSoluSys2($A, $B){
		
		$d=$A[0][0]*$A[1][1] - $A[0][1]*$A[1][0];
		if(count($A)!=2 or count($B)!=2 or $d==0) return "";
		
		$x=unFrac();
		$x['DEN']=$d;
		$x['NUM']=$A[1][1]*$B[0]-$A[0][1]*$B[1];
		$x=SimpliFrac($x);
		
		$y=unFrac();
		$y['DEN']=$d;
		$y['NUM']=-$A[1][0]*$B[0]+$A[0][0]*$B[1];
		$y=SimpliFrac($y);
	
		return "\\left\\{\\left(".latexFracSGN2($x)."; ".latexFracSGN2($y)."\\right)\\right\\}";
	}

	$clef = "CalculSolSys2";
	$liste_AutoQCM[$clef]="Demande les solutions d'un système";
	$secte_AutoQCM[$clef]="DAEUB";
	function CalculSolSys2(){
		$val_max=9;
		$A=GenRSys2($val_max);
		$B=array();
		$B[0]=mt_rand(-$val_max, $val_max);
		$B[1]=mt_rand(-$val_max, $val_max);
		
		$question="";
		$question.="Quel est la solution du système suivant ? ";
		$question.="
			$$
			\\left\\{
			\\begin{array}{rcrcl}";
			$lig=0;
			if($A[$lig][0]!=0){
				if($A[$lig][0]<0) $question.="-";
				if($A[$lig][0]>1) $question.=$A[$lig][0];
				elseif ($A[$lig][0]<-1) $question.=-$A[$lig][0];
				$question.="x";
			}
			$question.="&";
			if($A[$lig][1]!=0){
				if($A[$lig][1]<0) $question.="-";
				elseif($A[$lig][0]!=0) $question.="+";
				$question.="&";
				if($A[$lig][1]>1) $question.=$A[$lig][1];
				elseif ($A[$lig][1]<-1) $question.=-$A[$lig][1];
				$question.="y";
			}
			else $question.="&";
			$question.="&=&".$B[$lig];
			$question.="\\\\";
			$lig=1;	
			if($A[$lig][0]!=0){
				if($A[$lig][0]<0) $question.="-";
				if($A[$lig][0]>1) $question.=$A[$lig][0];
				elseif ($A[$lig][0]<-1) $question.=-$A[$lig][0];
				$question.="x";
			}
			$question.="&";
			if($A[$lig][1]!=0){
				if($A[$lig][1]<0) $question.="-";
				elseif($A[$lig][0]!=0) $question.="+";
				$question.="&";
				if($A[$lig][1]>1) $question.=$A[$lig][1];
				elseif ($A[$lig][1]<-1) $question.=-$A[$lig][1];
				$question.="y";
			}
			else $question.="&";
			$question.="&=&".$B[$lig];
			$question.="
			\\end{array}
			\\right.
			$$";
		$rep1="\\reponsejuste $".CalcSoluSys2($A, $B)."$";
		$A[0][0]=-$A[0][0];
		$A[0][1]=-$A[0][1];
		$B[0]=mt_rand(-$val_max, $val_max);
		$B[1]=mt_rand(-$val_max, $val_max);
		$rep2="\\reponse $".CalcSoluSys2($A, $B)."$";
		return $question.$rep1.$rep2;
	}

	$clef = "TrouveSys2";
	$liste_AutoQCM[$clef]="Demande les solutions d'un système";
	$secte_AutoQCM[$clef]="DAEUB";
	function TrouveSys2(){
		$val_max=3;
		$A=GenRSys2($val_max);
		$B=array();
		do{
			$B[0]=mt_rand(-$val_max, $val_max);
			$B[1]=mt_rand(-$val_max, $val_max);
		}while($B[0]==0 and $B[1]==0);
		$question="Quels systèmes admettent $ ".CalcSoluSys2($A, $B)." $ pour ensemble solution ?";
		$rep="\\reponsejuste $
		\\left\\{
		\\begin{array}{rcrcl}";
		$lig=0;
		if($A[$lig][0]!=0){
			if($A[$lig][0]<0) $rep.="-";
			if($A[$lig][0]>1) $rep.=$A[$lig][0];
			elseif ($A[$lig][0]<-1) $rep.=-$A[$lig][0];
			$rep.="x";
		}
		$rep.="&";
		if($A[$lig][1]!=0){
			if($A[$lig][1]<0) $rep.="-";
			elseif($A[$lig][0]!=0) $rep.="+";
			$rep.="&";
			if($A[$lig][1]>1) $rep.=$A[$lig][1];
			elseif ($A[$lig][1]<-1) $rep.=-$A[$lig][1];
			$rep.="y";
		}
		else $rep.="&";
		$rep.="&=&".$B[$lig];
		$rep.="\\\\";
		$lig=1;
		if($A[$lig][0]!=0){
			if($A[$lig][0]<0) $rep.="-";
			if($A[$lig][0]>1) $rep.=$A[$lig][0];
			elseif ($A[$lig][0]<-1) $rep.=-$A[$lig][0];
			$rep.="x";
		}
		$rep.="&";
		if($A[$lig][1]!=0){
			if($A[$lig][1]<0) $rep.="-";
			elseif($A[$lig][0]!=0) $rep.="+";
			$rep.="&";
			if($A[$lig][1]>1) $rep.=$A[$lig][1];
			elseif ($A[$lig][1]<-1) $rep.=-$A[$lig][1];
			$rep.="y";
		}
		else $rep.="&";
		$rep.="&=&".$B[$lig];
		$rep.="
		\\end{array}
		\\right.
		$";
		
		$X=array(-3, -2,-1, 2, 3, 5);
		$x=$X[array_rand($X)];
		$lig=mt_rand(0,1);
		$A[$lig][0]*=$x;
		$A[$lig][1]*=$x;
		$B[$lig]*=$x;
		$rep.="\\reponsejuste $
		\\left\\{
		\\begin{array}{rcrcl}";
		$lig=0;
		if($A[$lig][0]!=0){
			if($A[$lig][0]<0) $rep.="-";
			if($A[$lig][0]>1) $rep.=$A[$lig][0];
			elseif ($A[$lig][0]<-1) $rep.=-$A[$lig][0];
			$rep.="x";
		}
		$rep.="&";
		if($A[$lig][1]!=0){
			if($A[$lig][1]<0) $rep.="-";
			elseif($A[$lig][0]!=0) $rep.="+";
			$rep.="&";
			if($A[$lig][1]>1) $rep.=$A[$lig][1];
			elseif ($A[$lig][1]<-1) $rep.=-$A[$lig][1];
			$rep.="y";
		}
		else $rep.="&";
		$rep.="&=&".$B[$lig];
		$rep.="\\\\";
		$lig=1;
		if($A[$lig][0]!=0){
			if($A[$lig][0]<0) $rep.="-";
			if($A[$lig][0]>1) $rep.=$A[$lig][0];
			elseif ($A[$lig][0]<-1) $rep.=-$A[$lig][0];
			$rep.="x";
		}
		$rep.="&";
		if($A[$lig][1]!=0){
			if($A[$lig][1]<0) $rep.="-";
			elseif($A[$lig][0]!=0) $rep.="+";
			$rep.="&";
			if($A[$lig][1]>1) $rep.=$A[$lig][1];
			elseif ($A[$lig][1]<-1) $rep.=-$A[$lig][1];
			$rep.="y";
		}
		else $rep.="&";
		$rep.="&=&".$B[$lig];
		$rep.="
		\\end{array}
		\\right.
		$";
		
		$x=$X[array_rand($X)];
		do{
			$lig=mt_rand(0,1);
			$col=mt_rand(0,1);
		}while($A[$lig][$col]==0);
			$A[$lig][$col]*=$x;
		$rep.="\\reponse $
		\\left\\{
		\\begin{array}{rcrcl}";
		$lig=0;
		if($A[$lig][0]!=0){
			if($A[$lig][0]<0) $rep.="-";
			if($A[$lig][0]>1) $rep.=$A[$lig][0];
			elseif ($A[$lig][0]<-1) $rep.=-$A[$lig][0];
			$rep.="x";
		}
		$rep.="&";
		if($A[$lig][1]!=0){
			if($A[$lig][1]<0) $rep.="-";
			elseif($A[$lig][0]!=0) $rep.="+";
			$rep.="&";
			if($A[$lig][1]>1) $rep.=$A[$lig][1];
			elseif ($A[$lig][1]<-1) $rep.=-$A[$lig][1];
			$rep.="y";
		}
		else $rep.="&";
		$rep.="&=&".$B[$lig];
		$rep.="\\\\";
		$lig=1;
		if($A[$lig][0]!=0){
			if($A[$lig][0]<0) $rep.="-";
			if($A[$lig][0]>1) $rep.=$A[$lig][0];
			elseif ($A[$lig][0]<-1) $rep.=-$A[$lig][0];
			$rep.="x";
		}
		$rep.="&";
		if($A[$lig][1]!=0){
			if($A[$lig][1]<0) $rep.="-";
			elseif($A[$lig][0]!=0) $rep.="+";
			$rep.="&";
			if($A[$lig][1]>1) $rep.=$A[$lig][1];
			elseif ($A[$lig][1]<-1) $rep.=-$A[$lig][1];
			$rep.="y";
		}
		else $rep.="&";
		$rep.="&=&".$B[$lig];
		$rep.="
		\\end{array}
		\\right.
		$";
		$x=$X[array_rand($X)];
		$lig=mt_rand(0,1);
		$A[$lig][0]*=$x;
		$A[$lig][1]*=$x;
		$B[$lig]*=$x;
		$rep.="\\reponse $
		\\left\\{
		\\begin{array}{rcrcl}";
		$lig=0;
		if($A[$lig][0]!=0){
			if($A[$lig][0]<0) $rep.="-";
			if($A[$lig][0]>1) $rep.=$A[$lig][0];
			elseif ($A[$lig][0]<-1) $rep.=-$A[$lig][0];
			$rep.="x";
		}
		$rep.="&";
		if($A[$lig][1]!=0){
			if($A[$lig][1]<0) $rep.="-";
			elseif($A[$lig][0]!=0) $rep.="+";
			$rep.="&";
			if($A[$lig][1]>1) $rep.=$A[$lig][1];
			elseif ($A[$lig][1]<-1) $rep.=-$A[$lig][1];
			$rep.="y";
		}
		else $rep.="&";
		$rep.="&=&".$B[$lig];
		$rep.="\\\\";
		$lig=1;
		if($A[$lig][0]!=0){
			if($A[$lig][0]<0) $rep.="-";
			if($A[$lig][0]>1) $rep.=$A[$lig][0];
			elseif ($A[$lig][0]<-1) $rep.=-$A[$lig][0];
			$rep.="x";
		}
		$rep.="&";
		if($A[$lig][1]!=0){
			if($A[$lig][1]<0) $rep.="-";
			elseif($A[$lig][0]!=0) $rep.="+";
			$rep.="&";
			if($A[$lig][1]>1) $rep.=$A[$lig][1];
			elseif ($A[$lig][1]<-1) $rep.=-$A[$lig][1];
			$rep.="y";
		}
		else $rep.="&";
		$rep.="&=&".$B[$lig];
		$rep.="
		\\end{array}
		\\right.
		$";
		
		return $question.$rep;
	}

	?>