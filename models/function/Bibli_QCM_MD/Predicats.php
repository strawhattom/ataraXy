<?php
	
	function datapred(){
		$x=mt_rand(2, 99);
		$D=array();
		$P=array();
		$Q=array();
		$S=array();
		
		#code solution : 
		// 0 si rien
		// 1 si p=>q
		// -1 si q=>p
		// 2 si p<=>q
		
		// x>=1 equiv x>0
		$D[]="Soit $ x\\in \\N$";
		$P[]="x\\geqslant ".($x+1);
		$Q[]="x{>}".$x;
		$S[]=2;
		
		// x<=0 equiv x<1
		$D[]="Soit $ x\\in \\N$";
		$P[]="x\\leqslant ".($x);
		$Q[]="x{<}".($x+1);
		$S[]=2;
		
		$D[]="Soit $ x\\in \\Z$";
		$P[]="x\\geqslant ".($x+1);
		$Q[]="x{>}".$x;
		$S[]=2;
		
		$D[]="Soit $ x\\in \\Z$";
		$P[]="x\\leqslant ".($x);
		$Q[]="x{>}".($x+1);
		$S[]=0;
		
		// si x>=1 alors x>0
		$D[]="Soit $ x\\in \\R$";
		$P[]="x\\geqslant ".($x+1);
		$Q[]="x{>}".$x;
		$S[]=1;
		
		// si x<=1 alors x<0
		$D[]="Soit $ x\\in \\R$";
		$P[]="x\\leqslant ".($x+1);
		$Q[]="x{<}".$x;
		$S[]=-1;
		
		// si x<=0 alors x<1
		$D[]="Soit $ x\\in \\R$";
		$P[]="x\\leqslant ".($x);
		$Q[]="x{<}".($x+1);
		$S[]=1;
		
		$D[]="Soit $ x, y\\in \\R$";
		$P[]="x=y";
		$Q[]="x^2=y^2";
		$S[]=1;
		
		$D[]="Soit $ x, y\\in \\N$";
		$P[]="x=y";
		$Q[]="x^2=y^2";
		$S[]=2;
		
		$D[]="Soit $ x, y\\in \\Z$";
		$P[]="x=y";
		$Q[]="x^2=y^2";
		$S[]=1;
		
		$D[]="Soit $ x, y\\in \\R_+$";
		$P[]="x=y";
		$Q[]="x^2=y^2";
		$S[]=2;
		
		$D[]="Soit $ x, y\\in \\Z$";
		$P[]="x=y";
		$Q[]="x^3=y^3";
		$S[]=2;
		
		$D[]="Soit $ x, y\\in \\N$";
		$P[]="x=y";
		$Q[]="x^3=y^3";
		$S[]=2;
		
		$D[]="Soit $ x, y, z\\in \\R$";
		$P[]="xz=yz";
		$Q[]="x=y";
		$S[]=-1;
		
		$D[]="Soit $ x, y\\in \\R$";
		$P[]="x=y";
		$Q[]="x^2+y^2=0";
		$S[]=-1;
		
		$D[]="Soit $ x, y, z\\in \\R^*$";
		$P[]="xz=yz";
		$Q[]="x=y";
		$S[]=2;
		
		$D[]="Soit $ x, y\\in \\R$";
		$P[]="|x+y|=0";
		$Q[]="|x|+|y|=0";
		$S[]=-1;
		
		$D[]="Soit $ x\\in \\R$";
		$P[]="x^2{<}x";
		$Q[]="x{<}1";
		$S[]=0;
		
		$D[]="Soit $ x\\in \\R_+^*$";
		$P[]="x^2{<}x";
		$Q[]="x{<}1";
		$S[]=2;
		
		$D[]="Soit $ x, y\\in \\R$";
		$P[]="x^2{<}y^2";
		$Q[]="x{<}y";
		$S[]=0;
		
		return array("D"=>$D, "P"=>$P, "Q"=>$Q, "S"=>$S);
	}
	
	$clef = "PredicatEtImpliqueL2R";
	$liste_AutoQCM[$clef]="Question sur les prédicats";
	$secte_AutoQCM[$clef]="MD";
	function PredicatEtImpliqueL2R(){
		
		$X=datapred();
		$clef_sol=1;
		$D=array();
		$P=array();
		$Q=array();
		$n=count($X['D']);
		for($i=0 ; $i<$n ; $i++){
			if($X['S'][$i]==$clef_sol){
				$D[]=$X['D'][$i];
				$P[]=$X['P'][$i];
				$Q[]=$X['Q'][$i];
			}
		}
		
		$m=array_rand($D);
		
		$question=$D[$m].", $$ p(x)=(".$P[$m].")\\qquad\\text{et}\\qquad q(x)=(".$Q[$m].")$$ ";
		$rep1="\\reponsejuste $ p(x)\\Rightarrow q(x) $ ";
		$rep2="\\reponse  $ q(x)\\Rightarrow p(x) $ ";
		
		return $question.$rep1.$rep2;
		
	}
	
	$clef = "PredicatEtImpliqueR2L";
	$liste_AutoQCM[$clef]="Question sur les prédicats";
	$secte_AutoQCM[$clef]="MD";
	function PredicatEtImpliqueR2L(){
		
		$X=datapred();
		$clef_sol=-1;
		$D=array();
		$P=array();
		$Q=array();
		$n=count($X['D']);
		for($i=0 ; $i<$n ; $i++){
			if($X['S'][$i]==$clef_sol){
				$D[]=$X['D'][$i];
				$P[]=$X['P'][$i];
				$Q[]=$X['Q'][$i];
			}
		}
		
		$m=array_rand($D);
		
		$question=$D[$m].", $$ p(x)=(".$P[$m].")\\qquad\\text{et}\\qquad q(x)=(".$Q[$m].")$$ ";
		$rep1="\\reponse $ p(x)\\Rightarrow q(x) $ ";
		$rep2="\\reponsejuste  $ q(x)\\Rightarrow p(x) $ ";
		
		return $question.$rep1.$rep2;
	}
	
	$clef = "PredicatEtEquiv";
	$liste_AutoQCM[$clef]="Question sur les prédicats";
	$secte_AutoQCM[$clef]="MD";
	function PredicatEtEquiv(){
		
		$X=datapred();
		$clef_sol=2;
		$D=array();
		$P=array();
		$Q=array();
		$n=count($X['D']);
		for($i=0 ; $i<$n ; $i++){
			if($X['S'][$i]==$clef_sol){
				$D[]=$X['D'][$i];
				$P[]=$X['P'][$i];
				$Q[]=$X['Q'][$i];
			}
		}
		
		$m=array_rand($D);
		
		$question=$D[$m].", $$ p(x)=(".$P[$m].")\\qquad\\text{et}\\qquad q(x)=(".$Q[$m].")$$ ";
		$rep1="\\reponsejuste $ p(x)\\Rightarrow q(x) $ ";
		$rep2="\\reponsejuste $ q(x)\\Rightarrow p(x) $ ";
		
		return $question.$rep1.$rep2;
	}
	
	
	$clef = "PredicatEtRien";
	$liste_AutoQCM[$clef]="Question sur les prédicats";
	$secte_AutoQCM[$clef]="MD";
	function PredicatEtRien(){
		
		$X=datapred();
		$clef_sol=0;
		$D=array();
		$P=array();
		$Q=array();
		$n=count($X['D']);
		for($i=0 ; $i<$n ; $i++){
			if($X['S'][$i]==$clef_sol){
				$D[]=$X['D'][$i];
				$P[]=$X['P'][$i];
				$Q[]=$X['Q'][$i];
			}
		}
		
		$m=array_rand($D);
		
		$question=$D[$m].", $$ p(x)=(".$P[$m].")\\qquad\\text{et}\\qquad q(x)=(".$Q[$m].")$$ ";
		$rep1="\\reponse $ p(x)\\Rightarrow q(x) $ ";
		$rep2="\\reponse  $ q(x)\\Rightarrow p(x) $ ";
		
		return $question.$rep1.$rep2;
	}
	
	$clef = "ClasseTresFacile";
	$liste_AutoQCM[$clef]="Calcul la classe d'un predicat I";
	$secte_AutoQCM[$clef]="MD";
	function ClasseTresFacile(){
		
		$x=genRratio();
		$clefRep=array(0, 1, 2, 3);
		$DOM=array();
		#]x; +oo[
		$DOM[]=array(array(
			'm'=>array('val'=>$x, 'oof'=>'o'),
			'M'=>array('val'=>plongeFrac("1/0"), 'oof'=>'o')
		));
		#[x; +oo[
		$DOM[]=array(array(
			'm'=>array('val'=>$x, 'oof'=>'f'),
			'M'=>array('val'=>plongeFrac("1/0"), 'oof'=>'o')
		));
		#]-oo; x[
		$DOM[]=array(array(
			'm'=>array('val'=>chSGNFrac(plongeFrac("1/0")), 'oof'=>'o'),
			'M'=>array('val'=>$x, 'oof'=>'o')
		));
		#]-oo; x]
		$DOM[]=array(array(
			'm'=>array('val'=>chSGNFrac(plongeFrac("1/0")), 'oof'=>'o'),
			'M'=>array('val'=>$x, 'oof'=>'f')
		));
		
		shuffle($clefRep);shuffle($clefRep);shuffle($clefRep);
		
		$symb="{>}";
		switch($clefRep[0]){
			case 0 : $symb="{>}";break;
			case 1 : $symb="{\\geqslant}";break;
			case 2 : $symb="{<}";break;
			case 3 : $symb="{\\leqslant}";break;
		}
		$question="Soit $ p(x)=\\left(x".$symb.latexFracSGN2($x)."\\right)$ un prédicat défini sur $\\R$. Quelle est la classe de $ p$ ?";
		$rep="";
		$test=True;
		foreach($clefRep as $i){
			$rep.="\\reponse";
			if($test) {$rep.="juste";$test=False;}
			$rep.=" $".latexDomaine($DOM[$i])."$";
		}
		
		return $question.$rep;
	}
	
	$clef = "ClasseFacile";
	$liste_AutoQCM[$clef]="Calcul la classe d'un predicat II";
	$secte_AutoQCM[$clef]="MD";
	function ClasseFacile(){
		
		$x=genRratio();
		$clefRep=array(0, 1, 2, 3);
		$DOM=array();
		#]x; +oo[
		$DOM[]=array(array(
			'm'=>array('val'=>$x, 'oof'=>'o'),
			'M'=>array('val'=>plongeFrac("1/0"), 'oof'=>'o')
		));
		#[x; +oo[
		$DOM[]=array(array(
			'm'=>array('val'=>$x, 'oof'=>'f'),
			'M'=>array('val'=>plongeFrac("1/0"), 'oof'=>'o')
		));
		#]-oo; x[
		$DOM[]=array(array(
			'm'=>array('val'=>chSGNFrac(plongeFrac("1/0")), 'oof'=>'o'),
			'M'=>array('val'=>$x, 'oof'=>'o')
		));
		#]-oo; x]
		$DOM[]=array(array(
			'm'=>array('val'=>chSGNFrac(plongeFrac("1/0")), 'oof'=>'o'),
			'M'=>array('val'=>$x, 'oof'=>'f')
		));
		
		shuffle($clefRep);shuffle($clefRep);shuffle($clefRep);
		
		$symb="{>}";
		switch($clefRep[0]){
			case 0 : $symb="{>}";break;
			case 1 : $symb="{\\geqslant}";break;
			case 2 : $symb="{<}";break;
			case 3 : $symb="{\\leqslant}";break;
		}
		$question="Soit $ p(x)=\\left(x".$symb.latexFracSGN2($x)."\\right)$ un prédicat défini sur $\\R$. Quelle est la classe de $ \\neg p$ ?";
		$rep="";
		$test=True;
		foreach($clefRep as $i){
			$rep.="\\reponse";
			if($test) {$rep.="juste";$test=False;}
			$rep.=" $".latexDomaine(compDomaine($DOM[$i]))."$";
		}
		
		return $question.$rep;
	}
	
	
	$clef = "ClasseMoyen";
	$liste_AutoQCM[$clef]="Calcul la classe d'un predicat III";
	$secte_AutoQCM[$clef]="MD";
	function ClasseMoyen(){
		
		do{
			$x=genRratio();
			$y=genRratio();
		}while(cmpFrac($x, $y)>=0);
		#Donc x<y
		
		$clef=array(0, 1, 2, 3);
		$clefRepX=array(0, 1, 2, 3);
		$clefRepY=array(0, 1, 2, 3);
		
		$DOMX=array();
		#]x; +oo[
		$DOMX[]=array(array(
			'm'=>array('val'=>$x, 'oof'=>'o'),
			'M'=>array('val'=>plongeFrac("1/0"), 'oof'=>'o')
		));
		#[x; +oo[
		$DOMX[]=array(array(
			'm'=>array('val'=>$x, 'oof'=>'f'),
			'M'=>array('val'=>plongeFrac("1/0"), 'oof'=>'o')
		));
		#]-oo; x[
		$DOMX[]=array(array(
			'm'=>array('val'=>chSGNFrac(plongeFrac("1/0")), 'oof'=>'o'),
			'M'=>array('val'=>$x, 'oof'=>'o')
		));
		#]-oo; x]
		$DOMX[]=array(array(
			'm'=>array('val'=>chSGNFrac(plongeFrac("1/0")), 'oof'=>'o'),
			'M'=>array('val'=>$x, 'oof'=>'f')
		));
		
		$DOMY=array();
		#]y; +oo[
		$DOMY[]=array(array(
			'm'=>array('val'=>$y, 'oof'=>'o'),
			'M'=>array('val'=>plongeFrac("1/0"), 'oof'=>'o')
		));
		#[y; +oo[
		$DOMY[]=array(array(
			'm'=>array('val'=>$y, 'oof'=>'f'),
			'M'=>array('val'=>plongeFrac("1/0"), 'oof'=>'o')
		));
		#]-oo; y[
		$DOMY[]=array(array(
			'm'=>array('val'=>chSGNFrac(plongeFrac("1/0")), 'oof'=>'o'),
			'M'=>array('val'=>$y, 'oof'=>'o')
		));
		#]-oo; y]
		$DOMY[]=array(array(
			'm'=>array('val'=>chSGNFrac(plongeFrac("1/0")), 'oof'=>'o'),
			'M'=>array('val'=>$y, 'oof'=>'f')
		));
		
		shuffle($clefRepX);shuffle($clefRepX);shuffle($clefRepX);
		shuffle($clefRepY);shuffle($clefRepY);shuffle($clefRepY);
		
		$symbX="{>}";
		switch($clefRepX[0]){
			case 0 : $symbX="{>}";break;
			case 1 : $symbX="{\\geqslant}";break;
			case 2 : $symbX="{<}";break;
			case 3 : $symbX="{\\leqslant}";break;
		}
		$symbY="{>}";
		switch($clefRepY[0]){
			case 0 : $symbY="{>}";break;
			case 1 : $symbY="{\\geqslant}";break;
			case 2 : $symbY="{<}";break;
			case 3 : $symbY="{\\leqslant}";break;
		}
		$question="Soient $ p(x)=\\left(x".$symbX.latexFracSGN2($x)."\\right)$ et $ q(x)=\\left(x".$symbY.latexFracSGN2($y)."\\right)$ des prédicats définis sur $\\R$. Quelle est la classe de $ p\\ou q$ ?";
		$rep="";
		
		$test=True;
		foreach($clef as $i){
			$rep.="\\reponse";
			if($test) {$rep.="juste";$test=False;}
			$rep.=" $".latexDomaine(unionDomaine($DOMX[$clefRepX[$i]], $DOMY[$clefRepY[$i]]))."$";
		}
		
		return $question.$rep;
	}
	
	$clef = "ClasseDifficile";
	$liste_AutoQCM[$clef]="Calcul la classe d'un predicat IV";
	$secte_AutoQCM[$clef]="MD";
	function ClasseDifficile(){
		
		do{
			$x=genRratio();
			$y=genRratio();
		}while(cmpFrac($x, $y)<=0);
		#Donc x<y
		
		$clef=array(0, 1, 2, 3);
		$clefRepX=array(0, 1, 2, 3);
		$clefRepY=array(0, 1, 2, 3);
		
		$DOMX=array();
		#]x; +oo[
		$DOMX[]=array(array(
			'm'=>array('val'=>$x, 'oof'=>'o'),
			'M'=>array('val'=>plongeFrac("1/0"), 'oof'=>'o')
		));
		#[x; +oo[
		$DOMX[]=array(array(
			'm'=>array('val'=>$x, 'oof'=>'f'),
			'M'=>array('val'=>plongeFrac("1/0"), 'oof'=>'o')
		));
		#]-oo; x[
		$DOMX[]=array(array(
			'm'=>array('val'=>chSGNFrac(plongeFrac("1/0")), 'oof'=>'o'),
			'M'=>array('val'=>$x, 'oof'=>'o')
		));
		#]-oo; x]
		$DOMX[]=array(array(
			'm'=>array('val'=>chSGNFrac(plongeFrac("1/0")), 'oof'=>'o'),
			'M'=>array('val'=>$x, 'oof'=>'f')
		));
		
		$DOMY=array();
		#]y; +oo[
		$DOMY[]=array(array(
			'm'=>array('val'=>$y, 'oof'=>'o'),
			'M'=>array('val'=>plongeFrac("1/0"), 'oof'=>'o')
		));
		#[y; +oo[
		$DOMY[]=array(array(
			'm'=>array('val'=>$y, 'oof'=>'f'),
			'M'=>array('val'=>plongeFrac("1/0"), 'oof'=>'o')
		));
		#]-oo; y[
		$DOMY[]=array(array(
			'm'=>array('val'=>chSGNFrac(plongeFrac("1/0")), 'oof'=>'o'),
			'M'=>array('val'=>$y, 'oof'=>'o')
		));
		#]-oo; y]
		$DOMY[]=array(array(
			'm'=>array('val'=>chSGNFrac(plongeFrac("1/0")), 'oof'=>'o'),
			'M'=>array('val'=>$y, 'oof'=>'f')
		));
		
		shuffle($clefRepX);shuffle($clefRepX);shuffle($clefRepX);
		shuffle($clefRepY);shuffle($clefRepY);shuffle($clefRepY);
		
		$symbX="{>}";
		switch($clefRepX[0]){
			case 0 : $symbX="{>}";break;
			case 1 : $symbX="{\\geqslant}";break;
			case 2 : $symbX="{<}";break;
			case 3 : $symbX="{\\leqslant}";break;
		}
		$symbY="{>}";
		switch($clefRepY[0]){
			case 0 : $symbY="{>}";break;
			case 1 : $symbY="{\\geqslant}";break;
			case 2 : $symbY="{<}";break;
			case 3 : $symbY="{\\leqslant}";break;
		}
		$question="Soient $ p(x)=\\left(x".$symbX.latexFracSGN2($x)."\\right)$ et $ q(x)=\\left(x".$symbY.latexFracSGN2($y)."\\right)$ des prédicats définis sur $\\R$. Quelle est la classe de $ p\\et q$ ?";
		$rep="";
		
		$test=True;
		foreach($clef as $i){
			$rep.="\\reponse";
			if($test) {$rep.="juste";$test=False;}
			$rep.=" $".latexDomaine(intersectionDomaine($DOMX[$clefRepX[$i]], $DOMY[$clefRepY[$i]]))."$";
		}
		
		return $question.$rep;
	}
	
	$clef = "ClasseTresDifficile";
	$liste_AutoQCM[$clef]="Calcul la classe d'un predicat V";
	$secte_AutoQCM[$clef]="MD";
	function ClasseTresDifficile(){
		
		#insufisant
		do{
			$x=genRratio();
			$y=genRratio();
		}while(cmpFrac($x, $y)<=0);
		#Donc x<y
		
		$clef=array(0, 1, 2, 3);
		$clefRepX=array(0, 1, 2, 3);
		$clefRepY=array(0, 1, 2, 3);
		
		$DOMX=array();
		#]x; +oo[
		$DOMX[]=array(array(
			'm'=>array('val'=>$x, 'oof'=>'o'),
			'M'=>array('val'=>plongeFrac("1/0"), 'oof'=>'o')
		));
		#[x; +oo[
		$DOMX[]=array(array(
			'm'=>array('val'=>$x, 'oof'=>'f'),
			'M'=>array('val'=>plongeFrac("1/0"), 'oof'=>'o')
		));
		#]-oo; x[
		$DOMX[]=array(array(
			'm'=>array('val'=>chSGNFrac(plongeFrac("1/0")), 'oof'=>'o'),
			'M'=>array('val'=>$x, 'oof'=>'o')
		));
		#]-oo; x]
		$DOMX[]=array(array(
			'm'=>array('val'=>chSGNFrac(plongeFrac("1/0")), 'oof'=>'o'),
			'M'=>array('val'=>$x, 'oof'=>'f')
		));
		
		$DOMY=array();
		#]y; +oo[
		$DOMY[]=array(array(
			'm'=>array('val'=>$y, 'oof'=>'o'),
			'M'=>array('val'=>plongeFrac("1/0"), 'oof'=>'o')
		));
		#[y; +oo[
		$DOMY[]=array(array(
			'm'=>array('val'=>$y, 'oof'=>'f'),
			'M'=>array('val'=>plongeFrac("1/0"), 'oof'=>'o')
		));
		#]-oo; y[
		$DOMY[]=array(array(
			'm'=>array('val'=>chSGNFrac(plongeFrac("1/0")), 'oof'=>'o'),
			'M'=>array('val'=>$y, 'oof'=>'o')
		));
		#]-oo; y]
		$DOMY[]=array(array(
			'm'=>array('val'=>chSGNFrac(plongeFrac("1/0")), 'oof'=>'o'),
			'M'=>array('val'=>$y, 'oof'=>'f')
		));
		
		shuffle($clefRepX);shuffle($clefRepX);shuffle($clefRepX);
		shuffle($clefRepY);shuffle($clefRepY);shuffle($clefRepY);
		
		$symbX="{>}";
		switch($clefRepX[0]){
			case 0 : $symbX="{>}";break;
			case 1 : $symbX="{\\geqslant}";break;
			case 2 : $symbX="{<}";break;
			case 3 : $symbX="{\\leqslant}";break;
		}
		$symbY="{>}";
		switch($clefRepY[0]){
			case 0 : $symbY="{>}";break;
			case 1 : $symbY="{\\geqslant}";break;
			case 2 : $symbY="{<}";break;
			case 3 : $symbY="{\\leqslant}";break;
		}
		$question="Soient $ p(x)=\\left(x".$symbX.latexFracSGN2($x)."\\right)$ et $ q(x)=\\left(x".$symbY.latexFracSGN2($y)."\\right)$ des prédicats définis sur $\\R$. Quelle est la classe de $ p\\implique q$ ?";
		$rep="";
		
		$test=True;
		foreach($clef as $i){
			$rep.="\\reponse";
			if($test) {$rep.="juste";$test=False;}
			$rep.=" $".latexDomaine(unionDomaine(compDomaine($DOMX[$clefRepX[$i]]), $DOMY[$clefRepY[$i]]))."$";
		}
		
		return $question.$rep;
	}
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
?>