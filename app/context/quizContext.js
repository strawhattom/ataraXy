import React from 'react';

export const QuizContext = React.createContext();

export const useQuiz = () => {

    //Authent
    var decoded ;
    const token = sessionStorage.getItem('token');
    if (token){
        decoded = jwt_decode(token);
    }
    const {id,ID_GROUPE,NOM,PRENOM} = decoded;

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

    const [points,setPoint] = React.useState(2);
    const [temps,setTemps] = React.useState(10);
    const [question,setQuestion] = React.useState("Question par défaut");
    const [typeQuestion,setTypeQuestion] = React.useState("Texte");
    const [idquestion,setIdQuestion] = React.useState(1);
    const [reponses,setReponses] = React.useState(['Juste','Mauvaise 1','Mauvaise 2','Mauvaise 3']);
    const [reponses_binaire,setReponsesBinaire] = React.useState('1000');
    const [img,setImgSrc] = React.useState('');
    const [progress,setProgress] = React.useState(0);

    //Timer
    const [timer,setTimer] = React.useState(10);
    const [intervalTimer,setIntervalTimer] = React.useState();

    const [nbQuestion,setNbQuestion] = React.useState(1);
    const [reponseUser, setReponseUser] = React.useState([]);
    
};