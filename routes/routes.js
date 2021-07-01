const express = require('express');
const bodyParser = require('body-parser');
const cors = require('cors');
const http = require('http');
const sequelize = require('../config/database');

// Starting our app.
const app = express();
const server = http.createServer(app);
const port = process.env.PORT || 3000;

//Socket.io, attend des requêtes du serveur : server (depuis app)
const io = require('socket.io')(server,{
    cors:{origin:"*"},
});


app.use(express.json());
app.use(express.urlencoded({ extended: false }));
app.use(cors());


//Test DB
sequelize.authenticate()
    .then(() => console.log("Base de données connectée..."))
    .catch((err) => console.log("Erreur : " + err));

io.on('connection', (socket) => {
    socket.on('adm_gestion', () => {
        socket.join('admin');
        console.log("Un administrateur est sur la page de gestion de quiz");
    })

    socket.on('adm_voir', () => {
        socket.join('admin');
        console.log("Un administrateur est sur la page d'animation de quiz");
    })

    socket.on('joinRoom', ({PRENOM, GROUPE}) => {
        console.log(`${PRENOM} joined group ${GROUPE}`);
    })

    //Ajoute un mot clé d'evenement "lancer", on pourra emettre un message avec comme mot clé "lancer" depuis le web.
    socket.on('lancer-question', (idq) => {
        console.log(`Question ${idq} lancée`);
        io.emit('start-question');
    });

    //Lance un quiz
    socket.on('start', (message) => {
        console.log(message);
    })

    //Arrête un quiz
    socket.on('stop', (message) => {
        console.log(message);
        io.emit('stop-quiz');
        socket.emit('stop-quiz');
    });

    //Pause un quiz
    socket.on('pause-question',(message) => {
        console.log(message);
        io.emit('pause');
    })

    //Passe un quiz
    socket.on('pass', (data) => {
        console.log(`Quiz ${data.idquiz} du groupe ${data.idgroupe}, passe à une nouvelle question (${data.idquestion})`);
        io.emit('pass-question');
    });


    //Recois une réponse d'un utilisateur
    socket.on('reponse',(data) => {
        io.to('admin').emit('add-reponse',data);
        console.log("Envoie des réponses à l'admin...")
    });

    socket.on('disconnect', () => {
        console.log('user disconnected');
    });
});

//Chemin par defaut
app.get('/', (req, res) => {
    res.send("Node activé");
});

//Route vers l'authentification -> localhost:3000/auth/...
app.use('/auth', require('./auth'));

//Route vers le quiz -> localhost:3000/quiz/...
app.use('/quiz', require('./quiz'));

//Route vers les questions -> localhost:3000/questions/...
app.use('/questions', require('./questions'));

//Redirige toutes les requêtes /reponses au fichier en question
app.use('/reponses', require('./reponses'));

// Starting our server.
server.listen(port, () => {
 console.log(`Aller sur http://localhost:${port}/ pour voir les données.`);
});