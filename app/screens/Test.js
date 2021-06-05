import React from 'react';
import { StyleSheet, Text, TextInput, View, Image, TouchableOpacity, KeyboardAvoidingView} from 'react-native';

function Test(props) {

    const getUsers = () =>{
        fetch('http://192.168.8.11:3000/users')
            .then(response => response.json())
            .then(users => {return users})
            .catch((error) => {
                console.error(error);
            })
    }


    return (
    <KeyboardAvoidingView 
    behavior={Platform.OS === "ios" ? "padding" : "height"}
    style={styles.container}>
        <View style={styles.containerLogo}>
            <Image 
            fadeDuration={1500}
            style={styles.tinylogo}
            source={require('../assets/icon.png')
            }/>
        </View>
        
        <View style={styles.containerError}>
            <Text>{"Texte d'erreur"}</Text>
        </View>
    
        <View style={[styles.containerButton,styles.width]}>
            <TouchableOpacity onPress={getUsers}>
                <View style={[styles.button,styles.login]} > 
                    <Text>
                        {"Print data"}
                    </Text>
                </View>
            </TouchableOpacity>
        </View>   
        <View>
            <Text>
                {getUsers}
            </Text>
        </View>
    </KeyboardAvoidingView>
    );
};

const styles = StyleSheet.create({
    container: {
        flex: 1,
        flexDirection:"column", 
        backgroundColor: '#fff',
        alignItems: 'center',
        height:"100%",
    },
    containerLogo:{
        alignItems: 'center',
        justifyContent:'center',
        width:"100%",
        height:"13%",
    },
    containerError:{
        alignItems: 'center',
        justifyContent:'center',
        height:"10%",
        width:"100%",
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

export default Test;