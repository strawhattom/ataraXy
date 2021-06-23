const express = require('express');
<<<<<<< HEAD
const express = require('express');
=======
>>>>>>> Socket
const router = express.Router();
const db = require('../config/database');
const Quiz = require('../models/Quiz');

<<<<<<< HEAD

//Get question list
router.get('/', (req, res) => 
    Quiz.findAll()
        .then(quiz => {
            res.send(quiz);
        })
        .catch(err => console.log("Erreur quiz : " + err))
);
=======
//On veut voir tous les quiz
router.get('/', (req, res) => {
    Quiz.findAll()
        .then(quiz => {
            if (quiz == null){
                res.send(false);
            } else {
                //On a un résultat
                res.send(quiz);    
            }
        })
        .catch(err => console.log("Erreur quiz: " + err))
});

//Obtenir les quiz en cours d'un groupe spécifique 
router.get('/:groupe', (req, res) => {
    const idgroupe = req.params.groupe;
    Quiz.findAll({
        where: {
            ID_GROUPE:idgroupe,
            ENCOURS:true,
        }
    }).then(quiz => {
            if (quiz == null){
                res.send(false);
            } else {
                //On a un résultat
                res.send(quiz);    
            }
        })
        .catch(err => console.log("Erreur quiz: " + err))
});

router.get('/:quiz/etat', (req,res) => {
    const idquiz = req.params.quiz;
    Quiz.findOne({
        where:{
            ID_QUIZ:idquiz,
            ENCOURS:true,
        }
    }).then(quiz => {
        if (quiz == null){
            res.send(false);
        } else {
            //On a un résultat
            res.send(quiz);    
        }
    })
})
>>>>>>> Socket



module.exports = router;