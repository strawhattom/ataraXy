import React from 'react';
import { Animated, Easing, StyleSheet, Text, Alert, View, Image, SafeAreaView, TouchableOpacity} from 'react-native';
import {ProgressBar} from 'react-native-paper';
import { useQuizContext } from '../context/quizContext';
import {localhost} from '../../config/host';

const Quiz = (props) => {

    const {
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
        wait,
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
        setWait,
        setLoading,
    } = useQuizContext();

    const pressReponse = (reponse) => {

        //Si l'utilisateur à déjà cliquer sur la réponse, on l'enlève
        if (reponseUser.includes(reponse)){
            const temp = reponseUser;
            setReponseUser(temp.filter(val => val != reponse));
        } else {
            setReponseUser([...reponseUser,reponse]);
        }
    }

    //Lors de l'appuie, revien à la page Accueil
    const pressRetour = () => {
        props.navigation.navigate('Accueil');
        console.log("Retour à l'accueil");
    }
    
    // First set up animation 
    const spinValue = React.useRef(new Animated.Value(0)).current;
    
    // Next, interpolate beginning and end values (in this case 0 and 1)
    const spin = spinValue.interpolate({
        inputRange: [0, 1],
        outputRange: ['0deg', '360deg']
    });

    //Obtient les réponses dans un tableau en séparant la chaîne à chaque \n
    const recup_reponse = (chaine) => {
        var tempReponses = chaine.split("\\n");
        tempReponses.pop();
        return tempReponses;
    };

    //Obtient un tableau contenant : la question et les réponses en fonction du QCM.
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
        }).catch(err => console.log("Erreur obtention reponse : " + err));
    };

    //Par défaut on choisit la première question
    const update = (id) => fetch('http://' + localhost + `:3000/questions/${idQuiz}/${id}`,{
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

    //useEffect est lancé 1 fois à la chargement de la page
    //Dans le 2ème argument (un tableau) si la state d'un des hook changent, useEffect est appelé directement.
    React.useEffect(() => {

            if (etatQuestion == 1) {
                //Pour faire une boucle, ajouter le timing dans le loop
                Animated.loop(
                    Animated.timing(
                        spinValue,
                        {
                        toValue: 1,
                        duration: 10000,
                        easing: Easing.linear,
                        useNativeDriver: true
                        }
                    )
                ).start();
            } else {
                setLoading(false);
                setIdQuestion(etatQuestion);
                console.log(etatQuestion);
            }
            
            socket.on('stop-quiz', () => {
                console.log("Le quiz s'est arrêté, redirection vers la page d'accueil");
                props.navigation.navigate('Accueil');
            });
            
            //Blague aléatoire pour un utilisateur
            setBlague(blagues[Math.floor(Math.random() * (blagues.length-1) ) + 1]);

            //Fetch pour obtenir le nombre de réponse possible
            fetch('http://' + localhost + ':3000/questions/'+idQuiz,{
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
            
            return () => {
                socket.off('stop-quiz');
            };
        },
        []
    )

    //Si la state idQuestion change
    React.useEffect(
        () => {
            //Lors qu'on passe la question
            update(idQuestion);
            clearInterval(intervalTimer);
        },
        [idQuestion]
    );

    //Si la state wait change
    React.useEffect(
        () => {

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
        },
        [wait,isLoading]
    );

    React.useEffect(
        () => {
            if (timer <= 0){
                setWait(true);
                clearInterval(intervalTimer);
            }
            setProgress(timer/temps);
        },
        [timer]
    );

    //Créer les boutons en fonctions du nombre de réponses et les stockes dans le tableau btnReponses
    const ReponsesLayout = ({
        values,
        reponseUser,
        setReponseUser,
    }) => (
        <View style={{flex:1}}>
            <View style={[styles.containerReponses]}>

                { values.map((reponse) => ( //Crée un bouton pour chaque réponse
                    <TouchableOpacity
                     key={reponse}
                     onPress={() => setReponseUser(reponse)}
                     style={[
                        styles.button,
                        reponseUser.includes(reponse) && styles.quizSelected,
                        ]}
                    >
                        <Text style={
                            [styles.reponse,
                            reponseUser.includes(reponse) && styles.quizSelectedText,
                            ]}
                        >
                            {reponse}
                        </Text>
                    </TouchableOpacity>
                ))}
            </View>
        </View>
    ); 

    //Affichage

    if (isLoading) {
        return (
        <SafeAreaView style={[styles.container,{
            justifyContent:'center',
        }]}>
            <Animated.View style={[styles.containerLogo,{
                transform:[
                    { rotateZ : spin}
                ]
            }]}>
                <Image 
                fadeDuration={1500}
                style={styles.logo}
                source={require('../assets/icon.png')
                }/>
            </Animated.View>
            
            <View style={[styles.containerText,styles.width]}>
                <Text style={styles.wait}>
                    {"En attente de lancement..."}
                </Text>
                <Text style={styles.wait}>
                    {blague}
                </Text>
            </View>
            <TouchableOpacity style={styles.width} onPress={pressRetour}>
                <Text style={[styles.button,styles.retour]}>
                    {"Retour"}
                </Text>
            </TouchableOpacity>
        </SafeAreaView>
    );
    } else if (wait) {
        return (
            <View style={[styles.container,{
                justifyContent:'center',
            }]}>
                <Text
                style={styles.question}>
                    {"Prochaine question..."}
                </Text>
            </View>
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
                    {"Question " + idQuestion + "/" + nbQuestion}
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
            <ReponsesLayout
            values={reponses}
            binaire={reponses_binaire}
            reponseUser={reponseUser}
            setReponseUser={pressReponse}
            ></ReponsesLayout>
    
        </SafeAreaView>
        
    )};
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
    containerText:{
        margin:30,
        alignItems: 'center',
        justifyContent:'center',
        width:"100%",
        height:"15%",
    },
    containerButton:{
        height:"10%",
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
        alignItems: 'center',
        justifyContent:'center',
        flexDirection: "row",
        flexWrap: "wrap",
    },
    progressBar:{
        margin:10,
        width:300,
        height:7,
    },
    width:{
        width:"90%",
    },
    retour:{
        backgroundColor:"salmon",
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
    reponse:{
        color: "black",
        fontSize:16,
    },
    questionImg:{
        margin:10,
        minHeight:128,
        minWidth:128,
    },
    button:{
        margin:16,
        paddingHorizontal: 8,
        paddingVertical: 10,
        borderRadius: 8,
        backgroundColor: "oldlace",
        alignSelf: "center",
        marginHorizontal: "1%",
        marginBottom: 6,
        minWidth: "45%",
        textAlign: "center",
    },
    quizSelected:{
        backgroundColor: "slateblue",
    },
    quizSelectedText:{
        color: "white",
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

export default Quiz;