import React,{useState} from 'react';
import 'react-native-gesture-handler';
import { NavigationContainer } from '@react-navigation/native';
import { createStackNavigator } from '@react-navigation/stack';
import * as SecureStore from 'expo-secure-store';

//import Navigator from "./routes/homeStack";
import Login from "./app/screens/Login";
import Accueil from "./app/screens/Accueil";
import Test from "./app/screens/Test";
import Quiz from "./app/screens/Quiz";
import QuizText from "./app/screens/QuizText";
import {AuthContext} from "./app/components/context";
import {localhost} from './config/data';

const Stack = createStackNavigator();


export default function App({navigation}) {

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
          
          sessionStorage.removeItem('token');
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
        //userToken = await SecureStore.getItemAsync('token');
        userToken = sessionStorage.getItem('token');
      } catch (e) {
        // Restoring token failed
        console.log("Token restoring failed : " + e);
      }

      // After restoring token, we may need to validate it in production apps
      
      // This will switch to the App screen or Auth screen and this loading
      // screen will be unmounted and thrown away.
      dispatch({ type: 'RESTORE_TOKEN', token: userToken });
    };

    bootstrapAsync();
  }, []);

  const authContext = React.useMemo(
    () => ({
      signIn: async ({id,pw}) => {
        // In a production app, we need to send some data (usually username, password) to server and get a token
        // We will also need to handle errors if sign in failed
        // After getting token, we need to persist the token using `SecureStore`
        console.log("Connexion");
        fetch('http://'+localhost+':3000/auth',{
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
                  //SecureStore.setItemAsync('token',responseJSON)
                  //.catch(err => console.log("Error storing token : " + err));
                  sessionStorage.setItem('token',responseJSON)
                  dispatch({ type: 'SIGN_IN', token: responseJSON });
                } else {
                  //setError("Une erreur est survenue, l'identifiant et/ou le mot de passe sont incorrects");
                  console.log("Une erreur est survenue, l'identifiant et/ou le mot de passe sont incorrects");
                }
            }).catch((error)=>{
                console.log("Erreur : "+ error);
        });

        
      },
      signOut: () => {
        console.log("Deconnexion");
        dispatch({ type: 'SIGN_OUT' })
      },
    }),
    []
  );
  
  return(
    <>
      <AuthContext.Provider value={authContext}>
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
                  name="Test"
                  component={Test}
                />
                <Stack.Screen
                  name="Quiz"
                  component={Quiz}
                />
                <Stack.Screen
                  name="QuizText"
                  component={QuizText}
                />
              </>
            )}
            
              
          </Stack.Navigator>
        </NavigationContainer>
      </AuthContext.Provider>
    </>
    )
};