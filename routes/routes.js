const express = require('express');
const bodyParser = require('body-parser');
const cors = require('cors');

const sequelize = require('../config/database');


// Starting our app.
const app = express();
const port = process.env.PORT || 3000;



app.use(express.json());
app.use(express.urlencoded({ extended: false }));
app.use(cors());


//Test DB
sequelize.authenticate()
    .then(() => console.log("Base de données connectée..."))
    .catch((err) => console.log("Erreur : " + err));

//
app.get('/', (req, res) => {
    res.send("Node activé");
});

app.use('/auth',require('./auth'));


app.use('/questions',require('../routes/questions'));

// Starting our server.
app.listen(port, () => {
 console.log('Aller sur http://localhost:3000/ pour voir les données.');
});