import React,{useState} from 'react';
import 'react-native-gesture-handler';
import { NavigationContainer } from '@react-navigation/native';
import { createStackNavigator } from '@react-navigation/stack';

import Navigator from "./routes/homeStack";
import Login from "./app/screens/Login";
import Accueil from "./app/screens/Accueil";
import Test from "./app/screens/Test";
import Quiz from "./app/screens/Quiz";

//const Stack = createStackNavigator();

/*
function setToken(userToken){
  sessionStorage.setItem('token', JSON.stringify(userToken));
}
*/
function getToken(){
  const tokenString = sessionStorage.getItem('token');
  const userToken = JSON.parse(tokenString);
  return userToken?.token
}


export default function App() {

    /*
    const token = getToken();
    
    if (!token){
      return(<NavigationContainer>
        <Stack.Navigator>
        <Stack.Screen
            name="Login"
            component={Login}
          />
          <Stack.Screen
            name="Accueil"
            component={Accueil}
          />
          <Stack.Screen
            name="Test"
            component={Test}
          />
          <Stack.Screen
            name="Quiz"
            component={Quiz}
          />
        </Stack.Navigator>
      </NavigationContainer>)
    }
    */
    return (
      <Navigator/>
      /*
      <NavigationContainer>
          <Stack.Navigator>
          <Stack.Screen
              name="Login"
              component={Login}
            />
            <Stack.Screen
              name="Accueil"
              component={Accueil}
            />
            <Stack.Screen
              name="Test"
              component={Test}
            />
            <Stack.Screen
              name="Quiz"
              component={Quiz}
            />
          </Stack.Navigator>
        </NavigationContainer>
      */
    );
};