const express = require('express');
const router = express.Router();
const Resultats = require('../models/resultatsModel');
const Sequelize = require('sequelize');

//Post reponses list
router.post('/', (req, res) => {
    //Mettre une réponse dans la BDD
        const {idUser,nom,prenom,idQuiz,idQuestion,points,reponseUser,reponses,reponses_binaire} = JSON.parse(req.body.data);

        // console.log(req.body.data);

        //Tableau de réponse correcte
        let tabReponseCorrecte = [];
        for (let i = 0; i<reponses.length;i++){
            if (reponses_binaire[i] == '1'){
                tabReponseCorrecte.push(reponses[i]);
            }
        }

        let reussit = true;
        //Vérification des réponses correctes : si toutes les réponses de l'utilisateur sont aussi dans le tableau des réponses correctes, il a réussit la question
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

        const data = {idUser,nom,prenom,idQuiz,idQuestion,points,reponseUser,reponses,reponses_binaire,reussit};
        console.log(data);
        res.send(data);
    }
);



module.exports = router;