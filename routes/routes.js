const express = require('express');
const bodyParser = require('body-parser');
const cors = require('cors');

const sequelize = require('../config/database');


// Starting our app.
const app = express();
const port = process.env.PORT || 3000;


app.use(cors());

// parse application/x-www-form-urlencoded
app.use(bodyParser.urlencoded({ extended: false }))

// parse application/json
app.use(bodyParser.json())

/*
app.use(express.json());
app.use(express.urlencoded({ extended: true }));
app.use(cors());
*/

//Test DB
sequelize.authenticate()
    .then(() => console.log("Base de données connectée..."))
    .catch((err) => console.log("Erreur : " + err));

//
app.get('/', (req, res) => {
    res.send("Node activé");
});

//Redirige toutes les requêtes /connexion au fichier en question
app.use('/auth',require('./auth'));
/*
app.use('/connexion', (req, res) => { // require('../routes/connexion)
  res.send({
    token: 'test123'
  });
});
*/

//Redirige toutes les requêtes /questions au fichier en question
app.use('/questions',require('../routes/questions'));

//Redirige toutes les requêtes /reponses au fichier en question
app.use('/reponses',require('../routes/reponses'));

// Starting our server.
app.listen(port, () => {
 console.log('Aller sur http://localhost:3000/ pour voir les données.');
});