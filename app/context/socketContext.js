import React from 'react';

import io from 'socket.io-client';
import {localhost} from '../../config/data';

export const SocketContext = React.createContext();

export const useSocket = () => {
        
    const {} = React.useContext(QuizContext);
    const socket = io('ws://' + localhost + ':3000/');

    socket.emit('joinRoom',{PRENOM,ID_GROUPE});

    //Lors qu'on passe la question
    socket.on('pass-question', () => {
        updateId(idquestion+1);
        setAttendre(true);
        //Envoyer les reponses au socket etc...

        socket.emit('reponse',{id,NOM,PRENOM,ID_QUIZ,idquestion,reponseUser,reponses_binaire});
        console.log(`Passe une question sur le mobile : ${idquestion}`);
        setReponseUser([]);
    });

    //La question commence
    socket.on('start-question', () => {

        //Les chargements disparaissent
        setLoading(false);
        setAttendre(false);

        console.log("Mobile : question lancé");
    });
    
    socket.on('stop-quiz',() => {
        console.log("Mobile : quiz stoppé");
        setTimer(0);
        props.navigation.navigate('Accueil');
    });

    socket.on('pause',() => {
        console.log("Pause");
        clearInterval(intervalTimer);
    });

};