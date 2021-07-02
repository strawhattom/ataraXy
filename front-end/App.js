import React from 'react';

//Désactive la box de warning
import { Alert, LogBox } from 'react-native';
LogBox.ignoreLogs(['It']);
LogBox.ignoreAllLogs();//Ignore all log notifications

import { NavigationContainer } from '@react-navigation/native';
import { createStackNavigator } from '@react-navigation/stack';
import * as SecureStore from 'expo-secure-store';

//import Navigator from "./routes/homeStack";
import Login from "./app/screens/Login";
import Accueil from "./app/screens/Accueil";
import Quiz from "./app/screens/Quiz";

//Contextes
import {AuthContext} from "./app/context/authContext";
import {QuizContext, useQuiz} from './app/context/quizContext';

import {host} from './config/host';

const Stack = createStackNavigator();

async function setToken(key,value){
  await SecureStore.setItemAsync(key,value);
}

export default function App() {

  const [error,setError] = React.useState('');
  const [isLoading,setLoading] = React.useState(false);

  const [state, dispatch] = React.useReducer(
    (prevState, action) => {
      switch (action.type) {
        case 'RESTORE_TOKEN':
          return {
            ...prevState,
            userToken: action.token,
            isLoading: false,
          };
        case 'SIGN_IN':
  
          return {
            ...prevState,
            isSignout: false,
            userToken: action.token,
          };
        case 'SIGN_OUT':
          return {
            ...prevState,
            isSignout: true,
            userToken: null,
          };
      }
    },
    {
      isLoading: true,
      isSignout: false,
      userToken: null,
    }
  );

  React.useEffect(() => {
    // Fetch the token from storage then navigate to our appropriate place
    const bootstrapAsync = async () => {
      let userToken;
      try {
        userToken = await SecureStore.getItemAsync('token');
      } catch (e) {
        // Restoring token failed
        console.log("Token restoring failed : " + e);
      }
      dispatch({ type: 'RESTORE_TOKEN', token: userToken });
    };

    bootstrapAsync();
  }, []);

  const authContext = React.useMemo(
    () => ({
      signIn: async ({id,pw}) => {
        
        fetch('http://'+host+':3000/auth',{
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

              //Affiche un chargement
                setLoading(true);
                
                if (responseJSON !== false){

                  //Stock le token dans un stockage
                  setToken('token',responseJSON);
                  console.log("Connexion");
                  dispatch({ type: 'SIGN_IN', token: responseJSON });
                } else {
                  setError("Une erreur est survenue, l'identifiant et/ou le mot de passe sont incorrects");
                }
                
            }).catch((error)=>{
                console.log("Erreur : "+ error);
        });

        
      },
      signOut: async (alert = true) => {
        if (alert){
          Alert.alert(
            'Confirmation pour la déconnexion',
            'Vous êtes sur le point de vous déconnecter, êtes-vous sûr ?',
            [
              {
                text:'Annuler',
                onPress: () => {
                  return;
                },
                style: "cancel"
              },
              {
                text:'Confimer',
                onPress: async () => {
                  console.log("Deconnexion");
                  await SecureStore.deleteItemAsync('token');
                  //sessionStorage.removeItem('token');
                  setError('');
                  dispatch({ type: 'SIGN_OUT' })
                }
              }
            ]
          )
        } else {
          console.log("Deconnexion");
          await SecureStore.deleteItemAsync('token');
          //sessionStorage.removeItem('token');
          setError('');
          dispatch({ type: 'SIGN_OUT' })
        }
      },
      setLoading: (loading) => {
        setLoading(loading);
      },
      error,
      isLoading,
    }),
    [error,isLoading]
  );
  
  return(
    <>
      <AuthContext.Provider value={authContext}>
        <QuizContext.Provider value={useQuiz()}>
          <NavigationContainer>
            <Stack.Navigator
              screenOptions={{
              headerShown: false
            }}>
              {state.userToken == null ? (
                <Stack.Screen
                  name="Login"
                  component={Login}
                  options={{
                    title: 'Sign in',
                    // When logging out, a pop animation feels intuitive
                    // You can remove this if you want the default 'push' animation
                    animationTypeForReplace: state.isSignout ? 'pop' : 'push',
                  }}
                />
              ) : (
                <>
                  <Stack.Screen
                    name="Accueil"
                    component={Accueil}
                  />
                  <Stack.Screen
                    name="Quiz"
                    component={Quiz}
                  />
                </>
              )}
            </Stack.Navigator>
          </NavigationContainer>
        </QuizContext.Provider>
      </AuthContext.Provider>
    </>
    )
};