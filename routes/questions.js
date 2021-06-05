const express = require('express');
const router = express.Router();
const db = require('../config/database');
const Questions = require('../models/Questions');


//Get question list
router.get('/', (req, res) => 
    Questions.findAll()
        .then(questions => {
            res.send(questions);
        })
        .catch(err => console.log("Erreur login : " + err))
);



module.exports = router;