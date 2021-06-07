import React from 'react';
import { StyleSheet, Text, Alert, View, Image, SafeAreaView, TouchableOpacity} from 'react-native';
import jwt_decode from "jwt-decode";

function Accueil(props) {

    const {id,ID_GROUPE,NOM,PRENOM} = props.navigation.state.params;

    const pressDeco = () =>{
        /*
        Alert.alert(
            'Déconnexion',
            'Vous êtes sur le point de vous déconnecter',
            [
                {
                    text:"Valider", onPress:() => {
                        props.navigation.navigate('Login');
                        sessionStorage.removeItem('token');
                        console.log('Valider OK');
                    }
                    
                },
                {
                    text:"Annuler", onPress:() => console.log('Annuler OK'),
                    style:"cancel"
                }
            ]
        );
        */
        props.navigation.navigate('Login');
        sessionStorage.removeItem('token');
    }
    
    const pressQuiz = () => {
        props.navigation.navigate('Quiz');
        console.log("Rentre dans le quiz");
    }

    /*
    const pressGestion = () => {
        fetch('http://192.168.8.11:3000/users')
          .then(response => response.json())
          .then(users => console.warn(users))
        .done();
        props.navigation.navigate('Test');
    }
    */
    return (
    <SafeAreaView style={styles.container}>
        <View style={styles.containerLogo}>
            <Image 
            fadeDuration={1500}
            style={styles.tinylogo}
            source={require('../assets/icon.png')
            }/>
        </View>
        
        <View style={[styles.containerText,styles.width]}>
            <Text style={styles.bienvenue}>
                {"Salut, " + PRENOM}
            </Text>
            <Text style={styles.bienvenueDesc}>
                {"Bienvenue sur l'application ataraXy"}
            </Text>
        </View>
        <View style={[styles.containerButton,styles.width]}>
            <TouchableOpacity /*onPress={pressGestion}*/>
                <View style={styles.button} > 
                    <Text>
                        {"Gestion des QCM"}
                    </Text>
                </View>
            </TouchableOpacity>
            <TouchableOpacity onPress={pressQuiz}>
                <View style={[styles.button,styles.quizz]} > 
                    <Text>
                        {"Mode quiz"}
                    </Text>
                </View>
            </TouchableOpacity>
            <TouchableOpacity>
                <View style={[styles.button,styles.faireqcm]} > 
                    <Text>
                        {"Faire vos QCM"}
                    </Text>
                </View>
            </TouchableOpacity>
            
            <TouchableOpacity>
                <View 
                style={[styles.button,styles.cours]} > 
                    <Text>
                        {"Accéder aux cours"}
                    </Text>
                </View>
            </TouchableOpacity>
        </View>
        <View style={[styles.containerDeco,styles.width]}>
            <TouchableOpacity onPress={pressDeco}>
                <View 
                style={[styles.button,styles.deconnexion]} 
                > 
                    <Text>
                        {"Déconnexion"}
                    </Text>
                </View>
            </TouchableOpacity>
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
    containerDeco:{
        marginTop:"55%",
    },
    width:{
        width:"80%",
    },
    bienvenue:{
        textAlign:"center",
        fontSize:32,
        fontWeight:'bold',
    },
    bienvenueDesc:{
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
    faireqcm:{
        backgroundColor:"#ffa2c9",
    },
    cours:{
        backgroundColor:"#fffbef",
    },
    deconnexion:{
        backgroundColor:"salmon",
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

export default Accueil;