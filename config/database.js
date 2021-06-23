const Sequelize = require("sequelize");
module.exports = new Sequelize('atarztye_ataraxy','atarztye_2','mdp',{
    host:'127.0.0.1',
    dialect:'mysql',
    define:{
        timestamps: false,
        freezeTableName: true,
    },
});