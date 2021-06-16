<?php

	$clef = "Matrice22";
	$liste_AutoQCM[$clef]="Demande la puissance 2 d'une matrice de dim 2.";
	$secte_AutoQCM[$clef]="Graphes";
	function Matrice22(){
		return PuissanceMatrice(2,2);
	}	
	
	$clef = "Matrice32";
	$liste_AutoQCM[$clef]="Demande la puissance 3 d'une matrice de dim 2.";
	$secte_AutoQCM[$clef]="Graphes";
	function Matrice32(){
		return PuissanceMatrice(3,2);
	}
	
	$clef = "Matrice23";
	$liste_AutoQCM[$clef]="Demande la puissance 2 d'une matrice de dim 3.";
	$secte_AutoQCM[$clef]="Graphes";
	function Matrice23(){
		return PuissanceMatrice(2,3);
	}
	
	$clef = "Matrice24";
	$liste_AutoQCM[$clef]="Demande la puissance 2 d'une matrice de dim 4.";
	$secte_AutoQCM[$clef]="Graphes";
	function Matrice24(){
		return PuissanceMatrice(2,4);
	}
	
	$clef = "Matrice33";
	$liste_AutoQCM[$clef]="Demande la puissance 3 d'une matrice de dim 3.";
	$secte_AutoQCM[$clef]="Graphes";
	function Matrice33(){
		return PuissanceMatrice(3,3);
	}

	$clef = "Chaine1";
	$liste_AutoQCM[$clef]="Demande s'il existe ou pas une chaine en donnant la matrice puissance p";
	$secte_AutoQCM[$clef]="Graphes";
	function Chaine1(){
		$n=mt_rand(5,7);//Dimension
		$p=mt_rand(5,9);//Puissance
		$o=mt_rand(0,1);//orientation
		$O=array("orienté", "non orienté");
		$c=mt_rand(0,1); //Il existe ou pas
		$C=array("Il existe une ","Il n'existe pas de ");
		$x=mt_rand(0, $n-1);//depart
		$y=mt_rand(0, $n-1);//arrivé
		
		global $alphabet;
		
		if($o==0) $mat=matrice_oriente($n);
		else $mat=matrice_non_oriente($n);
		//On rajoute des 0 parce que sinon il n'y a que des 1
		$tmp=mt_rand(11,19);
		for($i=0 ; $i<$tmp ; $i++){
			$a=mt_rand(0,$n-1);
			$b=mt_rand(0,$n-1);
			$mat[$a][$b]=0;
			if($o==1) $mat[$b][$a]=0;
		}
		$matp = puiss_mat($mat, $p);
		
		$question = "On considère le graphe ".$O[$o]." $\\G$ de matrice booléenne $ M$. On sait que $$ M^{".$p."} = ".dessine_mat($matp)."$$ 
		".$C[$c]." chaine (ou chemin) de longueur ".$p." entre ".$alphabet[$x]." et ".$alphabet[$y].".";
		$reponse="";
		if(($matp[$x][$y]==1 and $c==0) or ($matp[$x][$y]==0 and $c==1)){//On pourrait faire if($matp[$x][$y]+$c==1)
			$reponse.="\\reponsejuste Vrai";
			$reponse.="\\reponse Faux";
		}
		else {
			$reponse.="\\reponsejuste Faux";
			$reponse.="\\reponse Vrai";
		}
		return $question.$reponse;
	}
	
	$clef = "Chaine2";
	$liste_AutoQCM[$clef]="Demande s'il existe ou pas une chaine en affichant la représentation saggitale";
	$secte_AutoQCM[$clef]="Graphes";
	function Chaine2(){
		$n=mt_rand(3,5);//Dimension
		$p=mt_rand(2,3);//Puissance
		//$o=mt_rand(0,1);//orientation
		$o=0;//C'est plus intéressant dans ce cas
		$O=array("orienté", "non orienté");
		$c=mt_rand(0,1); //Il existe ou pas$c=0;
		$C=array("Il existe une ","Il n'existe pas de ");
		$x=mt_rand(0, $n-1);//depart
		$y=mt_rand(0, $n-1);//arrivé
		
		global $alphabet;
		
		if($o==0) $mat=matrice_oriente($n);
		else $mat=matrice_non_oriente($n);
		//On rajoute des 0 parce que sinon il n'y a que des 1
		$tmp=mt_rand(2,2*$n-1);
		for($i=0 ; $i<$tmp ; $i++){
			$a=mt_rand(0,$n-1);
			$b=mt_rand(0,$n-1);
			$mat[$a][$b]=0;
			if($o==1) $mat[$b][$a]=0;
		}
		$matp = puiss_mat($mat, $p);
		
		$question = "On considère le graphe ".$O[$o]." suivant :";
		if($o==0) $question.= "$$".dessinegrapheoriente($mat)."$$";
		else $question.= "$$".dessinegraphenonoriente($mat)."$$";
		$question.=$C[$c]." chaine (ou chemin) de longueur ".$p." entre ".$alphabet[$x]." et ".$alphabet[$y].".";
		$reponse="";
		if(($matp[$x][$y]==1 and $c==0) or ($matp[$x][$y]==0 and $c==1)){//On pourrait faire if($matp[$x][$y]+$c==1)
			$reponse.="\\reponsejuste Vrai";
			$reponse.="\\reponse Faux";
		}
		else {
			$reponse.="\\reponsejuste Faux";
			$reponse.="\\reponse Vrai";
		}
		return $question.$reponse;
	}
	
	$clef = "GammaPlusNmat";
	$liste_AutoQCM[$clef]="Demande le Gamma +n d'un sommet à partir de la matrice";
	$secte_AutoQCM[$clef]="Graphes";
	function GammaPlusNmat(){
		$d=mt_rand(3,5);//Dimension
		$o=mt_rand(0,1);//orientation
		$O=array("orienté", "non orienté");
		
		$X=range(0, $d-1);
		shuffle($X);shuffle($X);shuffle($X);
		
		global $alphabet;
		
		if($o==0) $mat=matrice_oriente($d);
		else $mat=matrice_non_oriente($d);
		
		$question="Considérons le graphe ".$O[$o]." $\\G$ de matrice booléenne $$".dessine_mat($mat)."$$ Sélectionner les propositions vrais.";
		
		$repoui=array();
		$repnon=array();

		$n=mt_rand(1,2);
		$x=$X[0];
		$tmp =  CalculGammaN($mat, $n, $x);
		$repoui[]="\\reponsejuste $\\Gamma^{+".$n."}(".$alphabet[$x].",\\G)=\\{".implode(',',$tmp)."\\}$ ";
		$repnon[]="\\reponse $\\Gamma^{+".$n."}(".$alphabet[$x].",\\G)=\\{".implode(',',alter_gamma($tmp, $d))."\\}$ ";
		
		$n=mt_rand(1,2);
		$x=$X[1];
		$tmp =  CalculGammaN($mat, $n, $x);
		$repoui[]="\\reponsejuste $\\Gamma^{+".$n."}(".$alphabet[$x].",\\G)=\\{".implode(',',$tmp)."\\} $";
		$repnon[]="\\reponse $\\Gamma^{+".$n."}(".$alphabet[$x].",\\G)=\\{".implode(',',alter_gamma($tmp, $d))."\\}$ ";
		
		$n=mt_rand(1,2);
		$x=$X[1];
		$tmp =  CalculGammaN($mat, $n, $x);
		$repoui[]="\\reponsejuste $\\Gamma^{+".$n."}(".$alphabet[$x].",\\G)=\\{".implode(',',$tmp)."\\} $";
		$repnon[]="\\reponse $\\Gamma^{+".$n."}(".$alphabet[$x].",\\G)=\\{".implode(',',alter_gamma($tmp, $d))."\\}$ ";
		
		shuffle($repoui);shuffle($repoui);shuffle($repoui);
		shuffle($repnon);shuffle($repnon);shuffle($repnon);
		
		return $question.$repoui[0].$repoui[1].$repnon[0].$repnon[1];
	}
	
	$clef = "GammaMoinsNmat";
	$liste_AutoQCM[$clef]="Demande le Gamma -n d'un sommet à partir de la matrice";
	$secte_AutoQCM[$clef]="Graphes";
	function GammaMoinsNmat(){
		$d=mt_rand(3,5);//Dimension
		$o=mt_rand(0,1);//orientation
		$O=array("orienté", "non orienté");
		
		$X=range(0, $d-1);
		shuffle($X);shuffle($X);shuffle($X);
		
		global $alphabet;
		
		if($o==0) $mat=matrice_oriente($d);
		else $mat=matrice_non_oriente($d);
		
		$question="Considérons le graphe ".$O[$o]." $\\G$ de matrice booléenne $$".dessine_mat($mat)."$$ Sélectionner les propositions vrais.";

		$repoui=array();
		$repnon=array();

		$n=mt_rand(1,2);
		$x=$X[0];
		$tmp =  CalculGammaN($mat, -$n, $x);
		$repoui[]="\\reponsejuste $\\Gamma^{-".$n."}(".$alphabet[$x].",\\G)=\\{".implode(',',$tmp)."\\}$ ";
		$repnon[]="\\reponse $\\Gamma^{-".$n."}(".$alphabet[$x].",\\G)=\\{".implode(',',alter_gamma($tmp, $d))."\\}$ ";
		
		$n=mt_rand(1,2);
		$x=$X[1];
		$tmp =  CalculGammaN($mat, -$n, $x);
		$repoui[]="\\reponsejuste $\\Gamma^{-".$n."}(".$alphabet[$x].",\\G)=\\{".implode(',',$tmp)."\\} $";
		$repnon[]="\\reponse $\\Gamma^{-".$n."}(".$alphabet[$x].",\\G)=\\{".implode(',',alter_gamma($tmp, $d))."\\}$ ";
		
		$n=mt_rand(1,2);
		$x=$X[1];
		$tmp =  CalculGammaN($mat, -$n, $x);
		$repoui[]="\\reponsejuste $\\Gamma^{-".$n."}(".$alphabet[$x].",\\G)=\\{".implode(',',$tmp)."\\} $";
		$repnon[]="\\reponse $\\Gamma^{-".$n."}(".$alphabet[$x].",\\G)=\\{".implode(',',alter_gamma($tmp, $d))."\\}$ ";
		
		shuffle($repoui);shuffle($repoui);shuffle($repoui);
		shuffle($repnon);shuffle($repnon);shuffle($repnon);
		
		return $question.$repoui[0].$repoui[1].$repnon[0].$repnon[1];
	}
	
	$clef = "GammaPlusNsag";
	$liste_AutoQCM[$clef]="Demande le Gamma +n d'un sommet à partir de la repsag";
	$secte_AutoQCM[$clef]="Graphes";
	function GammaPlusNsag(){
		$d=mt_rand(3,5);//Dimension
		$o=mt_rand(0,1);//orientation
		$O=array("orienté", "non orienté");
		
		$X=range(0, $d-1);
		shuffle($X);shuffle($X);shuffle($X);
		
		global $alphabet;
		
		if($o==0) {
			$mat=matrice_oriente($d);
			$question="Considérons le graphe ".$O[$o]." $\\G$ de représentation saggitale $$".dessinegrapheoriente($mat)."$$ Sélectionner les propositions vrais.";
		}
		else{ 
			$mat=matrice_non_oriente($d);
			$question="Considérons le graphe ".$O[$o]." $\\G$ de représentation saggitale $$".dessinegraphenonoriente($mat)."$$ Sélectionner les propositions vrais.";
		}
		
		$repoui=array();
		$repnon=array();

		$n=mt_rand(1,2);
		$x=$X[0];
		$tmp =  CalculGammaN($mat, $n, $x);
		$repoui[]="\\reponsejuste $\\Gamma^{+".$n."}(".$alphabet[$x].",\\G)=\\{".implode(',',$tmp)."\\}$ ";
		$repnon[]="\\reponse $\\Gamma^{+".$n."}(".$alphabet[$x].",\\G)=\\{".implode(',',alter_gamma($tmp, $d))."\\}$ ";
		
		$n=mt_rand(1,2);
		$x=$X[1];
		$tmp =  CalculGammaN($mat, $n, $x);
		$repoui[]="\\reponsejuste $\\Gamma^{+".$n."}(".$alphabet[$x].",\\G)=\\{".implode(',',$tmp)."\\} $";
		$repnon[]="\\reponse $\\Gamma^{+".$n."}(".$alphabet[$x].",\\G)=\\{".implode(',',alter_gamma($tmp, $d))."\\}$ ";
		
		$n=mt_rand(1,2);
		$x=$X[1];
		$tmp =  CalculGammaN($mat, $n, $x);
		$repoui[]="\\reponsejuste $\\Gamma^{+".$n."}(".$alphabet[$x].",\\G)=\\{".implode(',',$tmp)."\\} $";
		$repnon[]="\\reponse $\\Gamma^{+".$n."}(".$alphabet[$x].",\\G)=\\{".implode(',',alter_gamma($tmp, $d))."\\}$ ";
		
		shuffle($repoui);shuffle($repoui);shuffle($repoui);
		shuffle($repnon);shuffle($repnon);shuffle($repnon);
		
		return $question.$repoui[0].$repoui[1].$repnon[0].$repnon[1];
	}
	
	$clef = "GammaMoinsNsag";
	$liste_AutoQCM[$clef]="Demande le Gamma -n d'un sommet à partir de la repsag";
	$secte_AutoQCM[$clef]="Graphes";
	function GammaMoinsNsag(){
		$d=mt_rand(3,5);//Dimension
		$o=mt_rand(0,1);//orientation
		$O=array("orienté", "non orienté");
		
		$X=range(0, $d-1);
		shuffle($X);shuffle($X);shuffle($X);
		
		global $alphabet;
		
		if($o==0) {
			$mat=matrice_oriente($d);
			$question="Considérons le graphe ".$O[$o]." $\\G$ de représentation saggitale $$".dessinegrapheoriente($mat)."$$ Sélectionner les propositions vrais.";
		}
		else{ 
			$mat=matrice_non_oriente($d);
			$question="Considérons le graphe ".$O[$o]." $\\G$ de représentation saggitale $$".dessinegraphenonoriente($mat)."$$ Sélectionner les propositions vrais.";
		}
		
		$repoui=array();
		$repnon=array();

		$n=mt_rand(1,2);
		$x=$X[0];
		$tmp =  CalculGammaN($mat, -$n, $x);
		$repoui[]="\\reponsejuste $\\Gamma^{-".$n."}(".$alphabet[$x].",\\G)=\\{".implode(',',$tmp)."\\}$ ";
		$repnon[]="\\reponse $\\Gamma^{-".$n."}(".$alphabet[$x].",\\G)=\\{".implode(',',alter_gamma($tmp, $d))."\\}$ ";
		
		$n=mt_rand(1,2);
		$x=$X[1];
		$tmp =  CalculGammaN($mat, -$n, $x);
		$repoui[]="\\reponsejuste $\\Gamma^{-".$n."}(".$alphabet[$x].",\\G)=\\{".implode(',',$tmp)."\\} $";
		$repnon[]="\\reponse $\\Gamma^{-".$n."}(".$alphabet[$x].",\\G)=\\{".implode(',',alter_gamma($tmp, $d))."\\}$ ";
		
		$n=mt_rand(1,2);
		$x=$X[1];
		$tmp =  CalculGammaN($mat, -$n, $x);
		$repoui[]="\\reponsejuste $\\Gamma^{-".$n."}(".$alphabet[$x].",\\G)=\\{".implode(',',$tmp)."\\} $";
		$repnon[]="\\reponse $\\Gamma^{-".$n."}(".$alphabet[$x].",\\G)=\\{".implode(',',alter_gamma($tmp, $d))."\\}$ ";
		
		shuffle($repoui);shuffle($repoui);shuffle($repoui);
		shuffle($repnon);shuffle($repnon);shuffle($repnon);
		
		return $question.$repoui[0].$repoui[1].$repnon[0].$repnon[1];
	}
	
	$clef = "GammaPlusMat";
	$liste_AutoQCM[$clef]="Demande le Gamma + d'un sommet à partir de la matrice booléenne";
	$secte_AutoQCM[$clef]="Graphes";
	function GammaPlusMat(){
		
		global $alphabet;
		
		$n=mt_rand(3,7);//Dimension
		$mat=matrice_oriente($n);
		//On rajoute des 0 parce que sinon le graphe est connexe
		$tmp=2*$n+1;
		for($i=0 ; $i<$tmp ; $i++){
			$a=mt_rand(0,$n-1);
			$b=mt_rand(0,$n-1);
			$mat[$a][$b]=0;
		}
		
		$question="On considère le graphe $\\G$ de matrice booléenne $$".dessine_mat($mat)."$$";
		$rep="";
	
		$x=mt_rand(0,$n-1);
		$rep.="\\reponsejuste $\\Gamma^{+}(".$alphabet[$x].",\\G)=\\{".implode(',',CalculGammaPlus($mat,$x))."\\} $";
		$x=mt_rand(0,$n-1);
		$rep.="\\reponsejuste $\\Gamma^{+}(".$alphabet[$x].",\\G)=\\{".implode(',',CalculGammaPlus($mat,$x))."\\} $";
		$x=mt_rand(0,$n-1);
		$rep.="\\reponse $\\Gamma^{+}(".$alphabet[$x].",\\G)=\\{".implode(',',alter_gamma(CalculGammaPlus($mat,$x),$n))."\\} $";
		$x=mt_rand(0,$n-1);
		$rep.="\\reponse $\\Gamma^{+}(".$alphabet[$x].",\\G)=\\{".implode(',',alter_gamma(CalculGammaPlus($mat,$x),$n))."\\} $";
		
		return $question.$rep;
	}
	
	$clef = "GammaMoinsMat";
	$liste_AutoQCM[$clef]="Demande le Gamma - d'un sommet à partir de la matrice booléenne";
	$secte_AutoQCM[$clef]="Graphes";
	function GammaMoinsMat(){
		
		global $alphabet;
		
		$n=mt_rand(3,7);//Dimension
		$mat=matrice_oriente($n);
		//On rajoute des 0 parce que sinon le graphe est connexe
		$tmp=2*$n+1;
		for($i=0 ; $i<$tmp ; $i++){
			$a=mt_rand(0,$n-1);
			$b=mt_rand(0,$n-1);
			$mat[$a][$b]=0;
		}
		
		$question="On considère le graphe $\\G$ de matrice booléenne $$".dessine_mat($mat)."$$";
		$rep="";
		
		$x=mt_rand(0,$n-1);
		$rep.="\\reponsejuste $\\Gamma^{-}(".$alphabet[$x].",\\G)=\\{".implode(',',CalculGammaMoins($mat,$x))."\\} $";
		$x=mt_rand(0,$n-1);
		$rep.="\\reponsejuste $\\Gamma^{-}(".$alphabet[$x].",\\G)=\\{".implode(',',CalculGammaMoins($mat,$x))."\\} $";
		$x=mt_rand(0,$n-1);
		$rep.="\\reponse $\\Gamma^{-}(".$alphabet[$x].",\\G)=\\{".implode(',',alter_gamma(CalculGammaMoins($mat,$x),$n))."\\} $";
		$x=mt_rand(0,$n-1);
		$rep.="\\reponse $\\Gamma^{-}(".$alphabet[$x].",\\G)=\\{".implode(',',alter_gamma(CalculGammaMoins($mat,$x),$n))."\\} $";
		
		return $question.$rep;
	}
	
	
	$clef = "GammaPlusSag";
	$liste_AutoQCM[$clef]="Demande le Gamma + d'un sommet à partir de la rep sag";
	$secte_AutoQCM[$clef]="Graphes";
	function GammaPlusSag(){
		
		global $alphabet;
		
		$n=mt_rand(3,6);//Dimension
		$mat=matrice_oriente($n);
		//On rajoute des 0 parce que sinon le graphe est connexe
		$tmp=2*$n+1;
		for($i=0 ; $i<$tmp ; $i++){
			$a=mt_rand(0,$n-1);
			$b=mt_rand(0,$n-1);
			$mat[$a][$b]=0;
		}
		
		$question="On considère le graphe $\\G$ dont une représentation saggitale est $$".dessinegrapheoriente($mat)."$$";
		$rep="";
	
		$x=mt_rand(0,$n-1);
		$rep.="\\reponsejuste $\\Gamma^{+}(".$alphabet[$x].",\\G)=\\{".implode(',',CalculGammaPlus($mat,$x))."\\} $";
		$x=mt_rand(0,$n-1);
		$rep.="\\reponsejuste $\\Gamma^{+}(".$alphabet[$x].",\\G)=\\{".implode(',',CalculGammaPlus($mat,$x))."\\} $";
		$x=mt_rand(0,$n-1);
		$rep.="\\reponse $\\Gamma^{+}(".$alphabet[$x].",\\G)=\\{".implode(',',alter_gamma(CalculGammaPlus($mat,$x),$n))."\\} $";
		$x=mt_rand(0,$n-1);
		$rep.="\\reponse $\\Gamma^{+}(".$alphabet[$x].",\\G)=\\{".implode(',',alter_gamma(CalculGammaPlus($mat,$x),$n))."\\} $";
		
		return $question.$rep;
	}
	
	$clef = "GammaMoinsSag";
	$liste_AutoQCM[$clef]="Demande le Gamma - d'un sommet à partir de la rep sag";
	$secte_AutoQCM[$clef]="Graphes";
	function GammaMoinsSag(){
		
		global $alphabet;
		
		$n=mt_rand(3,6);//Dimension
		$mat=matrice_oriente($n);
		//On rajoute des 0 parce que sinon le graphe est connexe
		$tmp=2*$n+1;
		for($i=0 ; $i<$tmp ; $i++){
			$a=mt_rand(0,$n-1);
			$b=mt_rand(0,$n-1);
			$mat[$a][$b]=0;
		}
		
		$question="On considère le graphe $\\G$ dont une représentation saggitale est $$".dessinegrapheoriente($mat)."$$";
		$rep="";
		
		$x=mt_rand(0,$n-1);
		$rep.="\\reponsejuste $\\Gamma^{-}(".$alphabet[$x].",\\G)=\\{".implode(',',CalculGammaMoins($mat,$x))."\\} $";
		$x=mt_rand(0,$n-1);
		$rep.="\\reponsejuste $\\Gamma^{-}(".$alphabet[$x].",\\G)=\\{".implode(',',CalculGammaMoins($mat,$x))."\\} $";
		$x=mt_rand(0,$n-1);
		$rep.="\\reponse $\\Gamma^{-}(".$alphabet[$x].",\\G)=\\{".implode(',',alter_gamma(CalculGammaMoins($mat,$x),$n))."\\} $";
		$x=mt_rand(0,$n-1);
		$rep.="\\reponse $\\Gamma^{-}(".$alphabet[$x].",\\G)=\\{".implode(',',alter_gamma(CalculGammaMoins($mat,$x),$n))."\\} $";
		
		return $question.$rep;
	}

	
	$clef = "GammaMat";
	$liste_AutoQCM[$clef]="Demande le Gamma +/- d'un sommet à partir de la matrice booléenne d'un graphe non orienté";
	$secte_AutoQCM[$clef]="Graphes";
	function GammaMat(){
		
		global $alphabet;
		
		$n=mt_rand(3,7);//Dimension
		$mat=matrice_non_oriente($n);
		//On rajoute des 0 parce que sinon le graphe est connexe
		$tmp=2*$n+1;
		for($i=0 ; $i<$tmp ; $i++){
			$a=mt_rand(0,$n-1);
			$b=mt_rand(0,$n-1);
			$mat[$a][$b]=0;$mat[$b][$a]=0;
		}
		
		$question="On considère le graphe non oriénté $\\G$ de matrice booléenne $$".dessine_mat($mat)."$$";
		$rep="";
		
		$x=mt_rand(0,$n-1);
		$rep.="\\reponsejuste $\\Gamma^{-}(".$alphabet[$x].",\\G)=\\{".implode(',',CalculGammaMoins($mat,$x))."\\} $";
		$x=mt_rand(0,$n-1);
		$rep.="\\reponsejuste $\\Gamma^{+}(".$alphabet[$x].",\\G)=\\{".implode(',',CalculGammaMoins($mat,$x))."\\} $";
		$x=mt_rand(0,$n-1);
		$rep.="\\reponse $\\Gamma^{-}(".$alphabet[$x].",\\G)=\\{".implode(',',alter_gamma(CalculGammaMoins($mat,$x),$n))."\\} $";
		$x=mt_rand(0,$n-1);
		$rep.="\\reponse $\\Gamma^{+}(".$alphabet[$x].",\\G)=\\{".implode(',',alter_gamma(CalculGammaMoins($mat,$x),$n))."\\} $";
		
		return $question.$rep;
	}
	
	
	$clef = "GammaSag";
	$liste_AutoQCM[$clef]="Demande le Gamma +/- d'un sommet à partir de la rep sag d'un graphe non orienté";
	$secte_AutoQCM[$clef]="Graphes";
	function GammaSag(){
		
		global $alphabet;
		
		$n=mt_rand(3,6);//Dimension
		$mat=matrice_non_oriente($n);
		//On rajoute des 0 parce que sinon le graphe est connexe
		$tmp=2*$n+1;
		for($i=0 ; $i<$tmp ; $i++){
			$a=mt_rand(0,$n-1);
			$b=mt_rand(0,$n-1);
			$mat[$a][$b]=0;$mat[$b][$a]=0;
		}
		
		$question="On considère le graphe non orienté $\\G$ dont une représentation saggitale est $$".dessinegraphenonoriente($mat)."$$";
		$rep="";
	
		$x=mt_rand(0,$n-1);
		$rep.="\\reponsejuste $\\Gamma^{-}(".$alphabet[$x].",\\G)=\\{".implode(',',CalculGammaPlus($mat,$x))."\\} $";
		$x=mt_rand(0,$n-1);
		$rep.="\\reponsejuste $\\Gamma^{+}(".$alphabet[$x].",\\G)=\\{".implode(',',CalculGammaPlus($mat,$x))."\\} $";
		$x=mt_rand(0,$n-1);
		$rep.="\\reponse $\\Gamma^{+}(".$alphabet[$x].",\\G)=\\{".implode(',',alter_gamma(CalculGammaPlus($mat,$x),$n))."\\} $";
		$x=mt_rand(0,$n-1);
		$rep.="\\reponse $\\Gamma^{-}(".$alphabet[$x].",\\G)=\\{".implode(',',alter_gamma(CalculGammaPlus($mat,$x),$n))."\\} $";
		
		return $question.$rep;
	}
	
	$clef = "QuestionGammaDef";
	$liste_AutoQCM[$clef]="Définition successeur, prédécesseur, ascendant et descendant";
	$secte_AutoQCM[$clef]="Graphes";
	function QuestionGammaDef(){
		
		$X=array(
		"\\Gamma^{+1}(x,\\G)", 
		"\\Gamma^{-1}(x,\\G)", 
		"\\Gamma^{+}(x,\\G)", 
		"\\Gamma^{-}(x,\\G)"
		);
		$Y=array(
		"Les succésseurs de $ x$",
		"Les prédécesseurs de $ x$",
		"Les descendants de $ x$",
		"Les ascendants de $ x$"
		);
		$mel=range(0,3);
		shuffle($mel);shuffle($mel);shuffle($mel);
		$question="Soient $\\G$ un graphe orienté et $ x$ un sommet de $\\G$. Comment sont appelés les éléments de $".$X[$mel[0]]."$ ?";
		$rep="";
		$rep.="\\reponsejuste ".$Y[$mel[0]];
		$rep.="\\reponse ".$Y[$mel[1]];
		$rep.="\\reponse ".$Y[$mel[2]];
		$rep.="\\reponse ".$Y[$mel[3]];
		
		return $question.$rep;
	}
	
?>