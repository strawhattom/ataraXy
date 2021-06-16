const Sequelize = require('sequelize');
const db = require('../config/database');

const Quiz = db.define('mobile_quiz',{
    ID_QUIZ:{
        type:Sequelize.INTEGER,
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