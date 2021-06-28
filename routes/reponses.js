const express = require('express');
const router = express.Router();
const Resultats = require('../models/resultatsModel');

//Post reponses list
router.post('/', (req, res) => {
    //Mettre une réponse dans la BDD
        //{idUser,nom,prenom,idQuiz,idQuestion,reponseUser,reponses,reponses_binaire}
        const {idUser,nom,prenom,idQuiz,idQuestion,reponseUser,reponses,reponses_binaire} = JSON.parse(req.body.data);

        // console.log(req.body.data);

        //Tableau de réponse correcte
        let tabReponseCorrecte = [];
        for (let i = 0; i<reponses.length;i++){
            if (reponses_binaire[i] == '1'){
                tabReponseCorrecte.push(reponses[i]);
            }
        }

        let reussit = true;
        if (tabReponseCorrecte.length == reponseUser.length){
            for (let i = 0; i < reponseUser.length; i++) {
                if (!reponseUser.includes(tabReponseCorrecte[i])){
                    reussit = false;
                    break;
                }
            }
        } else {
            reussit = false;
        }

        const data = {idUser,nom,prenom,idQuiz,idQuestion,reponseUser,reponses,reponses_binaire,reussit};

        res.send(data);
    }
);



module.exports = router;