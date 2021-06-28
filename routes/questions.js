const express = require('express');
const router = express.Router();
const Questions = require('../models/questionModel');


//Get question list
router.get('/', (req, res) => 
    Questions.findAll()
        .then(questions => {
            res.send(questions);
        })
        .catch(err => console.log("Erreur questions : " + err))
);

//Get question d'un quiz
router.get('/:idquiz',(req,res) => {
    Questions.findAll({
        where:{
            ID_QUIZ:req.params.idquiz
        }
    }).then(questions => res.send(questions))
    .catch(err => console.log("Erreur en cherchant la question : " + err));
});

//Get question d'un quiz
router.get('/:idquiz/:idquestion',(req,res) => {
    Questions.findAll({
        where:{
            ID_QUIZ:req.params.idquiz,
            ID_QUESTION:req.params.idquestion,
        }
    }).then(questions => res.send(questions))
    .catch(err => console.log("Erreur en cherchant la question : " + err));
});

module.exports = router;