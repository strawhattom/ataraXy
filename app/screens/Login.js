import React from 'react';
import PropTypes from 'prop-types';
import jwt_decode from 'jwt-decode';
import { ActivityIndicator, StyleSheet, Text, TextInput, View, Image, TouchableOpacity} from 'react-native';
import {AuthContext} from "../context/authContext";

function Login() {
    
    const [id,onChangeId] = React.useState('');
    const [pw,onChangePw] = React.useState('');
    const { signIn, error } = React.useContext(AuthContext);
    const [isLoading, setLoading] = React.useState(true);

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
                    <Text style={[styles.error,styles.width]}>
                        {error}
                    </Text>
                </View>
                <View style={[styles.containerInput,styles.width]}>
                    <TextInput 
                    style={styles.input}
                    onChangeText={onChangeId}
                    value={id}
                    placeholder={"Identifiant"}
                    placeholderTextColor={"lightgray"}
                    clearButtonMode='always'
                    />
        
                    <TextInput
                    style={styles.input}
                    onChangeText={onChangePw}
                    value={pw}
                    placeholder={"Mot de passe"}
                    placeholderTextColor={"lightgray"}
                    secureTextEntry={true}
                    maxLength={32}
                    clearButtonMode='always'
                    />

                </View>
                <View style={[styles.containerButton,styles.width]}>
                    <TouchableOpacity 
                    onPress={() => signIn({id,pw})}>
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
//}

    
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
        fontWeight:'bold',
        textAlign:'center',
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