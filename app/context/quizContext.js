import React from 'react';

import {socket} from '../../config/socket';

export const QuizContext = React.createContext();

export const useQuiz = () => {

    const [idUser,setIdUser] = React.useState('');
    const [idGroupe,setIdGroupe] = React.useState(0);
    const [nom,setNom] = React.useState("Nom");
    const [prenom,setPrenom] = React.useState("Prenom");

    //Authent
    const [error,setError] = React.useState('');            //En cas d'erreur
    const [wait,setWait] = React.useState(false); //wait la prochaine question
    const [waitMsg, setWaitMsg] = React.useState("Prochaine question...");
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

    

   React.useEffect(
       () => {
            //Lors qu'on passe la question
        socket.on('pass-question', () => {
            
            setWait(true);

            setIdQuestion(prevId => prevId + 1);
            setProgress(1);
            clearInterval(intervalTimer);

            //Envoyer les reponses au socket etc...
            socket.emit('reponse',{idUser,nom,prenom,idQuiz,idQuestion,points,reponseUser,reponses,reponses_binaire});
            console.log(`Passe une question`);
            
            setReponseUser([]);
        });

        //La question commence
        socket.on('start-question', () => {

            //Les chargements disparaissent
            setLoading(false);
            setWait(false);
            setWaitMsg("Prochaine question...");

            console.log("Mobile : question lancé");
        });
        
        socket.on('stop-quiz',() => {
            console.log("Mobile : quiz stoppé, envoie des réponses.");
            socket.emit('reponse',{idUser,nom,prenom,idQuiz,idQuestion,points,reponseUser,reponses,reponses_binaire});
            socket.emit('stop-quiz');
            //Envoie de la dernière réponse
            setIdQuestion(1);
            setReponseUser([]);
            setTimer(10);
            setWait(true);
            setWaitMsg("Fin du quiz");
            clearInterval(intervalTimer);
        });

        socket.on('pause',() => {
            console.log("Pause");
            clearInterval(intervalTimer);
        });

        socket.on('unpause',() => {
            if (wait == false && isLoading == false) {
                setIntervalTimer( 
                    setInterval(() => {
                        if (timer >= 0) {
                            //Baisse le compteur de temps
                            setTimer(prevTimer => prevTimer - 1);
                            //Met à jours la barre de progression
                            
                        } else {
                            clearInterval(intervalTimer);
                            return;
                        }
                    },1000)
                )
            }
            return () => {
                clearInterval(intervalTimer);
            }
        })
        
        socket.on('userDisconnect', () => {
            socket.leave(idGroupe);
        })

        //Ne pas oublier de les détruire quand l'affichage se met à jours 
        return () => {
            // on enlève tous les listener
            socket.off("userDisconnect");
            socket.off("pause");
            socket.off("unpause");
            socket.off("stop-quiz");
            socket.off("start-question");
            socket.off("pass-question");
          };

       },
       [waitMsg,wait,isLoading,socket,idUser,nom,prenom,idQuiz,idQuestion,points,reponseUser,reponses,reponses_binaire]
   );

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
        wait,
        isLoading,
        socket,
        waitMsg,
        setWaitMsg,
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
        setWait,
        setLoading,
    }
    
};

export const useQuizContext = () => React.useContext(QuizContext);