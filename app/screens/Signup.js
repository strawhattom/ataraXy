import React from 'react';
import { StyleSheet, Text, TextInput, View, Image, SafeAreaView, TouchableOpacity, KeyboardAvoidingView, Platform} from 'react-native';

function Signup(props) {
    const [mail,onChangeMail] = React.useState(null);
    const [id,onChangeId] = React.useState(null);
    const [pw,onChangePw] = React.useState(null);
    const [verifPw,onChangeVerifPw] = React.useState(null);
    return (
    <SafeAreaView style={styles.container}>
        <View style={styles.containerLogo}>
            <Image 
            fadeDuration={1500}
            style={styles.logo}
            source={require('../assets/icon.png')
            }/>
        </View>
        
        <View style={styles.containerError}>
            <Text style={styles.error}>Message d'erreur</Text>
        </View>
        
        <View style={[styles.containerInput,styles.width]}>

            <TextInput 
            style={styles.input}
            onChangeText={onChangeMail}
            value={mail}
            placeholder={"Votre e-mail"}
            />
            <TextInput 
            style={styles.input}
            onChangeText={onChangeId}
            value={id}
            placeholder={"Votre identifiant"}
            maxLength={24}
            />
                <View style={
                    {       
                        marginRight:20,
                        alignItems:'flex-end',
                        position:'absolute',
                        top:140,
                        right:0,
                    }
                }>
                    <Text style={styles.tinyfont}>
                        {"(16 caractères max)"}
                    </Text>
                </View>
            <TextInput
            style={styles.input}
            onChangeText={onChangePw}
            value={pw}
            placeholder={"Votre mot de passe"}
            secureTextEntry={true}
            maxLength={32}
            />
            <TextInput
            style={styles.input}
            onChangeText={onChangeVerifPw}
            value={verifPw}
            placeholder={"Vérifier votre mot de passe"}
            secureTextEntry={true}
            maxLength={32}
            />
            
        </View>

        <KeyboardAvoidingView 
        style={[styles.width,styles.containerButton]}
        behavior={Platform.OS === "ios" ? "padding" : "height"}
        enabled={true}>
            <TouchableOpacity>
                <View style={[styles.button,styles.signup]}> 
                    <Text>
                        {"S'inscrire"}
                    </Text>
                </View>
            </TouchableOpacity>
            <TouchableOpacity>
                <View style={styles.other}> 
                    <Text style={styles.tinyfont}>
                        {"avec votre identifiant IUTV →"}
                    </Text>
                </View>
            </TouchableOpacity>
        </KeyboardAvoidingView>
        
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
        marginTop:30,
        alignItems: 'center',
        justifyContent:'center',
        width:"100%",
        height:"15%",
    },
    containerError:{
        alignItems: 'center',
        justifyContent:'center',
        height:"10%",
        width:"100%",
    },
    containerInput:{
        height:"30%",
    },
    containerButton:{
        position:'absolute',
        top:"75%",
    }
    ,
    width:{
        width:"80%",
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
    signup:{
        backgroundColor:"#beeaff",
    },
    other:{
        alignItems:'flex-end',
    },

    error:{
        color:'red',
    },
    input:{
        margin:18,
        height:40,
        color:'lightgray',
        borderColor:"black",
        borderBottomWidth:StyleSheet.hairlineWidth,
    },
    tinyfont:{
        color:'black',
        fontSize:12,
    },
    logo:{
        position:'absolute',
        margin:20,
        width:64,
        height:64,
    },
    tinylogo:{
        position:'absolute',
        height:50,
        width:50,
    },
})
export default Signup;