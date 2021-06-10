import React from 'react';
import { StyleSheet, Text, Alert, View, Image, SafeAreaView, TouchableOpacity} from 'react-native';
import Animated from 'react-native-reanimated';
import ProgressBar from 'react-native-progress/Bar';

const recup_reponse = (chaine) => {
    var tempReponses = chaine.split('\n');
    tempReponses.pop();
    console.log(tempReponses);
    return tempReponses;
}

const atar = (qcm) => {
    fetch('http://127.0.0.1/php/WATARAXY/PHP/Adm_gestion_quiz_action.php?action=atar-qst&qcm='+qcm,{
        method:'GET',
        headers: {
            'Accept': 'application/json',
            'Content-Type': 'application/json',
        },
    }).then(response => response.json)
    .then(responseJSON => {
        console.log(responseJSON);
        //On a reçu une réponse positive
        if (responseJSON.message == true){
            let tempReponses = [];
            setQuestion(responseJSON.question);
            for (let i = 0;i<responseJSON.length;i++){
                tempReponses.push(responseJSON[i]['tex']);
            }
            setReponses(tempReponses);
        }
    }).catch(err => console.log("Erreur obtention reponse : " + err))
}

function QuizText(props) {

    const [points,setPoint] = React.useState(0);
    const [temps,setTemps] = React.useState(10);
    const [question,setQuestion] = React.useState("Question par défaut");
    const [idquestion,setIdQuestion] = React.useState(1);
    const [reponses,setReponses] = React.useState(['Juste','Mauvaise 1','Mauvaise 2','Mauvaise 3']);
    const [reponses_binaire,setReponsesBinaire] = React.useState('10');

    var btnReponses = [];

    for (let i = 0;i<reponses.length;i++){
        btnReponses.push(
            <TouchableOpacity /*onPress={pressGestion}*/>
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

    
    //Par défaut on choisit la première question
    const update = () => fetch('http://192.168.1.11:3000/questions/'+ID_QUIZ+'/1',{
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
                        setIdQuestion(question.ID_QUESTION);

                        if (question.TYPE != 'Ataraxienne'){
                            setQuestion(question.QUESTION);
                            console.log(question.REPONSES)
                            const reponses = recup_reponse(question.REPONSES);
                            setReponses(reponses);
                        } else {
                            atar(question.QUESTION);
                        }
                        setReponsesBinaire(question.REPONSES_BINAIRE);
                    }
                } else {
                    console.log("Retourne false via le serveur");
                }
            }).catch((error)=>{
                console.log("Erreur : "+ error);
        });

    update();
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
                {"Question " + idquestion + "/" + reponses.length}
            </Text>
            <View style={styles.progressBar}>
                <ProgressBar progress={0.3} width={300} height={7} color={"salmon"} animated/>
            </View>
        </View>
        {/* Contenu de la question */}
        <View style={styles.containerContenu}>
            <Text style={styles.question}>
                {question}
            </Text>
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
        height:"auto",
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
        height:"8%",
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
        textAlign:'left',
        fontSize:16,
        fontWeight:'bold',
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