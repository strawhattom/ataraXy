import React from 'react';
import { StyleSheet, Text, Alert, View, Image, SafeAreaView, TouchableOpacity} from 'react-native';
import {AuthContext} from "../context/authContext";
import jwt_decode from "jwt-decode";
import * as SecureStore from 'expo-secure-store';
import {localhost} from '../../config/host';
import { useQuizContext } from '../context/quizContext';

function Accueil(props) {

    const { signOut } = React.useContext(AuthContext);
    const {socket,idUser,idGroupe,prenom,setIdUser,setNom,setPrenom,setIdGroupe,setIdQuiz,setEtatQuestion} = useQuizContext();

    React.useEffect(
        () => {
            const token = sessionStorage.getItem('token');
            if (token){
                const decoded = jwt_decode(token);

                //Vérifie le token obtenue
                try {
                    setIdUser(decoded.id);
                    setIdGroupe(decoded.ID_GROUPE);
                    setNom(decoded.NOM);
                    setPrenom(decoded.PRENOM);
                    
                    socket.emit('joinRoom',{PRENOM:decoded.PRENOM,GROUPE:decoded.ID_GROUPE});

                } catch(e) {
                    console.error(e);
                    signOut();
                }
                
            }
        },
        []
    )

    

    
    
    //Appuie sur "Mode quiz"
    const pressQuiz = () => {
        fetch(`http://`+localhost+`:3000/quiz/${idGroupe}`,{
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
                        setIdQuiz(responseJSON[0].ID_QUIZ);
                        setEtatQuestion(responseJSON[0].ETAT_QUESTION);
                        props.navigation.navigate('Quiz'); //Prend le quiz le plus récent
                    }
                } else {
                    console.log("Retourne false via le serveur");
                }
            }).catch((error)=>{
                console.log("Erreur : "+ error);
        });
            
    };


    //Si c'est M. Hébert (à changer pour les futurs admins)
    if (idUser == 19){
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
                        "Salut, " + prenom
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
                        {"Salut, " + prenom}
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