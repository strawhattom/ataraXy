import React from 'react';
import PropTypes from 'prop-types';
import { ActivityIndicator, StyleSheet, Text, TextInput, View, Image, TouchableOpacity} from 'react-native';
import jwt_decode from "jwt-decode";

function Login(props) {
    
    const [id,onChangeId] = React.useState();
    const [pw,onChangePw] = React.useState();
    const [isLoading,setLoading] = React.useState(false);
    var [error,setError] = React.useState('');

    const pressLogin = async () => {
        setLoading(true);
        setTimeout(() => {setLoading(false)}, 3000);
        //http://127.0.0.1/php/WATARAXY/PHP/Mobile_user_login.php
        //http://localhost:3000/users
        
        fetch('http://192.168.1.11:3000/auth',{
            method:'POST',
            headers: {
                'Accept': 'application/json',
                'Content-Type': 'application/json',
            },
            body: JSON.stringify({
                id,
                pw,
            })
        }).then((response) => response.json())
            .then((responseJSON) => {
                if (responseJSON !== false){
                    var decoded = jwt_decode(responseJSON)
                    if (!isLoading){
                        sessionStorage.setItem('token',responseJSON);
                        props.navigation.navigate('Accueil',decoded);
                    }
                } else {
                    setError("Une erreur est survenue, l'identifiant et/ou le mot de passe sont incorrects");
                }
            }).catch((error)=>{
                console.log("Erreur : "+ error);
        });

    };
    


    if(isLoading){
        
        //Timer après 1s, l'appli se charge
        setTimeout(() => {setLoading(false)}, 1000);

        return(<ActivityIndicator
        style={styles.container}
        size="large" 
        color="#000000" />);

    } else {
        return (
            <View style={styles.container}>
                
                <View style={styles.containerLogo}>
                    <Image 
                    fadeDuration={1500}
                    style={styles.logo}
                    source={require('../assets/icon.png')
                    }/>
                </View>
                
                <View style={styles.containerError}>
                    
                    <Text style={[styles.error,styles.width]}>{error}</Text>
                </View>
                <View style={[styles.containerInput,styles.width]}>
                    <TextInput 
                    style={styles.input}
                    onChangeText={onChangeId}
                    value={id}
                    placeholder={"Identifiant"}
                    placeholderTextColor={"lightgray"}
                    />
        
                    <TextInput
                    style={styles.input}
                    onChangeText={onChangePw}
                    value={pw}
                    placeholder={"Mot de passe"}
                    placeholderTextColor={"lightgray"}
                    secureTextEntry={true}
                    maxLength={32}
                    />
                    <View style={
                        {   
                            marginRight:20,
                            alignItems:'flex-end',
                        }
                    }>
                        <Text style={styles.forgot}>
                            {"Mot de passe oublié ?"}
                        </Text>
                    </View>
                </View>
                <View style={[styles.containerButton,styles.width]}>
                <TouchableOpacity 
                    onPress={pressLogin}>
                        <View style={[styles.button,styles.login]} > 
                            <Text>
                                {"S'identifier"}
                            </Text>
                        </View>
                    </TouchableOpacity>
                </View>
            </View>
            );
    }

    
};

Login.protoTypes = {
    setToken:PropTypes.func.isRequired
}

const styles = StyleSheet.create({
    container: {
        flex: 1,
        flexDirection:"column", 
        backgroundColor: '#fff',
        alignItems: 'center',
        height:"100%",
    },
    containerLogo:{
        marginTop:"25%",
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
        height:"10%",
    },
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
    login:{
        backgroundColor:"#beeaff",
    },
    error:{
        color:'red',
    },
    input:{
        margin:18,
        height:40,
        color:'black',
        borderColor:"black",
        borderBottomWidth:StyleSheet.hairlineWidth,
    },
    forgot:{
        color:'black',
        fontSize:12,
    },
    logo:{
        margin:20,
        width:64,
        height:64,
    },
    tinylogo:{
        height:50,
        width:50,
    },
})

export default Login;