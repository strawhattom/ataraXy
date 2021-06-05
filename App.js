import React,{useState} from 'react';
import 'react-native-gesture-handler';
import { NavigationContainer } from '@react-navigation/native';
import { createStackNavigator } from '@react-navigation/stack';


import Login from "./app/screens/Login";
import Accueil from "./app/screens/Accueil";
import Test from "./app/screens/Test";
import Quiz from "./app/screens/Quiz";

const Stack = createStackNavigator();

export default class App extends React.Component {
  

  render(){
    return (
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
    );
  }
};