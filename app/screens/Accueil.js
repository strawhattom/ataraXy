import React from 'react';
import { StyleSheet, Text, Alert, View, Image, SafeAreaView, TouchableOpacity} from 'react-native';
import {AuthContext} from "../context/authContext";
import jwt_decode from "jwt-decode";
import * as SecureStore from 'expo-secure-store';
import {localhost} from '../../config/data';

function Accueil(props) {

    const { signOut } = React.useContext(AuthContext);

    var decoded ;
    /*
    const token = async () => await SecureStore.getItemAsync('token');
    
    if (token){
        decoded = jwt_decode(token);
    }
    */
    const token = sessionStorage.getItem('token');
    if (token){
        decoded = jwt_decode(token);
    }
    const {id,ID_GROUPE,NOM,PRENOM} = decoded;

    // const pressDeco = () =>{
    //     /*
    //     Alert.alert(
    //         'Déconnexion',
    //         'Vous êtes sur le point de vous déconnecter',
    //         [
    //             {
    //                 text:"Valider", onPress:() => {
    //                     props.navigation.navigate('Login');
    //                     sessionStorage.removeItem('token');
    //                     console.log('Valider OK');
    //                 }
                    
    //             },
    //             {
    //                 text:"Annuler", onPress:() => console.log('Annuler OK'),
    //                 style:"cancel"
    //             }
    //         ]
    //     );
    //     */
    //     props.navigation.navigate('Login');
    //     //SecureStore.deleteItemAsync('token');
    //     sessionStorage.removeItem('token');
    // }
    
    const pressQuiz = () => {
        fetch(`http://`+localhost+`:3000/quiz/${ID_GROUPE}`,{
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
                        console.log("Pas de quiz disponible qui sont en cours");
                        return;
                    } else {
                        //Trie les quiz du plus récent jusqu'au plus vieux
                        responseJSON.sort(function(a,b) {
                            return new Date(b.DATE_QUIZ) - new Date(a.DATE_QUIZ);
                        })
                        props.navigation.navigate('Quiz',{...responseJSON[0],id,NOM,PRENOM}); //Prend le quiz le plus récent
                    }
                } else {
                    console.log("Retourne false via le serveur");
                }
            }).catch((error)=>{
                console.log("Erreur : "+ error);
        });
            
    }

    //Gestion d'appuie sur "Accéder aux cours"
    const pressQuizText = () => {
        fetch('http://'+localhost+':3000/quiz/'+ID_GROUPE,{
            method:'GET',
            headers: {
                'Accept': 'application/json',
                'Content-Type': 'application/json',
            },
        }).then((response) => response.json())
            .then((responseJSON) => {
                //console.log(responseJSON)
                if (responseJSON !== false){
                    //Si on a une réponse mais qu'on a pas de résultat
                    if (responseJSON.length === 0){
                        console.log("Pas de quiz disponible, on ne fait rien");
                        return;
                    } else {
                        //Trie les quiz du plus récent jusqu'au plus vieux
                        responseJSON.sort(function(a,b) {
                            return new Date(b.DATE_QUIZ) - new Date(a.DATE_QUIZ);
                        })
                        props.navigation.navigate('QuizText',responseJSON[0]); //Prend le quiz le plus récent
                    }
                } else {
                    console.log("Retourne false via le serveur");
                }
            }).catch((error)=>{
                console.log("Erreur : "+ error);
        });
        
    }


    //Si c'est M. Hébert (à changer pour les futurs admins)
    if (id == 19){
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
                        {
                        "Salut, " + PRENOM
                        }
                    </Text>
                    <Text style={styles.bienvenueDesc}>
                        {"Bienvenue sur l'application ataraXy"}
                    </Text>
                </View>
                <View style={[styles.containerButton,styles.width]}>
        
                    
                    <TouchableOpacity /*onPress={pressGestion}*/>
                        <View style={styles.button} > 
                            <Text>
                                {"Gestion des blagues"}
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
                    {/* <TouchableOpacity>
                        <View style={[styles.button,styles.faireqcm]} > 
                            <Text>
                                {"Faire vos QCM"}
                            </Text>
                        </View>
                    </TouchableOpacity>
                    
                    <TouchableOpacity  onPress={pressQuizText}>
                        <View 
                        style={[styles.button,styles.cours]} > 
                            <Text>
                                {"Accéder aux cours"}
                            </Text>
                        </View>
                    </TouchableOpacity> */}
                </View>
                <View style={[styles.containerDeco,styles.width]}>
                    <TouchableOpacity onPress={signOut}>
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
    } else {
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
                    
                    <TouchableOpacity onPress={pressQuiz}>
                        <View style={[styles.button,styles.quizz]} > 
                            <Text>
                                {"Mode quiz"}
                            </Text>
                        </View>
                    </TouchableOpacity>
                    {/* <TouchableOpacity>
                        <View style={[styles.button,styles.faireqcm]} > 
                            <Text>
                                {"Faire vos QCM"}
                            </Text>
                        </View>
                    </TouchableOpacity>
                    
                    <TouchableOpacity onPress={pressQuizText}>
                        <View 
                        style={[styles.button,styles.cours]} > 
                            <Text>
                                {"Accéder aux cours"}
                            </Text>
                        </View>
                    </TouchableOpacity> */}
                </View>
                <View style={[styles.containerDeco,styles.width]}>
                    <TouchableOpacity onPress={signOut}>
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
        backgroundColor:'lightgray',
        borderRadius:40,
        alignItems: 'center',
        justifyContent: 'center',
    },
    quizz:{
        backgroundColor:"#a097ff",
    },
    faireqcm:{
        backgroundColor:"#ffa2c9",
    },
    cours:{
        backgroundColor:"#a097ff",
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