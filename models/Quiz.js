const Sequelize = require('sequelize');
const db = require('../config/database');

const Quiz = db.define('mobile_quiz',{
    ID_QUIZ:{
        type:Sequelize.INTEGER,
<<<<<<< HEAD
    },
    ID_QUESTION:{
        type:Sequelize.INTEGER,
    },
    QUESTION:{
        type:Sequelize.STRING,
    },
    POINTS:{
        type:Sequelize.INTEGER,
    },
    TEMPS:{
        type:Sequelize.INTEGER,
    },
    TYPE:{
        type:Sequelize.STRING,
    },
    REPONSES_BINAIRE:{
        type:Sequelize.STRING,
    },
    REPONSES:{
        type:Sequelize.STRING,
    },
    IMG_SRC:{
        type:Sequelize.BLOB('long'),
    },
});

module.exports = Questions;
=======
        primaryKey:true,
    },
    DATE_QUIZ:{
        type:Sequelize.DATE,
    },
    ID_GROUPE:{
        type:Sequelize.INTEGER,
    },
    NOTE:{
        type:Sequelize.BOOLEAN,
    },
    ETAT_QUESTION:{
        type:Sequelize.INTEGER,
    },
    ENCOURS:{
        type:Sequelize.BOOLEAN,
    },
});

module.exports = Quiz;
>>>>>>> Socket
