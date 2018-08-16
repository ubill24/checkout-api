import React from 'react';
import { createStackNavigator, createBottomTabNavigator } from 'react-navigation';
import Main from './src/screens/Main';
import Success from './src/screens/Success';
import Error from './src/screens/Error';
import UserCancel from './src/screens/UserCancel';
const HomeStack = createStackNavigator({
    Main: {
        screen: Main,
        navigationOptions: () => ({
            headerStyle: {
                backgroundColor: '#03A9F4',
                borderBottomWidth: 0,
            },
            title:'Confirm Order',
            headerTitleStyle: {
                color: 'white',
            },
            headerBackTitleStyle: {
                color: '#ffffff',
            },
            headerTintColor: '#ffffff',
        }),
    },
    SuccessStack: {
      screen: Success,
      navigationOptions: () => ({
            headerStyle: {
                backgroundColor: '#03A9F4',
                borderBottomWidth: 0,
            },
            title:'Check Out Success',
            headerTitleStyle: {
                color: 'white',
            },
            headerBackTitleStyle: {
                color: '#ffffff',
            },
            headerTintColor: '#ffffff',
        }),
    },
    ErrorStack: {
        screen: Error,
        navigationOptions: () => ({
            headerStyle: {
                backgroundColor: '#03A9F4',
                borderBottomWidth: 0,
            },
            title:'Error',
            headerTitleStyle: {
                color: 'white',
            },
            headerBackTitleStyle: {
                color: '#ffffff',
            },
            headerTintColor: '#ffffff',
        }),
    },
    UserCancelStack: {
        screen: UserCancel,
        navigationOptions: () => ({
            headerStyle: {
                backgroundColor: '#03A9F4',
                borderBottomWidth: 0,
            },
            title:'User Cancel',
            headerTitleStyle: {
                color: 'white',
            },
            headerBackTitleStyle: {
                color: '#ffffff',
            },
            headerTintColor: '#ffffff',
        }),
    }
});

export default HomeStack;
