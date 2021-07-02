const express = require('express');
const router = express.Router();
const Questions = require('../models/questionModel');


//Get question list
router.get('/', (req, res) => {
    
    //Faire des vérifications

    Questions.findAll().then(questions => {
        res.send(questions);
    }).catch(err => console.log("Erreur questions : " + err))

});

//Get question d'un quiz
router.get('/:idquiz',(req,res) => {
    
    const params = req.params;

    //Les paramètres idquestion et idquiz sont passés en paramètres
    if (params?.idquiz) {
        Questions.findAll({
            where:{
                ID_QUIZ:req.params.idquiz
            }
        }).then(questions => res.send(questions))
        .catch(err => console.log("Erreur en cherchant la question : " + err));
    } else {
        res.send(false);
    }

});

//Get question d'un quiz
router.get('/:idquiz/:idquestion',(req,res) => {

    const params = req.params;

    //Les paramètres idquestion et idquiz sont passés en paramètres
    if (params?.idquestion && params?.idquiz) {
        Questions.findAll({
            where:{
                ID_QUIZ:params.idquiz,
                ID_QUESTION:params.idquestion,
            }
        }).then(questions => res.send(questions))
        .catch(err => console.log("Erreur en cherchant la question : " + err));
    } else {
        res.send(false);
    }

    
});

module.exports = router;