import {  createAppContainer } from 'react-navigation';
import { createStackNavigator } from 'react-navigation-stack';
import Login from "./Login";
import Accueil from "./Accueil";
import Test from "./Test";
import Quiz from "./Quiz";

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