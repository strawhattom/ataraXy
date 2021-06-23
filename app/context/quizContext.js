import React from 'react';
import io from 'socket.io-client';
import {localhost} from '../../config/host';

export const QuizContext = React.createContext();

export const useQuiz = () => {

    const [idUser,setIdUser] = React.useState('');
    const [idGroupe,setIdGroupe] = React.useState(0);
    const [nom,setNom] = React.useState("Nom");
    const [prenom,setPrenom] = React.useState("Prenom");

    //Authent
    const [error,setError] = React.useState('');            //En cas d'erreur
    const [attendre,setAttendre] = React.useState(false); //Attendre la prochaine question
    const [isLoading, setLoading] = React.useState(true); //Attente que le quiz se lance

    //Liste des blagues
    const blagues = [
        "La réponse universelle est 42.",
        "Tu savais que j'adore les dragibus ?",
        "Un jour je serai le meilleur dresseur !",
        "Elle est où la poulette ?",
        "Faut pas respirer la compote ; ça fait tousser !",
    ];
    const [blague,setBlague] = React.useState(blagues[0]);

    const [idQuiz,setIdQuiz] = React.useState(0);

    const [points,setPoint] = React.useState(2);
    const [temps,setTemps] = React.useState(10);
    const [question,setQuestion] = React.useState("Question par défaut");
    const [typeQuestion,setTypeQuestion] = React.useState("Texte");
    const [idQuestion,setIdQuestion] = React.useState(1);
    const [etatQuestion,setEtatQuestion] = React.useState(1);
    const [reponses,setReponses] = React.useState(['Juste','Mauvaise 1','Mauvaise 2','Mauvaise 3']);
    const [reponses_binaire,setReponsesBinaire] = React.useState('1000');
    const [img,setImgSrc] = React.useState('');
    const [progress,setProgress] = React.useState(0);

    //Timer
    const [timer,setTimer] = React.useState(10);
    const [intervalTimer,setIntervalTimer] = React.useState();

    const [nbQuestion,setNbQuestion] = React.useState(1);
    const [reponseUser, setReponseUser] = React.useState([]);

        //Socket

    const socket = io('ws://' + localhost + ':3000/');

    //Lors qu'on passe la question
    socket.on('pass-question', () => {
        setIdQuestion(idQuestion+1);
        setAttendre(true);
        //Envoyer les reponses au socket etc...

        socket.emit('reponse',{idUser,nom,prenom,idQuiz,idQuestion,reponseUser,reponses_binaire});
        console.log(`Passe une question sur le mobile : ${idQuestion}`);
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
        socket.emit('stop-quiz-mobile');
    });

    socket.on('pause',() => {
        console.log("Pause");
        clearInterval(intervalTimer);
    });
    
    socket.on('userDisconnect', () => {
        socket.leave(idGroupe);
    })

    return {
        idUser,
        idGroupe,
        idQuestion,
        idQuiz,
        nom,
        prenom,
        points,
        temps,
        question,
        etatQuestion,
        typeQuestion,
        reponses,
        reponses_binaire,
        img,
        progress,
        timer,
        intervalTimer,
        nbQuestion,
        reponseUser,
        blague,
        blagues,
        error,
        attendre,
        isLoading,
        socket,
        setIdUser,
        setIdGroupe,
        setIdQuestion,
        setIdQuiz,
        setNom,
        setPrenom,
        setPoint,
        setTemps,
        setQuestion,
        setEtatQuestion,
        setTypeQuestion,
        setReponses,
        setReponsesBinaire,
        setImgSrc,
        setProgress,
        setTimer,
        setIntervalTimer,
        setNbQuestion,
        setReponseUser,
        setBlague,
        setError,
        setAttendre,
        setLoading,
    }
    
};

export const useQuizContext = () => React.useContext(QuizContext);