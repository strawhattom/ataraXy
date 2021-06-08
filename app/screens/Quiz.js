import React from 'react';
import { Animated, Easing, StyleSheet, Text, Alert, View, Image, SafeAreaView, TouchableOpacity} from 'react-native';
import QuizText from "./QuizText";

function Quiz(props) {

    const blagues = [
                        "La réponse universelle est 42.",
                        "Tu savais que j'adore les dragibus ?",
                        "Un jours je serais le meilleur dresseur !",
                        "Elle est où la poulette ?",
                        "Faut pas respirer la compote ; ça fait tousser !",
                    ]
    

    //Lors de l'appuie, revien à la page Accueil
    const pressRetour = () => {
        props.navigation.navigate('Accueil');
        console.log("Retour à l'accueil");
    }
    // First set up animation 
    const spinValue = React.useRef(new Animated.Value(0)).current;
    //Pour faire une boucle, ajouter le timing dans le loop
    Animated.loop(
        Animated.timing(
          spinValue,
          {
           toValue: 1,
           duration: 3000,
           easing: Easing.linear,
           useNativeDriver: true
          }
        )
       ).start();
    // Next, interpolate beginning and end values (in this case 0 and 1)
    const spin = spinValue.interpolate({
    inputRange: [0, 1],
    outputRange: ['0deg', '360deg']
    });

    return (
    <SafeAreaView style={styles.container}>
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
                {blagues[Math.floor(Math.random()*(blagues.length-1))]}
            </Text>
        </View>
        <TouchableOpacity style={styles.btnRetour} onPress={pressRetour}>
                <View style={[styles.button,styles.retour]} > 
                    <Text>
                        {"Retour"}
                    </Text>
                </View>
            </TouchableOpacity>
    </SafeAreaView>
    );
};

const styles = StyleSheet.create({
    container: {
        flex: 1,
        flexDirection:"column", 
        justifyContent:'center',
        backgroundColor: '#fff',
        alignItems: 'center',
    },
    containerLogo:{
        marginTop:"10%",
        alignItems: 'center',
        justifyContent:'center',
        width:"100%",
        height:"13%",
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
    width:{
        width:"80%",
    },
    btnRetour:{
        width:"40%",
    },
    retour:{
        backgroundColor:"salmon",
    }
    ,
    wait:{
        textAlign:"center",
        fontSize:16,
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
    quizz:{
        backgroundColor:"#beeaff",
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