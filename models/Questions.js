const Sequelize = require('sequelize');
const db = require('../config/database');

const Questions = db.define('quiz_data',{
    ID_QUIZ:{
        type:Sequelize.INTEGER,
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