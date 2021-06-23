const express = require('express');
const router = express.Router();
const Sequelize = require('sequelize');
const db = require('../config/database');
const Users = require('../models/Users');
<<<<<<< HEAD
const bodyParser = require('body-parser');
const jwt = require('jsonwebtoken');

=======

//Bibliothèque pour la gestion de token
const jwt = require('jsonwebtoken');

//Bibliothèque de cryptologie
>>>>>>> Socket
const crypto = require('crypto');

//Get login
router.post('/', (req,res) => {

    const id = req.body.id;
    const pw = req.body.pw;
    
    //Si aucune information n'a été tapé
    if (typeof id === 'undefined' || typeof pw === 'undefined'){
        res.send(false);
    } else {

        //On hash le mot de passe
        const shasum = crypto.createHash('sha1');
        shasum.update(pw);
        const mdp = shasum.digest('hex');

        Users.findOne({
            where:{
                LOGIN:id,
                MDP:mdp,
            }
        }).then(response => {
            if(response == null){
                res.send(false);
            } else { //On a obtenu un résultat

                //Crée le token avec les informations de l'utilisateurs
                //pour la session qui expire au bout de 15 minutes
                //de la forme (s'il est décodé):
<<<<<<< HEAD
                //{id:id users,ID_GROUPE:idDuGroupe,NOM:nom,PRENOM:prenom}
=======
                //{id:idUsers,ID_GROUPE:idDuGroupe,NOM:nom,PRENOM:prenom}
>>>>>>> Socket
                const token = jwt.sign(response.dataValues,
                'supersecret'
                ,
                {
                    expiresIn:900,
                });
                res.send(JSON.stringify(token));
            }
        })
        .catch(err => console.log("Erreur connexion : " + err));
    }
<<<<<<< HEAD
    /*
    res.send({
        token:'test123'
    });
    */
=======

>>>>>>> Socket
});

//Valide le token
router.post('/validate',(req,res) => {

});

module.exports = router;