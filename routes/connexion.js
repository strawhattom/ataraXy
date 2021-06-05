const express = require('express');
const router = express.Router();
const Sequelize = require('sequelize');
const db = require('../config/database');
const Users = require('../models/Users');

const crypto = require('crypto');

//Get login
router.get('/', (req,res) => {
    /*
    const login = req.body.login;
    const pw = req.body.pw;
    
    if (typeof login === 'undefined' || typeof pw === 'undefined'){
        res.send(false);
    } else {

        //On hash le mot de passe
        const shasum = crypto.createHash('sha1');
        shasum.update(pw);
        const mdp = shasum.digest('hex');
        Users.findOne({
            where:{
                LOGIN:login,
                MDP:mdp,
            }
        }).then(response => {
            if(response == null){
                res.send(false)
            } else {
                res.send(response)
            }
        })
        .catch(err => console.log("Erreur connexion : " + err));
    }
    */
    res.send({
        token:'test123'
    });
})

module.exports = router;