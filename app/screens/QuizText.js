import React from 'react';
import { StyleSheet, Text, Alert, View, Image, SafeAreaView, TouchableOpacity} from 'react-native';
import Animated from 'react-native-reanimated';
import ProgressBar from 'react-native-progress/Bar';
import {MathJaxSvg} from 'react-native-mathjax-html-to-svg';

function QuizText(props) {

    const [points,setPoint] = React.useState(2);
    const [temps,setTemps] = React.useState(10);
    const [question,setQuestion] = React.useState("Question par défaut");
    const [type,setType] = React.useState("Texte");
    const [idquestion,setIdQuestion] = React.useState(1);
    const [reponses,setReponses] = React.useState(['Juste','Mauvaise 1','Mauvaise 2','Mauvaise 3']);
    const [reponses_binaire,setReponsesBinaire] = React.useState('1000');
    const LaTeX = 'We give illustrations for the three processes $e^+e^-$, gluon-gluon and $\\gamma\\gamma \\to W t\\bar b$.'
    const [img,setImgSrc] = React.useState('');

    const [nbQuestion,setNbQuestion] = React.useState(1);

    var btnReponses = [];

    for (let i = 0;i<reponses.length;i++){
        btnReponses.push(
            <TouchableOpacity 
            key={i+1}
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

    const recup_reponse = (chaine) => {
        var tempReponses = chaine.split("\\n");
        tempReponses.pop();
        return tempReponses;
    }
    
    const atar = (qcm) => {
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
    const update = () => fetch('http://192.168.1.11:3000/questions/'+ID_QUIZ+'/3',{
            method:'GET',
            headers: {
                'Accept': 'application/json',
                'Content-Type': 'application/json',
            },
        }).then((response) => response.json())
            .then((responseJSON) => {
                console.log("Update");
                console.log(responseJSON);
                if (responseJSON !== false){
                    //Si on a une réponse mais qu'on a pas de résultat
                    if (responseJSON.length === 0){
                        return;
                    } else {
                        const question = responseJSON[0];
                        setPoint(question.POINTS);
                        setTemps(question.TEMPS);
                        setIdQuestion(question.ID_QUESTION);
                        setType(question.TYPE);

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


    React.useEffect(
        () => {
            update();
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
            
        }
        ,[]
    )
    //update();
    //const intervalUpdate = setInterval(update,5000);

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
            <View style={styles.progressBar}>
                <ProgressBar progress={0.6} width={300} height={7} color={"salmon"} animated/>
            </View>
        </View>
        {/* Contenu de la question */}
        <View style={[styles.containerContenu,styles.width]}>

            {type != 'Ataraxienne' &&
                <Text style={styles.question}>
                    {question}
                </Text>
            }

            {type == 'Image' &&
                <Image 
                fadeDuration={1500}
                style={styles.questionImg}
                source={img}/>
            }
            

            {type == 'Ataraxienne' &&
                <MathJaxSvg 
                fontCache={true}
                fontSize={16}>
                    {question}
                </MathJaxSvg>
            }
            
            
            

        </View>
        {/* Réponses */}
        <View style={[styles.containerReponses,styles.widthBtn]}>
            {btnReponses}
        </View>

    </SafeAreaView>
    );
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
        // position:"absolute",
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