const express = require('express');
const express = require('express');
const router = express.Router();
const db = require('../config/database');
const Quiz = require('../models/Quiz');


//Get question list
router.get('/', (req, res) => 
    Quiz.findAll()
        .then(quiz => {
            res.send(quiz);
        })
        .catch(err => console.log("Erreur quiz : " + err))
);



module.exports = router;