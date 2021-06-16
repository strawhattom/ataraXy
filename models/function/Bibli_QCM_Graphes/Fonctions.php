<?php

	$alphabet="ABCDEFGHIJKLMONPQRSTUVWXYZ";
	
	//Prend une matrice et renvoie le code LaTeX de la matrice
	function dessine_mat($mat){
		$n=count($mat);
		global $alphabet;
		if($n>strlen($alphabet)) return ' ';
		$res="\\begin{array}{c|";
		for($i=0 ; $i<$n ; $i++)$res.="c";
		$res.="}";
		for($i=0; $i<$n; $i++) $res.= "& ".$alphabet[$i];
		$res.="\\\\\\hline ";
		for($i=0 ; $i<$n ; $i++){
			$res.=$alphabet[$i];
			for($j=0 ; $j<$n ; $j++) $res.="& ".$mat[$i][$j];
			$res.="\\\\";
		}
		$res.="\\end{array}";
		return $res;
	}
	
	//Comme dessine_mat mais avec des nombre à la place des lettres
	function dessine_mat2($mat){
		$n=count($mat);
		
		$res="\\begin{array}{c|";
		for($i=0 ; $i<$n ; $i++)$res.="c";
		$res.="}";
		for($i=0; $i<$n; $i++) $res.= "& ".($i+1);
		$res.="\\\\\\hline ";
		for($i=0 ; $i<$n ; $i++){
			$res.=($i+1);
			for($j=0 ; $j<$n ; $j++) $res.="& ".$mat[$i][$j];
			$res.="\\\\";
		}
		$res.="\\end{array}";
		return $res;
	}
	
	//retourne la matrice de la clique à n sommets
	function clique($n){
		$mat=array();
		for($i=0; $i<$n ; $i++){
			$mat[$i]=array();
			for($j=0; $j<$n; $j++) $mat[$i][$j]=1;
		}
		return $mat;
	}
	
	//Retourne la matrice de la clique non_oriente à n sommets
	function cliquenon($n){
		$mat=array();
		for($i=0; $i<$n ; $i++){
			$mat[$i]=array();
			for($j=0; $j<$n; $j++) $mat[$i][$j]=1;
			$mat[$i][$i]=0;
		}
		return $mat;
	}
	
	//Retourne la matrice d'une chaine oriente à n sommets
	function chaine($n){
		$mat=array();
		for($i=0; $i<$n ; $i++){
			$mat[$i]=array();
			for($j=0; $j<$n; $j++) $mat[$i][$j]=0;
		}
		$X=range(0,$n-1);
		shuffle($X);shuffle($X);shuffle($X);
		for($i=0; $i<$n-1; $i++) $mat[$X[$i]][$X[$i+1]]=1;
		
		return $mat;
	}
	
	//Retourne la matrice d'une chaine non_oriente à n sommets
	function chainenon($n){
		$mat=array();
		for($i=0; $i<$n ; $i++){
			$mat[$i]=array();
			for($j=0; $j<$n; $j++) $mat[$i][$j]=0;
		}
		$X=range(0,$n-1);
		shuffle($X);shuffle($X);shuffle($X);
		for($i=0; $i<$n-1; $i++) {$mat[$X[$i]][$X[$i+1]]=1;$mat[$X[$i+1]][$X[$i]]=1;}
		
		return $mat;
	}

	//Retourne la matrice d'un cycle oriente à n sommets
	function cycle($n){
		$mat=array();
		for($i=0; $i<$n ; $i++){
			$mat[$i]=array();
			for($j=0; $j<$n; $j++) $mat[$i][$j]=0;
		}
		$X=range(0,$n-1);
		shuffle($X);shuffle($X);shuffle($X);
		for($i=0; $i<$n-1; $i++) $mat[$X[$i]][$X[$i+1]]=1;
		$mat[$X[$n-1]][$X[0]]=1;
		
		return $mat;
	}

	//Retourne la matrice d'un cycle non_oriente à n sommets
	function cyclenon($n){
		$mat=array();
		for($i=0; $i<$n ; $i++){
			$mat[$i]=array();
			for($j=0; $j<$n; $j++) $mat[$i][$j]=0;
		}
		$X=range(0,$n-1);
		shuffle($X);shuffle($X);shuffle($X);
		for($i=0; $i<$n-1; $i++) {$mat[$X[$i]][$X[$i+1]]=1;$mat[$X[$i+1]][$X[$i]]=1;}
		$mat[$X[$n-1]][$X[0]]=1;$mat[$X[0]][$X[$n-1]]=1;

		return $mat;
	}
	
	//Génère une matrice orienté à n sommets
	function matrice_oriente($n){
		$mat=array();
		for($i=0; $i<$n ; $i++){
			$mat[$i]=array();
			for($j=0 ; $j<$n ; $j++) $mat[$i][$j]=mt_rand(0, 1);
		}
		return $mat;
	}
	
	//Retourne le code LaTeX d'une représentation saggitale du graphe dont la matrice est passée en paramètre.
	function dessinegrapheoriente($mat){
		global $alphabet;
		$n=count($mat);
		$tmp=0.5;
		$res="\\xymatrix{";
		for($i=0; $i<$n ; $i++){
			$res.=$alphabet[$i];
			for($j=0; $j<$n ; $j++){
				$r="";
				if(!isset($mat[$i][$j])) return '';
				if($mat[$i][$j]==1){
					if($i<$j){
						for($x=0 ; $x<$j-$i ; $x++) $r.='r';
						$res.=" \\ar@/^".$tmp."pc/[".$r."] ";
					}
					if($i==$j) $res.="\\ar@(ld,rd)[]";
					if($i>$j){
						for($x=0 ; $x<$i-$j ; $x++) $r.='l';
						$res.="\\ar@/^".$tmp."pc/[".$r."] ";
					}
					$tmp+=0.5;
				}
			}
			if($i<$n-1) $res.=" & ";
		}
		$res.="}";
		return $res;
	}
	
	//Génére une question ou il faut trouver la représentation saggitale d'une matrice //Cas orienté
	function Trouve_representation_sag_oriente($n){
		$mat= matrice_oriente($n);
		$mat2=$mat;
		$x=mt_rand(0, $n-1); $y=mt_rand(0, $n-1);
		$mat2[$x][$y]=1-$mat2[$x][$y];
		$mat3=$mat2;
		$x=mt_rand(0, $n-1); $y=mt_rand(0, $n-1);
		$mat3[$x][$y]=1-$mat3[$x][$y];
		$x=mt_rand(0, $n-1); $y=mt_rand(0, $n-1);
		$mat3[$x][$y]=1-$mat3[$x][$y];
		$question = "Séléctionner la représentation saggitale du graphe orienté dont la matrice est $$".dessine_mat($mat)."$$";
		$reponses="";
		$reponses.="\\reponsejuste $".dessinegrapheoriente($mat)."$\n";
		$reponses.="\\reponse $".dessinegrapheoriente($mat2)."$\n";
		$reponses.="\\reponse $".dessinegrapheoriente($mat3)."$\n";
		
		return $question.$reponses;
	}

	//idem que précédement mais on donne la rep. sagg et on demande la matrice
	function Trouve_representation_mat_oriente($n){
		$mat= matrice_oriente($n);
		$mat2=$mat;
		$x=mt_rand(0, $n-1); $y=mt_rand(0, $n-1);
		$mat2[$x][$y]=1-$mat2[$x][$y];
		$mat3=$mat2;
		$x=mt_rand(0, $n-1); $y=mt_rand(0, $n-1);
		$mat3[$x][$y]=1-$mat3[$x][$y];
		$x=mt_rand(0, $n-1); $y=mt_rand(0, $n-1);
		$mat3[$x][$y]=1-$mat3[$x][$y];
		$question = "Séléctionner la représentation matricielle du graphe orienté dont la représentation saggitale est $$".dessinegrapheoriente($mat)."$$";
		$reponses="";
		$reponses.="\\reponsejuste $".dessine_mat($mat)."$\n";
		$reponses.="\\reponse $".dessine_mat($mat2)."$\n";
		$reponses.="\\reponse $".dessine_mat($mat3)."$\n";
		
		return $question.$reponses;
	}
		
	//Sort une matrice non orienté à n sommets
	function matrice_non_oriente($n){
		$mat=array();
		for($i=0; $i<$n ; $i++) $mat[$i]=array();
		for($i=0; $i<$n ; $i++){
			$mat[$i][$i]=0;
			for($j=$i+1 ; $j<$n ; $j++) {
				$mat[$i][$j]=mt_rand(0, 1);
				$mat[$j][$i]=$mat[$i][$j];
			}
		}
		return $mat;
	}

	//Renvoie le code LaTeX d'une rep. sagg. d'une graphe non orienté.
	function dessinegraphenonoriente($mat){
		global $alphabet;
		$n=count($mat);
		$tmp=0.5;
		$res="\\xymatrix{";
		for($i=0; $i<$n ; $i++){
			$res.=$alphabet[$i];
			for($j=$i+1; $j<$n ; $j++){
				$r="";
				if(!isset($mat[$i][$j])) return '';
				if($mat[$i][$j]==1){
					if($i<$j){
						for($x=0 ; $x<$j-$i ; $x++) $r.='r';
						$res.=" \\ar@{-}@/^".$tmp."pc/[".$r."] ";
					}
					if($i>$j){
						for($x=0 ; $x<$i-$j ; $x++) $r.='l';
						$res.="\\ar@{-}@/^".$tmp."pc/[".$r."] ";
					}
					$tmp+=0.5;
				}
			}
			if($i<$n-1) $res.=" & ";
		}
		$res.="}";
		return $res;
	}
	
	function RecupElementPourDessin($mat){
		$n=count($mat);
		$X=array();
		for($i=0 ; $i<$n ; $i++) $X[$i]="";
		$res="";
		switch($n){
		case(4) : 
			/*carré
				0	1
				2	3
			*/
			$i=0;
			$j=$i+1;
			if($mat[$i][$j]==1) $X[$i].="\\ar@{-}[r]";
			$j++;
			if($mat[$i][$j]==1) $X[$i].="\\ar@{-}[d]";
			$j++;
			if($mat[$i][$j]==1) $X[$i].="\\ar@{-}[rd]";
			$i=1;
			$j=$i+1;
			if($mat[$i][$j]==1) $X[$i].="\\ar@{-}[ld]";
			$j++;
			if($mat[$i][$j]==1) $X[$i].="\\ar@{-}[d]";
			$i=2;
			$j=$i+1;
			if($mat[$i][$j]==1) $X[$i].="\\ar@{-}[r]";
		break;
		case(5) : 
			/*maison
					0
				1		2
				3		4
			*/
			$i=0;
			$j=$i+1;
			if($mat[$i][$j]==1) $X[$i].="\\ar@{-}[ld]";
			$j++;
			if($mat[$i][$j]==1) $X[$i].="\\ar@{-}[rd]";
			$j++;
			if($mat[$i][$j]==1) $X[$i].="\\ar@{-}[ldd]";
			$j++;
			if($mat[$i][$j]==1) $X[$i].="\\ar@{-}[rdd]";
			$i=1;
			$j=$i+1;
			if($mat[$i][$j]==1) $X[$i].="\\ar@{-}[rr]";
			$j++;
			if($mat[$i][$j]==1) $X[$i].="\\ar@{-}[d]";
			$j++;
			if($mat[$i][$j]==1) $X[$i].="\\ar@{-}[rrd]";
			$i=2;
			$j=$i+1;
			if($mat[$i][$j]==1) $X[$i].="\\ar@{-}[lld]";
			$j++;
			if($mat[$i][$j]==1) $X[$i].="\\ar@{-}[d]";
			$i=3;
			$j=$i+1;
			if($mat[$i][$j]==1) $X[$i].="\\ar@{-}[rr]";
		break;
		case(6) : 
			/*Domino
				0	1	2
				3	4	5
			*/
			$i=0;
			$j=$i+1;
			if($mat[$i][$j]==1) $X[$i].="\\ar@{-}[r]";
			$j++;
			if($mat[$i][$j]==1) $X[$i].="\\ar@{-}@/^1pc/[rr]";
			$j++;
			if($mat[$i][$j]==1) $X[$i].="\\ar@{-}[d]";
			$j++;
			if($mat[$i][$j]==1) $X[$i].="\\ar@{-}[rd]";
			$j++;
			if($mat[$i][$j]==1) $X[$i].="\\ar@{-}[rrd]";
			$i=1;
			$j=$i+1;
			if($mat[$i][$j]==1) $X[$i].="\\ar@{-}[r]";
			$j++;
			if($mat[$i][$j]==1) $X[$i].="\\ar@{-}[ld]";
			$j++;
			if($mat[$i][$j]==1) $X[$i].="\\ar@{-}[d]";
			$j++;
			if($mat[$i][$j]==1) $X[$i].="\\ar@{-}[rd]";
			$i=2;
			$j=$i+1;
			if($mat[$i][$j]==1) $X[$i].="\\ar@{-}[lld]";
			$j++;
			if($mat[$i][$j]==1) $X[$i].="\\ar@{-}[ld]";
			$j++;
			if($mat[$i][$j]==1) $X[$i].="\\ar@{-}[d]";
			$i=3;
			$j=$i+1;
			if($mat[$i][$j]==1) $X[$i].="\\ar@{-}[r]";
			$j++;
			if($mat[$i][$j]==1) $X[$i].="\\ar@{-}@/_1pc/[rr]";
			$i=4;
			$j=$i+1;
			if($mat[$i][$j]==1) $X[$i].="\\ar@{-}[r]";
		break;
		case(7) : 
			/*Presque losange
					0
				1		2
			3				4
				5		6
					
			*/
			$i=0;
			$j=$i+1;
			if($mat[$i][$j]==1) $X[$i].="\\ar@{-}[ld]";
			$j++;
			if($mat[$i][$j]==1) $X[$i].="\\ar@{-}[rd]";
			$j++;
			if($mat[$i][$j]==1) $X[$i].="\\ar@{-}@/_1pc/[lldd]";
			$j++;
			if($mat[$i][$j]==1) $X[$i].="\\ar@{-}@/^1pc/[rrdd]";
			$j++;
			if($mat[$i][$j]==1) $X[$i].="\\ar@{-}[lddd]";
			$j++;
			if($mat[$i][$j]==1) $X[$i].="\\ar@{-}[rddd]";
			$i=1;
			$j=$i+1;
			if($mat[$i][$j]==1) $X[$i].="\\ar@{-}[rr]";
			$j++;
			if($mat[$i][$j]==1) $X[$i].="\\ar@{-}[ld]";
			$j++;
			if($mat[$i][$j]==1) $X[$i].="\\ar@{-}[rrrd]";
			$j++;
			if($mat[$i][$j]==1) $X[$i].="\\ar@{-}[dd]";
			$j++;
			if($mat[$i][$j]==1) $X[$i].="\\ar@{-}[rrdd]";
			$i=2;
			$j=$i+1;
			if($mat[$i][$j]==1) $X[$i].="\\ar@{-}[llld]";
			$j++;
			if($mat[$i][$j]==1) $X[$i].="\\ar@{-}[rd]";
			$j++;
			if($mat[$i][$j]==1) $X[$i].="\\ar@{-}[lldd]";
			$j++;
			if($mat[$i][$j]==1) $X[$i].="\\ar@{-}[dd]";
			$i=3;
			$j=$i+1;
			if($mat[$i][$j]==1) $X[$i].="\\ar@{-}[rrrr]";
			$j++;
			if($mat[$i][$j]==1) $X[$i].="\\ar@{-}[rd]";
			$j++;
			if($mat[$i][$j]==1) $X[$i].="\\ar@{-}[rrrd]";
			$i=4;
			$j=$i+1;
			if($mat[$i][$j]==1) $X[$i].="\\ar@{-}[llld]";
			$j++;
			if($mat[$i][$j]==1) $X[$i].="\\ar@{-}[ld]";
			$i=5;
			$j=$i+1;
			if($mat[$i][$j]==1) $X[$i].="\\ar@{-}[rr]";
		break;
		case(8) : 
			/*Losange
					0
				1		2
			3				4
				5		6
					8
			*/
			$i=0;
			$j=$i+1;
			if($mat[$i][$j]==1) $X[$i].="\\ar@{-}[ld]";
			$j++;
			if($mat[$i][$j]==1) $X[$i].="\\ar@{-}[rd]";
			$j++;
			if($mat[$i][$j]==1) $X[$i].="\\ar@{-}@/_1pc/[lldd]";
			$j++;
			if($mat[$i][$j]==1) $X[$i].="\\ar@{-}@/^1pc/[rrdd]";
			$j++;
			if($mat[$i][$j]==1) $X[$i].="\\ar@{-}[lddd]";
			$j++;
			if($mat[$i][$j]==1) $X[$i].="\\ar@{-}[rddd]";
			$j++;
			if($mat[$i][$j]==1) $X[$i].="\\ar@{-}[dddd]";
			$i=1;
			$j=$i+1;
			if($mat[$i][$j]==1) $X[$i].="\\ar@{-}[rr]";
			$j++;
			if($mat[$i][$j]==1) $X[$i].="\\ar@{-}[ld]";
			$j++;
			if($mat[$i][$j]==1) $X[$i].="\\ar@{-}[rrrd]";
			$j++;
			if($mat[$i][$j]==1) $X[$i].="\\ar@{-}[dd]";
			$j++;
			if($mat[$i][$j]==1) $X[$i].="\\ar@{-}[rrdd]";
			$j++;
			if($mat[$i][$j]==1) $X[$i].="\\ar@{-}[rddd]";
			$i=2;
			$j=$i+1;
			if($mat[$i][$j]==1) $X[$i].="\\ar@{-}[llld]";
			$j++;
			if($mat[$i][$j]==1) $X[$i].="\\ar@{-}[rd]";
			$j++;
			if($mat[$i][$j]==1) $X[$i].="\\ar@{-}[lldd]";
			$j++;
			if($mat[$i][$j]==1) $X[$i].="\\ar@{-}[dd]";
			$j++;
			if($mat[$i][$j]==1) $X[$i].="\\ar@{-}[lddd]";
			$i=3;
			$j=$i+1;
			if($mat[$i][$j]==1) $X[$i].="\\ar@{-}[rrrr]";
			$j++;
			if($mat[$i][$j]==1) $X[$i].="\\ar@{-}[rd]";
			$j++;
			if($mat[$i][$j]==1) $X[$i].="\\ar@{-}[rrrd]";
			$j++;
			if($mat[$i][$j]==1) $X[$i].="\\ar@{-}@/_1pc/[rrdd]";
			$i=4;
			$j=$i+1;
			if($mat[$i][$j]==1) $X[$i].="\\ar@{-}[llld]";
			$j++;
			if($mat[$i][$j]==1) $X[$i].="\\ar@{-}[ld]";
			$j++;
			if($mat[$i][$j]==1) $X[$i].="\\ar@{-}@/^1pc/[lldd]";
			$i=5;
			$j=$i+1;
			if($mat[$i][$j]==1) $X[$i].="\\ar@{-}[rr]";
			$j++;
			if($mat[$i][$j]==1) $X[$i].="\\ar@{-}[rd]";
			$i=6;
			$j=$i+1;
			if($mat[$i][$j]==1) $X[$i].="\\ar@{-}[ld]";
		break;
		}
		return $X;
	}
	
	//Renvoie le code LaTeX d'une graphe d'un dessin à reproduire sans levé le crayon du papier.
	function dessinedessin($mat){
		
		$n=count($mat);
		$X=RecupElementPourDessin($mat);
		switch($n){
		case(4) : 
			/*Carré
				0	1
				2	3
			*/
			return "\\xymatrix{
				*=0{} ".$X[0]." & *=0{} ".$X[1]."\\\\
				*=0{} ".$X[2]." & *=0{} ".$X[3]." 
			}";
		case(5): 
			/*maison
					0
				1		2
				3		4
			*/
			return "\\xymatrix{
				& *=0{}".$X[0]." & \\\\
				 *=0{} ".$X[1]." && *=0{} ".$X[2]." \\\\
				 *=0{} ".$X[3]." && *=0{} ".$X[4]." 
			}";
		case(6):
			/*Domino
				0	1	2
				3	4	5
			*/
			return "\\xymatrix{
				*=0{} ".$X[0]." & *=0{} ".$X[1]." & *=0{} ".$X[2]." \\\\
				*=0{} ".$X[3]." & *=0{} ".$X[4]." & *=0{} ".$X[5]." 
			}";
		case(7) : 
			/*Presque losange
					0
				1		2
			3				4
				5		6
					
			*/
			return "\\xymatrix{
				&& *=0{} ".$X[0]." &&\\\\
				& *=0{} ".$X[1]." && *=0{} ".$X[2]." &\\\\
				 *=0{} ".$X[3]." &&&& *=0{} ".$X[4]." \\\\
				& *=0{} ".$X[5]." && *=0{} ".$X[6]." &
			}";
		case(8) : 
			/*Losange
					0
				1		2
			3				4
				5		6
					8
			*/
			return "\\xymatrix{
				&& *=0{} ".$X[0]." &&\\\\
				& *=0{} ".$X[1]." && *=0{} ".$X[2]." &\\\\
				 *=0{} ".$X[3]." &&&& *=0{} ".$X[4]." \\\\
				& *=0{} ".$X[5]." && *=0{} ".$X[6]." &\\\\
				&& *=0{} ".$X[7]." &&
			}";
		}
		return "";
	}
	
	//Comme précédement mais en nomant les sommet
	function dessinedessin2($mat){
		
		$n=count($mat);
		$X=RecupElementPourDessin($mat);
		switch($n){
		case(4) : 
			/*Carré
				0	1
				2	3
			*/
			return "\\xymatrix{
				A".$X[0]." & B ".$X[1]."\\\\
				C".$X[2]." & D ".$X[3]." 
			}";
		case(5): 
			/*maison
					0
				1		2
				3		4
			*/
			return "\\xymatrix{
				& A".$X[0]." & \\\\
				 B ".$X[1]." && C ".$X[2]." \\\\
				 D ".$X[3]." && E ".$X[4]." 
			}";
		case(6):
			/*Domino
				0	1	2
				3	4	5
			*/
			return "\\xymatrix{
				A ".$X[0]." & B ".$X[1]." & C ".$X[2]." \\\\
				D ".$X[3]." & E ".$X[4]." & F ".$X[5]." 
			}";
		case(7) : 
			/*Presque losange
					0
				1		2
			3				4
				5		6
					
			*/
			return "\\xymatrix{
				&& A ".$X[0]." &&\\\\
				& B ".$X[1]." && C ".$X[2]." &\\\\
				 D ".$X[3]." &&&& E ".$X[4]." \\\\
				& F ".$X[5]." && G ".$X[6]." &
			}";
		case(8) : 
			/*Losange
					0
				1		2
			3				4
				5		6
					8
			*/
			return "\\xymatrix{
				&& A ".$X[0]." &&\\\\
				& B ".$X[1]." && C ".$X[2]." &\\\\
				 D ".$X[3]." &&&& E ".$X[4]." \\\\
				& F ".$X[5]." && G ".$X[6]." &\\\\
				&& H ".$X[7]." &&
			}";
		}
		return "";
	}
	
	//Idem que Trouve_representation_sag_oriente sauf qu'on est non orienté
	function Trouve_representation_sag_non_oriente($n){
		$mat= matrice_non_oriente($n);
		$mat2=$mat;
		do{
			$x=mt_rand(0, $n-1); $y=mt_rand(0, $n-1);
		}while($x==$y);//Un peu dangeureux
		$mat2[$x][$y]=1-$mat2[$x][$y];
		$mat2[$y][$x]=1-$mat2[$y][$x];
		$mat3=$mat2;
		do{
			$x=mt_rand(0, $n-1); $y=mt_rand(0, $n-1);
		}while($x==$y);//Un peu dangeureux
		$mat3[$x][$y]=1-$mat3[$x][$y];
		$mat3[$y][$x]=1-$mat3[$y][$x];
		do{
			$x=mt_rand(0, $n-1); $y=mt_rand(0, $n-1);
		}while($x==$y);//Un peu dangeureux
		$mat3[$x][$y]=1-$mat3[$x][$y];
		$mat3[$y][$x]=1-$mat3[$y][$x];
		$question = "Séléctionner la représentation saggitale du graphe non orienté dont la matrice est $$".dessine_mat($mat)."$$";
		$reponses="";
		$reponses.="\\reponsejuste $".dessinegraphenonoriente($mat)."$\n";
		$reponses.="\\reponse $".dessinegraphenonoriente($mat2)."$\n";
		$reponses.="\\reponse $".dessinegraphenonoriente($mat3)."$\n";
		
		return $question.$reponses;
	}
	
	//Idem que Trouve_representation_mat_oriente sauf qu'on est dans le cas non orienté.
	function Trouve_representation_mat_non_oriente($n){
		$mat= matrice_non_oriente($n);
		$mat2=$mat;
		do{
			$x=mt_rand(0, $n-1); $y=mt_rand(0, $n-1);
		}while($x==$y);//Un peu dangeureux
		$mat2[$x][$y]=1-$mat2[$x][$y];
		$mat2[$y][$x]=1-$mat2[$y][$x];
		$mat3=$mat2;
		do{
			$x=mt_rand(0, $n-1); $y=mt_rand(0, $n-1);
		}while($x==$y);//Un peu dangeureux
		$mat3[$x][$y]=1-$mat3[$x][$y];
		$mat3[$y][$x]=1-$mat3[$y][$x];
		do{
			$x=mt_rand(0, $n-1); $y=mt_rand(0, $n-1);
		}while($x==$y);//Un peu dangeureux
		$mat3[$x][$y]=1-$mat3[$x][$y];
		$mat3[$y][$x]=1-$mat3[$y][$x];
		$question = "Séléctionner la représentation matricielle du graphe non orienté dont la représentation saggitale est $$".dessinegraphenonoriente($mat)."$$";
		$reponses="";
		$reponses.="\\reponsejuste $".dessine_mat($mat)."$\n";
		$reponses.="\\reponse $".dessine_mat($mat2)."$\n";
		$reponses.="\\reponse $".dessine_mat($mat3)."$\n";
		
		return $question.$reponses;
	}
	
	//Renvoie la matrice désoriénté
	function desorientation($mat){
		$n=count($mat);
		for($i=0 ; $i<$n ; $i++){
			$mat[$i][$i]=0;
			for($j=$i+1 ; $j<$n ; $j++){
				if($mat[$i][$j]==1 or $mat[$j][$i]==1){
					$mat[$i][$j]=1;
					$mat[$j][$i]=1;
				}
			}
		}
		return $mat;
	}
	
	//Produit de matrice carré
	function prod_mat($M,$N){
		$X=array();
		$n=count($M);
		if(count($N)!=$n) return $X;
		for($i=0 ; $i<$n ; $i++){
			$X[$i]=array();
			for($j=0 ; $j<$n ; $j++){
				$X[$i][$j]=0;
				for($k=0 ; $k<$n ; $k++) $X[$i][$j]+=$M[$i][$k]*$N[$k][$j];
				if($X[$i][$j]!=0) $X[$i][$j]=1;
			}
		}
		return $X;
	}
	
	//Matrice identité en dim n
	function identit2($n){
		$X=array();
		for($i=0 ; $i<$n ; $i++){
			$X[$i]=array();
			for($j=0 ; $j<$n ; $j++){
				if($i==$j) $X[$i][$j]=1;
				else $X[$i][$j]=0;
			}
		}
		return $X;
	}
	
	function puiss_mat($M, $n){
		if($n<=0) return identit2(count($M));
		if($n==1) return $M;
		return prod_mat($M,puiss_mat($M, $n-1));
	}
	
	//Demande la puissance p d'une matrice nxn
	function PuissanceMatrice($n,$p){
		
		$mat=matrice_oriente($n);
		$matp=puiss_mat($mat, $p);
		
		$matp2=$matp;
		$i=mt_rand(0,$n-1); $j=mt_rand(0,$n-1); 
		$matp2[$i][$j]=1-$matp2[$i][$j];
		
		$matp3=$matp2;
		$i=mt_rand(0,$n-1); $j=mt_rand(0,$n-1); 
		$matp3[$i][$j]=1-$matp3[$i][$j];
		$i=mt_rand(0,$n-1); $j=mt_rand(0,$n-1); 
		$matp3[$i][$j]=1-$matp3[$i][$j];
		
		$question="Considérons le graphe $\\G$ dont la matrice $ M$ est $$".dessine_mat($mat)."$$ Alors $ M^{".$p."}$=";
		$reponse="";
		$reponse.="\\reponsejuste $".dessine_mat($matp)."$ ";
		$reponse.="\\reponse $".dessine_mat($matp2)."$ ";
		$reponse.="\\reponse $".dessine_mat($matp3)."$ ";
		
		return $question.$reponse;
	}
	
	//Calcul Gamma $n du sommet $x, retourne un tableau
	function CalculGammaN($mat, $n, $x){
		global $alphabet;
		if($n==0) return array($alphabet[$x]);
		$res=array();
		if($n>0){
			$mat=puiss_mat($mat, $n);
			for($j=0;$j<count($mat) ; $j++){
				if($mat[$x][$j]==1) $res[]=$alphabet[$j];
			}
		}
		if($n<0){
			$mat=puiss_mat($mat, -$n);
			for($i=0;$i<count($mat) ; $i++){
				if($mat[$i][$x]==1) $res[]=$alphabet[$i];
			}
		}
		return $res;
	}
	
	//Calcul du gamma + 
	function CalculGammaPlus($mat,$x){
		global $alphabet;
		$n=count($mat);
		$X=identit2($n);
		
		$res=array($alphabet[$x]);
		for($p=0 ; $p<$n ; $p++){//Puissance
			$X=prod_mat($X,$mat);//$X=$mat^($p+1);
			for($j=0 ; $j<$n ; $j++){
				if($X[$x][$j]==1 and !in_array($alphabet[$j], $res)) $res[]=$alphabet[$j];
			}
		}
		sort($res);
		return $res;
	}
	
	//Calcul du gamma - 
	function CalculGammaMoins($mat,$x){
		global $alphabet;
		$n=count($mat);
		$X=identit2($n);
		
		$res=array($alphabet[$x]);
		for($p=0 ; $p<$n ; $p++){//Puissance
			$X=prod_mat($X,$mat);//$X=$mat^($p+1);
			for($i=0 ; $i<$n ; $i++){
				if($X[$i][$x]==1 and !in_array($alphabet[$i], $res)) $res[]=$alphabet[$i];
			}
		}
		sort($res);
		return $res;
	}
	
	//Modifie un array qui viens d'un gamma
	function alter_gamma($X,$n){
		global $alphabet;
		$x=count($X);
		
		if($x<=0) return array($alphabet[mt_rand(0, $n-1)]);
		if($x>=$n){
			$Y=array();
			$y=mt_rand(0, $n-1);
			for($i=0 ; $i<$n ; $i++){
				if($i!=$y) $Y[]=$X[$i];
			}
			sort($Y);
			return $Y;
		}
		if(mt_rand(0,1)==0){
			$Y=array();
			for($i=0 ; $i<$x ; $i++) $Y[]=$X[$i];
			$i=0;
			while(in_array($alphabet[$i], $Y)) $i++;
			$Y[]=$alphabet[$i];
			sort($Y);
			return $Y;
		}
		else{
			//Suppression d'un élément
			$Y=array();
			$y=mt_rand(0, $x-1);
			for($i=0 ; $i<$x ; $i++){
				if($i!=$y) $Y[]=$X[$i];
			}
			sort($Y);
			return $Y;
		}
	}
	
	function ComposanteCnx($mat,$x){
		return CalculGammaPlus(desorientation($mat),$x);
	}
	
	function CalculCCF($mat, $x){
		$Gp=CalculGammaPlus($mat, $x);
		$Gm=CalculGammaMoins($mat, $x);
		
		$res=array();
		foreach($Gp as $a){
			if(in_array($a, $Gm)) $res[]=$a;
		}
		return $res;
	}
	
	function CalculGRed($mat){
		global $alphabet;
		
		$n=count($mat);
		
		$liste_somm=array();
		$CCF=array();
		while(count($liste_somm)<$n){
			//Recherche d'un somment
			$i=0;
			while($i<$n){
				if(!in_array($alphabet[$i],$liste_somm)) {
					$x=$i;
					break;
				}
				$i++;
			}
			$X = CalculCCF($mat, $x);
			$CCF[]=$X;
			$liste_somm=array_merge($liste_somm, $X);
		}
		
		//Calcul de la matrice 
		$N=count($CCF);
		$res=array();
		for($i=0 ; $i<$N ; $i++){
			$res[$i]=array();
			for($j=0 ; $j<$N ; $j++){
				$res[$i][$j]=0;
				for($a=0 ; $a<$n and $res[$i][$j]==0 ; $a++){
					for($b=0 ; $b<$n and $res[$i][$j]==0; $b++){
						if(in_array($alphabet[$a], $CCF[$i]) and in_array($alphabet[$b], $CCF[$j]) and $mat[$a][$b]==1) $res[$i][$j]=1;
					}
				}
			}
		}
		
		return $res;	
	}
	
	function CalculDegres($mat){
		$n=count($mat);
		$res=array();
		for($i=0 ; $i<$n ; $i++){
			$res[$i]=0;
			for($j=0 ; $j<$n ; $j++){
				if($mat[$i][$j]!=0)$res[$i]++;
			}
		}
		return $res;
	}
		
	function CalculDemiDegresExt($mat){
		$n=count($mat);
		$res=array();
		for($i=0 ; $i<$n ; $i++){
			$res[$i]=0;
			for($j=0 ; $j<$n ; $j++) $res[$i]+=$mat[$i][$j];
		}
		return $res;
	}
	
	function CalculDemiDegresInt($mat){
		$n=count($mat);
		$res=array();
		for($j=0 ; $j<$n ; $j++){
			$res[$j]=0;
			for($i=0 ; $i<$n ; $i++) $res[$j]+=$mat[$i][$j];
		}
		return $res;
	}
	
	function ExisteCirEuler($mat){
		$Ext = CalculDemiDegresExt($mat);
		$Int = CalculDemiDegresInt($mat);
		$n=count($mat);
		for($i=0 ; $i<$n ; $i++){
			if($Ext[$i]!=$Int[$i]) return false;
		}
		return true;
	}
	
	function ExisteCirEulerNon($mat){
		$n=count($mat);
		if(count(ComposanteCnx($mat,0))!=$n) return false;
		
		$Deg = CalculDegres($mat);
		for($i=0 ; $i<$n ; $i++){
			if($Deg[$i]%2==1) return false;
		}
		return true;
	}
	
	function ExisteChaineEuler($mat){
		$Ext = CalculDemiDegresExt($mat);
		$Int = CalculDemiDegresInt($mat);
		$dep=true;
		$arr=true;
		$n=count($mat);
		for($i=0 ; $i<$n ; $i++){
			if($Ext[$i]!=$Int[$i]){
				if($dep and $Ext[$i]==$Int[$i]+1) $dep=false;
				elseif($arr and $Int[$i]==$Ext[$i]+1) $arr=false;
				else return false;
			}
		}
		return true;
	}
	
	function ExisteChaineEulerNon($mat){
		$Deg = CalculDegres($mat);
		$cmp=0;//On compte le nombre d'impaire
		$n=count($mat);
		for($i=0 ; $i<$n ; $i++){
			if($Deg[$i]%2==1) $cmp++;
		}
		if($cmp<=2) return true;
		return false;
	}
	
	//Retourne le tableau de l'algo de Brelaz
	function Brelaz($mat){
		global $alphabet;
		$Alphabet = str_split($alphabet);
		
		$Couleur=array("red", "blue", "green", "yellow", "cyan", "magenta", "olive", "orange", "purple", "pink", "teal", "lime", "brown");
		shuffle($Couleur);
		
		$n=count($mat);
		$res=array();
		for($i=0 ; $i<$n+2 ; $i++) {
			$res[$i]=array();
			if($i==0) $res[$i][0]="Som";
			elseif($i==$n+1) $res[$i][0]="Coul";
			else $res[$i][0] = "DSAT_{".($i)."}";
		}
		
		//Initialisation
		$deg=CalculDegres($mat);
		
		/***************
				TRI
			****************/	
		$DEG=array();
		//recherche du max dans $deg
		while(count($deg)>0){
			$max=current($deg);
			foreach($deg as $clef=>$val){
				if($val>$max) $max=$val;
			}
			//Inscription et suppression des entrées à valeur $max
			foreach($deg as $clef=>$val){
				if($val==$max){
					$DEG[$clef]=$val;
					unset($deg[$clef]);
				}
			}
		}
		$deg=$DEG;
		
		$j=1;
		foreach($deg as $somm=>$deg_){
			$res[0][$j] = $alphabet[$somm];
			$res[1][$j] = $deg_;
			$res[$n+1][$j] = 0;
			$j++;
		}
		for($i=2 ; $i<=$n ; $i++){
			for($j=1 ; $j<=$n ; $j++) $res[$i][$j]="";
		}
		
		//Itération
		for($i=2 ; $i<=$n ; $i++){
			//On prend le plus grand de la ligne du dessus ($i-1)
			$_max = -1;
			for($j=1 ; $j<=$n ; $j++){
				if(is_int($res[$i-1][$j]) and $_max<$res[$i-1][$j]){
					$somm=array_search($res[0][$j], $Alphabet);// clef \in [0; n-1]
					$_max=$res[$i-1][$j];
				}
			}
			
			//On séléctionne la couleur du sommet $somm
			$x=1;
			for($j=0 ; $j<$n ; $j++){
				if($mat[$somm][$j]!=0 and $res[$n+1][array_search($alphabet[$j], $res[0])]==$x){
					$j=-1; 
					$x++;
				}
			}
			
			//On inscrit la couleur
			for($k=$i ; $k<=$n ; $k++){
				if(isset($Couleur[$x-1])) $res[$k][array_search($alphabet[$somm], $res[0])]="{\\color{".$Couleur[$x-1]."} \\blacksquare}";
				else $res[$k][array_search($alphabet[$somm], $res[0])]="{X}";
			}
			$res[$n+1][array_search($alphabet[$somm], $res[0])]=$x;
			
			//On calcul le DSAT_i
			for($j=1 ; $j<=$n ; $j++){
				if(isset($res[$i][$j]) and strpos($res[$i][$j], "square")!==false) continue;
				
				$somm = array_search($res[0][$j], $Alphabet);
				//Pour ce sommet on compte le nombre de voisin colorié
				$nb_voi_col=0;
				for($k=0 ; $k<$n ; $k++){
					//on regarde si le sommet $k est colorié
					if($mat[$somm][$k]!=0 and $res[$n+1][array_search($alphabet[$k], $res[0])]>0) $nb_voi_col++;
				}
				if($nb_voi_col==0) $res[$i][$j] = $res[$i-1][$j];
				else $res[$i][$j]=$nb_voi_col;
			}
			
			//Fin
		}

		//Cas de la dernière ligne
		for($j=1 ; $j<=$n ; $j++){
			if($res[$n+1][$j]==0) $somm=array_search($res[0][$j], $Alphabet);// clef \in [0; n-1]
		}
		
		//On séléctionne la couleur du sommet $somm
		$x=1;
		for($j=0 ; $j<$n ; $j++){
			if($mat[$somm][$j]!=0 and $res[$n+1][array_search($alphabet[$j], $res[0])]==$x){
				$j=-1; 
				$x++;
			}
		}
		
		//On inscrit la couleur
		$res[$n+1][array_search($alphabet[$somm], $res[0])]=$x;
		
		return $res;
	}//Retourne le tableau de l'algo de Brelaz
	
	//Comme Brelaz mais avec des erreurs
	function AlterBrelaz($mat){
		global $alphabet;
		$Alphabet = str_split($alphabet);
		$n=count($mat);
		
		$ERR = mt_rand(1,2);
		/*
			1 = les sommets non rangés dans l'ordre décroissant des degrés
			2 = On attribue pas la bonne couleur à un sommet
		*/
		if($ERR==2) $ERR_rand = mt_rand(2, $n-1);
		
		$Couleur=array("red", "blue", "green", "yellow", "cyan", "magenta", "olive", "orange", "purple", "pink", "teal", "lime", "brown");
		shuffle($Couleur);
		
		$res=array();
		for($i=0 ; $i<$n+2 ; $i++) {
			$res[$i]=array();
			if($i==0) $res[$i][0]="Som";
			elseif($i==$n+1) $res[$i][0]="Coul";
			else $res[$i][0] = "DSAT_{".($i)."}";
		}
		
		//Initialisation
		$deg=CalculDegres($mat);
		if($ERR!=1) arsort($deg);
		$j=1;
		foreach($deg as $somm=>$deg_){
			$res[0][$j] = $alphabet[$somm];
			$res[1][$j] = $deg_;
			$res[$n+1][$j] = 0;
			$j++;
		}
		for($i=2 ; $i<=$n ; $i++){
			for($j=1 ; $j<=$n ; $j++) $res[$i][$j]="";
		}
		
		//Itération
		for($i=2 ; $i<=$n ; $i++){
			//On prend le plus grand de la ligne du dessus ($i-1)
			$_max = -1;
			for($j=1 ; $j<=$n ; $j++){
				if(is_int($res[$i-1][$j]) and $_max<$res[$i-1][$j]){
					$somm=array_search($res[0][$j], $Alphabet);// clef \in [0; n-1]
					$_max=$res[$i-1][$j];
				}
			}
			if($ERR==2 and $i==$ERR_rand){
				do{
					$somm2=mt_rand(0, $n-1);
				}while($somm2==$somm or strpos($res[$i-1][$somm2+1], "square")!==false);	
			}
			
			//On séléctionne la couleur du sommet $somm
			$x=1;
			for($j=0 ; $j<$n ; $j++){
				if($mat[$somm][$j]!=0 and $res[$n+1][array_search($alphabet[$j], $res[0])]==$x){
					$j=-1; 
					$x++;
				}
			}
			if($ERR==2 and $i==$ERR_rand) $x++;
			
			//On inscrit la couleur
			for($k=$i ; $k<=$n ; $k++){
				if(isset($Couleur[$x-1])) $res[$k][array_search($alphabet[$somm], $res[0])]="{\\color{".$Couleur[$x-1]."} \\blacksquare}";
				else $res[$k][array_search($alphabet[$somm], $res[0])]="{X}";
			}
			$res[$n+1][array_search($alphabet[$somm], $res[0])]=$x;
			
			//On calcul le DSAT_i
			for($j=1 ; $j<=$n ; $j++){
				if(isset($res[$i][$j]) and strpos($res[$i][$j], "square")!==false) continue;
				
				$somm = array_search($res[0][$j], $Alphabet);
				//Pour ce sommet on compte le nombre de voisin colorié
				$nb_voi_col=0;
				for($k=0 ; $k<$n ; $k++){
					//on regarde si le sommet $k est colorié
					if($mat[$somm][$k]!=0 and $res[$n+1][array_search($alphabet[$k], $res[0])]>0) $nb_voi_col++;
				}
				if($nb_voi_col==0) $res[$i][$j] = $res[$i-1][$j];
				else $res[$i][$j]=$nb_voi_col;
			}
			
			//Fin
		}

		//Cas de la dernière ligne
		for($j=1 ; $j<=$n ; $j++){
			if($res[$n+1][$j]==0) $somm=array_search($res[0][$j], $Alphabet);// clef \in [0; n-1]
		}
		
		//On séléctionne la couleur du sommet $somm
		$x=1;
		for($j=0 ; $j<$n ; $j++){
			if($mat[$somm][$j]!=0 and $res[$n+1][array_search($alphabet[$j], $res[0])]==$x){
				$j=-1; 
				$x++;
			}
		}
		
		//On inscrit la couleur
		$res[$n+1][array_search($alphabet[$somm], $res[0])]=$x;
		
		return $res;
	}
	
	//Retourne le nombre de couleur selon Brelaz
	function NbCoulBrelaz($mat){
		$n=count($mat);
		$X=Brelaz($mat);
		
		return max($X[$n+1]);
	}
	
	function AffBrelaz($X){
		$n=count($X)-2;
		$res="\\begin{array}{|c||*{".($n)."}{c|}}\\hline ";
		for($i=0 ; $i<$n+2 ; $i++){
			for($j=0 ; $j<$n+1 ; $j++) {
				$res.= $X[$i][$j];
				if($j<$n) $res.=" & ";
			}
			$res.="\\\\\\hline ";
		}
		$res.="\\end{array}";
		return $res;
	}
	
	//On modifie la matrice $mat par l'ajout ou la suppression de 1
	function alterMatNon($mat){
		
		$n=count($mat);
		if(mt_rand(0,1)==0){
			//ajout de 1
			$tmp=0;
			do{
				$lig = mt_rand(0,$n-1);
				$col = mt_rand(0,$n-1);
				$tmp++;
			}while($mat[$lig][$col]==1 and $tmp<19);
			if($mat[$lig][$col]==1) return alterMatNon($mat);
			$mat[$lig][$col]=1;
			$mat[$col][$lig]=1;
		}
		else{
			//suppression de 1
			$tmp=0;
			do{
				$lig = mt_rand(0,$n-1);
				$col = mt_rand(0,$n-1);
				$tmp++;
			}while($mat[$lig][$col]==0 and $tmp<19);
			if($mat[$lig][$col]==0) return alterMatNon($mat);
			$mat[$lig][$col]=0;
			$mat[$col][$lig]=0;
		}
		
		return $mat;
		
	}
	
	//Retourne la matrice mat sans lig col
	function extract_mat($mat, $lig, $col){
		$n=count($mat);
		$res=array();
		$l=0; 
		for($i=0 ; $i<$n ; $i++){
			if($i==$lig) continue;
			$res[$l]=array();
			$c=0;
			for($j=0 ; $j<$n ; $j++){
				if($j==$col) continue;
				$res[$l][$c]=$mat[$i][$j];
				$c++;
			}
			$l++;
		}
		return $res;
	}
	
	//Renvoie le plus grand N tel que K_n soit dans G
	function TrouveCliqueDedansNon($mat){
		$n=count($mat);
		for($i=0 ; $i<$n ; $i++){			
			for($j=$i+1 ; $j<$n ; $j++){
				if($mat[$i][$j]==0) {
					$X=TrouveCliqueDedansNon(extract_mat($mat, $i, $i));
					$Y=TrouveCliqueDedansNon(extract_mat($mat, $j, $j));
					if($X>$Y) return $X;
					return $Y;
				}
			}
		}
		return $n;
	}
	
	//Sort une matrice non orienté à n sommets qui contient une clique à $k sommets
	//Si $k>$n on renvoie \Kk_n
	function matrice_non_oriente_avec_clique($n, $k){
		$mat=matrice_non_oriente($n);
		
		if($k>$n) $k=$n;
		if($k<=0) return $mat;
		$clef = array_rand(range(0, $n-1), $k);
		
		for($i=0 ; $i<$k ; $i++){
			for($j=$i+1 ; $j<$k ; $j++) {
				$mat[$clef[$i]][$clef[$j]]=1;
				$mat[$clef[$j]][$clef[$i]]=1;
			}
		}
		
		return $mat;
	}

	//Génère une matrice orienté et valué à n sommets. La valuation max est $M
	function matrice_oriente_val($n, $M){
		$mat=array();
		for($i=0; $i<$n ; $i++){
			$mat[$i]=array();
			for($j=0 ; $j<$n ; $j++) {
				if(mt_rand(0,1)==0) $mat[$i][$j]=0;
				else $mat[$i][$j]=mt_rand(1, $M);
			}
		}
		return $mat;
	}
	
	//Génère une matrice non orienté et valué à n sommets. La valuation max est $M
	function matrice_non_oriente_val($n, $M){
		$mat=array();
		for($i=0; $i<$n ; $i++) $mat[$i]=array();
		for($i=0; $i<$n ; $i++){
			$mat[$i][$i] = 0;
			for($j=$i+1 ; $j<$n ; $j++) {
				if(mt_rand(0,1)==0){
					$mat[$i][$j]=0;
					$mat[$j][$i]=0;
				}
				else{
					$tmp=mt_rand(1, $M);
					$mat[$i][$j]=$tmp;
					$mat[$j][$i]=$tmp;
				}
			}
		}
		return $mat;
	}
	
	//Retourne le tableau de Dijkstra ou prim suivant le modepartant du sommet $s
	//Mode 0 = Dijkstra
	//Mode 1 = Prim
	function DJP($mode, $mat, $s){
		global $alphabet;
		$n=count($mat);
		
		//Initialisation
		$res=array();
		$res[0]=array();
		$res[0][0]="Som";
		for($j=1 ; $j<=$n ; $j++) $res[0][$j]=$alphabet[$j-1];
		for($i=1 ; $i<=$n ; $i++){
			$res[$i]=array();
			for($j=0 ; $j<=$n ; $j++){
				if($i==1 and $j-1==$s) $res[$i][$j]=0;
				else $res[$i][$j]="";
			}
		}
		$res[1][0]="Init";
		
		//Itération
		for($i=2 ; $i<=$n ; $i++){
		
			//Le min de la case d'avant
			unset($somm);
			for($j=1 ; $j<=$n ; $j++){
				if(is_int($res[$i-1][$j]) and !isset($somm)) $somm=$j-1;
				if(is_int($res[$i-1][$j]) and $res[$i-1][$j]<$res[$i-1][$somm+1]) $somm=$j-1;
			}
			//On remet la ligne $i-1
			for($j=1 ; $j<=$n ; $j++) $res[$i][$j]=$res[$i-1][$j];
			
			if(!isset($somm)) continue;
			
			//Sommet séléctionné
			$res[$i][0]=$alphabet[$somm];
			
			//On tue le sommet
			for($k=$i ; $k<=$n ; $k++) $res[$k][$somm+1]="X";
			
			//Gestion des modes
			if($mode==0) $add = $res[$i-1][$somm+1];
			if($mode==1) $add = 0; 
			//On parcours et on met à jour si besoin.
			for($j=1 ; $j<=$n ; $j++){
				if($res[$i][$j]=="X") continue;
				if($mat[$somm][$j-1]>0){
					if(!is_int($res[$i][$j])) $res[$i][$j] = $mat[$somm][$j-1]+$add;
					else{
						if($res[$i][$j]>$add+$mat[$somm][$j-1]) $res[$i][$j]=$add+$mat[$somm][$j-1];
					}
				}
			}
			
		}
		
		return $res;
	}
	
	//CommeDJP mais avec une erreur
	function AlterDJP($mode, $mat, $s){
		global $alphabet;
		$n=count($mat);
		
		//Initialisation
		$res=array();
		$res[0]=array();
		$res[0][0]="Som";
		for($j=1 ; $j<=$n ; $j++) $res[0][$j]=$alphabet[$j-1];
		for($i=1 ; $i<=$n ; $i++){
			$res[$i]=array();
			for($j=0 ; $j<=$n ; $j++){
				if($i==1 and $j-1==$s) $res[$i][$j]=0;
				else $res[$i][$j]="";
			}
		}
		$res[1][0]="Init";
		
		//Itération
		for($i=2 ; $i<=$n ; $i++){
		
			//Le min de la case d'avant
			unset($somm);
			for($j=1 ; $j<=$n ; $j++){
				if(is_int($res[$i-1][$j]) and !isset($somm)) $somm=$j-1;
				if(is_int($res[$i-1][$j]) and $res[$i-1][$j]<$res[$i-1][$somm+1]) $somm=$j-1;
			}
			//On remet la ligne $i-1
			for($j=1 ; $j<=$n ; $j++) $res[$i][$j]=$res[$i-1][$j];
			
			if(!isset($somm)) continue;
			
			//Sommet séléctionné
			$res[$i][0]=$alphabet[$somm];
			
			//On tue le sommet
			for($k=$i ; $k<=$n ; $k++) $res[$k][$somm+1]="X";
			
			//Gestion des modes
			if($mode==0) $add = $res[$i-1][$somm+1];
			if($mode==1) $add = 0; 
			//On parcours et on met à jour si besoin.
			for($j=1 ; $j<=$n ; $j++){
				if($res[$i][$j]=="X") continue;
				if($mat[$somm][$j-1]>0){
					if(!is_int($res[$i][$j])) $res[$i][$j] = $mat[$somm][$j-1]+$add+mt_rand(1,2);//Ajout d'1 erreur ici
					else{
						if($res[$i][$j]>$add+$mat[$somm][$j-1]) $res[$i][$j]=$add+$mat[$somm][$j-1];
					}
				}
			}
		}
		
		return $res;
	}
	
	//X est un tableau de DJP
	function AffDJP($X){
		$n=count($X);
		
		//Recherche des valeurs à encadrer dans chaque colonne
		$enc=array();
		for($j=1 ; $j<$n ; $j++){
			for($i=1 ; $i<$n ; $i++){
				if(is_int($X[$i][$j]) and !isset($enc[$j])) $enc[$j]=$i;
				if(is_int($X[$i][$j]) and isset($enc[$j]) and $X[$i][$j]<$X[$enc[$j]][$j]) $enc[$j]=$i;
			}
		}
		
		$res="\\begin{array}{|c|*{".($n-1)."}{c|}}\\hline ";
		for($i=0 ; $i<$n ; $i++){
			for($j=0 ; $j<$n ; $j++){
				if(isset($enc[$j]) and $i==$enc[$j]) $res.="\\boxed{".$X[$i][$j]."}";
				else $res.=$X[$i][$j];
				if($j<$n-1) $res.=" & ";
			}
			$res.="\\\\\\hline ";
		}
		$res.="\\end{array}";
		
		return $res;
	}
	
	//Retourne un tableau ou la première case est le plus court chemin entre $a et $b et la deuxième case est la distance
	function PlusCourtChemin($mat, $a, $b){
		
		global $alphabet;
		
		$X=DJP(0,$mat, $a);
		$n=count($mat);
		
		$res=array();
		$res[0]="";
		$res[1]="+\\infty";
		
		//Recherche des sommets proches
		$SP=array();
		for($j=0 ; $j<$n ; $j++){
			for($i=0 ; $i<$n ; $i++){
				if(is_int($X[$i+1][$j+1]) and !isset($SP[$j])) $SP[$j]=$i;
				if(is_int($X[$i+1][$j+1]) and isset($SP[$j]) and $X[$i+1][$j+1]<$X[$SP[$j]+1][$j+1]) $SP[$j]=$i;
			}
		}
		if(!isset($SP[$b])) return $res;
		
		$res[1]=$X[$SP[$b]+1][$b+1];
		while($b!=$a){
			$res[0]=$alphabet[$b].$res[0];
			$b=strpos($alphabet, $X[$SP[$b]+1][0]);
		}
		$res[0]=$alphabet[$a].$res[0];
		return $res;
	
	}
	
	//Prend un tableau de Prim et retourne la liste des aretes de l'arbre couvrant de poids minimal.
	//Liste vide si graphe non connexe
	function ArbreCouvrant($X){
		global $alphabet;
		
		$n=count($X)-1;
		$res=array();
		//Recherche des sommets proches
		$SP=array();
		for($j=0 ; $j<$n ; $j++){
			for($i=0 ; $i<$n ; $i++){
				if(is_int($X[$i+1][$j+1]) and !isset($SP[$j])) $SP[$j]=$i;
				if(is_int($X[$i+1][$j+1]) and isset($SP[$j]) and $X[$i+1][$j+1]<$X[$SP[$j]+1][$j+1]) $SP[$j]=$i;
			}
		}
		if(count($SP)!=$n) return $res;
		
		for($j=0 ; $j<$n ; $j++){
			if($X[$SP[$j]+1][0]!="Init") $res[]="\\{".$alphabet[$j].$X[$SP[$j]+1][0]."\\}";
		}
		
		return $res;
	
	}
	
	//Prend un tableau de prim et renvoie le poids de l'arbre
	//"" en cas de non existence
	function CalculPoids($X){
		
		$n=count($X)-1;
		//Recherche des sommets proches
		$SP=array();
		$res=0;
		for($j=0 ; $j<$n ; $j++){
			for($i=0 ; $i<$n ; $i++){
				if(is_int($X[$i+1][$j+1]) and !isset($SP[$j])) $SP[$j]=$i;
				if(is_int($X[$i+1][$j+1]) and isset($SP[$j]) and $X[$i+1][$j+1]<$X[$SP[$j]+1][$j+1]) $SP[$j]=$i;
			}
			if(isset($SP[$j])) $res+=$X[$SP[$j]+1][$j+1];
			else return "";
		}
		return $res;
	}
	
	//Retourne toutes les arêtes qui ne sont pas dans l'arbre de Prim
	function ArbreCouvrantComplementaire($X){
		global $alphabet;
		
		$n=count($X)-1;
		$Are=array();
		//Recherche des sommets proches
		$SP=array();
		for($j=0 ; $j<$n ; $j++){
			for($i=0 ; $i<$n ; $i++){
				if(is_int($X[$i+1][$j+1]) and !isset($SP[$j])) $SP[$j]=$i;
				if(is_int($X[$i+1][$j+1]) and isset($SP[$j]) and $X[$i+1][$j+1]<$X[$SP[$j]+1][$j+1]) $SP[$j]=$i;
			}
		}
		
		for($j=0 ; $j<$n ; $j++){
			if(isset($SP[$j]) and $X[$SP[$j]+1][0]!="Init") $Are[]=$alphabet[$j].$X[$SP[$j]+1][0];
		}
		
		$res=array();
		for($i=0 ; $i<$n ; $i++){
			for($j=$i+1 ; $j<$n ; $j++){
				if(array_search($alphabet[$i].$alphabet[$j], $Are)===false and array_search($alphabet[$j].$alphabet[$i], $Are)===false) $res[]="\\{".$alphabet[$i].$alphabet[$j]."\\}";
			}
		}
		
		return $res;
	}
	
	//renvoie un circuit de caractère correspondant à une chaine eulérienne dans le cas non orienté
	function CalculCircuitEulerienneNon($mat){
		$res="";
		$mat2=$mat;
		$n=count($mat);
		$comp=0;
		$b=0;
		if(ExisteCirEulerNon($mat)){
			//Tant qu'il y a des 1 dans la matrice on continue
			$BLOC=array();
			$cir=array();
			while(true){		
				unset($x);
				unset($y);
				
				//Point de départ $x
				if(count($cir)==0){
					for($i=0 ; $i<$n; $i++){
						for($j=0 ; $j<$n ; $j++){
							if($mat2[$i][$j]!=0) break;
						}
						if(isset($mat2[$i][$j]) and $mat2[$i][$j]!=0) break;
					}
					if( !isset($mat2[$i][$j]) ) break;
					$cir[$comp]=$i;
					$comp++;
					$cir[$comp]=$j;
					$comp++;
					$mat2[$i][$j]=0;
					$mat2[$j][$i]=0;
					continue;
				}
				$x=end($cir);
				
				//On cherche le premier voisin $y
				for($j=0 ; $j<$n ; $j++){
					if($mat2[$x][$j]!=0) {
						$y=$j;
						break;
					}
				}
				if(!isset($y)) break;
		
				//On enlève le 1
				$mat2[$x][$y]=0;
				$mat2[$y][$x]=0;
				
				//On rajoute le sommet
				$cir[$comp]=$y;
				$comp++;
				
				//Si ce sommet est le premier stop
				if($y==$cir[0]){					
					$BLOC[$b]=$cir;
					$cir=array();
					$comp=0;
					$b++;
				}
			}
			//Construction du circuit
			global $alphabet;
			$bloc=array();
			$N=count($BLOC);
			for($i=0 ; $i<$N ; $i++){
				$n=count($BLOC[$i]);
				$bloc[$i]="";
				for($j=0 ; $j<$n ; $j++) $bloc[$i].=$alphabet[$BLOC[$i][$j]];
			}
			
			$res.=$bloc[0];
			for($i=1 ; $i<$N ; $i++) {
				$res2=$res;
				$res="";
				
				$A = strpos($res2, $bloc[$i][0]);
				$k=0;
				while($k<$A) {
					$res.=$res2[$k];
					$k++;
				}
				$res.=$bloc[$i];
				$k++;
				while($k<strlen($res2)) {
					$res.=$res2[$k];
					$k++;
				}
			}
		}	
			
		return $res;
	}
	
	//renvoie true s'il y a un circuit false sinon
	function IsCircuit($mat){
		
		$n=count($mat);
		$somm=array();
		//Initialisation
		$pred = array();
		for($j=0 ; $j<$n ; $j++){
			$pred[$j]=array();
			for($i=0 ; $i<$n ; $i++){
				if($mat[$i][$j]==1) $pred[$j][]=$i;
			}
		}
		while(count($somm)<$n){
			//On selectionne les sources//Si impossible return false
			$src=array();
			for($i=0 ; $i<$n ; $i++){
				if(in_array($i, $somm)) continue;
				if(count($pred[$i])==0) $src[]=$i;
			}
			$c=count($src);
			if($c==0) return true;
			
			//On supprime les éléments de src dans la liste des pred
			$cop_pred=$pred;
			$pred=array();
			for($i=0 ; $i<$n ; $i++){
				$pred[$i]=array();
				foreach($cop_pred[$i] as $x){
					if(!in_array($x, $src)) $pred[$i][]=$x;
				}
			}
			
			//On rajoute les éléments de src à la liste des sommets visités
			foreach($src as $s) $somm[]=$s;
		}
		return false;
	}
	
	//Génère une matrice sans circuit de taille $n
	function geneR_ss_circuit($n){
	
		//On construit une matrice triangulaire supérieur		
		$mat=array();
		$res=array();
		for($i=0 ; $i<$n ; $i++){
			$mat[$i]=array();
			$res[$i]=array();
			for($j=0 ; $j<$n ; $j++){
				$mat[$i][$j]=0;
				$res[$i][$j]=0;
			}
		}
		
		$X=array(0,0,1); //on met deux fois plus de 0;
		for($i=0 ; $i<$n ; $i++){
			for($j=$i+1 ; $j<$n ; $j++) $mat[$i][$j]=$X[array_rand($X)];
		}
		
		//On mélange les lignes/colonnes
		$mel=range(0, $n-1);shuffle($mel);shuffle($mel);shuffle($mel);
		for($i=0 ; $i<$n ; $i++){
			for($j=0 ; $j<$n ; $j++) $res[$i][$j]=$mat[$mel[$i]][$mel[$j]];
		}
	
		return $res;
	}
	
	//Algo de filtration par les sources
	//Retourne un tableau ou
	//	la case 0 est la numérotation (tableau=fonction de mélange)
	// 	la case 1 est les niveaux de sources
	//ATTENTION ON NE VERIFIE PAS QUE LA MATRICE EST SS CIRCUIT
	function Filtration_sources($mat){
		
		$n=count($mat);
		
		$bonne_num=array();//Bonne numérotation
		$pred=array();//Prédécésseur
		
		//Liste des prédécesseurs
		for($j=0 ; $j<$n ; $j++){
			$bonne_num[$j]=-1;
			$pred[$j]=array();
			for($i=0 ; $i<$n ; $i++){
				if($mat[$i][$j]>0) $pred[$j][]=$i;
			}	
		}
		
		$src=array();
		$num = 0; 
		$num_couche = 0;
		//Algo
		$test=true;
		while($test){
			$src[$num_couche]=array();
			for($j=0; $j<$n ; $j++){
				if($bonne_num[$j]==-1 and count($pred[$j])==0){
					//On ajoute $j dans le niveau de source
					$src[$num_couche][]=$j;
					
					//On numérote $j
					$bonne_num[$j]=$num;
					$num++;
				}
			}
			
			//On supprime les éléments de $src[$num_couche] de la liste des prédécesseurs
			foreach($src[$num_couche] as $J){
				for($j=0 ; $j<$n ; $j++){
					foreach($pred[$j] as $k=>$predJ){
						if($predJ==$J) unset($pred[$j][$k]);
					}
				}
			}
			
			//on change de niveau de source
			$num_couche++;
			
			//On test la continuation
			$test=false;
			for($j=0 ; $j<$n ; $j++){
				if($bonne_num[$j]==-1 and count($pred[$j])==0) $test=true;
			}

		}
		
		return array($bonne_num, $src);
		
	}
	
	//Algo de filtration par les puits
	//Retourne un tableau ou
	//	la case 0 est la numérotation (tableau=fonction de mélange)
	// 	la case 1 est les niveaux de puits
	//ATTENTION ON NE VERIFIE PAS QUE LA MATRICE EST SS CIRCUIT
	function Filtration_puits($mat){
		
		$n=count($mat);
		
		$bonne_num=array();//Bonne numérotation
		$succ=array();//Successeurs
		
		//Liste des successeurs
		for($j=0 ; $j<$n ; $j++){
			$bonne_num[$j]=-1;
			$succ[$j]=array();
			for($i=0 ; $i<$n ; $i++){
				if($mat[$j][$i]>0) $succ[$j][]=$i;
			}	
		}
		
		$puits=array();
		$num = $n+1; 
		$num_couche = 0;
		//Algo
		$test=true;
		while($test){
			$puits[$num_couche]=array();
			for($j=0; $j<$n ; $j++){
				if($bonne_num[$j]==-1 and count($succ[$j])==0){
					//On ajoute $j dans le niveau de puits
					$puits[$num_couche][]=$j;
					
					//On numérote $j
					$bonne_num[$j]=$num;
					$num--;
				}
			}
			
			//On supprime les éléments de $puits[$num_couche] de la liste des successeurs
			foreach($puits[$num_couche] as $J){
				for($j=0 ; $j<$n ; $j++){
					foreach($succ[$j] as $k=>$succJ){
						if($succJ==$J) unset($succ[$j][$k]);
					}
				}
			}
			
			//on change de niveau de source
			$num_couche++;
			
			//On test la continuation
			$test=false;
			for($j=0 ; $j<$n ; $j++){
				if($bonne_num[$j]==-1 and count($succ[$j])==0) $test=true;
			}

		}
		
		return array($bonne_num, $puits);
		
	}
	

	//rajoute des Arêtes jusqu'à obtenir un circuit - cas non orienté
	//Si pas réussi (parce que c'est juste pas possible comme K_4 par exemple ou si le graphe est pas cnx) alors on revoie la matrice
	//La valeur de retour est augmenter par un chaine de caractère expliquant ce qu'on a rajouter
	function ConstruitCircuitNon($mat){
		
		global $alphabet;
	
		$n=count($mat);
		if(count(ComposanteCnx($mat,0))!=$n) return $mat2;
		
		$res='';
		$mat2=$mat;
		for( $blabla = 0; $blabla<$n*$n and !ExisteCirEulerNon($mat) ; $blabla++){
			//On compte le nombre de sommet impaire			
			
			$DEG = CalculDegres($mat);
			$imp=array();
			for($i=0 ; $i<$n ; $i++){
				if($DEG[$i]%2==1) $imp[]=$i;
			}
			
			//jumelage de deux impaires
			for($i=0 ; $i<count($imp) ; $i++){
				for($j=$i+1 ; $j<count($imp) ; $j++){
					if($mat[$imp[$i]][$imp[$j]]==0){
						$mat[$imp[$i]][$imp[$j]]=1;
						$mat[$imp[$j]][$imp[$i]]=1;
						$res.=" On ajoute une ar\\^ete entre ".$alphabet[$imp[$i]]." et ".$alphabet[$imp[$j]].". ";
						
						//Mise à jour des imp
						$DEG = CalculDegres($mat);
						$imp=array();
						for($i=0 ; $i<$n ; $i++){
							if($DEG[$i]%2==1) $imp[]=$i;
						}
						
						//On recommence
						$i=-1;
						break;
					}
				}
			}
			
			//On passe par un autre sommet.
			//pour chaque sommet $imp[$i] $imp[$j] on cherche un sommet $k qui peut les accueillir
			for($i=0 ; $i<count($imp) ; $i++){
				for($j=$i+1 ; $j<count($imp) ; $j++){
					
					for($k=0 ; $k<9 ; $k++){
						if($mat[$imp[$i]][$k]==0 and $mat[$imp[$j]][$k]==0){
							$mat[$imp[$i]][$k]=1;
							$mat[$k][$imp[$i]]=1;
							$mat[$k][$imp[$j]]=1;
							$mat[$imp[$j]][$k]=1;
							$res.=" On ajoute une ar\\^ete entre ".$alphabet[$imp[$i]]." et ".$alphabet[$k]."
								    ainsi qu'une ar\\^ete entre ".$alphabet[$k]." et ".$alphabet[$imp[$j]].". ";
								
							
							//Mise à jour des imp
							$DEG = CalculDegres($mat);
							$imp=array();
							for($i=0 ; $i<$n ; $i++){
								if($DEG[$i]%2==1) $imp[]=$i;
							}
							
							//On recommence
							$i=-1;
							$j=count($mat);
							break;
						}
					}  
					
				}
			}
			
			//Sinon on met un 1 n'importe ou et on recommence
			if(!ExisteCirEulerNon($mat)){
				do{
					$i=mt_rand(0, $n-2);
					$j=mt_rand($i+1, $n-1);
				}while($mat[$i][$j]==1);
				$mat[$i][$j]=1;
				$mat[$j][$i]=1;
				$res.=" On ajoute une ar\\^ete entre ".$alphabet[$i]."".$alphabet[$j].". ";				
			}
		}
		
		if(!ExisteCirEulerNon($mat)) return array($mat2, "");
		return array($mat, $res);
	}
	
	//Renvoie les indices des sommets du noyau s'il existe
	function Noyau($mat){
		
		$res=array();
		if(IsCircuit($mat)) return $res;
		
		$n=count($mat);
		$somm=range(0,$n-1);
		while(count($somm)>0){
			
			//On prend un puits
			foreach($somm as $i){
				foreach($somm as $j){
					if($mat[$i][$j]==1) break;
				}
				if($mat[$i][$j]==0) break;
			}
			$puits=$i;
			
			$res[]=$puits;
			//on supprime de $somm $puits et les prédécesseurs de $puits
			$somm2=array();
			foreach($somm as $i){
				if($mat[$i][$puits]==1 or $i==$puits) continue;
				$somm2[]=$i;
			}
			$somm=$somm2;
			
		}
		sort($res);
		return $res;
	}
	
	//Comme noyau mais avec une erreur
	function AlterNoyau($mat){
		
		$res=array();
		if(IsCircuit($mat)) return $res;
		
		$n=count($mat);
		$somm=range(0,$n-1);
		$potentiel=array();
		while(count($somm)>0){
			
			//On prend un puits
			foreach($somm as $i){
				foreach($somm as $j){
					if($mat[$i][$j]==1) break;
				}
				if($mat[$i][$j]==0) break;
			}
			$puits=$i;
			
			$res[]=$puits;
			//on supprime de $somm $puits et les prédécesseurs de $puits
			$somm2=array();
			foreach($somm as $i){
				if($mat[$i][$puits]==1 or $i==$puits) {
					if($i!=$puits) $potentiel[]=$i;
					continue;
				}
				$somm2[]=$i;
			}
			$somm=$somm2;
			
		}
		if(count($potentiel)>0){
			$x=count($res);
			if($x>2 and mt_rand(0,1)==1){
				//On supprime une valeur
				$X=array_rand($res, $x-1);
				$res2=array();
				for($k=0 ; $k<$x-1 ; $k++) $res2[]=$res[$X[$k]];
				$res=$res2;
			}
			else $res[]=$potentiel[array_rand($potentiel)];//on rajoute une valeur
		}
		else $res=array_rand($range(0, $n-1), $n-1);//Cas de la matrice nule ou res=tout=range(0, $n-1) - on enlève un sommet;
			
		sort($res);
		return $res;
	}
	
	//Génère un AEF à n états sur l'alphabet sigma
	//Retourne un tableau ou la premiere case est la matrice, la seconde les états initiaux et la denrière les états finaux
	function GenAEF($n, $Sigma, $c=0){
		global $alphabet;
		
		$res=array();
		$s=count($Sigma);
		$R=range(0,$n-1);
		
		//Vecteur donnant le nombre d'état dans une case
		$vect_prob=array();
		for($i=$c ; $i<=$n ; $i++){
			for($k=$i ; $k<=$n ; $k++) $vect_prob[]=$i;
		}
		shuffle($vect_prob);shuffle($vect_prob);shuffle($vect_prob);
		
		//Initialisation
		for($i=0 ; $i<$n+1 ; $i++){
			$res[$i]=array();
			//Ligne $i=0
			if($i==0){
				$res[0][0]="";
				for($j=1 ; $j<$s+1 ; $j++) $res[0][$j]=$j-1;
			}
			else{
			//Autres lignes
				$res[$i][0]=$i-1;
				for($j=1 ; $j<$s+1 ; $j++) $res[$i][$j]=array();
			}
		}
		
		//pour chacune des case on met des trucs dedans ou pas - des indices d'états
		for($i=1 ; $i<$n+1 ; $i++){
			for($j=1 ; $j<$s+1 ; $j++){
				//Nombre d'état dans cette case
				$nb=$vect_prob[array_rand($vect_prob)];
				if($nb>0) {
					$X=array_rand($R, $nb);
					if($nb>1){
						for($k=0 ; $k<$nb ; $k++) $res[$i][$j][] = $R[$X[$k]];
					}
					else $res[$i][$j][] = $R[$X];
					sort($res[$i][$j]);
				}
			}
		}
		
		return array($res, array(mt_rand(0, $n-1)), array(mt_rand(0, $n-1)));
	}
	
	//Comme l'autre mais déterministe
	function GenADEF($n, $Sigma, $c=0){
		global $alphabet;
		
		$res=array();
		$s=count($Sigma);
		$R=range(0,$n-1);
		
		//Vecteur donnant le nombre d'état dans une case
		$vect_prob=array();
		for($i=$c ; $i<=$n ; $i++){
			for($k=$i ; $k<=$n ; $k++) $vect_prob[]=$i;
		}
		shuffle($vect_prob);shuffle($vect_prob);shuffle($vect_prob);
		
		
		//Initialisation
		for($i=0 ; $i<$n+1 ; $i++){
			$res[$i]=array();
			//Ligne $i=0
			if($i==0){
				$res[0][0]="";
				for($j=1 ; $j<$s+1 ; $j++) $res[0][$j]=$j-1;
			}
			else{
			//Autres lignes
				$res[$i][0]=$i-1;
				for($j=1 ; $j<$s+1 ; $j++) $res[$i][$j]=array();
			}
		}
		
		//pour chacune des case on met des trucs dedans ou pas - des indices d'états
		for($i=1 ; $i<$n+1 ; $i++){
			for($j=1 ; $j<$s+1 ; $j++){
				//Nombre d'état dans cette case
				$nb=$vect_prob[array_rand($vect_prob)];
				if($nb>0) {
					$X=array_rand($R);
					$res[$i][$j][] = $R[$X];
					sort($res[$i][$j]);
				}
			}
		}
		
		return array($res, array(mt_rand(0, $n-1)), array(mt_rand(0, $n-1)));
	}
	
	//renvoie le code LaTeX de l'automate $MAT à $n états sur l'alphabet $Sigma
	function AffAutomate($auto, $Sigma, $Etat){
		
		$n=count($Etat);
		$Mat=$auto[0]; 
		$Ini=$auto[1];
		$Fin=$auto[2];
		
		$res="";
		
		$s=count($Sigma);
		$res.="\\begin{array}{c|*{".$n."}{c}}";
		for($i=0 ; $i<$n+1 ; $i++){
			
			for($j=0 ; $j<$s+1 ; $j++){
				if($i==0){
					if($j==0) $res.=$Mat[0][$j];
					else $res.=$Sigma[$Mat[0][$j]];
				}
				else{
					if($j==0){
						if(in_array($i-1, $Ini)) $res.=" \\rightarrow ";
						$res.=$Etat[$Mat[$i][0]];
						if(in_array($i-1, $Fin)) $res.=" \\rightarrow ";
					}
					else{
						$X=$Mat[$i][$j];
						$x=count($X);
						for($k=0 ; $k<$x ; $k++){
							$res.=$Etat[$Mat[$i][$j][$k]];
							if($k<$x-1) $res.=", ";
						}
					}
				}
				if($j<$s) $res.=" & ";
			}
			$res.=" \\\\ ";
			if($i==0) $res.=" \\hline ";
		}
		
		$res.=" \\end{array} ";
		return $res;
	}

	//sort un alphabet
	function GenAlphabet(){
		$Sigma=array();
		$Sigma[]=array('a', 'b');
		$Sigma[]=array('a', 'b', 'c');
		$Sigma[]=array('0', '1');
		$Sigma[]=array('0', '1', '2');
		$Sigma[]=array('\alpha', '\beta');
		$Sigma[]=array('\alpha', '\beta', '\gamma');
		$Sigma[]=array('x', 'y');
		$Sigma[]=array('x', 'y', 'z');
		$Sigma[]=array('u', 'v');
		$Sigma[]=array('u', 'v', 'w');
		
		return $Sigma[mt_rand(0, count($Sigma)-1)];
	}
	
	//Sort la matrice du déterminé
	//La deuxième case c'est les nouveaux états
	function AlgoDeter($AEF, $n, $Sigma){
		$mat = $AEF[0];
		$ini = $AEF[1];
		$fin = $AEF[2];
		$s=count($Sigma);
		
		$res=array();
		$nvxEta=array();
		
		//Initialisation
		$ligne=0; 
		$res[0][0]="";
		for($j=1 ; $j<$s+1 ; $j++) $res[0][$j]=$j-1;
		
		$nvxEta[0]=array();
		foreach($ini as $i) $nvxEta[0][]=$i;
		sort($nvxEta[0]);
		
		$nvxEtaTraite=array();
		
		
		$E=0;
		while(count($nvxEta)>count($nvxEtaTraite)){
			
			//L'état E est traité
			$nvxEtaTraite[]=$E;
			
			//On rajoute ce nouvel état dans une nouvelle ligne
			$ligne++;
			$res[$ligne]=array();
			$res[$ligne][0]=$E;
			for($j=1 ; $j<$s+1 ; $j++){
				$res[$ligne][$j]=array();
				//pour chaque état de $E, on va chercher l'image de la lettre $j
				$X=array();
				foreach($nvxEta[$E] as $e){
					foreach($mat[$e+1][$j] as $x) {
						if(!in_array($x, $X)) $X[]=$x;	
					}
				}
				if(count($X)==0) continue;
				sort($X);
				
				//Si $X n'est pas un nouvel état on le crée.
				if(!in_array($X, $nvxEta)) $nvxEta[]=$X;
				
				$res[$ligne][$j][]=array_search($X, $nvxEta);
			}
			
			$E++;
		}
		
		
		$auto=array();
		$auto[0]=$res;
		$auto[1]=array(0);
		
		//Etat de sortie;
		$auto[2]=array();
		for($i=0 ; $i<$E ; $i++){
			foreach($fin as $f){
				if(in_array($f, $nvxEta[$i]) and !in_array($i, $auto[2])) $auto[2][]=$i;
			}
		}
		
		return array($auto, $nvxEta);
		
	}
	
	//Return true si l'auto est complet
	function isComplet($auto){
		$mat=$auto[0];
		$n=count($mat);
		$m=count($mat[0]);
		
		for($i=1 ; $i<$n ; $i++){
			for($j=1 ; $j<$m ; $j++){
				if(count($mat[$i][$j])==0) return false;
			}
		}
		
		return true;
	}
	
?>