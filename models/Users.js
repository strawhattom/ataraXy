const Sequelize = require('sequelize');
const db = require('../config/database');

const Users = db.define('users',{
    ID_GROUPE:{
        type:Sequelize.INTEGER,
    },
    NOM:{
        type:Sequelize.STRING,
    },
    PRENOM:{
        type:Sequelize.STRING,
    },
});

module.exports = Users;