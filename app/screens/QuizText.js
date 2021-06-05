import React from 'react';
import { StyleSheet, Text, Alert, View, Image, SafeAreaView, TouchableOpacity} from 'react-native';
import Animated from 'react-native-reanimated';
import ProgressBar from 'react-native-progress/Bar';


function QuizText(props) {

    
    return (
    <SafeAreaView style={styles.container}>
        {/* Logo dans le coin */}
        <View style={styles.containerLogo}>
            <Image 
            fadeDuration={1500}
            style={styles.tinylogo}
            source={require('../assets/icon.png')
            }/>
        </View>
        {/* Nombre de points*/}
        <View style={[styles.containerPoints,styles.width]}>
            <Text style={styles.numeroQuestion}>
                {"23"}
            </Text>
        </View>
        {/* Numéro question et barre de progression */}
        <View style={[styles.containerQuestion,styles.width]}>
            <Text style={styles.numeroQuestion}>
                {"Question 1/8"}
            </Text>
            <View style={styles.progressBar}>
                <ProgressBar progress={0.3} width={300} height={7} color={"salmon"} animated/>
            </View>
        </View>
        {/* Contenu de la question */}
        <View style={styles.containerContenu}>
            <Text style={styles.question}>
                {"Quelle est la réponse universelle ?"}
            </Text>
        </View>
        {/* Réponses */}
        <View style={[styles.containerReponses,styles.widthBtn]}>
            <TouchableOpacity /*onPress={pressGestion}*/>
                <View style={[styles.button,styles.quiz]} > 
                    <Text>
                        {"Reponse A"}
                    </Text>
                </View>
            </TouchableOpacity>
            <TouchableOpacity>
                <View style={[styles.button,styles.quiz]} > 
                    <Text>
                        {"Reponse B"}
                    </Text>
                </View>
            </TouchableOpacity>
            <TouchableOpacity>
                <View style={[styles.button,styles.quiz]} > 
                    <Text>
                        {"Reponse C"}
                    </Text>
                </View>
            </TouchableOpacity>
            
            <TouchableOpacity>
                <View 
                style={[styles.button,styles.quiz]} > 
                    <Text>
                        {"Reponse D"}
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
    containerPoints:{
        alignItems: 'center',
        justifyContent:'center',
        width:"100%",
        height:"7%",
    },
    containerQuestion:{
        alignItems: 'center',
        justifyContent:'center',
        width:"100%",
        height:"15%",
    },
    containerContenu:{
        alignItems: 'center',
        justifyContent:'center',
        width:"100%",
        height:"15%",
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