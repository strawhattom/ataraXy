const Sequelize = require('sequelize');
const db = require('../config/database');

const Resultats = db.define('resultats_quiz',{
    serie:{
        type:Sequelize.INTEGER,
    },
    ID_QUIZ:{
        type:Sequelize.INTEGER,
    },
    ID_QUESTION:{
        type:Sequelize.INTEGER,
    },
    ID_USER:{
        type:Sequelize.INTEGER,
    },
    POINTS:{
        type:Sequelize.INTEGER,
    },
    REUSSIT:{
        type:Sequelize.TINYINT,
    }
});

module.exports = Resultats;