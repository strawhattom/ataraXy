import React from 'react';
import {useQuizContext} from './quizContext';

export const SocketContext = React.createContext();

export const useSocket = () => {
        
    const {idUser,
        nom,
        prenom,
        idGroupe,
        idQuiz,
        reponseUser,
        reponses_binaire,
        intervalTimer,
        setIdQuiz,
        setIdQuestion,
        setAttendre,
        setReponseUser,
        setLoading,
        setTimer} = useQuizContext();

};

export const useSocketContext = () => React.useContext(SocketContext);