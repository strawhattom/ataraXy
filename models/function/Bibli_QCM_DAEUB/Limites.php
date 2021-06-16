<?php

	$clef = "Limite1";
	$liste_AutoQCM[$clef]="Calcul d'une limite";
	$secte_AutoQCM[$clef]="DAEUB";
	function Limite1(){
		
		$p=0.33;
		$n=1;//Nombre de limite à calculer
		$a=array();
		$s=array();
		do{
			for($i=0 ; $i<$n ; $i++){
				$a[$i]=genRratio($p, 19);
				$b[$i]=genRratio($p, 19);
				$s[$i]='+';
				if(mt_rand(0,1)) $s[$i]='-';
			}
			$test=false;
			//cmp 0
			for($i=0 ; $i<$n and !$test; $i++){
				if(cmpFrac($a[$i],0)==0) $test=true;
				if(cmpFrac($b[$i],0)==0) $test=true;
				for($j=$i+1 ; $j<$n and !$test; $j++){
					if(cmpFrac($a[$i],$a[$j])==0) $test=true;
				}
			}
		}while($test);
			
		for($i=0 ; $i<$n ; $i++){
						
			$question="$\\lim{x\\rightarrow ".petitlatexFracSGN2($a[$i])."^".$s[$i]."} \\dfrac{".petitlatexFracSGN2($b[$i])."}{x".petitlatexFracSGN(chSGNFrac($a[$i]))."} =$";
			
			if((cmpFrac($b[$i], 0)>=0 and $s[$i]=='+') or (cmpFrac($b[$i], 0)<0 and $s[$i]=='-')){
				$rep1="\\reponsejuste $+\\infty$";
				$rep2="\\reponse $-\\infty$";
			}
			else{
				$rep1="\\reponsejuste $-\\infty$";
				$rep2="\\reponse $+\\infty$";
			}
		}
		
		return $question.$rep1.$rep2;
	}
	
	
	$clef = "Limite2";
	$liste_AutoQCM[$clef]="Calcul d'une limite";
	$secte_AutoQCM[$clef]="DAEUB";
	function Limite2(){
		
		$n=1;//Nombre de limite à calculer
		$P=array();
		$L=array();
		$MEL=array();
		for($i=0 ; $i<$n ; $i++){
			$dnum=mt_rand(0,4);
			$dden=mt_rand(0,4);
			$MEL[$i]=array();
			$MEL[$i]['NUM']=range(0, $dnum);
			$MEL[$i]['DEN']=range(0, $dden);
			shuffle($MEL[$i]['NUM']);
			shuffle($MEL[$i]['DEN']);
			$P[$i]=genRRat($dnum, $dden, 0);
			$L[$i]=array('SGN'=>1, 'NUM'=>1, 'DEN'=>0);
			if(mt_rand(0,1)) $L[$i]=array('SGN'=>-1, 'NUM'=>1, 'DEN'=>0);;
		}
			
		for($i=0 ; $i<$n ; $i++){
						
			$question="$\\lim{x\\rightarrow ".latexFracSGN($L[$i])."} ".affRat($P[$i], $MEL[$i]['NUM'], $MEL[$i]['DEN'])." =$";
			
			$d=degPoly($P[$i]['NUM'])-degPoly($P[$i]['DEN']);
			$x=divFrac($P[$i]['NUM'][degPoly($P[$i]['NUM'])], $P[$i]['DEN'][degPoly($P[$i]['DEN'])]);
			if($d>0){ 
				if((cmpFrac($x, 0)>=0 and evalFrac($L[$i])==='+') or 
				   (cmpFrac($x, 0)<0 and evalFrac($L[$i])==='-' and $d%2==1) or
				   (cmpFrac($x, 0)>=0 and evalFrac($L[$i])==='-' and $d%2==0)
				   ){
					   $rep1="\\reponsejuste $+\\infty$";
					   $rep2="\\reponse $-\\infty$";
					   $rep3="\\reponse $0$";
					   $rep4="\\reponse $".latexFracSGN2($x)."$";
				   }
				else{
					   $rep1="\\reponsejuste $-\\infty$";
					   $rep2="\\reponse $+\\infty$";
					   $rep3="\\reponse $0$";
					   $rep4="\\reponse $".latexFracSGN2($x)."$";
				   }
			}
			elseif($d<0){
					   $rep1="\\reponsejuste $0$";
					   $rep2="\\reponse $-\\infty$";
					   $rep3="\\reponse $+\\infty$";
					   $rep4="\\reponse $".latexFracSGN2($x)."$";
			}
			else{
			   $rep1="\\reponsejuste $".latexFracSGN2($x)."$";
			   $rep2="\\reponse $-\\infty$";
			   $rep3="\\reponse $+\\infty$";
			   $rep4="\\reponse $0$";
			}
		}
		
		return $question.$rep1.$rep2.$rep3.$rep4;
	}
?>