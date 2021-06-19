import React from 'react';
import { Animated, Easing, StyleSheet, Text, Alert, View, Image, SafeAreaView, TouchableOpacity} from 'react-native';
import {ProgressBar} from 'react-native-paper';

const Quiz = (props) => {

    var btnReponses = [];

    const pressReponse = (i) => {

        //Si l'utilisateur à déjà cliquer sur la réponse, on l'enlève
        if (reponseUser.includes(reponses[i])){
            const temp = reponseUser;
            setReponseUser(temp.filter(val => val != reponses[i]));
        } else {
            setReponseUser([...reponseUser,reponses[i]]);
        }
        
    }

    //Créer les boutons en fonctions du nombre de réponses et les stockes dans le tableau btnReponses
    for (let i = 0;i<reponses.length;i++){
        btnReponses.push(
            <TouchableOpacity 
            key={i}
            val={reponses_binaire[i]}
            selected={false}
            onPress={() => pressReponse(i)}>
                <View style={[styles.button,styles.quiz]} > 
                    <Text style={styles.reponse}>
                        {reponses[i]}
                    </Text>
                </View>
            </TouchableOpacity>
        )
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
    
    const updateId = (id) => {
        setIdQuestion(id);
    }


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
        }).catch(err => console.log("Erreur obtention reponse : " + err));
    };

    //Par défaut on choisit la première question
    const update = (id) => fetch('http://' + localhost + `:3000/questions/${ID_QUIZ}/${id}`,{
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

            if (ETAT_QUESTION == 1) {
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
                updateId(ETAT_QUESTION);
                console.log(ETAT_QUESTION);
            }
            
            
            //Blague aléatoire pour un utilisateur
            setBlague(blagues[Math.floor(Math.random() * (blagues.length-1) ) + 1]);

            //Fetch pour obtenir le nombre de réponse possible
            fetch('http://' + localhost + ':3000/questions/'+ID_QUIZ,{
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
        },
        []
    )

    //Si la state idquestion change
    React.useEffect(
        () => {
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
            update(idquestion);
            clearInterval(intervalTimer);
        },
        [idquestion]
    );

    //Si la state attendre change
    React.useEffect(
        () => {

            if (attendre == false && isLoading == false) {
                setIntervalTimer( 
                    setInterval(() => {
                        if (timer != 0) {
                            //Baisse le compteur de temps
                            setTimer(timer-1);
                            //Met à jours la barre de progression
                            
                        } else {
                            setProgress(1);
                            clearInterval(intervalTimer);
                            return;
                        }
                    },1000)
                )
            }
        },
        [attendre,isLoading]
    );

    React.useEffect(
        () => {
            console.log("Timer : " + timer);
            setProgress(timer/temps);
        },
        [timer]
    );

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
            <TouchableOpacity style={styles.widthBtn} onPress={pressRetour}>
                    <View style={[styles.button,styles.retour]} > 
                        <Text>
                            {"Retour"}
                        </Text>
                    </View>
                </TouchableOpacity>
        </SafeAreaView>
    );
    } else if (attendre) {
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
        textAlign:'center',
        fontSize:16,
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

export default Quiz;