/**
 * Sample React Native App
 * https://github.com/facebook/react-native
 *
 * @format
 * @flow
 */

import React, {Component} from 'react';
import {
    Platform,
    TouchableWithoutFeedback,
    Keyboard,
    Text,
    View,
    TouchableOpacity,
    Alert,
    StatusBar,
    TextInput
} from 'react-native';
import { WebViewModal, LabelInput } from '../common/index'
import styles from '../style/styles'
import { CheckBox } from 'react-native-elements';
import KeyboardSpacer from 'react-native-keyboard-spacer';
import Icons from 'react-native-vector-icons/Ionicons';
const IS_IOS = Platform.OS === 'ios';


const TOKEN = 'a8024ffe355342ef890fcebed5ad3009';
const DATA = {
    "description": "Extra note",
    "currency": "USD",
    "amount": 1000,
    "reference_id": "YOURA869718501",
    "webview": true
};
const API_URL = 'https://checkoutapi-demo.bill24.net/transaction/init';

export default class Main extends React.Component {
    constructor(props){
        super(props);
        this._handleCheckOut = this._handleCheckOut.bind(this);
        this._handleOnResponseCheckOut = this._handleOnResponseCheckOut.bind(this);
        this._handleOnCallBack = this._handleOnCallBack.bind(this);
        this.state = {
            url: '',
            isModalWebViewVisible: false,
            token: TOKEN,
            data: DATA
        }
    }

    async _handleCheckOut(){
        const { token , data} = this.state;
        try {
            let response = await fetch(API_URL,
                {
                    method: 'POST',
                    headers:{
                        'accept': 'application/json',
                        'Content-Type': 'application/json',
                        'token': token,
                    },
                    body: JSON.stringify(data)
                });
            if (response.status < 300){
                let rest = await response.json();
                this._handleOnResponseCheckOut(rest);
            }else if(response.status > 300)
                Alert.alert(
                    'Error',
                    'something went wrong',
                    [
                        {text: 'OK', onPress: () =>{}},
                    ],
                    {cancelable: false}
                )
        } catch (error) {
            console.log("cathc",error)
        }
    }

    _handleOnResponseCheckOut(res){
        this.setState({
            url: res.data.payment_url,
            isModalWebViewVisible: true,
        })
    };

    _handleOnCallBack(data){
        console.log("On call back.......");
        this.setState({
          isModalWebViewVisible: false
        });
        let dataJoson = JSON.parse(data.nativeEvent.data);
        console.log(" dataJoson ===> ",dataJoson);
        if (dataJoson.code === "SUCCESS") {
            this.props.navigation.navigate("SuccessStack",{data: dataJoson.data}) 
        }else if (dataJoson.code === "400") {
            this.props.navigation.navigate("ErrorStack")
        }else if (dataJoson.code === "499"){
            this.props.navigation.navigate("UserCancelStack")
        } else {
            this.props.navigation.navigate("Main",)
        }
       
    }

    _handleOnMessage(data){
        let val = JSON.parse(data);
        console.log("_handleOnMessage val ", val.message)
        this.setState({
            url: val.message
        })
    }

    _handleOnChangeText(key, val,){
        let newData = this.state.data;
            newData[key] = val
        this.setState({
            data: newData
        })
    }

    _handleOnChangeTextToken(key, val,){
        this.setState({
            token: val
        })
    }
    _renderView(){
        const { data, token } = this.state;
              return <View style={{flex:1}}>
                  <View style={{flex:1}}>
                      <View style={{flex: 1,width:'100%', backgroundColor:'#4FC3F7',justifyContent:'center', alignItem:'center'}}>
                                <View style={styles.subTitle}>
                                    <Text style={styles.subTextTitle}>Danny Baldwin</Text>
                                    <Icons
                                        name = 'md-arrow-back'
                                        backgroundColor = 'transparent'
                                        color = '#fff'
                                        size = {28}
                                    />
                                    <Text style={styles.subTextTitle}>04-08-2018</Text>
                                </View>
                                <Text style={styles.headingTitle}>502796999</Text>
                      </View>
                      <View style={{flex:2, width:'100%'}}>

                            <View style={styles.listSingleInput}>
                                <LabelInput text='API Token'/>
                                <View style={styles.inlineText}>
                                    <View style={{flexDirection:'row'}}>
                                        <TextInput
                                            ref={'apitoken'}
                                            selectTextOnFocus
                                            style={styles.inputTextStyle}
                                            autoFocus={false}
                                            autoCorrect = {false}
                                            placeholder='Token'
                                            value={token}
                                            onChangeText={(text) => this._handleOnChangeTextToken(text)}
                                        />
                                    </View>
                                </View>
                            </View>

                            <View style={styles.listSingleInput}>
                                <LabelInput text='Amount'/>
                                <View style={styles.inlineText}>
                                    <View style={{flexDirection:'row'}}>
                                        <TextInput
                                            ref={'amount'}
                                            selectTextOnFocus
                                            style={styles.inputTextStyle}
                                            keyboardType = "numeric"
                                            autoFocus={false}
                                            autoCorrect = {false}
                                            placeholder={String(data.amount)}
                                            value={String(data.amount)}
                                            onChangeText={(text) => this._handleOnChangeText('amount',text)}
                                        />

                                    </View>
                                </View>
                            </View>

                            <View style={styles.listSingleItems}>
                                <LabelInput text='Currency'/>
                                <View style={styles.inlineTexts}>
                                    <View style={{flexDirection:'row'}}>
                                        <CheckBox
                                            title = 'USD'
                                            onPress ={(text) => this._handleOnChangeText('currency','USD')}
                                            checked = {data.currency === 'USD' ? true : false}
                                        />
                                        <CheckBox
                                            title = 'KHR'
                                            onPress ={(text) => this._handleOnChangeText('currency','KHR')}
                                            checked = {data.currency === 'KHR' ? true : false}
                                        />
                                    </View>
                                </View>
                            </View>

                            <View style={styles.listSingleInput}>
                                <LabelInput text='Description'/>
                                <View style={styles.inlineText}>
                                    <View style={{flexDirection:'row'}}>
                                        <TextInput
                                            ref={'des'}
                                            selectTextOnFocus
                                            style={styles.inputTextStyle}
                                            autoFocus={false}
                                            autoCorrect = {false}
                                            placeholder={data.description}
                                            value={data.description}
                                            onChangeText={(text) => this._handleOnChangeText('description',text)}
                                        />
                                    </View>
                                </View>
                            </View>

                            <View style={styles.listSingleItem}>
                                <TouchableOpacity style={{
                                    backgroundColor:'#03A9F4',
                                     justifyContent:'center',
                                      alignItem:'center',
                                      paddingTop: 9,
                                      paddingBottom:9,
                                      borderTopColor:'red',
                                      borderRadius:10,
                                      width:'90%',
                                      alighSelf:'center'
                                    }} onPress={this._handleCheckOut}>
                                    <Text style={{textAlign:'center', color:'#fff'}}> Check Out</Text>
                                </TouchableOpacity>
                            </View>
                      </View>
                      <KeyboardSpacer/>
                  </View>
              </View>
    }

    render() {
        let color = IS_IOS ? "#03A9F4" : "#039BE5";
        return (
            <TouchableWithoutFeedback onPress={()=>{Keyboard.dismiss()}}>
                <View style={styles.container}>
                  <StatusBar
                     backgroundColor= {color}
                     barStyle="light-content"
                   />
                  {this._renderView()}
                  <WebViewModal
                        url={this.state.url}
                        isVisible={this.state.isModalWebViewVisible}
                        closeModal={()=>this.setState({isModalWebViewVisible: false})}
                        titleText='WebView'
                        onMessage={(event)=>this._handleOnCallBack(event)}
                        onError={()=>{
                            console.log("error...........")
                        }}
                        onNavigation={(e)=>{
                            console.log("eeeeee",e)
                        }}
                    />
                </View>
            </TouchableWithoutFeedback>
        );
    }
}
