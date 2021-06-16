<?php
	// بِسْمِ ٱللَّهِ ٱلرَّحْمَٰنِ ٱلرَّحِيمِ

	function liens($nom, $url, $url_fav){
		//Liens pour la page de liens
		return '
		<div class="favicon">
			<a href="'.$url.'" target="_blank">
				<div class="favicon_img"><img src="'.$url_fav.'" title="'.$nom.'" alt="'.$nom.'"/></div>
				<div class="legend">'.$nom.'</div>
			</a>
		</div>
		';
	}

	function recup_calcul($mode, $CHAMP){
		//Récupère le mode de calcul
		//STD = renvoie 0
		//ABS = renvoie le pourcentage
		//PER = renvoie un tableau pour chaque niveau
		
		if($mode=="STD") return 0;
		if($mode=="ABS") return((float)substr($CHAMP, 4, strlen($CHAMP)-5));
		
		if($mode=="PER"){
			$X=explode(' ',substr($CHAMP, 4, strlen($CHAMP)-5));
			if(count($X)!=5) return array();
			for($i=0 ; $i<5 ; $i++) $res[$i]=explode(':',$X[$i]);
			return $res;

		}
		
		return null;
	}
	
	function recup_question($texte){
		//Récupère la question
		
		if(strpos($texte, "AutoQCM")!==false) return AutoQCM_question($texte);
		
		$x=strpos($texte, "\\reponse",0);
		if((bool)$x == false) return "";
		return substr($texte,0,$x);
	
	}
	
	function recup_reponses($texte){
		
		if(strpos($texte, "AutoQCM")!==false) return AutoQCM_reponses($texte);
		
		$num_rep=0;
		$reponses=array();
		$x=strpos($texte, "\\reponse",0);
		while((bool)$x==true){
			$y=strpos($texte, "\\reponsejuste",$x);
			if($x==$y)	$reponses[$num_rep]['val'] = true;
			else		$reponses[$num_rep]['val'] = false;
			
			if($x==$y)  $taille=13;
			else 		$taille=8;
			
			$x2=strpos($texte, "\\reponse",$x+8);
			
			if((bool)$x2==false) $reponses[$num_rep]['tex'] = substr($texte,$x+$taille);
			if((bool)$x2==true) $reponses[$num_rep]['tex'] = substr($texte,$x+$taille, $x2-$x-$taille);
			
			$num_rep++;
			$x=$x2;
			
		}
		return $reponses;
	}
	
	function MaDate($date){
	
		if($date=="") return "";
		
		$_date = date_create($date);
		$res = "";
		$jour = date_format($_date,"D");
		if($jour == "Mon" ) $res = $res."Lun ";
		if($jour == "Tue" ) $res = $res."Mar ";
		if($jour == "Wed" ) $res = $res."Mer ";
		if($jour == "Thu" ) $res = $res."Jeu ";
		if($jour == "Fri" ) $res = $res."Ven ";
		if($jour == "Sat" ) $res = $res."Sam ";
		if($jour == "Sun" ) $res = $res."Dim ";	
		
		$res = $res.date_format($_date,"d/m/y à H:i");
		
		return $res;
	}

	function ArXivDAEUB($intitul, $nom, $promo){
		return "<a href=\"COEUR/Modules/DAEUB/Toutim/".$promo."/".$intitul.".pdf\"  target=\"_blank\">".$nom."</a>
		(<a href=\"COEUR/Modules/DAEUB/Toutim/".$promo."/".$intitul.".tex\" target=\"_blank\">tex</a>) /
		";
	}
	
	function ArXiv($clef, $intitul, $nom, $promo){
		if(file_exists("../COEUR/Modules/".$clef."/Examens/".$promo."/".$intitul."Corr.pdf")) 
			return "<a href=\"COEUR/Modules/".$clef."/Examens/".$promo."/".$intitul.".pdf\" target=\"_blank\">".$nom."</a>
			<a href=\"COEUR/Modules/".$clef."/Examens/".$promo."/".$intitul."Corr.pdf\" target=\"_blank\">[Correction]</a>
			(<a href=\"COEUR/Modules/".$clef."/Examens/".$promo."/".$intitul.".tex\" target=\"_blank\">tex</a>) /
			";
		return "<a href=\"COEUR/Modules/".$clef."/Examens/".$promo."/".$intitul.".pdf\" target=\"_blank\">".$nom."</a>
		(<a href=\"COEUR/Modules/".$clef."/Examens/".$promo."/".$intitul.".tex\" target=\"_blank\">tex</a>) /
		";
	}

	//Retourne le même tableau $tab en ajoutant, sans répétition, les éléments de $lst_add
	function ajoute_tableau_dans_tableau($tab, $lst_add){
		foreach($lst_add as $x){
			if(!in_array($x, $tab)) $tab[]=$x;
		}
		return $tab;
	}
	
	//Retourne le même tableau $tab en supprimant les éléments de $lst_sup
	function supprime_tableau_dans_tableau($tab, $lst_sup){
		$res=array();
		foreach($tab as $x){
			if(!in_array($x, $lst_sup)) $res[]=$x;
		}
		return $res;
	}

	function melangeReponse($binaire,$texte){

		$tex = explode('\n',$texte,-1);
		$bin = str_split($binaire);
		$res = array();
		
		$order = range(1,count($bin));
		shuffle($order);
		array_multisort($order,$bin,$tex);

		for ($i = 0;$i<count($bin);$i++){
			array_push($res,array($bin[$i],$tex[$i]));
		}

		return $res;
	}
	
?>