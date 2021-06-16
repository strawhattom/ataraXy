<?php

	$clef = "DetermineDegres";
	$liste_AutoQCM[$clef]="Demande de déterminer le degrés d'un sommet d'un graphe";
	$secte_AutoQCM[$clef]="Graphes";
	function DetermineDegres(){
		
		global $alphabet;
		
		$n=mt_rand(5,11);//dimension
		$o=mt_rand(0,1);//Orientation
		$O=array("orienté", "non orienté");
		$aff=mt_rand(0,1);//Mode d'affichage
		$AFF=array("la matrice booléenne", "une représentation saggitale");
		
		//Matrice
		if($o==0) $mat=matrice_oriente($n);
		else $mat=matrice_non_oriente($n);
		
		$question="Soit $\\G$ le graphe ".$O[$o]." dont ".$AFF[$aff]." est ";
		if($aff==0) $question.="$$".dessine_mat($mat)."$$";
		else{
			if($o==0) $question.="$$".dessinegrapheoriente($mat)."$$";
			else $question.="$$".dessinegraphenonoriente($mat)."$$";
		}
		$D=array();
		$S=array('+', '-');
			
		$rep="";
		if($o==1) {
			$D=CalculDegres($mat);
		
			$x=mt_rand(0,$n-1);
			$rep.="\\reponsejuste $ d^1(".$alphabet[$x].", \\G)=".$D[$x]."$";
			
			$x=mt_rand(0,$n-1);
			$rep.="\\reponsejuste $ d^1(".$alphabet[$x].", \\G)=".$D[$x]."$";
			
			$x=mt_rand(0,$n-1);
			if($D[$x]>0) $rep.="\\reponse $ d^1(".$alphabet[$x].", \\G)=".($D[$x]-1)."$";
			else $rep.="\\reponse $ d^1(".$alphabet[$x].", \\G)=".($D[$x]+1)."$";
			
			$x=mt_rand(0,$n-1);
			if($D[$x]<$n) $rep.="\\reponse $ d^1(".$alphabet[$x].", \\G)=".($D[$x]+1)."$";
			else $rep.="\\reponse  $ d^1(".$alphabet[$x].", \\G)=".($D[$x]-1)."$";
		}
		else{
			$D['+']=CalculDemiDegresExt($mat);
			$D['-']=CalculDemiDegresInt($mat);
			
			$x=mt_rand(0,$n-1);
			$s=mt_rand(0,1);
			$rep.="\\reponsejuste $ d^{".$S[$s]."1}(".$alphabet[$x].", \\G)=".$D[$S[$s]][$x]."$";
			
			$x=mt_rand(0,$n-1);
			$s=mt_rand(0,1);
			$rep.="\\reponsejuste $ d^{".$S[$s]."1}(".$alphabet[$x].", \\G)=".$D[$S[$s]][$x]."$";
			
			$x=mt_rand(0,$n-1);
			$s=mt_rand(0,1);
			if($D[$S[$s]][$x]>0) $rep.="\\reponse $ d^{".$S[$s]."1}(".$alphabet[$x].", \\G)=".($D[$S[$s]][$x]-1)."$";
			else $rep.="\\reponse $ d^{".$S[$s]."1}(".$alphabet[$x].", \\G)=".($D[$S[$s]][$x]+1)."$";
			
			$x=mt_rand(0,$n-1);
			$s=mt_rand(0,1);
			if($D[$S[$s]][$x]>0) $rep.="\\reponse $ d^{".$S[$s]."1}(".$alphabet[$x].", \\G)=".($D[$S[$s]][$x]-1)."$";
			else $rep.="\\reponse $ d^{".$S[$s]."1}(".$alphabet[$x].", \\G)=".($D[$S[$s]][$x]+1)."$";
		}
		return $question.$rep;
	}	

	$clef = "DegresPossibleOriente";
	$liste_AutoQCM[$clef]="Demande s'il existe au moins un graphe orienté avec les contraintes de degrés";
	$secte_AutoQCM[$clef]="Graphes";
	function DegresPossibleOriente(){
		
		global $alphabet;
		
		$n=mt_rand(5,11);//dimension
		$mat=matrice_oriente($n);
		$x=mt_rand(0,1);
		
		$DInt = CalculDemiDegresInt($mat);
		$DExt = CalculDemiDegresExt($mat);
		
		if($x==0){
			$a=mt_rand(0, $n-1);
			
			if(mt_rand(0,1)==0){
				if($DInt[$a]>0 and $DInt[$a]<$n){
					if(mt_rand(0,1)==0) $DInt[$a]-=1;
					else  $DInt[$a]+=1;
				}
				elseif($DInt[$a]>0) $DInt[$a]-=1;
				else $DInt[$a]+=1;
			}
			else{
				if($DExt[$a]>0 and $DExt[$a]<$n){
					if(mt_rand(0,1)==0) $DExt[$a]-=1;
					else  $DExt[$a]+=1;
				}
				elseif($DExt[$a]>0) $DExt[$a]-=1;
				else $DExt[$a]+=1;
			
			}
		}

		$question="Il existe au moins un graphe orienté $\\G$ satisfaisant aux contraintes de demi-degrés suivantes ?";
		$question.="$$\\begin{array}{|c||*{".$n."}{|c}|}";
		$question.="\\hline";
		$question.=" \\Som(\\G)";
		for($i=0 ; $i<$n ; $i++) $question.=" & ".$alphabet[$i];
		$question.="\\\\\\hline";
		$question.=" d^{+1}(\\bullet, \\G)";
		for($i=0 ; $i<$n ; $i++) $question.=" & ".$DExt[$i];
		$question.="\\\\\\hline";
		$question.=" d^{-1}(\\bullet, \\G)";
		for($i=0 ; $i<$n ; $i++) $question.=" & ".$DInt[$i];
		$question.="\\\\\\hline";
		$question.="\\end{array}$$";
		
		
		$rep="";
		if($x==0){
			$rep.="\\reponsejuste Faux";
			$rep.="\\reponse Vrai";
		}
		else{
			$rep.="\\reponsejuste Vrai";
			$rep.="\\reponse Faux";
		}
		
		return $question.$rep;
		
	}
	
	$clef = "DegresPossibleNonOriente";
	$liste_AutoQCM[$clef]="Demande s'il existe au moins un graphe non orienté avec les contraintes de degrés";
	$secte_AutoQCM[$clef]="Graphes";
	function DegresPossibleNonOriente(){
		
		global $alphabet;
		
		$n=mt_rand(5,11);//dimension
		$mat=matrice_non_oriente($n);
		$x=mt_rand(0,1);
		
		$D = CalculDegres($mat);
		
		if($x==0){
			$a=mt_rand(0, $n-1);
			if($D[$a]>0 and $D[$a]<$n){
				if(mt_rand(0,1)==0) $D[$a]-=1;
				else  $D[$a]+=1;
			}
			elseif($D[$a]>0) $D[$a]-=1;
			else $D[$a]+=1;
		}

		$question="Il existe au moins un graphe non orienté $\\G$ satisfaisant aux contraintes de degrés suivantes ?";
		$question.="$$\\begin{array}{|c||*{".$n."}{|c}|}";
		$question.="\\hline";
		$question.=" \\Som(\\G)";
		for($i=0 ; $i<$n ; $i++) $question.=" & ".$alphabet[$i];
		$question.="\\\\\\hline";
		$question.=" d^{1}(\\bullet, \\G)";
		for($i=0 ; $i<$n ; $i++) $question.=" & ".$D[$i];
		$question.="\\\\\\hline";
		$question.="\\end{array}$$";
		
		
		$rep="";
		if($x==0){
			$rep.="\\reponsejuste Faux";
			$rep.="\\reponse Vrai";
		}
		else{
			$rep.="\\reponsejuste Vrai";
			$rep.="\\reponse Faux";
		}
		
		return $question.$rep;
		
	}
	
	$clef = "Eulerien";
	$liste_AutoQCM[$clef]="Demande s'il existe une chaine ou un circuit eulerien";
	$secte_AutoQCM[$clef]="Graphes";
	function Eulerien(){
		
		global $alphabet;
		
		$n=mt_rand(4,9);//dimension
		$o=mt_rand(0,1);//Orientation
		$O=array("orienté", "non orienté");
		$aff=mt_rand(0,1);//Mode d'affichage
		$AFF=array(" la matrice booléenne ", " une représentation saggitale ");
		$c=mt_rand(0,1);//Chaine ou circuit
		$C=array(" une chaine eulérienne ", " un circuit eulérien ");
		
		//Matrice
		if($o==0) $mat=matrice_oriente($n);
		else $mat=matrice_non_oriente($n);
		
		$question="Soit $\\G$ le graphe ".$O[$o]." dont ".$AFF[$aff]." est ";
		if($aff==0) $question.="$$".dessine_mat($mat)."$$";
		else{
			if($o==0) $question.="$$".dessinegrapheoriente($mat)."$$";
			else $question.="$$".dessinegraphenonoriente($mat)."$$";
		}

		$question.="Existe-t-il ".$C[$c]." dans $\\G$ ?";
		
		$x= (    ($o==0 and $c==0 and ExisteChaineEuler($mat))
		      or ($o==0 and $c==1 and ExisteCirEuler($mat))
			  or ($o==1 and $c==0 and ExisteChaineEulerNon($mat))
		      or ($o==1 and $c==1 and ExisteCirEulerNon($mat))
			);
		
		$rep="";
		if($x){
			$rep.="\\reponsejuste Vrai";
			$rep.="\\reponse Faux";
		}
		else{
			$rep.="\\reponsejuste Faux";
			$rep.="\\reponse Vrai";
		}
		return $question.$rep;
		
	}
	
	$clef = "DessinPossible";
	$liste_AutoQCM[$clef]="Demande s'il est possible de faire un dessin sans lever le crayon du papier.";
	$secte_AutoQCM[$clef]="Graphes";
	function DessinPossible(){
		$N=array(4, 5, 5, 6, 6, 6, 7, 7, 8, 8);
		$n=array_rand($N);
		
		$mat=matrice_non_oriente($N[$n]);
		$question="Est-il possible de repproduire ce dessin sur une feuille de papier sans passer deux fois par la même arête
		et sans lever le crayon du papier ? $$".dessinedessin($mat)."$$";

		if(ExisteChaineEulerNon($mat)){
			$reponse ="
			\\reponsejuste Vrai
			\\reponse Faux
			";
		}
		else{
			$reponse ="
			\\reponsejuste Faux
			\\reponse Vrai
			";
		}
		return $question.$reponse;
	}
?>