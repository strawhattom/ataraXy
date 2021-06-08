const express = require('express');
const router = express.Router();
const db = require('../config/database');
const Quiz = require('../models/Quiz');


//Get question list
router.get('/', (req, res) => {
    const idgroupe = req.query.idg;
    Quiz.findAll({
        where: {
            ID_GROUPE:idgroupe,
            ENCOURS:true,
        }
    })
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



module.exports = router;