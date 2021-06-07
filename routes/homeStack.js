import {  createAppContainer } from 'react-navigation';
import { createStackNavigator } from 'react-navigation-stack';
import Login from "../app/screens/Login";
import Accueil from "../app/screens/Accueil";
import Test from "../app/screens/Test";
import Quiz from "../app/screens/Quiz";

//pile des screens
const screens = {
    Login:{
        screen: Login,
    },
    Accueil:{
        screen:Accueil,
    },
    Test:{
        screen:Test,
    },
    Quiz:{
        screen:Quiz,
    },
};

const HomeStack = createStackNavigator(screens,{
    headerMode: 'none',
  });

export default createAppContainer(HomeStack);