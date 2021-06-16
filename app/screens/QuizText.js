import React from 'react';
import {ActivityIndicator, StyleSheet, Text, View, Image, SafeAreaView, TouchableOpacity} from 'react-native';
import {ProgressBar} from 'react-native-paper';
//import Katex from 'react-native-katex';

function QuizText(props) {

    console.log("Loading quiz text");

    const [points,setPoint] = React.useState(2);
    const [temps,setTemps] = React.useState(10);
    const [question,setQuestion] = React.useState("Question par défaut");
    const [typeQuestion,setTypeQuestion] = React.useState("Texte");
    const [idquestion,setIdQuestion] = React.useState(0);
    const [reponses,setReponses] = React.useState(['Juste','Mauvaise 1','Mauvaise 2','Mauvaise 3']);
    const [reponses_binaire,setReponsesBinaire] = React.useState('1000');
    const [img,setImgSrc] = React.useState('');
    const [progress,setProgress] = React.useState(0);
    const [timer,setTimer] = React.useState(10);
    const [isLoading, setLoading] = React.useState(true);
    const [expression, setExpression] = React.useState("We give illustrations for the three processes $e^+e^-$, gluon-gluon and $\\gamma\\gamma \\to W t\\bar b$.");

    const [nbQuestion,setNbQuestion] = React.useState(1);

    var btnReponses = [];

    //Créer les boutons en fonctions du nombre de réponses et les stockes dans le tableau btnReponses
    for (let i = 0;i<reponses.length;i++){
        btnReponses.push(
            <TouchableOpacity 
            key={i}
            val={reponses_binaire[i]}
            selected={false}
            /*onPress={pressGestion}*/>
                <View style={[styles.button,styles.quiz]} > 
                    <Text>
                        {reponses[i]}
                    </Text>
                </View>
            </TouchableOpacity>
        )
    }
    const {DATE_QUIZ,ID_GROUPE,ID_QUIZ,NOTE} = props.route.params

    //console.log("Date : " + DATE_QUIZ + '\n'+ "ID Groupe : " + ID_GROUPE + '\n'+ "ID Quiz : " + ID_QUIZ + '\n'+ "Noté : " + NOTE + '\n');

    //Obtient les réponses dans un tableau en séparant la chaîne à chaque \n
    const recup_reponse = (chaine) => {
        var tempReponses = chaine.split("\\n");
        tempReponses.pop();
        return tempReponses;
    }
    
    const atar = (qcm) => {
        //Fetch un tableau contenant : la question et les réponses en fonction du QCM.
        fetch(`http://127.0.0.1/php/WATARAXY/PHP/AutoQCMMobile.php?qcm=${qcm}`,{
            method:'GET',
            headers: {
                'Accept': 'application/json',
                'Content-Type': 'application/json',
            },
        }).then(response => response.json())
        .then(responseJSON => {
            console.log(responseJSON)
            //On a reçu une réponse positive
            if (typeof responseJSON !== 'undefined' && responseJSON.message == true){
                
                let tempReponses = [];
                setQuestion(responseJSON.question);
                const reponses = responseJSON.reponses;
                for (let i = 0;i<reponses.length;i++){
                    tempReponses.push(reponses[i].tex);
                }
                setReponses(tempReponses);  
            } else {
                console.log("Réponse vide du serveur");
            }
        }).catch(err => console.log("Erreur obtention reponse : " + err))
    }

    
    //Par défaut on choisit la première question
    const update = (id) => fetch(`http://192.168.1.11:3000/questions/${ID_QUIZ}/${id}`,{
            method:'GET',
            headers: {
                'Accept': 'application/json',
                'Content-Type': 'application/json',
            },
        }).then((response) => response.json())
            .then((responseJSON) => {

                if (responseJSON !== false){
                    //Si on a une réponse mais qu'on a pas de résultat
                    if (responseJSON.length === 0){
                        return;
                    } else {
                        const question = responseJSON[0];
                        setPoint(question.POINTS);
                        setTemps(question.TEMPS);
                        setTimer(question.TEMPS);
                        setIdQuestion(question.ID_QUESTION);
                        setTypeQuestion(question.TYPE);

                        if (question.TYPE != 'Ataraxienne'){
                            setQuestion(question.QUESTION);
                            const reponses = recup_reponse(question.REPONSES);
                            setReponses(reponses);
                        } else {
                            atar(question.QUESTION);
                        }
                        setReponsesBinaire(question.REPONSES_BINAIRE);
                        
                        let img = '';
                        //Image
                        if (question.TYPE == 'Image'){
                            const {data} = question.IMG_SRC;
                            img = new Buffer.from(data).toString('ascii');
                        }
                        setImgSrc(img);
                    }
                } else {
                    console.log("Retourne false via le serveur");
                }
            }).catch((error)=>{
                console.log("Erreur : "+ error);
        });
    
    //Fonction qui permet de savoir si il y a un changement de question à faire
    const checkUpdate = () => {
        fetch('http://192.168.1.11:3000/quiz/'+ID_QUIZ+'/etat',{
            method:'GET',
            headers: {
                'Accept': 'application/json',
                'Content-Type': 'application/json',
            },
        }).then(response => response.json())
        .then(responseJSON => {
            if (responseJSON !== false){

                const etat = responseJSON.ETAT_QUESTION;

                if (etat != idquestion){
                    setLoading(true);
                    setTimeout(() => {
                        console.log('Update');
                        setLoading(false);
                        setIdQuestion(etat);
                        update(etat);
                    },1000);
                }

            } else {
                console.log("Retourne false via le serveur");
            }
        })
    }

    React.useEffect(
        () => {
            checkUpdate();
            const intervalUpdate = setInterval(checkUpdate,5000);
            fetch('http://192.168.1.11:3000/questions/'+ID_QUIZ,{
                method:'GET',
                headers: {
                    'Accept': 'application/json',
                    'Content-Type': 'application/json',
                },
            }).then((response) => response.json())
            .then((responseJSON) => {
                    setNbQuestion(responseJSON.length);
            })
            .catch(err => console.err(err));
            
            if (!isLoading){
                const intervalBar = setInterval(() => {
                    if (temps != 0) {
                        //Baisse le compteur de temps
                        setTimer(timer-1);
                        //Met à jours la barre de progression
                        setProgress(timer/temps);
                    } else {
                        setLoading(true);
                        setProgress(1);
                        clearInterval(intervalBar);
                        return;
                    }
                },1000);
            }
        }
        ,[]
    )
    //update();
    

    

    if (isLoading) {
        setTimeout(() => {
            setLoading(false);
        },1000);
        return (
            <ActivityIndicator size="large"
            color='#ffe3c0'
            style={
                {
                    flex: 1,
                    justifyContent: "center",
                    backgroundColor:"white",    
                }
            }/>
        )
    } else {

        return (
            <SafeAreaView style={styles.container}>
                {/* Logo dans le coin */}
                <TouchableOpacity 
                    style={styles.containerLogo} 
                    onPress={() => {props.navigation.navigate('Accueil')}}>
                        <Image 
                        fadeDuration={1500}
                        style={styles.tinylogo}
                        source={require('../assets/icon.png')
                        }/>
                </TouchableOpacity>
                {/* Nombre de points*/}
                <View style={[styles.containerPoints,styles.width]}>
                    <Text style={styles.numeroQuestion}>
                        {points}
                    </Text>
                </View>
                {/* Numéro question et barre de progression */}
                <View style={[styles.containerQuestion,styles.width]}>
                    <Text style={styles.numeroQuestion}>
                        {"Question " + idquestion + "/" + nbQuestion}
                    </Text>
                    <ProgressBar progress={progress}
                        style={styles.progressBar}
                        color={"salmon"} animated/>
                </View>
                {/* Contenu de la question */}
                <View style={[styles.containerContenu,styles.width]}>
        
                    <Text style={styles.question}>
                        {question}
                    </Text>
        
                    {typeQuestion == 'Image' &&
                        <Image 
                        fadeDuration={1500}
                        style={styles.questionImg}
                        source={img}/>
                    }
                    
        
                    {/* {typeQuestion == 'Ataraxienne' &&
                        <Katex
                            expression={expression}
                            style={styles.katex}
                            inlineStyle={inlineStyle}
                            displayMode={false}
                            throwOnError={false}
                            errorColor="#f00"
                            macros={{}}
                            colorIsTextColor={false}
                            onLoad={() => setLoaded(true)}
                            onError={() => console.error('Error')}
                        />
                    } */}
                    
                    
                    
        
                </View>
                {/* Réponses */}
                <View style={[styles.containerReponses,styles.widthBtn]}>
                    {btnReponses}
                </View>
        
            </SafeAreaView>
            );
    }

};


const styles = StyleSheet.create({
    container: {
        flex: 1,
        flexDirection:"column", 
        backgroundColor: '#fff',
        alignItems: 'center',
    },
    containerLogo:{
        marginTop:"10%",
        alignItems: 'center',
        justifyContent:'center',
        width:"100%",
        height:"8%",
    },
    containerPoints:{
        alignItems: 'center',
        justifyContent:'center',
        width:"100%",
        height:"13%",
    },
    containerQuestion:{
        alignItems: 'center',
        justifyContent:'center',
        width:"100%",
        height:"10%",
    },
    containerContenu:{
        alignItems: 'center',
        justifyContent:'center',
        width:"100%",
        height:"auto",
    },
    containerReponses:{
        margin:10,
        height:"10%",
    },
    progressBar:{
        margin:10,
        width:300,
        height:7,
    },
    width:{
        width:"80%",
    },
    widthBtn:{
        width:"40%",
    },
    numeroQuestion:{
        textAlign:"center",
        fontSize:32,
        fontWeight:'bold',
    },
    question:{
        textAlign:'center',
        fontSize:16,
        fontWeight:'bold',
    },
    questionImg:{
        margin:10,
        height:128,
        width:128,
    },
    button:{
        margin:7,
        height:40,
        backgroundColor:"lightgray",
        color:"black",
        borderRadius:40,
        alignItems: 'center',
        justifyContent: 'center',
    },
    quiz:{
        backgroundColor:"#ffe3c0",
    },
    quizSelected:{
        backgroundColor:"#ffcb8a",
    },
    logo:{
        margin:20,
        width:64,
        height:64,
    },
    tinylogo:{
        top:20,
        left: 25,
        position:"absolute",
        height:50,
        width:50,
    },
})

export default QuizText;