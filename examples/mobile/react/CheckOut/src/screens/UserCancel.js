/**
 * Sample React Native App
 * https://github.com/facebook/react-native
 *
 * @format
 * @flow
 */

import React, {Component} from 'react';
import {Platform, Text,View, StatusBar} from 'react-native';
import styles from '../style/styles'
const IS_IOS = Platform.OS === 'ios';
type Props = {};

export default class UserCancel extends Component<Props> {
    constructor(props){
        super(props);
    }

    _renderView(){
        return <View style={{flex:1}}>
            <View style={{flex:1}}>
                <View style={{flex: 1,width:'100%', backgroundColor:'#4FC3F7',justifyContent:'center', alignItem:'center'}}>
                    <Text style={styles.headingTitle}>User Cancel</Text>
                </View>
            </View>
        </View>
    }

    render() {
        let color = IS_IOS ? "#03A9F4" : "#039BE5";
        return (
            <View style={styles.container}>
                <StatusBar
                    backgroundColor= {color}
                    barStyle="light-content"
                />
                {this._renderView()}
            </View>
        );}
}
